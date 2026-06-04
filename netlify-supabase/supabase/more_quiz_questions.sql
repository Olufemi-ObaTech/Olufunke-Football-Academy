-- ============================================================
-- OFA Academy — 120 More Quiz Questions
-- Week 3: Nigeria, Africa and World Football Challenge
-- 5 min time limit, 10 random per game
-- Pure PostgreSQL — no DO blocks, no variables
-- ============================================================

DELETE FROM public.quiz_weeks WHERE week_number = 3;

INSERT INTO public.quiz_weeks (title, description, theme, week_start, week_end, time_limit, is_active, week_number)
VALUES ('Nigeria, Africa and World Football Challenge',
        '120 questions covering Nigerian football, African football, and global football — 10 random per game!',
        'Nigeria & Africa', '2026-06-15', '2099-12-31', 300, TRUE, 3);

-- ── INSERT ALL 120 QUESTIONS ───────────────────────────────────
INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, "order")
SELECT w.id, v.q, v.d, v.cat, v.ord
FROM public.quiz_weeks w,
(VALUES
  -- NIGERIA (Q1–Q40)
  ('Which year did Nigeria gain independence?','easy','Nigeria',1),
  ('What is the nickname of the Nigerian national football team?','easy','Nigeria',2),
  ('Who is Nigeria all-time top scorer in World Cup history?','medium','Nigeria',3),
  ('In which year did Nigeria first qualify for the FIFA World Cup?','medium','Nigeria',4),
  ('Who scored Nigeria first ever World Cup goal?','hard','Nigeria',5),
  ('Which Nigerian player was named African Footballer of the Year three times?','hard','Nigeria',6),
  ('What year did Nigeria win the Olympic Gold medal in football?','medium','Nigeria',7),
  ('Where was the 1996 Olympic final played where Nigeria won gold?','hard','Nigeria',8),
  ('Which club did Jay-Jay Okocha play for in England?','medium','Nigeria',9),
  ('How many times has Nigeria won the Africa Cup of Nations?','medium','Nigeria',10),
  ('In which years did Nigeria win AFCON?','hard','Nigeria',11),
  ('Who was the coach that led Nigeria to win AFCON 2013?','medium','Nigeria',12),
  ('Which Nigerian player won the Champions League with Liverpool?','medium','Nigeria',13),
  ('What is the name of Nigeria home stadium?','easy','Nigeria',14),
  ('Which city is the Moshood Abiola National Stadium located in?','medium','Nigeria',15),
  ('Who is the most capped Nigerian international player?','hard','Nigeria',16),
  ('Which Nigerian player plays for Napoli and is top scorer in Serie A?','easy','Nigeria',17),
  ('What shirt number does Victor Osimhen wear for Nigeria?','medium','Nigeria',18),
  ('Which Nigerian player was known as Jay-Jay?','easy','Nigeria',19),
  ('What position does Wilfred Ndidi play?','easy','Nigeria',20),
  ('Which club did Nwankwo Kanu win the Champions League with?','medium','Nigeria',21),
  ('Who was Nigeria goalkeeper at the 1994 World Cup?','hard','Nigeria',22),
  ('Which Nigerian defender played for Chelsea in the Premier League?','medium','Nigeria',23),
  ('What was the score when Nigeria beat Argentina at the 1996 Olympics?','hard','Nigeria',24),
  ('Who scored the winning penalty for Nigeria in the 1996 Olympic semi-final?','hard','Nigeria',25),
  ('Which Nigerian won the Golden Boot at the 1999 FIFA World Youth Championship?','hard','Nigeria',26),
  ('Which club does Moses Simon play for?','medium','Nigeria',27),
  ('What is the capacity of the Moshood Abiola National Stadium?','hard','Nigeria',28),
  ('Which Nigerian player has played in the most World Cups?','hard','Nigeria',29),
  ('Who coached Nigeria at the 2018 FIFA World Cup?','medium','Nigeria',30),
  ('Which state in Nigeria is Jay-Jay Okocha from?','hard','Nigeria',31),
  ('What was the name of the Nigeria team that won the 1985 FIFA World Youth Championship?','hard','Nigeria',32),
  ('Which city hosted Nigeria most memorable AFCON victory in 2013?','medium','Nigeria',33),
  ('Who scored Nigeria opening goal at the 2014 World Cup?','medium','Nigeria',34),
  ('Which Nigerian player scored a famous goal for Bolton against Chelsea?','hard','Nigeria',35),
  ('Who is known as the Nigerian Nightmare in football?','medium','Nigeria',36),
  ('Which Nigerian signed for Real Madrid in 2023?','easy','Nigeria',37),
  ('What does NPFL stand for in Nigerian football?','easy','Nigeria',38),
  ('Which Nigerian club has won the most CAF Champions League titles?','hard','Nigeria',39),
  ('Who is the current Super Eagles head coach as of 2026?','medium','Nigeria',40),
  -- AFRICA (Q41–Q80)
  ('Which country has won the Africa Cup of Nations the most times?','medium','Africa',41),
  ('How many times has Cameroon won AFCON?','medium','Africa',42),
  ('Who is the all-time top scorer in AFCON history?','hard','Africa',43),
  ('Which country hosted AFCON 2023?','medium','Africa',44),
  ('Who won AFCON 2023?','medium','Africa',45),
  ('Which African player won the Ballon d''Or in 1995?','hard','Africa',46),
  ('Who is the Egyptian player known as the Pharaoh?','hard','Africa',47),
  ('Which African club has won the most CAF Champions League titles?','medium','Africa',48),
  ('Which country did Didier Drogba play for?','easy','Africa',49),
  ('Which African nation famously beat Italy at the 1966 World Cup?','hard','Africa',50),
  ('Which African player scored a hat-trick at the 2002 World Cup?','hard','Africa',51),
  ('Which country has Sadio Mane played for throughout his career?','easy','Africa',52),
  ('Who captained Cameroon at the 1990 World Cup where they reached the quarter-finals?','hard','Africa',53),
  ('Which African country did Morocco defeat to reach the 2022 World Cup semi-final?','hard','Africa',54),
  ('Who scored the most goals for Senegal?','hard','Africa',55),
  ('Which African team eliminated Argentina at the 1990 World Cup group stage?','medium','Africa',56),
  ('What is the name of the stadium in Cairo used for AFCON matches?','hard','Africa',57),
  ('Which African player has played the most Champions League matches?','hard','Africa',58),
  ('Who won African Footballer of the Year for 2023?','medium','Africa',59),
  ('Which country did Roger Milla play for?','easy','Africa',60),
  ('How old was Roger Milla when he scored at the 1994 World Cup?','hard','Africa',61),
  ('Which African country reached the World Cup quarter-finals in 2010?','medium','Africa',62),
  ('Who managed Ghana at the 2010 World Cup?','hard','Africa',63),
  ('What year did Egypt win AFCON most recently before 2023?','hard','Africa',64),
  ('Which African country produced Samuel Etoo?','easy','Africa',65),
  ('How many goals did Samuel Etoo score in his career at Barcelona?','hard','Africa',66),
  ('Which Ghanaian player was known as the Maestro at Arsenal?','medium','Africa',67),
  ('Which Moroccan club won the CAF Champions League in 2024?','hard','Africa',68),
  ('Who is the all-time top scorer for the Ivory Coast national team?','hard','Africa',69),
  ('Which African country has produced the player Achraf Hakimi?','easy','Africa',70),
  ('What position does Riyad Mahrez play?','easy','Africa',71),
  ('Which country did Yaya Toure play for?','easy','Africa',72),
  ('What club did Yaya Toure win the Premier League with?','easy','Africa',73),
  ('Which African player was known as the Black Panther?','hard','Africa',74),
  ('How many African teams qualified for the 2022 World Cup?','medium','Africa',75),
  ('Which African team had the best performance at the 2022 World Cup?','easy','Africa',76),
  ('Who scored the winning penalty in the 2022 World Cup quarter-final for Morocco against Portugal?','hard','Africa',77),
  ('Which African country does Edouard Mendy play for?','medium','Africa',78),
  ('What is the AFCON trophy called?','hard','Africa',79),
  ('Which West African country has never qualified for a World Cup?','hard','Africa',80),
  -- WORLD FOOTBALL (Q81–Q120)
  ('Who scored the most goals in a single calendar year in football history?','hard','World',81),
  ('Which club has been relegated from the top division the most times in England?','hard','World',82),
  ('Who holds the record for most goals in a single World Cup tournament?','hard','World',83),
  ('Which nation won the first ever UEFA European Championship in 1960?','hard','World',84),
  ('Who is the all-time top scorer for France?','medium','World',85),
  ('Which club did Ronaldo leave Real Madrid for in 2018?','easy','World',86),
  ('Who managed Spain when they won Euro 2008 and 2012?','hard','World',87),
  ('What is the name of the penalty shootout rule where a player goes 1v1 with the goalkeeper?','medium','World',88),
  ('Which country has won the Copa America the most times?','hard','World',89),
  ('Who scored the golden goal in the Euro 2000 final?','hard','World',90),
  ('Which club is known as Der Klassiker in German football?','medium','World',91),
  ('How many times has Bayern Munich won the Bundesliga?','hard','World',92),
  ('Who is Serie A all-time top scorer?','hard','World',93),
  ('Which club plays at the San Siro in Milan?','easy','World',94),
  ('What year was the Premier League founded?','easy','World',95),
  ('Who won the first Ballon d''Or ever awarded in 1956?','hard','World',96),
  ('Which club did Zinedine Zidane manage to three consecutive Champions League titles?','medium','World',97),
  ('What is the maximum number of players in a Premier League squad?','hard','World',98),
  ('Who scored twice in extra time for Real Madrid to win the 2022 Champions League?','hard','World',99),
  ('Which country hosted the first African World Cup?','easy','World',100),
  ('What is the name of Barcelona attacking style associated with Johan Cruyff?','hard','World',101),
  ('Who holds the Ligue 1 all-time top scorer record?','hard','World',102),
  ('Which club did Zlatan Ibrahimovic win the most league titles with?','hard','World',103),
  ('Who is the youngest ever player to score in a World Cup?','hard','World',104),
  ('Which South American country has never won the Copa America?','hard','World',105),
  ('How many substitutes can be named on a bench in the Champions League?','medium','World',106),
  ('Who scored the famous Panenka penalty in the 1976 Euro final?','hard','World',107),
  ('Which club won the inaugural FIFA Club World Cup in 2000?','hard','World',108),
  ('Who has managed the most clubs in the top five European leagues?','hard','World',109),
  ('What is the Puskas Award given for?','medium','World',110),
  ('Which player has the most appearances in Champions League history?','hard','World',111),
  ('Who was the first player to win the Ballon d''Or five consecutive times?','medium','World',112),
  ('Which country has the most clubs to have won the Champions League?','medium','World',113),
  ('What does UEFA stand for?','easy','World',114),
  ('Who scored a hat-trick against Germany for Brazil in a 1994 friendly?','hard','World',115),
  ('Which club did Luis Suarez join after leaving Liverpool?','medium','World',116),
  ('What year was Arsene Wenger appointed Arsenal manager?','medium','World',117),
  ('Who managed Jose Mourinho at Porto before they won the Champions League?','hard','World',118),
  ('Which stadium hosted the 2016 Champions League final?','hard','World',119),
  ('Who scored the winning goal for Real Madrid in the 2016 Champions League final?','hard','World',120)
) AS v(q, d, cat, ord)
WHERE w.week_number = 3;

