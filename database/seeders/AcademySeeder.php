<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookingPackage;
use App\Models\Course;
use App\Models\ManagementTeam;
use App\Models\Player;
use App\Models\Post;
use App\Models\Product;

class AcademySeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Latest News (skip if already seeded) ────────────────────────────
        if (Post::where('type', 'latest')->count() === 0) {
            Post::create([
                'title'      => 'Olufunke FA Crowned Champions of Lagos State Divisional Football Association Under‑17 Tournament!',
                'content'    => 'Olufunke Football Academy has been crowned champions of the Lagos State Divisional Football Association Under‑17 Tournament, finishing the competition unbeaten. This remarkable achievement is a testament to the Academy\'s unwavering commitment to excellence, discipline, and youth development. Throughout the tournament, our players demonstrated exceptional skill, teamwork, and resilience — qualities that reflect the core values of Olufunke FA. This victory not only highlights the rising talent within our ranks but also reinforces our position as one of the leading grassroots football academies in Lagos State.',
                'image_path' => 'images/cele3.jpg',
                'type'       => 'latest',
            ]);
            Post::create([
                'title'      => 'Olufunke Football Academy U19 – Registration Now Open!',
                'content'    => 'This season, we\'ll be competing in the prestigious Lagos State U19 League, showcasing the best of our young talent on a competitive stage. We are inviting good, young, and talented players who are passionate about football and ready to grow into future stars. If you have the skill, drive, and commitment, this is your chance to join a winning team. 📞 Contact Us — Phone: 09079917993 | Email: Olufunkefootballacademy@gmail.com',
                'image_path' => 'images/OFA-Registration.jpg',
                'type'       => 'latest',
            ]);
            Post::create([
                'title'      => 'Olufunke FA Presents Championship Trophy to Ajeromi-Ifelodun LGA Chairman',
                'content'    => 'Olufunke Football Academy proudly presented the championship trophy to the Chairman of Ajeromi-Ifelodun Local Government in recognition of their triumphant victory at the Lagos State Divisional Football Association Under‑17 Tournament. This symbolic gesture not only celebrates the team\'s outstanding achievement on the pitch but also underscores OFA\'s commitment to fostering youth talent, discipline, and community pride. The Chairman commended the players and management for their dedication and assured continued support for grassroots sports development.',
                'image_path' => 'images/chairman-ajeromi.jpg',
                'type'       => 'latest',
            ]);
        }

        // ── 2. Match Reports (skip if already seeded) ──────────────────────────
        if (Post::where('type', 'report')->count() === 0) {
            Post::create([
                'title'      => 'Match Report: OFA 2 – 2 Ikorodu City (4-2 Pens) — Lagos State League Final',
                'content'    => 'A thrilling final at Mobolaji Johnson Arena Onikan saw Olufunke FA hold their nerve in a penalty shootout to be crowned Lagos State League champions. After a 2-2 draw in normal time, the boys converted all four penalties to seal a historic victory.',
                'image_path' => 'images/cele1.jpg',
                'type'       => 'report',
            ]);
            Post::create([
                'title'      => 'Match Report: OFA 2 – 0 Ayicrip Nelis FA — Lagos State League Semi-Final (1st Leg)',
                'content'    => 'Olufunke FA delivered a commanding performance in the semi-final first leg, winning 2-0 against Ayicrip Nelis FA. The team showed great tactical discipline and clinical finishing to secure a comfortable advantage heading into the second leg.',
                'image_path' => 'images/cele2.jpg',
                'type'       => 'report',
            ]);
        }

        // ── 3. Media Highlights (skip if already seeded) ───────────────────────
        if (Post::where('type', 'media')->count() === 0) {
            Post::create([
                'title'      => 'Highlights: OFA vs. Ikorodu City — Lagos State League Final',
                'content'    => 'Watch the goals and crucial match-winning moments from the Lagos State League Final on our YouTube channel.',
                'image_path' => 'images/celeCoach.jpg',
                'type'       => 'media',
                'meta_link'  => 'https://www.youtube.com/@olufunkefootballacademy',
            ]);
            Post::create([
                'title'      => 'Champions Celebration — Olufunke FA U17 Trophy Presentation',
                'content'    => 'Relive the incredible trophy presentation ceremony as Olufunke FA celebrated their Under-17 championship title with the Ajeromi-Ifelodun LGA Chairman.',
                'image_path' => 'images/cele3.jpg',
                'type'       => 'media',
                'meta_link'  => 'https://www.youtube.com/@olufunkefootballacademy',
            ]);
        }

        // NOTE: Match Results and Standings are managed by Season2526Seeder only.

        // ── 4. Players ─────────────────────────────────────────────────────────
        $players = [
            ['name' => 'Ejiogu Enoch Chibueze',   'position' => 'Midfielder', 'age' => 16, 'goals' => 5,  'assists' => 7, 'matches' => 12, 'quote' => 'My dream is to make OFA and Nigeria proud one day.',              'image_path' => 'images/Ejiogu Chibueze.jpg'],
            ['name' => 'Emmanuel Ajose',           'position' => 'Forward',    'age' => 18, 'goals' => 8,  'assists' => 8, 'matches' => 15, 'quote' => 'OFA taught me confidence, resilience, and teamwork.',             'image_path' => 'images/Ajose Emmanuel.jpg'],
            ['name' => 'Okpara Chidera Emmanuel',  'position' => 'Forward',    'age' => 17, 'goals' => 15, 'assists' => 4, 'matches' => 13, 'quote' => 'Every session at OFA makes me better, on and off the pitch.',     'image_path' => 'images/Okpara Chidera.jpg'],
        ];
        foreach ($players as $p) {
            Player::firstOrCreate(['name' => $p['name']], $p);
        }

        // ── 5. Store Products ──────────────────────────────────────────────────
        $products = [
            ['name' => 'OFA Merchandise',      'description' => 'Official match ball used in training and merchandise.',                        'price' => 6000,  'image_path' => 'images/OFA  Merchandise.jpg'],
            ['name' => 'OFA Home Jersey',       'description' => 'Premium quality, breathable fabric.',                                         'price' => 12000, 'image_path' => 'images/OFA Jersey.jpg'],
            ['name' => 'Training Kit',          'description' => 'Includes shorts, socks, and training shirt.',                                 'price' => 8500,  'image_path' => 'images/OFA Training Kit.jpg'],
            ['name' => 'OFA Tracksuit',         'description' => 'Premium quality, breathable fabric.',                                         'price' => 15000, 'image_path' => 'images/OFA Tracksuit.jpg'],
            ['name' => 'OFA Polo Shirt',        'description' => 'Casual wear with OFA badge. Includes shorts and socks.',                      'price' => 10500, 'image_path' => 'images/OFA merchandise.jpg'],
            ['name' => 'Red OFA Hoodie',        'description' => 'Fleece hoodie with large OFA print.',                                         'price' => 16000, 'image_path' => 'images/Red Hoodie.jpg'],
            ['name' => 'OFA Sport Wrist Watch', 'description' => 'Premium quality. Digital display with bold time, date, and mode indicators.', 'price' => 21000, 'image_path' => 'images/OFA Sport Wristwatch.jpg'],
            ['name' => 'OFA Water Bottle',      'description' => 'Elite hydration gear. Leak-proof lid with flip-up spout and curved handle.',  'price' => 9500,  'image_path' => 'images/OFA Water Bottle.jpg'],
            ['name' => 'Blue OFA Hoodie',       'description' => 'Fleece hoodie with large OFA print.',                                         'price' => 16000, 'image_path' => 'images/Blue Hoodie.jpg'],
        ];
        foreach ($products as $p) {
            Product::firstOrCreate(['name' => $p['name']], array_merge($p, ['category' => 'merchandise', 'available' => true]));
        }

        // ── 6. Booking Packages ────────────────────────────────────────────────
        $packages = [
            ['name' => 'Trial Session',           'description' => 'A single trial session to assess your skill level and meet our coaching team. Open to all age groups.',                                                    'price' => 2000,  'duration' => '1 Day',       'group_size' => 'U13 / U15 / U17 / U19'],
            ['name' => 'Monthly Training Package', 'description' => 'Full month of structured training sessions — technical drills, tactical sessions, and fitness conditioning.',                                              'price' => 15000, 'duration' => '4 Weeks',     'group_size' => 'U13 / U15 / U17'],
            ['name' => 'Academy Full Season',      'description' => 'Complete season enrollment including league participation, kit, health education, and community programs.',                                                'price' => 50000, 'duration' => 'Full Season', 'group_size' => 'U17 / U19'],
        ];
        foreach ($packages as $p) {
            BookingPackage::firstOrCreate(['name' => $p['name']], array_merge($p, ['available' => true]));
        }

        // ── 7. Management Team ─────────────────────────────────────────────────
        $team = [
            ['name' => 'Adeshina Akintayo Peter',       'role' => 'Founder & President',        'email' => 'Olufunkefootballacademy@gmail.com', 'sort_order' => 1],
            ['name' => 'Oluokun Olamilekan Olasunkanmi', 'role' => 'Vice Chairman',              'email' => 'Olufunkefootballacademy@gmail.com', 'sort_order' => 2],
            ['name' => 'Olufemi Emmanuel Olugbodi',      'role' => 'Sporting Director',          'email' => 'Olufunkefootballacademy@gmail.com', 'sort_order' => 3],
            ['name' => 'Udeme John Friday',              'role' => 'Technical Adviser',          'email' => 'Olufunkefootballacademy@gmail.com', 'sort_order' => 4],
            ['name' => 'Ezeala Onyema Augustina',        'role' => 'Team and Marketing Manager', 'email' => 'Olufunkefootballacademy@gmail.com', 'sort_order' => 5],
        ];
        foreach ($team as $m) {
            ManagementTeam::firstOrCreate(['name' => $m['name']], $m);
        }

        // ── 8. E-Learning Courses ──────────────────────────────────────────────
        $courses = [
            ['title' => 'Football Education',       'description' => 'Learn rules, ethics, leadership, and teamwork through interactive lessons and video analysis. Build the mental and social foundations of a complete footballer.',                                                    'image_path' => 'images/Football Edu.jpg',  'category' => 'education',   'cta_label' => 'Start Learning'],
            ['title' => 'Technical Training',       'description' => 'Master ball control, passing, shooting, and tactical awareness with expert-led sessions. Structured modules for every skill level.',                                                                                  'image_path' => 'images/Technical Training.jpg', 'category' => 'technical',   'cta_label' => 'Explore Modules'],
            ['title' => 'Sports Psychology',        'description' => 'Build mental resilience, focus, and emotional intelligence for peak performance. Learn how elite athletes think and compete under pressure.',                                                                          'image_path' => 'images/Sports Psychology.jpg',  'category' => 'psychology',  'cta_label' => 'View Lessons'],
            ['title' => 'Health Education',         'description' => 'Nutrition, mental health, and injury prevention counseling led by certified professionals. Fuel your body and protect your career.',                                                                                  'image_path' => 'images/OFA 1.jpg',         'category' => 'health',      'cta_label' => 'Start Module'],
            ['title' => 'Environmental Initiatives','description' => 'Sustainability and stewardship of local playing fields, environments, and respect towards other players and teams. Every grassroots player has a role to play.',                                                      'image_path' => 'images/cele3.jpg',         'category' => 'environment', 'cta_label' => 'Learn More'],
            ['title' => 'Community Engagement',     'description' => 'Volunteering, mentorship, and outreach programs that foster inclusivity and a culture of giving back. Football as a force for community change.',                                                                     'image_path' => 'images/chairman-ajeromi.jpg', 'category' => 'community',  'cta_label' => 'Get Involved'],
        ];
        foreach ($courses as $c) {
            Course::firstOrCreate(['title' => $c['title']], $c);
        }
    }
}
