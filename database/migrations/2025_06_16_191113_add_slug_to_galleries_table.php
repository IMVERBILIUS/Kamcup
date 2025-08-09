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
        Schema::table('galleries', function (Blueprint $table) {
            // Menambahkan kolom 'slug' dengan tipe string, harus unik, dan ditempatkan setelah kolom 'title'
            $table->string('slug')->unique()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Menghapus kolom 'slug' jika migrasi di-rollback
            $table->dropColumn('slug');
        });
    }
};
