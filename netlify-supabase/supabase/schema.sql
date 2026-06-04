-- ============================================================
-- Supabase Schema — OFA Academy
-- Run this in: Supabase Dashboard → SQL Editor
-- ============================================================

-- Enable UUID extension (already enabled in Supabase by default)
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- ────────────────────────────────────────────────────────────
-- 1. USERS (extends Supabase auth.users)
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.profiles (
  id          UUID PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
  full_name   TEXT,
  avatar_url  TEXT,
  role        TEXT NOT NULL DEFAULT 'player'  -- 'player' | 'admin'
                   CHECK (role IN ('player', 'admin')),
  created_at  TIMESTAMPTZ DEFAULT NOW()
);

-- Auto-create profile when a new user signs up
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS TRIGGER AS $$
BEGIN
  INSERT INTO public.profiles (id, full_name, avatar_url)
  VALUES (
    NEW.id,
    NEW.raw_user_meta_data->>'full_name',
    NEW.raw_user_meta_data->>'avatar_url'
  );
  RETURN NEW;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users;
CREATE TRIGGER on_auth_user_created
  AFTER INSERT ON auth.users
  FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();

-- ────────────────────────────────────────────────────────────
-- 2. PLAYERS
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.players (
  id           BIGSERIAL PRIMARY KEY,
  user_id      UUID REFERENCES auth.users(id) ON DELETE SET NULL,
  full_name    TEXT NOT NULL,
  position     TEXT NOT NULL,
  age          INT,
  photo_url    TEXT DEFAULT '/images/OFA New Logo.jpg',
  goals        INT DEFAULT 0,
  assists      INT DEFAULT 0,
  matches      INT DEFAULT 0,
  quote        TEXT,
  approved     BOOLEAN DEFAULT FALSE,
  created_at   TIMESTAMPTZ DEFAULT NOW(),
  updated_at   TIMESTAMPTZ DEFAULT NOW()
);

-- ────────────────────────────────────────────────────────────
-- 3. STANDINGS — mirrors Laravel standings table
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.standings (
  id              BIGSERIAL PRIMARY KEY,
  rank            INT NOT NULL,
  club_name       TEXT NOT NULL,
  played          INT DEFAULT 0,
  won             INT DEFAULT 0,
  drawn           INT DEFAULT 0,
  lost            INT DEFAULT 0,
  goals_for       INT DEFAULT 0,
  goals_against   INT DEFAULT 0,
  points          INT DEFAULT 0,
  is_featured_club BOOLEAN DEFAULT FALSE,
  created_at      TIMESTAMPTZ DEFAULT NOW(),
  updated_at      TIMESTAMPTZ DEFAULT NOW()
);

-- ────────────────────────────────────────────────────────────
-- 4. PLAYER RATINGS
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.player_ratings (
  id           UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  player_id    BIGINT NOT NULL REFERENCES public.players(id) ON DELETE CASCADE,
  speed        INT CHECK (speed BETWEEN 0 AND 100),
  passing      INT CHECK (passing BETWEEN 0 AND 100),
  shooting     INT CHECK (shooting BETWEEN 0 AND 100),
  defending    INT CHECK (defending BETWEEN 0 AND 100),
  dribbling    INT CHECK (dribbling BETWEEN 0 AND 100),
  rated_by     UUID REFERENCES auth.users(id),
  created_at   TIMESTAMPTZ DEFAULT NOW()
);

