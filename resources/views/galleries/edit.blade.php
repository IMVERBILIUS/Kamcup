@extends('layouts.admin')

@section('content')
<style>
/* Custom select dropdown styling, updated to match the new design aesthetic */
.custom-select-dropdown {
    background-color: #f5f5f5; /* Light gray for a modern, clean look */
    border-radius: 0.5rem; /* More rounded corners for sporty youthful feel */
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease;
    border: 1px solid #dee2e6; /* subtle border */
}
.custom-select-dropdown:focus {
    border-color: #00617a; /* Primary color for focus */
    box-shadow: 0 0 0 0.2rem rgba(0, 97, 122, 0.25); /* Primary color shadow */
}
</style>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between mb-4">
        {{-- CRITICAL FIX: Changed route to admin.galleries.index --}}
        <a href="{{ route('admin.galleries.index') }}" class="btn px-4 py-2" style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body p-4">
            {{-- CRITICAL FIX: Changed $gallery->id to $gallery->slug for the form action --}}
            <form action="{{ route('admin.galleries.update', $gallery->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-medium">Thumbnail</label>
                        <div class="position-relative border rounded-3 d-flex align-items-center justify-content-center" style="height: 240px;">
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="position-absolute w-100 h-100 opacity-0 cursor-pointer" style="z-index: 3;">
                            <div id="thumbnail-overlay" class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center border border-success bg-white rounded-3" style="pointer-events: none; {{ $gallery->thumbnail ? 'display: none;' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#36b37e" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                </svg>
                            </div>
                            @if ($gallery->thumbnail)
                                <img id="thumbnail-preview-img" src="{{ asset('storage/' . $gallery->thumbnail) }}"
                                class="position-absolute w-100 h-100"
                                style="object-fit: cover; cursor: pointer;">
                            @else
                                <img id="thumbnail-preview-img" src="#" class="position-absolute w-100 h-100 d-none" style="object-fit: cover; cursor: pointer;">
                            @endif
                        </div>
                        @error('thumbnail')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Judul Galeri</label>
                            <input type="text" class="form-control border-success rounded-3" name="title" value="{{ old('title', $gallery->title) }}" required>
                            @error('title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Nama Turnamen</label>
                            <input type="text" class="form-control border-success rounded-3" name="tournament_name" value="{{ old('tournament_name', $gallery->tournament_name) }}">
                            @error('tournament_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Author</label>
                            <input type="text" class="form-control border-success rounded-3" name="author" value="{{ old('author', $gallery->author) }}">
                            @error('author')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Status</label>
                            <select name="status" class="form-select border-success rounded-3" required>
                                <option value="Draft" {{ old('status', $gallery->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Published" {{ old('status', $gallery->status) == 'Published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Video Link (YouTube / Vimeo / etc.)</label>
                    <input type="url" class="form-control border-success rounded-3" name="video_link" placeholder="https://" value="{{ old('video_link', $gallery->video_link) }}">
                    @error('video_link')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Deskripsi</label>
                    <textarea class="form-control border-success rounded-3" name="description" rows="4">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Gambar Galeri Saat Ini</label>
                    <div class="row" id="existing-gallery-images">
                        @forelse ($gallery->images as $image)
                        <div class="col-md-3 mb-3 text-center position-relative" data-image-id="{{ $image->id }}">
                            <img src="{{ asset('storage/' . $image->image) }}"
                            class="img-fluid rounded-3 border gallery-preview"
                            style="object-fit: cover; height: 150px; width: 100%; cursor: pointer;"
                            id="preview_{{ $image->id }}"
                            onclick="document.getElementById('input_{{ $image->id }}').click();">

                            <input type="file" name="update_images[{{ $image->id }}]"
                            accept="image/*"
                            class="form-control mt-2 d-none gallery-input"
                            data-preview="preview_{{ $image->id }}"
                            id="input_{{ $image->id }}">
                            <div class="d-flex justify-content-between mt-2">
                                <div class="form-check">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="form-check-input" id="delete_{{ $image->id }}">
                                    <label for="delete_{{ $image->id }}" class="form-check-label">Hapus</label>
                                </div>
                            </div>
                            @error('update_images.' . $image->id)
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        @empty
                            <p class="text-secondary">Tidak ada gambar galeri saat ini.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Tambah Gambar Galeri Baru</label>
                    <div id="gallery-image-container">
                        <div class="input-group mb-2">
                            <input type="file" name="gallery_images[]" accept="image/*" class="form-control border-success rounded-start">
                            <button type="button" class="btn btn-danger remove-gallery-image">Remove</button>
                        </div>
                        @error('gallery_images')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('gallery_images.*')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" id="add-gallery-image" class="btn btn-primary btn-sm mt-2">
                        <i class="fas fa-plus me-1"></i> Add More Images
                    </button>
                </div>

                <div id="content-container">
                    @foreach ($gallery->subtitles->sortBy('order_number') as $i => $subtitle)
                    <div class="content-group mb-4 border-0">
                        <label class="form-label text-secondary fw-medium">Subtitle</label>
                        <input type="text" name="contents[{{ $i }}][id]" value="{{ $subtitle->id }}" hidden>
                        <input type="text" name="contents[{{ $i }}][subtitle]" value="{{ old('contents.' . $i . '.subtitle', $subtitle->subtitle) }}" class="form-control border-success rounded-3 mb-3" required>
                        @error('contents.' . $i . '.subtitle')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror

                        <div class="paragraph-container">
                            @foreach ($subtitle->contents->sortBy('order_number') as $j => $content)
                            <div class="mb-3 paragraph-item">
                                <label class="form-label text-secondary fw-medium">Paragraph</label>
                                <input type="text" name="contents[{{ $i }}][paragraphs][{{ $j }}][id]" value="{{ $content->id }}" hidden>
                                <textarea name="contents[{{ $i }}][paragraphs][{{ $j }}][content]" class="form-control border-success rounded-3 mb-3" rows="4" required>{{ old('contents.' . $i . '.paragraphs.' . $j . '.content', $content->content) }}</textarea>
                                <button type="button" class="btn btn-danger btn-sm remove-paragraph">Remove Paragraph</button>
                                @error('contents.' . $i . '.paragraphs.' . $j . '.content')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-primary btn-sm add-paragraph">Add Paragraph</button>
                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-subtitle">Remove Subtitle</button>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mb-4">
                    <button type="button" id="add-subtitle-group" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-plus me-1"></i> Add Subtitle & Paragraph
                    </button>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success px-4 py-2">Update Galeri</button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary ms-2 px-4 py-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let subtitleIndex = {{ $gallery->subtitles->count() }};

    // Tambah subtitle dan paragraph
    document.getElementById('add-subtitle-group').addEventListener('click', function () {
        const container = document.getElementById('content-container');
        const group = document.createElement('div');
        group.classList.add('content-group', 'mb-4', 'border-0');
        group.innerHTML = `
            <label class="form-label text-secondary fw-medium">Subtitle</label>
            <input type="text" name="contents[${subtitleIndex}][subtitle]" class="form-control border-success rounded-3 mb-3" required>
            {{-- @error('contents.${subtitleIndex}.subtitle') --}}
            {{-- This error display should be handled on server-side render or more robust JS if dynamic --}}
            {{-- <div class="text-danger mt-1">{{ $message }}</div> --}}
            {{-- @enderror --}}
            <div class="paragraph-container">
                <div class="mb-3 paragraph-item">
                    <label class="form-label text-secondary fw-medium">Paragraph</label>
                    <textarea name="contents[${subtitleIndex}][paragraphs][0][content]" class="form-control border-success rounded-3 mb-3" rows="4" required></textarea>
                    <button type="button" class="btn btn-danger btn-sm remove-paragraph">Remove Paragraph</button>
                    {{-- @error('contents.${subtitleIndex}.paragraphs.0.content') --}}
                    {{-- <div class="text-danger mt-1">{{ $message }}</div> --}}
                    {{-- @enderror --}}
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm add-paragraph">Add Paragraph</button>
            <button type="button" class="btn btn-danger btn-sm ms-2 remove-subtitle">Remove Subtitle</button>
        `;
        container.appendChild(group);
        subtitleIndex++;
    });

    // Dynamic paragraph and subtitle
    document.getElementById('content-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('add-paragraph')) {
            const group = e.target.closest('.content-group');
            const subtitleInput = group.querySelector('input[name^="contents"]');
            const subtitleMatch = subtitleInput.name.match(/contents\[(\d+)\]/);
            const index = subtitleMatch ? subtitleMatch[1] : 0;
            const paragraphContainer = group.querySelector('.paragraph-container');
            const paragraphCount = paragraphContainer.querySelectorAll('.paragraph-item').length; // Hitung item paragraph

            const div = document.createElement('div');
            div.classList.add('mb-3', 'paragraph-item');
            div.innerHTML = `
                <label class="form-label text-secondary fw-medium">Paragraph</label>
                <textarea name="contents[${index}][paragraphs][${paragraphCount}][content]" class="form-control border-success rounded-3 mb-3" rows="4" required></textarea>
                <button type="button" class="btn btn-danger btn-sm remove-paragraph">Remove Paragraph</button>
            `;
            paragraphContainer.appendChild(div);
        }

        if (e.target.classList.contains('remove-paragraph')) {
            e.target.closest('div.mb-3').remove();
        }

        if (e.target.classList.contains('remove-subtitle')) {
            e.target.closest('.content-group').remove();
        }
    });

    // Tambah gambar baru
    document.getElementById('add-gallery-image').addEventListener('click', function () {
        const container = document.getElementById('gallery-image-container');
        const div = document.createElement('div');
        div.classList.add('input-group', 'mb-2');
        div.innerHTML = `
            <input type="file" name="gallery_images[]" accept="image/*" class="form-control border-success rounded-start" required>
            <button type="button" class="btn btn-danger remove-gallery-image">Remove</button>
        `;
        container.appendChild(div);
    });

    document.getElementById('gallery-image-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-gallery-image')) {
            e.target.closest('.input-group').remove();
        }
    });

    // Preview thumbnail
    document.getElementById('thumbnail').addEventListener('change', function (e) {
        const previewImg = document.getElementById('thumbnail-preview-img');
        const previewOverlay = document.getElementById('thumbnail-overlay');

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none'); // Show image
                previewOverlay.style.display = 'none'; // Hide overlay
            };
            reader.readAsDataURL(e.target.files[0]);
        } else {
            // If no file is selected or file is removed
            if (previewImg.src && previewImg.src !== '#') { // If there was an image, clear it
                previewImg.src = '#';
                previewImg.classList.add('d-none');
            }
            previewOverlay.style.display = 'flex'; // Show overlay again
        }
    });


    document.querySelectorAll('.gallery-input').forEach(input => {
        input.addEventListener('change', function (e) {
            const previewId = e.target.dataset.preview;
            const preview = document.getElementById(previewId);
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>
@endpush
@endsection
