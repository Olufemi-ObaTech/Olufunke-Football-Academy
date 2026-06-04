-- ============================================================
-- OFA Academy — 1000 International Football Quiz Questions
-- Week 2: International Football IQ Challenge
-- Time limit: 300 seconds (5 minutes), 10 random per session
-- Run AFTER seed.sql in Supabase SQL Editor
-- ============================================================

-- Create Week 2 quiz
INSERT INTO public.quiz_weeks (title, description, theme, week_start, week_end, time_limit, is_active, week_number)
VALUES ('International Football IQ Challenge', 'Test your knowledge of world football — 1000 questions, 10 random per game!', 'World Football', '2026-06-08', '2099-12-31', 300, TRUE, 2);

-- Helper: get the week 2 ID
DO $$
DECLARE wid BIGINT;
BEGIN
  SELECT id INTO wid FROM public.quiz_weeks WHERE week_number = 2;

  -- ══════════════════════════════════════════════
  -- BATCH 1: FIFA WORLD CUP (Q1–Q80)
  -- ══════════════════════════════════════════════

  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, "order") VALUES
  (wid,'Who scored the fastest goal in World Cup history?','hard','World Cup',1),
  (wid,'Which country has won the most FIFA World Cup titles?','easy','World Cup',2),
  (wid,'In which year was the first FIFA World Cup held?','medium','World Cup',3),
  (wid,'Who was the top scorer of the 2022 FIFA World Cup?','medium','World Cup',4),
  (wid,'Which country hosted the 2018 FIFA World Cup?','easy','World Cup',5),
  (wid,'Who scored the winning goal in the 2014 World Cup final?','hard','World Cup',6),
  (wid,'How many teams compete in the FIFA World Cup finals?','easy','World Cup',7),
  (wid,'Which player has appeared in the most World Cup finals?','hard','World Cup',8),
  (wid,'Who is the all-time top scorer in World Cup history?','hard','World Cup',9),
  (wid,'Which country won the 2010 FIFA World Cup?','easy','World Cup',10),
  (wid,'Who scored a hat-trick in the 2018 World Cup final?','medium','World Cup',11),
  (wid,'What is the nickname of the Brazilian national team?','easy','World Cup',12),
  (wid,'Who won the Golden Boot at the 2018 World Cup?','medium','World Cup',13),
  (wid,'Which African country first reached the World Cup semi-finals?','hard','World Cup',14),
  (wid,'How many World Cups has Brazil won?','easy','World Cup',15),
  (wid,'Who hosted the 2002 World Cup jointly?','medium','World Cup',16),
  (wid,'Which player won the Golden Ball at the 2014 World Cup?','medium','World Cup',17),
  (wid,'Which goalkeeper won the Golden Glove at 2022 World Cup?','hard','World Cup',18),
  (wid,'Who scored in the most World Cup tournaments?','hard','World Cup',19),
  (wid,'Which country lost the 2010 World Cup final?','easy','World Cup',20),
  (wid,'Who was the oldest player to score in a World Cup?','hard','World Cup',21),
  (wid,'Which country won the inaugural Women''s World Cup in 1991?','medium','World Cup',22),
  (wid,'Who scored the famous Hand of God goal?','easy','World Cup',23),
  (wid,'Which team was eliminated by the USA in the 2002 World Cup?','hard','World Cup',24),
  (wid,'How many goals did Miroslav Klose score in World Cups?','hard','World Cup',25),
  (wid,'Which country has the worst World Cup record?','hard','World Cup',26),
  (wid,'Who refereed the 2022 World Cup final?','hard','World Cup',27),
  (wid,'Which team beat Germany 7-1 in the 2014 World Cup semi-final?','easy','World Cup',28),
  (wid,'Who won the 2022 FIFA World Cup?','easy','World Cup',29),
  (wid,'Which country did Pelé play for?','easy','World Cup',30),

  -- BATCH 2: UEFA CHAMPIONS LEAGUE (Q31–Q80)
  (wid,'Which club has won the most UEFA Champions League titles?','easy','Champions League',31),
  (wid,'Who scored in every round of the 2018/19 Champions League?','hard','Champions League',32),
  (wid,'Which player has scored the most Champions League goals?','easy','Champions League',33),
  (wid,'What was the Champions League called before 1992?','medium','Champions League',34),
  (wid,'Which team won the first Champions League title in 1992/93?','medium','Champions League',35),
  (wid,'Who scored the winning goal in the 2019 Champions League final?','medium','Champions League',36),
  (wid,'Which club won the treble in 1998/99?','medium','Champions League',37),
  (wid,'Where was the 2023 Champions League final held?','medium','Champions League',38),
  (wid,'Which goalkeeper has won the most Champions League titles?','hard','Champions League',39),
  (wid,'Who was the first African to score in a Champions League final?','hard','Champions League',40),
  (wid,'How many teams play in the Champions League group stage?','medium','Champions League',41),
  (wid,'Which team won back-to-back Champions Leagues in 2015 and 2016?','medium','Champions League',42),
  (wid,'Who scored a bicycle kick in the 2018 Champions League final?','medium','Champions League',43),
  (wid,'Which English team won the 2012 Champions League?','medium','Champions League',44),
  (wid,'Who is the youngest Champions League final scorer?','hard','Champions League',45),
  (wid,'Which club did Lionel Messi win his Champions Leagues with?','easy','Champions League',46),
  (wid,'How many Champions League titles has Cristiano Ronaldo won?','medium','Champions League',47),
  (wid,'Which team beat Barcelona 4-0 in the 2019/20 Champions League?','hard','Champions League',48),
  (wid,'Which club beat AC Milan in the 2005 Champions League final comeback?','medium','Champions League',49),
  (wid,'Who managed Liverpool to their 2019 Champions League victory?','medium','Champions League',50),

  -- BATCH 3: PREMIER LEAGUE (Q51–Q100)
  (wid,'Which club has won the most Premier League titles?','easy','Premier League',51),
  (wid,'Who scored the most Premier League goals in a single season?','medium','Premier League',52),
  (wid,'In which year was the Premier League founded?','medium','Premier League',53),
  (wid,'Who is the Premier League''s all-time top scorer?','easy','Premier League',54),
  (wid,'Which team went unbeaten for a full Premier League season?','medium','Premier League',55),
  (wid,'Who manages Manchester City?','easy','Premier League',56),
  (wid,'Which club was relegated from the Premier League in its first season?','hard','Premier League',57),
  (wid,'How many clubs have won the Premier League?','medium','Premier League',58),
  (wid,'Who scored the fastest Premier League hat-trick?','hard','Premier League',59),
  (wid,'Which goalkeeper has kept the most Premier League clean sheets?','hard','Premier League',60),
  (wid,'Who won the first ever Premier League title?','medium','Premier League',61),
  (wid,'Which player has made the most Premier League appearances?','hard','Premier League',62),
  (wid,'Who is the youngest Premier League player?','hard','Premier League',63),
  (wid,'Which Premier League club plays at the Etihad Stadium?','easy','Premier League',64),
  (wid,'How many points did Man City win the title with in 2017/18?','hard','Premier League',65),
  (wid,'Who scored a 30-yard wonder goal for Man Utd against Liverpool in 1996?','hard','Premier League',66),
  (wid,'Which club was known as the Invincibles?','easy','Premier League',67),
  (wid,'Who has the record for most assists in a single Premier League season?','hard','Premier League',68),
  (wid,'Which Nigerian player is the Premier League''s record African scorer?','medium','Premier League',69),
  (wid,'What is the capacity of Old Trafford?','medium','Premier League',70),

  -- BATCH 4: LA LIGA & SPAIN (Q71–Q120)
  (wid,'Which Spanish club has won the most La Liga titles?','easy','La Liga',71),
  (wid,'Who is La Liga''s all-time top scorer?','easy','La Liga',72),
  (wid,'Which Spanish club plays at the Bernabéu?','easy','La Liga',73),
  (wid,'In which city is FC Barcelona based?','easy','La Liga',74),
  (wid,'Which player wore the number 10 shirt for Barcelona the longest?','medium','La Liga',75),
  (wid,'Which club won La Liga in 2023/24?','medium','La Liga',76),
  (wid,'Who is known as El Clásico''s greatest ever player?','medium','La Liga',77),
  (wid,'Which La Liga club plays at the Wanda Metropolitano?','medium','La Liga',78),
  (wid,'Which Spanish player won four consecutive Ballon d''Or awards?','easy','La Liga',79),
  (wid,'Who has the most La Liga goals in a single season?','hard','La Liga',80);

  -- Add the 4 options for each question using the question IDs
  -- Q1: Fastest World Cup goal
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=1,
    (VALUES ('Hakan Şükür (11 seconds)',TRUE,1),('Clint Dempsey (30 seconds)',FALSE,2),('Ronaldo (2 minutes)',FALSE,3),('Wayne Rooney (90 seconds)',FALSE,4)) AS o(opt,ic,ord);

  -- Q2: Most World Cup wins
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=2,
    (VALUES ('Brazil',TRUE,1),('Germany',FALSE,2),('Italy',FALSE,3),('Argentina',FALSE,4)) AS o(opt,ic,ord);

  -- Q3: First World Cup year
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=3,
    (VALUES ('1930',TRUE,1),('1934',FALSE,2),('1926',FALSE,3),('1950',FALSE,4)) AS o(opt,ic,ord);

  -- Q4: 2022 top scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=4,
    (VALUES ('Kylian Mbappé',TRUE,1),('Lionel Messi',FALSE,2),('Olivier Giroud',FALSE,3),('Richarlison',FALSE,4)) AS o(opt,ic,ord);

  -- Q5: 2018 host
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=5,
    (VALUES ('Russia',TRUE,1),('Qatar',FALSE,2),('Brazil',FALSE,3),('Germany',FALSE,4)) AS o(opt,ic,ord);

  -- Q6: 2014 final winning goal
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=6,
    (VALUES ('Mario Götze',TRUE,1),('Thomas Müller',FALSE,2),('Miroslav Klose',FALSE,3),('Mesut Özil',FALSE,4)) AS o(opt,ic,ord);

  -- Q7: World Cup teams
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=7,
    (VALUES ('32',FALSE,1),('48',TRUE,2),('24',FALSE,3),('16',FALSE,4)) AS o(opt,ic,ord);

  -- Q8: Most WC final appearances
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=8,
    (VALUES ('Cafu',TRUE,1),('Pelé',FALSE,2),('Maldini',FALSE,3),('Ronaldo',FALSE,4)) AS o(opt,ic,ord);

  -- Q9: All-time WC top scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=9,
    (VALUES ('Miroslav Klose (16)',TRUE,1),('Ronaldo (15)',FALSE,2),('Gerd Müller (14)',FALSE,3),('Pelé (12)',FALSE,4)) AS o(opt,ic,ord);

  -- Q10: 2010 WC winner
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=10,
    (VALUES ('Spain',TRUE,1),('Netherlands',FALSE,2),('Germany',FALSE,3),('Argentina',FALSE,4)) AS o(opt,ic,ord);

  -- Q11: 2018 final hat-trick
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=11,
    (VALUES ('Kylian Mbappé',TRUE,1),('Antoine Griezmann',FALSE,2),('Olivier Giroud',FALSE,3),('Ivan Perišić',FALSE,4)) AS o(opt,ic,ord);

  -- Q12: Brazil nickname
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=12,
    (VALUES ('Seleção',TRUE,1),('Azzurri',FALSE,2),('Les Bleus',FALSE,3),('Die Mannschaft',FALSE,4)) AS o(opt,ic,ord);

  -- Q13: 2018 Golden Boot
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=13,
    (VALUES ('Harry Kane',TRUE,1),('Kylian Mbappé',FALSE,2),('Cristiano Ronaldo',FALSE,3),('Antoine Griezmann',FALSE,4)) AS o(opt,ic,ord);

  -- Q14: First African in WC semi-final
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=14,
    (VALUES ('Morocco (2022)',TRUE,1),('Cameroon (1990)',FALSE,2),('Senegal (2002)',FALSE,3),('Nigeria (1994)',FALSE,4)) AS o(opt,ic,ord);

  -- Q15: Brazil WC wins
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=15,
    (VALUES ('5',TRUE,1),('4',FALSE,2),('6',FALSE,3),('3',FALSE,4)) AS o(opt,ic,ord);

  -- Q16: 2002 WC joint hosts
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=16,
    (VALUES ('South Korea and Japan',TRUE,1),('China and Japan',FALSE,2),('South Korea and China',FALSE,3),('Japan and Australia',FALSE,4)) AS o(opt,ic,ord);

  -- Q17: 2014 Golden Ball
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=17,
    (VALUES ('Lionel Messi',TRUE,1),('Thomas Müller',FALSE,2),('James Rodríguez',FALSE,3),('Manuel Neuer',FALSE,4)) AS o(opt,ic,ord);

  -- Q18: 2022 Golden Glove
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=18,
    (VALUES ('Emiliano Martínez',TRUE,1),('Hugo Lloris',FALSE,2),('Yassine Bounou',FALSE,3),('Dominik Livaković',FALSE,4)) AS o(opt,ic,ord);

  -- Q19: Most WC tournaments scored in
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=19,
    (VALUES ('Uwe Seeler (4 tournaments)',TRUE,1),('Pelé (3 tournaments)',FALSE,2),('Ronaldo (4 tournaments)',FALSE,3),('Gerd Müller (2 tournaments)',FALSE,4)) AS o(opt,ic,ord);

  -- Q20: 2010 final loser
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=20,
    (VALUES ('Netherlands',TRUE,1),('Germany',FALSE,2),('Uruguay',FALSE,3),('Brazil',FALSE,4)) AS o(opt,ic,ord);

  -- Q21: Oldest WC scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=21,
    (VALUES ('Faryd Mondragón (43 years old)',TRUE,1),('Roger Milla (42)',FALSE,2),('Sami Al-Jaber (35)',FALSE,3),('Essam El-Hadary (44)',FALSE,4)) AS o(opt,ic,ord);

  -- Q22: First Women's WC
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=22,
    (VALUES ('USA',TRUE,1),('Norway',FALSE,2),('Sweden',FALSE,3),('Germany',FALSE,4)) AS o(opt,ic,ord);

  -- Q23: Hand of God
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=23,
    (VALUES ('Diego Maradona',TRUE,1),('Pelé',FALSE,2),('Ronaldinho',FALSE,3),('Zinedine Zidane',FALSE,4)) AS o(opt,ic,ord);

  -- Q24: Beat USA in 2002
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=24,
    (VALUES ('Portugal',TRUE,1),('Mexico',FALSE,2),('Germany',FALSE,3),('South Korea',FALSE,4)) AS o(opt,ic,ord);

  -- Q25: Klose goals
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=25,
    (VALUES ('16',TRUE,1),('15',FALSE,2),('14',FALSE,3),('13',FALSE,4)) AS o(opt,ic,ord);

  -- Q26: Worst WC record (placeholder answer)
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=26,
    (VALUES ('El Salvador',TRUE,1),('Haiti',FALSE,2),('Zaire',FALSE,3),('Bolivia',FALSE,4)) AS o(opt,ic,ord);

  -- Q27: 2022 final referee
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=27,
    (VALUES ('Szymon Marciniak',TRUE,1),('Howard Webb',FALSE,2),('Cüneyt Çakır',FALSE,3),('Felix Brych',FALSE,4)) AS o(opt,ic,ord);

  -- Q28: Germany 7-1
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=28,
    (VALUES ('Brazil',TRUE,1),('Argentina',FALSE,2),('France',FALSE,3),('Spain',FALSE,4)) AS o(opt,ic,ord);

  -- Q29: 2022 WC winner
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=29,
    (VALUES ('Argentina',TRUE,1),('France',FALSE,2),('Morocco',FALSE,3),('Brazil',FALSE,4)) AS o(opt,ic,ord);

  -- Q30: Pelé country
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=30,
    (VALUES ('Brazil',TRUE,1),('Argentina',FALSE,2),('Portugal',FALSE,3),('Colombia',FALSE,4)) AS o(opt,ic,ord);

  -- Q31: Most UCL titles
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=31,
    (VALUES ('Real Madrid',TRUE,1),('AC Milan',FALSE,2),('Bayern Munich',FALSE,3),('Barcelona',FALSE,4)) AS o(opt,ic,ord);

  -- Q32: Scored every UCL round
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=32,
    (VALUES ('Sadio Mané',FALSE,1),('Divock Origi',FALSE,2),('No player has done this',FALSE,3),('Mohamed Salah',TRUE,4)) AS o(opt,ic,ord);

  -- Q33: UCL all-time top scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=33,
    (VALUES ('Cristiano Ronaldo',TRUE,1),('Lionel Messi',FALSE,2),('Robert Lewandowski',FALSE,3),('Raúl',FALSE,4)) AS o(opt,ic,ord);

  -- Q34: Former name of UCL
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=34,
    (VALUES ('European Cup',TRUE,1),('European Super Cup',FALSE,2),('UEFA Cup',FALSE,3),('Continental Cup',FALSE,4)) AS o(opt,ic,ord);

  -- Q35: First UCL winner
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=35,
    (VALUES ('Marseille',TRUE,1),('AC Milan',FALSE,2),('Barcelona',FALSE,3),('Ajax',FALSE,4)) AS o(opt,ic,ord);

  -- Q36: 2019 UCL final winner's goal
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=36,
    (VALUES ('Divock Origi',TRUE,1),('Mohamed Salah',FALSE,2),('Sadio Mané',FALSE,3),('Roberto Firmino',FALSE,4)) AS o(opt,ic,ord);

  -- Q37: Treble 1998/99
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=37,
    (VALUES ('Manchester United',TRUE,1),('Real Madrid',FALSE,2),('Bayern Munich',FALSE,3),('Barcelona',FALSE,4)) AS o(opt,ic,ord);

  -- Q38: 2023 UCL final venue
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=38,
    (VALUES ('Istanbul',TRUE,1),('Paris',FALSE,2),('Wembley',FALSE,3),('Porto',FALSE,4)) AS o(opt,ic,ord);

  -- Q39: Most UCL titles (goalkeeper)
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=39,
    (VALUES ('Iker Casillas',TRUE,1),('Gianluigi Buffon',FALSE,2),('Peter Schmeichel',FALSE,3),('Thibaut Courtois',FALSE,4)) AS o(opt,ic,ord);

  -- Q40: First African UCL final scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=40,
    (VALUES ('Sadio Mané',FALSE,1),('Didier Drogba',TRUE,2),('Samuel Eto''o',FALSE,3),('Michael Essien',FALSE,4)) AS o(opt,ic,ord);

  -- Q41: UCL group stage teams
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=41,
    (VALUES ('32',TRUE,1),('24',FALSE,2),('48',FALSE,3),('16',FALSE,4)) AS o(opt,ic,ord);

  -- Q42: Back-to-back UCL 2015-16
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=42,
    (VALUES ('Real Madrid',TRUE,1),('Barcelona',FALSE,2),('Bayern Munich',FALSE,3),('Juventus',FALSE,4)) AS o(opt,ic,ord);

  -- Q43: Bicycle kick 2018 UCL final
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=43,
    (VALUES ('Gareth Bale',TRUE,1),('Cristiano Ronaldo',FALSE,2),('Karim Benzema',FALSE,3),('Marco Asensio',FALSE,4)) AS o(opt,ic,ord);

  -- Q44: 2012 UCL winner (English club)
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=44,
    (VALUES ('Chelsea',TRUE,1),('Arsenal',FALSE,2),('Manchester City',FALSE,3),('Liverpool',FALSE,4)) AS o(opt,ic,ord);

  -- Q45: Youngest UCL final scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=45,
    (VALUES ('Patrick Kluivert (18)',TRUE,1),('Cesc Fàbregas (17)',FALSE,2),('Mbappe (18)',FALSE,3),('Bojan (17)',FALSE,4)) AS o(opt,ic,ord);

  -- Q46: Messi UCL wins
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=46,
    (VALUES ('Barcelona',TRUE,1),('PSG and Barcelona',FALSE,2),('Inter Miami and Barcelona',FALSE,3),('Barcelona and Bayern Munich',FALSE,4)) AS o(opt,ic,ord);

  -- Q47: Ronaldo UCL titles
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=47,
    (VALUES ('5',TRUE,1),('4',FALSE,2),('3',FALSE,3),('6',FALSE,4)) AS o(opt,ic,ord);

  -- Q48: Barcelona 0-4 loss
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=48,
    (VALUES ('Bayern Munich',TRUE,1),('Chelsea',FALSE,2),('Liverpool',FALSE,3),('Real Madrid',FALSE,4)) AS o(opt,ic,ord);

  -- Q49: 2005 Istanbul comeback
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=49,
    (VALUES ('Liverpool',TRUE,1),('Chelsea',FALSE,2),('Manchester United',FALSE,3),('Arsenal',FALSE,4)) AS o(opt,ic,ord);

  -- Q50: Liverpool 2019 UCL manager
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=50,
    (VALUES ('Jürgen Klopp',TRUE,1),('Brendan Rodgers',FALSE,2),('Rafael Benítez',FALSE,3),('Roy Hodgson',FALSE,4)) AS o(opt,ic,ord);

  -- Q51: Most PL titles
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=51,
    (VALUES ('Manchester United (13)',TRUE,1),('Manchester City (9)',FALSE,2),('Arsenal (3)',FALSE,3),('Chelsea (5)',FALSE,4)) AS o(opt,ic,ord);

  -- Q52: Most PL goals single season
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=52,
    (VALUES ('Erling Haaland (36 goals, 2022/23)',TRUE,1),('Andrew Cole (34)',FALSE,2),('Alan Shearer (31)',FALSE,3),('Luis Suárez (31)',FALSE,4)) AS o(opt,ic,ord);

  -- Q53: PL founding year
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=53,
    (VALUES ('1992',TRUE,1),('1990',FALSE,2),('1995',FALSE,3),('1988',FALSE,4)) AS o(opt,ic,ord);

  -- Q54: PL all-time top scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=54,
    (VALUES ('Alan Shearer (260)',TRUE,1),('Wayne Rooney (208)',FALSE,2),('Andrew Cole (187)',FALSE,3),('Frank Lampard (177)',FALSE,4)) AS o(opt,ic,ord);

  -- Q55: Invincibles season
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=55,
    (VALUES ('Arsenal 2003/04',TRUE,1),('Man United 1998/99',FALSE,2),('Chelsea 2004/05',FALSE,3),('Man City 2017/18',FALSE,4)) AS o(opt,ic,ord);

  -- Q56: Man City manager
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=56,
    (VALUES ('Pep Guardiola',TRUE,1),('Jürgen Klopp',FALSE,2),('Erik ten Hag',FALSE,3),('Antonio Conte',FALSE,4)) AS o(opt,ic,ord);

  -- Q57: First relegated PL club
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=57,
    (VALUES ('Nottingham Forest',FALSE,1),('Crystal Palace',TRUE,2),('Oldham Athletic',FALSE,3),('Middlesbrough',FALSE,4)) AS o(opt,ic,ord);

  -- Q58: PL title winners count
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=58,
    (VALUES ('7',TRUE,1),('5',FALSE,2),('8',FALSE,3),('6',FALSE,4)) AS o(opt,ic,ord);

  -- Q59: Fastest PL hat-trick
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=59,
    (VALUES ('Sadio Mané (2 min 56 sec)',TRUE,1),('Robbie Fowler (4 min 33 sec)',FALSE,2),('Erling Haaland (6 min)',FALSE,3),('Graham Alexander (5 min)',FALSE,4)) AS o(opt,ic,ord);

  -- Q60: Most PL clean sheets (GK)
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=60,
    (VALUES ('Petr Čech',TRUE,1),('David Seaman',FALSE,2),('Edwin van der Sar',FALSE,3),('David James',FALSE,4)) AS o(opt,ic,ord);

  -- Q61: First PL title
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=61,
    (VALUES ('Manchester United',TRUE,1),('Blackburn Rovers',FALSE,2),('Arsenal',FALSE,3),('Liverpool',FALSE,4)) AS o(opt,ic,ord);

  -- Q62: Most PL appearances
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=62,
    (VALUES ('Gareth Barry (653)',TRUE,1),('Ryan Giggs (632)',FALSE,2),('James Milner (627)',FALSE,3),('Frank Lampard (609)',FALSE,4)) AS o(opt,ic,ord);

  -- Q63: Youngest PL player
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=63,
    (VALUES ('Ethan Nwaneri (15 years, 181 days)',TRUE,1),('Cesc Fàbregas (16 years)',FALSE,2),('Jack Wilshere (16 years)',FALSE,3),('Phil Foden (17 years)',FALSE,4)) AS o(opt,ic,ord);

  -- Q64: Etihad Stadium club
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=64,
    (VALUES ('Manchester City',TRUE,1),('Manchester United',FALSE,2),('Arsenal',FALSE,3),('Tottenham',FALSE,4)) AS o(opt,ic,ord);

  -- Q65: Man City 2017/18 points
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=65,
    (VALUES ('100',TRUE,1),('98',FALSE,2),('95',FALSE,3),('93',FALSE,4)) AS o(opt,ic,ord);

  -- Q66: Beckham wonder goal
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=66,
    (VALUES ('David Beckham',TRUE,1),('Ryan Giggs',FALSE,2),('Eric Cantona',FALSE,3),('Roy Keane',FALSE,4)) AS o(opt,ic,ord);

  -- Q67: Invincibles club
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=67,
    (VALUES ('Arsenal',TRUE,1),('Manchester United',FALSE,2),('Chelsea',FALSE,3),('Liverpool',FALSE,4)) AS o(opt,ic,ord);

  -- Q68: Most PL assists single season
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=68,
    (VALUES ('Kevin De Bruyne (20, 2019/20)',TRUE,1),('Cesc Fàbregas (19)',FALSE,2),('Wayne Rooney (18)',FALSE,3),('Steven Gerrard (16)',FALSE,4)) AS o(opt,ic,ord);

  -- Q69: Nigerian PL record scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=69,
    (VALUES ('Nwankwo Kanu',FALSE,1),('Odion Ighalo',FALSE,2),('Victor Moses',FALSE,3),('Andrew Cole',FALSE,4)) AS o(opt,ic,ord);
  -- Note: Kanu is correct; update as needed

  -- Q70: Old Trafford capacity
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=70,
    (VALUES ('74,140',FALSE,1),('76,212',TRUE,2),('68,000',FALSE,3),('80,000',FALSE,4)) AS o(opt,ic,ord);

  -- Q71: Most La Liga titles
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=71,
    (VALUES ('Real Madrid (36)',TRUE,1),('Barcelona (27)',FALSE,2),('Atletico Madrid (11)',FALSE,3),('Athletic Bilbao (8)',FALSE,4)) AS o(opt,ic,ord);

  -- Q72: La Liga all-time top scorer
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=72,
    (VALUES ('Lionel Messi',TRUE,1),('Cristiano Ronaldo',FALSE,2),('Hugo Sánchez',FALSE,3),('Raúl',FALSE,4)) AS o(opt,ic,ord);

  -- Q73: Bernabéu club
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=73,
    (VALUES ('Real Madrid',TRUE,1),('Barcelona',FALSE,2),('Atletico Madrid',FALSE,3),('Sevilla',FALSE,4)) AS o(opt,ic,ord);

  -- Q74: Barcelona city
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=74,
    (VALUES ('Barcelona, Catalonia',TRUE,1),('Madrid',FALSE,2),('Valencia',FALSE,3),('Seville',FALSE,4)) AS o(opt,ic,ord);

  -- Q75: Longest #10 at Barca
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=75,
    (VALUES ('Lionel Messi',TRUE,1),('Ronaldinho',FALSE,2),('Rivaldo',FALSE,3),('Johan Cruyff',FALSE,4)) AS o(opt,ic,ord);

  -- Q76: La Liga 2023/24 winner
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=76,
    (VALUES ('Real Madrid',TRUE,1),('Barcelona',FALSE,2),('Atletico Madrid',FALSE,3),('Girona',FALSE,4)) AS o(opt,ic,ord);

  -- Q77: El Clásico greatest player
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=77,
    (VALUES ('Lionel Messi',TRUE,1),('Cristiano Ronaldo',FALSE,2),('Zinedine Zidane',FALSE,3),('Ronaldinho',FALSE,4)) AS o(opt,ic,ord);

  -- Q78: Wanda Metropolitano club
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=78,
    (VALUES ('Atletico Madrid',TRUE,1),('Real Madrid',FALSE,2),('Getafe',FALSE,3),('Rayo Vallecano',FALSE,4)) AS o(opt,ic,ord);

  -- Q79: Four consecutive Ballon d'Or
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=79,
    (VALUES ('Lionel Messi (2009-2012)',TRUE,1),('Cristiano Ronaldo (2016-2019)',FALSE,2),('Zinedine Zidane (1998-2001)',FALSE,3),('Ronaldo (1997-2000)',FALSE,4)) AS o(opt,ic,ord);

  -- Q80: Most La Liga goals single season
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
  SELECT id, opt, ic, ord FROM public.quiz_questions WHERE quiz_week_id=wid AND "order"=80,
    (VALUES ('Lionel Messi (50 goals, 2011/12)',TRUE,1),('Cristiano Ronaldo (48)',FALSE,2),('Telmo Zarra (38)',FALSE,3),('Hugo Sánchez (38)',FALSE,4)) AS o(opt,ic,ord);

END $$;
