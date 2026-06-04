-- ============================================================
-- OFA Academy — Row Level Security Policies
-- Run AFTER schema.sql
-- ============================================================

-- Helper: is the current user an admin?
CREATE OR REPLACE FUNCTION public.is_admin()
RETURNS BOOLEAN AS $$
  SELECT EXISTS (
    SELECT 1 FROM public.profiles
    WHERE id = auth.uid() AND role = 'admin'
  );
$$ LANGUAGE sql SECURITY DEFINER STABLE;

-- Enable RLS on every table
ALTER TABLE public.profiles        ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.players         ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.posts           ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.match_results   ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.next_fixtures   ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.standings       ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.management_team ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.products        ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.booking_packages ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.courses         ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.lessons         ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.player_progress ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.lesson_progress ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_weeks      ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_questions  ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_options    ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.quiz_attempts   ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.contact_messages ENABLE ROW LEVEL SECURITY;

-- PROFILES — own row + admin
CREATE POLICY "profiles_select" ON public.profiles FOR SELECT USING (id = auth.uid() OR public.is_admin());
CREATE POLICY "profiles_update" ON public.profiles FOR UPDATE USING (id = auth.uid());
CREATE POLICY "profiles_insert" ON public.profiles FOR INSERT WITH CHECK (id = auth.uid());

-- PLAYERS — public read, admin write
CREATE POLICY "players_read"  ON public.players FOR SELECT USING (TRUE);
CREATE POLICY "players_admin" ON public.players FOR ALL    USING (public.is_admin());

-- POSTS — public read, admin write
CREATE POLICY "posts_read"    ON public.posts FOR SELECT USING (TRUE);
CREATE POLICY "posts_admin"   ON public.posts FOR ALL    USING (public.is_admin());

-- MATCH RESULTS / FIXTURES / STANDINGS — public read, admin write
CREATE POLICY "results_read"   ON public.match_results  FOR SELECT USING (TRUE);
CREATE POLICY "results_admin"  ON public.match_results  FOR ALL    USING (public.is_admin());
CREATE POLICY "fixtures_read"  ON public.next_fixtures  FOR SELECT USING (TRUE);
CREATE POLICY "fixtures_admin" ON public.next_fixtures  FOR ALL    USING (public.is_admin());
CREATE POLICY "stand_read"     ON public.standings      FOR SELECT USING (TRUE);
CREATE POLICY "stand_admin"    ON public.standings      FOR ALL    USING (public.is_admin());

-- MANAGEMENT TEAM — public read, admin write
CREATE POLICY "team_read"  ON public.management_team FOR SELECT USING (TRUE);
CREATE POLICY "team_admin" ON public.management_team FOR ALL    USING (public.is_admin());

-- PRODUCTS / PACKAGES — public read, admin write
CREATE POLICY "prod_read"  ON public.products         FOR SELECT USING (TRUE);
CREATE POLICY "prod_admin" ON public.products         FOR ALL    USING (public.is_admin());
CREATE POLICY "pkg_read"   ON public.booking_packages FOR SELECT USING (TRUE);
CREATE POLICY "pkg_admin"  ON public.booking_packages FOR ALL    USING (public.is_admin());

-- COURSES / LESSONS — public read, admin write
CREATE POLICY "courses_read"  ON public.courses  FOR SELECT USING (TRUE);
CREATE POLICY "courses_admin" ON public.courses  FOR ALL    USING (public.is_admin());
CREATE POLICY "lessons_read"  ON public.lessons  FOR SELECT USING (TRUE);
CREATE POLICY "lessons_admin" ON public.lessons  FOR ALL    USING (public.is_admin());

-- PLAYER / LESSON PROGRESS — own rows + admin
CREATE POLICY "pp_read"   ON public.player_progress FOR SELECT USING (user_id = auth.uid() OR public.is_admin());
CREATE POLICY "pp_insert" ON public.player_progress FOR INSERT WITH CHECK (user_id = auth.uid());
CREATE POLICY "pp_update" ON public.player_progress FOR UPDATE USING (user_id = auth.uid());
CREATE POLICY "lp_read"   ON public.lesson_progress FOR SELECT USING (user_id = auth.uid() OR public.is_admin());
CREATE POLICY "lp_insert" ON public.lesson_progress FOR INSERT WITH CHECK (user_id = auth.uid());
CREATE POLICY "lp_update" ON public.lesson_progress FOR UPDATE USING (user_id = auth.uid());

-- QUIZ — public read attempts, anyone can insert, admin write all
CREATE POLICY "qw_read"   ON public.quiz_weeks     FOR SELECT USING (TRUE);
CREATE POLICY "qw_admin"  ON public.quiz_weeks     FOR ALL    USING (public.is_admin());
CREATE POLICY "qq_read"   ON public.quiz_questions FOR SELECT USING (TRUE);
CREATE POLICY "qq_admin"  ON public.quiz_questions FOR ALL    USING (public.is_admin());
CREATE POLICY "qo_read"   ON public.quiz_options   FOR SELECT USING (TRUE);
CREATE POLICY "qo_admin"  ON public.quiz_options   FOR ALL    USING (public.is_admin());
CREATE POLICY "qa_read"   ON public.quiz_attempts  FOR SELECT USING (TRUE);
CREATE POLICY "qa_insert" ON public.quiz_attempts  FOR INSERT WITH CHECK (TRUE);
CREATE POLICY "qa_admin"  ON public.quiz_attempts  FOR ALL    USING (public.is_admin());

-- CONTACT MESSAGES — public insert, admin read/update
CREATE POLICY "cm_insert" ON public.contact_messages FOR INSERT WITH CHECK (TRUE);
CREATE POLICY "cm_read"   ON public.contact_messages FOR SELECT USING (public.is_admin());
CREATE POLICY "cm_update" ON public.contact_messages FOR UPDATE USING (public.is_admin());