-- ────────────────────────────────────────────────────────────
-- 5. COURSES & LESSONS
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.courses (
  id           UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  title        TEXT NOT NULL,
  description  TEXT,
  thumbnail    TEXT,
  level        TEXT DEFAULT 'beginner' CHECK (level IN ('beginner', 'intermediate', 'advanced')),
  is_published BOOLEAN DEFAULT FALSE,
  created_at   TIMESTAMPTZ DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS public.lessons (
  id           UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  course_id    UUID NOT NULL REFERENCES public.courses(id) ON DELETE CASCADE,
  title        TEXT NOT NULL,
  content      TEXT,
  video_url    TEXT,
  order_index  INT DEFAULT 0,
  created_at   TIMESTAMPTZ DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS public.lesson_progress (
  id           UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  user_id      UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  lesson_id    UUID NOT NULL REFERENCES public.lessons(id) ON DELETE CASCADE,
  completed    BOOLEAN DEFAULT FALSE,
  completed_at TIMESTAMPTZ,
  UNIQUE (user_id, lesson_id)
);

-- ────────────────────────────────────────────────────────────
-- 5. QUIZ
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.quiz_weeks (
  id           UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  title        TEXT NOT NULL,
  description  TEXT,
  theme        TEXT,
  week_number  INT UNIQUE NOT NULL,
  week_start   DATE,
  week_end     DATE,
  time_limit   INT DEFAULT 600,  -- seconds, default 10 minutes
  is_active    BOOLEAN DEFAULT TRUE,
  created_at   TIMESTAMPTZ DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS public.quiz_questions (
  id              UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  quiz_week_id    UUID NOT NULL REFERENCES public.quiz_weeks(id) ON DELETE CASCADE,
  question_text   TEXT NOT NULL,
  difficulty      TEXT DEFAULT 'medium' CHECK (difficulty IN ('easy','medium','hard')),
  category        TEXT,
  explanation     TEXT,
  "order"         INT DEFAULT 0,
  created_at      TIMESTAMPTZ DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS public.quiz_options (
  id              UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  question_id     UUID NOT NULL REFERENCES public.quiz_questions(id) ON DELETE CASCADE,
  option_text     TEXT NOT NULL,
  is_correct      BOOLEAN DEFAULT FALSE,
  "order"         INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS public.quiz_attempts (
  id               UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  user_id          UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  quiz_week_id     UUID NOT NULL REFERENCES public.quiz_weeks(id),
  guest_name       TEXT,
  score            INT DEFAULT 0,
  total_questions  INT DEFAULT 0,
  time_taken       INT,            -- seconds
  answers          JSONB,          -- renamed from answers_json for consistency with Laravel model
  ip_address       TEXT,
  completed_at     TIMESTAMPTZ DEFAULT NOW(),
  UNIQUE (user_id, quiz_week_id)
);

-- FK from quiz_attempts to profiles so PostgREST can resolve profiles(full_name) join
ALTER TABLE public.quiz_attempts
  ADD CONSTRAINT fk_quiz_attempts_profile
  FOREIGN KEY (user_id) REFERENCES public.profiles(id) ON DELETE CASCADE;

-- ────────────────────────────────────────────────────────────
-- 6. CONTACT MESSAGES
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.contact_messages (
  id         UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  name       TEXT NOT NULL,
  email      TEXT NOT NULL,
  subject    TEXT,
  message    TEXT NOT NULL,
  is_read    BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMPTZ DEFAULT NOW()
);

-- ────────────────────────────────────────────────────────────
-- 7. MATCH RESULTS & FIXTURES
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.match_results (
  id              BIGSERIAL PRIMARY KEY,
  match_date      DATE NOT NULL,
  opponent        TEXT NOT NULL,
  competition     TEXT,
  result_badge    TEXT NOT NULL,
  status_color    TEXT DEFAULT 'success',
  week_label      TEXT,
  venue           TEXT,
  kick_off_time   TIME,
  notes           TEXT,
  created_at      TIMESTAMPTZ DEFAULT NOW(),
  updated_at      TIMESTAMPTZ DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS public.next_fixtures (
  id              BIGSERIAL PRIMARY KEY,
  week_label      TEXT,
  home_team       TEXT NOT NULL,
  away_team       TEXT NOT NULL,
  competition     TEXT,
  fixture_date    DATE NOT NULL,
  kick_off_time   TIME,
  venue           TEXT,
  is_active       BOOLEAN DEFAULT TRUE,
  created_at      TIMESTAMPTZ DEFAULT NOW(),
  updated_at      TIMESTAMPTZ DEFAULT NOW()
);

-- ────────────────────────────────────────────────────────────
-- 8. POSTS (News, Match Reports, Media) — mirrors Laravel posts table
-- ────────────────────────────────────────────────────────────
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

-- ────────────────────────────────────────────────────────────
-- 9. BOOKING PACKAGES
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.booking_packages (
  id           UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  name         TEXT NOT NULL,
  description  TEXT,
  price        DECIMAL(10,2) NOT NULL,
  duration     TEXT,
  features     JSONB,
  is_active    BOOLEAN DEFAULT TRUE,
  created_at   TIMESTAMPTZ DEFAULT NOW()
);

-- ────────────────────────────────────────────────────────────
-- 10. MANAGEMENT TEAM — mirrors Laravel management_team table
-- ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.management_team (
  id          BIGSERIAL PRIMARY KEY,
  name        TEXT NOT NULL,
  role        TEXT NOT NULL,
  email       TEXT,
  sort_order  INT DEFAULT 0,
  created_at  TIMESTAMPTZ DEFAULT NOW(),
  updated_at  TIMESTAMPTZ DEFAULT NOW()
);

-- ────────────────────────────────────────────────────────────
-- Indexes for performance
-- ────────────────────────────────────────────────────────────
CREATE INDEX IF NOT EXISTS idx_players_approved      ON public.players(approved);
CREATE INDEX IF NOT EXISTS idx_players_user_id       ON public.players(user_id);
CREATE INDEX IF NOT EXISTS idx_lessons_course_id     ON public.lessons(course_id);
CREATE INDEX IF NOT EXISTS idx_lesson_progress_user  ON public.lesson_progress(user_id);
CREATE INDEX IF NOT EXISTS idx_quiz_attempts_user    ON public.quiz_attempts(user_id);
CREATE INDEX IF NOT EXISTS idx_contact_messages_read ON public.contact_messages(is_read);
