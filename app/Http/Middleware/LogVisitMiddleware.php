<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogVisitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $url = $request->fullUrl();
        $path = $request->path(); // contoh: "articles", "articles/slug", "admin/dashboard"

        // Jangan log visit ke storage/thumbnails
        if (str_starts_with($path, 'storage/thumbnails')) {
            return $next($request);
        }

        // Jangan log visit ke halaman admin
        if (str_starts_with($path, 'admin')) {
            return $next($request);
        }

        // Jangan log visit jika URL diawali dengan articles/xxx atau galleries/xxx
        if (
            (str_starts_with($path, 'articles/') && $path !== 'articles') ||
            (str_starts_with($path, 'galleries/') && $path !== 'galleries')
        ) {
            return $next($request);
        }

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $recentVisit = DB::table('visits')
            ->where('ip_address', $ip)
            ->where('url', $url)
            ->where('visited_at', '>=', Carbon::now()->subMinutes(6))
            ->exists();

        if (!$recentVisit) {
            DB::table('visits')->insert([
                'ip_address' => $ip,
                'url' => $url,
                'user_agent' => $userAgent,
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
