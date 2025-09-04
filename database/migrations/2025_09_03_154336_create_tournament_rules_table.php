<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentRulesTable extends Migration
{
    public function up()
    {
        Schema::create('tournament_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->text('rule_text');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournament_rules');
    }
}
