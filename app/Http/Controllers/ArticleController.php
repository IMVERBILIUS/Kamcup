<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use App\Models\Subheading;
use App\Models\Paragraph;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles for admin management.
     * Articles can be sorted by date, views, or status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'date');

        $articles = Article::query();

        switch ($sort) {
            case 'view':
                $articles->orderBy('views', 'desc');
                break;
            case 'status':
                $articles->orderBy('status', 'asc');
                break;
            default: // 'date' is default
                $articles->orderBy('created_at', 'desc');
                break;
        }

        // Paginate results with 6 items per page, preserving query string
        $articles = $articles->paginate(6)->withQueryString();

        // Ensure this view path matches your actual file structure (e.g., resources/views/articles/manage.blade.php)
        return view('articles.manage', compact('articles'));
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ensure this view path matches your actual file structure (e.g., resources/views/articles/create.blade.php)
        return view('articles.create');
    }

    /**
     * Store a newly created article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:Draft,Published',
            'subheadings' => 'required|array',
            'subheadings.*.title' => 'required|string|max:255',
            'subheadings.*.paragraphs' => 'required|array',
            'subheadings.*.paragraphs.*.content' => 'required|string',
            'author'      => 'required|string|max:255',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Resize and compress image using Intervention Image
            $resizedImage = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($image->getClientOriginalExtension(), 75);

            // Store image in storage/app/public/thumbnails
            Storage::disk('public')->put('thumbnails/' . $imageName, $resizedImage);
            $thumbnailPath = 'thumbnails/' . $imageName;
        }

        // Create new article instance
        $article = new Article();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->thumbnail = $thumbnailPath;
        $article->status = $request->status;
        $article->user_id = auth()->id();
        $article->author = $request->author;
        // Spatie Sluggable (or similar) should automatically generate the slug here
        $article->save();

        // Save subheadings and paragraphs
        foreach ($request->subheadings as $subIndex => $subheading) {
            $savedSub = $article->subheadings()->create([
                'title' => $subheading['title'],
                'order_number' => $subIndex + 1,
            ]);

            foreach ($subheading['paragraphs'] as $paraIndex => $paragraph) {
                $savedSub->paragraphs()->create([
                    'content' => $paragraph['content'],
                    'order_number' => $paraIndex + 1,
                ]);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article created with subheadings and paragraphs.');
    }

    /**
     * Display the specified article (Admin view).
     *
     * @param  \App\Models\Article  $article  (Model bound by slug from route)
     * @return \Illuminate\View\View
     */
    public function show(Article $article)
    {
        // Article is automatically loaded by Route Model Binding (via slug)
        // Eager load relationships for subheadings and paragraphs
        $article->load('subheadings.paragraphs');
        // Ensure this view path matches your actual file structure (e.g., resources/views/articles/show.blade.php)
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article.
     *
     * @param  \App\Models\Article  $article  (Model bound by slug from route)
     * @return \Illuminate\View\View
     */
    public function edit(Article $article)
    {
        // Article is automatically loaded by Route Model Binding (via slug)
        // Eager load relationships for subheadings and paragraphs
        $article->load('subheadings.paragraphs');
        // Ensure this view path matches your actual file structure (e.g., resources/views/articles/edit.blade.php)
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article  (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'author'      => 'required|string|max:255',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:Draft,Published',
            'subheadings' => 'nullable|array',
            'subheadings.*.id' => 'nullable|exists:subheadings,id',
            'subheadings.*.title' => 'required|string|max:255',
            'subheadings.*.paragraphs' => 'nullable|array',
            'subheadings.*.paragraphs.*.id' => 'nullable|exists:paragraphs,id',
            'subheadings.*.paragraphs.*.content' => 'required|string',
        ]);

        // Handle thumbnail upload/replacement
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $resizedImage = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($image->getClientOriginalExtension(), 75);

            Storage::disk('public')->put('thumbnails/' . $imageName, $resizedImage);
            $article->thumbnail = 'thumbnails/' . $imageName;
        }

        // Update main article attributes
        $article->title = $request->title;
        $article->description = $request->description;
        $article->status = $request->status;
        $article->author = $request->author;
        // Spatie Sluggable (or similar) should automatically update the slug here if the title changed
        $article->save();

        // Manage subheadings and paragraphs (syncing existing, new, and deleted ones)
        $existingSubheadingIds = [];
        $existingParagraphIds = [];

        if ($request->has('subheadings')) {
            foreach ($request->subheadings as $subIndex => $subheadingData) {
                $subheading = null;
                // Attempt to find existing subheading by ID, otherwise create a new one
                if (isset($subheadingData['id'])) {
                    $subheading = $article->subheadings()->find($subheadingData['id']);
                }

                if ($subheading) {
                    $subheading->update([
                        'title' => $subheadingData['title'],
                        'order_number' => $subIndex + 1,
                    ]);
                } else {
                    $subheading = $article->subheadings()->create([
                        'title' => $subheadingData['title'],
                        'order_number' => $subIndex + 1,
                    ]);
                }
                $existingSubheadingIds[] = $subheading->id;

                // Manage paragraphs for the current subheading
                if (isset($subheadingData['paragraphs'])) {
                    foreach ($subheadingData['paragraphs'] as $paraIndex => $paragraphData) {
                        $paragraph = null;
                        // Attempt to find existing paragraph by ID, otherwise create a new one
                        if (isset($paragraphData['id'])) {
                            $paragraph = $subheading->paragraphs()->find($paragraphData['id']);
                        }

                        if ($paragraph) {
                            $paragraph->update([
                                'content' => $paragraphData['content'],
                                'order_number' => $paraIndex + 1,
                            ]);
                        } else {
                            $paragraph = $subheading->paragraphs()->create([
                                'content' => $paragraphData['content'],
                                'order_number' => $paraIndex + 1,
                            ]);
                        }
                        $existingParagraphIds[] = $paragraph->id;
                    }
                }
            }
        }

        // Delete subheadings that were removed in the request
        $article->subheadings()->whereNotIn('id', $existingSubheadingIds)->each(function ($sub) {
            $sub->paragraphs()->delete(); // Delete associated paragraphs
            $sub->delete(); // Delete subheading
        });

        // Delete paragraphs that were removed from existing subheadings
        $subheadingIdsStillExist = $article->subheadings()->pluck('id')->toArray();
        if (!empty($subheadingIdsStillExist)) {
            Paragraph::whereIn('subheading_id', $subheadingIdsStillExist)
                ->whereNotIn('id', $existingParagraphIds)
                ->delete();
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    /**
     * Display a listing of articles awaiting approval (status 'draft').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function approval(Request $request)
    {
        $sort = $request->query('sort', 'latest');

        $draftArticles = Article::where('status', 'draft');

        if ($sort === 'oldest') {
            $draftArticles->orderBy('created_at', 'asc');
        } else { // 'latest' is default
            $draftArticles->orderBy('created_at', 'desc');
        }

        $draftArticles = $draftArticles->paginate(6)->withQueryString();

        // Ensure this view path matches your actual file structure (e.g., resources/views/articles/approval.blade.php)
        return view('articles.approval', compact('draftArticles'));
    }

    /**
     * Update the status of a specific article to 'Published'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article  (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Article $article)
    {
        $article->status = 'Published'; // Ensure 'Published' matches your validation/enum casing
        $article->save();

        return redirect()->route('admin.articles.approval')->with('success', 'Article status updated to published.');
    }

    /**
     * Remove the specified article from storage.
     *
     * @param  \App\Models\Article  $article  (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        // Delete thumbnail if it exists
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        // Delete related subheadings and paragraphs.
        // If your database uses CASCADE DELETE for foreign keys, this might not be strictly necessary
        // as the database would handle it, but it's good for explicit control.
        $article->subheadings->each(function ($sub) {
            $sub->paragraphs()->delete(); // Delete associated paragraphs
            $sub->delete(); // Delete subheading
        });

        $article->delete(); // Delete the main article

        return redirect()->route('admin.articles.index')->with('success', 'Article and associated content deleted successfully.');
    }
}
