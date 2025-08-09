<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Pastikan hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $articles = Article::with('user')->latest()->get();

        return view('admin.dashboard', compact('articles'));
    }
}
