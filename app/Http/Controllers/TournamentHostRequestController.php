<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TournamentHostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
// use App\Models\User; // You don't need to import User model here unless you directly query it for something

class TournamentHostRequestController extends Controller
{
    // ===== USER: Tampilkan form request
    public function create()
    {
        // Pastikan view ini ada: resources/views/host_request/create.blade.php
        return view('host_request.create');
    }

    // ===== USER: Simpan permintaan host
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'responsible_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20', // Sesuaikan max length jika perlu
            'tournament_title' => 'required|string|max:255',
            'venue_name' => 'required|string|max:255',
            'venue_address' => 'required|string',
            'estimated_capacity' => 'nullable|integer|min:0', // 'nullable' karena opsional
            'proposed_date' => 'required|date',
            'available_facilities' => 'nullable|string', // 'nullable' karena opsional
            'notes' => 'nullable|string', // 'nullable' karena opsional
        ]);

        try {
            TournamentHostRequest::create([
                'user_id' => Auth::id(), // ID pengguna yang sedang login
                'responsible_name' => $validatedData['responsible_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'tournament_title' => $validatedData['tournament_title'],
                'venue_name' => $validatedData['venue_name'],
                'venue_address' => $validatedData['venue_address'],
                'estimated_capacity' => $validatedData['estimated_capacity'] ?? null, // Gunakan null jika tidak diisi
                'proposed_date' => $validatedData['proposed_date'],
                'available_facilities' => $validatedData['available_facilities'] ?? null, // Gunakan null jika tidak diisi
                'notes' => $validatedData['notes'] ?? null, // Gunakan null jika tidak diisi
                'status' => 'pending', // Status awal selalu pending
                'rejection_reason' => null, // Tidak ada alasan penolakan saat baru dibuat
            ]);

            return redirect()->route('redirect.dashboard')->with('success', 'Permintaan Anda untuk menjadi tuan rumah turnamen telah berhasil diajukan!');

        } catch (\Exception $e) {
            Log::error('Error submitting tournament host request: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan permintaan. Mohon coba lagi.');
        }
    }

    // ===== ADMIN: Lihat semua request
    public function index()
    {
        // Menggunakan latest() untuk mengurutkan dari yang terbaru
        $hostRequests = TournamentHostRequest::with('user')->latest()->paginate(10);
        // Pastikan view ini ada: resources/views/admin/host-requests/index.blade.php
        return view('host-requests.index', compact('hostRequests'));
    }

    // ===== ADMIN: Detail request
    public function show($id)
    {
        $request = TournamentHostRequest::with('user')->findOrFail($id);
        // Pastikan view ini ada: resources/views/admin/host-requests/show.blade.php
        return view('host-requests.show', compact('request'));
    }

    // ===== ADMIN: Approve request
    public function approve($id)
    {
        try {
            $request = TournamentHostRequest::findOrFail($id);

            if ($request->status === 'pending') {
                $request->status = 'approved';
                $request->rejection_reason = null; // Hapus alasan penolakan jika disetujui
                $request->save();

                // Tambahkan logika lain di sini setelah disetujui, seperti:
                // - Membuat entri turnamen baru di tabel 'tournaments' berdasarkan data request ini.
                // - Mengirim notifikasi email ke pengguna yang mengajukan bahwa permintaan mereka disetujui.

                return redirect()->route('admin.host-requests.index')->with('success', 'Permintaan tuan rumah turnamen telah disetujui.');
            } else {
                return redirect()->route('admin.host-requests.index')->with('error', 'Permintaan tidak dapat disetujui. Status bukan "pending".');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.host-requests.index')->with('error', 'Permintaan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error approving tournament host request (ID: ' . $id . '): ' . $e->getMessage());
            return redirect()->route('admin.host-requests.index')->with('error', 'Gagal menyetujui permintaan. Mohon coba lagi.');
        }
    }

    // ===== ADMIN: Reject request
    public function reject(Request $request, $id)
    {
        $validatedData = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000', // Alasan penolakan minimal 10 karakter
        ]);

        try {
            $hostRequest = TournamentHostRequest::findOrFail($id);

            if ($hostRequest->status === 'pending') {
                $hostRequest->status = 'rejected';
                $hostRequest->rejection_reason = $validatedData['rejection_reason'];
                $hostRequest->save();

                // Tambahkan logika lain di sini setelah ditolak, seperti:
                // - Mengirim notifikasi email ke pengguna yang ditolak beserta alasannya.

                return redirect()->route('admin.host-requests.index')->with('success', 'Permintaan tuan rumah turnamen telah ditolak.');
            } else {
                return redirect()->route('admin.host-requests.index')->with('error', 'Permintaan tidak dapat ditolak. Status bukan "pending".');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.host-requests.index')->with('error', 'Permintaan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error rejecting tournament host request (ID: ' . $id . '): ' . $e->getMessage());
            return redirect()->route('admin.host-requests.index')->with('error', 'Gagal menolak permintaan. Mohon coba lagi.');
        }
    }
}
