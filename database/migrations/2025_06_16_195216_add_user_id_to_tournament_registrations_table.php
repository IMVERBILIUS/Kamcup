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
        Schema::table('tournament_registrations', function (Blueprint $table) {
            // Tambahkan kolom user_id, unsigned big integer karena akan menjadi foreign key
            // nullable() jika pendaftaran bisa tanpa user login (tidak disarankan untuk kasus ini)
            // after('team_id') untuk posisi kolom yang logis
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->after('team_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_registrations', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['user_id']);
            // Kemudian hapus kolom
            $table->dropColumn('user_id');
        });
    }
};
