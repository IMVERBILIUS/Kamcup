<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $article->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil diperbarui');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus');
    }
} 