-- ── INSERT ALL OPTIONS ────────────────────────────────────────

-- Q1: Nigeria independence year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('1960',TRUE,1),('1963',FALSE,2),('1956',FALSE,3),('1970',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=1;

-- Q2: Super Eagles
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Super Eagles',TRUE,1),('Green Eagles',FALSE,2),('Golden Eagles',FALSE,3),('Eagles of Nigeria',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=2;

-- Q3: Nigeria WC top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Rashidi Yekini',TRUE,1),('Jay-Jay Okocha',FALSE,2),('Nwankwo Kanu',FALSE,3),('Daniel Amokachi',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=3;

-- Q4: Nigeria first WC year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('1994',TRUE,1),('1990',FALSE,2),('1998',FALSE,3),('2002',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=4;

-- Q5: Nigeria first WC goal scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Rashidi Yekini',TRUE,1),('Finidi George',FALSE,2),('Sunday Oliseh',FALSE,3),('Emmanuel Amunike',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=5;

-- Q6: African FOY three times
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Nwankwo Kanu',TRUE,1),('Jay-Jay Okocha',FALSE,2),('Rashidi Yekini',FALSE,3),('Austin Jay Jay Okocha',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=6;

-- Q7: Nigeria Olympic Gold year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('1996',TRUE,1),('2000',FALSE,2),('1992',FALSE,3),('2004',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=7;

-- Q8: 1996 Olympic final venue
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Athens Olympic Stadium',FALSE,1),('Sanford Stadium, Atlanta',TRUE,2),('Rose Bowl, Los Angeles',FALSE,3),('Silverdome, Detroit',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=8;

-- Q9: Okocha English club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Bolton Wanderers',TRUE,1),('Hull City',FALSE,2),('West Ham',FALSE,3),('Sunderland',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=9;

-- Q10: Nigeria AFCON wins
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('3',TRUE,1),('2',FALSE,2),('4',FALSE,3),('1',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=10;

-- Q11: Nigeria AFCON years
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('1980, 1994, 2013',TRUE,1),('1980, 1996, 2013',FALSE,2),('1984, 1994, 2013',FALSE,3),('1976, 1994, 2013',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=11;

-- Q12: AFCON 2013 coach
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Stephen Keshi',TRUE,1),('Shuaibu Amodu',FALSE,2),('Lars Lagerback',FALSE,3),('Gernot Rohr',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=12;

-- Q13: Nigerian CL winner with Liverpool
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Victor Moses',FALSE,1),('Nwankwo Kanu',FALSE,2),('John Obi Mikel',FALSE,3),('There is no Nigerian CL winner with Liverpool',TRUE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=13;

-- Q14: Nigeria home stadium
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Moshood Abiola National Stadium',TRUE,1),('Teslim Balogun Stadium',FALSE,2),('Godswill Akpabio Stadium',FALSE,3),('Emmanuel Lawson Stadium',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=14;

-- Q15: Moshood Abiola Stadium city
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Abuja',TRUE,1),('Lagos',FALSE,2),('Kano',FALSE,3),('Port Harcourt',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=15;

-- Q16: Most capped Nigerian
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Vincent Enyeama',TRUE,1),('Jay-Jay Okocha',FALSE,2),('Nwankwo Kanu',FALSE,3),('Ahmed Musa',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=16;

-- Q17: Victor Osimhen club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Napoli',TRUE,1),('Galatasaray',FALSE,2),('PSG',FALSE,3),('Chelsea',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=17;

-- Q18: Osimhen shirt number
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('9',TRUE,1),('10',FALSE,2),('11',FALSE,3),('7',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=18;

-- Q19: Jay-Jay
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Austin Okocha',TRUE,1),('Emmanuel Amunike',FALSE,2),('Sunday Oliseh',FALSE,3),('Finidi George',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=19;

-- Q20: Ndidi position
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Defensive Midfielder',TRUE,1),('Centre-Back',FALSE,2),('Attacking Midfielder',FALSE,3),('Right Back',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=20;

-- Q21: Kanu UCL club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ajax',TRUE,1),('Arsenal',FALSE,2),('Inter Milan',FALSE,3),('Portsmouth',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=21;

-- Q22: Nigeria 1994 WC goalkeeper
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Peter Rufai',TRUE,1),('Vincent Enyeama',FALSE,2),('Carl Ikeme',FALSE,3),('Dele Aiyenugba',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=22;

-- Q23: Nigerian Chelsea defender
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Victor Moses',TRUE,1),('John Obi Mikel',FALSE,2),('Celestine Babayaro',FALSE,3),('Kenneth Omeruo',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=23;

-- Q24: Nigeria vs Argentina 1996 Olympics score
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('3-2',TRUE,1),('2-1',FALSE,2),('4-1',FALSE,3),('1-0',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=24;

-- Q25: 1996 Olympic semi-final penalty scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Nwankwo Kanu',TRUE,1),('Jay-Jay Okocha',FALSE,2),('Tijani Babangida',FALSE,3),('Victor Ikpeba',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=25;

-- Q26: 1999 Golden Boot
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Julius Aghahowa',TRUE,1),('Nwankwo Kanu',FALSE,2),('Victor Agali',FALSE,3),('Celestine Babayaro',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=26;

-- Q27: Moses Simon club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('FC Nantes',TRUE,1),('Levante',FALSE,2),('KAA Gent',FALSE,3),('Anderlecht',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=27;

-- Q28: Stadium capacity
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('60,491',TRUE,1),('45,000',FALSE,2),('80,000',FALSE,3),('55,000',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=28;

-- Q29: Most Nigerian WC appearances
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ahmed Musa',TRUE,1),('Nwankwo Kanu',FALSE,2),('Jay-Jay Okocha',FALSE,3),('Vincent Enyeama',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=29;

-- Q30: 2018 WC Nigeria coach
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Gernot Rohr',TRUE,1),('Sunday Oliseh',FALSE,2),('Jose Peseiro',FALSE,3),('Lars Lagerback',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=30;

-- Q31: Okocha state
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Plateau State',TRUE,1),('Lagos State',FALSE,2),('Kogi State',FALSE,3),('Enugu State',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=31;

-- Q32: 1985 Youth Championship team name
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('The Golden Eaglets',TRUE,1),('Flying Eagles',FALSE,2),('Young Eagles',FALSE,3),('Super Falcons',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=32;

-- Q33: AFCON 2013 host city
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Johannesburg',FALSE,1),('Cape Town',FALSE,2),('Durban',FALSE,3),('Johannesburg (Soccer City)',TRUE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=33;

-- Q34: Nigeria 2014 WC first goal
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ahmed Musa',TRUE,1),('Emmanuel Emenike',FALSE,2),('Peter Odemwingie',FALSE,3),('Victor Moses',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=34;

-- Q35: Goal against Chelsea for Bolton
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Jay-Jay Okocha',TRUE,1),('Michael Essien',FALSE,2),('Nwankwo Kanu',FALSE,3),('Celestine Babayaro',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=35;

-- Q36: Nigerian Nightmare
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Julius Aghahowa',FALSE,1),('Tijani Babangida',TRUE,2),('Garba Lawal',FALSE,3),('Victor Ikpeba',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=36;

-- Q37: Nigerian Real Madrid signing
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('No Nigerian has signed for Real Madrid',TRUE,1),('Victor Osimhen',FALSE,2),('Wilfred Ndidi',FALSE,3),('Alex Iwobi',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=37;

-- Q38: NPFL meaning
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Nigeria Professional Football League',TRUE,1),('National Premier Football League',FALSE,2),('Nigeria Premier Football League',FALSE,3),('National Professional Football League',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=38;

-- Q39: Nigerian club most CAF titles
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Enyimba FC',TRUE,1),('Kano Pillars',FALSE,2),('Rangers International',FALSE,3),('Heartland FC',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=39;

-- Q40: Current Super Eagles coach 2026
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Eric Chelle',TRUE,1),('Jose Peseiro',FALSE,2),('Gernot Rohr',FALSE,3),('Stephen Keshi',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=40;

-- Q41: Most AFCON wins
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Egypt (8)',TRUE,1),('Ghana (4)',FALSE,2),('Cameroon (5)',FALSE,3),('Nigeria (3)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=41;

-- Q42: Cameroon AFCON wins
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('5',TRUE,1),('4',FALSE,2),('3',FALSE,3),('6',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=42;

-- Q43: AFCON all-time top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Hossam Hassan (Egypt)',TRUE,1),('Samuel Etoo (Cameroon)',FALSE,2),('Didier Drogba (Ivory Coast)',FALSE,3),('Rashidi Yekini (Nigeria)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=43;

-- Q44: AFCON 2023 host
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ivory Coast',TRUE,1),('Senegal',FALSE,2),('Morocco',FALSE,3),('Egypt',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=44;

-- Q45: AFCON 2023 winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ivory Coast',TRUE,1),('Nigeria',FALSE,2),('South Africa',FALSE,3),('Egypt',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=45;

-- Q46: African Ballon d'Or 1995
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('George Weah (Liberia)',TRUE,1),('Nwankwo Kanu (Nigeria)',FALSE,2),('Marc Vivien Foe (Cameroon)',FALSE,3),('Patrick Mboma (Cameroon)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=46;

-- Q47: Egyptian Pharaoh player
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Hossam Hassan',TRUE,1),('Mohamed Salah',FALSE,2),('Ahmed Hassan',FALSE,3),('Essam El-Hadary',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=47;

-- Q48: Most CAF CL titles club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Al Ahly (Egypt)',TRUE,1),('TP Mazembe (DRC)',FALSE,2),('Zamalek (Egypt)',FALSE,3),('Wydad Casablanca (Morocco)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=48;

-- Q49: Drogba country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ivory Coast',TRUE,1),('Ghana',FALSE,2),('Cameroon',FALSE,3),('Senegal',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=49;

-- Q50: Africa beat Italy 1966
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('North Korea',FALSE,1),('Morocco',FALSE,2),('North Korea is not African - Senegal',FALSE,3),('North Korea beat Italy not an African nation',TRUE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=50;

-- Q51: Hat-trick 2002 WC (African)
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Hasan El-Shazly (Tunisia)',FALSE,1),('None - no African scored a hat-trick',TRUE,2),('El Hadji Diouf (Senegal)',FALSE,3),('Samuel Etoo (Cameroon)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=51;

-- Q52: Sadio Mane country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Senegal',TRUE,1),('Mali',FALSE,2),('Ivory Coast',FALSE,3),('Guinea',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=52;

-- Q53: Cameroon 1990 captain
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Roger Milla',FALSE,1),('Stephen Tataw',TRUE,2),('Thomas Nkono',FALSE,3),('Jules Onana',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=53;

-- Q54: Morocco 2022 WC semi final opponent
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('France',TRUE,1),('Portugal',FALSE,2),('Spain',FALSE,3),('England',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=54;

-- Q55: Senegal top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Sadio Mane',TRUE,1),('El Hadji Diouf',FALSE,2),('Demba Ba',FALSE,3),('Papa Bouba Diop',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=55;

-- Q56: Beat Argentina 1990
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Cameroon',TRUE,1),('Morocco',FALSE,2),('Algeria',FALSE,3),('Nigeria',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=56;

-- Q57: Cairo AFCON stadium
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Cairo International Stadium',TRUE,1),('Suez Canal Stadium',FALSE,2),('Alexandria Stadium',FALSE,3),('Nile Stadium',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=57;

-- Q58: Most African CL appearances
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Didier Drogba',FALSE,1),('Sadio Mane',FALSE,2),('Mohamed Salah',TRUE,3),('Samuel Etoo',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=58;

-- Q59: African FOY 2023
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Victor Osimhen',TRUE,1),('Mohamed Salah',FALSE,2),('Sadio Mane',FALSE,3),('Achraf Hakimi',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=59;

-- Q60: Roger Milla country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Cameroon',TRUE,1),('Ivory Coast',FALSE,2),('Senegal',FALSE,3),('DR Congo',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=60;

-- Q61: Milla age 1994
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('42',TRUE,1),('38',FALSE,2),('44',FALSE,3),('40',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=61;

-- Q62: African QF 2010
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ghana',TRUE,1),('Ivory Coast',FALSE,2),('Nigeria',FALSE,3),('Cameroon',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=62;

-- Q63: Ghana 2010 WC manager
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Milovan Rajevac',TRUE,1),('Claude Le Roy',FALSE,2),('Kwesi Appiah',FALSE,3),('Avram Grant',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=63;

-- Q64: Egypt last AFCON before 2023
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('2010',TRUE,1),('2008',FALSE,2),('2012',FALSE,3),('2006',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=64;

-- Q65: Etoo country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Cameroon',TRUE,1),('Ivory Coast',FALSE,2),('Ghana',FALSE,3),('DR Congo',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=65;

-- Q66: Etoo Barcelona goals
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('108',TRUE,1),('95',FALSE,2),('120',FALSE,3),('87',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=66;

-- Q67: Ghanaian Maestro at Arsenal
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Michael Essien',FALSE,1),('Abedi Pele',FALSE,2),('Stephen Appiah',FALSE,3),('There was no Ghanaian known as Maestro at Arsenal',TRUE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=67;

-- Q68: Moroccan club CAF CL 2024
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Wydad Casablanca',TRUE,1),('Raja Casablanca',FALSE,2),('FAR Rabat',FALSE,3),('RSB Berkane',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=68;

-- Q69: Ivory Coast top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Didier Drogba',TRUE,1),('Yaya Toure',FALSE,2),('Wilfried Zaha',FALSE,3),('Kolo Toure',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=69;

-- Q70: Hakimi country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Morocco',TRUE,1),('Algeria',FALSE,2),('Tunisia',FALSE,3),('Spain',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=70;

-- Q71: Mahrez position
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Winger',TRUE,1),('Striker',FALSE,2),('Midfielder',FALSE,3),('Full-back',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=71;

-- Q72: Yaya Toure country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ivory Coast',TRUE,1),('Ghana',FALSE,2),('Senegal',FALSE,3),('Cameroon',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=72;

-- Q73: Toure PL title club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Manchester City',TRUE,1),('Barcelona',FALSE,2),('Chelsea',FALSE,3),('Arsenal',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=73;

-- Q74: Black Panther player
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Eusebio',FALSE,1),('Salif Keita',FALSE,2),('Abedi Pele',FALSE,3),('Laurent Pokou',TRUE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=74;

-- Q75: African teams 2022 WC
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('5',TRUE,1),('4',FALSE,2),('6',FALSE,3),('3',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=75;

-- Q76: Best African 2022 WC
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Morocco',TRUE,1),('Senegal',FALSE,2),('Cameroon',FALSE,3),('Ghana',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=76;

-- Q77: Morocco QF penalty scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Yassine Bounou',FALSE,1),('Achraf Hakimi',TRUE,2),('Hakim Ziyech',FALSE,3),('Sofiane Boufal',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=77;

-- Q78: Mendy country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Senegal',TRUE,1),('Guinea',FALSE,2),('Mali',FALSE,3),('Gambia',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=78;

-- Q79: AFCON trophy name
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Trophy of African Nations',FALSE,1),('The Nations Cup Trophy',FALSE,2),('Coupe d Afrique des Nations Trophy',TRUE,3),('African Gold Cup',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=79;

-- Q80: West African never qualified
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Liberia',TRUE,1),('Gambia',FALSE,2),('Sierra Leone',FALSE,3),('Benin',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=80;

-- Q81: Most goals single calendar year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Lionel Messi (91 goals in 2012)',TRUE,1),('Gerd Muller (85 in 1972)',FALSE,2),('Cristiano Ronaldo (69 in 2013)',FALSE,3),('Josef Bican (67 in 1943)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=81;

-- Q82: Most relegated English club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Notts County',TRUE,1),('Bradford City',FALSE,2),('Derby County',FALSE,3),('Birmingham City',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=82;

-- Q83: Most goals single WC tournament
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Just Fontaine (13 goals, 1958)',TRUE,1),('Gerd Muller (10 goals, 1970)',FALSE,2),('Miroslav Klose (8 goals, 2002)',FALSE,3),('Ronaldo (8 goals, 2002)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=83;

-- Q84: First UEFA Euro winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Soviet Union',TRUE,1),('Yugoslavia',FALSE,2),('Spain',FALSE,3),('Germany',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=84;

-- Q85: France all-time top scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Olivier Giroud',TRUE,1),('Thierry Henry',FALSE,2),('Kylian Mbappe',FALSE,3),('Zinedine Zidane',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=85;

-- Q86: Ronaldo left Real Madrid for
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Juventus',TRUE,1),('Manchester United',FALSE,2),('PSG',FALSE,3),('Al Nassr',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=86;

-- Q87: Spain Euro 2008 and 2012 coach
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Vicente del Bosque',TRUE,1),('Luis Aragones',FALSE,2),('Julen Lopetegui',FALSE,3),('Luis Enrique',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=87;

-- Q88: ABBA penalty shootout
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('ABBA format',TRUE,1),('Sudden death format',FALSE,2),('Golden penalty',FALSE,3),('Penalty lottery',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=88;

-- Q89: Most Copa America wins
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Uruguay (15)',TRUE,1),('Argentina (16)',FALSE,2),('Brazil (9)',FALSE,3),('Chile (2)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=89;

-- Q90: Euro 2000 golden goal scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('David Trezeguet',TRUE,1),('Zinedine Zidane',FALSE,2),('Thierry Henry',FALSE,3),('Patrick Vieira',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=90;

-- Q91: Der Klassiker clubs
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Bayern Munich vs Borussia Dortmund',TRUE,1),('Bayern Munich vs RB Leipzig',FALSE,2),('Borussia Dortmund vs Schalke',FALSE,3),('Bayern Munich vs Hamburg',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=91;

-- Q92: Bayern Bundesliga titles
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('33',TRUE,1),('28',FALSE,2),('25',FALSE,3),('30',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=92;

-- Q93: Serie A all-time scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Silvio Piola (274)',TRUE,1),('Giuseppe Meazza (216)',FALSE,2),('Gunnar Nordahl (225)',FALSE,3),('Francesco Totti (250)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=93;

-- Q94: San Siro clubs
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('AC Milan and Inter Milan',TRUE,1),('Juventus and AC Milan',FALSE,2),('AC Milan and Lazio',FALSE,3),('Inter Milan and Atalanta',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=94;

-- Q95: Premier League year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('1992',TRUE,1),('1990',FALSE,2),('1995',FALSE,3),('1988',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=95;

-- Q96: First Ballon d'Or winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Stanley Matthews',TRUE,1),('Alfredo Di Stefano',FALSE,2),('Raymond Kopa',FALSE,3),('Jusuf Mzali',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=96;

-- Q97: Zidane three UCL as manager
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Real Madrid',TRUE,1),('Juventus',FALSE,2),('Barcelona',FALSE,3),('France National Team',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=97;

-- Q98: PL squad maximum
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('25',TRUE,1),('23',FALSE,2),('30',FALSE,3),('22',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=98;

-- Q99: 2022 UCL extra time scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Karim Benzema',TRUE,1),('Vinicius Jr',FALSE,2),('Luka Modric',FALSE,3),('Federico Valverde',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=99;

-- Q100: First African World Cup host
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('South Africa (2010)',TRUE,1),('Egypt (1990)',FALSE,2),('Morocco (1994)',FALSE,3),('Nigeria (2006)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=100;

-- Q101: Cruyff total football
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Total Football',TRUE,1),('Tiki-Taka',FALSE,2),('Gegenpressing',FALSE,3),('Catenaccio',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=101;

-- Q102: Ligue 1 all-time scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Delio Onnis',TRUE,1),('Kylian Mbappe',FALSE,2),('Zlatan Ibrahimovic',FALSE,3),('Just Fontaine',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=102;

-- Q103: Ibrahimovic most league titles club
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('PSG (4 Ligue 1)',FALSE,1),('AC Milan',FALSE,2),('Juventus',FALSE,3),('All clubs equally - PSG with 4',TRUE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=103;

-- Q104: Youngest WC scorer
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Pele (17 years 239 days)',TRUE,1),('Cesc Fabregas (17)',FALSE,2),('Wayne Rooney (17)',FALSE,3),('Kylian Mbappe (19)',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=104;

-- Q105: SA country never won Copa America
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Colombia',TRUE,1),('Ecuador',FALSE,2),('Venezuela',FALSE,3),('Bolivia',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=105;

-- Q106: UCL bench subs
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('12',TRUE,1),('7',FALSE,2),('9',FALSE,3),('5',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=106;

-- Q107: Panenka 1976
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Antonin Panenka',TRUE,1),('Franz Beckenbauer',FALSE,2),('Johan Cruyff',FALSE,3),('Gerd Muller',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=107;

-- Q108: First Club World Cup winner
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Corinthians (Brazil)',TRUE,1),('Real Madrid',FALSE,2),('Manchester United',FALSE,3),('Boca Juniors',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=108;

-- Q109: Most clubs managed top 5 leagues
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Guus Hiddink',FALSE,1),('Sven Goran Eriksson',TRUE,2),('Harry Redknapp',FALSE,3),('Juande Ramos',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=109;

-- Q110: Puskas Award
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Goal of the Year',TRUE,1),('Most goals in a season',FALSE,2),('Best striker award',FALSE,3),('Top scorer in World Cup',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=110;

-- Q111: Most UCL appearances
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Cristiano Ronaldo',TRUE,1),('Iker Casillas',FALSE,2),('Lionel Messi',FALSE,3),('Xavi Hernandez',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=111;

-- Q112: Five consecutive Ballon d'Or
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Lionel Messi (2009-2012 then 2019)',FALSE,1),('No player has won 5 consecutive',FALSE,2),('Lionel Messi won 4 consecutive 2009-2012',TRUE,3),('Cristiano Ronaldo 2016-2020',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=112;

-- Q113: Most UCL clubs by country
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Spain',TRUE,1),('England',FALSE,2),('Germany',FALSE,3),('Italy',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=113;

-- Q114: UEFA meaning
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Union of European Football Associations',TRUE,1),('United European Football Association',FALSE,2),('Universal European Football Alliance',FALSE,3),('Union of Elite Football Associations',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=114;

-- Q115: Hat-trick against Germany for Brazil
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Ronaldo',FALSE,1),('Bebeto',FALSE,2),('Romario',FALSE,3),('No Brazilian scored a hat-trick against Germany in 1994',TRUE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=115;

-- Q116: Suarez after Liverpool
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Barcelona',TRUE,1),('Real Madrid',FALSE,2),('Juventus',FALSE,3),('Atletico Madrid',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=116;

-- Q117: Wenger Arsenal appointment year
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('1996',TRUE,1),('1994',FALSE,2),('1998',FALSE,3),('2000',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=117;

-- Q118: Mourinho at Porto
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Nobody managed Mourinho. He was the manager',TRUE,1),('Bobby Robson',FALSE,2),('Louis van Gaal',FALSE,3),('Claudio Ranieri',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=118;

-- Q119: 2016 UCL final venue
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('San Siro, Milan',TRUE,1),('Wembley, London',FALSE,2),('Allianz Arena, Munich',FALSE,3),('Bernabeu, Madrid',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=119;

-- Q120: 2016 UCL final winning goal
INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order")
SELECT q.id,o.opt,o.ic,o.ord FROM public.quiz_questions q,
(VALUES ('Cristiano Ronaldo (penalty shootout)',TRUE,1),('Sergio Ramos',FALSE,2),('Gareth Bale',FALSE,3),('Karim Benzema',FALSE,4)) AS o(opt,ic,ord)
WHERE q.quiz_week_id=(SELECT id FROM public.quiz_weeks WHERE week_number=3) AND q."order"=120;
