<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TAMBAHAN BARU: API Routes untuk Live Scores dan Rankings
Route::prefix('events')->group(function () {
    // Get live scores untuk semua match di event tertentu
    Route::get('{eventId}/live-scores', [MatchController::class, 'getLiveScores'])
         ->name('api.events.live-scores');
    
    // Get rankings untuk event tertentu
    Route::get('{eventId}/rankings', [MatchController::class, 'getRankings'])
         ->name('api.events.rankings');
});

// API Routes untuk Match Management (Optional - untuk admin)
Route::prefix('matches')->middleware(['auth:sanctum'])->group(function () {
    // Get single match score
    Route::get('{match}/score', [MatchController::class, 'getScore'])
         ->name('api.matches.score');
    
    // Bulk update match status
    Route::patch('bulk-update-status', [MatchController::class, 'bulkUpdateStatus'])
         ->name('api.matches.bulk-update-status');
    
    // Refresh all matches
    Route::post('refresh', [MatchController::class, 'refreshMatches'])
         ->name('api.matches.refresh');
});

// API Routes untuk Tournament Management (Optional)
Route::prefix('tournaments')->group(function () {
    // Get confirmed teams untuk tournament tertentu
    Route::get('{tournamentId}/confirmed-teams', [MatchController::class, 'getConfirmedTeams'])
         ->name('api.tournaments.confirmed-teams');
    
    // Get tournament location
    Route::get('{tournamentId}/location', [MatchController::class, 'getTournamentLocation'])
         ->name('api.tournaments.location');
    
    // Get all teams untuk tournament (including pending)
    Route::get('{tournamentId}/all-teams', [MatchController::class, 'getAllTeamsForTournament'])
         ->name('api.tournaments.all-teams');
    
    // Get tournament statistics
    Route::get('{tournament}/stats', [MatchController::class, 'getTournamentStats'])
         ->name('api.tournaments.stats');
});

// Alternative routes (jika ingin menggunakan path yang berbeda)
// Route::get('live-scores/{eventId}', [MatchController::class, 'getLiveScores']);
// Route::get('rankings/{eventId}', [MatchController::class, 'getRankings']);