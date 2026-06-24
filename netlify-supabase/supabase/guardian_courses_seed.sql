-- ============================================================
-- 5 GUARDIAN-EXCLUSIVE COURSES — SEED DATA
-- is_guardian_only = true  →  Players STRICTLY BLOCKED (403)
-- ============================================================

-- Course 1: Youth Football Development Pathway
INSERT INTO courses (id, title, description, level, is_guardian_only, is_active) VALUES
('gc-001', 'Youth Football Development Pathway',
 'Understanding the Long-Term Athlete Development (LTAD) model, age-phase expectations, balancing school with training, and setting realistic milestones for your child.',
 'Guardian Foundation', true, true);

INSERT INTO lessons (id, course_id, title, content, order_index) VALUES
('gl-001-1', 'gc-001', 'Understanding LTAD: The 7 Stages of Player Development',
 'The Long-Term Athlete Development (LTAD) model divides a player''s journey into 7 stages from Active Start (0-6) through to Active for Life. Each stage has specific physical, cognitive, and technical benchmarks. Understanding where your child sits helps you set appropriate expectations and avoid the trap of early specialisation, which research shows leads to burnout and dropout by age 16.

KEY TAKEAWAYS:
1. Children aged 6-12 are in the "FUNdamentals" and "Learning to Train" phases — fun and variety outweigh specialisation.
2. The Technical Development Window (ages 12-16) is when position-specific coaching becomes most effective.
3. Pushing match-winning agendas before age 12 is developmentally counterproductive.
4. Bilateral training (both feet) should be emphasized before age 10.
5. Rest and recovery are as important as training — sleep is performance.

SUGGESTED MULTIMEDIA: FIFA Football for Schools LTAD guide; FA Player Development Model overview video.',
 1),
('gl-001-2', 'gc-001', 'Age-Phase Expectations: What Should My Child Be Learning?',
 'A breakdown of what coaches are working on at each age group (U9–U19) and what progress looks like at each stage.

KEY TAKEAWAYS:
1. U9-U11: Ball mastery, 1v1 skills, creative play — win/loss records are irrelevant.
2. U12-U14: Tactical awareness begins; positional understanding develops; physical literacy peaks.
3. U15-U17: Strength, speed, and game intelligence converge; professional pathways become visible.
4. U18-U19: Full tactical systems, mental resilience, professional identity.
5. Academic performance and football development are not in conflict — they reinforce each other.

SUGGESTED MULTIMEDIA: Premier League Primary Stars curriculum resources; LTAD chart printable.',
 2),
('gl-001-3', 'gc-001', 'Balancing School, Training, and Family Life',
 'Practical strategies for managing your child''s football schedule without sacrificing academic performance or family wellbeing.

KEY TAKEAWAYS:
1. Sleep (9-10 hours for U16s) is the single highest-impact recovery tool available — prioritise it over extra training sessions.
2. Agree on homework-first policies with your child before the season starts.
3. Communicate proactively with teachers about match days rather than asking for make-up work after.
4. Build one fully rest day per week — physical and psychological recovery prevents overtraining syndrome.
5. Holidays and breaks are NOT lost development time — they are essential consolidation periods.

SUGGESTED MULTIMEDIA: Child Mind Institute: Balancing Sports and School; NHS Physical Activity guidelines for children.',
 3),
('gl-001-4', 'gc-001', 'Setting Realistic Milestones Without Adding Pressure',
 'How to support your child''s football journey without projecting your own ambitions, and how to celebrate process over outcomes.

KEY TAKEAWAYS:
1. Define success by effort and improvement, not match results or goals scored.
2. The "24-hour rule": hold feedback until 24 hours after the match. Debrief is for coaches, not car journeys home.
3. 75% of elite players report their parents as their #1 source of stress during development years.
4. Encourage your child to self-evaluate: "What did YOU think went well today?"
5. Milestones to celebrate: completing a full season, improving a skill, earning a coach''s mention — not trophies.

SUGGESTED MULTIMEDIA: Positive Coaching Alliance resources; TED Talk: "What parents can learn from letting kids take risks."',
 4);

