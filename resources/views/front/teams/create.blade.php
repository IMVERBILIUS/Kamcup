{{-- resources/views/teams/create.blade.php --}}

@extends('../layouts/master_nav') {{-- Pastikan ini mengacu pada master layout yang sama dengan edit.blade.php --}}

@section('title', 'Buat Tim Baru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Kartu Buat Tim --}}
            <div class="card shadow-sm profile-edit-card"> {{-- Menggunakan kelas yang sama dengan edit.blade.php --}}
                <div class="card-header bg-white text-center py-3">
                    <h4 class="mb-0 profile-section-title">Buat Tim Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf {{-- Token CSRF untuk keamanan form Laravel --}}

                        {{-- Input Logo Tim --}}
                        <div class="mb-4 text-center"> {{-- Mengikuti gaya foto profil di edit.blade.php --}}
                            <label for="logo" class="form-label d-block mb-3 profile-photo-upload-area">
                                <div class="profile-photo-wrapper mb-2">
                                    {{-- Placeholder untuk preview logo tim, bisa menggunakan gambar default --}}
                                    <img src="{{ asset('assets/img/team-placeholder.png') }}" {{-- Ganti dengan placeholder logo tim Anda --}}
                                         alt="Team Logo" class="img-fluid editable-profile-photo" width="120" height="120">
                                    <div class="profile-photo-overlay">
                                        <i class="fas fa-camera"></i> {{-- Ikon kamera --}}
                                    </div>
                                </div>
                                <div class="btn btn-sm btn-outline-secondary d-block mx-auto upload-button">Pilih Logo</div>
                            </label>
                            <input type="file" class="form-control d-none" id="logo" name="logo" accept="image/*" required>
                            @error('logo')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maksimal ukuran 2MB (jpeg, png, jpg, gif).</small>
                        </div>

                        {{-- Input Nama Tim --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Tim</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Nama Manajer --}}
                        <div class="mb-3">
                            <label for="manager_name" class="form-label">Nama Manajer</label>
                            <input type="text" class="form-control @error('manager_name') is-invalid @enderror" id="manager_name" name="manager_name" value="{{ old('manager_name') }}" required>
                            @error('manager_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Kontak Tim --}}
                        <div class="mb-3">
                            <label for="contact" class="form-label">Kontak Tim</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact') }}" required>
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Lokasi Tim --}}
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi Tim</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Kategori Gender Tim --}}
                        <div class="mb-3">
                            <label for="gender_category" class="form-label">Kategori Gender Tim</label>
                            <select class="form-select @error('gender_category') is-invalid @enderror" id="gender_category" name="gender_category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="male" {{ old('gender_category') == 'male' ? 'selected' : '' }}>Pria</option>
                                <option value="female" {{ old('gender_category') == 'female' ? 'selected' : '' }}>Wanita</option>
                                <option value="mixed" {{ old('gender_category') == 'mixed' ? 'selected' : '' }}>Campuran</option>
                            </select>
                            @error('gender_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Jumlah Anggota (misal: 1-10) --}}
                        <div class="mb-3">
                            <label for="member_count" class="form-label">Jumlah Anggota</label>
                            <input type="number" class="form-control @error('member_count') is-invalid @enderror" id="member_count" name="member_count" value="{{ old('member_count', 1) }}" min="1" max="10" required>
                            @error('member_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan jumlah anggota tim (misal: 5).</small>
                        </div>

                        {{-- Input Deskripsi Tim --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Tim (Opsional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4"> {{-- Mengikuti d-grid gap-2 yang sama --}}
                            <button type="submit" class="btn btn-primary btn-lg">Buat Tim</button>
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
    {{-- Memasukkan gaya yang sama dari profile.css dan gaya inline dari edit.blade.php --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}"> {{-- Pastikan profile.css di-load --}}
    <style>
        /* Gaya tambahan khusus untuk halaman buat tim, meniru edit.profile */
        .profile-edit-card {
            border-radius: 12px;
            box-shadow:
                8px 8px 0px 0px var(--shadow-color-cf2585), /* Shadow magenta tebal */
                5px 5px 15px rgba(0, 0, 0, 0.1) !important; /* Shadow lembut di belakang, dengan !important */
            position: relative;
            z-index: 1;
            border: 1px solid #dee2e6; /* Border tipis untuk konsistensi */
        }

        .profile-section-title {
            /* Gaya untuk judul di header card, jika ada kustomisasi */
            color: #212529; /* Warna teks gelap default */
            font-weight: 600; /* Misalnya lebih tebal */
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
            border-radius: 10px;
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
            border-radius: 10px;
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

        /* Definisi variabel warna jika belum ada di tempat lain, atau pastikan ini sesuai dengan branding Anda */
        :root {
            --shadow-color-cf2585: #cf2585; /* Ini harus sesuai dengan warna primer Anda atau warna yang digunakan di shadow */
        }
    </style>
@endpush

@push('scripts')
    {{-- Pastikan Font Awesome sudah terhubung jika menggunakan ikon fas fa-camera --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const logoInput = document.getElementById('logo');
            const logoPreview = document.querySelector('.editable-profile-photo');
            const logoUploadArea = document.querySelector('.profile-photo-upload-area');

            // Event listener untuk memicu klik input file saat area di klik
            logoUploadArea.addEventListener('click', function(event) {
                if (event.target !== logoInput) {
                    event.preventDefault();
                    logoInput.click();
                }
            });

            // Fungsi untuk menampilkan preview gambar
            function previewImage(inputElement, previewElement) {
                if (inputElement.files && inputElement.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                    };
                    reader.readAsDataURL(inputElement.files[0]);
                }
            }

            // Panggil fungsi previewImage saat input file berubah
            logoInput.addEventListener('change', function(event) {
                previewImage(event.target, logoPreview);
            });
        });
    </script>
@endpush
