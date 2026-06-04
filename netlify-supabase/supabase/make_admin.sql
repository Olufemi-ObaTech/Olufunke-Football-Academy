-- ============================================================
-- OFA Academy — Make User an Admin
-- Run in: Supabase Dashboard → SQL Editor → New query → Run
-- ============================================================
-- IMPORTANT: First register on the website at /register with
-- the email: Olufunkefootballacademy@gmail.com
-- Then come back here and run this SQL to grant admin access.
-- ============================================================

-- This single statement finds the user by email and sets admin role.
-- It will succeed silently if the email does not exist yet.

INSERT INTO public.profiles (id, full_name, role, status)
SELECT
  u.id,
  COALESCE(u.raw_user_meta_data->>'full_name', 'Admin'),
  'admin',
  'approved'
FROM auth.users u
WHERE u.email = 'Olufunkefootballacademy@gmail.com'
ON CONFLICT (id) DO UPDATE
  SET role   = 'admin',
      status = 'approved',
      updated_at = NOW();

-- Verify: shows all admin users
SELECT
  u.email,
  p.full_name,
  p.role,
  p.status,
  p.created_at
FROM public.profiles p
JOIN auth.users u ON p.id = u.id
WHERE p.role = 'admin';