-- Course 2: Match-Day & Training Nutrition for Young Athletes
INSERT INTO courses (id, title, description, level, is_guardian_only, is_active) VALUES
('gc-002', 'Match-Day & Training Nutrition for Young Athletes',
 'Evidence-based nutritional guidance specifically for parents of youth footballers: what to feed, when to feed it, and how hydration science affects performance and recovery.',
 'Guardian Foundation', true, true);

INSERT INTO lessons (id, course_id, title, content, order_index) VALUES
('gl-002-1', 'gc-002', 'Pre-Training and Pre-Match Meals: Fuelling Right',
 'The food your child eats 2-4 hours before training or a match directly determines their energy levels, concentration, and injury risk.

KEY TAKEAWAYS:
1. The ideal pre-match meal: 60% carbohydrate (rice, pasta, yam, bread), 25% protein (chicken, eggs, fish), 15% vegetables. Eaten 2-3 hours before kick-off.
2. Avoid high-fat, high-fibre, or unfamiliar foods on match day — they slow digestion and cause cramping.
3. A banana or date + water 30-45 minutes before kick-off is an ideal top-up snack.
4. Never let your child play on an empty stomach — glycogen depletion reduces sprint speed by up to 15% in the second half.
5. Nigerian staples that work perfectly: jollof rice + grilled chicken + water; yam + fish stew (eaten 3+ hours before).

SUGGESTED MULTIMEDIA: British Nutrition Foundation: Sport and Exercise resources; FIFA Medical Assessment Centre nutrition guidelines.',
 1),
('gl-002-2', 'gc-002', 'Half-Time Snacks and In-Match Refuelling',
 'The 15-minute half-time window is critical for maintaining energy and focus through the second half.

KEY TAKEAWAYS:
1. Fast-digesting carbohydrates are the priority at half-time — oranges, bananas, dates, watermelon.
2. Avoid heavy foods at half-time — digestion competes with muscles for blood flow.
3. Water is the best drink for matches under 60 minutes in cool conditions.
4. In hot Lagos conditions (30°C+): 150-250ml of water or diluted fruit juice every 15 minutes of play.
5. Sports drinks (like Lucozade) are only beneficial for matches lasting 90+ minutes in high heat.

SUGGESTED MULTIMEDIA: Gatorade Sports Science Institute youth hydration guidelines; Anita Bean: Practical Sports Nutrition for Young Athletes.',
 2),
('gl-002-3', 'gc-002', 'Post-Match Recovery Nutrition: The 30-Minute Window',
 'Recovery starts the moment the final whistle blows. The food consumed in the first 30-60 minutes post-match determines how quickly your child recovers for their next session.

KEY TAKEAWAYS:
1. The recovery window: consume carbohydrates + protein within 30-60 minutes of finishing a match.
2. Ideal recovery meal ratio: 3:1 carbohydrate-to-protein (e.g., jollof rice + chicken or a glass of chocolate milk).
3. Chocolate milk is one of the most researched recovery drinks for young athletes — contains ideal carb/protein ratio.
4. Re-hydrate: replace 1.5× the fluid lost (weigh before and after — every 1kg lost = 1.5 litres to replace).
5. Avoid skipping the recovery meal even if your child "isn''t hungry" — delayed refuelling extends DOMS (muscle soreness) by 24-48 hours.

SUGGESTED MULTIMEDIA: IOC consensus statement on sports nutrition; BBC Good Food: Post-workout meal ideas.',
 3),
