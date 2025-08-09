@extends('../layouts/master_nav') {{-- Make sure this points to your main layout file (e.g., master_nav or master) --}}

@section('title', 'Ajukan Permintaan Host Turnamen')

@section('content')
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container py-4">
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('profile.index') }}" class="btn px-4 py-2"
                style="background-color: #F0F5FF; border-radius: 8px; color: #00617a;">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Profil
            </a>
        </div>

        <div class="text-center mb-5 p-4 rounded-4" style="background-color: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <h1 class="fw-bold mb-3 article-text" style="color: #00617a;">Ajukan Permintaan Tuan Rumah</h1>
            <p class="text-muted w-75 mx-auto article-text">
                Bersama KAMCUP, wujudkan **visi sporty** Anda! Isi formulir di bawah ini untuk mengajukan diri sebagai tuan rumah turnamen kami.
                Kami menantikan **kolaborasi** yang **inspiratif** untuk **pertumbuhan** komunitas voli!
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-4 p-lg-5 rounded-4" style="background-color: #ffffff; box-shadow: 0 10px 30px rgba(108, 99, 255, 0.08);">
                    <h4 class="fw-semibold mb-4 article-text" style="color: #343a40;">Formulir Pengajuan</h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('host-request.store') }}" method="POST">
                        @csrf

                        {{-- Input Nama Penanggung Jawab --}}
                        <div class="mb-3">
                            <label for="responsible_name" class="form-label">Nama Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('responsible_name') is-invalid @enderror" id="responsible_name" name="responsible_name" value="{{ old('responsible_name', Auth::user()->name ?? '') }}" required
                                   placeholder="Nama lengkap penanggung jawab" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">
                            @error('responsible_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required
                                   placeholder="Alamat email aktif" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Nomor Telepon --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required
                                   placeholder="Contoh: 081234567890" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3 profile-section-title">Detail Turnamen yang Diajukan</h5>

                        {{-- Input Judul Turnamen --}}
                        <div class="mb-3">
                            <label for="tournament_title" class="form-label">Judul Turnamen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tournament_title') is-invalid @enderror" id="tournament_title" name="tournament_title" value="{{ old('tournament_title') }}" required
                                   placeholder="Contoh: KAMCUP Volley League 2025" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">
                            @error('tournament_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Nama Lokasi/Venue --}}
                        <div class="mb-3">
                            <label for="venue_name" class="form-label">Nama Lokasi/Venue <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('venue_name') is-invalid @enderror" id="venue_name" name="venue_name" value="{{ old('venue_name') }}" required
                                   placeholder="Contoh: GOR Olahraga KAMCUP" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">
                            @error('venue_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Alamat Lokasi --}}
                        <div class="mb-3">
                            <label for="venue_address" class="form-label">Alamat Lokasi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('venue_address') is-invalid @enderror" id="venue_address" name="venue_address" rows="3" required
                                      placeholder="Alamat lengkap lokasi turnamen (jalan, nomor, kota, provinsi)" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">{{ old('venue_address') }}</textarea>
                            @error('venue_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Estimasi Kapasitas Penonton/Peserta --}}
                        <div class="mb-3">
                            <label for="estimated_capacity" class="form-label">Estimasi Kapasitas <small class="text-muted">(Jumlah Orang)</small></label>
                            <input type="number" class="form-control @error('estimated_capacity') is-invalid @enderror" id="estimated_capacity" name="estimated_capacity" value="{{ old('estimated_capacity') }}" min="0"
                                   placeholder="Contoh: 100" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">
                            @error('estimated_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Tanggal yang Diusulkan --}}
                        <div class="mb-3">
                            <label for="proposed_date" class="form-label">Tanggal Pelaksanaan yang Diusulkan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('proposed_date') is-invalid @enderror" id="proposed_date" name="proposed_date" value="{{ old('proposed_date') }}" required
                                   style="background-color: #f4f4f4; border: 1px solid #dee2e6;">
                            @error('proposed_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Fasilitas yang Tersedia --}}
                        <div class="mb-3">
                            <label for="available_facilities" class="form-label">Fasilitas yang Tersedia <small class="text-muted">(Contoh: Lapangan Voli, Ruang Ganti, Toilet, Tribune)</small></label>
                            <textarea class="form-control @error('available_facilities') is-invalid @enderror" id="available_facilities" name="available_facilities" rows="3"
                                      placeholder="Sebutkan fasilitas utama yang bisa digunakan di venue" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">{{ old('available_facilities') }}</textarea>
                            @error('available_facilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Catatan Tambahan --}}
                        <div class="mb-4">
                            <label for="notes" class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                                      placeholder="Sampaikan detail atau harapan lain tentang pengajuan Anda" style="background-color: #f4f4f4; border: 1px solid #dee2e6;">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Ajukan Permintaan</button>
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
    {{-- Assuming profile.css defines common profile-related styles --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        /* Additional styles for the host request page, mimicking profile edit styles */
        .profile-edit-card {
            border-radius: 12px;
            box-shadow:
                8px 8px 0px 0px var(--kamcup-yellow), /* Bold yellow shadow */
                5px 5px 15px rgba(0, 0, 0, 0.1) !important; /* Soft background shadow */
            position: relative;
            z-index: 1;
            border: 1px solid #dee2e6;
        }

        .profile-section-title {
            color: #212529; /* Default dark text color */
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        /* Overriding button colors to match KAMCUP brand identity */
        .btn-primary {
            background-color: var(--kamcup-yellow) !important; /* KAMCUP Yellow */
            border-color: var(--kamcup-yellow) !important;
            color: var(--kamcup-dark-text) !important; /* Dark text for contrast */
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #e0ac00 !important; /* Slightly darker yellow on hover */
            border-color: #e0ac00 !important;
        }

        .btn-outline-secondary {
            color: #6c757d !important;
            border-color: #6c757d !important;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d !important;
            color: white !important;
        }

        /* KAMCUP brand color variables (ensure these are defined globally in your main CSS or layout) */
        :root {
            --kamcup-pink: #cb2786;
            --kamcup-blue-green: #00617a;
            --kamcup-yellow: #f4b704;
            --kamcup-dark-text: #212529;
        }
    </style>
@endpush

@push('scripts')
    {{-- No custom JS needed for this form unless there are specific dynamic behaviors --}}
@endpush
