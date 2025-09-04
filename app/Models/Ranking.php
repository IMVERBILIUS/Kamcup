<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'team_id',
        'wins',
        'losses',
        'draws',
        'points',
        'goals_for',
        'goals_against',
        'rank',
    ];

    protected $casts = [
        'wins' => 'integer',
        'losses' => 'integer', 
        'draws' => 'integer',
        'points' => 'integer',
        'goals_for' => 'integer',
        'goals_against' => 'integer',
        'rank' => 'integer',
    ];

    // Relationships
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Calculated attributes
    public function getMatchesPlayedAttribute()
    {
        return $this->wins + $this->losses + $this->draws;
    }

    public function getGoalDifferenceAttribute()
    {
        return $this->goals_for - $this->goals_against;
    }

    public function getWinPercentageAttribute()
    {
        $totalMatches = $this->matches_played;
        return $totalMatches > 0 ? round(($this->wins / $totalMatches) * 100, 2) : 0;
    }

    // Static methods untuk update ranking
    public static function updateRankingForMatch(VolleyMatch $match)
    {
        if ($match->status !== 'completed') {
            return false;
        }

        $team1Ranking = self::firstOrCreate([
            'tournament_id' => $match->tournament_id,
            'team_id' => $match->team1_id,
        ], [
            'wins' => 0,
            'losses' => 0,
            'draws' => 0,
            'points' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'rank' => 0,
        ]);

        $team2Ranking = self::firstOrCreate([
            'tournament_id' => $match->tournament_id,
            'team_id' => $match->team2_id,
        ], [
            'wins' => 0,
            'losses' => 0,
            'draws' => 0,
            'points' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'rank' => 0,
        ]);

        // Update goals
        $team1Ranking->goals_for += $match->team1_score;
        $team1Ranking->goals_against += $match->team2_score;
        $team2Ranking->goals_for += $match->team2_score;
        $team2Ranking->goals_against += $match->team1_score;

        // Update wins/losses/draws dan points
        if ($match->team1_score > $match->team2_score) {
            // Team 1 menang
            $team1Ranking->wins++;
            $team1Ranking->points += 3;
            $team2Ranking->losses++;
        } elseif ($match->team2_score > $match->team1_score) {
            // Team 2 menang
            $team2Ranking->wins++;
            $team2Ranking->points += 3;
            $team1Ranking->losses++;
        } else {
            // Seri/Draw
            $team1Ranking->draws++;
            $team1Ranking->points += 1;
            $team2Ranking->draws++;
            $team2Ranking->points += 1;
        }

        $team1Ranking->save();
        $team2Ranking->save();

        // Update ranking order untuk tournament ini
        self::updateRankingOrder($match->tournament_id);

        return true;
    }

    public static function updateRankingOrder($tournamentId)
    {
        $rankings = self::where('tournament_id', $tournamentId)
            ->orderBy('points', 'desc')
            ->orderBy('wins', 'desc')
            ->orderByRaw('(goals_for - goals_against) desc')
            ->orderBy('goals_for', 'desc')
            ->get();

        foreach ($rankings as $index => $ranking) {
            $ranking->rank = $index + 1;
            $ranking->save();
        }
    }

    public static function resetTournamentRankings($tournamentId)
    {
        return self::where('tournament_id', $tournamentId)->delete();
    }

    // Scope untuk mendapatkan ranking yang sudah diurutkan
    public function scopeOrdered($query, $tournamentId = null)
    {
        $query = $query->orderBy('points', 'desc')
                      ->orderBy('wins', 'desc')
                      ->orderByRaw('(goals_for - goals_against) desc')
                      ->orderBy('goals_for', 'desc');
        
        if ($tournamentId) {
            $query->where('tournament_id', $tournamentId);
        }

        return $query;
    }
}