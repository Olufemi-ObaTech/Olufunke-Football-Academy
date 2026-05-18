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

        $imagePath = 'images/Ofa new logo1.jpg';
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
            'kick_off_time'=> 'nullable|date_format:H:i',
            'notes'        => 'nullable|string|max:300',
        ]);
        MatchResult::create($data);
        return back()->with('success', "Match result added.");
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
            'kick_off_time'=> 'nullable|date_format:H:i',
            'notes'        => 'nullable|string|max:300',
        ]);
        $result->update($data);
        return back()->with('success', "Match result updated.");
    }

    public function matchDestroy(MatchResult $result)
    {
        $result->delete();
        return back()->with('success', "Match result deleted.");
    }

    // ── League Standings ───────────────────────────────────────────────────────

    public function standingStore(Request $request)
    {
        $data = $request->validate([
            'rank'             => 'required|integer|min:1',
            'club_name'        => 'required|string|max:100',
            'played'           => 'required|integer|min:0',
            'points'           => 'required|integer|min:0',
            'is_featured_club' => 'nullable|boolean',
        ]);
        $data['is_featured_club'] = $request->boolean('is_featured_club');
        Standing::create($data);
        return back()->with('success', "Standing entry added.");
    }

    public function standingUpdate(Request $request, Standing $standing)
    {
        $data = $request->validate([
            'rank'             => 'required|integer|min:1',
            'club_name'        => 'required|string|max:100',
            'played'           => 'required|integer|min:0',
            'points'           => 'required|integer|min:0',
            'is_featured_club' => 'nullable|boolean',
        ]);
        $data['is_featured_club'] = $request->boolean('is_featured_club');
        $standing->update($data);
        return back()->with('success', "Standing updated.");
    }

    public function standingDestroy(Standing $standing)
    {
        $standing->delete();
        return back()->with('success', "Standing entry deleted.");
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
            'kick_off_time'=> 'required|date_format:H:i',
            'venue'        => 'required|string|max:200',
            'is_active'    => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        // Deactivate others if this one is active
        if ($data['is_active']) {
            NextFixture::where('is_active', true)->update(['is_active' => false]);
        }
        NextFixture::create($data);
        return back()->with('success', "Next fixture added.");
    }

    public function fixtureUpdate(Request $request, NextFixture $fixture)
    {
        $data = $request->validate([
            'week_label'   => 'required|string|max:20',
            'home_team'    => 'required|string|max:100',
            'away_team'    => 'required|string|max:100',
            'competition'  => 'required|string|max:150',
            'fixture_date' => 'required|date',
            'kick_off_time'=> 'required|date_format:H:i',
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
        return back()->with('success', "Fixture updated.");
    }

    public function fixtureDestroy(NextFixture $fixture)
    {
        $fixture->delete();
        return back()->with('success', "Fixture deleted.");
    }
}
