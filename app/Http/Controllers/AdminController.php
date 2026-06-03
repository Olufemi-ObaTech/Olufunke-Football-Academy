<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ManagementTeam;
use App\Models\MatchResult;
use App\Models\NextFixture;
use App\Models\Player;
use App\Models\PlayerMessage;
use App\Models\PlayerRating;
use App\Models\Post;
use App\Models\Standing;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ── Training Schedules ─────────────────────────────────────────────────────

    public function scheduleIndex()
    {
        $schedules = TrainingSchedule::with('players')
            ->orderByDesc('session_date')
            ->get();
        $players = User::where('role', 'player')->where('status', 'approved')->orderBy('name')->get();
        return view('dashboard.admin.schedules', compact('schedules', 'players'));
    }

    public function scheduleStore(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:150',
            'description'      => 'nullable|string|max:500',
            'session_date'     => 'required|date',
            'session_time'     => 'required',
            'location'         => 'required|string|max:200',
            'type'             => 'required|in:technical,tactical,fitness,match,recovery,other',
            'age_group'        => 'required|in:U13,U15,U17,U19,Senior,All',
            'duration_minutes' => 'required|integer|min:15|max:300',
            'notes'            => 'nullable|string|max:1000',
            'player_ids'       => 'nullable|array',
            'player_ids.*'     => 'exists:users,id',
        ]);

        $schedule = TrainingSchedule::create(array_merge(
            $data,
            ['created_by' => auth()->id()]
        ));

        // Assign players
        if (!empty($data['player_ids'])) {
            $schedule->players()->sync($data['player_ids']);
        } else {
            // Assign all approved players if none specified
            $allPlayers = User::where('role', 'player')->where('status', 'approved')->pluck('id');
            $schedule->players()->sync($allPlayers);
        }

        return back()->with('success', "Training session \"{$schedule->title}\" scheduled for {$schedule->session_date->format('d M Y')}.");
    }

    public function scheduleDestroy(TrainingSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Training session deleted.');
    }

    // ── Messages ───────────────────────────────────────────────────────────────

    public function messageIndex()
    {
        $admin = auth()->user();

        // All messages sent TO admin (from players)
        $fromPlayers = PlayerMessage::where('to_user_id', $admin->id)
            ->with('sender')
            ->latest()
            ->get();

        // Count unread BEFORE marking as read
        $unreadFromPlayers = $fromPlayers->where('is_read', false)->count();

        // All messages sent BY admin (to players)
        $toPlayers = PlayerMessage::where('from_user_id', $admin->id)
            ->with('recipient')
            ->latest()
            ->get();

        // Now mark all as read
        PlayerMessage::where('to_user_id', $admin->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('dashboard.admin.messages', compact('fromPlayers', 'toPlayers', 'unreadFromPlayers'));
    }

    public function messageStore(Request $request)
    {
        $data = $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'subject'    => 'nullable|string|max:150',
            'body'       => 'required|string|max:2000',
        ]);

        PlayerMessage::create([
            'from_user_id' => auth()->id(),
            'to_user_id'   => $data['to_user_id'],
            'subject'      => $data['subject'] ?? 'Message from Coach',
            'body'         => $data['body'],
        ]);

        $player = User::find($data['to_user_id']);
        return back()->with('success', "Message sent to {$player->name}.");
    }

    public function messageBroadcast(Request $request)
    {
        $data = $request->validate([
            'subject'    => 'nullable|string|max:150',
            'body'       => 'required|string|max:2000',
            'age_group'  => 'nullable|string',
        ]);

        $query = User::where('role', 'player')->where('status', 'approved');
        if (!empty($data['age_group']) && $data['age_group'] !== 'All') {
            $query->where('age_group', $data['age_group']);
        }
        $players = $query->get();

        foreach ($players as $player) {
            PlayerMessage::create([
                'from_user_id' => auth()->id(),
                'to_user_id'   => $player->id,
                'subject'      => $data['subject'] ?? 'Announcement from OFA',
                'body'         => $data['body'],
            ]);
        }

        return back()->with('success', "Broadcast sent to {$players->count()} player(s).");
    }

    // ── Player Ratings ─────────────────────────────────────────────────────────

    public function ratingStore(Request $request)
    {
        $data = $request->validate([
            'player_id'     => 'required|exists:users,id',
            'technical'     => 'required|integer|min:1|max:10',
            'tactical'      => 'required|integer|min:1|max:10',
            'physical'      => 'required|integer|min:1|max:10',
            'mental'        => 'required|integer|min:1|max:10',
            'teamwork'      => 'required|integer|min:1|max:10',
            'attitude'      => 'required|integer|min:1|max:10',
            'comments'      => 'nullable|string|max:1000',
            'rated_for_date'=> 'required|date',
        ]);

        PlayerRating::create(array_merge($data, ['rated_by' => auth()->id()]));

        $player = User::find($data['player_id']);
        return back()->with('success', "Performance rating saved for {$player->name}.");
    }

    // ── Player Profile (AJAX/modal data) ──────────────────────────────────────

    public function playerProfile(User $player)
    {
        $courses  = Course::withCount('lessons')->get();
        $progress = $player->progress()->with('course')->get()->keyBy('course_id');
        $ratings  = $player->ratings()->with('rater')->take(5)->get();
        $messages = PlayerMessage::where('to_user_id', $player->id)
            ->orWhere('from_user_id', $player->id)
            ->with('sender', 'recipient')
            ->latest()
            ->take(10)
            ->get();
        $schedules = $player->trainingSchedules()
            ->orderByDesc('session_date')
            ->take(5)
            ->get();

        return response()->json([
            'player'    => $player,
            'progress'  => $progress->values(),
            'courses'   => $courses,
            'ratings'   => $ratings,
            'messages'  => $messages,
            'schedules' => $schedules,
        ]);
    }

    // ── Player Spotlight (public-facing players table) ─────────────────────────

    public function spotlightIndex()
    {
        $players = Player::latest()->get();
        return view('dashboard.admin.spotlight', compact('players'));
    }

    public function spotlightStore(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'position'   => 'required|string|max:60',
            'age'        => 'required|integer|min:5|max:50',
            'goals'      => 'required|integer|min:0',
            'assists'    => 'required|integer|min:0',
            'matches'    => 'required|integer|min:0',
            'quote'      => 'required|string|max:300',
            'image'      => 'nullable|image|max:2048',
        ]);

        $imagePath = 'images/OFA New Logo.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('players', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        Player::create([
            'name'       => $data['name'],
            'position'   => $data['position'],
            'age'        => $data['age'],
            'goals'      => $data['goals'],
            'assists'    => $data['assists'],
            'matches'    => $data['matches'],
            'quote'      => $data['quote'],
            'image_path' => $imagePath,
        ]);

        return back()->with('success', "Player \"{$data['name']}\" added to the spotlight.");
    }

    public function spotlightEdit(Player $player)
    {
        return view('dashboard.admin.spotlight-edit', compact('player'));
    }

    public function spotlightUpdate(Request $request, Player $player)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'position'   => 'required|string|max:60',
            'age'        => 'required|integer|min:5|max:50',
            'goals'      => 'required|integer|min:0',
            'assists'    => 'required|integer|min:0',
            'matches'    => 'required|integer|min:0',
            'quote'      => 'required|string|max:300',
            'image'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Remove old image if it was uploaded (not the default)
            if (str_starts_with($player->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $player->image_path));
            }
            $imagePath = $request->file('image')->store('players', 'public');
            $data['image_path'] = 'storage/' . $imagePath;
        }

        unset($data['image']);
        $player->update($data);

        return redirect()->route('admin.spotlight.index')
            ->with('success', "Player \"{$player->name}\" updated successfully.");
    }

    public function spotlightDestroy(Player $player)
    {
        if (str_starts_with($player->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $player->image_path));
        }
        $name = $player->name;
        $player->delete();
        return back()->with('success', "Player \"{$name}\" removed from the spotlight.");
    }

    // ── News / Posts ───────────────────────────────────────────────────────────

    public function newsIndex()
    {
        $posts = Post::latest()->get();
        return view('dashboard.admin.news', compact('posts'));
    }

    public function newsStore(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:200',
            'content'   => 'required|string',
            'type'      => 'required|in:latest,report,media',
            'meta_link' => 'nullable|url|max:500',
            'image'     => 'nullable|image|max:3072',
        ]);

        $imagePath = 'images/OFA New Logo.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        Post::create([
            'title'      => $data['title'],
            'content'    => $data['content'],
            'type'       => $data['type'],
            'meta_link'  => $data['meta_link'] ?? null,
            'image_path' => $imagePath,
        ]);

        return back()->with('success', "Post \"{$data['title']}\" published.");
    }

    public function newsEdit(Post $post)
    {
        return view('dashboard.admin.news-edit', compact('post'));
    }

    public function newsUpdate(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:200',
            'content'   => 'required|string',
            'type'      => 'required|in:latest,report,media',
            'meta_link' => 'nullable|url|max:500',
            'image'     => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('image')) {
            if (str_starts_with($post->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $post->image_path));
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $data['image_path'] = 'storage/' . $imagePath;
        }

        unset($data['image']);
        $post->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', "Post \"{$post->title}\" updated.");
    }

    public function newsDestroy(Post $post)
    {
        if (str_starts_with($post->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $post->image_path));
        }
        $title = $post->title;
        $post->delete();
        return back()->with('success', "Post \"{$title}\" deleted.");
    }

    // ── About Page — Management Team ───────────────────────────────────────────

    public function aboutIndex()
    {
        $team = ManagementTeam::orderBy('sort_order')->get();
        return view('dashboard.admin.about', compact('team'));
    }

    public function aboutStore(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'required|string|max:100',
            'email'      => 'nullable|email|max:150',
            'sort_order' => 'nullable|integer|min:0',
            'image'      => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        ManagementTeam::create([
            'name'       => $data['name'],
            'role'       => $data['role'],
            'email'      => $data['email'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'image_path' => $imagePath,
        ]);

        return back()->with('success', "Team member \"{$data['name']}\" added.");
    }

    public function aboutEdit(ManagementTeam $member)
    {
        return view('dashboard.admin.about-edit', compact('member'));
    }

    public function aboutUpdate(Request $request, ManagementTeam $member)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'required|string|max:100',
            'email'      => 'nullable|email|max:150',
            'sort_order' => 'nullable|integer|min:0',
            'image'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($member->image_path && str_starts_with($member->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $member->image_path));
            }
            $imagePath = $request->file('image')->store('team', 'public');
            $data['image_path'] = 'storage/' . $imagePath;
        }

        unset($data['image']);
        $member->update($data);

        return redirect()->route('admin.about.index')
            ->with('success', "Team member \"{$member->name}\" updated.");
    }

    public function aboutDestroy(ManagementTeam $member)
    {
        if ($member->image_path && str_starts_with($member->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $member->image_path));
        }
        $name = $member->name;
        $member->delete();
        return back()->with('success', "Team member \"{$name}\" removed.");
    }

    // ── Match Results ──────────────────────────────────────────────────────────

    public function matchIndex()
    {
        $results  = MatchResult::orderBy('match_date', 'desc')->get();
        $standings = Standing::orderBy('rank')->get();
        $fixtures  = NextFixture::latest()->get();
        return view('dashboard.admin.league', compact('results', 'standings', 'fixtures'));
    }

    public function resultEdit(MatchResult $result)
    {
        return view('dashboard.admin.result-edit', compact('result'));
    }

    public function standingEdit(Standing $standing)
    {
        return view('dashboard.admin.standing-edit', compact('standing'));
    }

    public function fixtureEdit(NextFixture $fixture)
    {
        return view('dashboard.admin.fixture-edit', compact('fixture'));
    }

    public function matchStore(Request $request)
    {
        $data = $request->validate([
            'match_date'   => 'required|date',
            'opponent'     => 'required|string|max:100',
            'competition'  => 'required|string|max:150',
            'result_badge' => 'required|string|max:60',
            'status_color' => 'required|in:success,danger,warning,secondary,primary,info',
            'week_label'   => 'nullable|string|max:20',
            'venue'        => 'nullable|string|max:200',
            'kick_off_time'=> 'nullable|string|max:8',
            'notes'        => 'nullable|string|max:300',
        ]);
        $data['kick_off_time'] = $data['kick_off_time'] ?: null;
        $data['week_label']    = $data['week_label']    ?: null;
        $data['venue']         = $data['venue']         ?: null;
        $data['notes']         = $data['notes']         ?: null;
        MatchResult::create($data);
        $this->rebuildLeagueStandings();
        return back()->with('success', "Match result added and league table updated.");
    }

    public function matchUpdate(Request $request, MatchResult $result)
    {
        $data = $request->validate([
            'match_date'   => 'required|date',
            'opponent'     => 'required|string|max:100',
            'competition'  => 'required|string|max:150',
            'result_badge' => 'required|string|max:60',
            'status_color' => 'required|in:success,danger,warning,secondary,primary,info',
            'week_label'   => 'nullable|string|max:20',
            'venue'        => 'nullable|string|max:200',
            'kick_off_time'=> 'nullable|string|max:8',
            'notes'        => 'nullable|string|max:300',
        ]);
        $data['kick_off_time'] = $data['kick_off_time'] ?: null;
        $data['week_label']    = $data['week_label']    ?: null;
        $data['venue']         = $data['venue']         ?: null;
        $data['notes']         = $data['notes']         ?: null;
        $result->update($data);
        $this->rebuildLeagueStandings();
        return redirect()->route('admin.league.index', ['tab' => 'results'])
            ->with('success', "Match result updated and league table refreshed.");
    }

    public function matchDestroy(MatchResult $result)
    {
        $result->delete();
        $this->rebuildLeagueStandings();
        return redirect()->route('admin.league.index', ['tab' => 'results'])
            ->with('success', "Match result deleted and league table refreshed.");
    }

    private function rebuildLeagueStandings(): void
    {
        $leagueResults = MatchResult::where('competition', 'like', '%LSFA State League 2026/27%')->get();

        $existingStandings = Standing::all()->keyBy(function ($standing) {
            return mb_strtolower(trim(preg_replace('/\s+/', ' ', $standing->club_name)));
        });

        $stats = [];

        foreach ($leagueResults as $result) {
            $parsed = $this->parseScoreBadge($result->result_badge);
            if (!$parsed) {
                continue;
            }

            [$homeClub, $homeGoals, $awayGoals, $awayClub] = $parsed;
            $homeKey = mb_strtolower($this->normalizeClubName($homeClub));
            $awayKey = mb_strtolower($this->normalizeClubName($awayClub));

            if (!isset($stats[$homeKey])) {
                $stats[$homeKey] = [
                    'club_name'        => $this->normalizeClubName($homeClub),
                    'played'          => 0,
                    'won'             => 0,
                    'drawn'           => 0,
                    'lost'            => 0,
                    'goals_for'       => 0,
                    'goals_against'   => 0,
                    'points'          => 0,
                    'is_featured_club'=> $existingStandings[$homeKey]->is_featured_club ?? false,
                ];
            }

            if (!isset($stats[$awayKey])) {
                $stats[$awayKey] = [
                    'club_name'        => $this->normalizeClubName($awayClub),
                    'played'          => 0,
                    'won'             => 0,
                    'drawn'           => 0,
                    'lost'            => 0,
                    'goals_for'       => 0,
                    'goals_against'   => 0,
                    'points'          => 0,
                    'is_featured_club'=> $existingStandings[$awayKey]->is_featured_club ?? false,
                ];
            }

            $stats[$homeKey]['played']++;
            $stats[$awayKey]['played']++;
            $stats[$homeKey]['goals_for'] += $homeGoals;
            $stats[$homeKey]['goals_against'] += $awayGoals;
            $stats[$awayKey]['goals_for'] += $awayGoals;
            $stats[$awayKey]['goals_against'] += $homeGoals;

            if ($homeGoals > $awayGoals) {
                $stats[$homeKey]['won']++;
                $stats[$homeKey]['points'] += 3;
                $stats[$awayKey]['lost']++;
            } elseif ($homeGoals < $awayGoals) {
                $stats[$awayKey]['won']++;
                $stats[$awayKey]['points'] += 3;
                $stats[$homeKey]['lost']++;
            } else {
                $stats[$homeKey]['drawn']++;
                $stats[$awayKey]['drawn']++;
                $stats[$homeKey]['points'] += 1;
                $stats[$awayKey]['points'] += 1;
            }
        }

        // Preserve manual entries for clubs with no parsed league results.
        foreach ($existingStandings as $key => $standing) {
            if (!isset($stats[$key])) {
                $stats[$key] = [
                    'club_name'        => $standing->club_name,
                    'played'          => $standing->played,
                    'won'             => $standing->won,
                    'drawn'           => $standing->drawn,
                    'lost'            => $standing->lost,
                    'goals_for'       => $standing->goals_for,
                    'goals_against'   => $standing->goals_against,
                    'points'          => $standing->points,
                    'is_featured_club'=> $standing->is_featured_club,
                ];
            }
        }

        $sorted = collect($stats)->sort(function ($a, $b) {
            if ($a['points'] !== $b['points']) {
                return $b['points'] <=> $a['points'];
            }
            $goalDiffA = $a['goals_for'] - $a['goals_against'];
            $goalDiffB = $b['goals_for'] - $b['goals_against'];
            if ($goalDiffA !== $goalDiffB) {
                return $goalDiffB <=> $goalDiffA;
            }
            if ($a['goals_for'] !== $b['goals_for']) {
                return $b['goals_for'] <=> $a['goals_for'];
            }
            return strcasecmp($a['club_name'], $b['club_name']);
        })->values();

        $rank = 1;
        foreach ($sorted as $row) {
            Standing::updateOrCreate(
                ['club_name' => $row['club_name']],
                array_merge($row, ['rank' => $rank])
            );
            $rank++;
        }
    }

    private function parseScoreBadge(string $badge): ?array
    {
        $badge = trim(preg_replace('/\s+/', ' ', $badge));
        if (preg_match('/^(.+?)\s+(\d+)\s*[-–]\s*(\d+)\s+(.+)$/u', $badge, $matches)) {
            return [
                $this->normalizeClubName($matches[1]),
                (int) $matches[2],
                (int) $matches[3],
                $this->normalizeClubName($matches[4]),
            ];
        }

        return null;
    }

    private function normalizeClubName(string $club): string
    {
        return trim(preg_replace('/\s+/', ' ', $club));
    }

    // ── League Standings ───────────────────────────────────────────────────────

    public function standingStore(Request $request)
    {
        $data = $request->validate([
            'rank'             => 'required|integer|min:1',
            'club_name'        => 'required|string|max:100',
            'played'           => 'required|integer|min:0',
            'won'              => 'required|integer|min:0',
            'drawn'            => 'required|integer|min:0',
            'lost'             => 'required|integer|min:0',
            'goals_for'        => 'required|integer|min:0',
            'goals_against'    => 'required|integer|min:0',
            'points'           => 'required|integer|min:0',
            'is_featured_club' => 'nullable|boolean',
        ]);
        $data['is_featured_club'] = $request->boolean('is_featured_club');
        Standing::create($data);
        return redirect()->route('admin.league.index', ['tab' => 'standings'])
            ->with('success', "Standing entry added.");
    }

    public function standingUpdate(Request $request, Standing $standing)
    {
        $data = $request->validate([
            'rank'             => 'required|integer|min:1',
            'club_name'        => 'required|string|max:100',
            'played'           => 'required|integer|min:0',
            'won'              => 'required|integer|min:0',
            'drawn'            => 'required|integer|min:0',
            'lost'             => 'required|integer|min:0',
            'goals_for'        => 'required|integer|min:0',
            'goals_against'    => 'required|integer|min:0',
            'points'           => 'required|integer|min:0',
            'is_featured_club' => 'nullable|boolean',
        ]);
        $data['is_featured_club'] = $request->boolean('is_featured_club');
        $standing->update($data);
        return redirect()->route('admin.league.index', ['tab' => 'standings'])
            ->with('success', "Standing updated.");
    }

    public function standingDestroy(Standing $standing)
    {
        $standing->delete();
        return redirect()->route('admin.league.index', ['tab' => 'standings'])
            ->with('success', "Standing entry deleted.");
    }

    // ── Next Fixtures ──────────────────────────────────────────────────────────

    public function fixtureStore(Request $request)
    {
        $data = $request->validate([
            'week_label'   => 'required|string|max:20',
            'home_team'    => 'required|string|max:100',
            'away_team'    => 'required|string|max:100',
            'competition'  => 'required|string|max:150',
            'fixture_date' => 'required|date',
            'kick_off_time'=> 'required|string|max:8',
            'venue'        => 'required|string|max:200',
            'is_active'    => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        if ($data['is_active']) {
            NextFixture::where('is_active', true)->update(['is_active' => false]);
        }
        NextFixture::create($data);
        return redirect()->route('admin.league.index', ['tab' => 'fixtures'])
            ->with('success', "Next fixture added.");
    }

    public function fixtureUpdate(Request $request, NextFixture $fixture)
    {
        $data = $request->validate([
            'week_label'   => 'required|string|max:20',
            'home_team'    => 'required|string|max:100',
            'away_team'    => 'required|string|max:100',
            'competition'  => 'required|string|max:150',
            'fixture_date' => 'required|date',
            'kick_off_time'=> 'required|string|max:8',
            'venue'        => 'required|string|max:200',
            'is_active'    => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($data['is_active']) {
            NextFixture::where('id', '!=', $fixture->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }
        $fixture->update($data);
        return redirect()->route('admin.league.index', ['tab' => 'fixtures'])
            ->with('success', "Fixture updated.");
    }

    public function fixtureDestroy(NextFixture $fixture)
    {
        $fixture->delete();
        return redirect()->route('admin.league.index', ['tab' => 'fixtures'])
            ->with('success', "Fixture deleted.");
    }
}
