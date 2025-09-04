<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            if (!Schema::hasColumn('rankings', 'goals_for')) {
                $table->integer('goals_for')->default(0)->after('points');
            }
            if (!Schema::hasColumn('rankings', 'goals_against')) {
                $table->integer('goals_against')->default(0)->after('goals_for');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->dropColumn(['goals_for', 'goals_against']);
        });
    }
};