<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;

class FullLessonSeeder extends Seeder
{
    public function run(): void
    {
        // ── Football Education (category: education) ───────────────────────────
        $edu = Course::where('category', 'education')->first();
        if ($edu) {
            $this->addIfMissing($edu->id, [
                [
                    'order' => 5, 'title' => 'Coaching Principles & Session Planning',
                    'duration' => '30 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'coach', 'icon' => 'bi-clipboard2-check-fill',
                    'content' =>
                        "Effective coaching begins with a clear plan. A well-structured session maximises player development and keeps athletes engaged.\n\n"
                        . "THE COACHING CYCLE\nEvery coaching session follows a cycle: Plan → Deliver → Observe → Analyse → Reflect. This cycle ensures continuous improvement for both coach and player.\n\n"
                        . "SESSION STRUCTURE\nA standard 90-minute training session should follow this format:\n• Warm-up (15 mins) — dynamic stretching, activation, rondos\n• Technical Focus (25 mins) — isolated skill work (e.g., passing, shooting)\n• Tactical Application (30 mins) — small-sided games applying the skill in context\n• Match Play (15 mins) — free play to consolidate learning\n• Cool-down & Review (5 mins) — stretching, Q&A, feedback\n\n"
                        . "COACHING STYLES\n• Command Style — coach directs, players execute. Good for beginners and safety-critical situations.\n• Guided Discovery — coach asks questions to help players find solutions. Develops thinking players.\n• Problem-Solving — players work in groups to solve tactical challenges. Builds leadership and creativity.\n\n"
                        . "GIVING FEEDBACK\nEffective feedback is: Specific ('Your plant foot was too far from the ball') not vague ('That was wrong'). Timely — given immediately after the action. Positive — acknowledge what was done well before correcting.\n\n"
                        . "PLANNING A SEASON\nA season plan should include: pre-season fitness, technical development blocks, tactical preparation, competition phase, and end-of-season review. Each block should have clear objectives and measurable outcomes.\n\n"
                        . "OFA STANDARD: All OFA coaches are expected to submit weekly session plans to the Technical Director. Plans should align with the age-group curriculum and individual player development goals.",
                ],
                [
                    'order' => 6, 'title' => 'Player Development Pathways',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-graph-up-arrow',
                    'content' =>
                        "Understanding how players develop from grassroots to elite level helps coaches design better programmes and helps players set realistic goals.\n\n"
                        . "THE LONG-TERM ATHLETE DEVELOPMENT (LTAD) MODEL\nThe LTAD model identifies key stages of development:\n\n"
                        . "1. ACTIVE START (Under 6)\nFundamental movement skills — running, jumping, throwing, catching. Fun and play-based. No formal competition.\n\n"
                        . "2. FUN & FUNDAMENTALS (U6–U9)\nBasic football skills introduced. Emphasis on enjoyment, creativity, and exploration. Small-sided games (3v3, 4v4).\n\n"
                        . "3. LEARNING TO TRAIN (U9–U12)\nThe golden age of learning. Technical skills are most easily acquired at this stage. Focus on ball mastery, passing, and basic tactics.\n\n"
                        . "4. TRAINING TO TRAIN (U12–U16)\nPhysical development accelerates. Tactical understanding deepens. Position-specific training begins. Fitness conditioning introduced.\n\n"
                        . "5. TRAINING TO COMPETE (U16–U23)\nHigh-performance training. Match preparation, video analysis, and mental skills. Transition to senior football.\n\n"
                        . "6. TRAINING TO WIN (Senior)\nElite performance. Periodisation, sports science, and individual development plans.\n\n"
                        . "INDIVIDUAL DEVELOPMENT PLANS (IDPs)\nEvery OFA player should have an IDP that identifies: current strengths, areas for improvement, short-term goals (1 month), long-term goals (1 season), and actions to achieve them.\n\n"
                        . "COACH'S ROLE: Identify where each player is in their development journey and tailor your coaching accordingly. A 14-year-old and a 17-year-old have very different developmental needs.",
                ],
            ]);
        }

        // ── Technical Training (category: technical) ───────────────────────────
        $tech = Course::where('category', 'technical')->first();
        if ($tech) {
            $this->addIfMissing($tech->id, [
                [
                    'order' => 5, 'title' => 'Defending: Principles & Techniques',
                    'duration' => '25 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-shield-fill',
                    'content' =>
                        "Defending is a skill, not just an attitude. The best defenders in the world are technically excellent and tactically intelligent.\n\n"
                        . "THE 4 PRINCIPLES OF DEFENDING\n\n"
                        . "1. DELAY\nWhen your team loses the ball, the first defender's job is to delay the attack — slow down the opponent to give teammates time to recover. Do not dive in. Show the attacker away from goal.\n\n"
                        . "2. DEPTH\nThe second defender provides cover behind the first defender. If the first defender is beaten, the second is in position to challenge. Never both defenders on the same line.\n\n"
                        . "3. BALANCE\nThe rest of the team maintains defensive shape — covering dangerous spaces, tracking runners, and preventing the opposition from switching play into dangerous areas.\n\n"
                        . "4. COMPACTNESS\nThe team stays compact — short distances between lines. This reduces space for the opposition to play through.\n\n"
                        . "1v1 DEFENDING TECHNIQUE\n• Approach at speed, slow down 2 metres from the attacker\n• Stay on your feet — do not slide unless certain\n• Show the attacker onto their weaker foot\n• Watch the ball, not the attacker's body\n• Time your tackle when the attacker's touch is heavy\n\n"
                        . "AERIAL DEFENDING\n• Attack the ball — do not wait for it\n• Use your body to shield the attacker\n• Time your jump to meet the ball at its highest point\n• Head through the ball, not under it\n\n"
                        . "DEFENSIVE COMMUNICATION\nDefending is a team activity. Call 'press', 'hold', 'man on', 'turn', 'time' to organise your teammates. A quiet defence is a disorganised defence.",
                ],
                [
                    'order' => 6, 'title' => 'Set Pieces: Attacking & Defending',
                    'duration' => '25 mins', 'difficulty' => 'advanced',
                    'target_audience' => 'both', 'icon' => 'bi-flag-fill',
                    'content' =>
                        "Set pieces account for approximately 30% of all goals in professional football. Mastering them gives your team a significant competitive advantage.\n\n"
                        . "CORNER KICKS — ATTACKING\nDesign 2–3 corner routines your team practises regularly:\n• Near-post flick-on — delivery to the near post for a flick-on into the danger area\n• Far-post delivery — whipped ball to the back post for a header or volley\n• Short corner — pass to a nearby player to create a crossing angle\n• Dummy run — decoy runners to create space for the primary target\n\n"
                        . "CORNER KICKS — DEFENDING\nChoose between zonal marking and man-marking (or a hybrid):\n• Zonal: players defend areas, not opponents. Requires discipline and timing.\n• Man-marking: each player marks a specific opponent. Requires physical dominance.\n• Always have a player on each post and one at the edge of the box to clear second balls.\n\n"
                        . "FREE KICKS\nDirect free kicks within 25 metres of goal are scoring opportunities:\n• The wall: 3–5 players, positioned to cover one side of the goal\n• The shooter: aims for the opposite corner to the wall\n• Variations: dummy runs, two-man routines, delayed shots\n\n"
                        . "THROW-INS\nOften wasted, throw-ins can be attacking opportunities:\n• Always have a player making a run to receive\n• Use the long throw in the final third as a set-piece delivery\n• Retain possession — don't throw blindly\n\n"
                        . "PENALTIES\nPenalty technique: choose your spot before you run up. Commit to your decision. Strike through the ball with your laces. Aim for the corners. Goalkeepers dive early — a well-placed penalty down the middle is often unstoppable.",
                ],
                [
                    'order' => 7, 'title' => 'Physical Conditioning for Footballers',
                    'duration' => '25 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-activity',
                    'content' =>
                        "Football demands a unique combination of speed, endurance, strength, and agility. A well-conditioned player performs better and gets injured less.\n\n"
                        . "THE PHYSICAL DEMANDS OF FOOTBALL\nA typical outfield player covers 10–13km per match, including:\n• 2–3km of high-intensity running\n• 200–300 sprints\n• Hundreds of jumps, turns, and tackles\n\n"
                        . "THE 5 COMPONENTS OF FOOTBALL FITNESS\n\n"
                        . "1. AEROBIC ENDURANCE\nThe ability to sustain effort over 90 minutes. Developed through: long runs (20–40 mins at moderate pace), interval training, and small-sided games.\n\n"
                        . "2. SPEED & ACCELERATION\nThe ability to reach top speed quickly. Developed through: sprint drills (10m, 20m, 30m), resisted sprints, and plyometrics.\n\n"
                        . "3. STRENGTH\nMuscular strength protects joints and improves power. Developed through: bodyweight exercises (squats, lunges, push-ups), resistance bands, and gym work for older players.\n\n"
                        . "4. AGILITY\nThe ability to change direction quickly. Developed through: ladder drills, cone drills, and reactive agility exercises.\n\n"
                        . "5. FLEXIBILITY\nRange of motion in joints and muscles. Developed through: daily stretching, yoga, and foam rolling.\n\n"
                        . "PERIODISATION\nTraining load should vary across the season:\n• Pre-season: high volume, high intensity — build fitness base\n• In-season: moderate volume, maintain fitness, prioritise recovery\n• Post-season: low volume, active recovery, address injuries\n\n"
                        . "RECOVERY\nRecovery is as important as training. Prioritise: 8 hours of sleep, post-training nutrition (protein + carbs within 30 mins), hydration, and active recovery (light jogging, swimming).",
                ],
            ]);
        }

        // ── Sports Psychology (category: psychology) ───────────────────────────
        $psych = Course::where('category', 'psychology')->first();
        if ($psych) {
            $this->addIfMissing($psych->id, [
                [
                    'order' => 4, 'title' => 'Team Dynamics & Leadership',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-people-fill',
                    'content' =>
                        "Great teams are not just collections of talented individuals — they are groups of people who trust, communicate, and sacrifice for each other.\n\n"
                        . "WHAT MAKES A GREAT TEAM?\nResearch on high-performing teams consistently identifies these factors:\n• Psychological safety — players feel safe to take risks and make mistakes without fear of ridicule\n• Clear roles — everyone knows their responsibilities\n• Shared goals — the team's objectives are understood and owned by all\n• Trust — players believe in each other's commitment and ability\n• Accountability — players hold each other to high standards\n\n"
                        . "TYPES OF LEADERSHIP IN FOOTBALL\n• Formal leaders: the captain, the manager — appointed roles\n• Informal leaders: players who lead by example, energy, and communication — earned through respect\n• Servant leaders: those who put the team first, sacrifice personal glory for collective success\n\n"
                        . "THE CAPTAIN'S ROLE\nA captain is not just the best player — they are the bridge between the manager and the squad. Key responsibilities:\n• Communicate the manager's message on the pitch\n• Motivate teammates during difficult moments\n• Manage conflict within the squad\n• Set the standard in training and behaviour\n\n"
                        . "BUILDING TEAM COHESION\n• Team activities outside football (meals, events, community work)\n• Clear communication channels — no cliques, no exclusion\n• Celebrate collective success, not just individual performance\n• Address conflict quickly and directly — don't let issues fester\n\n"
                        . "FOR COACHES: Create an environment where every player feels valued. Rotate the captaincy among senior players. Involve players in decision-making where appropriate. A player who feels ownership of the team's culture will give more.",
                ],
                [
                    'order' => 5, 'title' => 'Pre-Match Preparation & Routine',
                    'duration' => '15 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-calendar-check-fill',
                    'content' =>
                        "How you prepare in the hours before a match determines how you perform in the 90 minutes that follow.\n\n"
                        . "THE NIGHT BEFORE\n• Sleep: aim for 8–9 hours. Avoid screens for 1 hour before bed.\n• Nutrition: eat a carbohydrate-rich meal (rice, pasta, yam) 3–4 hours before the match.\n• Mental preparation: visualise your performance. See yourself making key passes, winning headers, scoring goals.\n• Kit check: prepare your kit, boots, and water bottle the night before. Remove pre-match stress.\n\n"
                        . "MATCH DAY MORNING\n• Light breakfast 2–3 hours before kick-off: oats, eggs, toast, fruit.\n• Hydrate: drink 500ml of water on waking.\n• Avoid heavy, fatty, or spicy foods.\n• Arrive at the venue early — rushing creates anxiety.\n\n"
                        . "THE WARM-UP\nA proper warm-up prepares your body AND mind:\n• Light jogging to raise heart rate\n• Dynamic stretching (leg swings, hip circles, lunges)\n• Ball work — first touches, passing combinations\n• Activation drills — short sprints, direction changes\n• Set-piece rehearsal\n\n"
                        . "MENTAL ACTIVATION\nDifferent players need different levels of arousal to perform at their best:\n• Some players need to calm down (use breathing, music, quiet time)\n• Some players need to fire up (use music, team talks, physical activation)\n• Know yourself — develop a pre-match routine that gets you into your optimal performance state.\n\n"
                        . "THE TEAM TALK\nA good team talk is: short (5–10 minutes), focused (2–3 key messages), motivating, and specific to the opponent. Avoid information overload — players cannot process 20 tactical instructions before kick-off.",
                ],
            ]);
        }

        // ── Health Education (category: health) ───────────────────────────────
        $health = Course::where('category', 'health')->first();
        if ($health) {
            $this->addIfMissing($health->id, [
                [
                    'order' => 4, 'title' => 'Sleep, Recovery & Performance',
                    'duration' => '15 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-moon-stars-fill',
                    'content' =>
                        "Sleep is the most powerful recovery tool available to any athlete — and it costs nothing.\n\n"
                        . "WHY SLEEP MATTERS FOR FOOTBALLERS\nDuring sleep, your body:\n• Repairs muscle tissue damaged during training\n• Consolidates motor skills learned during the day\n• Releases growth hormone (critical for young players)\n• Restores mental focus and emotional regulation\n\n"
                        . "HOW MUCH SLEEP DO YOU NEED?\n• Ages 13–17: 9–10 hours per night\n• Ages 18–25: 8–9 hours per night\n• Senior players: 7–9 hours per night\n\n"
                        . "SIGNS OF SLEEP DEPRIVATION\n• Slower reaction times\n• Poor decision-making on the pitch\n• Increased injury risk\n• Irritability and low mood\n• Reduced sprint speed and endurance\n\n"
                        . "SLEEP HYGIENE TIPS\n• Keep a consistent sleep schedule — same bedtime and wake time every day\n• Avoid screens (phone, TV) for 60 minutes before bed — blue light suppresses melatonin\n• Keep your room cool, dark, and quiet\n• Avoid caffeine after 2pm\n• Avoid heavy meals within 2 hours of bedtime\n\n"
                        . "NAPPING\nA 20–30 minute nap in the afternoon can improve alertness and performance. Avoid naps longer than 30 minutes — they cause grogginess.\n\n"
                        . "RECOVERY TOOLS\n• Ice baths: reduce inflammation after intense matches\n• Compression garments: improve circulation and reduce muscle soreness\n• Foam rolling: releases muscle tension and improves flexibility\n• Active recovery: light jogging or swimming the day after a match",
                ],
                [
                    'order' => 5, 'title' => 'Substance Awareness & Anti-Doping',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-exclamation-triangle-fill',
                    'content' =>
                        "Every footballer must understand the rules around prohibited substances and the dangers of alcohol, tobacco, and recreational drugs.\n\n"
                        . "ANTI-DOPING IN FOOTBALL\nFIFA and WADA (World Anti-Doping Agency) prohibit the use of performance-enhancing substances. Violations result in bans ranging from 2 years to lifetime exclusion.\n\n"
                        . "PROHIBITED SUBSTANCES INCLUDE\n• Anabolic steroids — artificially increase muscle mass\n• EPO (erythropoietin) — increases red blood cell count\n• Stimulants — increase alertness and mask fatigue\n• Beta-blockers — reduce anxiety (prohibited in some sports)\n• Diuretics — used to mask other substances\n\n"
                        . "STRICT LIABILITY\nIn anti-doping, you are responsible for everything that enters your body. 'I didn't know' is not a defence. Always check supplements with a doctor before taking them.\n\n"
                        . "ALCOHOL\nAlcohol impairs: reaction time, coordination, decision-making, and sleep quality. It also slows muscle recovery. Avoid alcohol during the season, especially within 48 hours of a match.\n\n"
                        . "TOBACCO & VAPING\nSmoking and vaping reduce lung capacity and cardiovascular performance. Nicotine is addictive and harmful. There is no safe level of tobacco use for an athlete.\n\n"
                        . "RECREATIONAL DRUGS\nCannabis, cocaine, and other recreational drugs are prohibited in competition and harmful to health. They impair coordination, motivation, and mental health.\n\n"
                        . "OFA POLICY: OFA operates a zero-tolerance policy on prohibited substances. Any player found using banned substances will be immediately suspended pending investigation.",
                ],
            ]);
        }

        // ── Environmental Initiatives (category: environment) ─────────────────
        $env = Course::where('category', 'environment')->first();
        if ($env) {
            $this->addIfMissing($env->id, [
                [
                    'order' => 4, 'title' => 'Waste Management at Football Venues',
                    'duration' => '15 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-recycle',
                    'content' =>
                        "Football venues generate significant waste. Players, coaches, and supporters all have a role in reducing it.\n\n"
                        . "THE PROBLEM\nA typical grassroots football match generates waste from: plastic water bottles, food packaging, kit packaging, and printed materials. Multiply this by thousands of matches every weekend and the environmental impact is enormous.\n\n"
                        . "THE 3 Rs: REDUCE, REUSE, RECYCLE\n\n"
                        . "REDUCE\n• Bring a reusable water bottle to every session — refuse single-use plastic\n• Use digital communications instead of printed flyers\n• Buy kit that lasts — quality over quantity\n\n"
                        . "REUSE\n• Donate old kit to younger players or community programmes\n• Repair equipment before replacing it\n• Share resources with other clubs where possible\n\n"
                        . "RECYCLE\n• Separate waste at training grounds — plastic, paper, organic\n• Ensure bins are available and clearly labelled at venues\n• Encourage supporters to use recycling facilities\n\n"
                        . "WATER CONSERVATION\nFootball pitches require significant water for maintenance. Clubs can reduce water use by:\n• Watering pitches at dawn or dusk (less evaporation)\n• Using drought-resistant grass varieties\n• Collecting rainwater for pitch irrigation\n\n"
                        . "OFA INITIATIVE: OFA has committed to being a plastic-free training ground by 2027. All players are required to bring reusable water bottles. Single-use plastic bottles will not be provided at training sessions.",
                ],
                [
                    'order' => 5, 'title' => 'Climate Change & Its Impact on Football',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-thermometer-sun',
                    'content' =>
                        "Climate change is already affecting football at every level — from grassroots pitches to World Cup venues.\n\n"
                        . "HOW CLIMATE CHANGE AFFECTS FOOTBALL\n\n"
                        . "EXTREME HEAT\nRising temperatures make outdoor training and matches dangerous. Heat exhaustion and heat stroke are real risks. The 2022 World Cup was moved to November/December specifically because of Qatar's extreme summer heat.\n\n"
                        . "FLOODING\nIncreased rainfall and flooding damage pitches, cancel matches, and destroy facilities. Many community pitches in Lagos are already affected by seasonal flooding.\n\n"
                        . "DROUGHT\nDrought kills grass pitches and increases the risk of hard, dangerous playing surfaces. Water scarcity affects pitch maintenance.\n\n"
                        . "WHAT FOOTBALL IS DOING\n• FIFA has committed to making the 2030 World Cup carbon neutral\n• Premier League clubs have set net-zero targets\n• Forest Green Rovers became the world's first carbon-neutral football club\n• UEFA's 'Football and Sustainability' programme supports clubs in reducing their environmental impact\n\n"
                        . "WHAT YOU CAN DO\n• Walk or cycle to training where possible\n• Reduce meat consumption — livestock farming is a major source of greenhouse gases\n• Plant trees — OFA's tree-planting programme offsets our carbon footprint\n• Educate your family and community about climate change\n\n"
                        . "THE BIGGER PICTURE: Football has a unique platform to influence millions of people. When footballers speak about climate change, people listen. Use your platform responsibly.",
                ],
            ]);
        }

        // ── Community Engagement (category: community) ────────────────────────
        $community = Course::where('category', 'community')->first();
        if ($community) {
            $this->addIfMissing($community->id, [
                [
                    'order' => 4, 'title' => 'Using Football to Promote Education',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-mortarboard-fill',
                    'content' =>
                        "Football and education are not competing priorities — they are complementary pathways to a successful life.\n\n"
                        . "THE DUAL CAREER\nThe vast majority of young footballers will not become professional players. Even those who do will have a career that ends by their mid-30s. Education provides the foundation for life after football.\n\n"
                        . "OFA'S EDUCATION COMMITMENT\nOlufunke Football Academy requires all registered players to:\n• Remain enrolled in school or a vocational programme\n• Maintain satisfactory academic performance\n• Attend OFA's life skills workshops\n\n"
                        . "FOOTBALL AS A CLASSROOM\nFootball teaches skills that are directly transferable to education and work:\n• Teamwork → collaboration in the workplace\n• Discipline → time management and commitment\n• Resilience → handling setbacks and failure\n• Communication → leadership and interpersonal skills\n• Strategic thinking → problem-solving and analysis\n\n"
                        . "COMMUNITY EDUCATION PROGRAMMES\nOFA partners with local schools to:\n• Deliver football coaching as part of physical education\n• Use football as a reward for academic achievement\n• Identify talented players who might otherwise be missed\n• Provide mentorship from OFA players and coaches\n\n"
                        . "SCHOLARSHIPS\nOFA is committed to providing scholarship opportunities for talented players from disadvantaged backgrounds. Academic performance is a key criterion — football talent alone is not sufficient.\n\n"
                        . "YOUR RESPONSIBILITY: As an OFA player, you are an ambassador for the academy in your school and community. Your behaviour, attitude, and academic performance reflect on OFA.",
                ],
                [
                    'order' => 5, 'title' => 'Social Media, Personal Brand & Responsibility',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-phone-fill',
                    'content' =>
                        "In the digital age, every footballer has a personal brand. How you present yourself online can open doors — or close them permanently.\n\n"
                        . "YOUR DIGITAL FOOTPRINT\nEverything you post online is permanent. Scouts, clubs, sponsors, and employers search social media before making decisions. A single inappropriate post can end a career before it starts.\n\n"
                        . "BUILDING A POSITIVE PERSONAL BRAND\n• Share your football journey — training clips, match highlights, achievements\n• Be authentic — show your personality, values, and interests\n• Engage positively with fans, teammates, and the football community\n• Support causes you believe in — community work, education, sustainability\n• Be consistent — your online persona should match who you are in real life\n\n"
                        . "WHAT TO AVOID\n• Negative comments about teammates, opponents, coaches, or referees\n• Controversial political or religious statements\n• Inappropriate images or videos\n• Responding to online abuse — block and report, never engage\n• Sharing confidential team information\n\n"
                        . "CYBERBULLYING\nOnline abuse is a serious issue in football. If you experience cyberbullying:\n• Do not respond to the abuser\n• Screenshot and save evidence\n• Report to the platform\n• Tell a trusted adult — coach, parent, or teacher\n• Contact the relevant football authority if the abuse is football-related\n\n"
                        . "PROFESSIONAL EXAMPLES\nMany professional players use their platforms for positive impact:\n• Marcus Rashford campaigned for free school meals for children in the UK\n• Didier Drogba used his profile to promote peace in Côte d'Ivoire\n• Asisat Oshoala advocates for women's football across Africa\n\n"
                        . "OFA SOCIAL MEDIA POLICY: OFA players are expected to conduct themselves professionally on all social media platforms. Posts that bring the academy into disrepute may result in disciplinary action.",
                ],
            ]);
        }
    }

    /**
     * Add lessons to a course only if they don't already exist (by title).
     */
    private function addIfMissing(int $courseId, array $lessons): void
    {
        foreach ($lessons as $data) {
            $exists = Lesson::where('course_id', $courseId)
                ->where('title', $data['title'])
                ->exists();
            if (!$exists) {
                Lesson::create(array_merge($data, ['course_id' => $courseId]));
            }
        }
    }
}
