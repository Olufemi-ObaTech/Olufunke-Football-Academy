-- ============================================================
-- Supabase Row Level Security (RLS) Policies — OFA Academy
-- Run AFTER schema.sql in: Supabase Dashboard → SQL Editor
-- ============================================================

-- ── Enable RLS on all tables ─────────────────────────────────
ALTER TABLE public.profiles          ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.players           ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.player_ratings    ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.courses           ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.lessons           ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.lesson_progress   ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_weeks        ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_questions    ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_options      ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_attempts     ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.contact_messages  ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.match_results     ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.next_fixtures     ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.booking_packages  ENABLE ROW LEVEL SECURITY;

-- ────────────────────────────────────────────────────────────
-- Helper: check if current user is admin
-- ────────────────────────────────────────────────────────────
CREATE OR REPLACE FUNCTION public.is_admin()
RETURNS BOOLEAN AS $$
  SELECT EXISTS (
    SELECT 1 FROM public.profiles
    WHERE id = auth.uid() AND role = 'admin'
  );
$$ LANGUAGE sql SECURITY DEFINER STABLE;

-- ────────────────────────────────────────────────────────────
-- PROFILES
-- ────────────────────────────────────────────────────────────
-- Users can read and update their own profile; admins can read all
CREATE POLICY "profiles_select_own"   ON public.profiles FOR SELECT
  USING (id = auth.uid() OR public.is_admin());

CREATE POLICY "profiles_update_own"   ON public.profiles FOR UPDATE
  USING (id = auth.uid());

-- ────────────────────────────────────────────────────────────
-- PLAYERS
-- ────────────────────────────────────────────────────────────
-- Public can read approved players
CREATE POLICY "players_select_approved" ON public.players FOR SELECT
  USING (approved = TRUE OR public.is_admin() OR user_id = auth.uid());

-- Only admins can approve, create, update, delete
CREATE POLICY "players_insert_admin"   ON public.players FOR INSERT
  WITH CHECK (public.is_admin());

CREATE POLICY "players_update_admin"   ON public.players FOR UPDATE
  USING (public.is_admin() OR user_id = auth.uid());

CREATE POLICY "players_delete_admin"   ON public.players FOR DELETE
  USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- PLAYER RATINGS
-- ────────────────────────────────────────────────────────────
CREATE POLICY "ratings_select_all"    ON public.player_ratings FOR SELECT USING (TRUE);
CREATE POLICY "ratings_insert_admin"  ON public.player_ratings FOR INSERT WITH CHECK (public.is_admin());
CREATE POLICY "ratings_update_admin"  ON public.player_ratings FOR UPDATE USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- COURSES & LESSONS (published = public read)
-- ────────────────────────────────────────────────────────────
CREATE POLICY "courses_select_public"  ON public.courses FOR SELECT
  USING (is_published = TRUE OR public.is_admin());

CREATE POLICY "courses_mutate_admin"   ON public.courses FOR ALL
  USING (public.is_admin());

CREATE POLICY "lessons_select_public"  ON public.lessons FOR SELECT
  USING (
    EXISTS (
      SELECT 1 FROM public.courses
      WHERE id = course_id AND (is_published = TRUE OR public.is_admin())
    )
  );

CREATE POLICY "lessons_mutate_admin"   ON public.lessons FOR ALL
  USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- LESSON PROGRESS — own rows only
-- ────────────────────────────────────────────────────────────
CREATE POLICY "progress_select_own"   ON public.lesson_progress FOR SELECT
  USING (user_id = auth.uid() OR public.is_admin());

CREATE POLICY "progress_insert_own"   ON public.lesson_progress FOR INSERT
  WITH CHECK (user_id = auth.uid());

CREATE POLICY "progress_update_own"   ON public.lesson_progress FOR UPDATE
  USING (user_id = auth.uid());

-- ────────────────────────────────────────────────────────────
-- QUIZ (questions/options public read; attempts own)
-- ────────────────────────────────────────────────────────────
CREATE POLICY "quiz_weeks_public"     ON public.quiz_weeks     FOR SELECT USING (TRUE);
CREATE POLICY "quiz_questions_public" ON public.quiz_questions  FOR SELECT USING (TRUE);

-- Hide is_correct from non-admins
CREATE POLICY "quiz_options_public"   ON public.quiz_options    FOR SELECT
  USING (TRUE);   -- is_correct filtering is done in the Netlify function

CREATE POLICY "quiz_attempts_own"     ON public.quiz_attempts   FOR SELECT
  USING (user_id = auth.uid() OR public.is_admin());

CREATE POLICY "quiz_attempts_insert"  ON public.quiz_attempts   FOR INSERT
  WITH CHECK (user_id = auth.uid());

