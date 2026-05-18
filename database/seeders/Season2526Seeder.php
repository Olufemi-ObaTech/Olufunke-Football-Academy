<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MatchResult;
use App\Models\Post;
use App\Models\Standing;

class Season2526Seeder extends Seeder
{
    public function run(): void
    {
        // ── Clear previous data ────────────────────────────────────────────────
        MatchResult::truncate();
        Standing::truncate();
        Post::where('type', 'latest')->delete();
        Post::where('type', 'report')->delete();
        Post::where('type', 'media')->delete();

        // ── 2026/2027 LATEST NEWS ──────────────────────────────────────────────
        Post::create([
            'title'      => '🏆 OFA Enter the 2026/2027 LSFA State League — Atlantic Conference!',
            'content'    => 'Olufunke Football Academy are proud to announce their participation in the 2026/2027 Lagos State Football Association (LSFA) State League — Atlantic Conference. Building on their historic achievements, OFA step up with renewed ambition, a strengthened squad, and the same winning mentality that has defined the academy. The 2026/2027 season is already underway with OFA competing in the Atlantic Conference. The squad is fully prepared to represent Ajeromi-Ifelodun LGA with pride.',
            'image_path' => 'images/cele3.jpg',
            'type'       => 'latest',
        ]);

        Post::create([
            'title'      => 'OFA 2026/2027 Squad Registration — Open Now!',
            'content'    => 'Olufunke Football Academy is now registering players for the 2026/2027 LSFA State League season. We are looking for talented, committed young footballers across all positions to join our competitive squad. This is your chance to play in the LSFA State League and be part of a winning academy culture. 📞 Call: 09079917993 | ✉️ Email: Olufunkefootballacademy@gmail.com. Don\'t miss this opportunity — trials are ongoing!',
            'image_path' => 'images/OFA-Registration.jpg',
            'type'       => 'latest',
        ]);

        Post::create([
            'title'      => 'OFA Defend Their Legacy — 2026/2027 Season Preview',
            'content'    => 'After winning the Lagos State Divisional Football Association Under-17 Tournament unbeaten and reaching the Lagos State League Final, Olufunke FA enter the 2026/2027 LSFA State League — Atlantic Conference as one of the most exciting grassroots clubs in Lagos. Under the leadership of Founder Adeshina Akintayo Peter and Technical Adviser Udeme John Friday, the team is focused, fit, and ready to make history again.',
            'image_path' => 'images/chairman-ajeromi.jpg',
            'type'       => 'latest',
        ]);

        // ── 2026/2027 MATCH REPORTS ────────────────────────────────────────────
        Post::create([
            'title'      => 'Match Report: Power for the Cross SC 1 – 0 OFA — LSFA Atlantic Conference WK1',
            'content'    => 'Olufunke FA suffered a narrow 1-0 defeat to Power for the Cross SC in their opening fixture of the 2026/2027 LSFA State League — Atlantic Conference. Despite a spirited performance, OFA were unable to find the net and conceded a single goal that proved decisive. The squad showed character and resilience throughout, and the management are confident of a strong response in the weeks ahead. This is just the beginning — OFA will bounce back.',
            'image_path' => 'images/cele2.jpg',
            'type'       => 'report',
        ]);

        Post::create([
            'title'      => 'Match Report: OFA 6 – 0 Gemstones FC — LSFA Atlantic Conference WK2',
            'content'    => 'Olufunke FA bounced back in emphatic fashion with a stunning 6-0 demolition of Gemstones FC on Tuesday 28th April 2026 at 3pm. It was a commanding display of attacking football from OFA, who showed exactly why they are one of the most exciting teams in the Atlantic Conference. The goals flowed freely as OFA dominated from start to finish. A statement result that sends a clear message to the rest of the conference.',
            'image_path' => 'images/cele1.jpg',
            'type'       => 'report',
        ]);

        Post::create([
            'title'      => 'WK3 Update: Buckner FC vs OFA — Match Postponed',
            'content'    => 'The Week 3 fixture between Buckner FC and Olufunke FA, scheduled for Friday 8th May 2026 at 3pm, has been officially postponed. The LSFA Atlantic Conference organisers will confirm a rescheduled date in due course. OFA remain focused and in preparation for their Week 4 home fixture against Team 360 on Monday 12th May 2026.',
            'image_path' => 'images/celeCoach.jpg',
            'type'       => 'report',
        ]);

        Post::create([
            'title'      => 'WK4 Preview: OFA vs Team 360 — Home Fixture at Nathaniel Idowu Field',
            'content'    => 'Olufunke FA return to home soil for their Week 4 fixture against Team 360 in the 2026/2027 LSFA State League — Atlantic Conference. The match takes place on Monday 12th May 2026 at 3:30pm at Nathaniel Idowu Football Field, Oregie, Ajegunle. After the big WK2 win over Gemstones FC, OFA will be looking to build momentum and secure three crucial points at home. Come out and support the boys!',
            'image_path' => 'images/cele3.jpg',
            'type'       => 'report',
        ]);

        // ── 2026/2027 MEDIA ────────────────────────────────────────────────────
        Post::create([
            'title'      => '2026/2027 Season Launch — OFA Enter the LSFA Atlantic Conference',
            'content'    => 'Watch our 2026/2027 season launch highlights and behind-the-scenes footage as Olufunke FA prepare for their biggest season yet in the LSFA State League — Atlantic Conference.',
            'image_path' => 'images/cele3.jpg',
            'type'       => 'media',
            'meta_link'  => 'https://www.youtube.com/@olufunkefootballacademy',
        ]);

        Post::create([
            'title'      => 'OFA 6 – 0 Gemstones FC — WK2 Highlights',
            'content'    => 'Watch the goals and highlights from OFA\'s stunning 6-0 victory over Gemstones FC in Week 2 of the 2026/2027 LSFA State League — Atlantic Conference. Six goals, zero conceded — a statement performance from Olufunke FA.',
            'image_path' => 'images/cele1.jpg',
            'type'       => 'media',
            'meta_link'  => 'https://www.youtube.com/@olufunkefootballacademy',
        ]);

        // ── 2026/2027 MATCH RESULTS (confirmed results only) ──────────────────
        // WK1: Power for the Cross SC 1 – 0 OFA (Away Loss)
        MatchResult::create([
            'match_date'   => '2026-04-21',
            'opponent'     => 'Power for the Cross SC',
            'competition'  => 'LSFA State League 2026/27 — Atlantic Conference WK1',
            'result_badge' => 'PDC 1 - 0 OFA',
            'status_color' => 'danger',
        ]);

        // WK2: OFA 6 – 0 Gemstones FC (Home Win)
        MatchResult::create([
            'match_date'   => '2026-04-28',
            'opponent'     => 'Gemstones FC',
            'competition'  => 'LSFA State League 2026/27 — Atlantic Conference WK2',
            'result_badge' => 'OFA 6 - 0 GFC',
            'status_color' => 'success',
        ]);

        // WK3: Buckner FC vs OFA — Postponed
        MatchResult::create([
            'match_date'   => '2026-05-08',
            'opponent'     => 'Buckner FC',
            'competition'  => 'LSFA State League 2026/27 — Atlantic Conference WK3',
            'result_badge' => 'POSTPONED',
            'status_color' => 'secondary',
        ]);

        // WK4: OFA vs Team 360 — Fixture (result TBD)
        MatchResult::create([
            'match_date'   => '2026-05-12',
            'opponent'     => 'Team 360',
            'competition'  => 'LSFA State League 2026/27 — Atlantic Conference WK4',
            'result_badge' => 'OFA vs T360',
            'status_color' => 'warning',
        ]);

        // WK5: Young Strikers FC vs OFA — Upcoming Fixture
        MatchResult::create([
            'match_date'   => '2026-05-20',
            'opponent'     => 'Young Strikers FC',
            'competition'  => 'LSFA State League 2026/27 — Atlantic Conference WK5',
            'result_badge' => 'YSF vs OFA',
            'status_color' => 'info',
        ]);

        // ── 2026/2027 LEAGUE STANDINGS — Atlantic Conference ───────────────────
        // Based on confirmed results through WK2 (WK3 postponed, WK4/WK5 pending)
        // OFA: P2 W1 D0 L1 — 3 pts (WK1 loss, WK2 win)
        // Other teams estimated from available fixture data
        Standing::create(['rank' => 1, 'club_name' => 'Hephzibah SC',          'played' => 3, 'points' => 7,  'is_featured_club' => false]);
        Standing::create(['rank' => 2, 'club_name' => 'Team 360',              'played' => 3, 'points' => 6,  'is_featured_club' => false]);
        Standing::create(['rank' => 3, 'club_name' => 'Power for the Cross SC','played' => 3, 'points' => 6,  'is_featured_club' => false]);
        Standing::create(['rank' => 4, 'club_name' => 'OLUFUNKE FA',           'played' => 2, 'points' => 3,  'is_featured_club' => true]);
        Standing::create(['rank' => 5, 'club_name' => 'Emajus FC',             'played' => 3, 'points' => 3,  'is_featured_club' => false]);
        Standing::create(['rank' => 6, 'club_name' => 'Young Strikers FC',     'played' => 3, 'points' => 3,  'is_featured_club' => false]);
        Standing::create(['rank' => 7, 'club_name' => 'Ecas FC',               'played' => 2, 'points' => 1,  'is_featured_club' => false]);
        Standing::create(['rank' => 8, 'club_name' => 'Chekas Feeders',        'played' => 3, 'points' => 1,  'is_featured_club' => false]);
        Standing::create(['rank' => 9, 'club_name' => 'Gemstones FC',          'played' => 3, 'points' => 1,  'is_featured_club' => false]);
        Standing::create(['rank' => 10,'club_name' => 'Buckner FC',            'played' => 2, 'points' => 0,  'is_featured_club' => false]);
    }
}
