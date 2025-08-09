<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Visit;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        // Ambil semua artikel dan galeri (opsional)
        $articles = Article::all();
        $galleries = Gallery::all();

        // Statistik kunjungan umum
        $today = Visit::whereDate('visited_at', Carbon::today())->count();
        $week = Visit::whereBetween('visited_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $month = Visit::whereMonth('visited_at', Carbon::now()->month)->count();
        $year = Visit::whereYear('visited_at', Carbon::now()->year)->count();

        // URL yang dianggap sebagai homepage
        $homepageUrls = ['https://kamcup.com', 'https://kamcup.com/']; // Changed from kersa.id

        // Statistik kunjungan per halaman (Homepage)
        $homeVisitToday = Visit::whereIn('url', $homepageUrls)
            ->whereDate('visited_at', Carbon::today())
            ->count();

        $homeVisitWeek = Visit::whereIn('url', $homepageUrls)
            ->whereBetween('visited_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $homeVisitMonth = Visit::whereIn('url', $homepageUrls)
            ->whereMonth('visited_at', Carbon::now()->month)
            ->count();

        $homeVisitYear = Visit::whereIn('url', $homepageUrls)
            ->whereYear('visited_at', Carbon::now()->year)
            ->count();

        // Statistik total berdasarkan halaman
        $homeVisit = Visit::whereIn('url', $homepageUrls)->count();
        $articleVisit = Visit::where('url', 'https://kamcup.com/articles')->count(); // Changed from kersa.id
        $galleryVisit = Visit::where('url', 'https://kamcup.com/galleries')->count(); // Changed from kersa.id
        $contactVisit = Visit::where('url', 'https://kamcup.com/contact')->count(); // Changed from kersa.id

        // Siapkan data untuk Chart.js
        $visitData = [
            'Homepage' => $homeVisit,
            'Articles' => $articleVisit,
            'Galleries' => $galleryVisit,
            'Contact' => $contactVisit,
        ];

        // Kirim semua data ke blade
        return view('dashboard.admin', compact(
            'articles', 'galleries',
            'today', 'week', 'month', 'year',
            'homeVisitToday', 'homeVisitWeek', 'homeVisitMonth', 'homeVisitYear',
            'homeVisit',
            'articleVisit', 'galleryVisit', 'contactVisit'
        ))->with('visitData', $visitData);
    }
}
