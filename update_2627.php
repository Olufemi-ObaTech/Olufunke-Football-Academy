<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MatchResult;
use App\Models\Standing;
use App\Models\Post;

MatchResult::truncate();
Standing::truncate();
Post::where('type', 'latest')->delete();
Post::where('type', 'report')->delete();
Post::where('type', 'media')->delete();

echo "Cleared old data.\n";

// ── CONFIRMED MATCH RESULTS ────────────────────────────────────────────────────
// WK1 — Apr 21, 2026 — Power of De Cross SA 1-0 OFA (confirmed by pmexpressng.com)
MatchResult::create([
    'match_date'   => '2026-04-21',
    'opponent'     => 'Power of De Cross SA',
    'competition'  => 'LSFA State League 2026/27 — Atlantic Conf. (WK1)',
    'result_badge' => 'OFA 0 - 1 PDCSA',
    'status_color' => 'danger',
]);

// WK2 — Apr 28, 2026 — OFA 6-0 Gemstones FC (confirmed by Facebook/fixtures)
MatchResult::create([
    'match_date'   => '2026-04-28',
    'opponent'     => 'Gemstones FC',
    'competition'  => 'LSFA State League 2026/27 — Atlantic Conf. (WK2)',
    'result_badge' => 'OFA 6 - 0 GFC',
    'status_color' => 'success',
]);

// WK3 — May 8, 2026 — Buckner FC vs OFA — POSTPONED (confirmed by Facebook)
MatchResult::create([
    'match_date'   => '2026-05-08',
    'opponent'     => 'Buckner FC',
    'competition'  => 'LSFA State League 2026/27 — Atlantic Conf. (WK3) — POSTPONED',
    'result_badge' => 'Postponed',
    'status_color' => 'secondary',
]);

// WK4 — May 12, 2026 — OFA vs Team 360 (upcoming — confirmed fixture)
MatchResult::create([
    'match_date'   => '2026-05-12',
    'opponent'     => 'Team 360',
    'competition'  => 'LSFA State League 2026/27 — Atlantic Conf. (WK4)',
    'result_badge' => 'Upcoming',
    'status_color' => 'primary',
]);

// WK5 — May 20, 2026 — Young Strikers FC vs OFA (upcoming — confirmed fixture)
MatchResult::create([
    'match_date'   => '2026-05-20',
    'opponent'     => 'Young Strikers FC',
    'competition'  => 'LSFA State League 2026/27 — Atlantic Conf. (WK5)',
    'result_badge' => 'Upcoming',
    'status_color' => 'primary',
]);

echo "Match results: " . MatchResult::count() . "\n";

// ── STANDINGS — Atlantic Conference after WK1 (confirmed results) ──────────────
// WK1 results confirmed:
// Ecas FA beat Young Strikers 2-0 → Ecas: 3pts, Young Strikers: 0pts
// Hephzibah SC beat Gemstone 2-0 → Hephzibah: 3pts, Gemstone: 0pts
// Emajus FC beat Bucknor 2-1 → Emajus: 3pts, Bucknor: 0pts
// Power of De Cross SA beat OFA 1-0 → PDCSA: 3pts, OFA: 0pts
// Team 360 drew Chekas Feeders 2-2 → Team 360: 1pt, Chekas: 1pt
// After WK2: OFA beat Gemstones 6-0 → OFA: 3pts total
Standing::create(['rank' => 1, 'club_name' => 'Power of De Cross SA', 'played' => 2, 'points' => 6,  'is_featured_club' => false]);
Standing::create(['rank' => 2, 'club_name' => 'Ecas FA',              'played' => 2, 'points' => 6,  'is_featured_club' => false]);
Standing::create(['rank' => 3, 'club_name' => 'Hephzibah SC',         'played' => 2, 'points' => 3,  'is_featured_club' => false]);
Standing::create(['rank' => 4, 'club_name' => 'Emajus FC',            'played' => 2, 'points' => 3,  'is_featured_club' => false]);
Standing::create(['rank' => 5, 'club_name' => 'OLUFUNKE FA',          'played' => 2, 'points' => 3,  'is_featured_club' => true]);
Standing::create(['rank' => 6, 'club_name' => 'Team 360',             'played' => 2, 'points' => 1,  'is_featured_club' => false]);
Standing::create(['rank' => 7, 'club_name' => 'Chekas Feeders',       'played' => 2, 'points' => 1,  'is_featured_club' => false]);
Standing::create(['rank' => 8, 'club_name' => 'Young Strikers FC',    'played' => 2, 'points' => 0,  'is_featured_club' => false]);
Standing::create(['rank' => 9, 'club_name' => 'Gemstones FC',         'played' => 2, 'points' => 0,  'is_featured_club' => false]);
Standing::create(['rank' =>10, 'club_name' => 'Buckner FC',           'played' => 1, 'points' => 0,  'is_featured_club' => false]);

