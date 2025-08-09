@extends('layouts.admin')

@section('content')
<style>
/* Custom select dropdown styling, updated for consistency */
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

.custom-select-dropdown option {
    font-weight: normal;
}

.logo-img {
    width: 120px;
    height: 60px;
    object-fit: contain;
    border-radius: 0.375rem; /* Consistent rounded corners */
}
</style>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between mb-4">
        {{-- Adjusted route for 'Back' button to admin.sponsors.index --}}
        <a href="{{ route('admin.sponsors.index') }}" class="btn px-4 py-2"
            style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        {{-- Added required indicator and size/type info --}}
                        <label class="form-label text-secondary fw-medium">Logo <span class="text-danger">*</span> <small class="text-muted">(Max 2MB, JPG, PNG, WebP)</small></label>
                        <div class="position-relative border rounded-3 d-flex align-items-center justify-content-center @error('logo') border-danger @enderror" style="height: 240px;">
                            <input type="file" id="logo" name="logo" accept="image/*" required
                                class="position-absolute w-100 h-100 opacity-0 cursor-pointer" style="z-index: 3;">
                            <div id="logo-preview-overlay" class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center border border-success bg-white rounded-3" style="pointer-events: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#36b37e" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                </svg>
                            </div>
                            {{-- Added an ID to the image preview for easier manipulation --}}
                            <img id="logo-image-preview" src="#" alt="Logo Preview" class="position-absolute w-100 h-100 d-none" style="object-fit: contain; border-radius: 0.25rem;">
                        </div>
                        @error('logo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-medium">Sponsor Name</label>
                                {{-- Added is-invalid class --}}
                                <input type="text" class="form-control border-success rounded-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary fw-medium">Sponsor Size</label>
                                {{-- Added is-invalid class --}}
                                <select name="sponsor_size" class="form-select border-success rounded-3 @error('sponsor_size') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('sponsor_size') ? '' : 'selected' }}>-- Select Size --</option>
                                    <option value="xxl" {{ old('sponsor_size') == 'xxl' ? 'selected' : '' }}>XXL</option>
                                    <option value="xl" {{ old('sponsor_size') == 'xl' ? 'selected' : '' }}>XL</option>
                                    <option value="l" {{ old('sponsor_size') == 'l' ? 'selected' : '' }}>L</option>
                                    <option value="m" {{ old('sponsor_size') == 'm' ? 'selected' : '' }}>M</option>
                                    <option value="s" {{ old('sponsor_size') == 's' ? 'selected' : '' }}>S</option>
                                </select>
                                @error('sponsor_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Description</label>
                    {{-- Added is-invalid class --}}
                    <textarea class="form-control border-success rounded-3 @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success px-4 py-2">Save Sponsor</button>
                    {{-- Adjusted route for 'Cancel' button to admin.sponsors.index --}}
                    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline-secondary ms-2 px-4 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #24E491;
        box-shadow: 0 0 0 0.25rem rgba(36, 228, 145, 0.25);
    }

    .btn-primary {
        background-color: #5932EA;
        border-color: #5932EA;
    }

    .btn-primary:hover {
        background-color: #4920D5;
        border-color: #4920D5;
    }

    .btn-success {
        background-color: #24E491;
        border-color: #24E491;
    }

    .btn-success:hover {
        background-color: #1fb47a;
        border-color: #1fb47a;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('logo');
        const logoImagePreview = document.getElementById('logo-image-preview');
        const logoPreviewOverlay = document.getElementById('logo-preview-overlay');

        logoInput.addEventListener('change', function (e) {
            if (e.target.files && e.target.files[0]) {
                const file = e.target.files[0];
                const fileSize = file.size / (1024 * 1024); // Size in MB
                const maxFileSize = 2; // Max size in MB (corresponds to 2048 KB in backend validation)

                // Client-side validation for file size
                if (fileSize > maxFileSize) {
                    alert(`Ukuran logo tidak boleh lebih dari ${maxFileSize} MB.`);
                    logoInput.value = ''; // Clear the selected file
                    logoImagePreview.src = '#';
                    logoImagePreview.classList.add('d-none');
                    logoPreviewOverlay.classList.remove('d-none');
                    return; // Stop further processing
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    logoImagePreview.src = event.target.result;
                    logoImagePreview.classList.remove('d-none');
                    logoPreviewOverlay.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                logoImagePreview.src = '#';
                logoImagePreview.classList.add('d-none');
                logoPreviewOverlay.classList.remove('d-none');
            }
        });

        // If there's an old value for logo (e.g., after validation error with a file)
        // this part would typically be for an 'edit' form, but included for completeness
        // in case old() can store temp file paths, though usually it only stores string path
        // if ('{{ old('logo') }}') { // This check is mostly for edit forms with existing images
        //     logoImagePreview.src = '{{ asset('storage/' . old('logo')) }}';
        //     logoImagePreview.classList.remove('d-none');
        //     logoPreviewOverlay.classList.add('d-none');
        // }
    });
</script>
@endpush

@endsection
