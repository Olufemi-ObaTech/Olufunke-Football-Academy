<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Guard each column — on fresh installs these are already in create_ofa_academy_tables.
        Schema::table('standings', function (Blueprint $table) {
            if (!Schema::hasColumn('standings', 'won')) {
                $table->integer('won')->default(0)->after('played');
            }
            if (!Schema::hasColumn('standings', 'drawn')) {
                $table->integer('drawn')->default(0)->after('won');
            }
            if (!Schema::hasColumn('standings', 'lost')) {
                $table->integer('lost')->default(0)->after('drawn');
            }
            if (!Schema::hasColumn('standings', 'goals_for')) {
                $table->integer('goals_for')->default(0)->after('lost');
            }
            if (!Schema::hasColumn('standings', 'goals_against')) {
                $table->integer('goals_against')->default(0)->after('goals_for');
            }
        });
    }

    public function down(): void
    {
        Schema::table('standings', function (Blueprint $table) {
            $table->dropColumn(['won', 'drawn', 'lost', 'goals_for', 'goals_against']);
        });
    }
};
