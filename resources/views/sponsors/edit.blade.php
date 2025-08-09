@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.sponsors.index') }}" class="btn px-4 py-2"
            style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <!-- Logo Upload -->
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-medium">Logo</label>
                        <div class="position-relative border rounded-3 d-flex align-items-center justify-content-center" style="height: 240px;">
                            <input type="file" id="logo" name="logo" accept="image/*"
                                class="position-absolute w-100 h-100 opacity-0 cursor-pointer" style="z-index: 3;">

                            @if ($sponsor->logo)
                                <img src="{{ asset('storage/' . $sponsor->logo) }}"
                                     class="position-absolute w-100 h-100"
                                     style="object-fit: contain;">
                            @else
                                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center border border-success bg-white rounded-3" style="pointer-events: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#36b37e" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('logo')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Fields -->
                    <div class="col-md-6">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-medium">Sponsor Name</label>
                                <input type="text" class="form-control border-success rounded-3" name="name"
                                    value="{{ old('name', $sponsor->name) }}" required>
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary fw-medium">Sponsor Size</label>
                                <select name="sponsor_size" class="form-select border-success rounded-3" required>
                                    <option value="" disabled>-- Select Size --</option>
                                    @foreach(['xxl', 'xl', 'l', 'm', 's'] as $size)
                                        <option value="{{ $size }}" {{ old('sponsor_size', $sponsor->sponsor_size) == $size ? 'selected' : '' }}>
                                            {{ strtoupper($size) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sponsor_size')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label text-secondary fw-medium">Description</label>
                    <textarea class="form-control border-success rounded-3" name="description" rows="3">{{ old('description', $sponsor->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success px-4 py-2">Update Sponsor</button>
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
    document.getElementById('logo').addEventListener('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const parent = document.getElementById('logo').parentElement;
                const existingImg = parent.querySelector('img');
                const overlay = parent.querySelector('div');

                if (existingImg) {
                    existingImg.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('position-absolute', 'w-100', 'h-100');
                    img.style.objectFit = 'contain';
                    parent.appendChild(img);
                }

                if (overlay) overlay.style.display = 'none';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush

@endsection
