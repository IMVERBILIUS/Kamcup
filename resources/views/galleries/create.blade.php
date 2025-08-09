@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.galleries.index') }}" class="btn px-4 py-2"
            style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-medium">Thumbnail</label>
                        <div class="position-relative border rounded-3 d-flex align-items-center justify-content-center" style="height: 240px;">
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="position-absolute w-100 h-100 opacity-0 cursor-pointer" style="z-index: 3;">
                            <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center border border-success bg-white rounded-3" style="pointer-events: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#36b37e" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                </svg>
                            </div>
                        </div>
                        @error('thumbnail')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        {{-- MENAMBAHKAN FIELD TITLE --}}
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Judul Galeri</label>
                            <input type="text" class="form-control border-success rounded-3" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Nama Turnamen</label>
                            <input type="text" class="form-control border-success rounded-3" name="tournament_name" value="{{ old('tournament_name') }}">
                            @error('tournament_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Author</label>
                            <input type="text" class="form-control border-success rounded-3" name="author" value="{{ old('author') }}">
                            @error('author')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-medium">Status</label>
                            <select name="status" class="form-select border-success rounded-3" required>
                                <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Video Link (YouTube / Vimeo / etc.)</label>
                    <input type="url" class="form-control border-success rounded-3" name="video_link" placeholder="https://" value="{{ old('video_link') }}">
                    @error('video_link')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Deskripsi</label>
                    <textarea class="form-control border-success rounded-3" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Gallery Images</label>
                    <div id="gallery-image-container">
                        <div class="input-group mb-2">
                            <input type="file" name="gallery_images[]" accept="image/*" class="form-control border-success rounded-start preview-gallery-image" required>
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
                    <div class="content-group mb-4 border-0">
                        <label class="form-label text-secondary fw-medium">Subtitle</label>
                        <input type="text" name="contents[0][subtitle]" class="form-control border-success rounded-3 mb-3" value="{{ old('contents.0.subtitle') }}" required>
                        @error('contents.0.subtitle')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror

                        <div class="paragraph-container">
                            <label class="form-label text-secondary fw-medium">Paragraph</label>
                            <textarea name="contents[0][paragraphs][0][content]" class="form-control border-success rounded-3 mb-3" rows="4" required>{{ old('contents.0.paragraphs.0.content') }}</textarea>
                            @error('contents.0.paragraphs.0.content')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="button" class="btn btn-primary btn-sm add-paragraph">Add Paragraph</button>
                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-subtitle">Remove Subtitle</button>
                    </div>
                    {{-- Error messages for dynamically added contents will show if you try to submit with errors --}}
                    @error('contents')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <button type="button" id="add-subtitle-group" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-plus me-1"></i> Add Subtitle & Paragraph
                    </button>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success px-4 py-2">Simpan Dokumentasi</button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary ms-2 px-4 py-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let subtitleIndex = 1;

    document.getElementById('add-subtitle-group').addEventListener('click', function () {
        const container = document.getElementById('content-container');
        const group = document.createElement('div');
        group.classList.add('content-group', 'mb-4', 'border-0');
        group.innerHTML = `
            <label class="form-label text-secondary fw-medium">Subtitle</label>
            <input type="text" name="contents[${subtitleIndex}][subtitle]" class="form-control border-success rounded-3 mb-3" required>

            <div class="paragraph-container">
                <label class="form-label text-secondary fw-medium">Paragraph</label>
                <textarea name="contents[${subtitleIndex}][paragraphs][0][content]" class="form-control border-success rounded-3 mb-3" rows="4" required></textarea>
            </div>

            <button type="button" class="btn btn-primary btn-sm add-paragraph">Add Paragraph</button>
            <button type="button" class="btn btn-danger btn-sm ms-2 remove-subtitle">Remove Subtitle</button>
        `;
        container.appendChild(group);
        subtitleIndex++;
    });

    document.getElementById('content-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('add-paragraph')) {
            const group = e.target.closest('.content-group');
            const subtitleInput = group.querySelector('input[name^="contents"]');
            const subtitleMatch = subtitleInput.name.match(/contents\[(\d+)\]/);
            const index = subtitleMatch ? subtitleMatch[1] : 0;

            const paragraphContainer = group.querySelector('.paragraph-container');
            const paragraphCount = paragraphContainer.querySelectorAll('textarea[name^="contents[' + index + '][paragraphs]"]').length; // Lebih spesifik

            const div = document.createElement('div');
            div.classList.add('mb-3');
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

    // Add/remove gallery images
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

    // Thumbnail preview
    document.getElementById('thumbnail').addEventListener('change', function (e) {
        const parent = e.target.parentElement;
        const overlay = parent.querySelector('div');
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                let preview = parent.querySelector('img');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.classList.add('position-absolute', 'w-100', 'h-100');
                    preview.style.objectFit = 'cover';
                    parent.appendChild(preview);
                }
                preview.src = e.target.result;
                overlay.style.display = 'none';
            }
            reader.readAsDataURL(e.target.files[0]);
        } else { // Jika file dihapus atau tidak ada
            let preview = parent.querySelector('img');
            if (preview) {
                preview.remove();
            }
            overlay.style.display = 'flex'; // Tampilkan kembali overlay
        }
    });
</script>
@endpush
@endsection
