<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('standings', function (Blueprint $table) {
            $table->integer('won')->default(0)->after('played');
            $table->integer('drawn')->default(0)->after('won');
            $table->integer('lost')->default(0)->after('drawn');
            $table->integer('goals_for')->default(0)->after('lost');
            $table->integer('goals_against')->default(0)->after('goals_for');
        });
    }

    public function down(): void
    {
        Schema::table('standings', function (Blueprint $table) {
            $table->dropColumn(['won', 'drawn', 'lost', 'goals_for', 'goals_against']);
        });
    }
};
