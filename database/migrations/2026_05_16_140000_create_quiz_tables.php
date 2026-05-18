<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Weekly quiz weeks
        Schema::create('quiz_weeks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('theme')->nullable();          // e.g. "World Cup History"
            $table->date('week_start');
            $table->date('week_end');
            $table->boolean('is_active')->default(true);
            $table->integer('time_limit')->default(300);  // seconds (5 min default)
            $table->timestamps();
        });

        // Questions for each quiz week
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_week_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(1);
            $table->text('question');
            $table->string('difficulty')->default('medium'); // easy | medium | hard
            $table->string('category')->default('general');  // general | history | tactics | rules | players
            $table->string('explanation')->nullable();        // shown after answering
            $table->timestamps();
        });

        // Answer options for each question
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_question_id')->constrained()->onDelete('cascade');
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        // Track quiz attempts (works for guests too via session)
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_week_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('guest_name')->nullable();         // for non-logged-in users
            $table->integer('score')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('time_taken')->nullable();        // seconds
            $table->json('answers')->nullable();              // {question_id: option_id, ...}
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quiz_weeks');
    }
};
