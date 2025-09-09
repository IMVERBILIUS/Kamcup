<?php

use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TournamentHostRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\BotManController;

/*
|--------------------------------------------------------------------------
| Storage Symlink Route (Run once after deployment)
|--------------------------------------------------------------------------
*/
Route::get('/storage-link', function () {
    $targetFolder = base_path() . '/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    
    if (!file_exists($linkFolder)) {
        try {
            symlink($targetFolder, $linkFolder);
            return "Symlink created successfully!";
        } catch (\Exception $e) {
            return "Failed to create symlink: " . $e->getMessage();
        }
    }
    return "Symlink already exists.";
});

/*
|--------------------------------------------------------------------------
| BotMan Chatbot Routes
|--------------------------------------------------------------------------
*/
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::get('/botman/tinker', [BotManController::class, 'tinker']);
Route::get('/chatbot-test', function () {
    return view('chatbot.test');
})->name('chatbot.test');

/*
|--------------------------------------------------------------------------
| Public Routes (Guest & Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware('log.visit')->group(function () {
    // Homepage and main content
    Route::get('/', [FrontController::class, 'index'])->name('front.index');
    Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
    Route::get('/search', [FrontController::class, 'search'])->name('front.search');
    
    // Articles (Public viewing)
    Route::get('/articles', [FrontController::class, 'articles'])->name('front.articles');
    Route::get('/articles/{article:slug}', [FrontController::class, 'showArticle'])->name('front.articles.show');
    
    // Galleries (Public viewing)
    Route::get('/galleries', [FrontController::class, 'galleries'])->name('front.galleries');
    Route::get('/galleries/{gallery:slug}', [FrontController::class, 'showGallery'])->name('front.galleries.show');
    
    // Events/Tournaments (Public viewing)
    Route::get('/events', [FrontController::class, 'events'])->name('front.events.index');
    Route::get('/events/{event:slug}', [FrontController::class, 'showEvent'])->name('front.events.show');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard redirection based on role
Route::get('/dashboard', [AuthController::class, 'redirectDashboard'])
    ->middleware('auth')
    ->name('redirect.dashboard');

/*
|--------------------------------------------------------------------------
| Password Reset Routes
|--------------------------------------------------------------------------
*/
Route::get('forgot-password', [ResetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Google OAuth Routes
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // User Profile Management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Comment Management on Articles
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Tournament Host Request (User-facing)
    Route::get('/host-request', [TournamentHostRequestController::class, 'create'])->name('host-request.create');
    Route::post('/host-request', [TournamentHostRequestController::class, 'store'])->name('host-request.store');
    
    // Team Management (User-facing) - Uses encrypted IDs for security
    Route::prefix('tim')->name('team.')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('index');
        Route::get('/buat', [TeamController::class, 'create'])->name('create');
        Route::post('/', [TeamController::class, 'store'])->name('store');
        Route::get('/{team}/edit', [TeamController::class, 'edit'])->name('edit');
        Route::put('/{team}', [TeamController::class, 'update'])->name('update');
        Route::delete('/{team}', [TeamController::class, 'destroy'])->name('destroy');
        
        // Team Member Management (Nested under team)
        Route::prefix('/{team}/anggota')->name('members.')->group(function () {
            Route::get('/buat', [TeamMemberController::class, 'create'])->name('create');
            Route::post('/', [TeamMemberController::class, 'store'])->name('store');
            Route::get('/{member}/edit', [TeamMemberController::class, 'edit'])->name('edit');
            Route::put('/{member}', [TeamMemberController::class, 'update'])->name('update');
            Route::delete('/{member}', [TeamMemberController::class, 'destroy'])->name('destroy');
        });
    });
    
    // Event Registration (User-facing)
    Route::post('/events/{event:slug}/register', [FrontController::class, 'register'])->name('front.events.register');
    
    // Donation/Sponsorship Routes (Requires Login)
    Route::prefix('sponsorship')->name('donations.')->group(function () {
        Route::get('/', [DonationController::class, 'create'])->name('create');
        Route::post('/', [DonationController::class, 'store'])->name('store');
    });
    
    // Alternative donation routes for different URLs
    Route::get('/donations', [DonationController::class, 'create'])->name('donation.form');
    Route::post('/donations', [DonationController::class, 'store'])->name('donation.store');
    Route::get('/ajukan-sponsorship', [DonationController::class, 'create'])->name('sponsorship.form');
    Route::get('/donasi', [DonationController::class, 'create'])->name('donation.form.alt');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    
    // Article Management (Admin)
    Route::get('/articles/approval', [ArticleController::class, 'approval'])->name('articles.approval');
    Route::put('/articles/{article}/status', [ArticleController::class, 'updateStatus'])->name('articles.updateStatus');
    Route::resource('articles', ArticleController::class)->parameters([
        'articles' => 'article:slug'
    ]);
    
    // Gallery Management (Admin)
    Route::get('/galleries/approval', [GalleryController::class, 'approval'])->name('galleries.approval');
    Route::put('/galleries/{gallery}/status', [GalleryController::class, 'updateStatus'])->name('galleries.updateStatus');
    Route::resource('galleries', GalleryController::class)->parameters([
        'galleries' => 'gallery:slug'
    ]);
    
    // Tournament Management (Admin)
    Route::resource('tournaments', TournamentController::class)->parameters([
        'tournaments' => 'tournament:slug'
    ]);
    
    // Tournament Registration Status Management
    Route::put('tournaments/{tournament:slug}/registrations/{registration}/status', 
        [TournamentController::class, 'updateRegistrationStatus']
    )->name('tournaments.registrations.updateStatus');
    
    // Sponsor Management (Admin)
    Route::resource('sponsors', SponsorController::class);
    
    // Host Request Management (Admin approval)
    Route::prefix('host-requests')->name('host-requests.')->group(function () {
        Route::get('/', [TournamentHostRequestController::class, 'index'])->name('index');
        Route::get('/{tournamentHostRequest}', [TournamentHostRequestController::class, 'show'])->name('show');
        Route::put('/{tournamentHostRequest}/approve', [TournamentHostRequestController::class, 'approve'])->name('approve');
        Route::put('/{tournamentHostRequest}/reject', [TournamentHostRequestController::class, 'reject'])->name('reject');
    });
    
    // Donation/Sponsorship Management (Admin)
    Route::prefix('donations')->name('donations.')->group(function () {
        Route::get('/', [DonationController::class, 'index'])->name('index');
        Route::get('/{donation}', [DonationController::class, 'show'])->name('show');
        Route::put('/{donation}/status', [DonationController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/export/csv', [DonationController::class, 'export'])->name('export');
        Route::get('/statistics/json', [DonationController::class, 'statistics'])->name('statistics');
    });
    
    // Match Management (Admin) - DIPERBAIKI DAN DIKELOMPOKKAN
    Route::prefix('matches')->name('matches.')->group(function () {
        // AJAX endpoints untuk form create/edit (harus di atas resource routes)
        Route::get('/get-confirmed-teams', [MatchController::class, 'getConfirmedTeams'])->name('get-confirmed-teams');
        Route::get('/get-tournament-location', [MatchController::class, 'getTournamentLocation'])->name('get-tournament-location');
        Route::get('/get-all-teams', [MatchController::class, 'getAllTeamsForTournament'])->name('get-all-teams');
        
        // Live score dan stats endpoints
        Route::get('/{match}/score', [MatchController::class, 'getScore'])->name('get-score');
        Route::get('/tournament/{tournament}/stats', [MatchController::class, 'getTournamentStats'])->name('tournament-stats');
        
        // Bulk operations
        Route::post('/bulk-update-status', [MatchController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
    });
    
    // Match Resource Routes (CRUD operations)
    Route::resource('matches', MatchController::class);
});

/*
|--------------------------------------------------------------------------
| Role-Based Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:author'])->group(function () {
    Route::get('/author/dashboard', function () {
        return view('dashboard.author');
    })->name('author.dashboard');
});

Route::middleware(['auth', 'role:reader'])->group(function () {
    Route::get('/reader/dashboard', function () {
        return view('dashboard.reader');
    })->name('reader.dashboard');
});

/*
|--------------------------------------------------------------------------
| API Routes (Optional - untuk akses eksternal)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->group(function () {
    // Public API endpoints (tidak perlu auth)
    Route::get('/matches/{match}/score', [MatchController::class, 'getScore'])->name('match.score');
    Route::get('/tournaments/{tournament}/matches', function($tournament) {
        return App\Models\Tournament::findOrFail($tournament)
            ->matches()
            ->with(['team1', 'team2'])
            ->get();
    })->name('tournament.matches');
});

// Tes error page, bisa di hapus setelah testing atau presentasi
Route::get('/401', fn() => abort(401, 'Unauthorized'));
Route::get('/402', fn() => abort(402, 'Unauthorized'));
Route::get('/403', fn() => abort(403, 'Forbidden'));
Route::get('/419', fn() => abort(419, 'Page Expired'));
Route::get('/429', fn() => abort(429, 'Too Many Requests'));
Route::get('/500', fn() => abort(500, 'Internal Server Error'));
Route::get('/503', fn() => abort(503, 'Service Unavailable'));