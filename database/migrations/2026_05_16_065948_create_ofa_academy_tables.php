<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. News & Match Reports
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image_path');
            $table->enum('type', ['latest', 'report', 'media']);
            $table->string('meta_link')->nullable(); // For video/youtube links
            $table->timestamps();
        });

        // 2. Match Results Scoreboard
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->date('match_date');
            $table->string('opponent');
            $table->string('competition')->nullable();
            $table->string('result_badge'); // e.g., "OFA 2 - 0 ANFA"
            $table->string('status_color')->default('success'); // Bootstrap color class
            $table->string('week_label')->nullable();
            $table->string('venue')->nullable();
            $table->time('kick_off_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. League Standings Table
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->integer('rank');
            $table->string('club_name');
            $table->integer('played')->default(0);
            $table->integer('won')->default(0);
            $table->integer('drawn')->default(0);
            $table->integer('lost')->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);
            $table->integer('points')->default(0);
            $table->boolean('is_featured_club')->default(false); // Highlight OLUFUNKE FA
            $table->timestamps();
        });

        // 4. Player Spotlights
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->integer('age');
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('matches')->default(0);
            $table->string('quote');
            $table->string('image_path')->default('images/Ofa new logo1.jpg');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
        Schema::dropIfExists('standings');
        Schema::dropIfExists('match_results');
        Schema::dropIfExists('posts');
    }
};