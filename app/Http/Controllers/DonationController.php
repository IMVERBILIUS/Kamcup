<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Constructor - Tambah middleware auth
     * Hanya user yang sudah login yang bisa akses semua method
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan form donasi.
     * Mengirim data turnamen ke view.
     */
    public function create()
    {
        // Ambil data dari tabel tournaments
        $tournaments = Tournament::orderBy('title', 'asc')->get();
        
        // Kirim data ke view
        return view('donations.create', compact('tournaments'));
    }

    /**
     * Menyimpan data donasi baru.
     */
    public function store(Request $request)
    {
        // Validasi - nama bisa diisi bebas, email tetap dari akun
        $validator = Validator::make($request->all(), [
            'name_brand' => 'required|string|max:255',
            'phone_whatsapp' => 'required|string|max:20',
            'tournament_id' => 'required|integer|exists:tournaments,id', 
            'donation_type' => 'required|in:sponsor,donatur',
            'sponsor_type' => 'nullable|string|max:50|required_if:donation_type,sponsor',
            'message' => 'nullable|string|max:1000',
        ], [
            'name_brand.required' => 'Nama/Brand wajib diisi.',
            'name_brand.max' => 'Nama/Brand maksimal 255 karakter.',
            'phone_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'tournament_id.required' => 'Pilih acara/pertandingan.',
            'tournament_id.exists' => 'Acara/pertandingan yang dipilih tidak valid.',
            'donation_type.required' => 'Pilih jenis pendanaan.',
            'donation_type.in' => 'Jenis pendanaan harus sponsor atau donatur.',
            'sponsor_type.required_if' => 'Jenis sponsor wajib dipilih jika jenis pendanaan adalah sponsor.',
            'message.max' => 'Pesan maksimal 1000 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil data user yang login
            $user = Auth::user();
            
            // Olah data sebelum disimpan
            $data = $request->except('tournament_id');

            // Cari nama turnamen berdasarkan ID yang dikirim dari form
            $tournament = Tournament::find($request->tournament_id);
            
            // Tambahkan data dari user login dan tournament
            $data['user_id'] = $user->id;
            // name_brand sudah ada dari request, tidak perlu diubah
            $data['email'] = $user->email; // EMAIL TETAP DARI AKUN LOGIN
            $data['event_name'] = $tournament ? $tournament->title : 'Unknown Event';

            // Simpan data yang sudah diolah
            $donation = Donation::create($data);

            // Kirim notifikasi email (opsional)
            // $this->sendNotificationEmail($donation);

            return redirect()->back()->with('success', 
                'Terima kasih! Pengajuan sponsorship/donasi Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.'
            );

        } catch (\Exception $e) {
            // Catat error jika perlu: \Log::error($e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Menampilkan semua donasi (untuk admin).
     */
    public function index(Request $request)
    {
        $query = Donation::with('user');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by donation type
        if ($request->has('type') && $request->type) {
            $query->where('donation_type', $request->type);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_brand', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('event_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $donations = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('donations.index', compact('donations'));
    }

    /**
     * Menampilkan detail donasi.
     */
    public function show(Donation $donation)
    {
        $donation->load('user');
        return view('donations.show', compact('donation'));
    }

    /**
     * Memperbarui status donasi.
     */
    public function updateStatus(Request $request, Donation $donation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $donation->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        // Kirim email notifikasi ke pendaftar
        // $this->sendStatusUpdateEmail($donation);

        return redirect()->back()->with('success', 'Status donasi berhasil diperbarui.');
    }

    /**
     * Get donation statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => Donation::count(),
            'pending' => Donation::where('status', 'pending')->count(),
            'approved' => Donation::where('status', 'approved')->count(),
            'sponsors' => Donation::where('donation_type', 'sponsor')->count(),
            'donatur' => Donation::where('donation_type', 'donatur')->count(),
            'this_month' => Donation::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()
        ];

        return response()->json($stats);
    }

    /**
     * Export donations to CSV
     */
    public function export()
    {
        $donations = Donation::with('user')->orderBy('created_at', 'desc')->get();

        $filename = 'donations_' . now()->format('Y_m_d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'ID', 'User ID', 'Nama/Brand', 'Email', 'WhatsApp', 'Event', 
                'Jenis', 'Sponsor Type', 'Status', 'Tanggal'
            ]);

            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->id,
                    $donation->user_id,
                    $donation->name_brand,
                    $donation->email,
                    $donation->phone_whatsapp,
                    $donation->event_name,
                    ucfirst($donation->donation_type),
                    $donation->sponsor_type ?? '-',
                    ucfirst($donation->status),
                    $donation->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function sendNotificationEmail($donation)
    {
        // Implementasi logika pengiriman email
    }

    private function sendStatusUpdateEmail($donation)
    {
        // Implementasi logika pengiriman email update status
    }
}
