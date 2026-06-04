-- ============================================================
-- OFA Academy — International Football Quiz Questions  v2
-- Week 2: 80 questions, 10 random per game, 5 min time limit
-- FIXED: No DO blocks, pure INSERT...SELECT syntax
-- Run AFTER seed.sql in Supabase SQL Editor
-- ============================================================

-- Clean up if already exists
DELETE FROM public.quiz_weeks WHERE week_number = 2;

-- Create Week 2
INSERT INTO public.quiz_weeks (title, description, theme, week_start, week_end, time_limit, is_active, week_number)
VALUES ('International Football IQ Challenge',
        'Test your world football knowledge — 80 questions, 10 random per game, 5 minutes!',
        'World Football', '2026-06-08', '2099-12-31', 300, TRUE, 2);

-- ── QUESTIONS ─────────────────────────────────────────────────
INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, "order")
SELECT w.id, v.q, v.d, v.cat, v.ord
FROM public.quiz_weeks w,
(VALUES
  -- World Cup (1-30)
  ('Who scored the fastest goal in World Cup history?',                       'hard',   'World Cup',        1),
  ('Which country has won the most FIFA World Cup titles?',                   'easy',   'World Cup',        2),
  ('In which year was the first FIFA World Cup held?',                        'medium', 'World Cup',        3),
  ('Who was the top scorer of the 2022 FIFA World Cup?',                      'medium', 'World Cup',        4),
  ('Which country hosted the 2018 FIFA World Cup?',                           'easy',   'World Cup',        5),
  ('Who scored the winning goal in the 2014 World Cup final?',                'hard',   'World Cup',        6),
  ('How many teams compete in the expanded FIFA World Cup from 2026?',        'easy',   'World Cup',        7),
  ('Which player has appeared in the most World Cup final tournaments?',      'hard',   'World Cup',        8),
  ('Who is the all-time top scorer in World Cup history?',                    'hard',   'World Cup',        9),
  ('Which country won the 2010 FIFA World Cup?',                              'easy',   'World Cup',       10),
  ('Who scored a hat-trick in the 2018 World Cup final?',                     'medium', 'World Cup',       11),
  ('What is the nickname of the Brazilian national team?',                    'easy',   'World Cup',       12),
  ('Who won the Golden Boot at the 2018 World Cup?',                          'medium', 'World Cup',       13),
  ('Which African country first reached the World Cup semi-finals?',          'hard',   'World Cup',       14),
  ('How many World Cups has Brazil won?',                                     'easy',   'World Cup',       15),
  ('Who hosted the 2002 World Cup jointly?',                                  'medium', 'World Cup',       16),
  ('Which player won the Golden Ball at the 2014 World Cup?',                 'medium', 'World Cup',       17),
  ('Which goalkeeper won the Golden Glove at the 2022 World Cup?',            'hard',   'World Cup',       18),
  ('Which team beat Germany 7-1 in the 2014 World Cup semi-final?',           'easy',   'World Cup',       19),
  ('Who won the 2022 FIFA World Cup?',                                        'easy',   'World Cup',       20),
  -- Champions League (21-40)
  ('Which club has won the most UEFA Champions League titles?',               'easy',   'Champions League',21),
  ('Which player has scored the most Champions League goals?',                'easy',   'Champions League',22),
  ('What was the Champions League called before 1992?',                       'medium', 'Champions League',23),
  ('Which team won the first Champions League title in 1992/93?',             'medium', 'Champions League',24),
  ('Who scored the winning goal in the 2019 Champions League final?',         'medium', 'Champions League',25),
  ('Which club won the treble including the Champions League in 1998/99?',    'medium', 'Champions League',26),
  ('Who scored a bicycle kick in the 2018 Champions League final?',           'medium', 'Champions League',27),
  ('Which English team won the 2012 Champions League?',                       'medium', 'Champions League',28),
  ('Which club did Lionel Messi win all his Champions League titles with?',   'easy',   'Champions League',29),
  ('Which club beat AC Milan in the 2005 Champions League final comeback?',   'medium', 'Champions League',30),
  ('Which team beat Barcelona 8-2 in the 2019/20 Champions League?',         'hard',   'Champions League',31),
  ('Who managed Liverpool to their 2019 Champions League victory?',           'medium', 'Champions League',32),
  ('How many Champions League titles has Real Madrid won as of 2024?',        'hard',   'Champions League',33),
  ('Who was the first African to score in a Champions League final?',         'hard',   'Champions League',34),
  ('Which goalkeeper has won the most Champions League titles?',              'hard',   'Champions League',35),
  -- Premier League (36-55)
  ('Which club has won the most Premier League titles?',                      'easy',   'Premier League',  36),
  ('Who scored the most Premier League goals in a single season?',            'medium', 'Premier League',  37),
  ('In which year was the Premier League founded?',                           'medium', 'Premier League',  38),
  ('Who is the Premier League all-time top scorer?',                          'easy',   'Premier League',  39),
  ('Which team went unbeaten for a full Premier League season?',              'medium', 'Premier League',  40),
  ('Who manages Manchester City?',                                            'easy',   'Premier League',  41),
  ('How many clubs have won the Premier League?',                             'medium', 'Premier League',  42),
  ('Who scored the fastest Premier League hat-trick?',                        'hard',   'Premier League',  43),
  ('Which goalkeeper has kept the most Premier League clean sheets?',         'hard',   'Premier League',  44),
  ('Who won the first ever Premier League title?',                            'medium', 'Premier League',  45),
  ('Which player has made the most Premier League appearances?',              'hard',   'Premier League',  46),
  ('Who is the youngest ever Premier League player?',                         'hard',   'Premier League',  47),
  ('Which Premier League club plays at the Etihad Stadium?',                  'easy',   'Premier League',  48),
  ('How many points did Man City win the title with in 2017/18?',             'hard',   'Premier League',  49),
  ('Which club was known as The Invincibles?',                                'easy',   'Premier League',  50),
  -- La Liga and Spain (51-65)
  ('Which Spanish club has won the most La Liga titles?',                     'easy',   'La Liga',         51),
  ('Who is La Liga all-time top scorer?',                                     'easy',   'La Liga',         52),
  ('Which Spanish club plays at the Bernabeu?',                               'easy',   'La Liga',         53),
  ('Which La Liga club plays at the Wanda Metropolitano?',                    'medium', 'La Liga',         54),
  ('Who has the most La Liga goals in a single season?',                      'hard',   'La Liga',         55),
  -- African Football (56-65)
  ('Which country has won the most Africa Cup of Nations titles?',            'medium', 'Africa',          56),
  ('Who is Nigeria Super Eagles all-time top scorer?',                        'hard',   'Africa',          57),
  ('Which year did Nigeria win the Olympic Gold medal in football?',          'medium', 'Africa',          58),
  ('Which African club is the most successful in CAF Champions League?',      'hard',   'Africa',          59),
  ('Which country did Jay-Jay Okocha play for?',                              'easy',   'Africa',          60),
  -- General Knowledge (61-80)
  ('Who has won the most Ballon d''Or awards?',                               'medium', 'General',         61),
  ('What is the maximum number of substitutes allowed in a modern match?',    'medium', 'General',         62),
  ('Which club is known as The Red Devils?',                                   'easy',   'General',         63),
  ('Who scored the famous Hand of God goal in the 1986 World Cup?',           'easy',   'General',         64),
  ('Which country does Erling Haaland play for?',                             'easy',   'General',         65),
  ('What does VAR stand for in football?',                                    'easy',   'General',         66),
  ('Which player is nicknamed The Egyptian King?',                            'medium', 'General',         67),
  ('Who scored a hat-trick on their debut for Barcelona?',                    'hard',   'General',         68),
  ('Which club plays home games at Anfield?',                                 'easy',   'General',         69),
  ('What colour card results in a player being sent off?',                    'easy',   'General',         70),
  ('Which country won Euro 2020 (played in 2021)?',                           'medium', 'General',         71),
  ('Who was the first player to win 8 Ballon d''Or awards?',                  'medium', 'General',         72),
  ('What is the offside rule?',                                               'medium', 'General',         73),
  ('Which Nigerian player plays for Liverpool?',                              'medium', 'General',         74),
  ('How long is a standard football match?',                                  'easy',   'General',         75),
  ('Which country invented football (association football)?',                 'easy',   'General',         76),
  ('What does FIFA stand for?',                                               'medium', 'General',         77),
  ('Who won the 2023 FIFA Women''s World Cup?',                               'medium', 'General',         78),
  ('Which club has Kylian Mbappe joined permanently after PSG?',              'medium', 'General',         79),
  ('How many players are in a football team during a match?',                 'easy',   'General',         80)
) AS v(q, d, cat, ord)
WHERE w.week_number = 2;

