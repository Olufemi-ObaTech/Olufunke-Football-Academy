<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('session_date');
            $table->time('session_time');
            $table->string('location')->default('Nathaniel Idowu Football Field, Oregie, Ajegunle');
            $table->enum('type', ['technical', 'tactical', 'fitness', 'match', 'recovery', 'other'])->default('technical');
            $table->enum('age_group', ['U13','U15','U17','U19','Senior','All'])->default('All');
            $table->integer('duration_minutes')->default(90);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot: which players are assigned to a schedule
        Schema::create('training_schedule_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('attendance', ['pending','present','absent'])->default('pending');
            $table->unique(['training_schedule_id','user_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_schedule_player');
        Schema::dropIfExists('training_schedules');
    }
};
