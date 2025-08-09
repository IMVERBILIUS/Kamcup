{{-- resources/views/front/team_members/create.blade.php --}}

@extends('../layouts/master_nav')

@section('title', 'Tambah Anggota Tim')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Kartu Tambah Anggota Tim --}}
            <div class="card shadow-sm profile-edit-card">
                <div class="card-header bg-white text-center py-3">
                    <h4 class="mb-0 profile-section-title">Tambah Anggota Tim untuk {{ $team->name }}</h4>
                </div>
                <div class="card-body">
                    {{-- Form untuk Tambah Anggota Tim --}}
                    <form action="{{ route('team.members.store', \Illuminate\Support\Facades\Crypt::encryptString($team->id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Input Foto Anggota --}}
                        <div class="mb-4 text-center">
                            <label for="photo" class="form-label d-block mb-3 profile-photo-upload-area">
                                <div class="profile-photo-wrapper mb-2">
                                    {{-- Placeholder untuk preview foto anggota --}}
                                    <img src="{{ asset('assets/img/profile-placeholder.png') }}" {{-- Ganti dengan placeholder anggota default --}}
                                         alt="Foto Anggota" class="img-fluid editable-profile-photo" width="120" height="120">
                                    <div class="profile-photo-overlay">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                </div>
                                <div class="btn btn-sm btn-outline-secondary d-block mx-auto upload-button">Pilih Foto</div>
                            </label>
                            <input type="file" class="form-control d-none" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maksimal ukuran 2MB (jpeg, png, jpg, gif).</small>
                        </div>

                        {{-- Input Nama Anggota --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap Anggota</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Tanggal Lahir --}}
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Jenis Kelamin --}}
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Posisi --}}
                        <div class="mb-3">
                            <label for="position" class="form-label">Posisi (Opsional)</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}" placeholder="Contoh: Striker, Midfielder">
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Nomor Punggung (Jersey Number) --}}
                        <div class="mb-3">
                            <label for="jersey_number" class="form-label">Nomor Punggung (Opsional)</label>
                            <input type="number" class="form-control @error('jersey_number') is-invalid @enderror" id="jersey_number" name="jersey_number" value="{{ old('jersey_number') }}" min="1" max="99">
                            @error('jersey_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Kontak Anggota --}}
                        <div class="mb-3">
                            <label for="contact" class="form-label">Kontak Anggota (Opsional)</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact') }}" placeholder="No. Telepon atau Link Sosial Media">
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Email Anggota --}}
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Anggota (Opsional, Unik)</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Tambah Anggota</button>
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        /* Gaya tambahan khusus untuk halaman tambah anggota tim, meniru edit.profile */
        .profile-edit-card {
            border-radius: 12px;
            box-shadow:
                8px 8px 0px 0px var(--shadow-color-cf2585),
                5px 5px 15px rgba(0, 0, 0, 0.1) !important;
            position: relative;
            z-index: 1;
            border: 1px solid #dee2e6;
        }

        .profile-section-title {
            color: #212529;
            font-weight: 600;
        }

        /* Gaya untuk area upload foto/logo, sama dengan edit.blade.php */
        .profile-photo-upload-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            width: fit-content;
            margin: 0 auto;
            position: relative;
        }

        .profile-photo-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 10px; /* Gunakan radius yang sama dengan edit.profile */
            overflow: hidden;
            border: 2px solid #eee;
        }

        .editable-profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        .profile-photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 10px; /* Cocokkan dengan radius wrapper */
        }

        .profile-photo-overlay .fas {
            color: #fff;
            font-size: 2rem;
        }

        .profile-photo-upload-area:hover .profile-photo-overlay {
            opacity: 1;
        }

        .upload-button {
            width: 120px;
            margin-top: 10px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        :root {
            --shadow-color-cf2585: #cf2585; /* Pastikan ini didefinisikan atau diimpor */
        }
    </style>
@endpush

@push('scripts')
    {{-- Pastikan Font Awesome sudah terhubung di master_nav.blade.php jika menggunakan ikon fas fa-camera --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const photoInput = document.getElementById('photo');
            const photoPreview = document.querySelector('.editable-profile-photo');
            const photoUploadArea = document.querySelector('.profile-photo-upload-area');

            photoUploadArea.addEventListener('click', function(event) {
                if (event.target !== photoInput) {
                    event.preventDefault();
                    photoInput.click();
                }
            });

            function previewImage(inputElement, previewElement) {
                if (inputElement.files && inputElement.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                    };
                    reader.readAsDataURL(inputElement.files[0]);
                }
            }

            photoInput.addEventListener('change', function(event) {
                previewImage(event.target, photoPreview);
            });
        });
    </script>
@endpush