-- ────────────────────────────────────────────────────────────
-- CONTACT MESSAGES — write-only for public, read for admins
-- ────────────────────────────────────────────────────────────
CREATE POLICY "contact_insert_public" ON public.contact_messages FOR INSERT
  WITH CHECK (TRUE);

CREATE POLICY "contact_select_admin"  ON public.contact_messages FOR SELECT
  USING (public.is_admin());

CREATE POLICY "contact_update_admin"  ON public.contact_messages FOR UPDATE
  USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- MATCH RESULTS & FIXTURES — public read, admin write
-- ────────────────────────────────────────────────────────────
CREATE POLICY "results_select_all"    ON public.match_results   FOR SELECT USING (TRUE);
CREATE POLICY "results_mutate_admin"  ON public.match_results   FOR ALL    USING (public.is_admin());

CREATE POLICY "fixtures_select_all"   ON public.next_fixtures   FOR SELECT USING (TRUE);
CREATE POLICY "fixtures_mutate_admin" ON public.next_fixtures   FOR ALL    USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- BOOKING PACKAGES — public read, admin write
-- ────────────────────────────────────────────────────────────
CREATE POLICY "packages_select_active" ON public.booking_packages FOR SELECT
  USING (is_active = TRUE OR public.is_admin());

CREATE POLICY "packages_mutate_admin"  ON public.booking_packages FOR ALL
  USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- POSTS — public read, admin write
-- ────────────────────────────────────────────────────────────
ALTER TABLE public.posts ENABLE ROW LEVEL SECURITY;
CREATE POLICY "posts_select_all"   ON public.posts FOR SELECT USING (TRUE);
CREATE POLICY "posts_mutate_admin" ON public.posts FOR ALL    USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- MANAGEMENT TEAM — public read, admin write
-- ────────────────────────────────────────────────────────────
ALTER TABLE public.management_team ENABLE ROW LEVEL SECURITY;
CREATE POLICY "team_select_all"   ON public.management_team FOR SELECT USING (TRUE);
CREATE POLICY "team_mutate_admin" ON public.management_team FOR ALL    USING (public.is_admin());

-- ────────────────────────────────────────────────────────────
-- STANDINGS — public read, admin write
-- ────────────────────────────────────────────────────────────
ALTER TABLE public.standings ENABLE ROW LEVEL SECURITY;
CREATE POLICY "standings_select_all"   ON public.standings FOR SELECT USING (TRUE);
CREATE POLICY "standings_mutate_admin" ON public.standings FOR ALL    USING (public.is_admin());

-- ── Courses / Lessons ────────────────────────────────────────
ALTER TABLE public.courses         ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.lessons         ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.player_progress ENABLE ROW LEVEL SECURITY;
CREATE POLICY "courses_read_all"      ON public.courses         FOR SELECT USING (TRUE);
CREATE POLICY "courses_admin"         ON public.courses         FOR ALL    USING (public.is_admin());
CREATE POLICY "lessons_read_all"      ON public.lessons         FOR SELECT USING (TRUE);
CREATE POLICY "lessons_admin"         ON public.lessons         FOR ALL    USING (public.is_admin());
CREATE POLICY "progress_own"          ON public.player_progress FOR SELECT USING (user_id = auth.uid() OR public.is_admin());
CREATE POLICY "progress_insert_own"   ON public.player_progress FOR INSERT WITH CHECK (user_id = auth.uid());
CREATE POLICY "progress_update_own"   ON public.player_progress FOR UPDATE USING (user_id = auth.uid());

-- ── Quiz tables ──────────────────────────────────────────────
ALTER TABLE public.quiz_weeks    ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_questions ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_options   ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_attempts  ENABLE ROW LEVEL SECURITY;
CREATE POLICY "qw_read_all"   ON public.quiz_weeks     FOR SELECT USING (TRUE);
CREATE POLICY "qw_admin"      ON public.quiz_weeks     FOR ALL    USING (public.is_admin());
CREATE POLICY "qq_read_all"   ON public.quiz_questions  FOR SELECT USING (TRUE);
CREATE POLICY "qq_admin"      ON public.quiz_questions  FOR ALL    USING (public.is_admin());
CREATE POLICY "qo_read_all"   ON public.quiz_options    FOR SELECT USING (TRUE);
CREATE POLICY "qo_admin"      ON public.quiz_options    FOR ALL    USING (public.is_admin());
CREATE POLICY "qa_read_all"   ON public.quiz_attempts   FOR SELECT USING (TRUE);
CREATE POLICY "qa_insert_all" ON public.quiz_attempts   FOR INSERT WITH CHECK (TRUE);
CREATE POLICY "qa_admin"      ON public.quiz_attempts   FOR ALL    USING (public.is_admin());
