<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gallery;
use App\Models\Tournament;
use App\Models\Sponsor;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TournamentRegistration;
use App\Models\VolleyMatch; // TAMBAHAN BARU
use App\Services\RankingService; // TAMBAHAN BARU
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Artikel terbaru
        $latest_articles = Article::where('status', 'Published')
                                    ->orderBy('created_at', 'desc')
                                    ->take(6)
                                    ->get();

        // Artikel populer (DIPERBAIKI: nama variabel konsisten dengan view)
        $popular_articles = Article::where('status', 'Published')
                                    ->orderBy('views', 'desc')
                                    ->take(6)
                                    ->get();

        // Jika tidak ada artikel dengan views, gunakan artikel terbaru sebagai fallback
        if ($popular_articles->isEmpty()) {
            $popular_articles = Article::where('status', 'Published')
                                      ->orderBy('created_at', 'desc')
                                      ->offset(3) // skip 3 artikel pertama agar berbeda dengan latest
                                      ->take(6)
                                      ->get();
        }

        // Chunk size berdasarkan device
        $chunk_size = (Agent::isMobile()) ? 1 : 3;

        // Galleries
        $galleries = Gallery::where('status', 'published')
                           ->orderBy('created_at', 'desc')
                           ->take(8)
                           ->get();

        // Events (DIPERBAIKI: konsisten dengan nama model Tournament)
        $events = Tournament::with('sponsors')
                           ->where('visibility_status', 'Published')
                           ->orderBy('created_at', 'desc')
                           ->take(6)
                           ->get();

        // Sponsors
        $sponsors = Sponsor::orderBy('order_number')->get();
        $sponsorData = $sponsors->groupBy('sponsor_size');

        // Next match terdekat berdasarkan tanggal pertandingan
        $next_match = VolleyMatch::with(['tournament', 'team1', 'team2'])
                                 ->whereHas('tournament', function($query) {
                                     $query->where('visibility_status', 'Published');
                                 })
                                 ->where('match_datetime', '>=', now())
                                 ->whereIn('status', ['scheduled', 'in-progress'])
                                 ->orderBy('match_datetime', 'asc')
                                 ->first();

        // TAMBAHAN BARU: Last match terbaru yang sudah completed
        $last_match = VolleyMatch::with(['tournament', 'team1', 'team2', 'winner'])
                                 ->whereHas('tournament', function($query) {
                                     $query->where('visibility_status', 'Published');
                                 })
                                 ->where('status', 'completed')
                                 ->orderBy('match_datetime', 'desc')
                                 ->first();

        // DIPERBAIKI: nama variabel konsisten dengan view
        return view('front.index', compact(
            'latest_articles',
            'popular_articles',  // CHANGED: dari 'populer_articles' ke 'popular_articles'
            'chunk_size',
            'galleries',
            'events',
            'sponsorData',
            'next_match',
            'last_match' // TAMBAHAN BARU
        ));
    }

    /**
     * Display the articles listing page with filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function articles(Request $request)
    {
        // Konsisten dengan penamaan di index method
        $popular_articles = Article::where('status', 'Published')
                                   ->orderBy('views', 'desc')
                                   ->take(3)
                                   ->get();

        $filter = $request->input('filter', 'latest');

        $articles = Article::where('status', 'Published');

        switch ($filter) {
            case 'popular':
                $articles->orderBy('views', 'desc');
                break;
            case 'author':
                $articles->orderBy('author', 'asc');
                break;
            case 'latest':
            default:
                $articles->orderBy('created_at', 'desc');
                break;
        }

        $articles = $articles->paginate(6)->withQueryString();

        // CHANGED: nama variabel konsisten
        return view('front.articles', compact('articles', 'popular_articles', 'filter'));
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('front.contact');
    }

    /**
     * Display a single article's details using slug for cleaner URLs.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function showArticle(Article $article)
    {
        $article->increment('views');
        $article->load(['subheadings.paragraphs', 'comments']);
        return view('front.article_show', compact('article'));
    }

    /**
     * Display the galleries listing page with sorting options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function galleries(Request $request)
    {
        $query = Gallery::where('status', 'published');
        $sort = $request->input('sort', 'latest');

        switch ($sort) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $galleries = $query->paginate(6);
        return view('front.galleries', compact('galleries'));
    }

    /**
     * Display a single gallery's details using slug for cleaner URLs.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\View\View
     */
    public function showGallery(Gallery $gallery)
    {
        $gallery->load(['subtitles.contents', 'images']);
        return view('front.gallery_show', compact('gallery'));
    }

    /**
     * Display the events listing page with sorting and filtering options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function events(Request $request)
    {
        $query = Tournament::with('sponsors')
                            ->where('visibility_status', 'Published');

        $sort = $request->input('sort', 'latest');
        $category = $request->input('category', 'all');

        switch ($sort) {
            case 'latest':
                $query->orderBy('registration_start', 'desc');
                break;
            case 'oldest':
                $query->orderBy('registration_start', 'asc');
                break;
            case 'upcoming':
                $query->where('registration_end', '>=', now())
                      ->orderBy('registration_start', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        if ($category !== 'all') {
            $query->where('gender_category', $category);
        }

        $events = $query->paginate(9)->withQueryString();

        return view('front.events.index', compact('events', 'sort', 'category'));
    }

    /**
     * Display a single event's details.
     * DIPERBAIKI: Menambahkan load matches dengan relasi untuk ranking
     *
     * @param  \App\Models\Tournament  $event
     * @return \Illuminate\View\View
     */
    public function showEvent(Tournament $event)
    {
        // DIPERBAIKI: Load semua relasi yang diperlukan termasuk matches
        $event->load([
            'rules', 
            'registrations.team.members', 
            'registrations.user', 
            'sponsors',
            'matches.team1', 
            'matches.team2', 
            'matches.winner'
        ]);

        $user = Auth::user();
        $userHasTeam = false;
        $teamMemberCount = 0;
        $userRegistrationStatus = null;

        $minMembersRequired = $event->min_participants ?? 7;
        $isRegistrationOpen = ($event->status === 'registration');

        if ($user) {
            $user->load('team.members');

            if ($user->team) {
                $userHasTeam = true;
                $teamMemberCount = $user->team->members->count();
            }

            $registration = $event->registrations->where('user_id', $user->id)->first();
            if ($registration) {
                $userRegistrationStatus = $registration->status;
            }
        }

        // TAMBAHAN BARU: Cek dan refresh ranking jika diperlukan
        if ($event->matches->where('status', 'completed')->isNotEmpty()) {
            // Jika belum ada ranking atau ranking perlu di-update
            if (!$event->hasRankings()) {
                Log::info('Creating initial rankings for tournament', ['tournament_id' => $event->id]);
                $event->refreshRankings();
            }
        }

        return view('front.event_detail', compact(
            'event',
            'userHasTeam',
            'teamMemberCount',
            'userRegistrationStatus',
            'minMembersRequired',
            'isRegistrationOpen'
        ));
    }

    /**
     * Processes event registration from the user.
     * This method is called via AJAX.
     *
     * @param Request $request
     * @param Tournament $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, Tournament $event)
    {
        // 1. Check Authentication
        if (!Auth::check()) {
            Log::warning('Event Registration: Unauthenticated attempt.', ['event_slug' => $event->slug]);
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk mendaftar.'], 401);
        }

        $user = Auth::user();
        $user->load('team.members');

        // 2. Check Tournament Status
        if ($event->status !== 'registration') {
            Log::warning('Event Registration: Attempt when registration is not open.', [
                'user_id' => $user->id,
                'event_slug' => $event->slug,
                'event_status' => $event->status
            ]);
            $message = 'Pendaftaran untuk event ini sudah ' .
                        ($event->status === 'ongoing' ? 'berlangsung.' : ($event->status === 'completed' ? 'selesai.' : 'ditutup.'));
            return response()->json(['success' => false, 'message' => $message], 400);
        }

        // 3. Check if User is Already Registered
        $existingRegistration = $event->registrations()->where('user_id', $user->id)->first();

        if ($existingRegistration) {
            if ($existingRegistration->status === 'rejected') {
                $existingRegistration->delete();
                Log::info('Event Registration: Deleted previous rejected registration to allow re-register.', ['user_id' => $user->id, 'event_slug' => $event->slug]);
            } else {
                Log::info('Event Registration: User already registered with non-rejected status.', ['user_id' => $user->id, 'event_slug' => $event->slug, 'status' => $existingRegistration->status]);
                return response()->json(['success' => false, 'message' => 'Anda sudah terdaftar di event ini dengan status: ' . ucfirst($existingRegistration->status) . '.'], 409);
            }
        }

        // 4. Check if User Has a Team
        if (!$user->team) {
            Log::warning('Event Registration: User has no team.', ['user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'Anda harus memiliki tim di profil untuk mendaftar.',
                'redirect_to_profile' => true
            ], 400);
        }

        // 5. Check Minimum Team Members Requirement
        $minMembersRequired = $event->min_participants ?? 7;
        if ($user->team->members->count() < $minMembersRequired) {
            Log::warning('Event Registration: Insufficient team members.', [
                'user_id' => $user->id,
                'team_id' => $user->team->id,
                'current_members' => $user->team->members->count(),
                'min_required' => $minMembersRequired
            ]);
            return response()->json([
                'success' => false,
                'message' => "Tim Anda harus memiliki minimal {$minMembersRequired} anggota untuk mendaftar. Silakan lengkapi di profil Anda.",
                'redirect_to_profile' => true
            ], 400);
        }

        // 6. Check Maximum Participants
        $currentParticipantsCount = $event->registrations()->whereIn('status', ['pending', 'approved', 'confirmed'])->count();
        if ($event->max_participants !== null && $currentParticipantsCount >= $event->max_participants) {
            Log::warning('Event Registration: Max participants reached.', [
                'event_slug' => $event->slug,
                'current_registrations' => $currentParticipantsCount,
                'max_participants' => $event->max_participants
            ]);
            return response()->json(['success' => false, 'message' => 'Jumlah partisipan event sudah penuh.'], 400);
        }

        // All checks passed, proceed with registration
        DB::beginTransaction();

        try {
            $registration = new TournamentRegistration();
            $registration->tournament_id = $event->id;
            $registration->user_id = $user->id;
            $registration->team_id = $user->team->id;
            $registration->status = 'pending';
            $registration->registered_at = now();

            $registration->save();

            DB::commit();
            Log::info('Event Registration: Successfully registered.', ['registration_id' => $registration->id]);

            return response()->json(['success' => true, 'message' => 'Pendaftaran berhasil!']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Event Registration: Database transaction failed.', [
                'event_id' => $event->id,
                'user_id' => $user->id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem saat mendaftar. Silakan coba lagi.'], 500);
        }
    }
    
    // =================================================================
    // ================ METODE SEARCH YANG SUDAH DIPERBAIKI ===========
    // =================================================================
    /**
     * Menangani permintaan pencarian dan menampilkan hasilnya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // 1. Validasi input dari user, harus diisi dan minimal 3 karakter
        $request->validate([
            'query' => 'required|min:3',
        ]);

        // 2. Ambil kata kunci pencarian dari input form
        $query = $request->input('query');

        // 3. Lakukan pencarian di database Articles
        $articles = Article::where('status', 'Published')
                            ->where(function($q) use ($query) {
                                $q->where('title', 'LIKE', "%{$query}%")
                                  ->orWhere('description', 'LIKE', "%{$query}%")
                                  ->orWhere('author', 'LIKE', "%{$query}%");
                            })
                            ->latest()
                            ->paginate(10);

        // 4. Pencarian di Events/Tournaments
        $events = Tournament::where('visibility_status', 'Published')
                            ->where(function($q) use ($query) {
                                $q->where('title', 'LIKE', "%{$query}%")
                                  ->orWhere('location', 'LIKE', "%{$query}%")
                                  ->orWhere('contact_person', 'LIKE', "%{$query}%")
                                  ->orWhere('gender_category', 'LIKE', "%{$query}%");
                            })
                            ->latest()
                            ->take(5)
                            ->get();

        // 5. Pencarian di Galleries
        $galleries = Gallery::where('status', 'Published')
                            ->where(function($q) use ($query) {
                                $q->where('title', 'LIKE', "%{$query}%")
                                  ->orWhere('description', 'LIKE', "%{$query}%")
                                  ->orWhere('author', 'LIKE', "%{$query}%")
                                  ->orWhere('tournament_name', 'LIKE', "%{$query}%");
                            })
                            ->latest()
                            ->take(5)
                            ->get();

        // Hitung total hasil
        $totalResults = $articles->total() + $events->count() + $galleries->count();

        // 6. Kirim hasil pencarian ke view
        return view('front.search_results', [
            'articles' => $articles,
            'events' => $events,
            'galleries' => $galleries,
            'query' => $query,
            'totalResults' => $totalResults
        ]);
    }
}