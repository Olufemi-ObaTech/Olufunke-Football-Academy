<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        // ── Football Education Course ──────────────────────────────────────────
        $edu = Course::where('category', 'education')->first();
        if ($edu) {
            $eduLessons = [
                [
                    'order' => 1,
                    'title' => 'The Laws of the Game',
                    'duration' => '20 mins',
                    'difficulty' => 'beginner',
                    'target_audience' => 'both',
                    'icon' => 'bi-book-fill',
                    'content' => "Understanding the 17 Laws of Football is the foundation of every player's education.\n\n"
                        . "LAW 1 — THE FIELD OF PLAY\nThe pitch must be rectangular, between 90–120m long and 45–90m wide for domestic matches. The centre circle has a radius of 9.15m.\n\n"
                        . "LAW 2 — THE BALL\nThe ball must be spherical, made of leather or suitable material, with a circumference of 68–70cm and pressure of 0.6–1.1 atmospheres.\n\n"
                        . "LAW 3 — THE NUMBER OF PLAYERS\nEach team fields 11 players including a goalkeeper. A minimum of 7 players is required to start or continue a match.\n\n"
                        . "LAW 4 — THE PLAYERS' EQUIPMENT\nPlayers must wear a jersey, shorts, socks, shin guards, and footwear. Goalkeepers must wear colours distinguishable from outfield players.\n\n"
                        . "LAW 5 — THE REFEREE\nThe referee has full authority to enforce the Laws of the Game. Their decisions are final and binding.\n\n"
                        . "LAW 11 — OFFSIDE\nA player is in an offside position if any part of their head, body, or feet is in the opponents' half and closer to the goal line than both the ball and the second-to-last opponent.\n\n"
                        . "KEY TAKEAWAY: Knowing the rules gives you a competitive edge. Study them, understand them, and use them to your advantage on the pitch.",
                ],
                [
                    'order' => 2,
                    'title' => 'Football Ethics & Fair Play',
                    'duration' => '15 mins',
                    'difficulty' => 'beginner',
                    'target_audience' => 'both',
                    'icon' => 'bi-shield-check',
                    'content' => "Football is more than a game — it is a school of life. The values you develop on the pitch shape who you become off it.\n\n"
                        . "RESPECT\nRespect your teammates, opponents, referees, and coaches. Disagreements happen, but how you handle them defines your character. Never argue with a referee's decision — accept it and move on.\n\n"
                        . "FAIR PLAY\nFair play means competing honestly. Avoid diving, time-wasting, or deliberately fouling opponents. FIFA's Fair Play campaign recognises teams and players who embody these values.\n\n"
                        . "DISCIPLINE\nYellow and red cards exist to protect players. Accumulating bookings hurts your team. Stay composed under pressure — elite players control their emotions.\n\n"
                        . "TEAMWORK\nNo individual wins a match alone. Celebrate your teammates' successes. Support them when they make mistakes. A team that trusts each other is unbeatable.\n\n"
                        . "LEADERSHIP\nLeadership is not just for captains. Every player leads by example — through effort, attitude, and commitment. Be the player your team looks to when things get tough.\n\n"
                        . "OFA VALUES: At Olufunke Football Academy, we build champions on and off the pitch. Discipline, respect, and teamwork are non-negotiable.",
                ],
                [
                    'order' => 3,
                    'title' => 'Understanding Positions & Formations',
                    'duration' => '25 mins',
                    'difficulty' => 'intermediate',
                    'target_audience' => 'both',
                    'icon' => 'bi-diagram-3-fill',
                    'content' => "Football formations are the tactical blueprint of a team. Understanding them helps you read the game and make smarter decisions.\n\n"
                        . "GOALKEEPER (GK)\nThe last line of defence. Must command the penalty area, organise the defence, and distribute the ball effectively.\n\n"
                        . "DEFENDERS (CB, LB, RB)\nCentre-backs protect the central areas and win aerial duels. Full-backs provide width and support attacks. Modern full-backs are expected to overlap and create chances.\n\n"
                        . "MIDFIELDERS (DM, CM, AM)\nThe engine of the team. Defensive midfielders screen the back four. Central midfielders link defence and attack. Attacking midfielders create chances and score goals.\n\n"
                        . "FORWARDS (ST, LW, RW)\nStrikers finish chances and lead the press. Wingers provide pace and width, cutting inside or delivering crosses.\n\n"
                        . "COMMON FORMATIONS:\n• 4-4-2: Classic, balanced, great for pressing\n• 4-3-3: Attacking, high press, used by Liverpool & Barcelona\n• 4-2-3-1: Defensive solidity with creative freedom\n• 3-5-2: Wing-backs provide width, strong in midfield\n• 5-3-2: Defensive, counter-attacking\n\n"
                        . "READING THE GAME: Understanding formations helps you anticipate where space will appear. Study your opponents' shape before every match.",
                ],
                [
                    'order' => 4,
                    'title' => 'Video Analysis & Match Intelligence',
                    'duration' => '30 mins',
                    'difficulty' => 'advanced',
                    'target_audience' => 'both',
                    'icon' => 'bi-camera-video-fill',
                    'content' => "Elite players and coaches use video analysis to gain a competitive edge. Learning to analyse footage transforms how you understand the game.\n\n"
                        . "WHY VIDEO ANALYSIS MATTERS\nProfessional clubs invest millions in analysis departments. Players like Cristiano Ronaldo and Virgil van Dijk are known for studying footage of themselves and opponents for hours.\n\n"
                        . "WHAT TO LOOK FOR IN YOUR OWN FOOTAGE:\n• Positioning — are you in the right place at the right time?\n• Decision-making — did you choose the best option?\n• Body shape — are you open to receive the ball?\n• Pressing triggers — when do you press and when do you hold?\n\n"
                        . "ANALYSING OPPONENTS:\n• Identify their patterns of play — do they build from the back or go direct?\n• Spot their key players and neutralise them\n• Find spaces they leave — wide areas, behind the striker, second balls\n\n"
                        . "TOOLS FOR ANALYSIS:\nYouTube, Wyscout, InStat, and even your phone camera can be used to record and review matches. OFA encourages all players to record training sessions and review them.\n\n"
                        . "PRACTICAL EXERCISE: Watch a full match of a top team (e.g., Manchester City, Arsenal). Pause every time they win the ball and note their immediate reaction — press, recycle, or counter?",
                ],
            ];
            foreach ($eduLessons as $l) {
                Lesson::create(array_merge($l, ['course_id' => $edu->id]));
            }
        }

        // ── Technical Training Course ──────────────────────────────────────────
        $tech = Course::where('category', 'technical')->first();
        if ($tech) {
            $techLessons = [
                [
                    'order' => 1,
                    'title' => 'Ball Mastery & First Touch',
                    'duration' => '20 mins',
                    'difficulty' => 'beginner',
                    'target_audience' => 'player',
                    'icon' => 'bi-circle-fill',
                    'content' => "Your first touch is your most important touch. It sets up everything that follows — your next pass, your dribble, your shot.\n\n"
                        . "THE PERFECT FIRST TOUCH\nA good first touch controls the ball into space, away from pressure, and into a position where you can play forward. Use the inside of your foot for most receptions. Use your chest, thigh, or instep for aerial balls.\n\n"
                        . "BALL MASTERY DRILLS:\n\n"
                        . "1. TOE TAPS — Alternate tapping the top of the ball with each foot. Start slow, build speed. 30 seconds x 3 sets.\n\n"
                        . "2. INSIDE-OUTSIDE ROLLS — Roll the ball with the inside of your right foot, then the outside of your left. Builds coordination and close control.\n\n"
                        . "3. V-ROLLS — Pull the ball back with your sole, then push it forward with the inside of your foot. Creates a V-shape movement.\n\n"
                        . "4. CRUYFF TURN — Fake to pass or shoot, then drag the ball behind your standing leg and accelerate away. Used by Johan Cruyff to bamboozle defenders.\n\n"
                        . "5. RONDO (4v1 or 5v2) — Keep-ball in a small circle. Forces quick thinking, sharp passing, and constant movement.\n\n"
                        . "DAILY PRACTICE: Spend 15 minutes every day on ball mastery. Consistency beats intensity. The best players in the world still do these drills.",
                ],
                [
                    'order' => 2,
                    'title' => 'Passing & Receiving Under Pressure',
                    'duration' => '25 mins',
                    'difficulty' => 'intermediate',
                    'target_audience' => 'player',
                    'icon' => 'bi-arrow-left-right',
                    'content' => "Passing is the language of football. A team that passes well controls the game.\n\n"
                        . "TYPES OF PASSES:\n• Short pass (inside of foot) — accurate, used in tight spaces\n• Long pass (instep/laces) — switches play, bypasses pressure\n• Through ball — splits the defence, requires timing and vision\n• Chip pass — lofted, used to play over a pressing defender\n• Backheel — disguised, used to surprise opponents\n\n"
                        . "PASSING PRINCIPLES:\n1. Weight of pass — too hard and the receiver struggles; too soft and it gets intercepted\n2. Accuracy — aim for the foot furthest from the defender\n3. Timing — pass before the pressure arrives, not after\n4. Communication — call for the ball, signal your intention\n\n"
                        . "RECEIVING UNDER PRESSURE:\n• Scan before you receive — know where the pressure is coming from\n• Open your body — face the direction you want to play\n• Use your first touch to escape pressure — don't receive and stand still\n• Play simple when under pressure — retain possession\n\n"
                        . "DRILL — PASSING SQUARE:\nSet up 4 cones in a 10m square. 4 players, one at each cone. Pass and follow your pass. Add a defender in the middle to increase difficulty.",
                ],
                [
                    'order' => 3,
                    'title' => 'Shooting Technique & Finishing',
                    'duration' => '25 mins',
                    'difficulty' => 'intermediate',
                    'target_audience' => 'player',
                    'icon' => 'bi-bullseye',
                    'content' => "Goals win matches. Finishing is a skill that can be trained and improved with deliberate practice.\n\n"
                        . "SHOOTING TECHNIQUES:\n\n"
                        . "INSTEP DRIVE (LACES)\nThe most powerful shot. Plant your non-kicking foot beside the ball, lock your ankle, and strike through the centre of the ball with your laces. Follow through toward the target.\n\n"
                        . "INSIDE FOOT PLACEMENT\nUsed for accuracy over power. Ideal for placing the ball into corners from close range. Used by clinical finishers like Thierry Henry and Didier Drogba.\n\n"
                        . "VOLLEY\nStrike the ball before it bounces. Keep your eyes on the ball, lean slightly back, and make contact with your instep. Timing is everything.\n\n"
                        . "CHIP SHOT\nUsed when the goalkeeper is off their line. Slide your foot under the ball with a short, sharp motion. No follow-through.\n\n"
                        . "FINISHING PRINCIPLES:\n• Shoot early — goalkeepers are vulnerable when they haven't set\n• Aim for corners — the hardest areas for keepers to reach\n• Stay composed — slow down your mind, not your body\n• Practice weak foot — be dangerous from both sides\n\n"
                        . "DRILL — 1v1 FINISHING:\nServer plays ball into striker 20m from goal. Striker takes one touch and shoots. Vary the angle and distance. 10 reps each side.",
                ],
                [
                    'order' => 4,
                    'title' => 'Tactical Awareness & Pressing',
                    'duration' => '30 mins',
                    'difficulty' => 'advanced',
                    'target_audience' => 'both',
                    'icon' => 'bi-grid-3x3-gap-fill',
                    'content' => "Modern football is won and lost in transitions. Teams that press intelligently and defend as a unit dominate the game.\n\n"
                        . "WHAT IS PRESSING?\nPressing is the act of applying pressure to the ball-carrier immediately after losing possession. The goal is to win the ball back quickly, before the opponent can organise.\n\n"
                        . "TYPES OF PRESSING:\n• High press — pressure applied in the opponent's half (Klopp's Liverpool, Guardiola's City)\n• Mid-block — pressure applied in the middle third\n• Low block — deep defensive shape, absorb pressure and counter\n\n"
                        . "PRESSING TRIGGERS:\nA pressing trigger is the moment your team decides to press. Common triggers:\n• A poor touch by the opponent\n• A back pass to the goalkeeper\n• A long ball that is contested\n• The ball going to a weak-footed player\n\n"
                        . "DEFENSIVE SHAPE:\n• Stay compact — reduce space between lines\n• Cover shadows — position yourself to block passing lanes\n• Communicate — call 'press', 'hold', 'drop'\n• Track runners — don't ball-watch\n\n"
                        . "TRANSITIONS:\nThe moment of losing or winning the ball is the most dangerous moment in football. React immediately:\n• After losing the ball: press for 5 seconds, then reorganise\n• After winning the ball: play forward quickly before the opponent recovers\n\n"
                        . "STUDY: Watch Jürgen Klopp's Liverpool (2019-2020) for the perfect example of gegenpressing — winning the ball back within 5 seconds of losing it.",
                ],
            ];
            foreach ($techLessons as $l) {
                Lesson::create(array_merge($l, ['course_id' => $tech->id]));
            }
        }

        // ── Sports Psychology Course ───────────────────────────────────────────
        $psych = Course::where('category', 'psychology')->first();
        if ($psych) {
            $psychLessons = [
                [
                    'order' => 1,
                    'title' => 'The Winning Mindset',
                    'duration' => '20 mins',
                    'difficulty' => 'beginner',
                    'target_audience' => 'both',
                    'icon' => 'bi-lightbulb-fill',
                    'content' => "The difference between good players and great players is often not physical — it is mental.\n\n"
                        . "GROWTH MINDSET vs FIXED MINDSET\nA fixed mindset believes talent is fixed — you either have it or you don't. A growth mindset believes ability can be developed through dedication and hard work. Every elite athlete has a growth mindset.\n\n"
                        . "SELF-BELIEF\nYou cannot perform at your best if you don't believe in yourself. Self-belief is not arrogance — it is a quiet confidence built through preparation and hard work. Prepare thoroughly, and confidence follows.\n\n"
                        . "HANDLING FAILURE\nEvery great player has failed. Messi was rejected by clubs. Ronaldo was told he was too small. Failure is not the opposite of success — it is part of the journey. Learn from every mistake and move forward.\n\n"
                        . "GOAL SETTING\nSet SMART goals: Specific, Measurable, Achievable, Relevant, Time-bound. Don't just say 'I want to be a professional footballer.' Say 'I will improve my weak foot by practising 20 minutes daily for 3 months.'\n\n"
                        . "DAILY AFFIRMATIONS\nStart each day with positive statements about yourself and your abilities. 'I am improving every day. I am a disciplined, focused footballer. I give 100% in every session.'\n\n"
                        . "OFA CHALLENGE: Write down 3 football goals for this month. Share them with your coach. Review them at the end of the month.",
                ],
                [
                    'order' => 2,
                    'title' => 'Focus, Concentration & Pressure',
                    'duration' => '20 mins',
                    'difficulty' => 'intermediate',
                    'target_audience' => 'both',
                    'icon' => 'bi-eye-fill',
                    'content' => "Elite performance requires the ability to focus completely on the present moment, regardless of the score, the crowd, or the pressure.\n\n"
                        . "CONCENTRATION IN FOOTBALL\nA single lapse in concentration can cost a goal. Defenders who switch off for one second get punished. Strikers who lose focus miss open goals. Train your concentration like a muscle.\n\n"
                        . "TECHNIQUES FOR FOCUS:\n\n"
                        . "1. PRE-PERFORMANCE ROUTINE\nDevelop a consistent routine before matches and training. This signals to your brain that it is time to perform. It could be a specific warm-up, a playlist, or a breathing exercise.\n\n"
                        . "2. PROCESS FOCUS\nFocus on what you can control — your effort, your positioning, your decisions. Don't focus on the result, the crowd, or what others think.\n\n"
                        . "3. BREATHING CONTROL\nWhen you feel anxious or overwhelmed, use box breathing: inhale for 4 counts, hold for 4, exhale for 4, hold for 4. This activates your parasympathetic nervous system and calms you down.\n\n"
                        . "4. RESET CUES\nWhen you make a mistake, use a physical reset cue — clap your hands, take a deep breath, or say a keyword like 'next play.' This prevents one mistake from becoming two.\n\n"
                        . "PERFORMING UNDER PRESSURE\nPressure is a privilege — it means you are in a situation that matters. Reframe pressure as excitement. The best players perform their best when the stakes are highest.",
                ],
                [
                    'order' => 3,
                    'title' => 'Resilience & Bouncing Back',
                    'duration' => '15 mins',
                    'difficulty' => 'intermediate',
                    'target_audience' => 'both',
                    'icon' => 'bi-arrow-repeat',
                    'content' => "Resilience is the ability to recover quickly from setbacks. In football, setbacks are inevitable — injuries, bad form, rejection, defeat. How you respond defines your career.\n\n"
                        . "WHAT IS RESILIENCE?\nResilience is not about never falling — it is about getting up every time you fall. It is built through adversity, not avoided by it.\n\n"
                        . "STORIES OF RESILIENCE:\n• Jamie Vardy was released by Sheffield Wednesday at 16 and played non-league football before becoming a Premier League champion and England international.\n• N'Golo Kanté was rejected by multiple academies before becoming one of the best midfielders in the world.\n• Victor Osimhen overcame poverty and personal tragedy to become one of Africa's greatest strikers.\n\n"
                        . "BUILDING RESILIENCE:\n1. Embrace discomfort — train in difficult conditions, push through fatigue\n2. Develop a support network — coaches, teammates, family\n3. Reflect, don't ruminate — analyse what went wrong, then let it go\n4. Celebrate small wins — progress is not always visible, but it is always happening\n5. Stay consistent — show up every day, even when you don't feel like it\n\n"
                        . "INJURY RECOVERY\nInjuries are one of the hardest tests of resilience. Use recovery time to study the game, strengthen your mind, and work on areas you can improve without full training.\n\n"
                        . "OFA PRINCIPLE: We don't just develop footballers — we develop resilient human beings who can handle whatever life throws at them.",
                ],
            ];
            foreach ($psychLessons as $l) {
                Lesson::create(array_merge($l, ['course_id' => $psych->id]));
            }
        }
    }
}
