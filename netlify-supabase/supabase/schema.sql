-- ============================================================
-- OFA Academy — Supabase Schema  v3  (clean, all errors fixed)
-- Run in: Supabase Dashboard → SQL Editor → New query → Run
-- ============================================================

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- ── 1. PROFILES (extends auth.users) ─────────────────────────
CREATE TABLE IF NOT EXISTS public.profiles (
  id          UUID PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
  full_name   TEXT,
  avatar_url  TEXT,
  phone       TEXT,
  position    TEXT,
  age         INT,
  age_group   TEXT,
  nationality TEXT,
  role        TEXT NOT NULL DEFAULT 'player' CHECK (role IN ('player','admin')),
  status      TEXT NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','approved','rejected')),
  created_at  TIMESTAMPTZ DEFAULT NOW(),
  updated_at  TIMESTAMPTZ DEFAULT NOW()
);

-- Auto-create profile on sign-up
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS TRIGGER AS $$
BEGIN
  INSERT INTO public.profiles (
    id, full_name, avatar_url, phone, position, age, age_group, nationality
  ) VALUES (
    NEW.id,
    NEW.raw_user_meta_data->>'full_name',
    NEW.raw_user_meta_data->>'avatar_url',
    NEW.raw_user_meta_data->>'phone',
    NEW.raw_user_meta_data->>'position',
    (NEW.raw_user_meta_data->>'age')::INT,
    NEW.raw_user_meta_data->>'age_group',
    NEW.raw_user_meta_data->>'nationality'
  )
  ON CONFLICT (id) DO NOTHING;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users;
CREATE TRIGGER on_auth_user_created
  AFTER INSERT ON auth.users
  FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();

-- ── 2. PLAYERS (spotlight — BIGINT primary key) ───────────────
CREATE TABLE IF NOT EXISTS public.players (
  id          BIGSERIAL PRIMARY KEY,
  name        TEXT NOT NULL,
  position    TEXT NOT NULL,
  age         INT,
  goals       INT DEFAULT 0,
  assists     INT DEFAULT 0,
  matches     INT DEFAULT 0,
  quote       TEXT,
  image_path  TEXT DEFAULT 'images/OFA New Logo.jpg',
  created_at  TIMESTAMPTZ DEFAULT NOW(),
  updated_at  TIMESTAMPTZ DEFAULT NOW()
);

-- ── 3. POSTS (news / reports / media) ────────────────────────
CREATE TABLE IF NOT EXISTS public.posts (
  id          BIGSERIAL PRIMARY KEY,
  title       TEXT NOT NULL,
  content     TEXT NOT NULL,
  image_path  TEXT,
  type        TEXT NOT NULL CHECK (type IN ('latest','report','media')),
  meta_link   TEXT,
  created_at  TIMESTAMPTZ DEFAULT NOW(),
  updated_at  TIMESTAMPTZ DEFAULT NOW()
);

-- ── 4. MATCH RESULTS ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.match_results (
  id            BIGSERIAL PRIMARY KEY,
  match_date    DATE NOT NULL,
  opponent      TEXT NOT NULL,
  competition   TEXT,
  result_badge  TEXT NOT NULL,
  status_color  TEXT DEFAULT 'success',
  week_label    TEXT,
  venue         TEXT,
  kick_off_time TIME,
  notes         TEXT,
  created_at    TIMESTAMPTZ DEFAULT NOW(),
  updated_at    TIMESTAMPTZ DEFAULT NOW()
);

-- ── 5. NEXT FIXTURES ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.next_fixtures (
  id            BIGSERIAL PRIMARY KEY,
  week_label    TEXT,
  home_team     TEXT NOT NULL,
  away_team     TEXT NOT NULL,
  competition   TEXT,
  fixture_date  DATE NOT NULL,
  kick_off_time TIME,
  venue         TEXT,
  is_active     BOOLEAN DEFAULT TRUE,
  created_at    TIMESTAMPTZ DEFAULT NOW(),
  updated_at    TIMESTAMPTZ DEFAULT NOW()
);

