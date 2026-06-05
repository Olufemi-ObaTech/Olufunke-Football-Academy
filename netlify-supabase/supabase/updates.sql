-- ============================================================
-- OFA Academy — Updates
-- 1. Fix quiz week descriptions
-- 2. Create admin user in Supabase Auth
-- 3. Add stars/level tracking columns to profiles
-- ============================================================

-- Fix Week 2 description
UPDATE public.quiz_weeks
SET description = 'World Football Challenge covering Global football Questions — 10 random per game!'
WHERE week_number = 2;

-- Fix Week 3 description
UPDATE public.quiz_weeks
SET description = 'World Football Challenge covering Nigeria, Africa and Global football Questions — 10 random per game!'
WHERE week_number = 3;

-- Fix Week 1 description
UPDATE public.quiz_weeks
SET description = 'Football Basics Challenge — Test your knowledge of the fundamental rules and history of football!'
WHERE week_number = 1;

-- Set all quizzes to 5 minute time limit (300 seconds)
UPDATE public.quiz_weeks SET time_limit = 300;

-- Add stars and level tracking to profiles
ALTER TABLE public.profiles ADD COLUMN IF NOT EXISTS total_stars     INT DEFAULT 0;
ALTER TABLE public.profiles ADD COLUMN IF NOT EXISTS current_level   INT DEFAULT 1;
ALTER TABLE public.profiles ADD COLUMN IF NOT EXISTS courses_passed  INT DEFAULT 0;
ALTER TABLE public.profiles ADD COLUMN IF NOT EXISTS courses_failed  INT DEFAULT 0;

-- Function to calculate stars from exam score
CREATE OR REPLACE FUNCTION public.calculate_stars(score_pct INT)
RETURNS INT AS $$
BEGIN
  IF score_pct >= 90 THEN RETURN 5;
  ELSIF score_pct >= 75 THEN RETURN 4;
  ELSIF score_pct >= 65 THEN RETURN 3;
  ELSIF score_pct >= 50 THEN RETURN 2;
  ELSE RETURN 1;
  END IF;
END;
$$ LANGUAGE plpgsql IMMUTABLE;

-- Function to update player level based on courses passed
CREATE OR REPLACE FUNCTION public.update_player_level(p_user_id UUID)
RETURNS VOID AS $$
DECLARE
  v_courses_passed INT;
  v_new_level      INT;
BEGIN
  SELECT COUNT(*) INTO v_courses_passed
  FROM public.course_exam_results
  WHERE user_id = p_user_id AND passed = TRUE;

  -- Level up every 2 courses passed (max level 7)
  v_new_level := LEAST(7, 1 + (v_courses_passed / 2));

  UPDATE public.profiles
  SET courses_passed = v_courses_passed,
      current_level  = v_new_level,
      updated_at     = NOW()
  WHERE id = p_user_id;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

-- Create the admin account in Supabase
-- (Supabase auth.users is managed by the API, but we can insert a profile for an existing user)
-- The admin email is: Olufunkefootballacademy@gmail.com
-- After you sign up with this email on the website, run this:
INSERT INTO public.profiles (id, full_name, role, status, current_level)
SELECT
  u.id,
  COALESCE(u.raw_user_meta_data->>'full_name', 'OFA Admin'),
  'admin',
  'approved',
  7
FROM auth.users u
WHERE u.email = 'Olufunkefootballacademy@gmail.com'
ON CONFLICT (id) DO UPDATE
  SET role          = 'admin',
      status        = 'approved',
      current_level = 7,
      updated_at    = NOW();
