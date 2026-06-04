-- ============================================================
-- OFA Academy — Assign Levels 1-7 to Courses
-- Run AFTER levels_schema.sql
-- Level 1 = Foundation | Level 7 = Elite
-- 70% exam score = pass and advance | <50% = repeat
-- ============================================================

-- LEVEL 1 — Foundation (everyone starts here)
UPDATE public.courses SET level_number=1, pass_score=70, repeat_score=50
WHERE title = 'Football Education';

-- LEVEL 2 — Technical Basics
UPDATE public.courses SET level_number=2, pass_score=70, repeat_score=50
WHERE title = 'Technical Training';

-- LEVEL 3 — Mind and Body
UPDATE public.courses SET level_number=3, pass_score=70, repeat_score=50
WHERE title IN ('Sports Psychology', 'Health Education');

-- LEVEL 4 — Fitness and Conditioning
UPDATE public.courses SET level_number=4, pass_score=70, repeat_score=50
WHERE title = 'Fitness and Conditioning';

-- LEVEL 5 — Specialisation
UPDATE public.courses SET level_number=5, pass_score=70, repeat_score=50
WHERE title IN ('Goalkeeping Masterclass', 'Environmental Initiatives');

-- LEVEL 6 — Leadership and Community
UPDATE public.courses SET level_number=6, pass_score=70, repeat_score=50
WHERE title IN ('Community Engagement', 'Coaching and Refereeing Fundamentals');

-- LEVEL 7 — Elite Development (top level)
-- Future courses will be added here
-- For now mark any remaining courses as level 7
UPDATE public.courses SET level_number=7, pass_score=75, repeat_score=55
WHERE level_number IS NULL OR level_number = 1
  AND title NOT IN (
    'Football Education','Technical Training','Sports Psychology',
    'Health Education','Fitness and Conditioning','Goalkeeping Masterclass',
    'Environmental Initiatives','Community Engagement',
    'Coaching and Refereeing Fundamentals'
  );

-- ── ADD EXAM QUESTIONS FOR LESSON 1 (Football Education → Laws of the Game) ──
INSERT INTO public.lesson_exams (lesson_id, question, option_a, option_b, option_c, option_d, correct_option, explanation, "order")
SELECT l.id,
       v.q, v.a, v.b, v.c, v.d, v.co, v.exp, v.ord
FROM public.lessons l
JOIN public.courses c ON c.id = l.course_id
JOIN (VALUES
  ('The Laws of the Game', 'How many Laws of the Game govern football?',
   '12', '15', '17', '20', 'c', 'There are 17 Laws of the Game maintained by IFAB.', 1),
  ('The Laws of the Game', 'What is the standard length of a football match?',
   '80 minutes', '90 minutes', '100 minutes', '70 minutes', 'b', 'A standard match is 90 minutes — two 45-minute halves.', 2),
  ('The Laws of the Game', 'How many players must a team have to continue playing?',
   '9', '8', '7', '6', 'c', 'Under Law 3, a team must have a minimum of 7 players to continue.', 3),
  ('The Laws of the Game', 'What card is shown for serious foul play?',
   'Yellow card', 'Orange card', 'Blue card', 'Red card', 'd', 'A red card results in dismissal for serious foul play.', 4),
  ('The Laws of the Game', 'What is the width of a standard football goal?',
   '6.5m', '7.32m', '8.0m', '7.0m', 'b', 'Standard goal width is 7.32m, height is 2.44m.', 5)
) AS v(lesson_title, q, a, b, c, d, co, exp, ord)
ON l.title = v.lesson_title AND c.title = 'Football Education';

-- ── ADD EXAM QUESTIONS FOR Technical Training → Ball Mastery ──
INSERT INTO public.lesson_exams (lesson_id, question, option_a, option_b, option_c, option_d, correct_option, explanation, "order")
SELECT l.id,
       v.q, v.a, v.b, v.c, v.d, v.co, v.exp, v.ord
FROM public.lessons l
JOIN public.courses c ON c.id = l.course_id
JOIN (VALUES
  ('Ball Mastery Fundamentals', 'Which ball mastery drill involves pulling the ball back with the sole then pushing it forward?',
   'V-Move', 'Cruyff Turn', 'Inside-Outside', 'Step Over', 'a', 'The V-Move trains close control: pull back with sole, push forward with inside of foot.', 1),
  ('Ball Mastery Fundamentals', 'How long should you do ball mastery drills daily?',
   '5 minutes', '10 minutes', '20 minutes', '45 minutes', 'c', '20 minutes of ball mastery daily leads to dramatic improvement within 6 weeks.', 2),
  ('Ball Mastery Fundamentals', 'Which foot should you practise ball mastery with?',
   'Dominant foot only', 'Weaker foot only', 'Both feet', 'Whichever feels comfortable', 'c', 'OFA expects all players to be technically comfortable on both feet.', 3),
  ('Ball Mastery Fundamentals', 'The Cruyff Turn is named after which legendary player?',
   'Pele', 'Diego Maradona', 'Johan Cruyff', 'Ronaldinho', 'c', 'The Cruyff Turn was invented by Dutch legend Johan Cruyff.', 4),
  ('Ball Mastery Fundamentals', 'What does Sole Juggling train?',
   'Power', 'Rhythm and close control', 'Speed', 'Shooting technique', 'b', 'Sole juggling trains rhythm and close control under the foot.', 5)
) AS v(lesson_title, q, a, b, c, d, co, exp, ord)
ON l.title = v.lesson_title AND c.title = 'Technical Training';

-- ── ADD EXAM QUESTIONS FOR Sports Psychology → Mental Toughness ──
INSERT INTO public.lesson_exams (lesson_id, question, option_a, option_b, option_c, option_d, correct_option, explanation, "order")
SELECT l.id,
       v.q, v.a, v.b, v.c, v.d, v.co, v.exp, v.ord
FROM public.lessons l
JOIN public.courses c ON c.id = l.course_id
JOIN (VALUES
  ('Mental Toughness in Football', 'What are the 4 Cs of Mental Toughness?',
   'Confidence, Courage, Creativity, Control', 'Control, Commitment, Challenge, Confidence', 'Calm, Competitive, Creative, Consistent', 'Concentration, Confidence, Courage, Control', 'b', 'The 4 Cs are Control, Commitment, Challenge, and Confidence.', 1),
  ('Mental Toughness in Football', 'Mental toughness is something you are born with — true or false?',
   'True', 'False — it is trainable', 'Only partly trainable', 'Depends on genetics', 'b', 'Mental toughness is trainable. It is NOT something you are simply born with.', 2),
  ('Mental Toughness in Football', 'Cristiano Ronaldo visualises which action before every game?',
   'Making a save', 'Scoring', 'Winning the toss', 'Making a tackle', 'b', 'Ronaldo visualises scoring before every match — a powerful mental preparation technique.', 3)
) AS v(lesson_title, q, a, b, c, d, co, exp, ord)
ON l.title = v.lesson_title AND c.title = 'Sports Psychology';

-- Verify levels assigned
SELECT title, level_number, pass_score, repeat_score FROM public.courses ORDER BY level_number;
