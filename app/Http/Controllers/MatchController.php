<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\VolleyMatch;
use App\Models\TournamentRegistration;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matches = VolleyMatch::with(['tournament', 'team1', 'team2', 'winner', 'loser'])
                    ->latest('match_datetime')
                    ->get();
        
        Log::info('Matches loaded for index view', [
            'total_matches' => $matches->count(),
            'matches_with_scores' => $matches->where('status', 'completed')->map(function($match) {
                return [
                    'id' => $match->id,
                    'team1' => $match->team1->name ?? 'N/A',
                    'team2' => $match->team2->name ?? 'N/A',
                    'team1_score' => $match->team1_score,
                    'team2_score' => $match->team2_score,
                    'winner' => $match->winner->name ?? 'None',
                    'status' => $match->status
                ];
            })
        ]);
        
        return view('match.index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tournaments = Tournament::where('status', '!=', 'completed')
                                ->orderBy('title')
                                ->get();
        
        $teams = collect(); // Empty collection
        
        return view('match.create', compact('tournaments', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'match_datetime' => 'required|date|after:now',
            'stage' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'nullable|in:scheduled,in-progress,completed,cancelled',
            'team1_score' => 'nullable|integer|min:0',
            'team2_score' => 'nullable|integer|min:0',
        ], [
            'tournament_id.required' => 'Turnamen wajib dipilih.',
            'tournament_id.exists' => 'Turnamen yang dipilih tidak valid.',
            'team1_id.required' => 'Tim 1 wajib dipilih.',
            'team1_id.exists' => 'Tim 1 yang dipilih tidak valid.',
            'team1_id.different' => 'Tim 1 dan Tim 2 harus berbeda.',
            'team2_id.required' => 'Tim 2 wajib dipilih.',
            'team2_id.exists' => 'Tim 2 yang dipilih tidak valid.',
            'match_datetime.required' => 'Tanggal dan waktu pertandingan wajib diisi.',
            'match_datetime.date' => 'Format tanggal dan waktu tidak valid.',
            'match_datetime.after' => 'Waktu pertandingan harus di masa depan.',
            'stage.required' => 'Tahapan pertandingan wajib diisi.',
            'location.required' => 'Lokasi pertandingan wajib diisi.',
            'status.in' => 'Status pertandingan tidak valid.',
        ]);

        DB::beginTransaction();
        try {
            // Validasi tambahan: pastikan kedua tim terdaftar di tournament dan dikonfirmasi
            $team1Registration = TournamentRegistration::where('tournament_id', $validated['tournament_id'])
                ->where('team_id', $validated['team1_id'])
                ->where('status', 'confirmed')
                ->first();

            $team2Registration = TournamentRegistration::where('tournament_id', $validated['tournament_id'])
                ->where('team_id', $validated['team2_id'])
                ->where('status', 'confirmed')
                ->first();

            if (!$team1Registration || !$team2Registration) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Salah satu atau kedua tim belum terdaftar atau dikonfirmasi untuk turnamen ini.');
            }

            $validated['status'] = $validated['status'] ?? 'scheduled';

            $match = VolleyMatch::create($validated);

            // Update ranking jika match langsung completed
            if ($validated['status'] === 'completed' && 
                isset($validated['team1_score']) && 
                isset($validated['team2_score'])) {
                
                $tournament = Tournament::find($match->tournament_id);
                $tournament->refreshRankings();
            }

            DB::commit();
            
            Log::info('Match created successfully', [
                'match_id' => $match->id,
                'tournament' => $match->tournament->title,
                'teams' => $match->team1->name . ' vs ' . $match->team2->name
            ]);

            return redirect()->route('admin.matches.index')->with('success', 'Pertandingan berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating match: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Gagal menambahkan pertandingan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VolleyMatch $match)
    {
        $match->load(['tournament', 'team1', 'team2', 'winner', 'loser']);
        return view('match.show', compact('match'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VolleyMatch $match)
    {
        $match->load(['tournament', 'team1', 'team2', 'winner', 'loser']);
        return view('match.edit', compact('match'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VolleyMatch $match)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,in-progress,completed,cancelled',
            'team1_score' => 'nullable|integer|min:0',
            'team2_score' => 'nullable|integer|min:0',
            'winner_id' => 'nullable|exists:teams,id',
            'loser_id' => 'nullable|exists:teams,id',
        ], [
            'status.required' => 'Status pertandingan wajib dipilih.',
            'status.in' => 'Status pertandingan tidak valid.',
            'team1_score.integer' => 'Skor Tim 1 harus berupa angka.',
            'team1_score.min' => 'Skor Tim 1 tidak boleh negatif.',
            'team2_score.integer' => 'Skor Tim 2 harus berupa angka.',
            'team2_score.min' => 'Skor Tim 2 tidak boleh negatif.',
            'winner_id.exists' => 'Pemenang yang dipilih tidak valid.',
            'loser_id.exists' => 'Tim yang kalah tidak valid.',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $match->status;
            $oldScores = ['team1' => $match->team1_score, 'team2' => $match->team2_score];
            
            // Cek apakah perlu refresh ranking
            $needsRankingRefresh = ($oldStatus === 'completed');
            
            // Logic untuk menentukan pemenang dan pecundang berdasarkan status
            if ($validated['status'] === 'completed') {
                $team1Score = $validated['team1_score'] ?? 0;
                $team2Score = $validated['team2_score'] ?? 0;

                if ($team1Score > $team2Score) {
                    $validated['winner_id'] = $match->team1_id;
                    $validated['loser_id'] = $match->team2_id;
                } elseif ($team2Score > $team1Score) {
                    $validated['winner_id'] = $match->team2_id;
                    $validated['loser_id'] = $match->team1_id;
                } else {
                    // Skor imbang
                    $validated['winner_id'] = null;
                    $validated['loser_id'] = null;
                }
            } elseif ($validated['status'] === 'cancelled') {
                // Reset semua nilai untuk pertandingan yang dibatalkan
                $validated['team1_score'] = null;
                $validated['team2_score'] = null;
                $validated['winner_id'] = null;
                $validated['loser_id'] = null;
            } else {
                // Untuk status scheduled atau in-progress, reset winner/loser
                $validated['winner_id'] = null;
                $validated['loser_id'] = null;
            }

            $match->update($validated);

            // Update ranking system
            if ($needsRankingRefresh || $validated['status'] === 'completed') {
                $tournament = Tournament::find($match->tournament_id);
                $tournament->refreshRankings();
            }

            DB::commit();
            
            Log::info('Match updated successfully', [
                'match_id' => $match->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
                'old_scores' => $oldScores,
                'new_scores' => [
                    'team1' => $validated['team1_score'],
                    'team2' => $validated['team2_score']
                ],
                'winner' => $match->winner ? $match->winner->name : 'None',
                'teams' => $match->team1->name . ' vs ' . $match->team2->name
            ]);

            return redirect()->route('admin.matches.index')->with('success', 'Pertandingan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating match: ' . $e->getMessage(), [
                'match_id' => $match->id,
                'request_data' => $request->all(),
                'exception' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui pertandingan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VolleyMatch $match)
    {
        try {
            $matchInfo = ($match->team1->name ?? 'Team 1') . ' vs ' . ($match->team2->name ?? 'Team 2');
            $matchId = $match->id;
            $tournamentId = $match->tournament_id;
            $wasCompleted = $match->status === 'completed';
            
            $match->delete();
            
            // Refresh ranking jika match yang dihapus sudah completed
            if ($wasCompleted) {
                $tournament = Tournament::find($tournamentId);
                if ($tournament) {
                    $tournament->refreshRankings();
                }
            }
            
            Log::info('Match deleted successfully', [
                'match_id' => $matchId,
                'match_info' => $matchInfo
            ]);
            
            return redirect()->route('admin.matches.index')->with('success', 'Pertandingan "' . $matchInfo . '" berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting match: ' . $e->getMessage(), [
                'match_id' => $match->id,
                'exception' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.matches.index')->with('error', 'Gagal menghapus pertandingan: ' . $e->getMessage());
        }
    }

    /**
     * API to get live score
     */
    public function getScore(VolleyMatch $match)
    {
        try {
            $match->load(['team1', 'team2', 'winner', 'loser']);
            
            $response = [
                'match_id' => $match->id,
                'team1_score' => $match->team1_score ?? 0,
                'team2_score' => $match->team2_score ?? 0,
                'status' => $match->status,
                'winner' => $match->winner ? $match->winner->name : null,
                'loser' => $match->loser ? $match->loser->name : null,
                'team1_name' => $match->team1 ? $match->team1->name : 'Team 1',
                'team2_name' => $match->team2 ? $match->team2->name : 'Team 2',
                'updated_at' => $match->updated_at->toISOString(),
                'is_draw' => ($match->status === 'completed' && 
                             $match->team1_score === $match->team2_score && 
                             $match->team1_score !== null)
            ];
            
            Log::info('Score requested for match', [
                'match_id' => $match->id,
                'response' => $response
            ]);
            
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error getting match score: ' . $e->getMessage(), [
                'match_id' => $match->id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to get match score'], 500);
        }
    }

    /**
     * API untuk mendapatkan live scores multiple matches
     */
    public function getLiveScores($eventId)
    {
        try {
            $matches = VolleyMatch::where('tournament_id', $eventId)
                ->with(['team1', 'team2', 'winner'])
                ->orderBy('match_datetime', 'asc')
                ->get();

            $response = $matches->map(function($match) {
                return [
                    'id' => $match->id,
                    'team1_score' => $match->team1_score ?? 0,
                    'team2_score' => $match->team2_score ?? 0,
                    'status' => $match->status,
                    'winner' => $match->winner ? $match->winner->name : null,
                    'team1_name' => $match->team1 ? $match->team1->name : 'Team 1',
                    'team2_name' => $match->team2 ? $match->team2->name : 'Team 2',
                    'is_draw' => ($match->status === 'completed' && 
                                 $match->team1_score === $match->team2_score && 
                                 $match->team1_score !== null),
                    'updated_at' => $match->updated_at->toISOString()
                ];
            });

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error getting live scores: ' . $e->getMessage(), [
                'event_id' => $eventId,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to get live scores'], 500);
        }
    }

    /**
     * API untuk mendapatkan rankings
     */
    public function getRankings($eventId)
    {
        try {
            $tournament = Tournament::findOrFail($eventId);
            $rankings = $tournament->getOrderedRankings();

            $response = $rankings->map(function($ranking) {
                $matchesPlayed = $ranking->wins + $ranking->losses + $ranking->draws;
                $winPercentage = $matchesPlayed > 0 ? round(($ranking->wins / $matchesPlayed) * 100, 2) : 0;
                $goalDifference = $ranking->goals_for - $ranking->goals_against;

                return [
                    'rank' => $ranking->rank ?: 0,
                    'team_id' => $ranking->team_id,
                    'team_name' => $ranking->team->name ?? 'Unknown Team',
                    'team_logo' => $ranking->team->logo ? asset('storage/' . $ranking->team->logo) : null,
                    'matches_played' => $matchesPlayed,
                    'wins' => $ranking->wins,
                    'draws' => $ranking->draws,
                    'losses' => $ranking->losses,
                    'goals_for' => $ranking->goals_for,
                    'goals_against' => $ranking->goals_against,
                    'goal_difference' => $goalDifference,
                    'points' => $ranking->points,
                    'win_percentage' => $winPercentage
                ];
            });

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error getting rankings: ' . $e->getMessage(), [
                'event_id' => $eventId,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to get rankings'], 500);
        }
    }

    /**
     * Get confirmed teams for a specific tournament (AJAX endpoint)
     */
    public function getConfirmedTeams(Request $request)
    {
        $tournamentId = $request->get('tournament_id');
        
        if (!$tournamentId) {
            Log::warning('getConfirmedTeams called without tournament_id');
            return response()->json(['error' => 'Tournament ID required'], 400);
        }

        try {
            $teams = Team::whereHas('registrations', function($query) use ($tournamentId) {
                $query->where('tournament_id', $tournamentId)
                      ->where('status', 'confirmed');
            })->select('id', 'name')
              ->orderBy('name')
              ->get();

            Log::info('Fetched confirmed teams for tournament ' . $tournamentId, [
                'tournament_id' => $tournamentId,
                'teams_count' => $teams->count(),
                'teams' => $teams->toArray()
            ]);

            if ($teams->isEmpty()) {
                return response()->json([
                    'teams' => [],
                    'message' => 'No confirmed teams found for this tournament'
                ]);
            }

            return response()->json($teams);

        } catch (\Exception $e) {
            Log::error('Error fetching confirmed teams: ' . $e->getMessage(), [
                'tournament_id' => $tournamentId,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch teams'], 500);
        }
    }

    /**
     * Get tournament location (AJAX endpoint)
     */
    public function getTournamentLocation(Request $request)
    {
        $tournamentId = $request->get('tournament_id');
        
        if (!$tournamentId) {
            Log::warning('getTournamentLocation called without tournament_id');
            return response()->json(['error' => 'Tournament ID required'], 400);
        }

        try {
            $tournament = Tournament::findOrFail($tournamentId);
            
            $response = [
                'location' => $tournament->location,
                'title' => $tournament->title,
                'tournament_id' => $tournament->id
            ];
            
            Log::info('Tournament location fetched', [
                'tournament_id' => $tournamentId,
                'location' => $tournament->location
            ]);
            
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching tournament location: ' . $e->getMessage(), [
                'tournament_id' => $tournamentId,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Tournament not found'], 404);
        }
    }

    /**
     * Get all teams for a tournament (including pending - for admin purposes)
     */
    public function getAllTeamsForTournament(Request $request)
    {
        $tournamentId = $request->get('tournament_id');
        
        if (!$tournamentId) {
            return response()->json(['error' => 'Tournament ID required'], 400);
        }

        try {
            $teams = Team::whereHas('registrations', function($query) use ($tournamentId) {
                $query->where('tournament_id', $tournamentId);
            })->with(['registrations' => function($query) use ($tournamentId) {
                $query->where('tournament_id', $tournamentId);
            }])->select('id', 'name')
              ->orderBy('name')
              ->get();

            $formattedTeams = $teams->map(function($team) {
                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'status' => $team->registrations->first()->status ?? 'unknown'
                ];
            });

            Log::info('Fetched all teams for tournament ' . $tournamentId, [
                'tournament_id' => $tournamentId,
                'teams_count' => $formattedTeams->count()
            ]);

            return response()->json($formattedTeams);

        } catch (\Exception $e) {
            Log::error('Error fetching all teams for tournament: ' . $e->getMessage(), [
                'tournament_id' => $tournamentId,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch teams'], 500);
        }
    }

    /**
     * Get match statistics for a tournament
     */
    public function getTournamentStats(Tournament $tournament)
    {
        try {
            $stats = [
                'total_matches' => $tournament->matches()->count(),
                'completed_matches' => $tournament->matches()->where('status', 'completed')->count(),
                'scheduled_matches' => $tournament->matches()->where('status', 'scheduled')->count(),
                'in_progress_matches' => $tournament->matches()->where('status', 'in-progress')->count(),
                'cancelled_matches' => $tournament->matches()->where('status', 'cancelled')->count(),
            ];

            try {
                $stats['confirmed_teams'] = $tournament->confirmedTeams()->count();
            } catch (\Exception $e) {
                Log::warning('Could not fetch team stats for tournament', [
                    'tournament_id' => $tournament->id,
                    'error' => $e->getMessage()
                ]);
                $stats['confirmed_teams'] = 0;
            }

            Log::info('Tournament stats fetched', [
                'tournament_id' => $tournament->id,
                'stats' => $stats
            ]);

            return response()->json($stats);

        } catch (\Exception $e) {
            Log::error('Error fetching tournament stats: ' . $e->getMessage(), [
                'tournament_id' => $tournament->id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch stats'], 500);
        }
    }

    /**
     * Bulk update match status (for admin convenience)
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'match_ids' => 'required|array|min:1',
            'match_ids.*' => 'exists:matches,id',
            'status' => 'required|in:scheduled,in-progress,completed,cancelled',
        ]);

        DB::beginTransaction();
        try {
            $updatedCount = VolleyMatch::whereIn('id', $validated['match_ids'])
                ->update([
                    'status' => $validated['status'],
                    'updated_at' => Carbon::now()
                ]);

            DB::commit();
            
            Log::info('Bulk status update completed', [
                'match_ids' => $validated['match_ids'],
                'new_status' => $validated['status'],
                'updated_count' => $updatedCount
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} pertandingan berhasil diperbarui ke status '{$validated['status']}'.",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error bulk updating match status: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Gagal memperbarui pertandingan'], 500);
        }
    }

    /**
     * Refresh all matches (force cache clear if any)
     */
    public function refreshMatches(Request $request)
    {
        try {
            if (function_exists('opcache_reset')) {
                opcache_reset();
            }

            $matches = VolleyMatch::with(['tournament', 'team1', 'team2', 'winner', 'loser'])
                        ->latest('match_datetime')
                        ->get();

            Log::info('Matches refreshed', [
                'total_matches' => $matches->count(),
                'timestamp' => now()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data pertandingan berhasil di-refresh',
                    'matches_count' => $matches->count()
                ]);
            }

            return redirect()->route('admin.matches.index')->with('success', 'Data pertandingan berhasil di-refresh!');

        } catch (\Exception $e) {
            Log::error('Error refreshing matches: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Gagal refresh data pertandingan'], 500);
            }

            return back()->with('error', 'Gagal refresh data pertandingan: ' . $e->getMessage());
        }
    }
}