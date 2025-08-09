<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug; // Import HasSlug
use Spatie\Sluggable\SlugOptions; // Import SlugOptions
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini jika belum ada

class Article extends Model
{
    use HasFactory, HasSlug; // Tambahkan HasFactory jika digunakan, dan HasSlug

    protected $fillable = [
        'title', 'description', 'thumbnail', 'status', 'views', 'user_id', 'author',
        'slug', // Tambahkan 'slug' di sini
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title') // Buat slug dari kolom 'title'
            ->saveSlugsTo('slug')       // Simpan slug di kolom 'slug'
            ->doNotGenerateSlugsOnUpdate(); // Opsional: Tidak membuat ulang slug saat update
    }

    /**
     * Get the route key for the model.
     * Ini memberitahu Laravel untuk menggunakan 'slug' alih-alih 'id' di Route Model Binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function subheadings()
    {
        return $this->hasMany(Subheading::class, 'article_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
