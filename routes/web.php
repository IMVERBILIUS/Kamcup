<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontController; // <-- Ini adalah FrontController utama
use App\Http\Controllers\SearchController; // <-- Tambahan untuk Search
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
use App\Http\Controllers\DonationController; // <-- Tambahan untuk Donation

// Route for storage link (usually run once after deployment/setup)
Route::get('/storage-link', function () {
    $targetFolder = base_path() . '/storage/app/public';
    // Ensure this points to your web server's public root, e.g., public_path()
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

// Public-Facing Routes (accessible to all, guest or authenticated)
Route::middleware('log.visit')->group(function () {
    Route::get('/', [FrontController::class, 'index'])->name('front.index');
    Route::get('/articles', [FrontController::class, 'articles'])->name('front.articles');
    Route::get('/articles/{article:slug}', [FrontController::class, 'showArticle'])->name('front.articles.show');
    Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');

    // Gallery Routes (front-facing)
    Route::get('/galleries', [FrontController::class, 'galleries'])->name('front.galleries');
    Route::get('/galleries/{gallery:slug}', [FrontController::class, 'showGallery'])->name('front.galleries.show');

    // Event Listing (front-facing) - Sekarang ditangani oleh FrontController
    Route::get('/events', [FrontController::class, 'events'])->name('front.events.index');
    // Event/Tournament Details (front-facing) - Sekarang ditangani oleh FrontController
    Route::get('/events/{event:slug}', [FrontController::class, 'showEvent'])->name('front.events.show');

    Route::get('/search', [FrontController::class, 'search'])->name('front.search');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard redirection based on role after login
Route::get('/dashboard', [AuthController::class, 'redirectDashboard'])->middleware('auth')->name('redirect.dashboard');

// Password Reset Routes (Laravel's built-in routes)
Route::get('forgot-password', [ResetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// --- Authenticated User Routes ---
// These routes require the user to be logged in.
Route::middleware(['auth'])->group(function () {
    // Comment management on articles
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // User Profile management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Tournament Host Request (User facing)
    Route::get('/host-request', [TournamentHostRequestController::class, 'create'])->name('host-request.create');
    Route::post('/host-request', [TournamentHostRequestController::class, 'store'])->name('host-request.store');

    // Team Management (User facing) - {team} parameter is encrypted ID
    Route::get('/tim', [TeamController::class, 'index'])->name('team.index'); // Tambahan untuk listing team user
    Route::get('/tim/buat', [TeamController::class, 'create'])->name('team.create');
    Route::post('/tim', [TeamController::class, 'store'])->name('team.store');
    // Using encrypted ID for team in edit/update/delete
    Route::get('/tim/{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
    Route::put('/tim/{team}', [TeamController::class, 'update'])->name('team.update');
    Route::delete('/tim/{team}', [TeamController::class, 'destroy'])->name('team.destroy'); // Added destroy for team

    // Team Member Management (User facing) - {team} and {member} parameters are encrypted IDs
    Route::get('/tim/{team}/anggota/buat', [TeamMemberController::class, 'create'])->name('team.members.create');
    Route::post('/tim/{team}/anggota', [TeamMemberController::class, 'store'])->name('team.members.store');
    // Using encrypted IDs for team member edit/update/delete
    Route::get('/tim/{team}/anggota/{member}/edit', [TeamMemberController::class, 'edit'])->name('team.members.edit');
    Route::put('/tim/{team}/anggota/{member}', [TeamMemberController::class, 'update'])->name('team.members.update');
    Route::delete('/tim/{team}/anggota/{member}', [TeamMemberController::class, 'destroy'])->name('team.members.destroy');

    // Event Registration (User facing) - Uses event slug as per front-facing URL, but sends event ID in AJAX body
    Route::post('/events/{event:slug}/register', [FrontController::class, 'register'])->name('front.events.register');

    // === DONATION/SPONSORSHIP ROUTES (SEKARANG BUTUH LOGIN) ===
    // Form sponsorship/donasi - sekarang butuh login
    Route::get('/sponsorship', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/sponsorship', [DonationController::class, 'store'])->name('donations.store');
    
    // Alternative routes dengan URL yang berbeda
    Route::get('/donations', [DonationController::class, 'create'])->name('donation.form');
    Route::post('/donations', [DonationController::class, 'store'])->name('donation.store');
    Route::get('/ajukan-sponsorship', [DonationController::class, 'create'])->name('sponsorship.form');
    Route::get('/donasi', [DonationController::class, 'create'])->name('donation.form.alt');
});

// --- Admin Routes ---
// These routes require authentication and the 'admin' role.
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Article management (Admin) - Uses slug for resource binding
    Route::get('/articles/approval', [ArticleController::class, 'approval'])->name('articles.approval');
    Route::put('/articles/{article}/status', [ArticleController::class, 'updateStatus'])->name('articles.updateStatus');
    Route::resource('articles', ArticleController::class)->parameters([
        'articles' => 'article:slug'
    ]);

    // Gallery management (Admin) - Uses slug for resource binding
    Route::get('/galleries/approval', [GalleryController::class, 'approval'])->name('galleries.approval');
    Route::put('/galleries/{gallery}/status', [GalleryController::class, 'updateStatus'])->name('galleries.updateStatus');
    Route::resource('galleries', GalleryController::class)->parameters([
        'galleries' => 'gallery:slug'
    ]);

    // Tournament management (Admin) - Uses slug for resource binding
    Route::resource('tournaments', TournamentController::class)->parameters([
        'tournaments' => 'tournament:slug'
    ]);

    // NEW ROUTE: Update Tournament Registration Status (Admin action)
    Route::put('tournaments/{tournament:slug}/registrations/{registration}/status', [TournamentController::class, 'updateRegistrationStatus'])->name('tournaments.registrations.updateStatus');

    // Sponsor management (Admin) - Uses ID for resource binding by default
    Route::resource('sponsors', SponsorController::class);

    // Host Request management (Admin approval)
    Route::get('/host-requests', [TournamentHostRequestController::class, 'index'])->name('host-requests.index');
    Route::get('/host-requests/{tournamentHostRequest}', [TournamentHostRequestController::class, 'show'])->name('host-requests.show');
    Route::put('/host-requests/{tournamentHostRequest}/approve', [TournamentHostRequestController::class, 'approve'])->name('host-requests.approve');
    Route::put('/host-requests/{tournamentHostRequest}/reject', [TournamentHostRequestController::class, 'reject'])->name('host-requests.reject');

    // === DONATION/SPONSORSHIP ADMIN ROUTES ===
    // Admin panel untuk melihat dan mengelola donations
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
    Route::put('/donations/{donation}/status', [DonationController::class, 'updateStatus'])->name('donations.updateStatus');
    Route::get('/donations/export/csv', [DonationController::class, 'export'])->name('donations.export');
    Route::get('/donations/statistics/json', [DonationController::class, 'statistics'])->name('donations.statistics');
});

// --- Role-Based Dashboards ---
// Specific dashboards for different roles, accessible only after authentication and role check.
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

// Google OAuth routes
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);