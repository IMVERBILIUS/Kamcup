<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGalleryTableForTournamentDocumentation extends Migration
{
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Jika mau hapus kolom lama yang tidak relevan
            if (Schema::hasColumn('galleries', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('galleries', 'function')) {
                $table->dropColumn('function');
            }
            if (Schema::hasColumn('galleries', 'land_area')) {
                $table->dropColumn('land_area');
            }
            if (Schema::hasColumn('galleries', 'building_area')) {
                $table->dropColumn('building_area');
            }

            // Tambah kolom baru
            $table->string('tournament_name')->nullable()->after('title');
            $table->string('video_link')->nullable()->after('thumbnail');
        });
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Tambah kembali kolom lama kalau rollback
            $table->string('location')->nullable()->after('author');
            $table->string('function')->nullable()->after('location');
            $table->string('land_area')->nullable()->after('function');
            $table->string('building_area')->nullable()->after('land_area');

            // Hapus kolom baru
            $table->dropColumn('tournament_name');
            $table->dropColumn('video_link');
        });
    }
}
