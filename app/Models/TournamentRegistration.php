<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this if you use model factories

class TournamentRegistration extends Model
{
    // Add HasFactory if you're using factories for seeding or testing
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'team_id',
        'user_id', // Add user_id here as it's now in the database and filled by the controller
        'status',
        'rejection_reason',
        'registered_at',
        // Optional: If you copy team details directly to registration table for a snapshot
        'team_name', // Add if you have this column in tournament_registrations
        'team_logo', // Add if you have this column in tournament_registrations
        // 'members_snapshot', // Add if you have this JSON column in tournament_registrations
    ];

    /**
     * Get the tournament that the registration belongs to.
     */
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get the team that the registration belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user who made this registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
