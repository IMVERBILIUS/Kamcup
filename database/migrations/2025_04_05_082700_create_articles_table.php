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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis artikel
            $table->string('title');
            $table->text('description')->nullable(); // Deskripsi umum artikel
            $table->string('thumbnail')->nullable(); // Gambar utama artikel
            $table->enum('status', ['Draft', 'Published'])->default('Draft'); // Status artikel
            $table->unsignedBigInteger('views')->default(0); // Jumlah view
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
