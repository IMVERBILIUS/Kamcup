<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use App\Models\Tournament;
use App\Models\Article;
use App\Models\Gallery;
use Carbon\Carbon;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        // Greeting dan Help
        $botman->hears('(hi|hello|hai|halo|help|bantuan)', function (BotMan $bot) {
            $this->startConversation($bot);
        });

        // Menu utama
        $botman->hears('menu|mulai|start', function (BotMan $bot) {
            $this->showMainMenu($bot);
        });

        // Tournament/Event related
        $botman->hears('(event|turnamen|tournament)', function (BotMan $bot) {
            $this->showEvents($bot);
        });

        // Article related
        $botman->hears('(artikel|article|berita|news)', function (BotMan $bot) {
            $this->showArticles($bot);
        });

        // Team registration
        $botman->hears('(daftar tim|tim|team|register)', function (BotMan $bot) {
            $this->teamRegistration($bot);
        });

        // Host registration
        $botman->hears('(tuan rumah|host|venue)', function (BotMan $bot) {
            $this->hostRegistration($bot);
        });

        // Donation info
        $botman->hears('(donasi|sponsor|donation)', function (BotMan $bot) {
            $this->donationInfo($bot);
        });

        // Gallery
        $botman->hears('(galeri|gallery|foto|photo)', function (BotMan $bot) {
            $this->showGallery($bot);
        });

        // Contact info
        $botman->hears('(kontak|contact|info)', function (BotMan $bot) {
            $this->contactInfo($bot);
        });

        // Default fallback
        $botman->fallback(function (BotMan $bot) {
            $this->fallbackResponse($bot);
        });

        $botman->listen();
    }

    private function startConversation(BotMan $bot)
    {
        $bot->reply("👋 Halo! Selamat datang di KAMCUP Bot!");
        $bot->reply("🏐 Saya adalah asisten virtual untuk membantu Anda dengan informasi seputar volleyball tournament dan event kami.");
        $this->showMainMenu($bot);
    }

    private function showMainMenu(BotMan $bot)
    {
        $bot->reply("📋 **MENU UTAMA** - Pilih informasi yang Anda butuhkan:");
        $bot->reply("🏆 Ketik 'event' - Lihat tournament & event\n" .
                   "📰 Ketik 'artikel' - Baca artikel terbaru\n" .
                   "👥 Ketik 'tim' - Daftar sebagai tim\n" .
                   "🏢 Ketik 'host' - Jadi tuan rumah\n" .
                   "💝 Ketik 'donasi' - Informasi sponsor\n" .
                   "📸 Ketik 'galeri' - Lihat galeri foto\n" .
                   "📞 Ketik 'kontak' - Informasi kontak\n" .
                   "❓ Ketik 'help' - Bantuan");
    }

    private function showEvents(BotMan $bot)
    {
        $upcomingEvents = Tournament::where('status', 'registration')
            ->where('registration_end', '>=', Carbon::now())
            ->orderBy('registration_start', 'asc')
            ->take(3)
            ->get();

        if ($upcomingEvents->count() > 0) {
            $bot->reply("🏆 **EVENT MENDATANG:**");
            
            foreach ($upcomingEvents as $event) {
                $message = "**{$event->title}**\n" .
                          "📅 Pendaftaran: " . Carbon::parse($event->registration_start)->format('d M') . 
                          " - " . Carbon::parse($event->registration_end)->format('d M Y') . "\n" .
                          "📍 Lokasi: {$event->location}\n" .
                          "👥 Kategori: {$event->gender_category}\n" .
                          "🔗 Detail: " . route('front.events.show', $event->slug);
                
                $bot->reply($message);
            }
        } else {
            $bot->reply("📅 Saat ini belum ada event yang dibuka untuk pendaftaran.");
        }
        
        $bot->reply("🔗 Lihat semua event: " . route('front.events.index'));
        $this->askForMore($bot);
    }

    private function showArticles(BotMan $bot)
    {
        $latestArticles = Article::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        if ($latestArticles->count() > 0) {
            $bot->reply("📰 **ARTIKEL TERBARU:**");
            
            foreach ($latestArticles as $article) {
                $message = "**{$article->title}**\n" .
                          "📝 " . substr(strip_tags($article->description), 0, 100) . "...\n" .
                          "🔗 Baca: " . route('front.articles.show', $article->slug);
                
                $bot->reply($message);
            }
        } else {
            $bot->reply("📰 Artikel terbaru sedang dalam persiapan.");
        }
        
        $bot->reply("🔗 Lihat semua artikel: " . route('front.articles'));
        $this->askForMore($bot);
    }

    private function teamRegistration(BotMan $bot)
    {
        $message = "👥 **PENDAFTARAN TIM**\n\n" .
                  "Untuk mendaftarkan tim Anda:\n" .
                  "1️⃣ Login ke akun Anda\n" .
                  "2️⃣ Buat profil tim\n" .
                  "3️⃣ Tambahkan anggota tim\n" .
                  "4️⃣ Pilih event untuk diikuti\n\n" .
                  "🔗 Daftar Tim: " . route('team.create');

        $bot->reply($message);
        $this->askForMore($bot);
    }

    private function hostRegistration(BotMan $bot)
    {
        $message = "🏢 **PENDAFTARAN TUAN RUMAH**\n\n" .
                  "Ingin menyelenggarakan tournament?\n" .
                  "1️⃣ Login ke akun Anda\n" .
                  "2️⃣ Isi form permohonan\n" .
                  "3️⃣ Tunggu konfirmasi tim\n" .
                  "4️⃣ Siapkan venue terbaik!\n\n" .
                  "🔗 Jadi Tuan Rumah: " . route('host-request.create');

        $bot->reply($message);
        $this->askForMore($bot);
    }

    private function donationInfo(BotMan $bot)
    {
        $message = "💝 **PROGRAM SPONSORSHIP**\n\n" .
                  "Dukung perkembangan volleyball Indonesia!\n" .
                  "🎯 Mendukung atlet muda\n" .
                  "🏆 Fasilitas tournament\n" .
                  "🤝 Membangun komunitas\n\n" .
                  "🔗 Info Donasi: " . route('donations.create');

        $bot->reply($message);
        $this->askForMore($bot);
    }

    private function showGallery(BotMan $bot)
    {
        $latestGalleries = Gallery::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        if ($latestGalleries->count() > 0) {
            $bot->reply("📸 **GALERI TERBARU:**");
            
            foreach ($latestGalleries as $gallery) {
                $message = "**{$gallery->title}**\n" .
                          "🔗 Lihat: " . route('front.galleries.show', $gallery->slug);
                
                $bot->reply($message);
            }
        } else {
            $bot->reply("📸 Galeri foto sedang dalam persiapan.");
        }
        
        $bot->reply("🔗 Lihat semua galeri: " . route('front.galleries'));
        $this->askForMore($bot);
    }

    private function contactInfo(BotMan $bot)
    {
        $message = "📞 **KONTAK KAMI**\n\n" .
                  "🌐 Website: " . url('/') . "\n" .
                  "📧 Email: info@kamcup.com\n" .
                  "📱 Instagram: @kamcup_official\n" .
                  "📍 Lokasi: Yogyakarta, Indonesia\n\n" .
                  "💬 Tim customer service kami siap membantu!";

        $bot->reply($message);
        $this->askForMore($bot);
    }

    private function askForMore(BotMan $bot)
    {
        $bot->reply("❓ Ada yang bisa saya bantu lagi? Ketik 'menu' untuk kembali ke menu utama.");
    }

    private function fallbackResponse(BotMan $bot)
    {
        $responses = [
            "🤔 Maaf, saya tidak mengerti. Ketik 'help' untuk melihat panduan.",
            "❓ Bisa ulangi dengan kata kunci yang lebih spesifik? Ketik 'menu' untuk pilihan.",
            "🔍 Coba ketik salah satu: event, artikel, tim, host, donasi, galeri, atau kontak"
        ];

        $bot->reply($responses[array_rand($responses)]);
        $this->showMainMenu($bot);
    }

    /**
     * Test method untuk memastikan BotMan berfungsi
     */
    public function tinker()
    {
        return "BotMan is working! Chatbot sudah siap digunakan.";
    }
}