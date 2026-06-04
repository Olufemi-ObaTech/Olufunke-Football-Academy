-- ============================================================
-- OFA Academy — Course Levels & Exam System
-- Levels 1-7, exams after each lesson/course
-- Pass mark: 70% to advance | Below 50%: repeat course
-- Run AFTER schema.sql
-- ============================================================

-- ── Add level column to courses ───────────────────────────────
ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS level_number INT DEFAULT 1
  CHECK (level_number BETWEEN 1 AND 7);

ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS unlock_score INT DEFAULT 70
  COMMENT_WORKAROUND TEXT; -- 70 = 70% needed to unlock next level

-- Remove the invalid comment workaround column
ALTER TABLE public.courses DROP COLUMN IF EXISTS COMMENT_WORKAROUND;

ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS pass_score     INT DEFAULT 70;
ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS repeat_score   INT DEFAULT 50;
ALTER TABLE public.courses ADD COLUMN IF NOT EXISTS next_course_id BIGINT REFERENCES public.courses(id);

-- ── Add level column to lessons ────────────────────────────────
ALTER TABLE public.lessons ADD COLUMN IF NOT EXISTS has_exam       BOOLEAN DEFAULT TRUE;
ALTER TABLE public.lessons ADD COLUMN IF NOT EXISTS exam_pass_score INT DEFAULT 70;

-- ── LESSON EXAMS ──────────────────────────────────────────────
-- Each lesson can have exam questions (multiple choice)
CREATE TABLE IF NOT EXISTS public.lesson_exams (
  id              BIGSERIAL PRIMARY KEY,
  lesson_id       BIGINT NOT NULL REFERENCES public.lessons(id) ON DELETE CASCADE,
  question        TEXT NOT NULL,
  option_a        TEXT NOT NULL,
  option_b        TEXT NOT NULL,
  option_c        TEXT NOT NULL,
  option_d        TEXT NOT NULL,
  correct_option  TEXT NOT NULL CHECK (correct_option IN ('a','b','c','d')),
  explanation     TEXT,
  "order"         INT DEFAULT 0,
  created_at      TIMESTAMPTZ DEFAULT NOW()
);

-- ── LESSON EXAM RESULTS ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.lesson_exam_results (
  id            BIGSERIAL PRIMARY KEY,
  user_id       UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  lesson_id     BIGINT NOT NULL REFERENCES public.lessons(id) ON DELETE CASCADE,
  score         INT DEFAULT 0,        -- percentage 0-100
  passed        BOOLEAN DEFAULT FALSE,
  attempt_count INT DEFAULT 1,
  answers       JSONB,                -- { question_id: selected_option }
  completed_at  TIMESTAMPTZ DEFAULT NOW(),
  UNIQUE (user_id, lesson_id)         -- keeps only the best attempt
);

-- ── COURSE EXAM RESULTS ────────────────────────────────────────
-- Taken at the end of a full course (all lessons complete)
CREATE TABLE IF NOT EXISTS public.course_exam_results (
  id            BIGSERIAL PRIMARY KEY,
  user_id       UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
  course_id     BIGINT NOT NULL REFERENCES public.courses(id) ON DELETE CASCADE,
  score         INT DEFAULT 0,        -- percentage 0-100
  passed        BOOLEAN DEFAULT FALSE,
  can_advance   BOOLEAN DEFAULT FALSE, -- score >= pass_score (70%)
  must_repeat   BOOLEAN DEFAULT FALSE, -- score < repeat_score (50%)
  attempt_count INT DEFAULT 1,
  completed_at  TIMESTAMPTZ DEFAULT NOW(),
  UNIQUE (user_id, course_id)
);

-- ── COURSE LEVELS VIEW ─────────────────────────────────────────
-- Makes it easy to query "what level is user on?"
CREATE OR REPLACE VIEW public.user_level AS
SELECT
  p.id AS user_id,
  COALESCE(MAX(c.level_number), 0) AS current_level,
  COUNT(CASE WHEN cer.passed = TRUE THEN 1 END) AS courses_passed,
  COUNT(CASE WHEN cer.must_repeat = TRUE THEN 1 END) AS courses_to_repeat
FROM public.profiles p
LEFT JOIN public.course_exam_results cer ON cer.user_id = p.id
LEFT JOIN public.courses c ON c.id = cer.course_id AND cer.passed = TRUE
WHERE p.role = 'player'
GROUP BY p.id;

-- ── RLS for new tables ─────────────────────────────────────────
ALTER TABLE public.lesson_exams        ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.lesson_exam_results ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.course_exam_results ENABLE ROW LEVEL SECURITY;

-- Exam questions: approved members can read, admin writes
CREATE POLICY "lex_read"  ON public.lesson_exams        FOR SELECT USING (public.is_approved_member());
CREATE POLICY "lex_admin" ON public.lesson_exams        FOR ALL    USING (public.is_admin());
-- Exam results: own rows only
CREATE POLICY "ler_read"  ON public.lesson_exam_results FOR SELECT USING (user_id = auth.uid() OR public.is_admin());
CREATE POLICY "ler_insert" ON public.lesson_exam_results FOR INSERT WITH CHECK (user_id = auth.uid());
CREATE POLICY "ler_update" ON public.lesson_exam_results FOR UPDATE USING (user_id = auth.uid());
CREATE POLICY "cer_read"  ON public.course_exam_results FOR SELECT USING (user_id = auth.uid() OR public.is_admin());
CREATE POLICY "cer_insert" ON public.course_exam_results FOR INSERT WITH CHECK (user_id = auth.uid());
CREATE POLICY "cer_update" ON public.course_exam_results FOR UPDATE USING (user_id = auth.uid());

-- ── Indexes ────────────────────────────────────────────────────
CREATE INDEX IF NOT EXISTS idx_lesson_exams_lesson      ON public.lesson_exams(lesson_id);
CREATE INDEX IF NOT EXISTS idx_lesson_exam_results_user ON public.lesson_exam_results(user_id);
CREATE INDEX IF NOT EXISTS idx_course_exam_results_user ON public.course_exam_results(user_id);
CREATE INDEX IF NOT EXISTS idx_courses_level            ON public.courses(level_number);
