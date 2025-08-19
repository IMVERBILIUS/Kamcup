<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Tournament;
// TAMBAHKAN MODEL-MODEL YANG DIBUTUHKAN
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan form donasi.
     */
    public function create()
    {
        $tournaments = Tournament::orderBy('title', 'asc')->get();
        return view('donations.create', compact('tournaments'));
    }

    /**
     * Menyimpan data donasi baru.
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'name_brand' => 'required|string|max:255',
            'phone_whatsapp' => 'required|string|max:20',
            'tournament_id' => 'required|integer|exists:tournaments,id',
            'donation_type' => 'required|in:sponsor,donatur',
            'sponsor_type' => 'nullable|string|max:50|required_if:donation_type,sponsor',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = Auth::user();
            $tournament = Tournament::find($request->tournament_id);
            
            $data = $request->except('tournament_id');
            $data['user_id'] = $user->id;
            $data['email'] = $user->email;
            $data['event_name'] = $tournament ? $tournament->title : 'Unknown Event';

            Donation::create($data);

            return redirect()->back()->with('success', 
                'Terima kasih! Pengajuan sponsorship/donasi Anda telah berhasil dikirim.'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses permintaan Anda.')->withInput();
        }
    }

    /**
     * Menampilkan semua donasi (untuk admin).
     * !! FUNGSI INI YANG DIPERBAIKI SECARA KESELURUHAN !!
     */
    public function index(Request $request)
    {
        // 1. Logika untuk data donasi (tetap sama)
        $query = Donation::with('user');
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        if ($request->has('type') && $request->type) {
            $query->where('donation_type', $request->type);
        }
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
        $donations = $query->orderBy('created_at', 'desc')->paginate(20);

        // 2. Tambahkan semua data lain yang dibutuhkan oleh view 'index.blade.php'
        $next_match = Tournament::where('registration_start', '>=', now())
                                ->orderBy('registration_start', 'asc')
                                ->first();
        
        $latest_articles = Article::latest()->take(5)->get();
        // Asumsi ada kolom 'views' untuk populer, jika tidak ada ganti dengan 'created_at'
        $populer_articles = Article::orderBy('views', 'desc')->take(5)->get(); 
        
        $events = Tournament::where('status', '!=', 'completed')
                            ->orderBy('registration_start', 'asc')
                            ->take(5)
                            ->get();

        $galleries = Gallery::latest()->take(10)->get();
        $sponsorData = Sponsor::all()->groupBy('size');
        $chunk_size = 3; // Ukuran untuk carousel

        // 3. Kirim SEMUA data ke view
        return view('donations.index', compact(
            'donations', 
            'next_match',
            'latest_articles',
            'populer_articles',
            'events',
            'galleries',
            'sponsorData',
            'chunk_size'
        ));
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
        $donation->update($request->only('status', 'admin_notes'));
        return redirect()->back()->with('success', 'Status donasi berhasil diperbarui.');
    }
    
    // ... SISA FUNGSI LAINNYA (statistics, export, dll) TETAP SAMA ...
    
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
            fputcsv($file, ['ID', 'User ID', 'Nama/Brand', 'Email', 'WhatsApp', 'Event', 'Jenis', 'Sponsor Type', 'Status', 'Tanggal']);
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->id, $donation->user_id, $donation->name_brand, $donation->email, $donation->phone_whatsapp,
                    $donation->event_name, ucfirst($donation->donation_type), $donation->sponsor_type ?? '-',
                    ucfirst($donation->status), $donation->created_at->format('d/m/Y H:i')
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}