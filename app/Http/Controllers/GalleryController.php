<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\GallerySubtitle;
use App\Models\GalleryContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; // Keep this if you plan to use it for resize/compress

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries for admin management.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort');

        $galleries = Gallery::query();

        if ($sort === 'view') {
            $galleries->orderByDesc('views');
        } elseif ($sort === 'latest') { // 'latest' is typical for newest
            $galleries->orderByDesc('created_at');
        } elseif ($sort === 'oldest') {
            $galleries->orderBy('created_at');
        } else {
            $galleries->latest(); // default sorting if no valid sort provided
        }

        $galleries = $galleries->paginate(6);

        // Ensure this view path matches your actual file structure (e.g., resources/views/galleries/index.blade.php or galleries/manage.blade.php)
        return view('galleries.index', compact('galleries')); // Assuming index is your main gallery list for admin
    }

    /**
     * Show the form for creating a new gallery.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('galleries.create');
    }

    /**
     * Store a newly created gallery in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'tournament_name' => 'nullable|string|max:255',
            'video_link' => 'nullable|url|max:255',
            'status' => 'required|in:Draft,Published',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'contents' => 'required|array',
            'contents.*.subtitle' => 'required|string|max:255',
            'contents.*.paragraphs' => 'required|array',
            'contents.*.paragraphs.*.content' => 'required|string',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            // Uncomment and configure if you want to resize/compress here
            /*
            $image = Image::make($request->file('thumbnail'))
                ->resize(800, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); })
                ->encode('jpg', 75);
            $thumbnailFileName = 'thumbnails/' . time() . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            Storage::disk('public')->put($thumbnailFileName, $image);
            $thumbnailPath = $thumbnailFileName;
            */

            // If not resizing, directly store the file
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $gallery = new Gallery();
        $gallery->user_id = auth()->id();
        $gallery->author = $request->author;
        $gallery->title = $request->title;
        $gallery->tournament_name = $request->tournament_name;
        $gallery->video_link = $request->video_link;
        $gallery->thumbnail = $thumbnailPath;
        $gallery->status = $request->status;
        $gallery->description = $request->description;
        $gallery->save();

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                if ($image->isValid()) {
                    $gallery->images()->create([
                        'image' => $image->store('gallery_images', 'public'),
                    ]);
                }
            }
        }

        foreach ($request->contents as $subIndex => $subtitleData) {
            $subtitle = $gallery->subtitles()->create([
                'order_number' => $subIndex + 1,
                'subtitle' => $subtitleData['subtitle'],
            ]);

            foreach ($subtitleData['paragraphs'] as $paraIndex => $paragraph) {
                $subtitle->contents()->create([
                    'order_number' => $paraIndex + 1,
                    'content' => $paragraph['content'],
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery created successfully!');
    }

    /**
     * Show the form for editing the specified gallery.
     *
     * @param  \App\Models\Gallery  $gallery (Model bound by slug from route)
     * @return \Illuminate\View\View
     */
    public function edit(Gallery $gallery)
    {
        $gallery->load([
            'images',
            'subtitles.contents' => fn ($query) => $query->orderBy('order_number')
        ]);

        return view('galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'tournament_name' => 'nullable|string|max:255',
            'video_link' => 'nullable|url|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:Draft,Published',
            'description' => 'nullable|string',
            'update_images' => 'nullable|array',
            'update_images.*' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|max:2048',
            'contents' => 'nullable|array',
            'contents.*.id' => 'nullable|exists:gallery_subtitles,id',
            'contents.*.subtitle' => 'required|string|max:255',
            'contents.*.paragraphs' => 'nullable|array',
            'contents.*.paragraphs.*.id' => 'nullable|exists:gallery_contents,id',
            'contents.*.paragraphs.*.content' => 'required|string',
        ]);

        // Handle thumbnail update
        if ($request->hasFile('thumbnail')) {
            if ($gallery->thumbnail) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            $gallery->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Update main gallery attributes
        $gallery->title = $validated['title'];
        $gallery->author = $validated['author'];
        $gallery->tournament_name = $validated['tournament_name'];
        $gallery->video_link = $validated['video_link'];
        $gallery->status = $validated['status'];
        $gallery->description = $validated['description'];
        $gallery->save();

        // Handle image updates and new image uploads
        if ($request->hasFile('update_images')) {
            foreach ($request->file('update_images') as $imageId => $file) {
                $imageModel = $gallery->images()->find($imageId);
                if ($imageModel && $file->isValid()) {
                    Storage::disk('public')->delete($imageModel->image);
                    $imageModel->update([
                        'image' => $file->store('gallery_images', 'public'),
                    ]);
                }
            }
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                if ($image->isValid()) {
                    $gallery->images()->create([
                        'image' => $image->store('gallery_images', 'public'),
                    ]);
                }
            }
        }

        // Delete images if requested by checkbox
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $gallery->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image);
                    $image->delete();
                }
            }
        }

        // Sync subtitles and their contents
        $existingSubtitleIds = [];
        if ($request->has('contents')) {
            foreach ($request->contents as $subIndex => $subtitleData) {
                $subtitle = null;
                if (isset($subtitleData['id'])) {
                    $subtitle = $gallery->subtitles()->find($subtitleData['id']);
                }

                if ($subtitle) {
                    $subtitle->update([
                        'subtitle' => $subtitleData['subtitle'],
                        'order_number' => $subIndex + 1,
                    ]);
                } else {
                    $subtitle = $gallery->subtitles()->create([
                        'subtitle' => $subtitleData['subtitle'],
                        'order_number' => $subIndex + 1,
                    ]);
                }
                $existingSubtitleIds[] = $subtitle->id;

                $existingContentIds = [];
                if (isset($subtitleData['paragraphs'])) {
                    foreach ($subtitleData['paragraphs'] as $paraIndex => $paragraphData) {
                        $content = null;
                        if (isset($paragraphData['id'])) {
                            $content = $subtitle->contents()->find($paragraphData['id']);
                        }

                        if ($content) {
                            $content->update([
                                'content' => $paragraphData['content'],
                                'order_number' => $paraIndex + 1,
                            ]);
                        } else {
                            $content = $subtitle->contents()->create([
                                'content' => $paragraphData['content'],
                                'order_number' => $paraIndex + 1,
                            ]);
                        }
                        $existingContentIds[] = $content->id;
                    }
                }
                $subtitle->contents()->whereNotIn('id', $existingContentIds)->delete();
            }
        }

        $gallery->subtitles()->whereNotIn('id', $existingSubtitleIds)->each(function($sub) {
            $sub->contents()->delete();
            $sub->delete();
        });

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated successfully!');
    }

    /**
     * Remove the specified gallery from storage.
     *
     * @param  \App\Models\Gallery  $gallery (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        if ($gallery->thumbnail) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->subtitles->each(function ($subtitle) {
            $subtitle->contents()->delete();
            $subtitle->delete();
        });

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery deleted successfully!');
    }

    /**
     * Display the specified gallery (Admin view).
     *
     * @param  \App\Models\Gallery  $gallery (Model bound by slug from route)
     * @return \Illuminate\View\View
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('images', 'subtitles.contents');

        return view('galleries.show', compact('gallery'));
    }

    /**
     * Display a listing of galleries awaiting approval (status 'Draft').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function approval(Request $request)
    {
        $sort = $request->query('sort', 'latest');

        // Added 'status' filter from request, ensuring case-sensitive match
        $query = Gallery::query();
        if ($request->filled('status')) {
            $query->where('status', ucfirst($request->status));
        } else {
            // If no status filter, default to showing only 'Draft' for approval page
            $query->where('status', 'Draft');
        }

        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else { // 'latest'
            $query->orderBy('created_at', 'desc');
        }

        $draftGalleries = $query->paginate(6)->withQueryString();

        return view('galleries.approval', compact('draftGalleries'));
    }

    /**
     * Update the status of a specific gallery (e.g., from Draft to Published).
     * This method was previously named 'approve'.
     *
     * @param  \App\Models\Gallery  $gallery (Model bound by slug from route)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Gallery $gallery) // Renamed from 'approve'
    {
        $gallery->update(['status' => 'Published']);

        return redirect()->route('admin.galleries.approval')->with('success', 'Gallery approved and published!');
    }

    // You had a 'reject' route in web.php, but no method here.
    // If you need it, you would add it like this:
    /*
    public function reject(Gallery $gallery)
    {
        $gallery->update(['status' => 'Rejected']); // Or 'Draft' if you want it to revert to draft
        return redirect()->route('admin.galleries.approval')->with('success', 'Gallery request rejected.');
    }
    */
}
