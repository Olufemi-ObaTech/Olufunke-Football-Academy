<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Expand role ENUM to include coach and guardian
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('player','admin','coach','guardian') NOT NULL DEFAULT 'player'");

        // Expand age_group ENUM to allow 'N/A' for non-player accounts
        DB::statement("ALTER TABLE users MODIFY COLUMN age_group ENUM('U13','U15','U17','U19','Senior','N/A') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('player','admin') NOT NULL DEFAULT 'player'");
        DB::statement("ALTER TABLE users MODIFY COLUMN age_group ENUM('U13','U15','U17','U19','Senior') NULL");
    }
};