('gl-002-4', 'gc-002', 'Hydration Science: Heat, Lagos Climate, and Performance',
 'Lagos''s tropical climate (average 28-32°C) creates unique hydration demands that Northern European nutritional guidelines do not account for.

KEY TAKEAWAYS:
1. In 30°C+ conditions, youth athletes can lose 1-2 litres of sweat per hour of exercise.
2. Even 2% dehydration reduces cognitive performance (decision-making, reaction time) and physical output.
3. Signs of dehydration in children: dark urine, headache, irritability, loss of focus — not just thirst.
4. Encourage drinking 400-600ml of water 2 hours before training, not just during.
5. Energy drinks (Red Bull, Monster) are NOT sports drinks — they are dangerous for under-18s and should never be consumed before, during, or after sports.

SUGGESTED MULTIMEDIA: WHO heat and hydration guidelines; NHS: How much water should children drink?',
 4);

-- Course 3: Mental Resilience & Sideline Etiquette
INSERT INTO courses (id, title, description, level, is_guardian_only, is_active) VALUES
('gc-003', 'Mental Resilience & Sideline Etiquette',
 'How to foster a growth mindset in your young footballer, manage anxiety, maintain positive sideline behaviour, and help your child navigate rejection, benching, and setbacks with resilience.',
 'Guardian Intermediate', true, true);

INSERT INTO lessons (id, course_id, title, content, order_index) VALUES
('gl-003-1', 'gc-003', 'The Growth Mindset: Rewiring How Your Child Processes Failure',
 'Dr Carol Dweck''s landmark research shows that children praised for effort develop greater resilience than those praised for talent.

KEY TAKEAWAYS:
1. Fixed mindset language to avoid: "You''re so talented!", "You should have scored that." Growth mindset language: "I noticed how hard you worked on your first touch today."
2. Failure is data, not identity. Help your child ask: "What would I do differently next time?"
3. Effort praise creates persistence. Talent praise creates avoidance of challenge (fear of looking "not talented").
4. Normalise mistakes: professional footballers lose possession hundreds of times per match.
5. Introduce the concept of "yet" — "I can''t do a Cruyff turn... yet." Two letters that change everything.

SUGGESTED MULTIMEDIA: Carol Dweck TED Talk: "The Power of Believing That You Can Improve"; Mindset by Carol Dweck (book summary).',
 1),
('gl-003-2', 'gc-003', 'Managing Pre-Match Anxiety: What Parents Can Do',
 'Pre-match anxiety affects up to 60% of youth athletes. As a guardian, your behaviour in the hours before kick-off directly affects your child''s nervous system.

KEY TAKEAWAYS:
1. The "quiet car" principle: no tactical discussions, no match pressure conversations in the 30 minutes before kick-off.
2. Anxiety is normal and productive in small doses — it sharpens focus. Help your child name it: "I''m excited and ready."
3. Box breathing technique for anxious children: inhale 4 counts, hold 4, exhale 4, hold 4. Repeat 3 times.
4. Your facial expression matters: anxious parents transmit anxiety. Calm, smiling drop-offs regulate your child''s cortisol.
5. Never ask "Are you nervous?" before a match — you are suggesting they should be. Ask "Are you ready?" instead.

SUGGESTED MULTIMEDIA: YST (Youth Sport Trust) mental health resources; NHS: Helping children with anxiety.',
 2),
('gl-003-3', 'gc-003', 'Silent Sideline Rules: The Evidence for Coaching Your Voice',
 'Research from sports psychology consistently shows that parent shouting from the sideline is one of the top three reasons children quit sport by age 13.

KEY TAKEAWAYS:
1. Children receive 3 sets of instructions simultaneously during a match: their own instincts, their coach''s voice, and their parent''s shouts. Three inputs = cognitive overload = mistakes.
2. The only acceptable sideline communication: "Well done!", "Keep going!", applause. Nothing tactical. Nothing corrective.
3. Never contradict your child''s coach from the sideline — even if you believe they are wrong. Raise concerns privately, after the match.
4. Negative reactions to errors (sighs, head-shaking, body language) are visible from the pitch and damage confidence.
5. The "silent sideline" experiment: research shows children play more freely, communicate better with teammates, and take more positive risks when parents stop shouting instructions.

SUGGESTED MULTIMEDIA: Child Protection in Sport Unit (CPSU): Safe sport for parents; Kidscape: Creating positive sporting environments.',
 3),
