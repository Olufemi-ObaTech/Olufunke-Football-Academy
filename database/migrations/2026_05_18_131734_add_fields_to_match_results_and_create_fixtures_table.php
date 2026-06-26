<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns to match_results only if they don't already exist.
        // On fresh installs these columns are already in create_ofa_academy_tables;
        // on older installs (XAMPP) they may not be — so we guard each one.
        Schema::table('match_results', function (Blueprint $table) {
            if (!Schema::hasColumn('match_results', 'week_label')) {
                $table->string('week_label')->nullable()->after('competition');
            }
            if (!Schema::hasColumn('match_results', 'venue')) {
                $table->string('venue')->nullable()->after('week_label');
            }
            if (!Schema::hasColumn('match_results', 'kick_off_time')) {
                $table->time('kick_off_time')->nullable()->after('venue');
            }
            if (!Schema::hasColumn('match_results', 'notes')) {
                $table->text('notes')->nullable()->after('kick_off_time');
            }
        });

        // Next fixtures table
        Schema::create('next_fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('week_label');           // e.g. "WK5"
            $table->string('home_team');            // e.g. "Young Strikers FC"
            $table->string('away_team');            // e.g. "OFA"
            $table->string('competition');          // e.g. "LSFA State League 2026/27 — Atlantic Conference"
            $table->date('fixture_date');
            $table->time('kick_off_time');
            $table->string('venue');
            $table->boolean('is_active')->default(true); // only one shown at a time
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('next_fixtures');
        Schema::table('match_results', function (Blueprint $table) {
            $table->dropColumn(['week_label', 'venue', 'kick_off_time', 'notes']);
        });
    }
};
