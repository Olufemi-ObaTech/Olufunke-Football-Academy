<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rated_by')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('technical')->default(5);   // 1-10
            $table->unsignedTinyInteger('tactical')->default(5);
            $table->unsignedTinyInteger('physical')->default(5);
            $table->unsignedTinyInteger('mental')->default(5);
            $table->unsignedTinyInteger('teamwork')->default(5);
            $table->unsignedTinyInteger('attitude')->default(5);
            $table->text('comments')->nullable();
            $table->date('rated_for_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_ratings');
    }
};
