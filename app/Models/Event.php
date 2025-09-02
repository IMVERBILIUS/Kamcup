<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model
{
    use HasFactory, HasSlug;

    // Nama tabel (jika berbeda dari konvensi Laravel)
    protected $table = 'tournaments'; // Karena di routes menggunakan 'tournament'

    protected $fillable = [
        'title',
        'description', 
        'thumbnail',
        'location',
        'registration_start',
        'registration_end',
        'event_start',
        'event_end',
        'max_teams',
        'registration_fee',
        'gender_category',
        'status',
        'slug',
        'user_id',
        'views'
    ];

    protected $casts = [
        'registration_start' => 'datetime',
        'registration_end' => 'datetime', 
        'event_start' => 'datetime',
        'event_end' => 'datetime',
        'registration_fee' => 'decimal:2',
        'views' => 'integer',
        'max_teams' => 'integer'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationship with User (creator)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Team Registrations
     */
    public function registrations()
    {
        return $this->hasMany(TeamRegistration::class, 'tournament_id');
    }

    /**
     * Scope untuk event yang masih bisa didaftari
     */
    public function scopeOpenForRegistration($query)
    {
        return $query->where('registration_start', '<=', now())
                    ->where('registration_end', '>=', now())
                    ->where('status', 'registration');
    }

    /**
     * Scope untuk event yang sedang berlangsung
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope untuk event yang sudah selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if event is still open for registration
     */
    public function isOpenForRegistration()
    {
        return $this->registration_start <= now() 
            && $this->registration_end >= now()
            && $this->status === 'registration';
    }

    /**
     * Get registered teams count
     */
    public function getRegisteredTeamsCountAttribute()
    {
        return $this->registrations()->where('status', 'approved')->count();
    }

    /**
     * Check if event is full
     */
    public function isFull()
    {
        return $this->registered_teams_count >= $this->max_teams;
    }
}