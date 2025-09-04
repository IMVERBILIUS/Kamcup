<?php

namespace App\Services;

use App\Models\Ranking;
use App\Models\VolleyMatch;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RankingService
{
    /**
     * Update ranking berdasarkan hasil pertandingan
     */
    public static function updateRankingFromMatch(VolleyMatch $match)
    {
        if ($match->status !== 'completed') {
            return false;
        }

        DB::beginTransaction();
        try {
            // Get atau create ranking untuk kedua tim
            $team1Ranking = Ranking::firstOrCreate([
                'tournament_id' => $match->tournament_id,
                'team_id' => $match->team1_id,
            ], self::getDefaultRankingData());

            $team2Ranking = Ranking::firstOrCreate([
                'tournament_id' => $match->tournament_id,
                'team_id' => $match->team2_id,
            ], self::getDefaultRankingData());

            // Update statistik berdasarkan hasil pertandingan
            self::updateTeamStats($team1Ranking, $match->team1_score, $match->team2_score);
            self::updateTeamStats($team2Ranking, $match->team2_score, $match->team1_score);

            $team1Ranking->save();
            $team2Ranking->save();

            // Update urutan ranking
            self::recalculateRankingOrder($match->tournament_id);

            DB::commit();

            Log::info('Ranking updated successfully', [
                'match_id' => $match->id,
                'tournament_id' => $match->tournament_id,
                'team1_ranking' => $team1Ranking->toArray(),
                'team2_ranking' => $team2Ranking->toArray()
            ]);

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating ranking from match: ' . $e->getMessage(), [
                'match_id' => $match->id,
                'exception' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Recalculate semua ranking untuk tournament dari awal
     */
    public static function recalculateAllRankings($tournamentId)
    {
        DB::beginTransaction();
        try {
            // Reset semua ranking untuk tournament ini
            Ranking::where('tournament_id', $tournamentId)->delete();

            // Ambil semua pertandingan completed dan urutkan berdasarkan waktu
            $completedMatches = VolleyMatch::where('tournament_id', $tournamentId)
                ->where('status', 'completed')
                ->orderBy('match_datetime', 'asc')
                ->get();

            // Process setiap pertandingan secara berurutan
            foreach ($completedMatches as $match) {
                self::updateRankingFromMatch($match);
            }

            DB::commit();

            Log::info('All rankings recalculated successfully', [
                'tournament_id' => $tournamentId,
                'processed_matches' => $completedMatches->count()
            ]);

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error recalculating all rankings: ' . $e->getMessage(), [
                'tournament_id' => $tournamentId,
                'exception' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Update statistik individual tim
     */
    private static function updateTeamStats(Ranking $ranking, $goalsFor, $goalsAgainst)
    {
        // Update goals
        $ranking->goals_for += $goalsFor;
        $ranking->goals_against += $goalsAgainst;

        // Update win/lose/draw dan points
        if ($goalsFor > $goalsAgainst) {
            // Menang
            $ranking->wins++;
            $ranking->points += 3;
        } elseif ($goalsFor < $goalsAgainst) {
            // Kalah
            $ranking->losses++;
            // Tidak dapat point
        } else {
            // Seri
            $ranking->draws++;
            $ranking->points += 1;
        }
    }

    /**
     * Recalculate urutan ranking untuk tournament
     */
    private static function recalculateRankingOrder($tournamentId)
    {
        // Ambil semua ranking dan urutkan berdasarkan kriteria
        $rankings = Ranking::where('tournament_id', $tournamentId)
            ->orderBy('points', 'desc')           // Poin tertinggi
            ->orderBy('wins', 'desc')             // Jumlah menang tertinggi
            ->orderByRaw('(goals_for - goals_against) desc') // Selisih gol tertinggi
            ->orderBy('goals_for', 'desc')        // Gol dicetak tertinggi
            ->orderBy('goals_against', 'asc')     // Gol kebobolan terendah
            ->get();

        // Update rank untuk setiap tim
        foreach ($rankings as $index => $ranking) {
            $ranking->rank = $index + 1;
            $ranking->save();
        }

        Log::info('Ranking order recalculated', [
            'tournament_id' => $tournamentId,
            'teams_ranked' => $rankings->count()
        ]);
    }

    /**
     * Get default ranking data untuk tim baru
     */
    private static function getDefaultRankingData()
    {
        return [
            'wins' => 0,
            'losses' => 0,
            'draws' => 0,
            'points' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'rank' => 0,
        ];
    }

    /**
     * Get formatted ranking data untuk API response
     */
    public static function getFormattedRankings($tournamentId)
    {
        $rankings = Ranking::where('tournament_id', $tournamentId)
            ->with('team')
            ->orderBy('rank', 'asc')
            ->get();

        return $rankings->map(function($ranking) {
            return [
                'rank' => $ranking->rank,
                'team_id' => $ranking->team_id,
                'team_name' => $ranking->team->name ?? 'Unknown Team',
                'team_logo' => $ranking->team->logo ? asset('storage/' . $ranking->team->logo) : null,
                'matches_played' => $ranking->wins + $ranking->losses + $ranking->draws,
                'wins' => $ranking->wins,
                'draws' => $ranking->draws,
                'losses' => $ranking->losses,
                'goals_for' => $ranking->goals_for,
                'goals_against' => $ranking->goals_against,
                'goal_difference' => $ranking->goals_for - $ranking->goals_against,
                'points' => $ranking->points,
                'win_percentage' => $ranking->wins + $ranking->losses + $ranking->draws > 0 ? 
                    round(($ranking->wins / ($ranking->wins + $ranking->losses + $ranking->draws)) * 100, 2) : 0
            ];
        });
    }

    /**
     * Reset ranking untuk tournament (gunakan dengan hati-hati)
     */
    public static function resetTournamentRankings($tournamentId)
    {
        try {
            $deletedCount = Ranking::where('tournament_id', $tournamentId)->delete();
            
            Log::info('Tournament rankings reset', [
                'tournament_id' => $tournamentId,
                'deleted_count' => $deletedCount
            ]);

            return $deletedCount;
        } catch (\Exception $e) {
            Log::error('Error resetting tournament rankings: ' . $e->getMessage(), [
                'tournament_id' => $tournamentId,
                'exception' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Get top performers untuk tournament
     */
    public static function getTopPerformers($tournamentId, $limit = 5)
    {
        return [
            'top_scorers' => Ranking::where('tournament_id', $tournamentId)
                ->with('team')
                ->orderBy('goals_for', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($ranking) {
                    return [
                        'team_name' => $ranking->team->name,
                        'goals_for' => $ranking->goals_for,
                        'team_logo' => $ranking->team->logo ? asset('storage/' . $ranking->team->logo) : null,
                    ];
                }),
            
            'best_defense' => Ranking::where('tournament_id', $tournamentId)
                ->with('team')
                ->where(DB::raw('wins + losses + draws'), '>', 0) // Tim yang sudah main
                ->orderBy('goals_against', 'asc')
                ->limit($limit)
                ->get()
                ->map(function($ranking) {
                    return [
                        'team_name' => $ranking->team->name,
                        'goals_against' => $ranking->goals_against,
                        'matches_played' => $ranking->wins + $ranking->losses + $ranking->draws,
                        'team_logo' => $ranking->team->logo ? asset('storage/' . $ranking->team->logo) : null,
                    ];
                }),
            
            'most_wins' => Ranking::where('tournament_id', $tournamentId)
                ->with('team')
                ->orderBy('wins', 'desc')
                ->orderBy('points', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($ranking) {
                    return [
                        'team_name' => $ranking->team->name,
                        'wins' => $ranking->wins,
                        'points' => $ranking->points,
                        'team_logo' => $ranking->team->logo ? asset('storage/' . $ranking->team->logo) : null,
                    ];
                })
        ];
    }
}