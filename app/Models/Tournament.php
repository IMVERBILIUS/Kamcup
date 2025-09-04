<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tournament extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title', 'thumbnail', 'registration_start', 'registration_end',
        'gender_category', 'location', 'registration_fee', 'prize_total',
        'contact_person', 'status', 'event_start', 'event_end',
        'visibility_status', 'max_participants',
        'slug',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function rules() {
        return $this->hasMany(TournamentRule::class);
    }

    public function registrations() {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function sponsors() {
        return $this->belongsToMany(Sponsor::class, 'sponsor_tournament');
    }

    public function matches()
    {
        return $this->hasMany(VolleyMatch::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
