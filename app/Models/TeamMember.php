<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'team_id', 'photo', 'name', 'birthdate', 'gender',
        'position', 'jersey_number', 'contact', 'email',
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }
}
