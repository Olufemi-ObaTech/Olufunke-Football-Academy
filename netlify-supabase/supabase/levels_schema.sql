-- ============================================================
-- OFA Academy — Course Levels & Exam System
-- Levels 1-7, exams after each lesson/course
-- Pass: 70% | Fail/Repeat: below 50%
-- Run AFTER schema.sql
-- ============================================================

-- Add level and scoring columns to courses
ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS level_number   INT DEFAULT 1 CHECK (level_number BETWEEN 1 AND 7);
ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS pass_score     INT DEFAULT 70;
ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS repeat_score   INT DEFAULT 50;
ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS next_course_id BIGINT REFERENCES public.courses(id);

-- Add exam flag to lessons
ALTER TABLE public.lessons ADD COLUMN IF NOT EXISTS has_exam        BOOLEAN DEFAULT TRUE;
ALTER TABLE public.lessons ADD COLUMN IF NOT EXISTS exam_pass_score INT DEFAULT 70;

-- ── LESSON EXAMS ──────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.lesson_exams (
  id             BIGSERIAL PRIMARY KEY,
  lesson_id      BIGINT NOT NULL REFERENCES public.lessons(id) ON DELETE CASCADE,
  question       TEXT NOT NULL,
  option_a       TEXT NOT NULL,
  option_b       TEXT NOT NULL,
  option_c       TEXT NOT NULL,
  option_d       TEXT NOT NULL,
  correct_option TEXT NOT NULL CHECK (correct_option IN ('a','b','c','d')),
  explanation    TEXT,
  "order"        INT DEFAULT 0,
  created_at     TIMESTAMPTZ DEFAULT NOW()
);

-- ── LESSON EXAM RESULTS ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.lesson_exam_results (
  id            BIGSERIAL PRIMARY KEY,
  user_id       UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  lesson_id     BIGINT NOT NULL REFERENCES public.lessons(id) ON DELETE CASCADE,
  score         INT DEFAULT 0,
  passed        BOOLEAN DEFAULT FALSE,
  attempt_count INT DEFAULT 1,
  answers       JSONB,
  completed_at  TIMESTAMPTZ DEFAULT NOW(),
  UNIQUE (user_id, lesson_id)
);

-- ── COURSE EXAM RESULTS ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.course_exam_results (
  id            BIGSERIAL PRIMARY KEY,
  user_id       UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  course_id     BIGINT NOT NULL REFERENCES public.courses(id) ON DELETE CASCADE,
  score         INT DEFAULT 0,
  passed        BOOLEAN DEFAULT FALSE,
  can_advance   BOOLEAN DEFAULT FALSE,
  must_repeat   BOOLEAN DEFAULT FALSE,
  attempt_count INT DEFAULT 1,
  completed_at  TIMESTAMPTZ DEFAULT NOW(),
  UNIQUE (user_id, course_id)
);

-- ── RLS ────────────────────────────────────────────────────────
ALTER TABLE public.lesson_exams        ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.lesson_exam_results ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.course_exam_results ENABLE ROW LEVEL SECURITY;

CREATE POLICY "lex_read"   ON public.lesson_exams        FOR SELECT USING (public.is_approved_member());
CREATE POLICY "lex_admin"  ON public.lesson_exams        FOR ALL    USING (public.is_admin());
CREATE POLICY "ler_read"   ON public.lesson_exam_results FOR SELECT USING (user_id = auth.uid() OR public.is_admin());
CREATE POLICY "ler_insert" ON public.lesson_exam_results FOR INSERT WITH CHECK (user_id = auth.uid());
CREATE POLICY "ler_update" ON public.lesson_exam_results FOR UPDATE USING (user_id = auth.uid());
CREATE POLICY "cer_read"   ON public.course_exam_results FOR SELECT USING (user_id = auth.uid() OR public.is_admin());
CREATE POLICY "cer_insert" ON public.course_exam_results FOR INSERT WITH CHECK (user_id = auth.uid());
CREATE POLICY "cer_update" ON public.course_exam_results FOR UPDATE USING (user_id = auth.uid());

CREATE INDEX IF NOT EXISTS idx_lesson_exams_lesson      ON public.lesson_exams(lesson_id);
CREATE INDEX IF NOT EXISTS idx_lesson_exam_results_user ON public.lesson_exam_results(user_id);
CREATE INDEX IF NOT EXISTS idx_course_exam_results_user ON public.course_exam_results(user_id);
CREATE INDEX IF NOT EXISTS idx_courses_level            ON public.courses(level_number);
