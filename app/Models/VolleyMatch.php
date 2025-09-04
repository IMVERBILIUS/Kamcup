<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolleyMatch extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tournament_id',
        'team1_id',
        'team2_id',
        'stage',
        'match_datetime',
        'status',
        'team1_score',
        'team2_score',
        'winner_id',
        'loser_id',
        'format',
        'location',
    ];

    /**
     * Get the tournament that the match belongs to.
     */
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get the first team of the match.
     */
    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    /**
     * Get the second team of the match.
     */
    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    /**
     * Get the winning team of the match.
     */
    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    /**
     * Get the losing team of the match.
     */
    public function loser()
    {
        return $this->belongsTo(Team::class, 'loser_id');
    }
}