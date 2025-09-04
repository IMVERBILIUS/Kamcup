<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->dateTime('registration_start')->nullable();
            $table->dateTime('registration_end')->nullable();
            $table->string('location')->nullable();
            $table->decimal('registration_fee', 8, 2)->default(0);
            $table->decimal('prize_total', 8, 2)->nullable();
            $table->string('contact_person')->nullable();
            $table->string('status')->default('draft');
            $table->integer('max_teams')->nullable();
            $table->string('gender_category')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};