echo "Standings: " . Standing::count() . "\n";

// ── NEWS POSTS ─────────────────────────────────────────────────────────────────
Post::create([
    'title'      => '⚽ OFA Bounce Back with Stunning 6-0 Win Over Gemstones FC — LSFA State League WK2',
    'content'    => 'Olufunke Football Academy delivered a dominant 6-0 demolition of Gemstones FC in Week 2 of the 2026/2027 LSFA State League (Atlantic Conference) on Tuesday, 28th April 2026. After a narrow 1-0 defeat to Power of De Cross SA in the opening week, the team responded in emphatic fashion. The result demonstrates the attacking quality and resilience within the OFA squad as they push for a strong finish in the Atlantic Conference.',
    'image_path' => 'images/cele3.jpg',
    'type'       => 'latest',
]);

Post::create([
    'title'      => '📅 WK4 Fixture: OFA vs Team 360 — Monday 12th May 2026, 3:30 PM',
    'content'    => 'Olufunke Football Academy host Team 360 in Week 4 of the 2026/2027 LSFA State League (Atlantic Conference). The match takes place at Nathaniel Idowu Football Field, Oregie, Ajegunle, Lagos on Monday 12th May 2026 at 3:30 PM. Come out and support the boys! 📞 09079917993 | Olufunkefootballacademy@gmail.com',
    'image_path' => 'images/OFA-Registration.jpg',
    'type'       => 'latest',
]);

Post::create([
    'title'      => '📅 WK5 Fixture: Young Strikers FC vs OFA — Wednesday 20th May 2026, 8:00 AM',
    'content'    => 'Olufunke FA travel to face Young Strikers FC in Week 5 of the 2026/2027 LSFA State League (Atlantic Conference). The match is at Maracana Football Pitch, Ajegunle, Lagos on Wednesday 20th May 2026 at 8:00 AM. The team is focused and ready to secure three crucial points. Come support OFA!',
    'image_path' => 'images/cele1.jpg',
    'type'       => 'latest',
]);

// Match Reports
Post::create([
    'title'      => 'Match Report: OFA 0-1 Power of De Cross SA — LSFA State League WK1',
    'content'    => 'Olufunke FA suffered a narrow 1-0 defeat to Power of De Cross SA in their opening match of the 2026/2027 LSFA State League (Atlantic Conference) on 21st April 2026. Despite a spirited performance, a single goal proved the difference on the day. The team showed character and came back stronger in Week 2 with a dominant 6-0 victory.',
    'image_path' => 'images/cele2.jpg',
    'type'       => 'report',
]);

Post::create([
    'title'      => 'Match Report: OFA 6-0 Gemstones FC — LSFA State League WK2',
    'content'    => 'What a response from Olufunke Football Academy! After the Week 1 defeat, OFA came roaring back with a dominant 6-0 victory over Gemstones FC on Tuesday 28th April 2026. The team showed incredible attacking intent, clinical finishing, and solid defensive organisation throughout the 90 minutes. A statement result in the Atlantic Conference of the 2026/2027 LSFA State League.',
    'image_path' => 'images/cele3.jpg',
    'type'       => 'report',
]);

Post::create([
    'title'      => 'WK3 Postponed: Buckner FC vs OFA — Friday 8th May 2026',
    'content'    => 'The Week 3 fixture between Buckner FC and Olufunke FA, scheduled for Friday 8th May 2026 in the Mainland Conference, has been postponed. OFA remain focused on their upcoming Week 4 clash against Team 360 on Monday 12th May 2026 at Nathaniel Idowu Football Field, Oregie, Ajegunle.',
    'image_path' => 'images/OFA New Logo.jpg',
    'type'       => 'report',
]);

// Media
Post::create([
    'title'      => '🎥 OFA 6-0 Gemstones FC — LSFA State League WK2 Highlights',
    'content'    => 'Watch the full highlights of Olufunke FA\'s stunning 6-0 victory over Gemstones FC in Week 2 of the 2026/2027 LSFA State League on our YouTube channel.',
    'image_path' => 'images/celeCoach.jpg',
    'type'       => 'media',
    'meta_link'  => 'https://www.youtube.com/@olufunkefootballacademy',
]);

Post::create([
    'title'      => '🎥 2026/2027 LSFA State League — OFA Atlantic Conference Campaign',
    'content'    => 'Follow Olufunke FA\'s journey in the 2026/2027 LSFA State League Atlantic Conference. Watch training sessions, match highlights, and behind-the-scenes content on our YouTube channel.',
    'image_path' => 'images/training ground.jpg',
    'type'       => 'media',
    'meta_link'  => 'https://www.youtube.com/@olufunkefootballacademy',
]);

echo "Posts: " . Post::count() . "\n";
echo "\nDone! All confirmed data updated.\n";
