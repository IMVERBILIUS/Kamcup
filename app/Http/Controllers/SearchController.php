<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $results = collect();
        
        if ($query && strlen(trim($query)) >= 2) {
            // Search Articles - hanya kolom yang pasti ada
            $articles = Article::where('status', 'published')
                ->where('title', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($article) {
                    return [
                        'type' => 'article',
                        'title' => $article->title,
                        'description' => $article->description ?? '',
                        'url' => route('front.articles.show', $article->slug),
                        'image' => $article->thumbnail ? asset('storage/' . $article->thumbnail) : null,
                        'date' => $article->created_at->format('d M Y'),
                        'category' => 'Berita'
                    ];
                });

            // Search Events/Tournaments - gunakan model Event atau Tournament
            try {
                // Gunakan tabel tournaments langsung dengan kolom yang pasti ada
                $events = \DB::table('tournaments')
                    ->where('status', '!=', 'draft')
                    ->where('title', 'LIKE', "%{$query}%")
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get()
                    ->map(function ($event) {
                        return [
                            'type' => 'event',
                            'title' => $event->title,
                            'description' => $event->description ?? 'Event KAMCUP',
                            'url' => route('front.events.show', $event->slug),
                            'image' => $event->thumbnail ? asset('storage/' . $event->thumbnail) : null,
                            'date' => \Carbon\Carbon::parse($event->registration_start ?? $event->created_at)->format('d M Y'),
                            'category' => 'Event',
                            'location' => $event->location ?? '',
                            'status' => ucfirst($event->status ?? 'active')
                        ];
                    });
            } catch (\Exception $e) {
                // Jika ada error dengan tournaments, skip saja
                $events = collect();
            }

            // Search Galleries - hanya kolom yang pasti ada
            $galleries = Gallery::where('status', 'published')
                ->where('title', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($gallery) {
                    return [
                        'type' => 'gallery',
                        'title' => $gallery->title,
                        'description' => $gallery->description ?? '',
                        'url' => route('front.galleries.show', $gallery->slug),
                        'image' => $gallery->thumbnail ? asset('storage/' . $gallery->thumbnail) : null,
                        'date' => $gallery->created_at->format('d M Y'),
                        'category' => 'Galeri'
                    ];
                });

            // Combine all results
            $results = $articles->concat($events)->concat($galleries);
        }

        return view('front.search', [
            'query' => $query,
            'results' => $results,
            'total_results' => $results->count()
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('q');
        $suggestions = collect();
        
        if ($query && strlen(trim($query)) >= 2) {
            // Get article titles
            $articles = Article::where('status', 'published')
                ->where('title', 'LIKE', "%{$query}%")
                ->limit(5)
                ->pluck('title');

            // Get event titles
            $events = Event::where('status', '!=', 'draft')
                ->where('title', 'LIKE', "%{$query}%")
                ->limit(5)
                ->pluck('title');

            // Get gallery titles
            $galleries = Gallery::where('status', 'published')
                ->where('title', 'LIKE', "%{$query}%")
                ->limit(5)
                ->pluck('title');

            $suggestions = $articles->concat($events)->concat($galleries)->unique()->take(10);
        }

        return response()->json($suggestions);
    }
}