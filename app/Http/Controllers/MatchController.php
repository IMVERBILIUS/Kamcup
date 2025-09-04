<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\VolleyMatch;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matches = VolleyMatch::with(['tournament', 'team1', 'team2'])->latest()->get();
        return view('match.index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tournaments = Tournament::all();
        $teams = Team::all();
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
            'match_datetime' => 'required|date',
            'stage' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:scheduled,in-progress,completed,cancelled',
            'team1_score' => 'nullable|integer|min:0',
            'team2_score' => 'nullable|integer|min:0',
        ]);

        VolleyMatch::create($validated);

        return redirect()->route('admin.matches.index')->with('success', 'Pertandingan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VolleyMatch $match)
    {
        return view('match.edit', compact('match'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VolleyMatch $match)
    {
        // Validasi input data
        $validated = $request->validate([
            'status' => 'required|in:scheduled,in-progress,completed,cancelled',
            'team1_score' => 'nullable|integer|min:0',
            'team2_score' => 'nullable|integer|min:0',
            'winner_id' => 'nullable|exists:teams,id|required_if:status,completed',
            'loser_id' => 'nullable|exists:teams,id|required_if:status,completed',
        ]);

        // Jika status pertandingan 'completed', tentukan pemenang dan pecundang
        if ($validated['status'] == 'completed') {
            if ($validated['team1_score'] > $validated['team2_score']) {
                $validated['winner_id'] = $match->team1_id;
                $validated['loser_id'] = $match->team2_id;
            } else if ($validated['team2_score'] > $validated['team1_score']) {
                $validated['winner_id'] = $match->team2_id;
                $validated['loser_id'] = $match->team1_id;
            } else {
                // Jika skor imbang (draw), atur winner dan loser menjadi null
                $validated['winner_id'] = null;
                $validated['loser_id'] = null;
            }
        } else {
            // Jika status bukan 'completed', kosongkan winner dan loser
            $validated['winner_id'] = null;
            $validated['loser_id'] = null;
        }

        // Update data pertandingan
        $match->update($validated);

        return redirect()->route('admin.matches.index')->with('success', 'Skor pertandingan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VolleyMatch $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Pertandingan berhasil dihapus.');
    }

    /**
     * API to get live score
     */
    public function getScore(VolleyMatch $match)
    {
        return response()->json([
            'team1_score' => $match->team1_score,
            'team2_score' => $match->team2_score,
            'status' => $match->status,
        ]);
    }
}
