<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->foreignId('team1_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->foreignId('team2_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->string('stage')->nullable();
            $table->dateTime('match_datetime');
            $table->string('status')->default('scheduled');
            $table->integer('team1_score')->nullable();
            $table->integer('team2_score')->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->foreignId('loser_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->string('format')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};