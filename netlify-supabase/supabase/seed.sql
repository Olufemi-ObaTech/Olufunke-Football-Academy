-- ============================================================
-- Supabase Seed — OFA Academy  (mirrors AcademySeeder.php exactly)
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
  ('2026-05-12', 'Team 360',               'LSFA State League 2026/27 — Atlantic Conference WK4', 'Olufunke FA 2 - 4 Team360',                 'danger',    'WK4', NULL),
  ('2026-05-20', 'Young Striker Fc',       'LSFA State League 2026/27 — Atlantic Conference',     'Young Striker 2 - 4 Olufunke FA',           'success',   'WK5', 'MARACANA FOOTBALL FIELD AJEGUNLE LAGOS');

-- ── Players (Spotlight) ───────────────────────────────────────
INSERT INTO public.players (name, position, age, goals, assists, matches, quote, image_path) VALUES
  ('Ejiogu Enoch Chibueze',   'Midfielder', 16, 5,  7, 12, 'My dream is to make OFA and Nigeria proud one day.',          'images/Ejiogu Chibueze.jpg'),
  ('Emmanuel Ajose',          'Forward',    18, 8,  8, 15, 'OFA taught me confidence, resilience, and teamwork.',         'images/Ajose Emmanuel.jpg'),
  ('Okpara Chidera Emmanuel', 'Forward',    17, 15, 4, 13, 'Every session at OFA makes me better, on and off the pitch.', 'images/Okpara Chidera.jpg');

-- ── Management Team ───────────────────────────────────────────
INSERT INTO public.management_team (name, role, email, sort_order) VALUES
  ('Adeshina Akintayo Peter',          'Founder & President',        'Olufunkefootballacademy@gmail.com', 1),
  ('Oluokun Olamilekan Olasunkanmi',   'Vice Chairman',              'Olufunkefootballacademy@gmail.com', 2),
  ('Olufemi Emmanuel Olugbodi',        'Sporting Director',          'Olufunkefootballacademy@gmail.com', 3),
  ('Udeme John Friday',                'Technical Adviser',          'Olufunkefootballacademy@gmail.com', 4),
  ('Ezeala Onyema Augustina',          'Team and Marketing Manager', 'Olufunkefootballacademy@gmail.com', 5);

-- ── Latest News Posts ─────────────────────────────────────────
INSERT INTO public.posts (title, content, image_path, type) VALUES
  ('Olufunke FA Crowned Champions of Lagos State Divisional Football Association Under‑17 Tournament!',
   'Olufunke Football Academy has been crowned champions of the Lagos State Divisional Football Association Under‑17 Tournament, finishing the competition unbeaten. This remarkable achievement is a testament to the Academy''s unwavering commitment to excellence, discipline, and youth development. Throughout the tournament, our players demonstrated exceptional skill, teamwork, and resilience — qualities that reflect the core values of Olufunke FA. This victory not only highlights the rising talent within our ranks but also reinforces our position as one of the leading grassroots football academies in Lagos State.',
   'images/cele3.jpg', 'latest'),
  ('Olufunke Football Academy U19 – Registration Now Open!',
   'This season, we''ll be competing in the prestigious Lagos State U19 League, showcasing the best of our young talent on a competitive stage. We are inviting good, young, and talented players who are passionate about football and ready to grow into future stars. If you have the skill, drive, and commitment, this is your chance to join a winning team. 📞 Contact Us — Phone: 09079917993 | Email: Olufunkefootballacademy@gmail.com',
   'images/OFA-Registration.jpg', 'latest'),
  ('Olufunke FA Presents Championship Trophy to Ajeromi-Ifelodun LGA Chairman',
   'Olufunke Football Academy proudly presented the championship trophy to the Chairman of Ajeromi-Ifelodun Local Government in recognition of their triumphant victory at the Lagos State Divisional Football Association Under‑17 Tournament. This symbolic gesture not only celebrates the team''s outstanding achievement on the pitch but also underscores OFA''s commitment to fostering youth talent, discipline, and community pride.',
   'images/chairman-ajeromi.jpg', 'latest');

-- ── Match Reports ─────────────────────────────────────────────
INSERT INTO public.posts (title, content, image_path, type) VALUES
  ('Match Report: OFA 2 – 2 Ikorodu City (4-2 Pens) — Lagos State League Final',
   'A thrilling final at Mobolaji Johnson Arena Onikan saw Olufunke FA hold their nerve in a penalty shootout to be crowned Lagos State League champions. After a 2-2 draw in normal time, the boys converted all four penalties to seal a historic victory.',
   'images/cele1.jpg', 'report'),
  ('Match Report: OFA 2 – 0 Ayicrip Nelis FA — Lagos State League Semi-Final (1st Leg)',
   'Olufunke FA delivered a commanding performance in the semi-final first leg, winning 2-0 against Ayicrip Nelis FA. The team showed great tactical discipline and clinical finishing to secure a comfortable advantage heading into the second leg.',
   'images/cele2.jpg', 'report');

