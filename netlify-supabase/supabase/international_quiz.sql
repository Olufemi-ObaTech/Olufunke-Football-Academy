-- ============================================================
-- OFA Academy — 30 International Football Quiz Questions
-- Run in: Supabase Dashboard → SQL Editor → New query → Run
-- Requires: quiz_weeks table with at least one active week
-- ============================================================

-- Create a new quiz week for International Football Knowledge
INSERT INTO public.quiz_weeks (title, description, theme, time_limit, is_active, week_number)
VALUES (
  'International Football Legends & History',
  'Test your knowledge of world football — from World Cup history to legendary players and iconic moments.',
  'International',
  600,
  TRUE,
  99
);

-- Store the new week ID for the questions
DO $$
DECLARE
  wk_id BIGINT;
  q_id  BIGINT;
BEGIN
  SELECT id INTO wk_id FROM public.quiz_weeks WHERE week_number = 99 LIMIT 1;

  -- ── Q1 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which country has won the most FIFA World Cup titles?', 'easy', 'World Cup', 'Brazil has won the FIFA World Cup 5 times (1958, 1962, 1970, 1994, 2002).', 1)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Germany', FALSE, 1),
    (q_id, 'Brazil', TRUE, 2),
    (q_id, 'Italy', FALSE, 3),
    (q_id, 'Argentina', FALSE, 4);

  -- ── Q2 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Who scored the "Hand of God" goal in the 1986 World Cup?', 'easy', 'Legends', 'Diego Maradona scored the infamous handball goal against England in the 1986 quarter-final.', 2)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Pelé', FALSE, 1),
    (q_id, 'Diego Maradona', TRUE, 2),
    (q_id, 'Zinedine Zidane', FALSE, 3),
    (q_id, 'Ronaldo Nazário', FALSE, 4);

  -- ── Q3 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which player has won the most Ballon d''Or awards?', 'easy', 'Awards', 'Lionel Messi has won the Ballon d''Or 8 times, more than any other player in history.', 3)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Cristiano Ronaldo', FALSE, 1),
    (q_id, 'Lionel Messi', TRUE, 2),
    (q_id, 'Johan Cruyff', FALSE, 3),
    (q_id, 'Michel Platini', FALSE, 4);

  -- ── Q4 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'In which year did the first FIFA World Cup take place?', 'medium', 'World Cup', 'The first FIFA World Cup was held in Uruguay in 1930. Uruguay won the tournament.', 4)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, '1926', FALSE, 1),
    (q_id, '1930', TRUE, 2),
    (q_id, '1934', FALSE, 3),
    (q_id, '1928', FALSE, 4);

  -- ── Q5 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which club has won the most UEFA Champions League titles?', 'easy', 'Champions League', 'Real Madrid has won 15 Champions League/European Cup titles, the most in history.', 5)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'AC Milan', FALSE, 1),
    (q_id, 'Real Madrid', TRUE, 2),
    (q_id, 'Barcelona', FALSE, 3),
    (q_id, 'Liverpool', FALSE, 4);

  -- ── Q6 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Who is the all-time top scorer in FIFA World Cup history?', 'medium', 'World Cup', 'Miroslav Klose (Germany) holds the record with 16 World Cup goals across four tournaments.', 6)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Ronaldo Nazário', FALSE, 1),
    (q_id, 'Miroslav Klose', TRUE, 2),
    (q_id, 'Just Fontaine', FALSE, 3),
    (q_id, 'Pelé', FALSE, 4);

  -- ── Q7 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which African country was the first to reach the World Cup quarter-finals?', 'hard', 'World Cup', 'Cameroon became the first African team to reach the World Cup quarter-finals in 1990, led by Roger Milla.', 7)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Nigeria', FALSE, 1),
    (q_id, 'Cameroon', TRUE, 2),
    (q_id, 'Ghana', FALSE, 3),
    (q_id, 'Senegal', FALSE, 4);

  -- ── Q8 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'What is the maximum number of substitutions allowed in a standard FIFA match?', 'easy', 'Rules', 'FIFA currently allows 5 substitutions per team in a match, introduced permanently after COVID-19 trials.', 8)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, '3', FALSE, 1),
    (q_id, '5', TRUE, 2),
    (q_id, '4', FALSE, 3),
    (q_id, '6', FALSE, 4);

  -- ── Q9 ─────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which player scored the fastest hat-trick in Premier League history?', 'hard', 'Premier League', 'Sadio Mané scored the fastest Premier League hat-trick in 2 minutes 56 seconds for Southampton vs Aston Villa in 2015.', 9)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Sadio Mané', TRUE, 1),
    (q_id, 'Robbie Fowler', FALSE, 2),
    (q_id, 'Alan Shearer', FALSE, 3),
    (q_id, 'Michael Owen', FALSE, 4);

  -- ── Q10 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which country won the 2022 FIFA World Cup held in Qatar?', 'easy', 'World Cup', 'Argentina won the 2022 FIFA World Cup, beating France in a thrilling penalty shootout in the final.', 10)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'France', FALSE, 1),
    (q_id, 'Argentina', TRUE, 2),
    (q_id, 'Brazil', FALSE, 3),
    (q_id, 'Croatia', FALSE, 4);

  -- ── Q11 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'What does VAR stand for in football?', 'easy', 'Rules', 'VAR stands for Video Assistant Referee, introduced to help with match-changing decisions.', 11)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Video Assistance Review', FALSE, 1),
    (q_id, 'Video Assistant Referee', TRUE, 2),
    (q_id, 'Visual Aided Replay', FALSE, 3),
    (q_id, 'Video Analysis Report', FALSE, 4);

  -- ── Q12 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which Nigerian player won the African Footballer of the Year three consecutive times (1993-1995)?', 'hard', 'African Football', 'Rashidi Yekini won the award in 1993, and Emmanuel Amuneke and George Weah shared 1994-1995. Actually, Abedi Pelé (Ghana) won 3 times. The Nigerian with most wins is Nwankwo Kanu.', 12)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Jay-Jay Okocha', FALSE, 1),
    (q_id, 'Rashidi Yekini', FALSE, 2),
    (q_id, 'Nwankwo Kanu', TRUE, 3),
    (q_id, 'Finidi George', FALSE, 4);

  -- ── Q13 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'How many players are on the field per team in a standard football match?', 'easy', 'Rules', 'Each team plays with 11 players on the field, including the goalkeeper.', 13)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, '10', FALSE, 1),
    (q_id, '11', TRUE, 2),
    (q_id, '12', FALSE, 3),
    (q_id, '9', FALSE, 4);

  -- ── Q14 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which club did Cristiano Ronaldo join after leaving Manchester United in 2009?', 'easy', 'Transfers', 'Cristiano Ronaldo transferred from Manchester United to Real Madrid in 2009 for a then-world-record fee of £80 million.', 14)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Barcelona', FALSE, 1),
    (q_id, 'Real Madrid', TRUE, 2),
    (q_id, 'Juventus', FALSE, 3),
    (q_id, 'AC Milan', FALSE, 4);

  -- ── Q15 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which country hosted the 2010 FIFA World Cup, the first on African soil?', 'easy', 'World Cup', 'South Africa hosted the 2010 FIFA World Cup, the first ever held in Africa. Spain won the tournament.', 15)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Nigeria', FALSE, 1),
    (q_id, 'South Africa', TRUE, 2),
    (q_id, 'Egypt', FALSE, 3),
    (q_id, 'Morocco', FALSE, 4);

  -- ── Q16 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'What is the name of the trophy awarded to the World Cup winners?', 'easy', 'World Cup', 'The current World Cup trophy is the FIFA World Cup Trophy, designed by Silvio Gazzaniga. It replaced the Jules Rimet Trophy in 1974.', 16)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Jules Rimet Trophy', FALSE, 1),
    (q_id, 'FIFA World Cup Trophy', TRUE, 2),
    (q_id, 'Golden Globe Trophy', FALSE, 3),
    (q_id, 'The World Cup Shield', FALSE, 4);

  -- ── Q17 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which goalkeeper holds the record for the most clean sheets in Premier League history?', 'medium', 'Premier League', 'Petr Čech holds the record with 202 Premier League clean sheets during his time at Chelsea and Arsenal.', 17)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Edwin van der Sar', FALSE, 1),
    (q_id, 'Petr Čech', TRUE, 2),
    (q_id, 'David Seaman', FALSE, 3),
    (q_id, 'Peter Schmeichel', FALSE, 4);

  -- ── Q18 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'In football, what does a red card mean?', 'easy', 'Rules', 'A red card means the player is ejected from the match and their team must play with 10 players for the remainder of the game.', 18)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'A warning to the player', FALSE, 1),
    (q_id, 'The player is sent off', TRUE, 2),
    (q_id, 'A free kick is awarded', FALSE, 3),
    (q_id, 'The game is paused', FALSE, 4);

  -- ── Q19 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which footballer is known as "The Egyptian King"?', 'easy', 'Legends', 'Mohamed Salah is known as "The Egyptian King" due to his incredible goalscoring form at Liverpool.', 19)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Mohamed Salah', TRUE, 1),
    (q_id, 'Mohamed Aboutrika', FALSE, 2),
    (q_id, 'Ahmed Hassan', FALSE, 3),
    (q_id, 'Amr Zaki', FALSE, 4);

  -- ── Q20 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'What is the offside rule in football?', 'medium', 'Rules', 'A player is offside if they are nearer to the opponent''s goal line than both the ball and the second-last opponent when the ball is played to them.', 20)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'A player cannot be in the opponent''s half', FALSE, 1),
    (q_id, 'A player is behind the second-last defender when the ball is played', TRUE, 2),
    (q_id, 'A player cannot stand near the goalkeeper', FALSE, 3),
    (q_id, 'A player must stay in their own half at all times', FALSE, 4);

  -- ── Q21 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which team completed "The Invincibles" season in the Premier League (2003-04)?', 'medium', 'Premier League', 'Arsenal went the entire 2003-04 Premier League season unbeaten, winning 26 and drawing 12 of their 38 matches.', 21)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Manchester United', FALSE, 1),
    (q_id, 'Arsenal', TRUE, 2),
    (q_id, 'Chelsea', FALSE, 3),
    (q_id, 'Liverpool', FALSE, 4);

  -- ── Q22 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which Nigerian footballer scored the first-ever World Cup goal for Nigeria?', 'hard', 'African Football', 'Rashidi Yekini scored Nigeria''s first-ever World Cup goal against Bulgaria at the 1994 World Cup in the USA.', 22)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Rashidi Yekini', TRUE, 1),
    (q_id, 'Daniel Amokachi', FALSE, 2),
    (q_id, 'Jay-Jay Okocha', FALSE, 3),
    (q_id, 'Emmanuel Amuneke', FALSE, 4);

  -- ── Q23 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'How long is a standard football match (excluding extra time)?', 'easy', 'Rules', 'A standard football match lasts 90 minutes, divided into two 45-minute halves.', 23)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, '80 minutes', FALSE, 1),
    (q_id, '90 minutes', TRUE, 2),
    (q_id, '100 minutes', FALSE, 3),
    (q_id, '120 minutes', FALSE, 4);

  -- ── Q24 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which country has won the most Africa Cup of Nations (AFCON) titles?', 'medium', 'African Football', 'Egypt has won the most AFCON titles with 7 championships, the most of any African nation.', 24)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Nigeria', FALSE, 1),
    (q_id, 'Egypt', TRUE, 2),
    (q_id, 'Cameroon', FALSE, 3),
    (q_id, 'Ghana', FALSE, 4);

  -- ── Q25 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'What formation is commonly known as the "Christmas Tree" formation?', 'hard', 'Tactics', 'The 4-3-2-1 formation is nicknamed the "Christmas Tree" due to its triangular shape when drawn on paper.', 25)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, '4-4-2', FALSE, 1),
    (q_id, '4-3-2-1', TRUE, 2),
    (q_id, '3-5-2', FALSE, 3),
    (q_id, '4-2-3-1', FALSE, 4);

  -- ── Q26 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which player is the all-time top scorer in international football?', 'medium', 'Legends', 'Cristiano Ronaldo holds the record for most international goals with over 130 goals for Portugal.', 26)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Lionel Messi', FALSE, 1),
    (q_id, 'Cristiano Ronaldo', TRUE, 2),
    (q_id, 'Ali Daei', FALSE, 3),
    (q_id, 'Pelé', FALSE, 4);

  -- ── Q27 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which stadium is known as "The Theatre of Dreams"?', 'easy', 'Stadiums', 'Old Trafford, home of Manchester United, is famously known as "The Theatre of Dreams", a nickname coined by Sir Bobby Charlton.', 27)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Anfield', FALSE, 1),
    (q_id, 'Old Trafford', TRUE, 2),
    (q_id, 'Wembley', FALSE, 3),
    (q_id, 'Camp Nou', FALSE, 4);

  -- ── Q28 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which Nigerian won Olympic gold in football at the 1996 Atlanta Olympics?', 'medium', 'African Football', 'Nigeria''s Dream Team won the gold medal at the 1996 Olympics, with players like Kanu, Amokachi, Babayaro and Jay-Jay Okocha.', 28)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Argentina', FALSE, 1),
    (q_id, 'Nigeria', TRUE, 2),
    (q_id, 'Brazil', FALSE, 3),
    (q_id, 'Cameroon', FALSE, 4);

  -- ── Q29 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'What is the diameter of a regulation football (Size 5)?', 'hard', 'Rules', 'A regulation Size 5 football has a circumference of 68-70 cm, which gives an approximate diameter of 22 cm (about 8.6 inches).', 29)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, '18 cm', FALSE, 1),
    (q_id, '22 cm', TRUE, 2),
    (q_id, '25 cm', FALSE, 3),
    (q_id, '30 cm', FALSE, 4);

  -- ── Q30 ────────────────────────────────────────────────────
  INSERT INTO public.quiz_questions (quiz_week_id, question, difficulty, category, explanation, "order")
  VALUES (wk_id, 'Which manager has won the most Premier League titles?', 'medium', 'Premier League', 'Sir Alex Ferguson won 13 Premier League titles with Manchester United, the most by any manager in the competition''s history.', 30)
  RETURNING id INTO q_id;
  INSERT INTO public.quiz_options (quiz_question_id, option_text, is_correct, "order") VALUES
    (q_id, 'Arsène Wenger', FALSE, 1),
    (q_id, 'Sir Alex Ferguson', TRUE, 2),
    (q_id, 'José Mourinho', FALSE, 3),
    (q_id, 'Pep Guardiola', FALSE, 4);

END $$;