('gl-003-4', 'gc-003', 'Dealing with Rejection, Benching, and Selection Disappointment',
 'Getting dropped from the starting eleven, being rejected from a trial, or being told by a coach that development is needed are inevitable parts of a football career. How guardians respond shapes everything.

KEY TAKEAWAYS:
1. Your first response in the car or at home sets the emotional tone. Lead with empathy, not problem-solving: "That must have felt really disappointing. I''m proud of how you handled it."
2. Avoid dismissing feelings: "Don''t worry, it doesn''t matter" invalidates the child''s experience and discourages emotional openness.
3. Rejection from one trial is not rejection from football. 70% of professional players were rejected by at least one academy.
4. Use benching as a development conversation: ask the coach privately what specific skills the player needs to improve.
5. Model resilience yourself: how you talk about your own setbacks teaches your child more than any sports psychology book.

SUGGESTED MULTIMEDIA: Laurence Llewelyn-Bowen: Dealing with sporting disappointment; Mind: Supporting young people''s mental health.',
 4);

-- Course 4: Injury Prevention, Recovery & Safeguarding
INSERT INTO courses (id, title, description, level, is_guardian_only, is_active) VALUES
('gc-004', 'Injury Prevention, Recovery & Safeguarding',
 'Essential knowledge for guardians on preventing common youth football injuries, supporting recovery, recognising burnout, understanding sleep science, and safeguarding your child from abuse within sport.',
 'Guardian Intermediate', true, true);

INSERT INTO lessons (id, course_id, title, content, order_index) VALUES
('gl-004-1', 'gc-004', 'Warm-Up and Cool-Down: What Every Parent Should Understand',
 'Proper warm-up reduces injury risk by up to 50% in youth athletes. Yet many youth sessions skip structured warm-ups due to time pressure.

KEY TAKEAWAYS:
1. A proper warm-up is 10-15 minutes: light jog → dynamic stretches (leg swings, hip circles) → activation exercises (lunges, lateral shuffles) → sport-specific movements.
2. Static stretching (holding positions) before activity is counterproductive — it temporarily reduces muscle power. Save static stretches for cool-down.
3. The FIFA 11+ programme is scientifically validated and reduces ACL injuries by 50% in youth players — ask your child''s coach if they use it.
4. Cool-down matters: 5-10 minutes of light jogging + static stretching reduces DOMS and speeds next-session readiness.
5. Encourage your child to arrive 15 minutes early for sessions to do their own warm-up if the team warm-up is rushed.

SUGGESTED MULTIMEDIA: FIFA 11+ warm-up programme (free PDF); Sports Medicine Australia: Youth sport injury prevention.',
 1),
('gl-004-2', 'gc-004', 'ACL, Ankle, and Growth Plate Awareness',
 'Youth footballers are at elevated risk for specific injuries due to their developing musculoskeletal systems.

KEY TAKEAWAYS:
1. ACL injuries peak in girls aged 14-17 and boys aged 16-19, coinciding with growth spurts that temporarily reduce neuromuscular control.
2. Warning signs before ACL injury: the player complains of knee "giving way", difficulty landing from jumps, swelling after activity.
3. Growth plate injuries (Sever''s disease in heels, Osgood-Schlatter in knees) are common and painful but manageable — rest, ice, and physiotherapy. Never push a child to play through growth plate pain.
4. Ankle sprains: RICE protocol (Rest, Ice, Compression, Elevation) for the first 48 hours. Return to play only when they can hop on one leg without pain.
5. Overuse injuries account for 50% of youth sport injuries and are entirely preventable through adequate rest days and load management.

SUGGESTED MULTIMEDIA: NATA Position Statement on Youth Overuse Injuries; NHS: Knee pain in children.',
 2),
