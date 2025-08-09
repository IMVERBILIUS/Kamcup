<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug; // Import HasSlug
use Spatie\Sluggable\SlugOptions; // Import SlugOptions

class Gallery extends Model
{
    use HasFactory, HasSlug; // Tambahkan HasSlug

    protected $fillable = [
        'user_id', 'author', 'title', 'tournament_name', 'thumbnail', 'video_link',
        'status', 'views', 'description',
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
            ->doNotGenerateSlugsOnUpdate(); // Opsional
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function subtitles()
    {
        return $this->hasMany(GallerySubtitle::class);
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
