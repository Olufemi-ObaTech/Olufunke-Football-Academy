<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Assigns the most appropriate image to each post.
 * Safe to run on every boot — it's idempotent (UPDATE by title fragment).
 */
class PostImageUpdateSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            // ── Latest News ────────────────────────────────────────────────────
            'OFA Enter the 2026/2027 LSFA State League'   => 'images/OFA2.jpg',
            'OFA 2026/2027 Squad Registration'             => 'images/news-registration.jpg',
            'OFA Defend Their Legacy'                      => 'images/news-champions.jpg',
            // Legacy news (AcademySeeder)
            'Olufunke FA Crowned Champions'                => 'images/news-champions.jpg',
            'Olufunke Football Academy U19'                => 'images/news-registration.jpg',
            'Olufunke FA Presents Championship Trophy'     => 'images/news-chairman.jpg',

            // ── Match Reports ──────────────────────────────────────────────────
            'Power for the Cross SC 1 – 0 OFA'            => 'images/OFA 1.jpg',
            'OFA 6 – 0 Gemstones FC — LSFA Atlantic Conference WK2' => 'images/cele1.jpg',
            'WK3 Update: Buckner FC vs OFA'                => 'images/studium.jpg',
            'WK4 Preview: OFA vs Team 360'                 => 'images/training ground.jpg',
            // Legacy match reports
            'OFA 2 – 2 Ikorodu City'                      => 'images/cele1.jpg',
            'OFA 2 – 0 Ayicrip Nelis FA'                  => 'images/cele2.jpg',

            // ── Media Highlights ──────────────────────────────────────────────
            '2026/2027 Season Launch'                      => 'images/OFA.jpg',
            'OFA 6 – 0 Gemstones FC — WK2 Highlights'     => 'images/cele2.jpg',
            // Legacy media
            'Highlights: OFA vs. Ikorodu City'             => 'images/celeCoach.jpg',
            'Champions Celebration'                        => 'images/cele3.jpg',
        ];

        foreach ($map as $fragment => $imagePath) {
            Post::where('title', 'like', '%' . $fragment . '%')
                ->update(['image_path' => $imagePath]);
        }
    }
}
