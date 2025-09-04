<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'user_id', 'logo', 'name', 'manager_name', 'contact',
        'location', 'gender_category', 'member_count', 'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function members() {
        return $this->hasMany(TeamMember::class);
    }

    public function registrations() {
        return $this->hasMany(TournamentRegistration::class);
    }
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
