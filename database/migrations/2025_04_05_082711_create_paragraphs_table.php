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
        Schema::create('paragraphs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subheading_id')->constrained()->onDelete('cascade'); // Relasi ke subheading
            $table->text('content'); // Isi paragraf
            $table->integer('order_number')->default(1); // Urutan dalam subheading
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paragraphs');
    }
};
