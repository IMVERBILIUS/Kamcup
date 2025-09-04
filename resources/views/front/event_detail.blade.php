@extends('../layouts/master_nav')

@section('content')

    <div class="container px-4 px-lg-5 tournament-detail-page-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- Top Header Section (Back Button & Date) --}}
                <div class="d-flex justify-content-between align-items-center top-header-section mb-4 mt-4 scroll-animate"
                    data-animation="fadeInUp">
                    <a href="{{ route('front.events.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i> KEMBALI
                    </a>
                    <span class="date-info">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
                </div>

                {{-- Tournament Title --}}
                <h1 class="tournament-title scroll-animate" data-animation="fadeInLeft" data-delay="100">{{ $event->title }}
                </h1>

                {{-- Tournament Header Image --}}
                <div class="tournament-header-image-container mb-4 scroll-animate" data-animation="zoomIn" data-delay="200">
                    @if ($event->thumbnail)
                        <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="Event Thumbnail"
                            class="img-fluid rounded-lg tournament-thumbnail-img">
                    @else
                        <img src="https://via.placeholder.com/900x400/F4B704/00617A?text=Event+Image"
                            alt="Placeholder Thumbnail" class="img-fluid rounded-lg tournament-thumbnail-img">
                    @endif
                </div>

                {{-- Summary Boxes --}}
                <div class="summary-boxes-container row g-0 mb-4 scroll-animate" data-animation="fadeInUp" data-delay="300">
                    <div class="col-6">
                        <div class="summary-box tournament-status">
                            <span class="label">Status Event</span>
                            <span class="value">{{ ucfirst($event->status) }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="summary-box total-participants">
                            <span class="label">Jumlah Partisipan (Dikonfirmasi)</span>
                            <span
                                class="value">{{ $event->registrations->where('status', 'confirmed')->count() ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                {{-- Navigation Tabs and Content --}}
                <div class="tabs-section mb-5 scroll-animate" data-animation="fadeInUp" data-delay="400">
                    <ul class="nav nav-pills custom-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="peraturan-tab" data-bs-toggle="tab"
                                data-bs-target="#peraturan" type="button" role="tab" aria-controls="peraturan"
                                aria-selected="true">Peraturan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="event-detail-tab" data-bs-toggle="tab"
                                data-bs-target="#event-detail" type="button" role="tab" aria-controls="event-detail"
                                aria-selected="false">Detail Event</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="partisipan-tab" data-bs-toggle="tab" data-bs-target="#partisipan"
                                type="button" role="tab" aria-controls="partisipan"
                                aria-selected="false">Partisipan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-person-tab" data-bs-toggle="tab"
                                data-bs-target="#contact-person" type="button" role="tab"
                                aria-controls="contact-person" aria-selected="false">Contact Person</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="jadwal-pertandingan-tab" data-bs-toggle="tab"
                                data-bs-target="#jadwal-pertandingan" type="button" role="tab"
                                aria-controls="jadwal-pertandingan" aria-selected="false">Jadwal Pertandingan</button>
                        </li>
                        <li class="nav-item ms-auto social-icon-wrapper">
                            <a href="https://twitter.com" target="_blank" class="nav-link twitter-icon">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content custom-tab-content mt-3" id="myTabContent">
                        {{-- Peraturan Tab Content --}}
                        <div class="tab-pane fade show active" id="peraturan" role="tabpanel"
                            aria-labelledby="peraturan-tab">
                            <h5 class="tab-content-title">PERATURAN EVENT</h5>
                            @forelse($event->rules ?? [] as $rule)
                                <div class="rule-section mb-4">
                                    @php
                                        $ruleContent = trim($rule->rule_text);
                                        $categoryTitle = null;
                                        $rulePoints = [];

                                        if (preg_match('/^([A-Z\s]+?)\s*:\s*(.*)/s', $ruleContent, $matches)) {
                                            $categoryTitle = $matches[1];
                                            $remainingText = trim($matches[2]);
                                            $rulePoints = preg_split('/(?<=[.!?])\s+(?=[A-Z0-9(])/', $remainingText);
                                            $rulePoints = array_filter($rulePoints, 'trim');
                                        } else {
                                            $rulePoints = preg_split('/(?<=[.!?])\s+(?=[A-Z0-9(])/', $ruleContent);
                                            $rulePoints = array_filter($rulePoints, 'trim');
                                        }
                                    @endphp

                                    @if ($categoryTitle)
                                        <h6 class="rule-category-title">{{ $categoryTitle }}</h6>
                                        @if (count($rulePoints) > 0)
                                            <ul class="rules-list-detailed">
                                                @foreach ($rulePoints as $point)
                                                    <li><i class="fas fa-caret-right rule-bullet-icon me-2"></i>
                                                        {{ trim($point) }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        @if (count($rulePoints) > 0)
                                            <ul class="rules-list-detailed">
                                                @foreach ($rulePoints as $point)
                                                    <li><i class="fas fa-caret-right rule-bullet-icon me-2"></i>
                                                        {{ trim($point) }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="rule-text">{{ $rule->rule_text }}</p>
                                        @endif
                                    @endif
                                </div>
                            @empty
                                <p class="no-data-text">Tidak ada peraturan yang disediakan.</p>
                            @endforelse

                        </div>

                        {{-- Event Detail Tab Content --}}
                        <div class="tab-pane fade" id="event-detail" role="tabpanel" aria-labelledby="event-detail-tab">
                            <h5 class="tab-content-title">DETAIL WAKTU & INFORMASI EVENT</h5>
                            <div class="event-details-grid">
                                <div class="detail-card">
                                    <div class="detail-icon"><i class="far fa-calendar-alt"></i></div>
                                    <div class="detail-content">
                                        <span class="detail-label">Pendaftaran</span>
                                        <p class="detail-value">
                                            @if ($event->registration_start && $event->registration_end)
                                                {{ \Carbon\Carbon::parse($event->registration_start)->format('d F Y') }} -
                                                {{ \Carbon\Carbon::parse($event->registration_end)->format('d F Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="detail-card">
                                    <div class="detail-icon"><i class="far fa-clock"></i></div>
                                    <div class="detail-content">
                                        <span class="detail-label">Waktu Event</span>
                                        <p class="detail-value">
                                            @if ($event->event_start && $event->event_end)
                                                {{ \Carbon\Carbon::parse($event->event_start)->format('d F Y, H:i') }} WIB
                                                - {{ \Carbon\Carbon::parse($event->event_end)->format('H:i') }} WIB
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="detail-card">
                                    <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                                    <div class="detail-content">
                                        <span class="detail-label">Lokasi</span>
                                        <p class="detail-value">{{ $event->location ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="detail-card">
                                    <div class="detail-icon"><i class="fas fa-dollar-sign"></i></div>
                                    <div class="detail-content">
                                        <span class="detail-label">Biaya Pendaftaran</span>
                                        <p class="detail-value">
                                            {{ $event->registration_fee ? 'Rp ' . number_format($event->registration_fee, 0, ',', '.') : 'Gratis' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="detail-card">
                                    <div class="detail-icon"><i class="fas fa-trophy"></i></div>
                                    <div class="detail-content">
                                        <span class="detail-label">Total Hadiah</span>
                                        <p class="detail-value">
                                            {{ $event->prize_total ? 'Rp ' . number_format($event->prize_total, 0, ',', '.') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="detail-card">
                                    <div class="detail-icon"><i class="fas fa-user-friends"></i></div>
                                    <div class="detail-content">
                                        <span class="detail-label">Kategori Gender</span>
                                        <p class="detail-value">
                                            {{ $event->gender_category ? ucfirst($event->gender_category) : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            @if (
                                !$event->registration_start &&
                                    !$event->registration_end &&
                                    !$event->event_start &&
                                    !$event->event_end &&
                                    !$event->location &&
                                    !$event->registration_fee &&
                                    !$event->prize_total &&
                                    !$event->gender_category)
                                <p class="no-data-text">Detail event belum tersedia.</p>
                            @endif
                        </div>


                        {{-- Partisipan Tab Content (uses real data) --}}
                        <div class="tab-pane fade" id="partisipan" role="tabpanel" aria-labelledby="partisipan-tab">
                            <h5 class="tab-content-title">DAFTAR PARTISIPAN</h5>
                            @php
                                $confirmedRegistrations = $event->registrations->where('status', 'confirmed');
                            @endphp

                            @if ($confirmedRegistrations && $confirmedRegistrations->isNotEmpty())
                                <div class="participants-grid">
                                    @foreach ($confirmedRegistrations as $registration)
                                        <div class="participant-card">
                                            <div class="participant-logo">
                                                <img src="{{ $registration->team->logo ? asset('storage/' . $registration->team->logo) : 'https://via.placeholder.com/60x60/CB2786/FFFFFF?text=TL' }}"
                                                    alt="Team Logo">
                                            </div>
                                            <div class="participant-info">
                                                <h6 class="participant-team-name">
                                                    {{ $registration->team->name ?? 'Tim Tanpa Nama' }}</h6>
                                                <p class="participant-caption">Kapten:
                                                    <strong>{{ $registration->user->name ?? 'Tidak Ada' }}</strong>
                                                </p>
                                                @if ($registration->team && $registration->team->members->isNotEmpty())
                                                    <div class="participant-members-list">
                                                        <span class="members-label"><i class="fas fa-users me-1"></i>
                                                            Anggota Tim:</span>
                                                        <ul class="list-unstyled mb-0 d-inline-block ms-2">
                                                            @foreach ($registration->team->members as $index => $member)
                                                                <li class="d-inline-block">{{ $member->name }}@if (!$loop->last)
                                                                        ,
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="participant-caption text-muted">Anggota tidak tersedia.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="no-data-text">Belum ada partisipan terdaftar.</p>
                            @endif
                        </div>

                        {{-- Contact Person Tab Content --}}
                        <div class="tab-pane fade" id="contact-person" role="tabpanel"
                            aria-labelledby="contact-person-tab">
                            <h5 class="tab-content-title">INFORMASI KONTAK</h5>
                            <div class="contact-info-card">
                                <div class="contact-icon"><i class="fas fa-user-circle"></i></div>
                                <div class="contact-content">
                                    <p class="contact-person-name">
                                        {{ $event->contact_person ?? 'Informasi kontak tidak tersedia.' }}</p>
                                    <p class="contact-description">Untuk pertanyaan lebih lanjut, silakan hubungi kontak di
                                        atas.</p>
                                    @if ($event->contact_person)
                                        @php
                                            // Bersihkan nomor telepon dari karakter non-digit
                                            $phoneNumberClean = preg_replace('/[^0-9]/', '', $event->contact_person);
                                            // Tambahkan awalan negara jika belum ada (contoh: untuk Indonesia, 62)
                                            if (substr($phoneNumberClean, 0, 1) === '0') {
                                                $phoneNumberClean = '62' . substr($phoneNumberClean, 1);
                                            } elseif (
                                                substr($phoneNumberClean, 0, 2) !== '62' &&
                                                substr($phoneNumberClean, 0, 1) === '8'
                                            ) {
                                                $phoneNumberClean = '62' . $phoneNumberClean;
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $phoneNumberClean }}" target="_blank"
                                            class="btn btn-whatsapp mt-2">
                                            <i class="fab fa-whatsapp me-2"></i> Hubungi via WhatsApp
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Jadwal Pertandingan Tab Content --}}
                        <div class="tab-pane fade" id="jadwal-pertandingan" role="tabpanel"
                            aria-labelledby="jadwal-pertandingan-tab">
                            <h5 class="tab-content-title">JADWAL PERTANDINGAN</h5>
                            @forelse ($event->matches as $match)
                                <div data-match-id="{{ $match->id }}"
                                    class="match-card mb-3 p-3 border rounded-3 d-flex align-items-center justify-content-between">
                                    <div class="match-info d-flex align-items-center w-100">
                                        {{-- Team 1 --}}
                                        <div class="team-logo text-center me-3">
                                            <img src="{{ $match->team1->logo ? asset('storage/' . $match->team1->logo) : 'https://via.placeholder.com/60x60/3498db/FFFFFF?text=T1' }}"
                                                alt="Team 1 Logo" class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <h6 class="team-name mt-2 text-truncate">{{ $match->team1->name ?? 'Tim 1' }}
                                            </h6>
                                        </div>

                                        {{-- Bagian Skor dan Status Live --}}
                                        <div class="match-score-and-status text-center mx-3 flex-grow-1"
                                            data-match-id="{{ $match->id }}">
                                            {{-- Konten ini akan diperbarui oleh JavaScript --}}
                                            <h4 class="score-display fw-bold" id="score-{{ $match->id }}">
                                                @if ($match->status === 'completed' || $match->status === 'ongoing')
                                                    {{ $match->score_team1 ?? '0' }} - {{ $match->score_team2 ?? '0' }}
                                                @else
                                                    vs
                                                @endif
                                            </h4>
                                            <span class="badge" id="status-{{ $match->id }}">
                                                @if ($match->status === 'completed')
                                                    <span class="badge bg-success">Selesai</span>
                                                @elseif($match->status === 'ongoing')
                                                    <span class="badge bg-primary">Berlangsung</span>
                                                @else
                                                    <span class="badge bg-secondary">Akan Datang</span>
                                                @endif
                                            </span>
                                        </div>

                                        {{-- Team 2 --}}
                                        <div class="team-logo text-center ms-3">
                                            <img src="{{ $match->team2->logo ? asset('storage/' . $match->team2->logo) : 'https://via.placeholder.com/60x60/e74c3c/FFFFFF?text=T2' }}"
                                                alt="Team 2 Logo" class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <h6 class="team-name mt-2 text-truncate">{{ $match->team2->name ?? 'Tim 2' }}
                                            </h6>
                                        </div>

                                        {{-- Match Details --}}
                                        <div class="match-details ms-auto text-end">
                                            <p class="match-date-time mb-0"><i class="far fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($match->match_datetime)->format('d F Y, H:i') }}
                                                WIB</p>
                                            <p class="match-stage mb-0"><i class="fas fa-bullseye me-1"></i>
                                                {{ $match->stage }}</p>
                                            <p class="match-location mb-0 text-muted"><i
                                                    class="fas fa-map-marker-alt me-1"></i> {{ $match->location }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="far fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <p class="no-data-text">Belum ada jadwal pertandingan yang tersedia.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Tombol Daftar Event --}}
                <div class="registration-section text-center my-5 scroll-animate" data-animation="zoomIn"
                    data-delay="500">
                    @auth
                        @if ($userRegistrationStatus === 'rejected')
                            <button id="registerEventBtn" class="btn btn-warning btn-lg custom-register-btn">
                                <span id="registerBtnText">Daftar Ulang Event Ini</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                    id="registerBtnSpinner"></span>
                            </button>
                            <p class="text-muted mt-2">Pendaftaran Anda sebelumnya ditolak. Anda bisa mendaftar ulang.</p>
                        @elseif ($userRegistrationStatus !== null)
                            <button class="btn btn-secondary btn-lg" disabled>Anda Sudah Terdaftar
                                ({{ ucfirst($userRegistrationStatus) }})
                            </button>
                            <p class="text-muted mt-2">Pendaftaran Anda sedang diproses atau sudah dikonfirmasi.</p>
                        @elseif (!$isRegistrationOpen)
                            <button class="btn btn-danger btn-lg" disabled>Pendaftaran Ditutup</button>
                            <p class="text-muted mt-2">Pendaftaran untuk event ini sudah
                                {{ $event->status === 'ongoing' ? 'berlangsung.' : ($event->status === 'completed' ? 'selesai.' : 'ditutup.') }}
                            </p>
                        @else
                            <button id="registerEventBtn" class="btn btn-primary btn-lg custom-register-btn">
                                <span id="registerBtnText">Daftar Event Ini</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                    id="registerBtnSpinner"></span>
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg">Login untuk Mendaftar</a>
                        <p class="text-muted mt-2">Silakan login untuk dapat mendaftar event ini.</p>
                    @endauth
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="registrationConfirmModal" tabindex="-1" aria-labelledby="registrationConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationConfirmModalLabel">Konfirmasi Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mendaftar ke event ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary" id="confirmRegisterBtn">Ya, Daftar!</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="teamNotFoundModal" tabindex="-1" aria-labelledby="teamNotFoundModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teamNotFoundModalLabel">Pendaftaran Dibatalkan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda harus memiliki tim di profil Anda untuk mendaftar event ini.</p>
                    <p>Silakan buat tim di halaman profil.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('profile.index') }}" class="btn btn-primary">Ke Halaman Profil</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profileCompletionModal" tabindex="-1" aria-labelledby="profileCompletionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileCompletionModalLabel">Pendaftaran Dibatalkan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tim Anda harus memiliki minimal <strong id="minMembersDisplay">{{ $minMembersRequired }}</strong>
                        anggota untuk mendaftar event ini.</p>
                    <p>Silakan lengkapi data tim Anda di halaman profil.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('profile.index') }}" class="btn btn-primary">Ke Halaman Profil</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registrationSuccessModal" tabindex="-1" aria-labelledby="registrationSuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationSuccessModalLabel">Pendaftaran Berhasil!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Selamat! Pendaftaran Anda untuk event <strong>{{ $event->title }}</strong> telah berhasil.</p>
                    <p>Silakan cek status pendaftaran Anda di halaman profil.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Oke</button>
                    <a href="{{ route('profile.index') }}" class="btn btn-primary">Lihat Profil</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registrationErrorModal" tabindex="-1" aria-labelledby="registrationErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationErrorModalLabel">Pendaftaran Gagal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="registrationErrorMessage">Terjadi kesalahan saat mendaftar. Silakan coba lagi nanti atau hubungi
                        administrator.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/event_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <style>
        /* Custom styles for the register button and modals */
        .custom-register-btn {
            background-color: #F4B704;
            /* Example primary color */
            border-color: #F4B704;
            color: #000;
            /* Dark text for yellow button */
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .custom-register-btn:hover {
            background-color: #d19f00;
            /* Darker yellow on hover */
            border-color: #d19f00;
            color: #000;
        }

        .custom-register-btn:active,
        .custom-register-btn:focus {
            background-color: #e0ac00 !important;
            border-color: #e0ac00 !important;
            box-shadow: 0 0 0 0.25rem rgba(244, 183, 4, 0.5) !important;
        }

        .custom-register-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Modal styling */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .3);
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            color: #333;
        }

        .modal-body {
            padding: 0 1.5rem 1.5rem;
            color: #555;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem 1.5rem;
        }

        .modal-footer .btn {
            min-width: 100px;
        }

        .match-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .match-info .team-logo .team-name {
            font-size: 0.9rem;
            font-weight: 600;
            /* max-width: 80px; */
        }

        .match-details p {
            font-size: 0.85rem;
            line-height: 1.2;
        }

        .match-details .match-date-time {
            font-weight: 600;
            color: #000;
        }

        .match-details .match-stage {
            font-weight: 500;
            color: #5B93FF;
        }

        .no-data-text {
            color: #777;
            font-style: italic;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerEventBtn = document.getElementById('registerEventBtn');
            const confirmRegisterBtn = document.getElementById('confirmRegisterBtn');
            const registerBtnText = document.getElementById('registerBtnText');
            const registerBtnSpinner = document.getElementById('registerBtnSpinner');
            const registrationErrorMessage = document.getElementById('registrationErrorMessage');

            // NEW: Elemen untuk menampilkan skor
            const matchStatusElement = document.getElementById('match-status');
            const team1ScoreElement = document.getElementById('team1-score');
            const team2ScoreElement = document.getElementById('team2-score');

            // Initialize Bootstrap Modals
            const registrationConfirmModal = new bootstrap.Modal(document.getElementById(
                'registrationConfirmModal'));
            const profileCompletionModal = new bootstrap.Modal(document.getElementById('profileCompletionModal'));
            const teamNotFoundModal = new bootstrap.Modal(document.getElementById('teamNotFoundModal'));
            const registrationSuccessModal = new bootstrap.Modal(document.getElementById(
                'registrationSuccessModal'));
            const registrationErrorModal = new bootstrap.Modal(document.getElementById('registrationErrorModal'));

            // Data from backend (ensure these variables are passed from your controller)
            const eventId = {{ $event->id }};
            const eventSlug = '{{ $event->slug }}';
            const userHasTeam = {{ json_encode($userHasTeam) }};
            const teamMemberCount = {{ json_encode($teamMemberCount) }};
            const minMembersRequired = {{ json_encode($minMembersRequired) }};
            const isRegistrationOpen = {{ json_encode($isRegistrationOpen) }};
            const userRegistrationStatus = '{{ $userRegistrationStatus }}'; // NEW: Get user's registration status

            // Set initial state of the register button based on backend logic and event status
            if (registerEventBtn) {
                if (userRegistrationStatus === 'rejected') { // NEW: If rejected, style for re-register
                    registerEventBtn.classList.remove('btn-primary', 'btn-secondary', 'btn-danger');
                    registerEventBtn.classList.add('btn-warning'); // Or a specific re-register color
                    registerBtnText.textContent = 'Daftar Ulang Event Ini';
                    registerEventBtn.disabled = false; // Enable for re-registration
                } else if (userRegistrationStatus !==
                    '') { // If registered with any status (not empty, so 'pending', 'approved', 'completed')
                    registerEventBtn.disabled = true;
                    registerEventBtn.classList.remove('btn-primary', 'custom-register-btn', 'btn-danger',
                        'btn-warning');
                    registerEventBtn.classList.add('btn-secondary');
                    registerBtnText.textContent = 'Anda Sudah Terdaftar (' + userRegistrationStatus.charAt(0)
                        .toUpperCase() + userRegistrationStatus.slice(1) + ')';
                } else if (!isRegistrationOpen) { // Check if tournament status is NOT 'registration'
                    registerEventBtn.disabled = true;
                    registerEventBtn.classList.remove('btn-primary', 'custom-register-btn', 'btn-secondary',
                        'btn-warning');
                    registerEventBtn.classList.add('btn-danger');
                    registerBtnText.textContent = 'Pendaftaran Ditutup';
                }
                // If none of the above, it means registration is open and user is not registered,
                // so the default styling (btn-primary, custom-register-btn) applies and it's enabled.
            }


            // Event listener for the main "Daftar Event Ini" button
            if (registerEventBtn) {
                registerEventBtn.addEventListener('click', function() {
                    // Client-side checks. These mirror backend checks for immediate feedback.
                    if (!isRegistrationOpen) {
                        registrationErrorMessage.textContent =
                            'Periode pendaftaran untuk event ini sudah ditutup.';
                        registrationErrorModal.show();
                        return;
                    }
                    // Check if user is already registered with a non-rejected status
                    if (userRegistrationStatus !== '' && userRegistrationStatus !== 'rejected') {
                        registrationErrorMessage.textContent =
                            'Anda sudah terdaftar di event ini dengan status: ' + userRegistrationStatus
                            .charAt(0).toUpperCase() + userRegistrationStatus.slice(1) + '.';
                        registrationErrorModal.show();
                        return;
                    }
                    if (!userHasTeam) {
                        teamNotFoundModal.show();
                        return;
                    }
                    if (teamMemberCount < minMembersRequired) {
                        document.getElementById('minMembersDisplay').textContent = minMembersRequired;
                        profileCompletionModal.show();
                        return;
                    }

                    registrationConfirmModal.show(); // Show confirmation modal if all checks pass
                });
            }

            // Event listener for the "Ya, Daftar!" button in the confirmation modal
            if (confirmRegisterBtn) {
                confirmRegisterBtn.addEventListener('click', function() {
                    registrationConfirmModal.hide(); // Hide confirmation modal

                    // Show spinner and disable button while registering
                    if (registerEventBtn) {
                        registerBtnText.textContent = 'Mendaftar...';
                        registerBtnSpinner.classList.remove('d-none');
                        registerEventBtn.disabled = true;
                    }

                    // Perform AJAX POST request to the registration route
                    fetch('{{ url('/events/') }}/' + eventSlug + '/register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                event_id: eventId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw new Error(errorData.message ||
                                        'Terjadi kesalahan tidak diketahui.');
                                }).catch(() => {
                                    throw new Error(
                                        'Server mengirim respons yang tidak valid. Mohon coba lagi atau hubungi administrator.'
                                    );
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                registrationSuccessModal.show(); // Show success modal
                                // Update UI button after successful registration
                                if (registerEventBtn) {
                                    registerEventBtn.disabled = true;
                                    registerEventBtn.classList.remove('btn-primary',
                                        'custom-register-btn', 'btn-danger', 'btn-warning');
                                    registerEventBtn.classList.add('btn-secondary');
                                    registerBtnText.textContent =
                                        'Anda Sudah Terdaftar (Pending)'; // After successful register, status is pending
                                }
                                // Update the userRegistrationStatus variable globally to reflect new state
                                userRegistrationStatus = 'pending'; // Reflect the new state
                            } else {
                                // Handle cases where response is OK but 'success' is false (e.g., custom validation messages from server)
                                registrationErrorMessage.textContent = data.message ||
                                    'Pendaftaran gagal.';
                                if (data.redirect_to_profile) {
                                    // Optionally, automatically redirect the user to their profile
                                    // window.location.href = '{{ route('profile.index') }}';
                                }
                                registrationErrorModal.show();
                            }
                        })
                        .catch(error => {
                            console.error('Error during registration:', error);
                            registrationErrorMessage.textContent = error.message ||
                                'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';
                            registrationErrorModal.show();
                        })
                        .finally(() => {
                            // Hide spinner
                            registerBtnSpinner.classList.add('d-none');
                            // Re-enable button if it was disabled ONLY for this attempt, and registration is still open/re-registrable
                            if (registerEventBtn && registerEventBtn.disabled && isRegistrationOpen) {
                                if (userRegistrationStatus ===
                                    'rejected'
                                ) { // If user was rejected, allow re-register button to show again
                                    registerEventBtn.disabled = false;
                                    registerBtnText.textContent = 'Daftar Ulang Event Ini';
                                    registerEventBtn.classList.remove('btn-primary', 'btn-secondary',
                                        'btn-danger');
                                    registerEventBtn.classList.add('btn-warning');
                                } else if (userRegistrationStatus ===
                                    '') { // If user was never registered, enable main button
                                    registerEventBtn.disabled = false;
                                    registerBtnText.textContent = 'Daftar Event Ini';
                                    registerEventBtn.classList.add('btn-primary',
                                        'custom-register-btn');
                                    registerEventBtn.classList.remove('btn-secondary', 'btn-danger',
                                        'btn-warning');
                                }
                                // If userRegistrationStatus is pending/approved, it should remain disabled.
                            }
                        });
                });
            }

            // BAGIAN BARU UNTUK LIVE SCORE
            /**
             * Fungsi untuk mengambil data skor live dan memperbarui tampilan.
             */
            async function fetchLiveScores() {
                // Ambil semua elemen match-card yang memiliki data-match-id
                const matchCards = document.querySelectorAll('.match-card');
                if (matchCards.length === 0) {
                    console.log('Tidak ada pertandingan, menghentikan live score fetch.');
                    return;
                }

                try {
                    const eventId = {{ $event->id }};
                    const response = await fetch(`/api/events/${eventId}/live-scores`);

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data skor live.');
                    }

                    const matches = await response.json();

                    // Iterasi setiap kartu pertandingan di halaman
                    matchCards.forEach(card => {
                        const matchId = card.dataset.matchId;
                        const matchData = matches.find(m => m.id == matchId);

                        if (matchData) {
                            // Temukan elemen skor dan status di dalam kartu
                            const scoreElement = card.querySelector('.score-live');
                            const statusElement = card.querySelector('.status-live');

                            // Perbarui skor
                            const scoreText =
                                `${matchData.team1_score ?? 0} - ${matchData.team2_score ?? 0}`;
                            if (scoreElement && scoreElement.textContent.trim() !== scoreText) {
                                scoreElement.textContent = scoreText;
                            }

                            // Perbarui status
                            let statusBadge;
                            if (matchData.status === 'completed') {
                                statusBadge = '<span class="badge bg-success">Selesai</span>';
                            } else if (matchData.status === 'ongoing') {
                                statusBadge = '<span class="badge bg-primary">Berlangsung</span>';
                            }

                            // Hanya perbarui status jika ada data yang sesuai
                            if (statusBadge && statusElement && statusElement.innerHTML.trim() !==
                                statusBadge) {
                                statusElement.innerHTML = statusBadge;
                            }
                        }
                    });

                } catch (error) {
                    console.error('Error fetching live scores:', error);
                }
            }

            // Panggil fungsi pertama kali saat halaman dimuat
            fetchLiveScores();

            // Panggil fungsi setiap 10 detik (10000ms) untuk memperbarui skor
            const liveScoreInterval = setInterval(fetchLiveScores, 10000);

            // Optional: Hentikan interval saat user beralih tab untuk menghemat resource
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    clearInterval(liveScoreInterval);
                } else {
                    // Mulai lagi saat kembali ke tab
                    fetchLiveScores();
                    liveScoreInterval = setInterval(fetchLiveScores, 10000);
                }
            });
        });
    </script>
    <script src="{{ asset('js/live_score.js') }}"></script>
    <script src="{{ asset('js/animate.js') }}"></script>
@endpush
