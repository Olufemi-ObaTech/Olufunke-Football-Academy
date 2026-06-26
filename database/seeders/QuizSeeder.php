<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizWeek;
use App\Models\QuizQuestion;
use App\Models\QuizOption;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        if (QuizWeek::count() > 0) {
            return;
        }

        // ── Week 1: General Football Knowledge ────────────────────────────────
        $week1 = QuizWeek::create([
            'title'       => 'Week 1 — General Football Knowledge',
            'description' => 'Test your general football knowledge across history, rules, and famous players.',
            'theme'       => 'General Knowledge',
            'week_start'  => now()->startOfWeek()->format('Y-m-d'),
            'week_end'    => now()->endOfWeek()->format('Y-m-d'),
            'is_active'   => true,
            'time_limit'  => 300,
        ]);

        $questions = [
            [
                'question'   => 'How many players are on the field for each team in a standard football match?',
                'difficulty' => 'easy',
                'category'   => 'rules',
                'explanation'=> 'Each team fields 11 players including the goalkeeper, as per Law 3 of the Laws of the Game.',
                'options'    => [
                    ['text' => '9',  'correct' => false],
                    ['text' => '10', 'correct' => false],
                    ['text' => '11', 'correct' => true],
                    ['text' => '12', 'correct' => false],
                ],
            ],
            [
                'question'   => 'Which country has won the most FIFA World Cup titles?',
                'difficulty' => 'easy',
                'category'   => 'history',
                'explanation'=> 'Brazil has won the FIFA World Cup 5 times (1958, 1962, 1970, 1994, 2002).',
                'options'    => [
                    ['text' => 'Germany',   'correct' => false],
                    ['text' => 'Brazil',    'correct' => true],
                    ['text' => 'Argentina', 'correct' => false],
                    ['text' => 'Italy',     'correct' => false],
                ],
            ],
            [
                'question'   => 'What is the maximum number of substitutions allowed in a standard FIFA match?',
                'difficulty' => 'medium',
                'category'   => 'rules',
                'explanation'=> 'FIFA updated the rules to allow 5 substitutions per team in a match (introduced during COVID-19 and made permanent).',
                'options'    => [
                    ['text' => '3', 'correct' => false],
                    ['text' => '4', 'correct' => false],
                    ['text' => '5', 'correct' => true],
                    ['text' => '6', 'correct' => false],
                ],
            ],
            [
                'question'   => 'Which player has won the most Ballon d\'Or awards?',
                'difficulty' => 'medium',
                'category'   => 'players',
                'explanation'=> 'Lionel Messi has won the Ballon d\'Or a record 8 times as of 2023.',
                'options'    => [
                    ['text' => 'Cristiano Ronaldo', 'correct' => false],
                    ['text' => 'Ronaldinho',        'correct' => false],
                    ['text' => 'Lionel Messi',      'correct' => true],
                    ['text' => 'Zinedine Zidane',   'correct' => false],
                ],
            ],
            [
                'question'   => 'In football, what does "VAR" stand for?',
                'difficulty' => 'easy',
                'category'   => 'rules',
                'explanation'=> 'VAR stands for Video Assistant Referee — a technology used to review match-changing decisions.',
                'options'    => [
                    ['text' => 'Video Assisted Referee',  'correct' => false],
                    ['text' => 'Video Assistant Referee', 'correct' => true],
                    ['text' => 'Virtual Assistant Review','correct' => false],
                    ['text' => 'Video Analysis Review',   'correct' => false],
                ],
            ],
            [
                'question'   => 'Which Nigerian player is known as "The Eagle of Napoli"?',
                'difficulty' => 'medium',
                'category'   => 'nigeria',
                'explanation'=> 'Victor Osimhen became a legend at Napoli, helping them win the Serie A title in 2022/23.',
                'options'    => [
                    ['text' => 'Kelechi Iheanacho', 'correct' => false],
                    ['text' => 'Ahmed Musa',        'correct' => false],
                    ['text' => 'Victor Osimhen',    'correct' => true],
                    ['text' => 'Odion Ighalo',      'correct' => false],
                ],
            ],
            [
                'question'   => 'What is the diameter of a standard football goal post?',
                'difficulty' => 'hard',
                'category'   => 'rules',
                'explanation'=> 'According to FIFA Laws, goalposts and crossbars must not exceed 12cm (5 inches) in diameter.',
                'options'    => [
                    ['text' => '8cm',  'correct' => false],
                    ['text' => '10cm', 'correct' => false],
                    ['text' => '12cm', 'correct' => true],
                    ['text' => '15cm', 'correct' => false],
                ],
            ],
            [
                'question'   => 'Which club has won the most UEFA Champions League titles?',
                'difficulty' => 'medium',
                'category'   => 'clubs',
                'explanation'=> 'Real Madrid has won the UEFA Champions League/European Cup a record 15 times.',
                'options'    => [
                    ['text' => 'Barcelona',   'correct' => false],
                    ['text' => 'AC Milan',    'correct' => false],
                    ['text' => 'Real Madrid', 'correct' => true],
                    ['text' => 'Bayern Munich','correct' => false],
                ],
            ],
            [
                'question'   => 'What is the offside rule in football?',
                'difficulty' => 'medium',
                'category'   => 'rules',
                'explanation'=> 'A player is offside if they are in the opponents\' half and closer to the goal line than both the ball and the second-to-last opponent when the ball is played to them.',
                'options'    => [
                    ['text' => 'Being ahead of the ball when it is passed',                                    'correct' => false],
                    ['text' => 'Being closer to the goal than the last defender when the ball is played',      'correct' => true],
                    ['text' => 'Standing in the penalty area before a corner kick',                            'correct' => false],
                    ['text' => 'Being in the opponents\' half at any time',                                    'correct' => false],
                ],
            ],
            [
                'question'   => 'Which formation is described as "4-3-3"?',
                'difficulty' => 'medium',
                'category'   => 'tactics',
                'explanation'=> 'A 4-3-3 formation uses 4 defenders, 3 midfielders, and 3 forwards. It is an attacking formation used by clubs like Barcelona and Liverpool.',
                'options'    => [
                    ['text' => '4 defenders, 4 midfielders, 2 forwards',  'correct' => false],
                    ['text' => '4 defenders, 3 midfielders, 3 forwards',  'correct' => true],
                    ['text' => '3 defenders, 3 midfielders, 4 forwards',  'correct' => false],
                    ['text' => '4 defenders, 2 midfielders, 4 forwards',  'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $qIdx => $qData) {
            $question = QuizQuestion::create([
                'quiz_week_id' => $week1->id,
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

        // ── 30 Additional Questions (pool for randomisation) ───────────────────
        $extraQuestions = [
            // History
            ['question'=>'In which year was the FIFA World Cup first held?','difficulty'=>'medium','category'=>'history','explanation'=>'The first FIFA World Cup was held in Uruguay in 1930, with Uruguay winning the tournament.',
             'options'=>[['text'=>'1926','correct'=>false],['text'=>'1930','correct'=>true],['text'=>'1934','correct'=>false],['text'=>'1938','correct'=>false]]],
            ['question'=>'Which country hosted the 2010 FIFA World Cup?','difficulty'=>'easy','category'=>'history','explanation'=>'South Africa hosted the 2010 FIFA World Cup — the first time the tournament was held on African soil.',
             'options'=>[['text'=>'Nigeria','correct'=>false],['text'=>'Egypt','correct'=>false],['text'=>'South Africa','correct'=>true],['text'=>'Morocco','correct'=>false]]],
            ['question'=>'Who scored the "Hand of God" goal in the 1986 World Cup?','difficulty'=>'medium','category'=>'history','explanation'=>'Diego Maradona scored the infamous "Hand of God" goal against England in the 1986 World Cup quarter-final.',
             'options'=>[['text'=>'Pelé','correct'=>false],['text'=>'Diego Maradona','correct'=>true],['text'=>'Ronaldo','correct'=>false],['text'=>'Zidane','correct'=>false]]],
            ['question'=>'Which club has won the most English Premier League titles?','difficulty'=>'medium','category'=>'clubs','explanation'=>'Manchester United has won the most Premier League titles with 13 championships.',
             'options'=>[['text'=>'Arsenal','correct'=>false],['text'=>'Chelsea','correct'=>false],['text'=>'Manchester City','correct'=>false],['text'=>'Manchester United','correct'=>true]]],
            ['question'=>'Who is the all-time top scorer in FIFA World Cup history?','difficulty'=>'hard','category'=>'history','explanation'=>'Miroslav Klose of Germany holds the record with 16 World Cup goals across four tournaments.',
             'options'=>[['text'=>'Ronaldo (Brazil)','correct'=>false],['text'=>'Miroslav Klose','correct'=>true],['text'=>'Gerd Müller','correct'=>false],['text'=>'Just Fontaine','correct'=>false]]],

            // Rules
            ['question'=>'How long is a standard football match?','difficulty'=>'easy','category'=>'rules','explanation'=>'A standard football match consists of two 45-minute halves, totalling 90 minutes of normal time.',
             'options'=>[['text'=>'80 minutes','correct'=>false],['text'=>'90 minutes','correct'=>true],['text'=>'100 minutes','correct'=>false],['text'=>'120 minutes','correct'=>false]]],
            ['question'=>'What happens when a goalkeeper handles the ball outside the penalty area?','difficulty'=>'medium','category'=>'rules','explanation'=>'If a goalkeeper handles the ball outside their penalty area, a direct free kick is awarded to the opposing team.',
             'options'=>[['text'=>'Penalty kick','correct'=>false],['text'=>'Indirect free kick','correct'=>false],['text'=>'Direct free kick','correct'=>true],['text'=>'Yellow card only','correct'=>false]]],
            ['question'=>'How many yellow cards equal a red card in a single match?','difficulty'=>'easy','category'=>'rules','explanation'=>'Two yellow cards in the same match result in a red card and the player is sent off.',
             'options'=>[['text'=>'1','correct'=>false],['text'=>'2','correct'=>true],['text'=>'3','correct'=>false],['text'=>'4','correct'=>false]]],
            ['question'=>'What is the distance of a penalty spot from the goal line?','difficulty'=>'medium','category'=>'rules','explanation'=>'The penalty spot is 11 metres (12 yards) from the goal line.',
             'options'=>[['text'=>'9 metres','correct'=>false],['text'=>'10 metres','correct'=>false],['text'=>'11 metres','correct'=>true],['text'=>'12 metres','correct'=>false]]],
            ['question'=>'Can a goalkeeper score directly from a goal kick?','difficulty'=>'hard','category'=>'rules','explanation'=>'Yes — since the 2019 law change, a goal can be scored directly from a goal kick.',
             'options'=>[['text'=>'No, it must touch another player first','correct'=>false],['text'=>'Yes, a goal can be scored directly','correct'=>true],['text'=>'Only in extra time','correct'=>false],['text'=>'Only if the ball crosses the halfway line','correct'=>false]]],

            // Players
            ['question'=>'Which player is known as "The Egyptian King"?','difficulty'=>'easy','category'=>'players','explanation'=>'Mohamed Salah of Liverpool and Egypt is widely known as "The Egyptian King" or "The Pharaoh".',
             'options'=>[['text'=>'Sadio Mané','correct'=>false],['text'=>'Riyad Mahrez','correct'=>false],['text'=>'Mohamed Salah','correct'=>true],['text'=>'Pierre-Emerick Aubameyang','correct'=>false]]],
            ['question'=>'Which player won the Golden Boot at the 2018 FIFA World Cup?','difficulty'=>'medium','category'=>'players','explanation'=>'Harry Kane of England won the Golden Boot at the 2018 World Cup with 6 goals.',
             'options'=>[['text'=>'Kylian Mbappé','correct'=>false],['text'=>'Romelu Lukaku','correct'=>false],['text'=>'Harry Kane','correct'=>true],['text'=>'Antoine Griezmann','correct'=>false]]],
            ['question'=>'Who is the most capped male international footballer of all time?','difficulty'=>'hard','category'=>'players','explanation'=>'Cristiano Ronaldo holds the record for most international caps for a male player, surpassing 200 appearances for Portugal.',
             'options'=>[['text'=>'Lionel Messi','correct'=>false],['text'=>'Sergio Ramos','correct'=>false],['text'=>'Cristiano Ronaldo','correct'=>true],['text'=>'Ahmed Hassan','correct'=>false]]],
            ['question'=>'Which Nigerian player won the African Player of the Year award in 1994?','difficulty'=>'hard','category'=>'nigeria','explanation'=>'Emmanuel Amuneke won the African Player of the Year award in 1994 after a stellar year with Zamalek and the Super Eagles.',
             'options'=>[['text'=>'Jay-Jay Okocha','correct'=>false],['text'=>'Rashidi Yekini','correct'=>false],['text'=>'Emmanuel Amuneke','correct'=>true],['text'=>'Nwankwo Kanu','correct'=>false]]],
            ['question'=>'Which player is nicknamed "The Special One\'s favourite" and known for his dribbling at Chelsea?','difficulty'=>'medium','category'=>'players','explanation'=>'Arjen Robben was known for his devastating left-foot cut-ins, but Eden Hazard was Chelsea\'s most celebrated dribbler under multiple managers.',
             'options'=>[['text'=>'Frank Lampard','correct'=>false],['text'=>'Eden Hazard','correct'=>true],['text'=>'Didier Drogba','correct'=>false],['text'=>'John Terry','correct'=>false]]],

            // Tactics
            ['question'=>'What does "pressing" mean in football tactics?','difficulty'=>'medium','category'=>'tactics','explanation'=>'Pressing means applying immediate pressure to the ball-carrier after losing possession, aiming to win the ball back quickly in the opponent\'s half.',
             'options'=>[['text'=>'Defending deep in your own half','correct'=>false],['text'=>'Applying pressure to win the ball back quickly','correct'=>true],['text'=>'Playing long balls forward','correct'=>false],['text'=>'Marking opponents man-to-man','correct'=>false]]],
            ['question'=>'What is a "false 9" in football?','difficulty'=>'hard','category'=>'tactics','explanation'=>'A false 9 is a centre-forward who drops deep into midfield to create space and overload the midfield, rather than staying high as a traditional striker.',
             'options'=>[['text'=>'A goalkeeper who plays as a sweeper','correct'=>false],['text'=>'A striker who drops deep to create space','correct'=>true],['text'=>'A midfielder who plays as a winger','correct'=>false],['text'=>'A defender who pushes forward to attack','correct'=>false]]],
            ['question'=>'Which manager is most associated with the "tiki-taka" style of play?','difficulty'=>'medium','category'=>'tactics','explanation'=>'Pep Guardiola perfected tiki-taka at Barcelona (2008–2012), a style based on short passing, movement, and maintaining possession.',
             'options'=>[['text'=>'José Mourinho','correct'=>false],['text'=>'Jürgen Klopp','correct'=>false],['text'=>'Pep Guardiola','correct'=>true],['text'=>'Carlo Ancelotti','correct'=>false]]],
            ['question'=>'What is the role of a "sweeper" (libero) in football?','difficulty'=>'medium','category'=>'tactics','explanation'=>'A sweeper plays behind the defensive line, mopping up any balls that get past the other defenders. The role was popularised in Italian football.',
             'options'=>[['text'=>'A forward who tracks back to defend','correct'=>false],['text'=>'A defender who plays behind the defensive line to cover','correct'=>true],['text'=>'A midfielder who wins the ball in the centre','correct'=>false],['text'=>'A goalkeeper who plays as an outfield player','correct'=>false]]],
            ['question'=>'What does "high defensive line" mean in football?','difficulty'=>'hard','category'=>'tactics','explanation'=>'A high defensive line means the defenders push up the pitch, compressing space and keeping the team compact, but leaving space behind for opponents to exploit.',
             'options'=>[['text'=>'Defenders staying near their own goal','correct'=>false],['text'=>'Defenders pushing up the pitch to compress space','correct'=>true],['text'=>'Wingers defending from a high position','correct'=>false],['text'=>'The goalkeeper coming off their line frequently','correct'=>false]]],

            // Nigeria Football
            ['question'=>'In which year did Nigeria first qualify for the FIFA World Cup?','difficulty'=>'medium','category'=>'nigeria','explanation'=>'Nigeria first qualified for the FIFA World Cup in 1994, held in the United States, where they reached the Round of 16.',
             'options'=>[['text'=>'1990','correct'=>false],['text'=>'1994','correct'=>true],['text'=>'1998','correct'=>false],['text'=>'2002','correct'=>false]]],
            ['question'=>'What is the nickname of the Nigerian national football team?','difficulty'=>'easy','category'=>'nigeria','explanation'=>'The Nigerian national football team is nicknamed the "Super Eagles".',
             'options'=>[['text'=>'The Lions','correct'=>false],['text'=>'The Warriors','correct'=>false],['text'=>'The Super Eagles','correct'=>true],['text'=>'The Stallions','correct'=>false]]],
            ['question'=>'Which Nigerian player is known as "Jay-Jay" and was famous for his skill and dribbling?','difficulty'=>'easy','category'=>'nigeria','explanation'=>'Austin Jay-Jay Okocha is one of Nigeria\'s greatest ever players, famous for his extraordinary dribbling, tricks, and goals.',
             'options'=>[['text'=>'Nwankwo Kanu','correct'=>false],['text'=>'Rashidi Yekini','correct'=>false],['text'=>'Austin Okocha','correct'=>true],['text'=>'Taribo West','correct'=>false]]],
            ['question'=>'Nigeria won the Olympic gold medal in football in which year?','difficulty'=>'medium','category'=>'nigeria','explanation'=>'Nigeria\'s Dream Team won the Olympic gold medal at the 1996 Atlanta Olympics, defeating Argentina 3-2 in the final.',
             'options'=>[['text'=>'1992','correct'=>false],['text'=>'1996','correct'=>true],['text'=>'2000','correct'=>false],['text'=>'2004','correct'=>false]]],
            ['question'=>'Which Nigerian striker scored the most goals at a single Africa Cup of Nations tournament?','difficulty'=>'hard','category'=>'nigeria','explanation'=>'Rashidi Yekini scored 4 goals at the 1994 AFCON and was Nigeria\'s all-time top scorer. He also scored Nigeria\'s first-ever World Cup goal in 1994.',
             'options'=>[['text'=>'Victor Osimhen','correct'=>false],['text'=>'Odion Ighalo','correct'=>false],['text'=>'Rashidi Yekini','correct'=>true],['text'=>'Emmanuel Amuneke','correct'=>false]]],

            // General / Clubs
            ['question'=>'Which club is known as "The Gunners"?','difficulty'=>'easy','category'=>'clubs','explanation'=>'Arsenal Football Club is known as "The Gunners", a nickname derived from the club\'s origins near the Royal Arsenal in Woolwich.',
             'options'=>[['text'=>'Chelsea','correct'=>false],['text'=>'Arsenal','correct'=>true],['text'=>'Tottenham','correct'=>false],['text'=>'West Ham','correct'=>false]]],
            ['question'=>'What colour are Barcelona\'s home shirts?','difficulty'=>'easy','category'=>'clubs','explanation'=>'FC Barcelona\'s iconic home kit is blue and red (blaugrana), which has been their colours since the club\'s founding in 1899.',
             'options'=>[['text'=>'Red and white','correct'=>false],['text'=>'Blue and white','correct'=>false],['text'=>'Blue and red','correct'=>true],['text'=>'Yellow and red','correct'=>false]]],
            ['question'=>'Which African country has won the most Africa Cup of Nations titles?','difficulty'=>'medium','category'=>'history','explanation'=>'Egypt has won the Africa Cup of Nations a record 7 times.',
             'options'=>[['text'=>'Nigeria','correct'=>false],['text'=>'Cameroon','correct'=>false],['text'=>'Ghana','correct'=>false],['text'=>'Egypt','correct'=>true]]],
            ['question'=>'What is the name of Real Madrid\'s home stadium?','difficulty'=>'easy','category'=>'clubs','explanation'=>'Real Madrid play their home matches at the Santiago Bernabéu Stadium in Madrid, Spain.',
             'options'=>[['text'=>'Camp Nou','correct'=>false],['text'=>'Wanda Metropolitano','correct'=>false],['text'=>'Santiago Bernabéu','correct'=>true],['text'=>'Estadio de la Cerámica','correct'=>false]]],
            ['question'=>'Which player scored the winning penalty in the 2022 World Cup final?','difficulty'=>'medium','category'=>'history','explanation'=>'Gonzalo Montiel scored the winning penalty for Argentina in the 2022 World Cup final shootout against France.',
             'options'=>[['text'=>'Lionel Messi','correct'=>false],['text'=>'Ángel Di María','correct'=>false],['text'=>'Lautaro Martínez','correct'=>false],['text'=>'Gonzalo Montiel','correct'=>true]]],
        ];

        $startOrder = count($questions) + 1;
        foreach ($extraQuestions as $qIdx => $qData) {
            $question = QuizQuestion::create([
                'quiz_week_id' => $week1->id,
                'order'        => $startOrder + $qIdx,
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
