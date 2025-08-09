<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article; // Pastikan ini diimport
use App\Models\Gallery;
use App\Models\Tournament;
use Illuminate\Support\Str; // Pastikan ini diimport

class FillExistingSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slugs:fill-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills the slug column for existing entries in Article, Gallery, and Tournament models.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Filling slugs for existing data...');

        // === Untuk Model Gallery ===
        $this->info('Processing Galleries...');
        Gallery::all()->each(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
                $gallery->saveQuietly();
                $this->info("Gallery ID: {$gallery->id} - Slug filled: {$gallery->slug}");
            }
        });
        $this->info('Galleries done.');

        // === Untuk Model Tournament ===
        $this->info('Processing Tournaments...');
        Tournament::all()->each(function ($tournament) {
            if (empty($tournament->slug)) {
                $tournament->slug = Str::slug($tournament->title);
                $tournament->saveQuietly();
                $this->info("Tournament ID: {$tournament->id} - Slug filled: {$tournament->slug}");
            }
        });
        $this->info('Tournaments done.');

        // === Untuk Model Article ===
        $this->info('Processing Articles...');
        Article::all()->each(function ($article) {
            if (empty($article->slug)) { // Hanya proses yang slug-nya kosong
                $article->slug = Str::slug($article->title); // Buat slug dari 'title'
                $article->saveQuietly(); // Gunakan saveQuietly()
                $this->info("Article ID: {$article->id} - Slug filled: {$article->slug}");
            }
        });
        $this->info('Articles done.');

        $this->info('All existing slugs have been filled!');
    }
}
