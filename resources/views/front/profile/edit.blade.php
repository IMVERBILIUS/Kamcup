{{-- resources/views/front/profile/edit.blade.php --}}

@extends('../layouts/master_nav')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Kartu Edit Profil --}}
            <div class="card shadow-sm profile-edit-card fade-in-up">
                <div class="card-header bg-white text-center py-3 fade-in-up" data-delay="100">
                    {{-- Judul bagian edit profil, gaya diatur di CSS --}}
                    <h4 class="mb-0 profile-section-title">Edit Informasi Profile</h4>
                </div>
                <div class="card-body">
                    {{-- Form untuk Edit Profil --}}
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Gunakan metode PUT untuk update --}}

                        {{-- Input Foto Profil --}}
                        <div class="mb-4 text-center fade-in-up" data-delay="200">
                            <label for="profile_photo" class="form-label d-block mb-3 profile-photo-upload-area">
                                {{-- Kontainer untuk gambar preview --}}
                                <div class="profile-photo-wrapper mb-2">
                                    <img src="{{ Auth::user()->profile->profile_photo ? asset('storage/' . Auth::user()->profile->profile_photo) : asset('assets/img/profile-placeholder.png') }}"
                                         alt="Profile Photo" class="img-fluid editable-profile-photo" width="120" height="120">
                                    {{-- Overlay atau ikon edit bisa ditambahkan di sini untuk estetika --}}
                                    <div class="profile-photo-overlay">
                                        <i class="fas fa-camera"></i> </div>
                                </div>
                                <div class="btn btn-sm btn-outline-secondary d-block mx-auto upload-button">Ganti Foto</div>
                            </label>
                            <input type="file" class="form-control d-none" id="profile_photo" name="profile_photo" accept="image/*">
                            @error('profile_photo')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Nama --}}
                        <div class="mb-3 fade-in-up" data-delay="300">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->profile->name ?? Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Tanggal Lahir --}}
                        <div class="mb-3 fade-in-up" data-delay="400">
                            <label for="birthdate" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate', Auth::user()->profile->birthdate) }}">
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Jenis Kelamin --}}
                        <div class="mb-3 fade-in-up" data-delay="500">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Pilih Jenis Kelamin</option>
                                {{-- UBAH NILAI SESUAI DENGAN ENUM DATABASE: 'male', 'female' --}}
                                <option value="male" {{ old('gender', Auth::user()->profile->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', Auth::user()->profile->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                {{-- Hapus opsi 'Lainnya' jika ENUM database Anda tidak memiliki nilai 'other' --}}
                                {{-- Jika Anda ingin 'Lainnya', pastikan ENUM di database juga mencakup 'other' --}}
                                <option value="other" {{ old('gender', Auth::user()->profile->gender) == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Email (biasanya dari user model, mungkin tidak bisa diedit langsung di sini) --}}
                        <div class="mb-3 fade-in-up" data-delay="600">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" disabled>
                            <div class="form-text">Email tidak dapat diubah di sini.</div>
                        </div>

                        {{-- Input Nomor Telepon --}}
                        <div class="mb-3 fade-in-up" data-delay="700">
                            <label for="phone_number" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', Auth::user()->profile->phone_number) }}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Akun Sosial Media --}}
                        <div class="mb-4 fade-in-up" data-delay="800">
                            <label for="social_media" class="form-label">Akun Sosial Media (Link)</label>
                            <input type="url" class="form-control @error('social_media') is-invalid @enderror" id="social_media" name="social_media" value="{{ old('social_media', Auth::user()->profile->social_media) }}" placeholder="https://instagram.com/namapengguna">
                            @error('social_media')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 fade-in-up" data-delay="900">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
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
        /* Gaya tambahan khusus untuk halaman edit profil */
        .profile-edit-card {
            border-radius: 12px;
            /* Aplikasikan box-shadow yang diinginkan di sini */
            box-shadow:
                8px 8px 0px 0px var(--shadow-color-cf2585), /* Shadow magenta tebal */
                5px 5px 15px rgba(0, 0, 0, 0.1) !important; /* Shadow lembut di belakang, dengan !important */
            position: relative;
            z-index: 1;
            border: 1px solid #dee2e6; /* Border tipis untuk konsistensi */
        }

        .profile-photo-upload-area {
            display: flex;
            flex-direction: column; /* Mengatur item secara vertikal */
            align-items: center; /* Pusatkan item secara horizontal */
            cursor: pointer;
            width: fit-content; /* Sesuaikan lebar dengan kontennya */
            margin: 0 auto; /* Pusatkan area upload */
            position: relative; /* Untuk positioning overlay */
        }

        .profile-photo-wrapper {
            position: relative;
            width: 120px; /* Ukuran wrapper sama dengan gambar */
            height: 120px;
            border-radius: 10px; /* Border radius sama dengan gambar */
            overflow: hidden; /* Pastikan tidak ada yang keluar */
            border: 2px solid #eee; /* Border yang sama dengan gambar */
        }

        .editable-profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Penting untuk cropping gambar */
            transition: opacity 0.3s ease;
        }

        .profile-photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Warna overlay saat hover */
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0; /* Sembunyikan secara default */
            transition: opacity 0.3s ease;
            border-radius: 10px; /* Cocokkan dengan radius wrapper */
        }

        .profile-photo-overlay .fas {
            color: #fff;
            font-size: 2rem;
        }

        .profile-photo-upload-area:hover .profile-photo-overlay {
            opacity: 1; /* Tampilkan overlay saat hover pada area */
        }

        .upload-button {
            width: 120px; /* Sesuaikan lebar tombol dengan lebar foto */
            margin-top: 10px; /* Beri sedikit jarak dari foto */
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        /* Animasi Scroll - CSS Keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Class untuk elemen yang akan dianimasi */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        .slide-in-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.6s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        .slide-in-right {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.6s cubic-bezier(0.25, 0.25, 0.25, 1);
        }

        /* Class untuk elemen yang sudah terlihat */
        .fade-in-up.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-in-left.animate {
            opacity: 1;
            transform: translateX(0);
        }

        .slide-in-right.animate {
            opacity: 1;
            transform: translateX(0);
        }

        /* Animasi khusus untuk foto profil */
        .profile-photo-wrapper {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .fade-in-up.animate .profile-photo-wrapper {
            animation: bounceIn 0.8s ease-out;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Animasi untuk tombol */
        .btn {
            transition: all 0.3s ease;
        }

        .fade-in-up.animate .btn {
            animation: slideInFromBottom 0.6s ease-out;
        }

        @keyframes slideInFromBottom {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsif untuk mobile */
        @media (max-width: 768px) {
            .fade-in-up {
                transform: translateY(20px);
            }
            
            .slide-in-left,
            .slide-in-right {
                transform: translateY(20px);
            }
            
            .slide-in-left.animate,
            .slide-in-right.animate {
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('scripts')
    {{-- Pastikan Font Awesome sudah terhubung di master.blade.php jika menggunakan ikon fas fa-camera --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profilePhotoInput = document.getElementById('profile_photo');
            const profilePhotoPreview = document.querySelector('.editable-profile-photo');
            const profilePhotoUploadArea = document.querySelector('.profile-photo-upload-area');

            // HANYA SATU EVENT LISTENER DI SINI UNTUK MENCEGAH DOUBLE POP-UP
            profilePhotoUploadArea.addEventListener('click', function(event) {
                if (event.target !== profilePhotoInput) {
                    event.preventDefault();
                    profilePhotoInput.click();
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
            profilePhotoInput.addEventListener('change', function(event) {
                previewImage(event.target, profilePhotoPreview);
            });

            // SCROLL ANIMATION FUNCTIONALITY
            const animateElements = document.querySelectorAll('.fade-in-up, .slide-in-left, .slide-in-right');
            
            // Intersection Observer untuk deteksi scroll
            const observerOptions = {
                threshold: 0.1, // Trigger ketika 10% elemen terlihat
                rootMargin: '0px 0px -50px 0px' // Trigger sedikit sebelum elemen benar-benar terlihat
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        const delay = element.dataset.delay || 0;
                        
                        // Tambahkan delay sesuai dengan data-delay attribute
                        setTimeout(() => {
                            element.classList.add('animate');
                        }, delay);
                        
                        // Stop observing setelah animasi dijalankan
                        observer.unobserve(element);
                    }
                });
            }, observerOptions);

            // Observe semua elemen yang akan dianimasi
            animateElements.forEach(element => {
                observer.observe(element);
            });

            // Fallback untuk browser yang tidak support Intersection Observer
            if (!window.IntersectionObserver) {
                // Langsung tampilkan semua elemen tanpa animasi
                animateElements.forEach(element => {
                    element.classList.add('animate');
                });
            }

            // Optional: Animasi saat halaman pertama kali dimuat
            // Elemen pertama (kartu utama) akan langsung muncul
            const firstElement = document.querySelector('.profile-edit-card');
            if (firstElement) {
                setTimeout(() => {
                    firstElement.classList.add('animate');
                }, 200);
            }

            // Smooth scroll enhancement (optional)
            // Menambahkan smooth scrolling jika belum ada
            if (!document.documentElement.style.scrollBehavior) {
                document.documentElement.style.scrollBehavior = 'smooth';
            }
        });
    </script>
@endpush