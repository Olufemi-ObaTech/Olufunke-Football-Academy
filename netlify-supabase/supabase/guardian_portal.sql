-- ============================================================
-- GUARDIAN PORTAL — DATABASE SCHEMA
-- Run after the main schema.sql
-- ============================================================

-- 1. Add guardian columns to profiles table
ALTER TABLE profiles
  ADD COLUMN IF NOT EXISTS phone_encrypted  TEXT,
  ADD COLUMN IF NOT EXISTS address_encrypted TEXT,
  ADD COLUMN IF NOT EXISTS relationship     TEXT;

-- Update role constraint to include coach and guardian
ALTER TABLE profiles DROP CONSTRAINT IF EXISTS profiles_role_check;
ALTER TABLE profiles ADD CONSTRAINT profiles_role_check
  CHECK (role IN ('admin', 'coach', 'player', 'guardian'));

-- 2. Guardian → Child linking table
CREATE TABLE IF NOT EXISTS guardian_children (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  guardian_id  UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  player_id    UUID REFERENCES auth.users(id) ON DELETE SET NULL,
  player_name  TEXT NOT NULL,
  player_age   INTEGER,
  player_position TEXT,
  player_age_group TEXT,
  linked_at    TIMESTAMPTZ DEFAULT now()
);

-- 3. Guardian invoices / financials
CREATE TABLE IF NOT EXISTS guardian_invoices (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  guardian_id  UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  player_name  TEXT,
  description  TEXT NOT NULL,
  amount       NUMERIC(10,2) NOT NULL,
  due_date     DATE,
  paid_at      TIMESTAMPTZ,
  status       TEXT DEFAULT 'unpaid' CHECK (status IN ('unpaid','paid','overdue','waived')),
  pdf_url      TEXT,
  created_at   TIMESTAMPTZ DEFAULT now()
);

-- 4. Support tickets (Guardian → Admin only)
CREATE TABLE IF NOT EXISTS guardian_tickets (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  guardian_id  UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  type         TEXT CHECK (type IN ('billing','absence','general','safeguarding')),
  subject      TEXT NOT NULL,
  message      TEXT NOT NULL,
  status       TEXT DEFAULT 'open' CHECK (status IN ('open','in_progress','resolved','closed')),
  admin_reply  TEXT,
  created_at   TIMESTAMPTZ DEFAULT now(),
  updated_at   TIMESTAMPTZ DEFAULT now()
);

-- 5. Coach call requests
CREATE TABLE IF NOT EXISTS guardian_call_requests (
  id            UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  guardian_id   UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  status        TEXT DEFAULT 'pending' CHECK (status IN ('pending','scheduled','completed','declined')),
  preferred_time TEXT,
  scheduled_at  TIMESTAMPTZ,
  admin_notes   TEXT,
  created_at    TIMESTAMPTZ DEFAULT now()
);

-- 6. Broadcast announcements (Admin/Coach → Guardians/Players)
CREATE TABLE IF NOT EXISTS announcements (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  author_id    UUID REFERENCES auth.users(id),
  author_role  TEXT,
  title        TEXT NOT NULL,
  body         TEXT NOT NULL,
  target_roles TEXT[] DEFAULT ARRAY['player','guardian','coach'],
  is_pinned    BOOLEAN DEFAULT false,
  created_at   TIMESTAMPTZ DEFAULT now()
);

-- 7. Consent form version history
CREATE TABLE IF NOT EXISTS consent_history (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  guardian_id  UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  form_version TEXT DEFAULT '1.0',
  signed_at    TIMESTAMPTZ DEFAULT now(),
  pdf_url      TEXT,
  is_current   BOOLEAN DEFAULT true,
  expires_at   TIMESTAMPTZ
);

-- 8. Audit logs (Admin actions only)
CREATE TABLE IF NOT EXISTS audit_logs (
  id          UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  admin_id    UUID REFERENCES auth.users(id),
  action      TEXT NOT NULL,
  target_type TEXT,
  target_id   TEXT,
  metadata    JSONB,
  created_at  TIMESTAMPTZ DEFAULT now()
);

-- 9. Add is_guardian_only flag to courses table
ALTER TABLE courses
  ADD COLUMN IF NOT EXISTS is_guardian_only BOOLEAN DEFAULT false;

-- ── ROW LEVEL SECURITY ──────────────────────────────────────────

ALTER TABLE guardian_children      ENABLE ROW LEVEL SECURITY;
ALTER TABLE guardian_invoices      ENABLE ROW LEVEL SECURITY;
ALTER TABLE guardian_tickets       ENABLE ROW LEVEL SECURITY;
ALTER TABLE guardian_call_requests ENABLE ROW LEVEL SECURITY;
ALTER TABLE announcements          ENABLE ROW LEVEL SECURITY;
ALTER TABLE consent_history        ENABLE ROW LEVEL SECURITY;
ALTER TABLE audit_logs             ENABLE ROW LEVEL SECURITY;

-- Guardians see only their own children
CREATE POLICY "guardian_children_own" ON guardian_children
  FOR ALL USING (guardian_id = auth.uid());

-- Guardians see only their own invoices
CREATE POLICY "guardian_invoices_own" ON guardian_invoices
  FOR ALL USING (guardian_id = auth.uid());

-- Guardians see only their own tickets
CREATE POLICY "guardian_tickets_own" ON guardian_tickets
  FOR ALL USING (guardian_id = auth.uid());

-- Guardians see only their own call requests
CREATE POLICY "guardian_calls_own" ON guardian_call_requests
  FOR ALL USING (guardian_id = auth.uid());

-- All authenticated users can read announcements targeted at their role
CREATE POLICY "announcements_read" ON announcements
  FOR SELECT USING (true);

-- Guardians see only their own consent history
CREATE POLICY "consent_history_own" ON consent_history
  FOR ALL USING (guardian_id = auth.uid());

-- Only admin can read audit logs
CREATE POLICY "audit_logs_admin_only" ON audit_logs
  FOR SELECT USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role = 'admin')
  );

-- ── INDEXES ────────────────────────────────────────────────────

CREATE INDEX IF NOT EXISTS idx_guardian_children_guardian ON guardian_children(guardian_id);
CREATE INDEX IF NOT EXISTS idx_guardian_invoices_guardian ON guardian_invoices(guardian_id);
CREATE INDEX IF NOT EXISTS idx_guardian_tickets_guardian  ON guardian_tickets(guardian_id);
CREATE INDEX IF NOT EXISTS idx_announcements_created      ON announcements(created_at DESC);
CREATE INDEX IF NOT EXISTS idx_courses_guardian_only      ON courses(is_guardian_only);
CREATE INDEX IF NOT EXISTS idx_audit_logs_admin           ON audit_logs(admin_id, created_at DESC);
