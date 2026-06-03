-- ============================================================
-- Supabase Seed — OFA Academy REAL DATA (exported from MySQL)
-- Run AFTER schema.sql and policies.sql
-- Supabase Dashboard → SQL Editor → New query → paste & Run
-- ============================================================

-- ── Standings (LSFA 2026/27 Atlantic Conference) ──────────────
INSERT INTO public.standings (rank, club_name, played, won, drawn, lost, goals_for, goals_against, points, is_featured_club) VALUES
  (1,  'Ecas FC',                 5, 5, 0, 0, 17, 2,  12, FALSE),
  (2,  'Chekas Feeders',          4, 3, 1, 0, 9,  5,  10, FALSE),
  (3,  'Emajus FC',               3, 3, 0, 0, 10, 3,  9,  FALSE),
  (4,  'Team 360',                5, 2, 1, 2, 7,  0,  7,  FALSE),
  (5,  'Olufunke FA',             4, 2, 0, 2, 12, 7,  6,  TRUE),
  (6,  'Hephzibah SC',            4, 1, 2, 1, 4,  3,  5,  FALSE),
  (7,  'Power for the Cross SC',  1, 1, 0, 0, 1,  0,  3,  FALSE),
  (8,  'Young Strikers FC',       4, 0, 1, 3, 4,  13, 1,  FALSE),
  (9,  'Buckner FC',              3, 0, 0, 3, 2,  7,  0,  FALSE),
  (10, 'Gemstones FC',            1, 0, 0, 1, 0,  6,  0,  FALSE);

-- ── Match Results ─────────────────────────────────────────────
INSERT INTO public.match_results (match_date, opponent, competition, result_badge, status_color, week_label, venue) VALUES
  ('2026-04-21', 'Power for the Cross SC', 'LSFA State League 2026/27 — Atlantic Conference WK1', 'Power for the Cross SC 1 - 0 Olufunke FA', 'danger',    'WK1', NULL),
  ('2026-04-28', 'Gemstones FC',           'LSFA State League 2026/27 — Atlantic Conference WK2', 'Olufunke FA 6 - 0 Gemstones FC',           'success',   'WK2', NULL),
  ('2026-05-08', 'Buckner FC',             'LSFA State League 2026/27 — Atlantic Conference WK3', 'POSTPONED',                                 'secondary', 'WK3', NULL),
  ('2026-05-12', 'Team 360',               'LSFA State League 2026/27 — Atlantic Conference WK4', 'Olufunke FA 2 - 4 Team360',                'danger',    'WK4', NULL),
  ('2026-05-20', 'Young Striker Fc',       'LSFA State League 2026/27 — Atlantic Conference',     'Young Striker 2 - 4 Olufunke FA',          'success',   'WK5', 'MARACANA FOOTBALL FIELD AJEGUNLE LAGOS');

-- ── Players (Spotlight) ───────────────────────────────────────
INSERT INTO public.players (name, position, age, goals, assists, matches, quote, image_path) VALUES
  ('Ejiogu Enoch Chibueze',    'Midfielder', 16, 5,  7, 12, 'My dream is to make OFA and Nigeria proud one day.',          'images/Ejiogu Chibueze.jpg'),
  ('Emmanuel Ajose',           'Forward',    18, 8,  8, 15, 'OFA taught me confidence, resilience, and teamwork.',         'images/Ajose Emmanuel.jpg'),
  ('Okpara Chidera Emmanuel',  'Forward',    17, 15, 4, 13, 'Every session at OFA makes me better, on and off the pitch.', 'images/Okpara Chidera.jpg');

-- ── Management Team ───────────────────────────────────────────
INSERT INTO public.management_team (name, role, email, sort_order) VALUES
  ('Adeshina Akintayo Peter',          'Founder & President',          'Olufunkefootballacademy@gmail.com', 1),
  ('Oluokun Olamilekan Olasunkanmi',   'Vice Chairman',                'Olufunkefootballacademy@gmail.com', 2),
  ('Olufemi Emmanuel Olugbodi',        'Sporting Director',            'Olufunkefootballacademy@gmail.com', 3),
  ('Udeme John Friday',                'Technical Adviser',            'Olufunkefootballacademy@gmail.com', 4),
  ('Ezeala Onyema Augustina',          'Team and Marketing Manager',   'Olufunkefootballacademy@gmail.com', 5);

-- ── Booking Packages ─────────────────────────────────────────
INSERT INTO public.booking_packages (name, description, price, duration, features, is_active) VALUES
  ('Starter',     'Perfect for beginners',                   50.00,  '1 month', '["2 sessions/week","Basic training","Kit included"]',                                                   TRUE),
  ('Pro Academy', 'Intermediate development programme',      120.00, '1 month', '["4 sessions/week","Tactical training","Video analysis","Nutrition guide"]',                            TRUE),
  ('Elite',       'Full professional pathway',               250.00, '1 month', '["Daily training","1-on-1 coaching","Match exposure","Scouting report"]',                               TRUE);

-- ── Quiz Week 1 ───────────────────────────────────────────────
INSERT INTO public.quiz_weeks (title, week_number, is_active)
VALUES ('Week 1 — Football Basics', 1, TRUE);

WITH week AS (SELECT id FROM public.quiz_weeks WHERE week_number = 1)
INSERT INTO public.quiz_questions (quiz_week_id, question_text)
SELECT week.id, q FROM week, (VALUES
  ('How many players are on a football team during a match?'),
  ('How long is a standard football match?'),
  ('What does the offside rule prevent?')
) AS questions(q);

WITH q1 AS (SELECT qq.id FROM public.quiz_questions qq JOIN public.quiz_weeks qw ON qq.quiz_week_id=qw.id WHERE qw.week_number=1 AND qq.question_text LIKE 'How many players%')
INSERT INTO public.quiz_options (question_id, option_text, is_correct)
SELECT q1.id, opt, ic FROM q1, (VALUES ('9',FALSE),('10',FALSE),('11',TRUE),('12',FALSE)) AS o(opt,ic);

WITH q2 AS (SELECT qq.id FROM public.quiz_questions qq JOIN public.quiz_weeks qw ON qq.quiz_week_id=qw.id WHERE qw.week_number=1 AND qq.question_text LIKE 'How long is%')
INSERT INTO public.quiz_options (question_id, option_text, is_correct)
SELECT q2.id, opt, ic FROM q2, (VALUES ('60 minutes',FALSE),('90 minutes',TRUE),('80 minutes',FALSE),('120 minutes',FALSE)) AS o(opt,ic);

WITH q3 AS (SELECT qq.id FROM public.quiz_questions qq JOIN public.quiz_weeks qw ON qq.quiz_week_id=qw.id WHERE qw.week_number=1 AND qq.question_text LIKE 'What does the offside%')
INSERT INTO public.quiz_options (question_id, option_text, is_correct)
SELECT q3.id, opt, ic FROM q3, (VALUES
  ('Goalkeepers from leaving their area',FALSE),
  ('Attackers gaining unfair positional advantage',TRUE),
  ('Defenders from fouling',FALSE),
  ('Players from taking free kicks',FALSE)
) AS o(opt,ic);
