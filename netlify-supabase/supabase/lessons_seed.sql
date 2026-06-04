-- ============================================================
-- OFA Academy — Course Lessons Seed
-- Run AFTER seed.sql (courses must exist first)
-- ============================================================

DO $$
DECLARE
  c1 BIGINT; c2 BIGINT; c3 BIGINT; c4 BIGINT; c5 BIGINT; c6 BIGINT;
BEGIN
  SELECT id INTO c1 FROM public.courses WHERE title = 'Football Education'        LIMIT 1;
  SELECT id INTO c2 FROM public.courses WHERE title = 'Technical Training'        LIMIT 1;
  SELECT id INTO c3 FROM public.courses WHERE title = 'Sports Psychology'         LIMIT 1;
  SELECT id INTO c4 FROM public.courses WHERE title = 'Health Education'          LIMIT 1;
  SELECT id INTO c5 FROM public.courses WHERE title = 'Environmental Initiatives' LIMIT 1;
  SELECT id INTO c6 FROM public.courses WHERE title = 'Community Engagement'      LIMIT 1;

  -- ── COURSE 1: Football Education ─────────────────────────────
  INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index) VALUES
  (c1, 'The Laws of the Game', 'Football is governed by 17 Laws of the Game maintained by IFAB (International Football Association Board). These laws ensure consistency and fairness across all levels of play worldwide.

Key Laws:
• Law 1 — The Field of Play: A rectangular field between 100-110m long and 64-75m wide for international matches. Goal dimensions: 7.32m wide, 2.44m high.
• Law 2 — The Ball: Spherical, circumference 68-70cm, pressure 0.6-1.1 atmosphere.
• Law 3 — The Players: 11 players per team including goalkeeper. Minimum 7 to continue.
• Law 4 — Equipment: Players must wear jersey, shorts, socks, shin guards, and boots.
• Law 5 — The Referee: Has full authority. Decisions are final.
• Law 12 — Fouls and Misconduct: Direct and indirect free kicks. Yellow and red cards.

Understanding these laws helps you play smarter, argue fewer decisions, and earn more respect from referees and teammates.',
  'bi-book-fill', '25 min', 'beginner', 'both', 1),

  (c1, 'Football Ethics and Fair Play', 'FIFA''s Fair Play Campaign promotes respect, integrity, and good sportsmanship. As an OFA player, you are expected to uphold these values at all times.

Core Principles:
• Respect opponents — they are not enemies but partners in creating a great game.
• Respect the referee — even when you disagree with a decision.
• No discrimination — race, religion, gender, or background must never be a basis for disrespect.
• Anti-doping — never use performance-enhancing substances.
• Say no to match-fixing — the integrity of the game depends on every player.

At OFA, we believe champions are made not just on the pitch but in how they carry themselves off it. Every player who wears the OFA badge represents thousands of young Nigerians watching and learning.',
  'bi-award-fill', '20 min', 'beginner', 'both', 2),

  (c1, 'History of Nigerian Football', 'Nigeria has one of the richest football histories in Africa. Understanding this history helps you appreciate where you come from and inspires you to build on this legacy.

Key Milestones:
• 1945 — First organized football association formed in Nigeria.
• 1960 — Nigeria Football Association (NFA) affiliated with FIFA at independence.
• 1980 — Nigeria wins first Africa Cup of Nations (AFCON).
• 1994 — Nigeria qualify for first-ever FIFA World Cup, beating Bulgaria and Greece.
• 1996 — Super Eagles win Olympic Gold at Atlanta — the greatest moment in Nigerian football history.
• 2013 — Nigeria wins AFCON in South Africa under Stephen Keshi.

Famous Nigerian Players:
Jay-Jay Okocha (nicknamed "too good to be named twice"), Nwankwo Kanu (3x African Footballer of the Year), Rashidi Yekini (Nigeria''s all-time World Cup top scorer), John Obi Mikel, Vincent Enyeama, Victor Osimhen.',
  'bi-flag-fill', '30 min', 'beginner', 'player', 3),

  (c1, 'Football Positions Explained', 'Understanding where you play and what is expected of you is fundamental to becoming a complete footballer.

Goalkeepers (GK):
The last line of defence. Must have quick reflexes, command their penalty area, and distribute effectively. Famous GKs: Iker Casillas, Manuel Neuer, Alison Becker.

Defenders:
• Centre-Back (CB): Dominant in the air and on the ground. Leads the defensive line.
• Full-Back (RB/LB): Supports attack and defence down the flanks.
• Wing-Back (RWB/LWB): More attacking than full-backs in modern systems.

Midfielders:
• Defensive Midfielder (DM/CDM): Protects the back four. Intercepts and recycles possession.
• Central Midfielder (CM): Box-to-box role linking defence and attack.
• Attacking Midfielder (AM/CAM): Creates chances and scores goals.

Forwards:
• Centre-Forward (CF/ST): Main goalscorer. Leads the attack.
• Winger (LW/RW): Creates from wide areas. Speed and crossing are key attributes.',
  'bi-diagram-3-fill', '35 min', 'beginner', 'player', 4),

  (c1, 'Understanding Tactical Formations', 'Modern football is built on tactical intelligence. Coaches choose formations based on their players'' strengths and the opponent''s weaknesses.

Common Formations:

4-4-2 (Classic):
Four defenders, four midfielders, two strikers. The most traditional formation. Balanced but predictable.

4-3-3 (Attacking):
Four defenders, three midfielders, three forwards. Used by Barcelona, Real Madrid. Requires technically excellent wide players.

4-2-3-1 (Modern Standard):
Four defenders, two holding midfielders, three attacking midfielders, one striker. Very flexible and difficult to break down.

3-5-2 (Wing-back system):
Three centre-backs, five midfielders (with two wing-backs), two strikers. Requires highly athletic wing-backs.

As an OFA player, you must be able to understand and function in at least two formations. The best players adapt quickly.',
  'bi-grid-fill', '40 min', 'intermediate', 'both', 5),

  (c1, 'Video Analysis — Reading the Game', 'The best players study the game as much as they practice it. Video analysis is a crucial modern tool used at every professional club.

What to Look For:
• Space — Where is the space on the pitch? Who is creating it? Who is filling it?
• Movement — Are players making runs? Are they supporting the ball carrier?
• Shape — Is the team maintaining its formation? Are there gaps being exploited?
• Pressing triggers — When does the team press? What triggers a press?

How to Analyse Your Own Performance:
1. Watch your highlights without emotion first — just observe.
2. On second watch, note every decision: Was it correct? Was there a better option?
3. Focus on your positioning without the ball — this is where most goals are created or prevented.
4. Share observations with your coach for feedback.

OFA coaches use video analysis every week to help our players improve faster.',
  'bi-camera-video-fill', '45 min', 'intermediate', 'both', 6);

  -- ── COURSE 2: Technical Training ─────────────────────────────
  INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index) VALUES
  (c2, 'Ball Mastery Fundamentals', 'Ball mastery is the foundation of technical excellence. Every elite player — from Messi to Mbappe — spends hours perfecting their touch.

Core Ball Mastery Drills:
1. Roll & Stop (5 mins): Roll ball forward with sole, stop with the other foot. 50 repetitions each foot.
2. Inside-Outside Touch (5 mins): Touch ball inside then outside same foot, alternating. Builds close control.
3. Sole Juggling (5 mins): Roll ball back and forth under sole of foot, alternating feet. Focus on rhythm.
4. V-Move (10 mins): Pull ball back with sole, push forward with inside of same foot. Creates change of direction.
5. Cruyff Turn (10 mins): Fake pass, pull ball behind standing foot, change direction. Named after Johan Cruyff.

Training Tip:
Do these drills for 20 minutes every day before team training. You will see dramatic improvement within 6 weeks. Use both feet — OFA expects all players to be technically comfortable on both sides.',
  'bi-circle-fill', '30 min', 'beginner', 'player', 1),

  (c2, 'Passing Accuracy and Weight', 'A team that passes accurately controls the game. Poor passing loses possession and puts teammates under unnecessary pressure.

Types of Passes:
• Short Pass (Inside of foot): Most reliable, most used. Plant foot alongside ball, lock ankle, follow through.
• Long Pass (Instep): Laces drive the ball. Used to switch play or play over the press.
• Through Ball: Played into space ahead of a running teammate. Timing is everything.
• Backward Pass: Often the best option to maintain possession and reset.

Key Principles:
1. Scan before receiving — know where your teammates are before the ball arrives.
2. Body shape — open your body to see the pitch when receiving.
3. Weight of pass — too soft gets intercepted, too hard is uncontrollable.
4. Accuracy — hit your teammate''s feet or lead them into space.

Drill: Triangle passing with 3 players. One touch only. Increase speed gradually. Build to first touch with direction changes.',
  'bi-arrow-right-circle-fill', '35 min', 'beginner', 'player', 2),

  (c2, 'Shooting Technique', 'Goals win games. Every field player must be capable of scoring. Even defenders can decide matches with a well-taken goal.

Shooting Techniques:

Instep Drive:
Strike through the centre of the ball with laces. Plant foot alongside, lean over the ball, follow through. Most powerful shot.

Side Foot Finish:
Use inside of foot. More accurate, less power. Ideal inside the box when placement matters more than power.

Curling Shot:
Strike the side of ball with inside of foot. Creates curve. Ideal for bending around defenders or keepers.

Volley:
Striking ball before it touches ground. Timing is critical. Watch ball onto foot, don''t rush.

Heading:
Attack the ball with your forehead. Close eyes on impact? No — keep eyes open. Power comes from neck muscles, not just head movement.

Finishing Drill: 10 shots per session with each technique. Always aim for corners — keepers are weakest there.',
  'bi-bullseye', '40 min', 'intermediate', 'player', 3),

  (c2, 'Dribbling and 1v1 Skills', 'Dribbling in the right situations creates chances and unlocks defences. The key is knowing WHEN to dribble, not just HOW.

When to Dribble:
• You have space to exploit
• You are near the opponent''s box
• A pass is not available
• You can isolate a defender 1v1

Key Moves:
• Step Over: Fake to go one way, go the other
• Scissors: Two step overs, same side, then accelerate
• Elastico: Touch outside then inside in one motion — Brazilian technique
• Fake Shot / Body Feint: Drop shoulder, sell the fake, accelerate away
• La Croqueta: Transfer ball from one foot to other with inside touch, change direction

Defensive Dribbling (Shield):
Use your body as a barrier between ball and opponent. Stay low, keep ball on far foot, earn a foul or recycle possession.

Training: Set up 10 cones in a row, 1 metre apart. Dribble through with different moves. Time yourself. Beat your personal best.',
  'bi-lightning-fill', '40 min', 'intermediate', 'player', 4),

  (c2, 'Defending Principles', 'Defending is an art. Every OFA player — regardless of position — must understand defensive principles.

The Four Ds of Defending:
1. Delay: Don''t rush to win the ball. Force the attacker away from goal. Buy time for teammates to recover.
2. Deny: Stop them from turning. Get tight to prevent them facing goal.
3. Dictate: Force them towards the weak side — usually their weaker foot or toward the sideline.
4. Destroy: Win the ball cleanly when the moment is right.

Pressing:
• Trigger-based pressing: Press when opponent receives with back to goal, bad first touch, or plays backward pass.
• Never press alone: Coordinate with teammates. Press as a unit.

Tackling:
• Sliding tackle: Last resort. Commit only when sure.
• Standing tackle: Block with inside of foot. Stay on feet whenever possible.
• Interception: The best defence. Read the game and cut passing lanes before attacker receives.',
  'bi-shield-fill', '35 min', 'intermediate', 'both', 5);

  -- ── COURSE 3: Sports Psychology ──────────────────────────────
  INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index) VALUES
  (c3, 'Mental Toughness in Football', 'Physical ability takes you to the game. Mental toughness determines how far you go.

What is Mental Toughness?
Mental toughness is the ability to perform consistently under pressure, in adversity, and when the stakes are highest. It is trainable — it is not something you are born with.

The 4 Cs of Mental Toughness:
1. Control: You control what you can control (effort, attitude, preparation). Let go of what you cannot (referee decisions, weather, opponent quality).
2. Commitment: Turning up every day even when you do not feel like it. Champions train hardest when they are least motivated.
3. Challenge: See setbacks as opportunities to grow. Missed penalty? Use it. Poor training session? Learn from it.
4. Confidence: Belief in your own ability. Built through preparation, not words.

Ronaldo''s Mental Routine:
Before every game, Cristiano Ronaldo visualises scoring. He sees it in his mind before it happens on the pitch. You can practice this too.',
  'bi-brain', '30 min', 'intermediate', 'both', 1),

  (c3, 'Dealing with Pressure and Anxiety', 'Pre-match nerves are normal. Even the world''s best players feel them. The difference is knowing how to use that energy.

Understanding Anxiety:
Anxiety before a big match is your body preparing for performance. Adrenaline increases reaction speed and focus. The goal is not to eliminate nerves — it is to control them.

Techniques:

Box Breathing (4-4-4-4):
Inhale for 4 seconds. Hold for 4. Exhale for 4. Hold for 4. Repeat 4 times. This activates your parasympathetic nervous system — instant calm.

Positive Self-Talk:
Replace "What if I miss?" with "I have practiced this. I am ready." Words shape thoughts. Thoughts shape performance.

Pre-Match Routine:
Build a consistent pre-match routine. Same warm-up music. Same stretching sequence. Same food. Routines signal to your brain: "It is time to perform."

After Mistakes:
The best players have a 5-second rule. You have 5 seconds to be disappointed. Then you reset. The next action is more important than the last one.',
  'bi-heart-pulse-fill', '25 min', 'intermediate', 'both', 2),

  (c3, 'Goal Setting for Athletes', 'Without clear goals, you are training without direction. Goal setting transforms effort into achievement.

The SMART Framework:
• Specific: "I will score 5 goals this season" not "I want to score more goals."
• Measurable: You can track it. Numbers, dates, milestones.
• Achievable: Challenging but realistic. Not too easy, not impossible.
• Relevant: Connected to your overall football development.
• Time-bound: Has a deadline. Creates urgency and focus.

Three Types of Goals:
1. Outcome Goals: "Win the Lagos State League." — motivating but outside full control.
2. Performance Goals: "Maintain 85% pass accuracy." — within your control, measurable.
3. Process Goals: "Complete ball mastery drills every morning." — daily actions that lead to outcomes.

OFA Challenge:
Write down three SMART goals for this season. Share them with your coach. Review them every month. Winners write their goals down.',
  'bi-trophy-fill', '25 min', 'beginner', 'player', 3);

  -- ── COURSE 4: Health Education ───────────────────────────────
  INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index) VALUES
  (c4, 'Nutrition for Football Performance', 'You cannot out-train a bad diet. What you eat directly affects your speed, stamina, and recovery.

Macronutrients for Footballers:

Carbohydrates (Primary fuel):
• Rice, yam, plantain, bread, pasta, oats
• Eat 2-3 hours before training/match
• The body converts carbohydrates to glycogen — your muscles'' fuel

Protein (Repair and growth):
• Chicken, fish, eggs, beans, groundnut
• Consume within 30 minutes after training
• Target: 1.4–1.7g per kg of body weight daily

Fats (Long-duration energy):
• Avocado, groundnut oil, palm oil (in moderation), fish
• Do not eliminate fats — they support hormone production

Hydration:
• Dehydration of just 2% causes 10-20% performance drop
• Drink water throughout the day — not just during training
• Add electrolytes after heavy sweat sessions (coconut water or oral rehydration salts)

Pre-Match Meal (3 hours before): Rice and chicken + vegetables
Post-Match Meal (within 2 hours): Protein + carbohydrate + water',
  'bi-egg-fried', '30 min', 'beginner', 'player', 1),

  (c4, 'Injury Prevention and Recovery', 'Every injury sets you back weeks or months. Prevention is far better than cure.

Warm-Up (Never skip):
• 5 minutes light jog
• Dynamic stretches: leg swings, hip circles, high knees, lunges
• Activation drills: jumping jacks, lateral shuffles
• Ball work to increase intensity gradually

Common Football Injuries and Prevention:
• Hamstring strain: Strengthen hamstrings with Nordic curls. Always warm up properly.
• Ankle sprain: Use ankle supports if history of sprains. Proprioception exercises (balance on one leg).
• Knee ligament injury (ACL): Strengthen quads and hamstrings equally. Landing mechanics — land soft.
• Groin strain: Hip flexor stretching daily. Adductor strengthening exercises.

Recovery Protocol:
• RICE: Rest, Ice, Compression, Elevation — for first 48 hours after acute injury
• Sleep: 7-9 hours per night is when your body repairs
• Active recovery: Light swim or walk on rest days keeps blood flowing without stress

When to See a Doctor:
Any swelling, significant pain, or inability to bear weight — see a medical professional immediately.',
  'bi-bandaid-fill', '35 min', 'intermediate', 'player', 2),

  (c4, 'Mental Health in Sport', 'Mental health is as important as physical health. The stigma around mental health in African football is slowly breaking down. OFA leads this conversation.

Common Mental Health Challenges in Football:
• Burnout: Exhaustion from overtraining or excessive pressure
• Performance anxiety: Fear of failure affecting ability to perform
• Depression: Can affect any player regardless of success level
• Social pressure: Family expectations, community pressure to succeed

Warning Signs:
• Persistent fatigue despite rest
• Loss of enjoyment in football
• Withdrawal from teammates
• Changes in sleep or appetite
• Irritability or mood swings

What to Do:
1. Talk to someone you trust — coach, parent, teammate
2. OFA has a pastoral care policy — you can speak to management in confidence
3. It is not weakness to ask for help — it is strength

Remember: Marcus Rashford, Thierry Henry, and Frank Lampard have all spoken publicly about mental health struggles. You are never alone.',
  'bi-person-heart', '30 min', 'beginner', 'both', 3);

  -- ── COURSE 5: Environmental Initiatives ──────────────────────
  INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index) VALUES
  (c5, 'Green Goal — Football and the Environment', 'FIFA launched the Green Goal campaign to make football more environmentally sustainable. As OFA players, we have a responsibility to our community and environment.

Football''s Environmental Impact:
• Stadium operations consume enormous energy
• Travel to away games produces carbon emissions
• Plastic bottles and packaging generate waste at grounds
• Poorly maintained pitches contribute to soil erosion

What OFA Commits To:
• Zero litter policy at all OFA training sessions and matches
• Reusable water bottles for all players
• Tree-planting initiative — OFA players will plant trees in the Ajegunle community
• Education of players about environmental responsibility

What You Can Do Today:
1. Never litter at training or on matchday
2. Use your OFA reusable water bottle
3. Carpool or use public transport to training when possible
4. Report poor conditions at training facilities to management

The Nathaniel Idowu Football Field, our home ground, is maintained by OFA volunteers. Help keep it in excellent condition.',
  'bi-tree-fill', '20 min', 'beginner', 'both', 1),

  (c5, 'Community Responsibility for OFA Players', 'You are not just a footballer. You are a community leader. Young people in Ajegunle and beyond are watching you.

The OFA Community Pledge:
• Be a positive role model in your neighbourhood
• Stay in education alongside football
• Never engage in violence, substance abuse, or criminal activity
• Give back when you can — mentor younger kids who want to play football

Community Outreach:
OFA runs quarterly free football clinics for underprivileged children in Ajegunle. All registered OFA players are expected to volunteer at least once per year.

The Legacy of Nigerian Greats:
Jay-Jay Okocha funded schools and hospitals in Plateau State. Nwankwo Kanu built a heart surgery centre through the Kanu Heart Foundation. Your success on the pitch can fund your community''s future.

OFA''s Promise to You:
In return for your commitment, OFA provides coaching, education, a safe training environment, and a pathway to professional football.',
  'bi-people-fill', '25 min', 'beginner', 'both', 2);

  -- ── COURSE 6: Community Engagement ──────────────────────────
  INSERT INTO public.lessons (course_id, title, content, icon, duration, difficulty, target_audience, order_index) VALUES
  (c6, 'Volunteering and Mentorship', 'The greatest leaders in any field are those who lift others as they climb. In football, mentorship creates the next generation of champions.

How to Mentor at OFA:
• Senior players are assigned a junior player to guide each season
• Mentorship is about attitude, not just football skills
• Share your experiences — successes AND failures
• Be available, consistent, and honest

Volunteering Opportunities:
• Junior Training Days: Help coach U13 and U15 sessions under supervision
• Community Events: OFA partners with local schools for football education days
• Clean-Up Days: Regular training ground maintenance sessions open to all players

Benefits of Mentorship:
Research shows that mentors improve their own performance through teaching. When you teach a skill, you understand it at a deeper level. The student teaches the teacher.

The Grassroots Pipeline:
Many professional Nigerian players started exactly where you are. Your involvement in OFA grassroots programs ensures the pipeline continues. The next Jay-Jay Okocha could be the child you mentor today.',
  'bi-hand-thumbs-up-fill', '25 min', 'beginner', 'both', 1),

  (c6, 'Leadership Skills for Young Athletes', 'Football develops more than athletes — it develops leaders. The skills you build on the pitch are directly transferable to life, business, and society.

5 Leadership Skills Football Teaches:

1. Decision Making Under Pressure:
In 0.5 seconds you must decide: pass, dribble, or shoot. This trains rapid, confident decision-making for all areas of life.

2. Communication:
Calling for the ball, directing teammates, organizing a defensive line — all communication. Leaders communicate clearly and often.

3. Accountability:
Owning a mistake and working harder because of it. Not making excuses. Not blaming others. The best players are hardest on themselves.

4. Team Before Self:
The greatest players — Messi, Ronaldo, Okocha — knew that individual brilliance must serve the team. Ego loses championships. Team wins them.

5. Resilience:
Every footballer faces rejection, injury, and failure. How you respond defines your character and your ceiling.

OFA Leadership Programme:
OFA nominates two player captains per season. Applications are open to all players who demonstrate these qualities on and off the pitch.',
  'bi-star-fill', '30 min', 'intermediate', 'both', 2);

END $$;
