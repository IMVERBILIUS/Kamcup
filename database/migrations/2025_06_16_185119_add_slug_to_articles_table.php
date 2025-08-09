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
        Schema::table('articles', function (Blueprint $table) {
            // Tambahkan kolom 'slug' setelah kolom 'title'
            // 'string' untuk tipe data teks
            // 'unique' untuk memastikan setiap slug adalah unik (penting untuk URL)
            // 'nullable' jika Anda ingin memperbolehkan slug kosong pada awalnya (tidak disarankan untuk slug URL)
            $table->string('slug')->unique()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Hapus kolom 'slug' jika migrasi di-rollback
            $table->dropColumn('slug');
        });
    }
};
