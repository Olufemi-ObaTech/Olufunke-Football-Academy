<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['player', 'admin'])->default('player')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('position')->nullable()->after('phone');       // e.g. Forward, Midfielder
            $table->integer('age')->nullable()->after('position');
            $table->string('nationality')->nullable()->after('age');
            $table->enum('age_group', ['U13','U15','U17','U19','Senior'])->nullable()->after('nationality');
            $table->string('profile_photo')->nullable()->after('age_group');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('profile_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','phone','position','age','nationality','age_group','profile_photo','status']);
        });
    }
};
