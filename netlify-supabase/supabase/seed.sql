-- ============================================================
-- Seed Data — OFA Academy
-- Run AFTER schema.sql and policies.sql
-- ============================================================

-- ── Booking Packages ─────────────────────────────────────────
INSERT INTO public.booking_packages (name, description, price, duration, features, is_active)
VALUES
  ('Starter', 'Perfect for beginners', 50.00, '1 month',
   '["2 sessions/week", "Basic training", "Kit included"]', TRUE),
  ('Pro Academy', 'Intermediate development programme', 120.00, '1 month',
   '["4 sessions/week", "Tactical training", "Video analysis", "Nutrition guide"]', TRUE),
  ('Elite', 'Full professional pathway', 250.00, '1 month',
   '["Daily training", "1-on-1 coaching", "Match exposure", "Scouting report"]', TRUE);

-- ── Quiz Week 1 ───────────────────────────────────────────────
INSERT INTO public.quiz_weeks (title, week_number, is_active)
VALUES ('Week 1 — Football Basics', 1, TRUE);

-- Questions (replace uuid below with actual quiz_week id after running schema)
-- Using a CTE to reference the week we just created
WITH week AS (SELECT id FROM public.quiz_weeks WHERE week_number = 1)

INSERT INTO public.quiz_questions (quiz_week_id, question_text)
SELECT week.id, q FROM week, (VALUES
  ('How many players are on a football team during a match?'),
  ('How long is a standard football match?'),
  ('What does the offside rule prevent?')
) AS questions(q);

-- Options for Q1
WITH q1 AS (
  SELECT qq.id FROM public.quiz_questions qq
  JOIN public.quiz_weeks qw ON qq.quiz_week_id = qw.id
  WHERE qw.week_number = 1 AND qq.question_text LIKE 'How many players%'
)
INSERT INTO public.quiz_options (question_id, option_text, is_correct)
SELECT q1.id, opt, is_correct FROM q1,
  (VALUES ('9', FALSE), ('10', FALSE), ('11', TRUE), ('12', FALSE)) AS opts(opt, is_correct);

-- Options for Q2
WITH q2 AS (
  SELECT qq.id FROM public.quiz_questions qq
  JOIN public.quiz_weeks qw ON qq.quiz_week_id = qw.id
  WHERE qw.week_number = 1 AND qq.question_text LIKE 'How long is%'
)
INSERT INTO public.quiz_options (question_id, option_text, is_correct)
SELECT q2.id, opt, is_correct FROM q2,
  (VALUES ('60 minutes', FALSE), ('90 minutes', TRUE), ('80 minutes', FALSE), ('120 minutes', FALSE)) AS opts(opt, is_correct);

-- Options for Q3
WITH q3 AS (
  SELECT qq.id FROM public.quiz_questions qq
  JOIN public.quiz_weeks qw ON qq.quiz_week_id = qw.id
  WHERE qw.week_number = 1 AND qq.question_text LIKE 'What does the offside%'
)
INSERT INTO public.quiz_options (question_id, option_text, is_correct)
SELECT q3.id, opt, is_correct FROM q3,
  (VALUES
    ('Goalkeepers from leaving their area', FALSE),
    ('Attackers gaining unfair positional advantage', TRUE),
    ('Defenders from fouling', FALSE),
    ('Players from taking free kicks', FALSE)
  ) AS opts(opt, is_correct);

-- ── Sample Match Results ─────────────────────────────────────
INSERT INTO public.match_results (home_team, away_team, home_score, away_score, match_date, competition)
VALUES
  ('OFA Academy', 'Lagos Stars FC', 3, 1, '2026-05-10', 'Youth League'),
  ('OFA Academy', 'Abuja Boys FC',  2, 2, '2026-05-17', 'Youth League'),
  ('Lagos Stars FC', 'OFA Academy', 0, 2, '2026-05-24', 'Youth League');

-- ── Sample Fixtures ───────────────────────────────────────────
INSERT INTO public.next_fixtures (home_team, away_team, fixture_date, venue, competition)
VALUES
  ('OFA Academy', 'Delta Eagles FC', '2026-06-07 15:00:00+01', 'OFA Academy Ground', 'Youth League'),
  ('Benin City FC', 'OFA Academy',   '2026-06-14 14:00:00+01', 'Benin City Stadium',  'Youth League');
