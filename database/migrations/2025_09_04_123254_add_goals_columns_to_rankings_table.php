<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->integer('goals_for')->default(0)->after('points');
            $table->integer('goals_against')->default(0)->after('goals_for');
            
            // Add unique constraint jika belum ada
            try {
                $table->unique(['tournament_id', 'team_id']);
            } catch (Exception $e) {
                // Unique constraint sudah ada, skip
            }
        });
    }

    public function down(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->dropColumn(['goals_for', 'goals_against']);
            $table->dropUnique(['tournament_id', 'team_id']);
        });
    }
};