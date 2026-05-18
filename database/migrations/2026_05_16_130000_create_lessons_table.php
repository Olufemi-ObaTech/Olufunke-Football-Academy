<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(1);
            $table->string('title');
            $table->text('content');           // Full lesson text
            $table->string('target_audience'); // 'player', 'coach', 'both'
            $table->string('duration')->nullable(); // e.g. "15 mins"
            $table->string('difficulty')->default('beginner'); // beginner | intermediate | advanced
            $table->string('icon')->default('bi-book-fill');
            $table->timestamps();
        });

        // Track lesson-level progress
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'lesson_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
        Schema::dropIfExists('lessons');
    }
};
