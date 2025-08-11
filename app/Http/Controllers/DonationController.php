<?php
// app/Http/Controllers/DonationController.php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class DonationController extends Controller
{
    /**
     * Display the donation form
     */
    public function create()
    {
        return view('donations.create');
    }

    /**
     * Store a newly created donation in storage
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_brand' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_whatsapp' => 'required|string|max:20',
            'event_name' => 'required|string|max:255',
            'donation_type' => 'required|in:sponsor,donatur',
            'sponsor_type' => 'nullable|string|max:50|required_if:donation_type,sponsor',
            'message' => 'nullable|string|max:1000',
        ], [
            'name_brand.required' => 'Nama/Brand wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'phone_whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'event_name.required' => 'Pilih acara/pertandingan',
            'donation_type.required' => 'Pilih jenis pendanaan',
            'donation_type.in' => 'Jenis pendanaan harus sponsor atau donatur',
            'sponsor_type.required_if' => 'Jenis sponsor wajib dipilih untuk pendanaan sponsor',
            'message.max' => 'Pesan maksimal 1000 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create donation record
            $donation = Donation::create($request->all());

            // Send notification email (optional)
            // $this->sendNotificationEmail($donation);

            return redirect()->back()->with('success', 
                'Terima kasih! Pengajuan sponsorship/donasi Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.'
            );

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Display all donations (admin)
     */
    public function index(Request $request)
    {
        $query = Donation::query();

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
                  ->orWhere('event_name', 'like', "%{$search}%");
            });
        }

        $donations = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('donations.index', compact('donations'));
    }

    /**
     * Display the specified donation
     */
    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    /**
     * Update donation status
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

        // Send email notification to applicant
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
            'pending' => Donation::pending()->count(),
            'approved' => Donation::approved()->count(),
            'sponsors' => Donation::sponsors()->count(),
            'donatur' => Donation::donatur()->count(),
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
        $donations = Donation::orderBy('created_at', 'desc')->get();

        $filename = 'donations_' . now()->format('Y_m_d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID', 'Nama/Brand', 'Email', 'WhatsApp', 'Event', 
                'Jenis', 'Sponsor Type', 'Status', 'Tanggal'
            ]);

            // CSV Data
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->id,
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

    /**
     * Send notification email (implement as needed)
     */
    private function sendNotificationEmail($donation)
    {
        // Implement email notification logic
        // Mail::to($donation->email)->send(new DonationReceived($donation));
        // Mail::to('admin@kamcup.com')->send(new NewDonationNotification($donation));
    }

    /**
     * Send status update email (implement as needed)
     */
    private function sendStatusUpdateEmail($donation)
    {
        // Implement status update email logic
        // Mail::to($donation->email)->send(new DonationStatusUpdate($donation));
    }
}