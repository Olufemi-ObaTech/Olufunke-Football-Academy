<?php

namespace App\Http\Controllers;

use App\Models\MatchResult;
use App\Models\NextFixture;
use App\Models\Player;
use App\Models\Post;
use App\Models\Standing;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews      = Post::where('type', 'latest')->latest()->get();
        $matchReports    = Post::where('type', 'report')->latest()->get();
        $mediaHighlights = Post::where('type', 'media')->latest()->get();
        $matchResults    = MatchResult::orderBy('match_date', 'desc')->get();
        $standings       = Standing::orderBy('rank')->get();
        $players         = Player::all();
        $lastResult      = MatchResult::orderBy('match_date', 'desc')->first();
        $nextFixture     = NextFixture::where('is_active', true)->latest()->first();

        return view('pages.home', compact(
            'latestNews', 'matchReports', 'mediaHighlights',
            'matchResults', 'standings', 'players',
            'lastResult', 'nextFixture'
        ));
    }
}
