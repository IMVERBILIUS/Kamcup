<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TournamentRegistration;
use App\Models\TournamentHostRequest;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Jumlah item per halaman untuk masing-masing bagian
        $perPageRegistered = 5; // Tetap 5 untuk Event Saya
        $perPageHost = 3;       // Diubah menjadi 3 untuk Permohonan Tuan Rumah

        // Dapatkan nomor halaman saat ini dari request query
        $pageRegistered = $request->query('page_registered', 1);
        $pageHost = $request->query('page_host', 1);

        // Eager load semua relasi yang dibutuhkan
        $user->load([
            'profile',
            'team.members',
            'registeredTournaments.tournament',
            'hostApplications'
        ]);

        // Inisialisasi variabel untuk view
        $hasTeam = false;
        $firstTeam = null;
        $teamMembers = collect();

        if ($user->team) {
            $hasTeam = true;
            $firstTeam = $user->team;
            $teamMembers = $user->team->members;
        }

        // --- Paginasi Manual untuk registeredTournaments ---
        $allRegisteredTournaments = $user->registeredTournaments ?? collect();
        $registeredTournaments = new \Illuminate\Pagination\LengthAwarePaginator(
            $allRegisteredTournaments->forPage($pageRegistered, $perPageRegistered),
            $allRegisteredTournaments->count(),
            $perPageRegistered,
            $pageRegistered,
            ['path' => route('profile.index', ['page_host' => $pageHost, 'active_tab' => 'event-saya']), 'pageName' => 'page_registered']
        );

        // --- Paginasi Manual untuk hostApplications ---
        $allHostApplications = $user->hostApplications ?? collect();
        $hostApplications = new \Illuminate\Pagination\LengthAwarePaginator(
            $allHostApplications->forPage($pageHost, $perPageHost), // Menggunakan $perPageHost
            $allHostApplications->count(),
            $perPageHost, // Menggunakan $perPageHost
            $pageHost,
            ['path' => route('profile.index', ['page_registered' => $pageRegistered, 'active_tab' => 'permohonan']), 'pageName' => 'page_host']
        );

        return view('front.profile.profile', compact(
            'user',
            'hasTeam',
            'firstTeam',
            'teamMembers',
            'registeredTournaments',
            'hostApplications'
        ));
    }

    /**
     * Show the form for editing the user's basic profile information.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $user->load('profile');

        return view('front.profile.edit', compact('user'));
    }

    /**
     * Update the user's basic profile information.
     *
     * @param   \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'nullable|date|before_or_equal:today',
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'phone_number' => 'nullable|string|max:255',
            'social_media' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'clear_profile_photo' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            if ($user->name !== $request->name) {
                $user->name = $request->name;
                $user->save();
            }

            $profile = $user->profile ?? new Profile();
            $profile->user_id = $user->id;

            $profile->name = $request->name;
            $profile->birthdate = $request->birthdate;
            $profile->gender = $request->gender;
            $profile->phone_number = $request->phone_number;
            $profile->social_media = $request->social_media;

            if ($request->hasFile('profile_photo')) {
                if ($profile->profile_photo && Storage::disk('public')->exists($profile->profile_photo)) {
                    Storage::disk('public')->delete($profile->profile_photo);
                }
                $profile->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
            } elseif ($request->boolean('clear_profile_photo')) {
                if ($profile->profile_photo && Storage::disk('public')->exists($profile->profile_photo)) {
                    Storage::disk('public')->delete($profile->profile_photo);
                }
                $profile->profile_photo = null;
            }

            $user->profile()->save($profile);

            DB::commit();

            return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating profile: " . $e->getMessage(), ['user_id' => $user->id, 'request_data' => $request->except('profile_photo')]);
            return back()->withInput()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
