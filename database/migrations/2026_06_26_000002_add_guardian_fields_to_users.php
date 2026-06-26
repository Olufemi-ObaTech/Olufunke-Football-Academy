<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'child_name')) {
                $table->string('child_name', 100)->nullable()->after('nationality');
            }
            if (!Schema::hasColumn('users', 'relationship_to_player')) {
                $table->string('relationship_to_player', 50)->nullable()->after('child_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['child_name', 'relationship_to_player']);
        });
    }
};
