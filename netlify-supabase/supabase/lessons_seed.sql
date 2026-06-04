-- ============================================================
-- OFA Academy — Course Lessons Seed  v2 (fixed syntax)
-- Run AFTER seed.sql in Supabase SQL Editor
-- ============================================================

-- Prevent duplicates if run multiple times
DELETE FROM public.lessons WHERE course_id IN (
  SELECT id FROM public.courses WHERE title IN (
    'Football Education','Technical Training','Sports Psychology',
    'Health Education','Environmental Initiatives','Community Engagement'
  )
);

-- Insert all lessons directly using subqueries for course_id
INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index)
SELECT c.id,
       v.title, v.content, v.icon, v.duration, v.difficulty, v.target_audience, v.order_index
FROM public.courses c
JOIN (VALUES

  -- ══ COURSE 1: Football Education ══════════════════════════════
  ('Football Education', 'The Laws of the Game',
   E'Football is governed by 17 Laws of the Game maintained by IFAB.\n\nKey Laws:\n• Law 1 - The Field of Play: 100-110m long, 64-75m wide. Goal: 7.32m wide, 2.44m high.\n• Law 2 - The Ball: Circumference 68-70cm, pressure 0.6-1.1 atmosphere.\n• Law 3 - Players: 11 per team including goalkeeper. Minimum 7 to continue.\n• Law 4 - Equipment: Jersey, shorts, socks, shin guards, and boots required.\n• Law 5 - The Referee: Full authority. Decisions are final.\n• Law 12 - Fouls and Misconduct: Direct/indirect free kicks. Yellow and red cards.\n\nUnderstanding these laws helps you play smarter and earn respect from referees.',
   'bi-book-fill', '25 min', 'beginner', 'both', 1),

  ('Football Education', 'Football Ethics and Fair Play',
   E'FIFA Fair Play Campaign promotes respect, integrity, and sportsmanship.\n\nCore Principles:\n• Respect opponents - they are partners in creating a great game.\n• Respect the referee - even when you disagree with a decision.\n• No discrimination - race, religion, gender, or background must never be a basis for disrespect.\n• Anti-doping - never use performance-enhancing substances.\n• No match-fixing - the integrity of the game depends on every player.\n\nAt OFA, champions are made not just on the pitch but in how they carry themselves off it.',
   'bi-award-fill', '20 min', 'beginner', 'both', 2),

  ('Football Education', 'History of Nigerian Football',
   E'Nigeria has one of the richest football histories in Africa.\n\nKey Milestones:\n• 1945 - First organised football association formed in Nigeria.\n• 1960 - NFA affiliated with FIFA at independence.\n• 1980 - Nigeria wins first AFCON.\n• 1994 - Nigeria qualify for first-ever FIFA World Cup.\n• 1996 - Super Eagles win Olympic Gold at Atlanta.\n• 2013 - Nigeria wins AFCON in South Africa under Stephen Keshi.\n\nFamous Nigerian Players:\nJay-Jay Okocha, Nwankwo Kanu (3x African Footballer of Year), Rashidi Yekini, John Obi Mikel, Vincent Enyeama, Victor Osimhen.',
   'bi-flag-fill', '30 min', 'beginner', 'player', 3),

  ('Football Education', 'Football Positions Explained',
   E'Understanding your position is fundamental to becoming a complete footballer.\n\nGoalkeeper (GK): Quick reflexes, commands penalty area, distributes effectively.\n\nDefenders:\n• Centre-Back (CB): Dominant in the air and ground, leads defensive line.\n• Full-Back (RB/LB): Supports attack and defence down flanks.\n• Wing-Back: More attacking than full-backs in modern systems.\n\nMidfielders:\n• Defensive Midfielder (DM): Protects back four, intercepts and recycles possession.\n• Central Midfielder (CM): Box-to-box, links defence and attack.\n• Attacking Midfielder (AM): Creates chances and scores goals.\n\nForwards:\n• Centre-Forward (CF/ST): Main goalscorer, leads attack.\n• Winger (LW/RW): Creates from wide areas, speed and crossing key.',
   'bi-diagram-3-fill', '35 min', 'beginner', 'player', 4),

  ('Football Education', 'Understanding Tactical Formations',
   E'Modern football is built on tactical intelligence.\n\n4-4-2 (Classic): Four defenders, four midfielders, two strikers. Balanced but predictable.\n\n4-3-3 (Attacking): Used by Barcelona, Real Madrid. Requires excellent wide players.\n\n4-2-3-1 (Modern Standard): Two holding midfielders, three attacking mids, one striker. Very flexible.\n\n3-5-2 (Wing-back system): Three centre-backs, five midfielders with athletic wing-backs, two strikers.\n\nAs an OFA player, you must understand and function in at least two formations. The best players adapt quickly.',
   'bi-grid-fill', '40 min', 'intermediate', 'both', 5),

  ('Football Education', 'Video Analysis - Reading the Game',
   E'The best players study the game as much as they practice it.\n\nWhat to Look For:\n• Space - Where is it? Who is creating it?\n• Movement - Are players making runs? Supporting the ball carrier?\n• Shape - Is the team maintaining formation? Are there gaps?\n• Pressing triggers - When does the team press?\n\nHow to Analyse Your Own Performance:\n1. Watch highlights without emotion - just observe.\n2. Note every decision: Was it correct? Was there a better option?\n3. Focus on positioning WITHOUT the ball.\n4. Share observations with your coach.\n\nOFA coaches use video analysis every week.',
   'bi-camera-video-fill', '45 min', 'intermediate', 'both', 6),

  -- ══ COURSE 2: Technical Training ══════════════════════════════
  ('Technical Training', 'Ball Mastery Fundamentals',
   E'Ball mastery is the foundation of technical excellence.\n\nCore Ball Mastery Drills:\n1. Roll and Stop (5 mins): Roll ball forward with sole, stop with other foot. 50 reps each foot.\n2. Inside-Outside Touch (5 mins): Touch ball inside then outside same foot, alternating.\n3. Sole Juggling (5 mins): Roll ball back and forth under sole of foot, alternating feet.\n4. V-Move (10 mins): Pull ball back with sole, push forward with inside of same foot.\n5. Cruyff Turn (10 mins): Fake pass, pull ball behind standing foot, change direction.\n\nDo these drills 20 minutes every day. Dramatic improvement within 6 weeks. Use BOTH feet.',
   'bi-circle-fill', '30 min', 'beginner', 'player', 1),

  ('Technical Training', 'Passing Accuracy and Weight',
   E'A team that passes accurately controls the game.\n\nTypes of Passes:\n• Short Pass (Inside of foot): Most reliable, most used. Lock ankle, follow through.\n• Long Pass (Instep): Laces drive the ball. Used to switch play.\n• Through Ball: Into space ahead of running teammate. Timing is everything.\n• Backward Pass: Often best option to maintain possession.\n\nKey Principles:\n1. Scan before receiving - know where teammates are.\n2. Open body shape to see the pitch when receiving.\n3. Weight of pass - too soft gets intercepted, too hard is uncontrollable.\n4. Accuracy - hit feet or lead into space.\n\nDrill: Triangle passing, one touch only, increase speed gradually.',
   'bi-arrow-right-circle-fill', '35 min', 'beginner', 'player', 2),

  ('Technical Training', 'Shooting Technique',
   E'Goals win games. Every field player must be capable of scoring.\n\nShooting Techniques:\n\nInstep Drive: Strike through centre of ball with laces. Plant foot alongside, lean over ball, follow through. Most powerful.\n\nSide Foot Finish: Inside of foot. More accurate, less power. Ideal inside box.\n\nCurling Shot: Strike side of ball with inside of foot. Creates curve around defenders.\n\nVolley: Striking before ball touches ground. Watch ball onto foot, do not rush.\n\nHeading: Attack ball with forehead. Power comes from neck muscles. Keep eyes open.\n\nDrill: 10 shots per session with each technique. Always aim for corners.',
   'bi-bullseye', '40 min', 'intermediate', 'player', 3),

  ('Technical Training', 'Dribbling and 1v1 Skills',
   E'Dribbling creates chances. Know WHEN to dribble, not just HOW.\n\nWhen to Dribble:\n• You have space to exploit\n• You are near the opponents box\n• A pass is not available\n• You can isolate a defender 1v1\n\nKey Moves:\n• Step Over: Fake one way, go the other.\n• Scissors: Two step overs, same side, then accelerate.\n• Elastico: Touch outside then inside in one motion - Brazilian technique.\n• Fake Shot / Body Feint: Drop shoulder, sell the fake, accelerate away.\n• La Croqueta: Transfer ball inside touch foot to foot, change direction.\n\nTraining: 10 cones, 1 metre apart. Dribble through with different moves. Time yourself.',
   'bi-lightning-fill', '40 min', 'intermediate', 'player', 4),

  ('Technical Training', 'Defending Principles',
   E'Defending is an art. Every OFA player must understand defensive principles.\n\nThe Four Ds:\n1. Delay: Do not rush. Force attacker away from goal. Buy time for teammates.\n2. Deny: Stop them from turning. Get tight, prevent them facing goal.\n3. Dictate: Force toward weak side - weaker foot or sideline.\n4. Destroy: Win ball cleanly when the moment is right.\n\nPressing:\n• Press when opponent receives with back to goal, bad first touch, or plays backward.\n• Never press alone. Press as a unit.\n\nTackling:\n• Sliding tackle: Last resort. Commit only when sure.\n• Standing tackle: Block with inside of foot. Stay on feet.\n• Interception: Best defence. Read the game and cut passing lanes.',
   'bi-shield-fill', '35 min', 'intermediate', 'both', 5),

  -- ══ COURSE 3: Sports Psychology ═══════════════════════════════
  ('Sports Psychology', 'Mental Toughness in Football',
   E'Physical ability takes you to the game. Mental toughness determines how far you go.\n\nThe 4 Cs of Mental Toughness:\n1. Control: Control effort, attitude, preparation. Let go of referee decisions, weather, opponents.\n2. Commitment: Turning up every day even when you do not feel like it.\n3. Challenge: See setbacks as opportunities. Missed penalty? Use it. Poor session? Learn.\n4. Confidence: Built through preparation, not words.\n\nRonaldo Mental Routine:\nBefore every game, Cristiano Ronaldo visualises scoring. He sees it before it happens. You can practise this too.',
   'bi-brain', '30 min', 'intermediate', 'both', 1),

  ('Sports Psychology', 'Dealing with Pressure and Anxiety',
   E'Pre-match nerves are normal. Even world-class players feel them.\n\nBox Breathing (4-4-4-4):\nInhale 4 seconds. Hold 4. Exhale 4. Hold 4. Repeat 4 times. Instant calm.\n\nPositive Self-Talk:\nReplace "What if I miss?" with "I have practised this. I am ready."\n\nPre-Match Routine:\nBuild a consistent routine. Same warm-up music. Same stretching. Same food. Signals your brain: time to perform.\n\nAfter Mistakes - The 5-Second Rule:\nYou have 5 seconds to be disappointed. Then reset. The next action is more important than the last.',
   'bi-heart-pulse-fill', '25 min', 'intermediate', 'both', 2),

  ('Sports Psychology', 'Goal Setting for Athletes',
   E'Without clear goals, you train without direction.\n\nSMART Framework:\n• Specific: I will score 5 goals this season - not I want to score more.\n• Measurable: Track it with numbers and dates.\n• Achievable: Challenging but realistic.\n• Relevant: Connected to your football development.\n• Time-bound: Has a deadline.\n\nThree Types of Goals:\n1. Outcome Goals: Win the Lagos State League. Motivating but outside full control.\n2. Performance Goals: Maintain 85% pass accuracy. Within your control.\n3. Process Goals: Complete ball mastery drills every morning. Daily actions.\n\nOFA Challenge: Write three SMART goals. Share with your coach. Review monthly.',
   'bi-trophy-fill', '25 min', 'beginner', 'player', 3),

  -- ══ COURSE 4: Health Education ════════════════════════════════
  ('Health Education', 'Nutrition for Football Performance',
   E'You cannot out-train a bad diet.\n\nCarbohydrates (Primary fuel):\n• Rice, yam, plantain, bread, pasta, oats.\n• Eat 2-3 hours before training and matches.\n• Body converts carbohydrates to glycogen - your muscles fuel.\n\nProtein (Repair and growth):\n• Chicken, fish, eggs, beans, groundnut.\n• Within 30 minutes after training.\n• Target: 1.4-1.7g per kg of body weight daily.\n\nFats: Avocado, groundnut oil, fish. Do not eliminate fats - they support hormones.\n\nHydration:\n• 2% dehydration = 10-20% performance drop.\n• Drink water all day, not just during training.\n• Electrolytes after heavy sessions (coconut water).\n\nPre-Match: Rice and chicken 3 hours before. Post-Match: Protein and carbs within 2 hours.',
   'bi-egg-fried', '30 min', 'beginner', 'player', 1),

  ('Health Education', 'Injury Prevention and Recovery',
   E'Every injury sets you back weeks or months. Prevention is better than cure.\n\nWarm-Up (Never skip):\n• 5 minutes light jog\n• Dynamic stretches: leg swings, hip circles, high knees, lunges\n• Activation: jumping jacks, lateral shuffles\n• Ball work to increase intensity gradually\n\nCommon Injuries:\n• Hamstring strain: Nordic curls strengthen. Always warm up.\n• Ankle sprain: Proprioception balance exercises.\n• ACL injury: Strengthen quads and hamstrings equally. Land soft.\n• Groin strain: Daily hip flexor stretching.\n\nRecovery - RICE:\nRest, Ice, Compression, Elevation - first 48 hours after acute injury.\n\nSleep 7-9 hours - body repairs during sleep.\n\nSee a doctor for: swelling, significant pain, inability to bear weight.',
   'bi-bandaid-fill', '35 min', 'intermediate', 'player', 2),

  ('Health Education', 'Mental Health in Sport',
   E'Mental health is as important as physical health.\n\nCommon Challenges:\n• Burnout: Exhaustion from overtraining or excessive pressure.\n• Performance anxiety: Fear of failure affecting ability.\n• Depression: Can affect any player regardless of success.\n• Social pressure: Family expectations, community pressure to succeed.\n\nWarning Signs:\n• Persistent fatigue despite rest\n• Loss of enjoyment in football\n• Withdrawal from teammates\n• Changes in sleep or appetite\n• Irritability or mood swings\n\nWhat to Do:\n1. Talk to someone you trust - coach, parent, teammate.\n2. OFA pastoral care policy: speak to management in confidence.\n3. Asking for help is strength, not weakness.\n\nMarcus Rashford, Thierry Henry, Frank Lampard have all spoken publicly about mental health.',
   'bi-person-heart', '30 min', 'beginner', 'both', 3),

  -- ══ COURSE 5: Environmental Initiatives ═══════════════════════
  ('Environmental Initiatives', 'Green Goal — Football and the Environment',
   E'FIFA launched Green Goal to make football more environmentally sustainable.\n\nFootball Impact:\n• Stadium operations consume enormous energy.\n• Travel produces carbon emissions.\n• Plastic bottles and packaging generate waste.\n• Poorly maintained pitches contribute to soil erosion.\n\nOFA Commits To:\n• Zero litter policy at all training sessions and matches.\n• Reusable water bottles for all players.\n• Tree-planting initiative in the Ajegunle community.\n• Environmental education for all players.\n\nWhat You Can Do Today:\n1. Never litter at training or matchday.\n2. Use your OFA reusable water bottle.\n3. Carpool or use public transport to training.\n4. Report poor facility conditions to management.',
   'bi-tree-fill', '20 min', 'beginner', 'both', 1),

  ('Environmental Initiatives', 'Community Responsibility for OFA Players',
   E'You are not just a footballer. You are a community leader.\n\nThe OFA Community Pledge:\n• Be a positive role model in your neighbourhood.\n• Stay in education alongside football.\n• Never engage in violence, substance abuse, or criminal activity.\n• Give back - mentor younger kids who want to play.\n\nCommunity Outreach:\nOFA runs quarterly free football clinics for underprivileged children in Ajegunle. All registered OFA players are expected to volunteer at least once per year.\n\nThe Legacy of Nigerian Greats:\nJay-Jay Okocha funded schools and hospitals in Plateau State. Nwankwo Kanu built a heart surgery centre through the Kanu Heart Foundation.',
   'bi-people-fill', '25 min', 'beginner', 'both', 2),

  -- ══ COURSE 6: Community Engagement ════════════════════════════
  ('Community Engagement', 'Volunteering and Mentorship',
   E'The greatest leaders lift others as they climb.\n\nHow to Mentor at OFA:\n• Senior players are assigned a junior player to guide each season.\n• Mentorship is about attitude, not just football skills.\n• Share your experiences - successes AND failures.\n• Be available, consistent, and honest.\n\nVolunteering Opportunities:\n• Junior Training Days: Help coach U13 and U15 sessions under supervision.\n• Community Events: OFA partners with local schools for football education days.\n• Clean-Up Days: Regular training ground maintenance sessions.\n\nBenefit: Research shows mentors improve their own performance through teaching.',
   'bi-hand-thumbs-up-fill', '25 min', 'beginner', 'both', 1),

  ('Community Engagement', 'Leadership Skills for Young Athletes',
   E'Football develops leaders. Skills built on the pitch transfer to life, business, and society.\n\n5 Leadership Skills Football Teaches:\n\n1. Decision Making Under Pressure: In 0.5 seconds decide: pass, dribble, or shoot. Trains rapid confident decisions for all of life.\n\n2. Communication: Calling for ball, directing teammates, organising defensive line. Leaders communicate clearly.\n\n3. Accountability: Owning mistakes and working harder. No excuses. No blaming others.\n\n4. Team Before Self: Individual brilliance must serve the team. Ego loses championships. Team wins them.\n\n5. Resilience: Every footballer faces rejection, injury, and failure. How you respond defines your ceiling.\n\nOFA Leadership Programme: Two player captains nominated per season.',
   'bi-star-fill', '30 min', 'intermediate', 'both', 2)

) AS v(course_title, title, content, icon, duration, difficulty, target_audience, order_index)
ON c.title = v.course_title;
