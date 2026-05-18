<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;

class NewCourseLessonSeeder extends Seeder
{
    public function run(): void
    {
        // ── Health Education ───────────────────────────────────────────────────
        $health = Course::where('category', 'health')->first();
        if ($health) {
            $lessons = [
                [
                    'order' => 1, 'title' => 'Nutrition for Footballers',
                    'duration' => '20 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-egg-fried',
                    'content' =>
                        "What you eat directly affects how you train, recover, and perform on match day.\n\n"
                        . "MACRONUTRIENTS FOR FOOTBALLERS\n\n"
                        . "CARBOHYDRATES — Your Primary Fuel\nCarbohydrates are the main energy source for high-intensity exercise. Before training or a match, eat complex carbs: rice, pasta, yam, sweet potato, oats. Aim for a meal 2–3 hours before kick-off.\n\n"
                        . "PROTEIN — Recovery and Muscle Repair\nProtein repairs muscle fibres broken down during training. Good sources: eggs, chicken, fish, beans, groundnuts, dairy. Aim for 1.4–1.7g of protein per kg of body weight daily.\n\n"
                        . "FATS — Sustained Energy\nHealthy fats support joint health and hormone production. Sources: avocado, nuts, olive oil, oily fish. Avoid fried and processed foods before matches.\n\n"
                        . "HYDRATION\nDehydration of just 2% body weight reduces performance by up to 20%. Drink water consistently throughout the day — not just during training. Coconut water is an excellent natural electrolyte drink.\n\n"
                        . "PRE-MATCH MEAL (2–3 hours before)\nRice and chicken, pasta with tomato sauce, or yam and egg. Avoid heavy, fatty, or spicy foods.\n\n"
                        . "POST-MATCH RECOVERY MEAL (within 30–60 minutes)\nProtein + carbs: banana and peanut butter, rice and beans, or a protein shake. This window is critical for muscle repair.\n\n"
                        . "OFA TIP: Keep a food diary for one week. Note what you eat before training and how your energy levels feel. Patterns will emerge.",
                ],
                [
                    'order' => 2, 'title' => 'Injury Prevention & Recovery',
                    'duration' => '25 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-bandaid-fill',
                    'content' =>
                        "Injuries are the biggest threat to a footballer's career. Most can be prevented with the right habits.\n\n"
                        . "THE MOST COMMON FOOTBALL INJURIES\n• Ankle sprains — from awkward landings or tackles\n• Hamstring strains — from sprinting without proper warm-up\n• Knee ligament injuries (ACL/MCL) — from sudden direction changes\n• Groin strains — from overstretching during kicks\n• Shin splints — from overtraining on hard surfaces\n\n"
                        . "PREVENTION STRATEGIES\n\n"
                        . "1. WARM UP PROPERLY\nNever skip your warm-up. The FIFA 11+ programme is a scientifically proven warm-up that reduces injury risk by up to 50%. It includes jogging, dynamic stretching, strength exercises, and balance work.\n\n"
                        . "2. COOL DOWN AND STRETCH\nAfter every session, spend 10 minutes cooling down with light jogging and static stretching. Focus on hamstrings, quads, calves, and hip flexors.\n\n"
                        . "3. STRENGTH TRAINING\nStrong muscles protect joints. Include squats, lunges, single-leg exercises, and core work in your weekly routine.\n\n"
                        . "4. REST AND RECOVERY\nMuscles grow and repair during rest, not during training. Aim for 8 hours of sleep. Take at least one full rest day per week.\n\n"
                        . "5. LISTEN TO YOUR BODY\nPain is a signal. Do not train through sharp or persistent pain. Report injuries to your coach immediately — playing through injury makes it worse.\n\n"
                        . "RETURNING FROM INJURY\nFollow a structured return-to-play protocol. Do not rush back. Psychological readiness is as important as physical readiness.",
                ],
                [
                    'order' => 3, 'title' => 'Mental Health & Wellbeing',
                    'duration' => '20 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-heart-pulse-fill',
                    'content' =>
                        "Mental health is as important as physical health. Elite performance requires a healthy mind.\n\n"
                        . "THE MENTAL HEALTH CHALLENGES IN FOOTBALL\nFootballers face unique pressures: performance anxiety, fear of failure, rejection from clubs, social media criticism, and the pressure to provide for family. These are real challenges that require real support.\n\n"
                        . "RECOGNISING THE SIGNS\nWatch for: persistent sadness or low mood, loss of motivation to train, difficulty sleeping, withdrawal from teammates, irritability, or loss of appetite. These are signs that you may need support.\n\n"
                        . "WHAT YOU CAN DO\n\n"
                        . "TALK TO SOMEONE\nSharing your feelings with a trusted coach, teammate, or family member reduces the burden. You are not weak for asking for help — you are strong.\n\n"
                        . "MINDFULNESS AND MEDITATION\nSpend 5–10 minutes daily in quiet reflection. Focus on your breathing. Apps like Headspace or Calm can guide you. This reduces anxiety and improves focus.\n\n"
                        . "LIMIT SOCIAL MEDIA\nSocial media comparison is a major source of anxiety for young players. Limit your time on platforms that make you feel inadequate. Your journey is your own.\n\n"
                        . "CELEBRATE PROGRESS\nAcknowledge your improvements, however small. Progress is not always visible in results — it shows in effort, attitude, and consistency.\n\n"
                        . "OFA COMMITMENT: Olufunke Football Academy is a safe space. We encourage open conversations about mental health and provide access to counseling support for all players.",
                ],
            ];
            foreach ($lessons as $l) {
                Lesson::create(array_merge($l, ['course_id' => $health->id]));
            }
        }

        // ── Environmental Initiatives ──────────────────────────────────────────
        $env = Course::where('category', 'environment')->first();
        if ($env) {
            $lessons = [
                [
                    'order' => 1, 'title' => 'Why Sustainability Matters in Grassroots Football',
                    'duration' => '15 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-tree-fill',
                    'content' =>
                        "Football is played on the earth. How we treat that earth determines whether future generations can play the game we love.\n\n"
                        . "WHAT IS SUSTAINABILITY?\nSustainability means meeting our needs today without compromising the ability of future generations to meet theirs. In football, this means protecting pitches, reducing waste, and respecting the environment around us.\n\n"
                        . "WHY IT MATTERS FOR GRASSROOTS PLAYERS\nGrassroots football is played on community pitches, open fields, and local grounds. These spaces are shared resources. When we damage them — through littering, overuse, or neglect — we take them away from the next generation of players.\n\n"
                        . "THE STATE OF LOCAL PITCHES IN NIGERIA\nMany community pitches in Lagos and across Nigeria suffer from poor drainage, erosion, and litter. Clubs and players have a responsibility to maintain and improve these spaces.\n\n"
                        . "WHAT OFA PLAYERS COMMIT TO\n• Never litter on or around the pitch\n• Report damage to facilities to coaches immediately\n• Participate in pitch maintenance days\n• Encourage teammates to respect shared spaces\n• Conserve water during training — don't leave taps running\n\n"
                        . "THE BIGGER PICTURE\nClimate change is already affecting football — extreme heat, flooding, and drought threaten pitches worldwide. As footballers, we are stewards of the game and the ground it is played on.\n\n"
                        . "OFA ACTION: We organise quarterly pitch clean-up days. Every player is expected to participate. A clean pitch is a safe pitch.",
                ],
                [
                    'order' => 2, 'title' => 'Respect for Opponents, Officials & the Game',
                    'duration' => '15 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-hand-thumbs-up-fill',
                    'content' =>
                        "Environmental stewardship extends beyond the physical pitch — it includes the social environment of football: how we treat opponents, officials, and the game itself.\n\n"
                        . "RESPECT FOR OPPONENTS\nYour opponent is not your enemy — they are your partner in the game. Without them, there is no match. Compete hard, but compete fairly. Shake hands before and after every game. Acknowledge good play from the opposition.\n\n"
                        . "RESPECT FOR REFEREES AND OFFICIALS\nReferees are human. They make mistakes, just as players do. Arguing with officials, surrounding the referee, or using abusive language is unacceptable at OFA. Accept decisions and move on.\n\n"
                        . "RESPECT FOR THE GAME ITSELF\nDiving, time-wasting, and deliberate fouling disrespect the game. Play with integrity. The way you play reflects your character and your academy.\n\n"
                        . "RESPECT FOR FACILITIES\nChanging rooms, dugouts, and training equipment belong to everyone. Leave them as you found them — or better. Vandalism and carelessness have no place in football.\n\n"
                        . "CREATING A POSITIVE ENVIRONMENT\nThe atmosphere around a football club is shaped by every person in it. Positive encouragement, constructive feedback, and inclusive behaviour create an environment where everyone can thrive.\n\n"
                        . "OFA STANDARD: Any player found disrespecting opponents, officials, or facilities will face disciplinary action. We build champions of character, not just champions of football.",
                ],
                [
                    'order' => 3, 'title' => 'Green Football — Reducing Our Carbon Footprint',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-globe2',
                    'content' =>
                        "Football clubs around the world are taking action on climate change. As grassroots players, we can do our part too.\n\n"
                        . "FOOTBALL'S ENVIRONMENTAL IMPACT\nProfessional football generates significant carbon emissions through travel, stadium energy use, and merchandise production. Grassroots football has a smaller footprint, but every action counts.\n\n"
                        . "WHAT WE CAN DO AS PLAYERS\n\n"
                        . "TRAVEL SMART\nWhere possible, share transport to training and matches. Walking or cycling to local sessions reduces emissions and improves fitness.\n\n"
                        . "REDUCE SINGLE-USE PLASTIC\nBring a reusable water bottle to every session. Avoid single-use plastic bags and packaging. OFA provides water stations at training — use them.\n\n"
                        . "TREE PLANTING\nOFA participates in community tree-planting initiatives. Trees improve air quality, reduce heat on pitches, and create shade for players and spectators.\n\n"
                        . "ENERGY CONSERVATION\nTurn off lights, fans, and equipment when not in use. Report leaking taps or broken facilities to management.\n\n"
                        . "EDUCATE OTHERS\nShare what you learn with your family and community. Environmental change starts with awareness.\n\n"
                        . "GLOBAL EXAMPLES\nForest Green Rovers (UK) became the world's first carbon-neutral football club. They use solar energy, serve plant-based food, and maintain an organic pitch. This is the future of football.\n\n"
                        . "OFA PLEDGE: We commit to reducing our environmental impact year on year through education, action, and community partnership.",
                ],
            ];
            foreach ($lessons as $l) {
                Lesson::create(array_merge($l, ['course_id' => $env->id]));
            }
        }

        // ── Community Engagement ───────────────────────────────────────────────
        $community = Course::where('category', 'community')->first();
        if ($community) {
            $lessons = [
                [
                    'order' => 1, 'title' => 'Football as a Tool for Community Change',
                    'duration' => '15 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-people-fill',
                    'content' =>
                        "Football is the most powerful sport in the world — not just because of what happens on the pitch, but because of what it can do off it.\n\n"
                        . "FOOTBALL'S SOCIAL POWER\nFootball brings people together across ethnic, religious, and economic divides. In communities where resources are scarce, a football pitch becomes a classroom, a counseling room, and a place of hope.\n\n"
                        . "OFA'S COMMUNITY MISSION\nOlufunke Football Academy was founded in Ajeromi-Ifelodun — one of the most densely populated local governments in Africa. Our mission goes beyond producing professional footballers. We use football to:\n• Keep young people off the streets\n• Build discipline, confidence, and leadership\n• Create pathways to education and employment\n• Foster unity across communities\n\n"
                        . "REAL IMPACT\nEvery player who trains at OFA becomes an ambassador for their community. When you carry yourself with discipline and respect, you inspire others around you.\n\n"
                        . "YOUR ROLE\nAs an OFA player, you are part of something bigger than football. You represent your family, your community, and your academy. How you behave on and off the pitch matters.\n\n"
                        . "COMMUNITY STATISTICS\nStudies show that young people involved in structured sports programmes are:\n• 40% less likely to engage in criminal activity\n• More likely to complete secondary education\n• Better equipped with leadership and teamwork skills\n\n"
                        . "OFA CHALLENGE: Identify one person in your community — a younger sibling, a neighbour, a friend — who could benefit from football. Invite them to a session.",
                ],
                [
                    'order' => 2, 'title' => 'Volunteering & Mentorship in Football',
                    'duration' => '20 mins', 'difficulty' => 'beginner',
                    'target_audience' => 'both', 'icon' => 'bi-hand-index-thumb-fill',
                    'content' =>
                        "The best way to grow is to give back. Mentorship and volunteering are not just acts of generosity — they develop your own leadership, communication, and empathy.\n\n"
                        . "WHAT IS MENTORSHIP?\nMentorship is a relationship where a more experienced person guides and supports someone less experienced. In football, senior players mentoring younger ones creates a culture of continuous improvement and care.\n\n"
                        . "HOW TO BE A GOOD MENTOR\n• Lead by example — your actions speak louder than your words\n• Be patient — everyone learns at a different pace\n• Encourage, don't criticise — build confidence, not fear\n• Share your experiences — including your failures and what you learned\n• Be consistent — show up for the people who look up to you\n\n"
                        . "VOLUNTEERING IN FOOTBALL\nVolunteering can take many forms:\n• Helping coach younger age groups\n• Organising community football events\n• Maintaining the pitch and facilities\n• Supporting matchday operations\n• Representing OFA at community outreach events\n\n"
                        . "THE BENEFITS OF VOLUNTEERING\nVolunteering builds your CV, develops transferable skills, and connects you with a wider network. Many professional coaches and administrators started as volunteers.\n\n"
                        . "FAMOUS MENTORS IN FOOTBALL\n• Sir Alex Ferguson mentored dozens of players who became managers — including Steve Bruce, Roy Keane, and Ole Gunnar Solskjær.\n• Didier Drogba has invested millions in healthcare and education in Côte d'Ivoire, using his platform to give back.\n\n"
                        . "OFA PROGRAMME: Senior OFA players are encouraged to assist with U13 and U15 sessions. This is a formal part of our player development pathway.",
                ],
                [
                    'order' => 3, 'title' => 'Inclusivity & Outreach in Grassroots Football',
                    'duration' => '20 mins', 'difficulty' => 'intermediate',
                    'target_audience' => 'both', 'icon' => 'bi-heart-fill',
                    'content' =>
                        "Football belongs to everyone. Inclusivity means ensuring that no one is excluded from the game because of their background, ability, gender, or circumstance.\n\n"
                        . "WHAT IS INCLUSIVITY?\nInclusivity in football means actively welcoming and supporting people from all backgrounds. It means creating an environment where everyone feels safe, valued, and able to participate.\n\n"
                        . "BARRIERS TO PARTICIPATION\nMany talented young players never get the opportunity to play because of:\n• Financial barriers — inability to afford kit, registration fees, or transport\n• Geographic barriers — no accessible pitches or clubs nearby\n• Social barriers — discrimination, bullying, or exclusion\n• Gender barriers — girls and women being discouraged from playing\n\n"
                        . "OFA'S OUTREACH WORK\nOlufunke Football Academy actively reaches into underserved communities to identify talent and provide opportunities. We offer:\n• Free trial sessions for players who cannot afford registration\n• Kit donations for players in need\n• Partnerships with local schools to identify and develop talent\n• Open training days for the wider community\n\n"
                        . "GIRLS IN FOOTBALL\nWomen's football is the fastest-growing sport in the world. OFA encourages and supports female participation at all levels. Every player — regardless of gender — deserves the same quality of coaching, facilities, and opportunity.\n\n"
                        . "YOUR RESPONSIBILITY\nInclusivity starts with you. Challenge discrimination when you see it. Welcome new players. Include those who are struggling. A team that looks after its own is a team that wins together.\n\n"
                        . "OFA VISION: A community where every young person, regardless of background, has access to the life-changing power of football.",
                ],
            ];
            foreach ($lessons as $l) {
                Lesson::create(array_merge($l, ['course_id' => $community->id]));
            }
        }
    }
}