('gl-004-3', 'gc-004', 'Sleep Hygiene and Recognising Burnout',
 'Sleep is the most powerful performance and recovery tool available — and the most overlooked by guardians trying to fit football into packed schedules.

KEY TAKEAWAYS:
1. U13-U17 athletes need 9-10 hours of sleep per night for full cognitive and physical recovery. Under 8 hours increases injury risk by 1.7×.
2. Screen time in the hour before bed suppresses melatonin production and delays sleep onset by 30-60 minutes. Phone-free bedrooms are a competitive advantage.
3. Burnout warning signs: persistent fatigue not relieved by rest, declining performance, irritability, loss of enjoyment, recurring minor illnesses.
4. If your child says "I don''t want to go to training," investigate the emotion before assuming laziness — it may signal the early stages of burnout or a safeguarding concern.
5. The solution to burnout is NOT pushing through — it is planned recovery time (1-2 weeks off), followed by a conversation about load management going forward.

SUGGESTED MULTIMEDIA: Matthew Walker: Why We Sleep (key chapters); NSF (National Sleep Foundation): Sleep and athletic performance.',
 3),
('gl-004-4', 'gc-004', 'Safeguarding: Recognising and Reporting Abuse in Sport',
 'Child safeguarding in sport is every guardian''s responsibility. Knowing the signs of abuse and the correct reporting channels is not optional knowledge.

KEY TAKEAWAYS:
1. Types of abuse in sport: physical (excessive training loads, harmful contact), emotional (public humiliation, threats), sexual, and neglect (inadequate supervision).
2. Warning signs: sudden change in behaviour around a specific adult, reluctance to attend sessions they previously enjoyed, unexplained physical marks, withdrawal.
3. NEVER dismiss or minimise a child''s disclosure. Listen, believe, and do not promise secrecy. Say: "Thank you for telling me. I''m going to make sure you''re safe."
4. In Nigeria: report safeguarding concerns to the academy safeguarding officer, and if necessary, to the National Agency for the Prohibition of Trafficking in Persons (NAPTIP) or local police.
5. A legitimate coach will NEVER ask for unsupervised one-to-one time with a child, ask a child to keep secrets from parents, or contact a child directly via personal social media.

SUGGESTED MULTIMEDIA: UNICEF Nigeria: Child Protection resources; CPSU (Child Protection in Sport Unit): Safeguarding guides for parents.',
 4);

-- Course 5: Navigating Trials, Scouts & Football Scholarships
INSERT INTO courses (id, title, description, level, is_guardian_only, is_active) VALUES
('gc-005', 'Navigating Trials, Scouts & Football Scholarships',
 'A practical guide for guardians on how scouts evaluate players, how to prepare a professional highlight reel, understanding NCAA and UK football scholarship pathways, and how to read and negotiate academy contracts.',
 'Guardian Advanced', true, true);

INSERT INTO lessons (id, course_id, title, content, order_index) VALUES
('gl-005-1', 'gc-005', 'How Scouts Actually Evaluate Youth Players',
 'Understanding the scouting process removes anxiety and helps guardians support the right development priorities.

KEY TAKEAWAYS:
1. Scouts evaluate in this priority order: Physical attributes (pace, strength, height projection) → Technical ability (first touch, passing, striking) → Tactical intelligence (positioning, decision-making) → Mental qualities (communication, reaction to adversity, coachability).
2. Scouts are NOT primarily looking at goal tallies — a defensive midfielder who covers 11km per match and wins 70% of duels is more valuable to a scout than a striker who scored 3 goals in weak opposition.
3. Scouts watch multiple matches before approaching — one standout performance rarely leads to a trial offer. Consistency over a season matters far more.
4. The question scouts ask: "How does this player respond when things go wrong?" Positive reactions to mistakes are a major differentiator.
5. Age group clubs (LMC, SWAN, NCOLGS affiliates in Lagos) are the primary scouting grounds for Nigerian players — ensure your child is registered and playing competitive league football, not just academy training.

SUGGESTED MULTIMEDIA: Signed by Scout podcast (UK scouting insights); Soccerway Nigeria for tracking competitive league exposure.',
 1),