-- ── 6. STANDINGS ──────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.standings (
  id               BIGSERIAL PRIMARY KEY,
  rank             INT NOT NULL,
  club_name        TEXT NOT NULL,
  played           INT DEFAULT 0,
  won              INT DEFAULT 0,
  drawn            INT DEFAULT 0,
  lost             INT DEFAULT 0,
  goals_for        INT DEFAULT 0,
  goals_against    INT DEFAULT 0,
  points           INT DEFAULT 0,
  is_featured_club BOOLEAN DEFAULT FALSE,
  created_at       TIMESTAMPTZ DEFAULT NOW(),
  updated_at       TIMESTAMPTZ DEFAULT NOW()
);

-- ── 7. MANAGEMENT TEAM ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.management_team (
  id         BIGSERIAL PRIMARY KEY,
  name       TEXT NOT NULL,
  role       TEXT NOT NULL,
  email      TEXT,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMPTZ DEFAULT NOW(),
  updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- ── 8. PRODUCTS ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.products (
  id          BIGSERIAL PRIMARY KEY,
  name        TEXT NOT NULL,
  description TEXT,
  price       DECIMAL(10,2) NOT NULL DEFAULT 0,
  image_path  TEXT,
  category    TEXT DEFAULT 'merchandise',
  available   BOOLEAN DEFAULT TRUE,
  created_at  TIMESTAMPTZ DEFAULT NOW(),
  updated_at  TIMESTAMPTZ DEFAULT NOW()
);

-- ── 9. BOOKING PACKAGES ───────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.booking_packages (
  id          BIGSERIAL PRIMARY KEY,
  name        TEXT NOT NULL,
  description TEXT,
  price       DECIMAL(10,2) NOT NULL DEFAULT 0,
  duration    TEXT,
  group_size  TEXT,
  is_active   BOOLEAN DEFAULT TRUE,
  created_at  TIMESTAMPTZ DEFAULT NOW(),
  updated_at  TIMESTAMPTZ DEFAULT NOW()
);

-- ── 10. COURSES (BIGINT primary key) ──────────────────────────
CREATE TABLE IF NOT EXISTS public.courses (
  id              BIGSERIAL PRIMARY KEY,
  title           TEXT NOT NULL,
  description     TEXT,
  image_path      TEXT,
  category        TEXT DEFAULT 'technical',
  target_audience TEXT DEFAULT 'both',
  cta_label       TEXT DEFAULT 'Start Learning',
  is_published    BOOLEAN DEFAULT TRUE,
  created_at      TIMESTAMPTZ DEFAULT NOW(),
  updated_at      TIMESTAMPTZ DEFAULT NOW()
);

-- ── 11. LESSONS (BIGINT FK → courses.id) ─────────────────────
CREATE TABLE IF NOT EXISTS public.lessons (
  id              BIGSERIAL PRIMARY KEY,
  course_id       BIGINT NOT NULL REFERENCES public.courses(id) ON DELETE CASCADE,
  title           TEXT NOT NULL,
  content         TEXT,
  icon            TEXT DEFAULT 'bi-book',
  duration        TEXT DEFAULT '10 min',
  difficulty      TEXT DEFAULT 'beginner',
  target_audience TEXT DEFAULT 'both',
  video_url       TEXT,
  order_index     INT DEFAULT 0,
  created_at      TIMESTAMPTZ DEFAULT NOW(),
  updated_at      TIMESTAMPTZ DEFAULT NOW()
);

-- ── 12. PLAYER PROGRESS (BIGINT FK → courses.id) ─────────────
CREATE TABLE IF NOT EXISTS public.player_progress (
  id               BIGSERIAL PRIMARY KEY,
  user_id          UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  course_id        BIGINT NOT NULL REFERENCES public.courses(id) ON DELETE CASCADE,
  status           TEXT DEFAULT 'started' CHECK (status IN ('started','in_progress','completed')),
  progress_percent INT DEFAULT 0,
  started_at       TIMESTAMPTZ DEFAULT NOW(),
  completed_at     TIMESTAMPTZ,
  UNIQUE (user_id, course_id)
);

-- ── 13. LESSON PROGRESS (BIGINT FK → lessons.id) ─────────────
CREATE TABLE IF NOT EXISTS public.lesson_progress (
  id           BIGSERIAL PRIMARY KEY,
  user_id      UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  lesson_id    BIGINT NOT NULL REFERENCES public.lessons(id) ON DELETE CASCADE,
  completed    BOOLEAN DEFAULT FALSE,
  completed_at TIMESTAMPTZ,
  UNIQUE (user_id, lesson_id)
);

-- ── 14. QUIZ WEEKS ────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.quiz_weeks (
  id          BIGSERIAL PRIMARY KEY,
  title       TEXT NOT NULL,
  description TEXT,
  theme       TEXT,
  week_start  DATE,
  week_end    DATE,
  time_limit  INT DEFAULT 600,
  is_active   BOOLEAN DEFAULT TRUE,
  week_number INT,
  created_at  TIMESTAMPTZ DEFAULT NOW(),
  updated_at  TIMESTAMPTZ DEFAULT NOW()
);

-- ── 15. QUIZ QUESTIONS ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.quiz_questions (
  id           BIGSERIAL PRIMARY KEY,
  quiz_week_id BIGINT NOT NULL REFERENCES public.quiz_weeks(id) ON DELETE CASCADE,
  question     TEXT NOT NULL,
  difficulty   TEXT DEFAULT 'medium' CHECK (difficulty IN ('easy','medium','hard')),
  category     TEXT DEFAULT 'general',
  explanation  TEXT,
  "order"      INT DEFAULT 0,
  created_at   TIMESTAMPTZ DEFAULT NOW()
);

-- ── 16. QUIZ OPTIONS ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.quiz_options (
  id               BIGSERIAL PRIMARY KEY,
  quiz_question_id BIGINT NOT NULL REFERENCES public.quiz_questions(id) ON DELETE CASCADE,
  option_text      TEXT NOT NULL,
  is_correct       BOOLEAN DEFAULT FALSE,
  "order"          INT DEFAULT 0
);

-- ── 17. QUIZ ATTEMPTS ─────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.quiz_attempts (
  id              BIGSERIAL PRIMARY KEY,
  quiz_week_id    BIGINT NOT NULL REFERENCES public.quiz_weeks(id),
  user_id         UUID REFERENCES auth.users(id) ON DELETE SET NULL,
  guest_name      TEXT,
  score           INT DEFAULT 0,
  total_questions INT DEFAULT 0,
  time_taken      INT,
  answers         JSONB,
  ip_address      TEXT,
  created_at      TIMESTAMPTZ DEFAULT NOW(),
  updated_at      TIMESTAMPTZ DEFAULT NOW()
);

-- ── 18. CONTACT MESSAGES ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.contact_messages (
  id         BIGSERIAL PRIMARY KEY,
  name       TEXT NOT NULL,
  email      TEXT NOT NULL,
  phone      TEXT,
  subject    TEXT,
  message    TEXT NOT NULL,
  is_read    BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMPTZ DEFAULT NOW()
);

-- ── Performance indexes ────────────────────────────────────────
CREATE INDEX IF NOT EXISTS idx_posts_type              ON public.posts(type);
CREATE INDEX IF NOT EXISTS idx_match_results_date      ON public.match_results(match_date);
CREATE INDEX IF NOT EXISTS idx_standings_rank          ON public.standings(rank);
CREATE INDEX IF NOT EXISTS idx_lessons_course          ON public.lessons(course_id);
CREATE INDEX IF NOT EXISTS idx_player_progress_user    ON public.player_progress(user_id);
CREATE INDEX IF NOT EXISTS idx_lesson_progress_user    ON public.lesson_progress(user_id);
CREATE INDEX IF NOT EXISTS idx_quiz_attempts_user      ON public.quiz_attempts(user_id);
CREATE INDEX IF NOT EXISTS idx_quiz_attempts_week      ON public.quiz_attempts(quiz_week_id);
CREATE INDEX IF NOT EXISTS idx_contact_read            ON public.contact_messages(is_read);
CREATE INDEX IF NOT EXISTS idx_profiles_role           ON public.profiles(role);
CREATE INDEX IF NOT EXISTS idx_profiles_status         ON public.profiles(status);