-- ── Media Highlights ─────────────────────────────────────────
INSERT INTO public.posts (title, content, image_path, type, meta_link) VALUES
  ('Highlights: OFA vs. Ikorodu City — Lagos State League Final',
   'Watch the goals and crucial match-winning moments from the Lagos State League Final on our YouTube channel.',
   'images/celeCoach.jpg', 'media', 'https://www.youtube.com/@olufunkefootballacademy'),
  ('Champions Celebration — Olufunke FA U17 Trophy Presentation',
   'Relive the incredible trophy presentation ceremony as Olufunke FA celebrated their Under-17 championship title with the Ajeromi-Ifelodun LGA Chairman.',
   'images/cele3.jpg', 'media', 'https://www.youtube.com/@olufunkefootballacademy');

-- ── Store Products ────────────────────────────────────────────
INSERT INTO public.products (name, description, price, image_path, category, available) VALUES
  ('OFA Merchandise',      'Official match ball used in training and merchandise.',                        6000,  'images/OFA  Merchandise.jpg',      'merchandise', TRUE),
  ('OFA Home Jersey',      'Premium quality, breathable fabric.',                                         12000, 'images/OFA Jersey.jpg',            'merchandise', TRUE),
  ('Training Kit',         'Includes shorts, socks, and training shirt.',                                 8500,  'images/OFA Training Kit.jpg',      'merchandise', TRUE),
  ('OFA Tracksuit',        'Premium quality, breathable fabric.',                                         15000, 'images/OFA Tracksuit.jpg',         'merchandise', TRUE),
  ('OFA Polo Shirt',       'Casual wear with OFA badge. Includes shorts and socks.',                      10500, 'images/OFA merchandise.jpg',       'merchandise', TRUE),
  ('Red OFA Hoodie',       'Fleece hoodie with large OFA print.',                                         16000, 'images/Red Hoodie.jpg',            'merchandise', TRUE),
  ('OFA Sport Wrist Watch','Premium quality. Digital display with bold time, date, and mode indicators.', 21000, 'images/OFA Sport Wristwatch.jpg',  'merchandise', TRUE),
  ('OFA Water Bottle',     'Elite hydration gear. Leak-proof lid with flip-up spout and curved handle.',  9500,  'images/OFA Water Bottle.jpg',      'merchandise', TRUE),
  ('Blue OFA Hoodie',      'Fleece hoodie with large OFA print.',                                         16000, 'images/Blue Hoodie.jpg',           'merchandise', TRUE);

-- ── Booking Packages ─────────────────────────────────────────
INSERT INTO public.booking_packages (name, description, price, duration, is_active) VALUES
  ('Trial Session',            'A single trial session to assess your skill level and meet our coaching team. Open to all age groups.',                                                  2000,  '1 Day',       TRUE),
  ('Monthly Training Package', 'Full month of structured training sessions — technical drills, tactical sessions, and fitness conditioning.',                                            15000, '4 Weeks',     TRUE),
  ('Academy Full Season',      'Complete season enrollment including league participation, kit, health education, and community programs.',                                              50000, 'Full Season', TRUE);

-- ── E-Learning Courses ────────────────────────────────────────
INSERT INTO public.courses (title, description, image_path, category, cta_label, is_published) VALUES
  ('Football Education',        'Learn rules, ethics, leadership, and teamwork through interactive lessons and video analysis. Build the mental and social foundations of a complete footballer.',                    'images/Football Edu.jpg',       'education',   'Start Learning',   TRUE),
  ('Technical Training',        'Master ball control, passing, shooting, and tactical awareness with expert-led sessions. Structured modules for every skill level.',                                               'images/Technical Training.jpg', 'technical',   'Explore Modules',  TRUE),
  ('Sports Psychology',         'Build mental resilience, focus, and emotional intelligence for peak performance. Learn how elite athletes think and compete under pressure.',                                       'images/Sports Psychology.jpg',  'psychology',  'View Lessons',     TRUE),
  ('Health Education',          'Nutrition, mental health, and injury prevention counseling led by certified professionals. Fuel your body and protect your career.',                                               'images/OFA 1.jpg',              'health',      'Start Module',     TRUE),
  ('Environmental Initiatives', 'Sustainability and stewardship of local playing fields, environments, and respect towards other players and teams. Every grassroots player has a role to play.',                  'images/cele3.jpg',              'environment', 'Learn More',       TRUE),
  ('Community Engagement',      'Volunteering, mentorship, and outreach programs that foster inclusivity and a culture of giving back. Football as a force for community change.',                                 'images/chairman-ajeromi.jpg',   'community',   'Get Involved',     TRUE);

