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
            // Kolom untuk tanggal dan waktu mulai event
            // datetime('event_start') akan menyimpan tanggal dan waktu,
            // nullable() agar bisa kosong jika belum diisi.
            // after('status') akan menempatkan kolom setelah kolom 'status' yang sudah ada.
            $table->dateTime('event_start')->nullable()->after('status');

            // Kolom untuk tanggal dan waktu berakhir event
            $table->dateTime('event_end')->nullable()->after('event_start');

            // Kolom untuk status visibilitas (Draft/Published)
            // enum(['Draft', 'Published']) akan membatasi nilai yang bisa disimpan.
            // default('Draft') akan mengatur nilai default-nya.
            // after('event_end') akan menempatkannya setelah kolom 'event_end'.
            $table->enum('visibility_status', ['Draft', 'Published'])->default('Draft')->after('event_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            // Untuk rollback: hapus kolom-kolom ini
            $table->dropColumn(['event_start', 'event_end', 'visibility_status']);
        });
    }
};