('gl-005-2', 'gc-005', 'Creating a Professional Highlight Reel',
 'A highlight reel is your child''s football CV. Done well, it opens doors to trials. Done poorly, it can actively harm their prospects.

KEY TAKEAWAYS:
1. Optimal length: 3-5 minutes maximum. Scouts will not watch a 15-minute video. If you cannot make it compelling in 5 minutes, more footage will not help.
2. Structure: 30-second intro (player info, DOB, position, club, academic year) → best 4-5 clips → end with contact info.
3. Include BOTH successful and recovery moments — a player who wins the ball back after losing it impresses scouts more than a player who only shows highlights.
4. Film quality matters: use a mobile phone on a tripod, wide angle, steady. Shaky, zoomed-in footage is unusable.
5. Avoid: slow-motion, music, transitions, or anything that hides the player''s movement patterns. Scouts need to see natural, unpredictable football, not cinematic editing.

SUGGESTED MULTIMEDIA: Hudl platform (used by professional academies globally); EPPP (Elite Player Performance Plan) standards for UK academies.',
 2),
('gl-005-3', 'gc-005', 'NCAA, UK Pathways and International Scholarship Options',
 'For guardians with a child showing genuine elite potential, understanding the international pathway landscape is essential strategic knowledge.

KEY TAKEAWAYS:
1. NCAA Division I football scholarships (USA): Academic eligibility requirements are strict — minimum GPA and standardised test scores. Begin the eligibility process at age 14-15 via the NCAA Eligibility Center. Sports scholarships are "equivalency" not "full ride" in football — players often share partial scholarships.
2. UK Academy system: Category 1 clubs (Premier League) operate EPPP academies and can sign players from age 9. Category 2 and 3 clubs are more accessible entry points. Under-18s are covered by the Home Academy Agreement (HAA) and cannot be poached without compensation.
3. Scholarships at UK colleges (independent schools with football academies) provide education + training + accommodation for players aged 16-18.
4. Beware of agents approaching players under 16 — FIFA regulations prohibit intermediaries from contacting or signing under-16s.
5. For Nigeria-specific pathways: NFF Elite Youth League, NFAS Elite Academy Pipeline, and LMC National Youth League are the official domestic progression routes.

SUGGESTED MULTIMEDIA: NCAA Eligibility Center (eligibilitycenter.org); FA Club Finder for UK academies; NFF youth football development framework.',
 3),
('gl-005-4', 'gc-005', 'Understanding Academy Contracts and Protecting Your Child',
 'When a professional academy approaches your child with a contract, legal and financial literacy is critical. Many families sign documents they do not fully understand.

KEY TAKEAWAYS:
1. A scholarship/development contract is NOT a professional playing contract — it does not guarantee the player will turn professional, and the academy can release them at the end of the scholarship period.
2. Key clauses to scrutinise: Release clause (what compensation does the academy pay if they release your child?); Education guarantee (is the academy legally bound to provide academic education?); Compensation on transfer (are you entitled to a sell-on fee if your child moves clubs?).
3. NEVER sign a contract without independent legal review — a sports solicitor specialising in youth football is essential. In the UK, the Professional Footballers Association (PFA) provides free advice.
4. Image rights clauses: some academy contracts include broad image rights assignments — ensure these are limited in scope and duration.
5. In Nigeria: any agent claiming to have a "direct line" to a European club and asking for upfront fees is operating a scam. Legitimate agents are FIFA-licensed and work on success-based commission only.

SUGGESTED MULTIMEDIA: PFA (Professional Footballers Association) guardian guides; FIFPro youth player charter; SportsLawyer.co.uk resources.',
 4);
