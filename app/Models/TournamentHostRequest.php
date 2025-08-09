<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentHostRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'responsible_name',
        'email',
        'phone',
        'tournament_title',
        'venue_name',
        'venue_address',
        'estimated_capacity',
        'proposed_date',
        'available_facilities',
        'notes',
        'status',
        'rejection_reason',
    ];

    /**
     * Relasi ke user yang mengajukan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
