-- ============================================================
-- OFA Academy — Additional Lessons  v2 (correct PostgreSQL)
-- Run AFTER more_courses.sql
-- No DO blocks — pure INSERT...SELECT...JOIN
-- ============================================================

INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index)
SELECT c.id, v.title, v.content, v.icon, v.duration, v.difficulty, v.target_audience, v.order_index
FROM public.courses c
JOIN (VALUES

  -- GOALKEEPING MASTERCLASS
  ('Goalkeeping Masterclass', 'Goalkeeper Positioning and Angles',
   E'A goalkeeper''s first job is positioning. Good positioning reduces what an attacker can see of the goal.\n\nAngle Reduction:\nWhen 1v1 with an attacker, come off your line to narrow the angle. The further you come, the smaller the target. But go too far and the lob becomes dangerous.\n\nThe Ready Position:\n• Feet shoulder-width apart\n• Weight on balls of feet\n• Slight bend in knees\n• Hands at hip height, ready\n• Eyes on the ball AT ALL TIMES\n\nSetting Your Line:\nFor crosses, stand on or near the 6-yard box. For shots from distance, stand near the penalty spot line.\n\nGoal Mapping Exercise:\nPractise standing in different positions relative to attackers. Have a coach mark your starting position and score your angle reduction.',
   'bi-crosshair', '35 min', 'intermediate', 'player', 1),

  ('Goalkeeping Masterclass', 'Shot-Stopping Techniques',
   E'Shot-stopping is the most watched GK skill but least practised at grassroots level.\n\nDiving Saves:\n1. Drive off the opposite foot to where you are diving.\n2. Lead with hands FIRST, then body follows.\n3. Land on the side of body, never on elbow.\n4. Get up immediately after every save.\n\nLow Saves:\nScoop technique for balls along ground. Get down early, two-hand scoop, clutch to chest.\n\nHigh Saves:\nFull stretch saves: palm the ball over or around post. Do not parry back into danger.\n\nReaction Saves:\nClose range shots require pure reflex. Train with rapid-fire shooting drills from 6-10 yards.\n\nDrill: Rapid-fire shooting. 3 players take shots from various angles continuously. GK has 2 seconds between each shot. 5-minute rounds.',
   'bi-shield-shaded', '40 min', 'intermediate', 'player', 2),

  ('Goalkeeping Masterclass', 'Distribution and Playing Out from the Back',
   E'Modern goalkeepers are the first attackers. Poor distribution wastes possession.\n\nTypes of Distribution:\n\nGoal Kick Long:\nBypass the press. Strike through the bottom half of ball with instep. Aim for a player chest.\n\nGoal Kick Short:\nRecycle possession to centre-back. Effective against high press.\n\nJavelin Throw:\nRapid counter-attack tool. Throw to wide players making runs. Aim for feet or space ahead.\n\nRolled Pass:\nFor close distribution. One-touch football starts here.\n\nDrop Kick or Volley:\nFor switching play quickly. Drop ball, half-volley or full volley to opposite flank.\n\nKey Rule:\nIn tight situations, take the safe option. A bad decision from the goalkeeper can cost the match.',
   'bi-arrow-up-right-circle-fill', '30 min', 'beginner', 'player', 3),

  ('Goalkeeping Masterclass', 'Commanding the Penalty Area',
   E'The goalkeeper must be the leader of the defensive unit. Organising and communicating is just as important as saves.\n\nKey Commands:\n• KEEPER: You are coming to claim the ball. Shout LOUDLY before you move.\n• AWAY: Tell defenders to clear the ball. Used on crosses and corners you cannot reach safely.\n• MAN ON: Alert a teammate that pressure is coming from behind.\n• HOLD: Tell defenders to hold their line and not dive into tackles.\n\nClaiming Crosses:\n1. Call KEEPER early and loudly.\n2. Move decisively — do not hesitate.\n3. Catch at the highest point you can reach.\n4. Protect the ball immediately on landing.\n5. If in doubt, PUNCH with two fists to safety.\n\nFootball IQ for Goalkeepers:\nAlways know where your nearest teammate is. Always know where the next danger is. Scan the pitch every 3-4 seconds.',
   'bi-megaphone-fill', '30 min', 'intermediate', 'player', 4),

  -- COACHING AND REFEREEING FUNDAMENTALS
  ('Coaching and Refereeing Fundamentals', 'How to Plan a Training Session',
   E'Every elite coach plans every session in advance.\n\nThe Session Structure (90 minutes):\n\n1. Warm-Up (15 mins):\nLight jog, dynamic stretching, activation drills with ball. Build intensity gradually.\n\n2. Technical Focus (20 mins):\nIsolate one skill: passing, shooting, defending. High repetition, low pressure.\n\n3. Functional Training (25 mins):\nApply the skill in a game-related context. Small-sided games, positional play.\n\n4. Match Play (25 mins):\nFull game or large-sided game. Apply everything from the session.\n\n5. Cool Down (5 mins):\nLight jog, static stretching, hydration.\n\nSession Planning Tips:\n• Write your objective FIRST: What do you want players to leave knowing?\n• Overplan: Prepare more than you need.\n• Evaluate after every session: What worked? What did not?\n• Age-appropriate: U13 training must be FUN first.',
   'bi-clipboard-check-fill', '30 min', 'beginner', 'coach', 1),

  ('Coaching and Refereeing Fundamentals', 'Communication and Player Management',
   E'The best coaches are the best communicators.\n\nCoaching Communication Principles:\n\n1. Be Specific:\nDo not say "pass better." Say "when you receive the ball, open your body so you can see the pitch before you play."\n\n2. Positive First:\nPraise what is done well before correcting. Players respond better to encouragement.\n\n3. One Instruction at a Time:\nDo not overload young players. Pick the most important point.\n\n4. Ask Questions:\n"What did you see when you received that ball?" makes the player think.\n\n5. Consistency:\nTreat all players fairly. No favouritism. Standards apply to everyone.\n\nHandling Conflict:\n• Separate the player from the behaviour.\n• Private conversations for sensitive matters.\n• Involve parents early if a player is struggling.',
   'bi-chat-quote-fill', '25 min', 'beginner', 'coach', 2),

  ('Coaching and Refereeing Fundamentals', 'Laws of the Game for Referees',
   E'A referee who knows the laws thoroughly commands respect.\n\nKey Decision Points:\n\nOffside:\nA player is offside if any part that can play the ball is closer to the goal line than both ball and second-to-last opponent WHEN the ball is played.\n\nFouls and Misconduct:\n• Direct free kick: Tripping, pushing, striking, holding, handball.\n• Indirect free kick: Dangerous play, obstruction.\n• Yellow Card: Persistent fouling, dissent, time-wasting.\n• Red Card: Serious foul play, violent conduct, DOGSO, abusive language.\n\nPenalty Kicks:\nOccur when a direct free kick offence happens inside the penalty area by the defending team.\n\nVAR Protocol:\nReview four categories only: Goals, Penalties, Red Cards, Mistaken Identity.\n\nReferee Fitness:\nA referee must cover 10-12km per match. Fitness training is essential.',
   'bi-person-badge-fill', '40 min', 'intermediate', 'coach', 3),

  ('Coaching and Refereeing Fundamentals', 'Tactical Coaching — Small-Sided Games',
   E'Small-sided games are the most effective coaching tool ever invented. More touches, more decisions, more learning.\n\nWhy Small-Sided Games Work:\n• Every player touches the ball far more than in 11v11.\n• Decisions happen faster — tactical understanding develops.\n• More goals scored — players stay motivated.\n• Easy to manipulate rules to focus on your coaching theme.\n\nExample Small-Sided Games:\n\n3v3 on Mini Goals:\nObjective: Quick combinations, movement off the ball.\nRule: Maximum 2 touches.\n\n4v4 with Neutral Players:\nObjective: Possession and pressing.\nRule: Neutral players always play with team in possession.\n\n5v5 Transition Game:\nObjective: Speed of transition from defence to attack.\nRule: Score within 6 seconds of winning possession.\n\nCoaching Point:\nStop the game when you see a teachable moment. Reset players. Show the correct action. Restart.',
   'bi-diagram-2-fill', '35 min', 'intermediate', 'coach', 4),

  -- FITNESS AND CONDITIONING
  ('Fitness and Conditioning', 'Speed and Sprint Training for Footballers',
   E'Speed wins games. A 5% improvement in sprint speed can be the difference between good and great.\n\nTypes of Speed in Football:\n• Acceleration: 0-10m explosive burst from standing.\n• Top Speed: 20-40m full sprint.\n• Change of Direction Speed: Agility.\n\nSprint Training Drills:\n\n1. Flying 30s:\nJog 20m to build speed, then sprint flat out for 30m. Rest 90 seconds. Repeat 6 times.\n\n2. Acceleration Ladders:\nStart from lying face down. Jump up and sprint 10m. Rest 60 seconds. Repeat 8 times.\n\n3. T-Drill:\nSet up 4 cones in T-shape. Sprint forward, shuffle left, shuffle right, shuffle back, backpedal. Improves acceleration AND agility.\n\nKey Tips:\n• Sprint training 2x per week maximum.\n• Always warm up properly before sprinting.\n• Rest fully between reps.',
   'bi-lightning-charge-fill', '35 min', 'intermediate', 'player', 1),

  ('Fitness and Conditioning', 'Endurance and Stamina for 90 Minutes',
   E'A player who cannot last 90 minutes cannot perform when the game is decided — usually the last 20 minutes.\n\nFootball Fitness Facts:\nA typical outfield player runs 10-13km per match. 70-80% walking and jogging. 20-30% high-intensity.\n\nBuilding Aerobic Base:\n\n1. Long Runs (2x per week off-season):\n20-30 minute continuous runs at conversational pace.\n\n2. Fartlek Training:\nAlternate fast and slow running. Sprint 30 seconds, jog 1 minute. Repeat 20 minutes.\n\n3. Interval Training:\n200m sprints with 60-second rest. 8-10 repetitions.\n\nFootball Specific:\nRondo (3v1) for 10 minutes without stopping. Players move constantly. Rest 2 minutes. Repeat.\n\nHydration:\nDrink 500ml water 2 hours before training. 200ml every 15 minutes during. Replace sweat after.',
   'bi-heart-pulse', '30 min', 'beginner', 'player', 2),

  ('Fitness and Conditioning', 'Strength Training for Young Footballers',
   E'Strength training does NOT stunt growth. Age-appropriate strength training improves performance and reduces injury.\n\nAge Guidelines:\nUnder 16: Bodyweight only. No heavy weights.\n16-18: Light weights with proper technique. Focus on form.\n18+: Progressive resistance training under supervision.\n\nBodyweight Exercises:\n\n1. Squats (3 x 15):\nFeet shoulder-width. Lower until thighs parallel to floor. Drive up through heels.\n\n2. Lunges (3 x 10 each leg):\nBuilds quad and glute strength for acceleration.\n\n3. Push-ups (3 x 15):\nUpper body and core. Important for shielding the ball.\n\n4. Plank (3 x 30-60 seconds):\nCore stability is fundamental. Weak core means poor balance and poor technique.\n\n5. Nordic Curls (3 x 8):\nPartner holds ankles. Lower torso to floor using hamstrings. Best hamstring injury prevention exercise known.',
   'bi-activity', '35 min', 'intermediate', 'both', 3),

  ('Fitness and Conditioning', 'Agility and Coordination Drills',
   E'Agility is the ability to change direction quickly while maintaining control and balance. It separates good players from great ones.\n\nLadder Drills (5 minutes):\n1. Two feet in each box: Step both feet into each space moving forward.\n2. In-in-out-out: Both feet in, both feet out to side, repeat.\n3. Lateral shuffle: Sideways through ladder, two feet each box.\n4. Crossover step: Cross one foot in front of the other moving laterally.\n\nCone Drills:\n1. Box drill: 4 cones in square, 5m apart. Sprint each side, different movements.\n2. 5-10-5 drill: Sprint 5m right, sprint 10m left, sprint 5m right back to start.\n3. W-drill: 5 cones in W pattern. Sprint, backpedal, sprint.\n\nBall Coordination:\nJuggling is the single best coordination drill for footballers. Target 100 consecutive juggles. Then 100 with each foot separately.',
   'bi-arrows-move', '30 min', 'beginner', 'player', 4),

  -- EXTRA LESSONS FOR EXISTING COURSES
  ('Technical Training', 'Set Pieces and Dead Ball Situations',
   E'Set pieces account for approximately 30% of all professional goals. Practising them is a massive competitive advantage.\n\nCorner Kicks:\n• Near post run: Attack near post to flick on or score.\n• Far post run: Attack far post for header or volley.\n• Short corner: Two players combine near flag for different angle.\n\nFree Kicks:\nDirect bent: Curve using inside of foot. Plant foot 30cm to side of ball.\nDirect power: Through or over wall with instep. Lean back slightly.\nIndirect: Pass to teammate who shoots.\n\nThrow-ins:\nAlways have a short and long option. Quick throw-ins catch opponents off guard.\n\nOFA Drill:\nPractise 10 corner kicks and 10 free kicks from different positions every single training session. Set pieces win championships.',
   'bi-flag-fill', '35 min', 'intermediate', 'both', 6),

  ('Sports Psychology', 'Concentration and Focus Techniques',
   E'A lapse in concentration at the wrong moment can cost a match.\n\nWhy Focus Breaks Down:\n• Fatigue — physical and mental.\n• Negative self-talk after mistakes.\n• Crowd or opposition noise.\n• Result thinking instead of process thinking.\n\nFocus Training Techniques:\n\n1. Pre-ball Focus Cue:\nEvery time you receive the ball, use a trigger word like "See it" to focus fully.\n\n2. Process Focus:\nFocus only on the next action, not the scoreline.\n\n3. Mindfulness:\n10 minutes daily focused breathing. Builds mental endurance.\n\n4. Simulation Training:\nPractise in noisy environments to build crowd noise tolerance.\n\nPost-Mistake Reset:\nClinch fist, take one breath, say your reset word, move forward. Never let one mistake become two.',
   'bi-eye-fill', '25 min', 'intermediate', 'both', 4),

  ('Health Education', 'Sleep and Recovery Science',
   E'Sleep is the most powerful free recovery tool available to every athlete.\n\nWhat Happens During Sleep:\n• Growth hormone released — essential for muscle repair.\n• Motor skills embedded during memory consolidation.\n• Immune system strengthens.\n• Inflammation from training reduces.\n\nSleep Requirements:\n• Ages 13-18: 8-10 hours per night.\n• Adults: 7-9 hours per night.\n\nSleep Quality Tips:\n1. Consistent schedule — same bedtime and wake time daily.\n2. No screens 30 minutes before bed — blue light suppresses melatonin.\n3. Cool, dark, quiet room.\n4. No caffeine after 2pm.\n\nPower Naps:\n20-minute afternoon nap restores alertness. Do not exceed 25 minutes or you enter deep sleep and wake groggy.',
   'bi-moon-stars-fill', '25 min', 'beginner', 'both', 4),

  ('Football Education', 'Understanding the Modern Offside Rule',
   E'The offside rule is the most debated law in football.\n\nThe Basic Rule:\nA player is in an offside position if any part of their body that can play the ball is closer to the opponents goal line than both the ball AND the second-to-last defender.\n\nWhen is it an Offence?\nBeing in an offside position is NOT an offence by itself. A player is only penalised if involved in ACTIVE PLAY:\n• Touching or playing the ball.\n• Interfering with an opponent.\n• Gaining an advantage from being offside.\n\nVAR and Offside:\nVAR draws lines from the foremost body part of the attacker and the last defender. Even a shoulder ahead can be offside.\n\nOnside Situations:\n• Receiving the ball directly from a goal kick, corner kick, or throw-in.\n• Being in your own half.\n• Being level with the last defender is ONSIDE.',
   'bi-info-circle-fill', '25 min', 'intermediate', 'both', 7)

) AS v(course_title, title, content, icon, duration, difficulty, target_audience, order_index)
ON c.title = v.course_title;
