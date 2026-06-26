<?php

namespace Database\Seeders;

use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\QuizWeek;
use Illuminate\Database\Seeder;

class QuizWeek2Seeder extends Seeder
{
    public function run(): void
    {
        if (QuizWeek::where('title', 'like', 'Week 2%')->exists()) {
            return;
        }

        $week2 = QuizWeek::create([
            'title'       => 'Week 2 — African Football & Tactics',
            'description' => 'Dive deeper — African football history, advanced tactics, fitness science, and OFA values.',
            'theme'       => 'African Football & Tactics',
            'week_start'  => now()->addWeek()->startOfWeek()->format('Y-m-d'),
            'week_end'    => now()->addWeek()->endOfWeek()->format('Y-m-d'),
            'is_active'   => false,
            'time_limit'  => 360,
        ]);

        $questions = [
            // ── African Football ─────────────────────────────────────────────────
            [
                'question'    => 'Which country won the 2023 Africa Cup of Nations (AFCON)?',
                'difficulty'  => 'medium',
                'category'    => 'africa',
                'explanation' => 'Ivory Coast (Côte d\'Ivoire) won the 2023 AFCON on home soil, defeating Nigeria 2-1 in the final.',
                'options' => [
                    ['text' => 'Nigeria',       'correct' => false],
                    ['text' => 'Morocco',        'correct' => false],
                    ['text' => 'Ivory Coast',    'correct' => true],
                    ['text' => 'Senegal',        'correct' => false],
                ],
            ],
            [
                'question'    => 'How many times has Nigeria won the Africa Cup of Nations?',
                'difficulty'  => 'medium',
                'category'    => 'nigeria',
                'explanation' => 'Nigeria has won the AFCON 3 times: 1980, 1994, and 2013.',
                'options' => [
                    ['text' => '2', 'correct' => false],
                    ['text' => '3', 'correct' => true],
                    ['text' => '4', 'correct' => false],
                    ['text' => '5', 'correct' => false],
                ],
            ],
            [
                'question'    => 'Which African player won the 2022 FIFA Best Men\'s Player award?',
                'difficulty'  => 'medium',
                'category'    => 'africa',
                'explanation' => 'Sadio Mané won the 2022 FIFA Best Men\'s Player award after leading Senegal to their first AFCON title.',
                'options' => [
                    ['text' => 'Mohamed Salah',  'correct' => false],
                    ['text' => 'Victor Osimhen', 'correct' => false],
                    ['text' => 'Sadio Mané',     'correct' => true],
                    ['text' => 'Riyad Mahrez',   'correct' => false],
                ],
            ],
            [
                'question'    => 'Which country was the first African nation to reach a FIFA World Cup semi-final?',
                'difficulty'  => 'hard',
                'category'    => 'africa',
                'explanation' => 'Morocco became the first African nation to reach a FIFA World Cup semi-final at the 2022 World Cup in Qatar.',
                'options' => [
                    ['text' => 'Cameroon', 'correct' => false],
                    ['text' => 'Senegal',  'correct' => false],
                    ['text' => 'Nigeria',  'correct' => false],
                    ['text' => 'Morocco',  'correct' => true],
                ],
            ],
            [
                'question'    => 'Which club competition do African clubs compete in at the highest continental level?',
                'difficulty'  => 'easy',
                'category'    => 'africa',
                'explanation' => 'The CAF Champions League is Africa\'s top club competition, equivalent to Europe\'s UEFA Champions League.',
                'options' => [
                    ['text' => 'CAF Champions League',        'correct' => true],
                    ['text' => 'CAF Confederation Cup',       'correct' => false],
                    ['text' => 'Africa Super League',         'correct' => false],
                    ['text' => 'WAFU Nations Cup',            'correct' => false],
                ],
            ],

            // ── Tactics ──────────────────────────────────────────────────────────
            [
                'question'    => 'What does "gegenpressing" mean in football?',
                'difficulty'  => 'hard',
                'category'    => 'tactics',
                'explanation' => 'Gegenpressing (counter-pressing) is a tactic popularised by Jürgen Klopp where a team immediately presses to win back the ball right after losing it, before the opposition can organise.',
                'options' => [
                    ['text' => 'A defensive tactic of sitting back deep',        'correct' => false],
                    ['text' => 'Counter-pressing immediately after losing the ball','correct' => true],
                    ['text' => 'Playing long balls over the defence',             'correct' => false],
                    ['text' => 'Parking the bus in your own half',               'correct' => false],
                ],
            ],
            [
                'question'    => 'In a 4-2-3-1 formation, what do the two central players in front of the defence do?',
                'difficulty'  => 'medium',
                'category'    => 'tactics',
                'explanation' => 'In a 4-2-3-1, the two players in front of the back four are defensive midfielders (double pivot) who protect the defence and recycle possession.',
                'options' => [
                    ['text' => 'Act as wingers',                  'correct' => false],
                    ['text' => 'Play as defensive midfielders',   'correct' => true],
                    ['text' => 'Support the striker directly',    'correct' => false],
                    ['text' => 'Act as centre-backs in possession','correct' => false],
                ],
            ],
            [
                'question'    => 'What is meant by "pressing triggers" in modern football?',
                'difficulty'  => 'hard',
                'category'    => 'tactics',
                'explanation' => 'Pressing triggers are pre-agreed cues (e.g. a bad touch, a back-pass, a certain body shape) that signal to the whole team to press simultaneously.',
                'options' => [
                    ['text' => 'Signals from the goalkeeper to start attacking',             'correct' => false],
                    ['text' => 'Pre-agreed cues that tell the whole team when to press',      'correct' => true],
                    ['text' => 'A referee signal to stop play',                              'correct' => false],
                    ['text' => 'When a team presses only in the final 10 minutes',           'correct' => false],
                ],
            ],
            [
                'question'    => 'What does "transition" mean in football analysis?',
                'difficulty'  => 'medium',
                'category'    => 'tactics',
                'explanation' => 'Transition refers to the moments when a team switches between attacking and defending — or vice versa — after gaining or losing the ball.',
                'options' => [
                    ['text' => 'Substituting a player during a match',                   'correct' => false],
                    ['text' => 'The moment a team switches between attack and defence',   'correct' => true],
                    ['text' => 'Moving to a different formation at half time',            'correct' => false],
                    ['text' => 'A player dribbling past defenders',                      'correct' => false],
                ],
            ],

            // ── Rules (Advanced) ─────────────────────────────────────────────────
            [
                'question'    => 'Can a player be offside from a throw-in?',
                'difficulty'  => 'medium',
                'category'    => 'rules',
                'explanation' => 'No — a player cannot be offside directly from a throw-in. Offside does not apply to throw-ins, goal kicks, or corner kicks.',
                'options' => [
                    ['text' => 'Yes, if they are ahead of the last defender',            'correct' => false],
                    ['text' => 'No, offside does not apply from a throw-in',             'correct' => true],
                    ['text' => 'Only if the throw-in is taken in the opponents\' half', 'correct' => false],
                    ['text' => 'Yes, but only if the referee judges it deliberate',      'correct' => false],
                ],
            ],
            [
                'question'    => 'What is the minimum number of players required for a team to continue a match?',
                'difficulty'  => 'hard',
                'category'    => 'rules',
                'explanation' => 'According to FIFA Law 3, a match may not start or continue if either team has fewer than 7 players.',
                'options' => [
                    ['text' => '6', 'correct' => false],
                    ['text' => '7', 'correct' => true],
                    ['text' => '8', 'correct' => false],
                    ['text' => '9', 'correct' => false],
                ],
            ],
            [
                'question'    => 'If the ball hits the referee and goes into the goal, what is the decision?',
                'difficulty'  => 'hard',
                'category'    => 'rules',
                'explanation' => 'Since the 2019 rule change, if the ball touches the referee and goes into the goal or creates a goal-scoring opportunity, play is stopped and restarted with a dropped ball.',
                'options' => [
                    ['text' => 'Goal is awarded',                                         'correct' => false],
                    ['text' => 'Play is stopped and restarted with a dropped ball',       'correct' => true],
                    ['text' => 'Corner kick to the attacking team',                       'correct' => false],
                    ['text' => 'Goal kick to the defending team',                         'correct' => false],
                ],
            ],
            [
                'question'    => 'A player receives the ball from the goalkeeper\'s throw-out and passes it back — is this allowed?',
                'difficulty'  => 'medium',
                'category'    => 'rules',
                'explanation' => 'Yes — the backpass rule only applies to intentional kicks. The goalkeeper\'s throw is not a kick, so a player can receive it and pass back, but the GK cannot then handle it with their hands.',
                'options' => [
                    ['text' => 'No, it counts as a deliberate backpass',                 'correct' => false],
                    ['text' => 'Yes, because the keeper\'s throw is not a kick',         'correct' => true],
                    ['text' => 'Only if the player uses their head',                     'correct' => false],
                    ['text' => 'Only in extra time',                                     'correct' => false],
                ],
            ],

            // ── Fitness & Sports Science ─────────────────────────────────────────
            [
                'question'    => 'What energy system provides power for a short explosive sprint in football?',
                'difficulty'  => 'medium',
                'category'    => 'fitness',
                'explanation' => 'The ATP-PC (phosphocreatine) system powers short explosive efforts up to about 10 seconds — like a sprint to the ball or an explosive shot.',
                'options' => [
                    ['text' => 'Aerobic system',       'correct' => false],
                    ['text' => 'Lactic acid system',  'correct' => false],
                    ['text' => 'ATP-PC system',        'correct' => true],
                    ['text' => 'Glycolytic system',    'correct' => false],
                ],
            ],
            [
                'question'    => 'Why is hydration important for a footballer during a match?',
                'difficulty'  => 'easy',
                'category'    => 'fitness',
                'explanation' => 'Even mild dehydration (as little as 2% body weight loss) reduces a player\'s speed, decision-making, and concentration. Proper hydration maintains performance.',
                'options' => [
                    ['text' => 'It only matters in hot weather',                     'correct' => false],
                    ['text' => 'It maintains speed, focus, and decision-making',     'correct' => true],
                    ['text' => 'Water makes players heavier and slower',             'correct' => false],
                    ['text' => 'It only affects goalkeepers',                        'correct' => false],
                ],
            ],
            [
                'question'    => 'What does "VO2 max" measure in football fitness?',
                'difficulty'  => 'hard',
                'category'    => 'fitness',
                'explanation' => 'VO2 max is the maximum rate of oxygen consumption during intense exercise. A higher VO2 max allows a player to sustain high-intensity effort for longer.',
                'options' => [
                    ['text' => 'Maximum sprint speed',                              'correct' => false],
                    ['text' => 'Maximum oxygen uptake during exercise',             'correct' => true],
                    ['text' => 'The number of calories burned in a match',          'correct' => false],
                    ['text' => 'Heart rate at rest',                                'correct' => false],
                ],
            ],
            [
                'question'    => 'How much distance does a professional midfielder typically cover in a 90-minute match?',
                'difficulty'  => 'medium',
                'category'    => 'fitness',
                'explanation' => 'Elite midfielders typically cover 10–13 km per match, combining walking, jogging, running, and sprinting throughout the 90 minutes.',
                'options' => [
                    ['text' => '5–7 km',    'correct' => false],
                    ['text' => '8–9 km',    'correct' => false],
                    ['text' => '10–13 km',  'correct' => true],
                    ['text' => '15–18 km',  'correct' => false],
                ],
            ],

            // ── Mental Strength & Values ─────────────────────────────────────────
            [
                'question'    => 'What does "mental resilience" mean for a young footballer?',
                'difficulty'  => 'easy',
                'category'    => 'psychology',
                'explanation' => 'Mental resilience is the ability to bounce back from mistakes, defeats, or setbacks and continue performing with confidence and determination.',
                'options' => [
                    ['text' => 'Never making mistakes on the pitch',                     'correct' => false],
                    ['text' => 'Bouncing back from mistakes and setbacks with confidence','correct' => true],
                    ['text' => 'Ignoring the coach\'s instructions',                     'correct' => false],
                    ['text' => 'Avoiding difficult training sessions',                   'correct' => false],
                ],
            ],
            [
                'question'    => 'What is the benefit of a pre-match routine for a footballer?',
                'difficulty'  => 'medium',
                'category'    => 'psychology',
                'explanation' => 'A consistent pre-match routine helps players enter a focused mental state, reduces anxiety, and triggers the mind and body to perform at their best.',
                'options' => [
                    ['text' => 'It wastes energy before the match',                      'correct' => false],
                    ['text' => 'It triggers focus, reduces anxiety, and prepares the mind','correct' => true],
                    ['text' => 'It is only useful for professional players',             'correct' => false],
                    ['text' => 'It makes players tired before the game',                 'correct' => false],
                ],
            ],

            // ── Youth Football & OFA Values ───────────────────────────────────────
            [
                'question'    => 'What is the most important quality a youth player should develop first?',
                'difficulty'  => 'easy',
                'category'    => 'youth',
                'explanation' => 'Discipline — the commitment to training, learning, and following the team\'s principles — is the foundation of all development. Without discipline, no other quality can grow.',
                'options' => [
                    ['text' => 'Speed',       'correct' => false],
                    ['text' => 'Discipline',  'correct' => true],
                    ['text' => 'Strength',    'correct' => false],
                    ['text' => 'Dribbling',   'correct' => false],
                ],
            ],
            [
                'question'    => 'At what age does UEFA recommend switching from 7-a-side to 9-a-side football for youth players?',
                'difficulty'  => 'hard',
                'category'    => 'youth',
                'explanation' => 'UEFA\'s Long-Term Player Development (LTPD) model recommends 7-a-side for U9–U11, transitioning to 9-a-side for U12–U13, before full 11-a-side at U14+.',
                'options' => [
                    ['text' => 'U10', 'correct' => false],
                    ['text' => 'U12', 'correct' => true],
                    ['text' => 'U14', 'correct' => false],
                    ['text' => 'U16', 'correct' => false],
                ],
            ],
            [
                'question'    => 'What is the main purpose of "small-sided games" in football training?',
                'difficulty'  => 'medium',
                'category'    => 'youth',
                'explanation' => 'Small-sided games (e.g. 4v4, 5v5) increase the number of ball touches, decisions, and 1v1 situations each player faces, dramatically improving technical and tactical development.',
                'options' => [
                    ['text' => 'To reduce the number of players needed for a session',      'correct' => false],
                    ['text' => 'To improve fitness only',                                   'correct' => false],
                    ['text' => 'To maximise touches, decisions, and 1v1 situations',        'correct' => true],
                    ['text' => 'To teach players to play on smaller pitches',               'correct' => false],
                ],
            ],
            [
                'question'    => 'Which of these best describes "sportsmanship" in football?',
                'difficulty'  => 'easy',
                'category'    => 'youth',
                'explanation' => 'Sportsmanship means competing hard but with respect — for opponents, teammates, referees, and the game itself. It includes fair play, accepting defeat gracefully, and celebrating without disrespect.',
                'options' => [
                    ['text' => 'Winning at all costs, even by cheating',                   'correct' => false],
                    ['text' => 'Competing with respect for opponents, officials, and the game','correct' => true],
                    ['text' => 'Only celebrating your own goals',                          'correct' => false],
                    ['text' => 'Arguing with referees when decisions go against you',      'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $qIdx => $qData) {
            $question = QuizQuestion::create([
                'quiz_week_id' => $week2->id,
                'order'        => $qIdx + 1,
                'question'     => $qData['question'],
                'difficulty'   => $qData['difficulty'],
                'category'     => $qData['category'],
                'explanation'  => $qData['explanation'],
            ]);
            foreach ($qData['options'] as $oIdx => $oData) {
                QuizOption::create([
                    'quiz_question_id' => $question->id,
                    'option_text'      => $oData['text'],
                    'is_correct'       => $oData['correct'],
                    'order'            => $oIdx + 1,
                ]);
            }
        }
    }
}
