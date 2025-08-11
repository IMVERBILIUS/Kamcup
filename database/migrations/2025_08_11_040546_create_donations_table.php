<?php
// database/migrations/2025_01_01_000000_create_donations_table.php

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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('name_brand')->comment('Nama perusahaan/brand sponsor');
            $table->string('email')->comment('Email kontak');
            $table->string('phone_whatsapp', 20)->comment('Nomor WhatsApp');
            $table->string('event_name')->comment('Nama acara yang dipilih');
            $table->enum('donation_type', ['sponsor', 'donatur'])->comment('Jenis pendanaan');
            $table->string('sponsor_type', 50)->nullable()->comment('Kategori sponsor (XXL, XL, L, M, Pilihan Lainnya)');
            $table->text('message')->nullable()->comment('Kesan/pesan dari sponsor (optional)');
            $table->text('benefits')->nullable()->comment('Benefits yang didapat sesuai sponsor type');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('Status pengajuan');
            $table->timestamps();

            // Indexes
            $table->index('email');
            $table->index('status');
            $table->index('donation_type');
            $table->index('event_name');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};