<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Tournament;
use App\Models\TournamentRule;
use App\Models\TournamentRegistration; // Make sure this model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // Make sure Log is imported

class TournamentController extends Controller
{
    /**
     * Display a listing of the tournaments for admin management.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // Default sort by latest creation date, matching Blade option 'latest'

        $query = Tournament::query();

        switch ($sort) {
            case 'title_asc': // Corresponds to 'Judul (A-Z)' in Blade
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc': // Corresponds to 'Judul (Z-A)' in Blade
                $query->orderBy('title', 'desc');
                break;
            case 'oldest': // Corresponds to 'Terlama' in Blade
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest': // Corresponds to 'Terbaru' in Blade
            default: // Default if no valid sort is provided
                $query->orderBy('created_at', 'desc');
                break;
        }

        $tournaments = $query->paginate(10)->withQueryString();

        return view('tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new tournament.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sponsors = Sponsor::all();
        return view('tournaments.create', compact('sponsors'));
    }

    /**
     * Store a newly created tournament in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'gender_category' => 'required|in:male,female,mixed',
            'registration_fee' => 'required|numeric|min:0',
            'prize_total' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'event_start' => 'nullable|date',
            'event_end' => 'nullable|date|after_or_equal:event_start',
            'status' => 'required|in:registration,ongoing,completed',
            'visibility_status' => 'required|in:Draft,Published',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // Changed to required
            'rules.*' => 'nullable|string',
            'sponsors' => 'nullable|array',
            'sponsors.*' => 'exists:sponsors,id',
        ]);

        DB::beginTransaction();

        try {
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            $tournament = Tournament::create([
                'title' => $request->title,
                'location' => $request->location,
                'contact_person' => $request->contact_person,
                'gender_category' => $request->gender_category,
                'registration_fee' => $request->registration_fee,
                'prize_total' => $request->prize_total,
                'max_participants' => $request->max_participants,
                'registration_start' => $request->registration_start,
                'registration_end' => $request->registration_end,
                'event_start' => $request->event_start,
                'event_end' => $request->event_end,
                'status' => $request->status,
                'visibility_status' => $request->visibility_status,
                'thumbnail' => $thumbnailPath,
            ]);

            if ($request->has('rules') && is_array($request->rules)) {
                foreach ($request->rules as $ruleText) {
                    if (!empty($ruleText)) {
                        $tournament->rules()->create([
                            'rule_text' => $ruleText,
                        ]);
                    }
                }
            }

            if ($request->has('sponsors')) {
                $tournament->sponsors()->attach($request->sponsors);
            }

            DB::commit();

            return redirect()->route('admin.tournaments.index')->with('success', 'Turnamen berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error creating tournament: " . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Gagal membuat turnamen: ' . $e->getMessage());
        }
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     dd($e->getMessage()); // Langsung tampilkan pesan error
        // }
    }

    /**
     * Display the specified tournament (Admin view).
     *
     * @param  \App\Models\Tournament  $tournament (Model bound by slug from route)
     * @return \Illuminate\View\View
     */
    public function show(Tournament $tournament)
    {
        // Tournament is automatically loaded by Route Model Binding (via slug)
        // Eager load necessary relations for admin view:
        // - 'rules' for rules tab
        // - 'sponsors' for sponsors display
        // - 'registrations.team.members': to get team details and their members for the participants tab
        // - 'registrations.user': to get the user who registered (captain) for the participants tab
        $tournament->load(['rules', 'sponsors', 'registrations.team.members', 'registrations.user']);
        return view('tournaments.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified tournament.
     *
     * @param  \App\Models\Tournament  $tournament (Model bound by slug from route)
     * @return \Illuminate\View\View
     */
    public function edit(Tournament $tournament)
    {
        // Tournament is automatically loaded
        $tournament->load(['rules', 'sponsors']); // Eager load necessary relations
        $sponsors = Sponsor::all();
        return view('tournaments.edit', compact('tournament', 'sponsors'));
    }

    /**
     * Update the specified tournament in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tournament  $tournament (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'gender_category' => 'required|in:male,female,mixed',
            'registration_fee' => 'required|numeric|min:0',
            'prize_total' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'event_start' => 'nullable|date',
            'event_end' => 'nullable|date|after_or_equal:event_start',
            'status' => 'required|in:registration,ongoing,completed',
            'visibility_status' => 'required|in:Draft,Published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'clear_thumbnail' => 'nullable|boolean',
            'rules.*' => 'nullable|string',
            'sponsors' => 'nullable|array',
            'sponsors.*' => 'exists:sponsors,id',
        ]);

        DB::beginTransaction();

        try {
            // Thumbnail handling
            if ($request->hasFile('thumbnail')) {
                if ($tournament->thumbnail) {
                    Storage::disk('public')->delete($tournament->thumbnail);
                }
                $tournament->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
            } else if ($request->boolean('clear_thumbnail')) {
                if ($tournament->thumbnail) {
                    Storage::disk('public')->delete($tournament->thumbnail);
                }
                $tournament->thumbnail = null;
            }

            // Update main tournament attributes. Spatie Sluggable (or similar) will manage the slug.
            $tournament->update([
                'title' => $request->title,
                'location' => $request->location,
                'contact_person' => $request->contact_person,
                'gender_category' => $request->gender_category,
                'registration_fee' => $request->registration_fee,
                'prize_total' => $request->prize_total,
                'max_participants' => $request->max_participants,
                'registration_start' => $request->registration_start,
                'registration_end' => $request->registration_end,
                'event_start' => $request->event_start,
                'event_end' => $request->event_end,
                'status' => $request->status,
                'visibility_status' => $request->visibility_status,
                // 'thumbnail' is handled separately above
            ]);

            // Sync rules (deletes old and creates new based on the request)
            $currentRuleTexts = collect($request->rules)->filter()->all(); // Filter out empty strings
            $tournament->rules()->delete(); // Delete all old rules
            foreach ($currentRuleTexts as $ruleText) {
                $tournament->rules()->create(['rule_text' => $ruleText]);
            }

            // Sync Sponsors (will add, remove, or retain relations)
            $tournament->sponsors()->sync($request->sponsors ?? []);

            DB::commit();

            return redirect()->route('admin.tournaments.index')->with('success', 'Turnamen berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating tournament: " . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Gagal memperbarui turnamen: ' . $e->getMessage());
        }
    }

    /**
     * Update the registration status of a specific team for this tournament.
     * This is a new method for the admin to change registration status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tournament  $tournament
     * @param  \App\Models\TournamentRegistration  $registration
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRegistrationStatus(Request $request, Tournament $tournament, TournamentRegistration $registration)
    {
        // Authorize: Ensure only admins can do this
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        // Validate the incoming status
        $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'rejected'])],
            'rejection_reason' => ['nullable', 'string', 'max:500'], // Optional for 'rejected' status
        ]);

        DB::beginTransaction();
        try {
            // Ensure the registration belongs to the correct tournament
            if ($registration->tournament_id !== $tournament->id) {
                return back()->with('error', 'Pendaftaran tidak sesuai dengan turnamen ini.');
            }

            $oldStatus = $registration->status;
            $newStatus = $request->status;

            $registration->status = $newStatus;

            // Handle rejection reason
            if ($newStatus === 'rejected') {
                $registration->rejection_reason = $request->rejection_reason;
            } else {
                $registration->rejection_reason = null; // Clear reason if not rejected
            }

            $registration->save();
            DB::commit();

            return back()->with('success', "Status pendaftaran tim '{$registration->team->name}' berhasil diubah dari '{$oldStatus}' menjadi '{$newStatus}'.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating registration status: " . $e->getMessage(), [
                'tournament_id' => $tournament->id,
                'registration_id' => $registration->id,
                'new_status' => $request->status,
                'exception' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal mengubah status pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified tournament from storage.
     *
     * @param  \App\Models\Tournament  $tournament (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tournament $tournament)
    {
        DB::transaction(function () use ($tournament) {
            // Delete related rules
            $tournament->rules()->delete();
            // Detach all associated sponsors
            $tournament->sponsors()->detach();
            // Delete related registrations (ensure this cascades if necessary or manually handle related team/members if they are only related to this registration)
            $tournament->registrations()->delete(); // This assumes registrations can be deleted without further cascades.

            if ($tournament->thumbnail) {
                Storage::disk('public')->delete($tournament->thumbnail);
            }

            $tournament->delete(); // Delete the main tournament
        });

        return redirect()->route('admin.tournaments.index')->with('success', 'Turnamen berhasil dihapus.');
    }
}
