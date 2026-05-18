<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Store products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('image_path');
            $table->string('category')->default('merchandise'); // merchandise | booking
            $table->boolean('available')->default(true);
            $table->timestamps();
        });

        // Booking packages
        Schema::create('booking_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('duration')->nullable(); // e.g. "4 weeks"
            $table->string('group_size')->nullable(); // e.g. "U13 / U15 / U17"
            $table->boolean('available')->default(true);
            $table->timestamps();
        });

        // Management team
        Schema::create('management_team', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('email')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // E-learning courses
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_path');
            $table->string('category'); // technical | psychology | education
            $table->string('cta_label')->default('Start Learning');
            $table->timestamps();
        });

        // Contact messages
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('management_team');
        Schema::dropIfExists('booking_packages');
        Schema::dropIfExists('products');
    }
};
