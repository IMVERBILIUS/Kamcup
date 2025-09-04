<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tournament_registrations', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Captain/user yang mendaftar
            
            // Registration details
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('registration_date')->useCurrent();
            $table->text('rejection_reason')->nullable();
            
            // Payment information (opsional)
            $table->enum('payment_status', ['unpaid', 'paid', 'verified'])->default('unpaid');
            $table->string('payment_proof')->nullable(); // File bukti bayar
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('payment_verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null'); // Admin yang verifikasi
            
            // Additional info
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->json('additional_data')->nullable(); // Data tambahan dalam format JSON
            
            $table->timestamps();
            
            // Indexes
            $table->index(['tournament_id', 'status']);
            $table->index(['team_id', 'tournament_id']);
            $table->index(['user_id', 'tournament_id']);
            
            // Constraints
            $table->unique(['tournament_id', 'team_id'], 'unique_team_tournament'); // Satu team hanya bisa daftar sekali per tournament
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_registrations');
    }
};