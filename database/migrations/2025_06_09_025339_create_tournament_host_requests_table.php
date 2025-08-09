<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentHostRequestsTable extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_host_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('responsible_name');
            $table->string('email');
            $table->string('phone');

            $table->string('tournament_title');
            $table->string('venue_name');
            $table->text('venue_address');
            $table->integer('estimated_capacity');
            $table->date('proposed_date');
            $table->text('available_facilities');
            $table->text('notes')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_host_requests');
    }
}
