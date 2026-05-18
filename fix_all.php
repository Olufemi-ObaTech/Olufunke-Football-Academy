<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MatchResult;
use App\Models\Standing;
use App\Models\Post;

// ── 1. Fix WK4 exact score: OFA 0-2 Team 360 (confirmed from Facebook image) ──
MatchResult::where('opponent', 'Team 360')->update([
    'result_badge' => 'OFA 0 - 2 T360',
    'status_color' => 'danger',
]);

// ── 2. Fix Ecas FA WK4 result: Ecas FA 3-0 Buckner FC (confirmed from Facebook)
// Update Ecas FA standings: now P=3, W=3, Pts=9
Standing::where('club_name', 'Ecas FA')->update(['played' => 3, 'points' => 9]);
// Buckner FC: P=2, Pts=0
Standing::where('club_name', 'Buckner FC')->update(['played' => 2, 'points' => 0]);

// ── 3. Fix Team 360 standings: WK4 win → P=3, Pts=4 (1 draw WK1 + 1 win WK4)
Standing::where('club_name', 'Team 360')->update(['played' => 3, 'points' => 4]);

// ── 4. Recalculate all ranks by points ────────────────────────────────────────
$rankMap = [
    'Ecas FA'              => ['rank' => 1, 'played' => 3, 'points' => 9],
    'Power of De Cross SA' => ['rank' => 2, 'played' => 2, 'points' => 6],
    'Team 360'             => ['rank' => 3, 'played' => 3, 'points' => 4],
    'Hephzibah SC'         => ['rank' => 4, 'played' => 2, 'points' => 3],
    'Emajus FC'            => ['rank' => 5, 'played' => 2, 'points' => 3],
    'OLUFUNKE FA'          => ['rank' => 6, 'played' => 3, 'points' => 3],
    'Chekas Feeders'       => ['rank' => 7, 'played' => 2, 'points' => 1],
    'Young Strikers FC'    => ['rank' => 8, 'played' => 2, 'points' => 0],
    'Gemstones FC'         => ['rank' => 9, 'played' => 2, 'points' => 0],
    'Buckner FC'           => ['rank' => 10,'played' => 2, 'points' => 0],
];

foreach ($rankMap as $club => $data) {
    Standing::where('club_name', $club)->update($data);
}

// ── 5. Update WK4 match report with exact score ───────────────────────────────
Post::where('title', 'LIKE', '%WK4%')->where('type', 'report')->update([
    'title'   => 'Match Report: OFA 0-2 Team 360 FC — LSFA State League WK4',
    'content' => 'Olufunke Football Academy suffered a 0-2 defeat to Team 360 FC in Week 4 of the 2026/2027 LSFA State League (Atlantic Conference) on Tuesday 12th May 2026 at Nathaniel Idowu Football Field, Oregie, Ajegunle. The result ended OFA\'s remarkable 25-match unbeaten home record. Despite the disappointment, the team remains focused and determined heading into Week 5 against Young Strikers FC on 20th May 2026.',
    'image_path' => 'images/cele2.jpg',
]);

// ── 6. Add Ecas FA WK4 result to context (standings update note) ──────────────
echo "=== Updated Results ===\n";
$results = MatchResult::orderBy('match_date')->get();
foreach ($results as $r) {
    echo "{$r->match_date} | {$r->opponent} | {$r->result_badge} | {$r->status_color}\n";
}

echo "\n=== Updated Standings ===\n";
$standings = Standing::orderBy('rank')->get();
foreach ($standings as $s) {
    $star = $s->is_featured_club ? ' ⭐' : '';
    echo "#{$s->rank} {$s->club_name}{$star} — P:{$s->played} Pts:{$s->points}\n";
}

echo "\nDone!\n";
