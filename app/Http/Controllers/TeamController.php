<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Team;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeamController extends Controller
{
    /**
     * Tampilkan formulir untuk membuat tim baru.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat tim.');
        }

        // --- PERUBAHAN DI SINI: Gunakan team() (tunggal) ---
        // Cek apakah user sudah memiliki tim. Jika ya, redirect ke profil.
        if (Auth::user()->team) { // Cek langsung apakah relasi team() mengembalikan objek
            return redirect()->route('profile.index')->with('info', 'Anda sudah memiliki tim. Anda hanya dapat membuat satu tim.');
        }

        return view('front.teams.create');
    }

    /**
     * Simpan tim yang baru dibuat ke penyimpanan (database).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat tim.');
        }

        // --- PERUBAHAN DI SINI: Gunakan team() (tunggal) ---
        // Cek apakah user sudah memiliki tim. Jika ya, redirect ke profil.
        if (Auth::user()->team) { // Cek langsung apakah relasi team() mengembalikan objek
            return redirect()->route('profile.index')->with('info', 'Anda sudah memiliki tim. Anda tidak dapat membuat tim lagi.');
        }

        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'name' => ['required', 'string', 'max:255', 'unique:teams,name'],
            'manager_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'gender_category' => ['required', Rule::in(['male', 'female', 'mixed'])],
            'member_count' => ['required', 'integer', 'min:1', 'max:10'],
            'description' => ['nullable', 'string'],
        ], [
            'logo.required' => 'Logo tim wajib diunggah.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo yang diizinkan adalah jpeg, png, jpg, atau gif.',
            'logo.max' => 'Ukuran logo tidak boleh melebihi 2MB.',
            'name.required' => 'Nama tim wajib diisi.',
            'name.unique' => 'Nama tim ini sudah digunakan. Mohon gunakan nama lain.',
            'gender_category.required' => 'Kategori gender tim wajib dipilih.',
            'gender_category.in' => 'Kategori gender tim tidak valid.',
            'member_count.required' => 'Jumlah anggota tim wajib diisi.',
            'member_count.integer' => 'Jumlah anggota tim harus berupa angka.',
            'member_count.min' => 'Jumlah anggota tim minimal 1.',
            'member_count.max' => 'Jumlah anggota tim maksimal 10.',
            'manager_name.required' => 'Nama manajer wajib diisi.',
            'contact.required' => 'Informasi kontak tim wajib diisi.',
            'location.required' => 'Lokasi tim wajib diisi.',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('team_logos', 'public');
        }

        $team = Team::create([
            'user_id' => Auth::id(),
            'logo' => $logoPath,
            'name' => $request->name,
            'manager_name' => $request->manager_name,
            'contact' => $request->contact,
            'location' => $request->location,
            'gender_category' => $request->gender_category,
            'member_count' => $request->member_count,
            'description' => $request->description,
        ]);

        return redirect()->route('profile.index')->with('success', 'Tim "' . $team->name . '" berhasil dibuat!');
    }

    /**
     * Tampilkan formulir untuk mengedit tim yang ada.
     *
     * @param  string  $encryptedId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(string $encryptedId)
    {
        try {
            $teamId = Crypt::decryptString($encryptedId);
            $team = Team::findOrFail($teamId);
        } catch (DecryptException $e) {
            return redirect()->route('profile.index')->with('error', 'Link pengeditan tim tidak valid.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('profile.index')->with('error', 'Tim yang ingin diedit tidak ditemukan.');
        }

        if (Auth::id() !== $team->user_id) {
            return redirect()->route('profile.index')->with('error', 'Anda tidak memiliki izin untuk mengedit tim ini.');
        }

        return view('front.teams.edit', compact('team'));
    }

    /**
     * Perbarui tim yang ada di penyimpanan (database).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $encryptedId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $encryptedId)
    {
        try {
            $teamId = Crypt::decryptString($encryptedId);
            $team = Team::findOrFail($teamId);
        } catch (DecryptException $e) {
            return redirect()->route('profile.index')->with('error', 'Link pembaruan tim tidak valid.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('profile.index')->with('error', 'Tim yang ingin diperbarui tidak ditemukan.');
        }

        if (Auth::id() !== $team->user_id) {
            return redirect()->route('profile.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui tim ini.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('teams')->ignore($team->id)],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'manager_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'gender_category' => ['required', Rule::in(['male', 'female', 'mixed'])],
            'member_count' => ['required', 'integer', 'min:1', 'max:10'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama tim wajib diisi.',
            'name.unique' => 'Nama tim ini sudah digunakan oleh tim lain. Mohon gunakan nama yang berbeda.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo yang diizinkan adalah jpeg, png, jpg, atau gif.',
            'logo.max' => 'Ukuran logo tidak boleh melebihi 2MB.',
            'gender_category.required' => 'Kategori gender tim wajib dipilih.',
            'gender_category.in' => 'Kategori gender tim tidak valid.',
            'member_count.required' => 'Jumlah anggota tim wajib diisi.',
            'member_count.integer' => 'Jumlah anggota tim harus berupa angka.',
            'member_count.min' => 'Jumlah anggota tim minimal 1.',
            'member_count.max' => 'Jumlah anggota tim maksimal 10.',
            'manager_name.required' => 'Nama manajer wajib diisi.',
            'contact.required' => 'Informasi kontak tim wajib diisi.',
            'location.required' => 'Lokasi tim wajib diisi.',
        ]);

        $logoPath = $team->logo;
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($team->logo && Storage::disk('public')->exists($team->logo)) {
                Storage::disk('public')->delete($team->logo);
            }
            $logoPath = $request->file('logo')->store('team_logos', 'public');
        }

        $team->update([
            'logo' => $logoPath,
            'name' => $request->name,
            'manager_name' => $request->manager_name,
            'contact' => $request->contact,
            'location' => $request->location,
            'gender_category' => $request->gender_category,
            'member_count' => $request->member_count,
            'description' => $request->description,
        ]);

        return redirect()->route('profile.index')->with('success', 'Tim "' . $team->name . '" berhasil diperbarui!');
    }

    /**
     * Delete the specified team from storage.
     *
     * @param string $encryptedId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $encryptedId)
    {
        try {
            $teamId = Crypt::decryptString($encryptedId);
            $team = Team::findOrFail($teamId);
        } catch (DecryptException $e) {
            return redirect()->route('profile.index')->with('error', 'Link penghapusan tim tidak valid.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('profile.index')->with('error', 'Tim yang ingin dihapus tidak ditemukan.');
        }

        if (Auth::id() !== $team->user_id) {
            return redirect()->route('profile.index')->with('error', 'Anda tidak memiliki izin untuk menghapus tim ini.');
        }

        // Delete associated team members
        $team->members()->delete();

        // Delete logo file if exists
        if ($team->logo && Storage::disk('public')->exists($team->logo)) {
            Storage::disk('public')->delete($team->logo);
        }

        $teamName = $team->name; // Store name before deleting for the message
        $team->delete();

        return redirect()->route('profile.index')->with('success', 'Tim "' . $teamName . '" dan semua anggotanya berhasil dihapus.');
    }
}