-- ── Quiz Week 1 ───────────────────────────────────────────────
INSERT INTO public.quiz_weeks (title, description, theme, week_start, week_end, time_limit, is_active)
VALUES ('Week 1 — Football Basics', 'Test your basic football knowledge', 'Basics', '2026-06-01', '2026-06-07', 600, TRUE);

WITH week AS (SELECT id FROM public.quiz_weeks WHERE title = 'Week 1 — Football Basics' LIMIT 1)
INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, "order")
SELECT week.id, q, d, cat, ord FROM week, (VALUES
  ('How many players are on a football team during a match?',  'easy',   'rules',   1),
  ('How long is a standard football match?',                   'easy',   'rules',   2),
  ('What does the offside rule prevent?',                      'medium', 'tactics', 3),
  ('Which country won the 2022 FIFA World Cup?',               'easy',   'history', 4),
  ('How many substitutions are allowed per team in a match?',  'medium', 'rules',   5),
  ('What is the diameter of a standard football goal?',        'hard',   'rules',   6),
  ('Which club has won the most UEFA Champions League titles?','medium', 'history', 7),
  ('What is a hat-trick in football?',                         'easy',   'rules',   8),
  ('Who invented the offside trap?',                           'hard',   'tactics', 9),
  ('How long is each half in extra time?',                     'medium', 'rules',   10)
) AS q(q, d, cat, ord);

-- Options Q1
WITH q1 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'How many players%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q1.id, opt, ic, ord FROM q1, (VALUES ('9',FALSE,1),('10',FALSE,2),('11',TRUE,3),('12',FALSE,4)) AS o(opt,ic,ord);

-- Options Q2
WITH q2 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'How long is a standard%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q2.id, opt, ic, ord FROM q2, (VALUES ('60 minutes',FALSE,1),('90 minutes',TRUE,2),('80 minutes',FALSE,3),('120 minutes',FALSE,4)) AS o(opt,ic,ord);

-- Options Q3
WITH q3 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'What does the offside%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q3.id, opt, ic, ord FROM q3, (VALUES
  ('Goalkeepers leaving their area',FALSE,1),
  ('Attackers gaining unfair positional advantage',TRUE,2),
  ('Defenders from fouling',FALSE,3),
  ('Players taking free kicks',FALSE,4)) AS o(opt,ic,ord);

-- Options Q4
WITH q4 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'Which country won the 2022%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q4.id, opt, ic, ord FROM q4, (VALUES ('France',FALSE,1),('Brazil',FALSE,2),('Argentina',TRUE,3),('England',FALSE,4)) AS o(opt,ic,ord);

-- Options Q5
WITH q5 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'How many substitutions%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q5.id, opt, ic, ord FROM q5, (VALUES ('3',FALSE,1),('4',FALSE,2),('5',TRUE,3),('6',FALSE,4)) AS o(opt,ic,ord);

-- Options Q6
WITH q6 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'What is the diameter%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q6.id, opt, ic, ord FROM q6, (VALUES ('6.4m',FALSE,1),('7.32m',TRUE,2),('8.0m',FALSE,3),('9.0m',FALSE,4)) AS o(opt,ic,ord);

-- Options Q7
WITH q7 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'Which club has won the most%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q7.id, opt, ic, ord FROM q7, (VALUES ('Barcelona',FALSE,1),('Real Madrid',TRUE,2),('Bayern Munich',FALSE,3),('AC Milan',FALSE,4)) AS o(opt,ic,ord);

-- Options Q8
WITH q8 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'What is a hat-trick%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q8.id, opt, ic, ord FROM q8, (VALUES ('Two goals in one game',FALSE,1),('Three goals in one game',TRUE,2),('Four goals in one game',FALSE,3),('Scoring in three consecutive games',FALSE,4)) AS o(opt,ic,ord);

-- Options Q9
WITH q9 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'Who invented the offside trap%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q9.id, opt, ic, ord FROM q9, (VALUES ('Sir Alex Ferguson',FALSE,1),('Arsène Wenger',FALSE,2),('Herbert Chapman',TRUE,3),('Brian Clough',FALSE,4)) AS o(opt,ic,ord);

-- Options Q10
WITH q10 AS (SELECT id FROM public.quiz_questions WHERE question LIKE 'How long is each half in extra time%' LIMIT 1)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q10.id, opt, ic, ord FROM q10, (VALUES ('10 minutes',FALSE,1),('15 minutes',TRUE,2),('20 minutes',FALSE,3),('30 minutes',FALSE,4)) AS o(opt,ic,ord);
