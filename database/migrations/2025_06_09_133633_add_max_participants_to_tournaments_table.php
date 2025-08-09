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
        Schema::table('tournaments', function (Blueprint $table) {
            $table->integer('max_participants')->after('prize_total')->nullable();
            // Anda bisa mengubah 'after' sesuai dengan posisi yang Anda inginkan
            // Misalnya, jika Anda ingin di akhir: $table->integer('max_participants')->nullable();
            // Atau jika setelah 'location': $table->integer('max_participants')->after('location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('max_participants');
        });
    }
};
