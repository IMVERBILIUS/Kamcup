<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Don't forget to import Log for error handling

class SponsorController extends Controller
{
    // Tampilkan daftar sponsor
    public function index()
    {
        // Default sort behavior, similar to TournamentController
        $sort = request()->query('sort', 'name'); // Default sort by name

        $query = Sponsor::query();

        switch ($sort) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'sponsor_size':
                // Assuming you want to sort by custom order for sizes if they're not alphabetical
                // Otherwise, 'asc' would be fine. If you have a defined order, you might use a custom sort.
                // For simplicity, we'll sort alphabetically by size string.
                $query->orderBy('sponsor_size', 'asc');
                break;
            default:
                $query->orderBy('name', 'asc'); // Fallback
                break;
        }

        $sponsors = $query->paginate(10)->withQueryString(); // Maintain query string for pagination
        return view('sponsors.index', compact('sponsors')); // Changed to 'sponsors.index' for consistency with resource routing
    }

    // Tampilkan form tambah sponsor baru
    public function create()
    {
        return view('sponsors.create');
    }

    // Simpan sponsor baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // --- PERUBAHAN DI SINI UNTUK LOGO: required dan mimes ---
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // Logo WAJIB saat membuat
            // --------------------------------------------------------
            'sponsor_size' => 'required|in:xxl,xl,l,m,s',
            'description' => 'nullable|string',
        ]);

        try {
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('sponsors', 'public');
            }

            $sponsor = new Sponsor();
            $sponsor->name = $request->name;
            $sponsor->sponsor_size = $request->sponsor_size;
            $sponsor->description = $request->description;
            $sponsor->logo = $logoPath; // Set the path

            // Asumsi order_number diisi otomatis di model melalui Observer atau boot() method
            // Jika tidak, Anda perlu menambahkannya di sini, misal:
            // $sponsor->order_number = Sponsor::max('order_number') + 1;

            $sponsor->save();

            return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Error creating sponsor: " . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Gagal menambahkan sponsor: ' . $e->getMessage());
        }
    }

    // Tampilkan form edit sponsor
    // Menggunakan Route Model Binding (berdasarkan ID secara default untuk resource route)
    public function edit(Sponsor $sponsor) // Parameter diubah dari $id menjadi Sponsor $sponsor
    {
        return view('sponsors.edit', compact('sponsor'));
    }

    // Update data sponsor di database
    // Menggunakan Route Model Binding
    public function update(Request $request, Sponsor $sponsor) // Parameter diubah dari $id menjadi Sponsor $sponsor
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // --- PERUBAHAN DI SINI UNTUK LOGO: nullable dan mimes, tambahkan clear_logo ---
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Logo opsional saat update
            'clear_logo' => 'nullable|boolean', // Untuk checkbox hapus logo
            // -----------------------------------------------------------------------------
            'sponsor_size' => 'required|in:xxl,xl,l,m,s',
            'description' => 'nullable|string',
        ]);

        try {
            $sponsor->name = $request->name;
            $sponsor->sponsor_size = $request->sponsor_size;
            $sponsor->description = $request->description;

            // Logika untuk mengelola logo
            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada
                if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo)) {
                    Storage::disk('public')->delete($sponsor->logo);
                }
                $path = $request->file('logo')->store('sponsors', 'public');
                $sponsor->logo = $path;
            } else if ($request->boolean('clear_logo')) { // Jika checkbox 'clear_logo' dicentang
                if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo)) {
                    Storage::disk('public')->delete($sponsor->logo);
                }
                $sponsor->logo = null; // Set logo menjadi null di DB
            }
            // Jika tidak ada file baru dan 'clear_logo' tidak dicentang, logo lama akan tetap ada

            $sponsor->save();

            return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating sponsor: " . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Gagal memperbarui sponsor: ' . $e->getMessage());
        }
    }

    // Hapus sponsor
    // Menggunakan Route Model Binding
    public function destroy(Sponsor $sponsor) // Parameter diubah dari $id menjadi Sponsor $sponsor
    {
        try {
            if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo)) {
                Storage::disk('public')->delete($sponsor->logo);
            }

            $sponsor->delete();

            return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error deleting sponsor: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Gagal menghapus sponsor: ' . $e->getMessage());
        }
    }
}
