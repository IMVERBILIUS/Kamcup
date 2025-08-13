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
        Schema::table('donations', function (Blueprint $table) {
            // Tambah kolom user_id setelah kolom id
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            
            // Tambah foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            // Tambah index untuk performa query
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Hapus foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Hapus index
            $table->dropIndex(['user_id']);
            
            // Hapus kolom user_id
            $table->dropColumn('user_id');
        });
    }
};