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

    protected $casts = [
        'registration_start' => 'datetime',
        'registration_end' => 'datetime', 
        'event_start' => 'datetime',
        'event_end' => 'datetime',
        'registration_fee' => 'decimal:2',
        'prize_total' => 'decimal:2',
        'max_participants' => 'integer'
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

    // Existing Relationships
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

    // NEW: Ranking Relationships and Methods
    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }

    /**
     * Get rankings yang sudah diurutkan berdasarkan points, wins, goal difference
     */
    public function getOrderedRankings()
    {
        return $this->rankings()
            ->with('team')
            ->orderBy('points', 'desc')
            ->orderBy('wins', 'desc')
            ->orderByRaw('(goals_for - goals_against) desc')
            ->orderBy('goals_for', 'desc')
            ->orderBy('goals_against', 'asc')
            ->get();
    }

    /**
     * Refresh semua ranking untuk tournament ini dari awal
     */
    public function refreshRankings()
    {
        // Reset semua ranking untuk tournament ini
        $this->rankings()->delete();
        
        // Recalculate berdasarkan matches yang completed, diurutkan chronologically
        $completedMatches = $this->matches()
            ->where('status', 'completed')
            ->orderBy('match_datetime', 'asc')
            ->get();

        foreach ($completedMatches as $match) {
            $this->updateRankingFromMatch($match);
        }

        return $this->getOrderedRankings();
    }

    /**
     * Update ranking berdasarkan hasil satu pertandingan
     */
    private function updateRankingFromMatch(VolleyMatch $match)
    {
        if ($match->status !== 'completed') {
            return false;
        }

        // Get atau create ranking untuk kedua tim
        $team1Ranking = $this->rankings()->firstOrCreate([
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

        $team2Ranking = $this->rankings()->firstOrCreate([
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
        $team1Ranking->goals_for += $match->team1_score ?? 0;
        $team1Ranking->goals_against += $match->team2_score ?? 0;
        $team2Ranking->goals_for += $match->team2_score ?? 0;
        $team2Ranking->goals_against += $match->team1_score ?? 0;

        // Update wins/losses/draws dan points
        $team1Score = $match->team1_score ?? 0;
        $team2Score = $match->team2_score ?? 0;

        if ($team1Score > $team2Score) {
            // Team 1 menang
            $team1Ranking->wins++;
            $team1Ranking->points += 3;
            $team2Ranking->losses++;
        } elseif ($team2Score > $team1Score) {
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

        // Update ranking order
        $this->updateRankingOrder();

        return true;
    }

    /**
     * Update urutan ranking berdasarkan points, wins, goal difference
     */
    private function updateRankingOrder()
    {
        $rankings = $this->rankings()
            ->orderBy('points', 'desc')
            ->orderBy('wins', 'desc')
            ->orderByRaw('(goals_for - goals_against) desc')
            ->orderBy('goals_for', 'desc')
            ->orderBy('goals_against', 'asc')
            ->get();

        foreach ($rankings as $index => $ranking) {
            $ranking->rank = $index + 1;
            $ranking->save();
        }
    }

    /**
     * Check apakah tournament memiliki ranking data
     */
    public function hasRankings()
    {
        return $this->rankings()->exists();
    }

    /**
     * Get top teams berdasarkan ranking
     */
    public function getTopTeams($limit = 3)
    {
        return $this->rankings()
            ->with('team')
            ->orderBy('points', 'desc')
            ->orderBy('wins', 'desc')
            ->orderByRaw('(goals_for - goals_against) desc')
            ->orderBy('goals_for', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get confirmed teams untuk tournament ini
     */
    public function confirmedTeams()
    {
        return $this->belongsToMany(Team::class, 'tournament_registrations')
            ->wherePivot('status', 'confirmed');
    }

    /**
     * Scope untuk tournament yang bisa diikuti
     */
    public function scopeOpenForRegistration($query)
    {
        return $query->where('registration_start', '<=', now())
                    ->where('registration_end', '>=', now())
                    ->where('status', 'registration');
    }

    /**
     * Scope untuk tournament yang sedang berlangsung
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope untuk tournament yang sudah selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if tournament is still open for registration
     */
    public function isOpenForRegistration()
    {
        return $this->registration_start <= now() 
            && $this->registration_end >= now()
            && $this->status === 'registration';
    }

    /**
     * Get registered teams count yang sudah dikonfirmasi
     */
    public function getConfirmedTeamsCountAttribute()
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    /**
     * Check if tournament is full
     */
    public function isFull()
    {
        return $this->confirmed_teams_count >= $this->max_participants;
    }

    /**
     * Get tournament progress percentage
     */
    public function getProgressPercentage()
    {
        if (!$this->event_start || !$this->event_end) {
            return 0;
        }

        $now = now();
        $start = $this->event_start;
        $end = $this->event_end;

        if ($now < $start) {
            return 0;
        }

        if ($now > $end) {
            return 100;
        }

        $total = $end->diffInSeconds($start);
        $elapsed = $now->diffInSeconds($start);

        return round(($elapsed / $total) * 100, 2);
    }

    /**
     * Get tournament statistics
     */
    public function getStatistics()
    {
        return [
            'total_matches' => $this->matches()->count(),
            'completed_matches' => $this->matches()->where('status', 'completed')->count(),
            'scheduled_matches' => $this->matches()->where('status', 'scheduled')->count(),
            'in_progress_matches' => $this->matches()->where('status', 'in-progress')->count(),
            'confirmed_teams' => $this->confirmed_teams_count,
            'total_registrations' => $this->registrations()->count(),
            'pending_registrations' => $this->registrations()->where('status', 'pending')->count(),
        ];
    }
}