-- ── OPTIONS: Insert all options for all 80 questions ──────────
-- Each question gets 4 options. We join by quiz_week_id and order.

-- Q1: Fastest WC goal
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Hakan Sukur (11 seconds)',TRUE,1),('Clint Dempsey (30 seconds)',FALSE,2),('Ronaldo (2 min)',FALSE,3),('Wayne Rooney (90 sec)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=1;

-- Q2: Most WC wins
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Brazil',TRUE,1),('Germany',FALSE,2),('Italy',FALSE,3),('Argentina',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=2;

-- Q3: First WC year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('1930',TRUE,1),('1934',FALSE,2),('1926',FALSE,3),('1950',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=3;

-- Q4: 2022 top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Kylian Mbappe',TRUE,1),('Lionel Messi',FALSE,2),('Olivier Giroud',FALSE,3),('Richarlison',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=4;

-- Q5: 2018 host
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Russia',TRUE,1),('Qatar',FALSE,2),('Brazil',FALSE,3),('Germany',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=5;

-- Q6: 2014 final goal
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Mario Gotze',TRUE,1),('Thomas Muller',FALSE,2),('Miroslav Klose',FALSE,3),('Mesut Ozil',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=6;

-- Q7: Expanded WC teams
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('48',TRUE,1),('32',FALSE,2),('24',FALSE,3),('64',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=7;

-- Q8: Most WC final appearances
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Cafu',TRUE,1),('Pele',FALSE,2),('Paolo Maldini',FALSE,3),('Ronaldo',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=8;

-- Q9: All-time WC top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Miroslav Klose (16)',TRUE,1),('Ronaldo (15)',FALSE,2),('Gerd Muller (14)',FALSE,3),('Pele (12)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=9;

-- Q10: 2010 winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Spain',TRUE,1),('Netherlands',FALSE,2),('Germany',FALSE,3),('Argentina',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=10;

-- Q11: 2018 hat-trick
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Kylian Mbappe',TRUE,1),('Antoine Griezmann',FALSE,2),('Olivier Giroud',FALSE,3),('Ivan Perisic',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=11;

-- Q12: Brazil nickname
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Selecao',TRUE,1),('Azzurri',FALSE,2),('Les Bleus',FALSE,3),('Die Mannschaft',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=12;

-- Q13: 2018 Golden Boot
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Harry Kane',TRUE,1),('Kylian Mbappe',FALSE,2),('Cristiano Ronaldo',FALSE,3),('Antoine Griezmann',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=13;

-- Q14: First African WC semi
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Morocco (2022)',TRUE,1),('Cameroon (1990)',FALSE,2),('Senegal (2002)',FALSE,3),('Nigeria (1994)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=14;

-- Q15: Brazil WC wins
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('5',TRUE,1),('4',FALSE,2),('6',FALSE,3),('3',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=15;

-- Q16: 2002 hosts
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('South Korea and Japan',TRUE,1),('China and Japan',FALSE,2),('South Korea and China',FALSE,3),('Japan and Australia',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=16;

-- Q17: 2014 Golden Ball
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Lionel Messi',TRUE,1),('Thomas Muller',FALSE,2),('James Rodriguez',FALSE,3),('Manuel Neuer',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=17;

-- Q18: 2022 Golden Glove
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Emiliano Martinez',TRUE,1),('Hugo Lloris',FALSE,2),('Yassine Bounou',FALSE,3),('Dominik Livakovic',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=18;

-- Q19: 7-1 loser
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Brazil',TRUE,1),('Argentina',FALSE,2),('France',FALSE,3),('Spain',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=19;

-- Q20: 2022 winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Argentina',TRUE,1),('France',FALSE,2),('Morocco',FALSE,3),('Brazil',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=20;

-- Q21: Most UCL titles
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Real Madrid',TRUE,1),('AC Milan',FALSE,2),('Bayern Munich',FALSE,3),('Barcelona',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=21;

-- Q22: UCL top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Cristiano Ronaldo',TRUE,1),('Lionel Messi',FALSE,2),('Robert Lewandowski',FALSE,3),('Raul',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=22;

-- Q23: Former UCL name
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('European Cup',TRUE,1),('UEFA Cup',FALSE,2),('Continental Cup',FALSE,3),('European Super Cup',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=23;

-- Q24: First UCL winner 1992/93
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Marseille',TRUE,1),('AC Milan',FALSE,2),('Barcelona',FALSE,3),('Ajax',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=24;

-- Q25: 2019 UCL final goal
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Divock Origi',TRUE,1),('Mohamed Salah',FALSE,2),('Sadio Mane',FALSE,3),('Roberto Firmino',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=25;

-- Q26: Treble 1998/99
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Manchester United',TRUE,1),('Real Madrid',FALSE,2),('Bayern Munich',FALSE,3),('Barcelona',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=26;

-- Q27: Bicycle kick 2018 UCL final
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Gareth Bale',TRUE,1),('Cristiano Ronaldo',FALSE,2),('Karim Benzema',FALSE,3),('Marco Asensio',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=27;

-- Q28: 2012 UCL English winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Chelsea',TRUE,1),('Arsenal',FALSE,2),('Manchester City',FALSE,3),('Liverpool',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=28;

-- Q29: Messi UCL clubs
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Barcelona',TRUE,1),('PSG and Barcelona',FALSE,2),('Inter Miami and Barcelona',FALSE,3),('Bayern Munich',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=29;

-- Q30: 2005 Istanbul comeback
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Liverpool',TRUE,1),('Chelsea',FALSE,2),('Manchester United',FALSE,3),('Arsenal',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=30;

-- Q31: Barca 8-2 loss
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Bayern Munich',TRUE,1),('Chelsea',FALSE,2),('Liverpool',FALSE,3),('Real Madrid',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=31;

-- Q32: Liverpool 2019 manager
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Jurgen Klopp',TRUE,1),('Brendan Rodgers',FALSE,2),('Rafael Benitez',FALSE,3),('Roy Hodgson',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=32;

-- Q33: Real Madrid UCL titles 2024
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('15',TRUE,1),('13',FALSE,2),('14',FALSE,3),('12',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=33;

-- Q34: First African UCL final scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Didier Drogba',TRUE,1),('Sadio Mane',FALSE,2),('Samuel Etoo',FALSE,3),('Michael Essien',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=34;

-- Q35: Most UCL titles GK
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Iker Casillas',TRUE,1),('Gianluigi Buffon',FALSE,2),('Peter Schmeichel',FALSE,3),('Thibaut Courtois',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=35;

-- Q36: Most PL titles
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Manchester United (13)',TRUE,1),('Manchester City (9)',FALSE,2),('Arsenal (3)',FALSE,3),('Chelsea (5)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=36;

-- Q37: Most PL goals season
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Erling Haaland (36)',TRUE,1),('Andrew Cole (34)',FALSE,2),('Alan Shearer (31)',FALSE,3),('Luis Suarez (31)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=37;

-- Q38: PL founding year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('1992',TRUE,1),('1990',FALSE,2),('1995',FALSE,3),('1988',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=38;

-- Q39: PL all-time scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Alan Shearer (260)',TRUE,1),('Wayne Rooney (208)',FALSE,2),('Andrew Cole (187)',FALSE,3),('Frank Lampard (177)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=39;

-- Q40: Invincibles season
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Arsenal 2003/04',TRUE,1),('Man United 1998/99',FALSE,2),('Chelsea 2004/05',FALSE,3),('Man City 2017/18',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=40;

-- Q41: Man City manager
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Pep Guardiola',TRUE,1),('Jurgen Klopp',FALSE,2),('Erik ten Hag',FALSE,3),('Antonio Conte',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=41;

-- Q42: PL title winners count
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('7',TRUE,1),('5',FALSE,2),('8',FALSE,3),('6',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=42;

-- Q43: Fastest PL hat-trick
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Sadio Mane (2 min 56 sec)',TRUE,1),('Robbie Fowler (4 min 33 sec)',FALSE,2),('Erling Haaland (6 min)',FALSE,3),('Graham Alexander (5 min)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=43;

-- Q44: Most PL clean sheets GK
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Petr Cech',TRUE,1),('David Seaman',FALSE,2),('Edwin van der Sar',FALSE,3),('David James',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=44;

-- Q45: First PL title
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Manchester United',TRUE,1),('Blackburn Rovers',FALSE,2),('Arsenal',FALSE,3),('Liverpool',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=45;

-- Q46: Most PL appearances
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Gareth Barry (653)',TRUE,1),('Ryan Giggs (632)',FALSE,2),('James Milner (627)',FALSE,3),('Frank Lampard (609)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=46;

-- Q47: Youngest PL player
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Ethan Nwaneri (15 years 181 days)',TRUE,1),('Cesc Fabregas (16 years)',FALSE,2),('Jack Wilshere (16 years)',FALSE,3),('Phil Foden (17 years)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=47;

-- Q48: Etihad club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Manchester City',TRUE,1),('Manchester United',FALSE,2),('Arsenal',FALSE,3),('Tottenham',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=48;

-- Q49: Man City 2017/18 points
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('100',TRUE,1),('98',FALSE,2),('95',FALSE,3),('93',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=49;

-- Q50: Invincibles club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Arsenal',TRUE,1),('Manchester United',FALSE,2),('Chelsea',FALSE,3),('Liverpool',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=50;

-- Q51: Most La Liga titles
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Real Madrid',TRUE,1),('Barcelona',FALSE,2),('Atletico Madrid',FALSE,3),('Athletic Bilbao',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=51;

-- Q52: La Liga top scorer all time
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Lionel Messi',TRUE,1),('Cristiano Ronaldo',FALSE,2),('Hugo Sanchez',FALSE,3),('Raul',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=52;

-- Q53: Bernabeu club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Real Madrid',TRUE,1),('Barcelona',FALSE,2),('Atletico Madrid',FALSE,3),('Sevilla',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=53;

-- Q54: Wanda Metropolitano
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Atletico Madrid',TRUE,1),('Real Madrid',FALSE,2),('Getafe',FALSE,3),('Rayo Vallecano',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=54;

-- Q55: Most La Liga goals season
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Lionel Messi (50 goals 2011/12)',TRUE,1),('Cristiano Ronaldo (48)',FALSE,2),('Telmo Zarra (38)',FALSE,3),('Hugo Sanchez (38)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=55;

-- Q56: Most AFCON wins
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Egypt (8 titles)',TRUE,1),('Ghana (4 titles)',FALSE,2),('Cameroon (5 titles)',FALSE,3),('Nigeria (3 titles)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=56;

-- Q57: Nigeria Super Eagles top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Rashidi Yekini',TRUE,1),('Jay-Jay Okocha',FALSE,2),('Nwankwo Kanu',FALSE,3),('Victor Osimhen',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=57;

-- Q58: Nigeria Olympic Gold year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('1996',TRUE,1),('2000',FALSE,2),('1992',FALSE,3),('1988',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=58;

-- Q59: Most CAF Champions League
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Al Ahly (Egypt)',TRUE,1),('TP Mazembe (DRC)',FALSE,2),('Zamalek (Egypt)',FALSE,3),('Wydad Casablanca (Morocco)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=59;

-- Q60: Okocha country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Nigeria',TRUE,1),('Ghana',FALSE,2),('Cameroon',FALSE,3),('Ivory Coast',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=60;

-- Q61: Most Ballon d'Or
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Lionel Messi (8)',TRUE,1),('Cristiano Ronaldo (5)',FALSE,2),('Johan Cruyff (3)',FALSE,3),('Zinedine Zidane (1)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=61;

-- Q62: Max substitutes modern
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('5',TRUE,1),('3',FALSE,2),('6',FALSE,3),('4',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=62;

-- Q63: Red Devils
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Manchester United',TRUE,1),('Arsenal',FALSE,2),('Liverpool',FALSE,3),('Chelsea',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=63;

-- Q64: Hand of God
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Diego Maradona',TRUE,1),('Pele',FALSE,2),('Ronaldinho',FALSE,3),('Zinedine Zidane',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=64;

-- Q65: Haaland country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Norway',TRUE,1),('Sweden',FALSE,2),('Denmark',FALSE,3),('Iceland',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=65;

-- Q66: VAR meaning
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Video Assistant Referee',TRUE,1),('Video Analysis Review',FALSE,2),('Virtual Assistant Referee',FALSE,3),('Video Action Review',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=66;

-- Q67: Egyptian King
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Mohamed Salah',TRUE,1),('Omar Marmoush',FALSE,2),('Mostafa Mohamed',FALSE,3),('Trezeguet',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=67;

-- Q68: Hat-trick on Barca debut
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Ronaldinho',FALSE,1),('Thierry Henry',FALSE,2),('Zlatan Ibrahimovic',TRUE,3),('Samuel Etoo',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=68;

-- Q69: Anfield club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Liverpool',TRUE,1),('Everton',FALSE,2),('Manchester City',FALSE,3),('Arsenal',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=69;

-- Q70: Send off card
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Red card',TRUE,1),('Yellow card',FALSE,2),('Blue card',FALSE,3),('Orange card',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=70;

-- Q71: Euro 2020 winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Italy',TRUE,1),('England',FALSE,2),('Spain',FALSE,3),('France',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=71;

-- Q72: 8 Ballon d'Or winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Lionel Messi',TRUE,1),('Cristiano Ronaldo',FALSE,2),('Zinedine Zidane',FALSE,3),('Ronaldo (Brazil)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=72;

-- Q73: Offside rule
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('A player is offside if they are closer to the opponents goal line than both the ball and the second-to-last opponent when the ball is played',TRUE,1),('A player is offside if they cross the halfway line',FALSE,2),('A player is offside if they are behind the ball when it is played',FALSE,3),('A player is offside if they are in the opponents half',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=73;

-- Q74: Nigerian Liverpool player
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Taiwo Awoniyi',FALSE,1),('Alex Iwobi',FALSE,2),('Victor Moses',FALSE,3),('Cody Gakpo',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=74;

-- Q75: Match length
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('90 minutes',TRUE,1),('80 minutes',FALSE,2),('100 minutes',FALSE,3),('60 minutes',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=75;

-- Q76: Football inventor country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('England',TRUE,1),('Scotland',FALSE,2),('Brazil',FALSE,3),('France',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=76;

-- Q77: FIFA meaning
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Federation Internationale de Football Association',TRUE,1),('Football International Federation Association',FALSE,2),('Federation of International Football Associations',FALSE,3),('International Federation of Football Associations',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=77;

-- Q78: 2023 Women's WC winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Spain',TRUE,1),('England',FALSE,2),('USA',FALSE,3),('Australia',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=78;

-- Q79: Mbappe after PSG
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('Real Madrid',TRUE,1),('Manchester City',FALSE,2),('Bayern Munich',FALSE,3),('Liverpool',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=79;

-- Q80: Players in a match
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id, o.opt, o.ic, o.ord FROM public.quiz_questions q,
(VALUES ('11',TRUE,1),('10',FALSE,2),('12',FALSE,3),('9',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=2) AND q."order"=80;
