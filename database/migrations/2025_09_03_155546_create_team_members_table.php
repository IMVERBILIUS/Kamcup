<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMembersTable extends Migration
{
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');  // foreign key ke tabel teams
            $table->string('photo');
            $table->string('name');
            $table->date('birthdate');
            $table->enum('gender', ['male', 'female']);
            $table->string('position');
            $table->integer('jersey_number');
            $table->string('contact');
            $table->string('email');
            $table->timestamps();  // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_members');
    }
}
