@extends('../layouts/master_nav')

@section('title', 'Profile')

@section('content')
<div class="container py-5">
    <h2 class="text-center mt-5">Profile</h2>

    <div class="text-center my-3">
        <img src="{{ Auth::user()->profile && Auth::user()->profile->profile_photo ? asset('storage/' . Auth::user()->profile->profile_photo) : asset('assets/img/profile-placeholder.png') }}"
             alt="Profile Photo" class="img-fluid img-square-rounded" width="100" height="100" style="object-fit: cover;">
    </div>

    <h4 class="text-center mt-4 mb-3 profile-section-title">Informasi Dasar</h4>

    <div class="card shadow-sm mb-4 profile-info-card">
        <div class="card-body position-relative">
            <a href="{{ route('profile.edit') }}" class="btn btn-link p-0 position-absolute top-0 end-0 mt-3 me-3 edit-profile-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.121z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                </svg>
            </a>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nama:</div>
                <div class="col-md-9">{{ Auth::user()->profile->name ?? Auth::user()->name ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Tanggal Lahir:</div>
                <div class="col-md-9">{{ Auth::user()->profile->birthdate ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Jenis Kelamin:</div>
                <div class="col-md-9">{{ Auth::user()->profile->gender ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Email:</div>
                <div class="col-md-9">{{ Auth::user()->profile->email ?? Auth::user()->email ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nomor Telepon:</div>
                <div class="col-md-9">{{ Auth::user()->profile->phone_number ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Akun Sosial Media:</div>
                <div class="col-md-9">{{ Auth::user()->profile->social_media ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Navigasi Tab --}}
    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(request('active_tab') == 'tim' || !request('active_tab')) active @endif" id="tim-tab" data-bs-toggle="tab" href="#tim" role="tab" aria-controls="tim" aria-selected="true">Tim</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request('active_tab') == 'event-saya') active @endif" id="event-saya-tab" data-bs-toggle="tab" href="#event-saya" role="tab" aria-controls="event-saya" aria-selected="false">Event Saya</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request('active_tab') == 'permohonan') active @endif" id="permohonan-tab" data-bs-toggle="tab" href="#permohonan" role="tab" aria-controls="permohonan" aria-selected="false">Permohonan Tuan Rumah</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request('active_tab') == 'donasi-saya') active @endif" id="donasi-saya-tab" data-bs-toggle="tab" href="#donasi-saya" role="tab" aria-controls="donasi-saya" aria-selected="false">Donasi Saya</a>
        </li>
    </ul>

    {{-- Konten Tab --}}
    <div class="tab-content" id="myTabContent">
        {{-- Tab 'Tim' --}}
        <div class="tab-pane fade @if(request('active_tab') == 'tim' || !request('active_tab')) show active @endif" id="tim" role="tabpanel" aria-labelledby="tim-tab">
            @if (!$hasTeam)
                <div class="d-flex justify-content-center align-items-center" style="min-height: 200px; border: 1px dashed #ccc; border-radius: 8px;">
                    <a href="{{ route('team.create') }}" class="text-decoration-none text-muted" style="font-size: 3rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        <p class="mt-3 fs-5">Buat Tim</p>
                    </a>
                </div>
            @else
                <h4 class="text-center mt-4 mb-3 profile-section-title">Detail Tim</h4>
                <div class="card shadow-sm mb-4 profile-info-card">
                    <div class="card-body position-relative">
                       <a href="{{ route('team.edit', Crypt::encryptString($firstTeam->id)) }}" class="btn btn-link p-0 position-absolute top-0 end-0 mt-3 me-3 edit-profile-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.121z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </a>

                        <div class="text-center mb-3">
                            <img src="{{ $firstTeam->logo ? asset('storage/' . $firstTeam->logo) : asset('assets/img/team-placeholder.png') }}"
                                 alt="Team Logo" class="img-fluid img-square-rounded" width="80" height="80" style="object-fit: cover;">
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Nama Tim:</div>
                            <div class="col-md-8">{{ $firstTeam->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Manajer:</div>
                            <div class="col-md-8">{{ $firstTeam->manager_name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Kontak:</div>
                            <div class="col-md-8">{{ $firstTeam->contact }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Lokasi:</div>
                            <div class="col-md-8">{{ $firstTeam->location }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Kategori Gender:</div>
                            <div class="col-md-8">{{ ucfirst($firstTeam->gender_category) }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Jumlah Anggota:</div>
                            <div class="col-md-8">{{ $firstTeam->members->count() }} / {{ $firstTeam->member_count }}</div>
                        </div>
                        @if ($firstTeam->description)
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Deskripsi:</div>
                                <div class="col-md-8">{{ $firstTeam->description }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <h4 class="text-center mt-4 mb-3 profile-section-title">Anggota Tim</h4>
                <div class="row row-cols-2 row-cols-md-5 g-3">
                    @for ($i = 0; $i < $firstTeam->member_count; $i++)
                        <div class="col">
                            @php
                                $member = $teamMembers->get($i);
                            @endphp

                            @if ($member)
                                <div class="card h-100 shadow-sm text-center d-flex flex-column justify-content-center align-items-center text-dark member-card-wrapper">
                                    <a href="{{ route('team.members.edit', ['team' => Crypt::encryptString($firstTeam->id), 'member' => Crypt::encryptString($member->id)]) }}"
                                       class="member-card-link" style="padding: 1rem; width: 100%;">
                                        <div class="card-body">
                                            @if ($member->photo)
                                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="img-fluid img-square-rounded mb-2" width="70" height="70" style="object-fit: cover;">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-person-circle text-muted mb-2" viewBox="0 0 16 16">
                                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                                </svg>
                                            @endif
                                            <h6 class="card-title mb-0">{{ $member->name ?? 'Anggota Tim' }}</h6>
                                            <p class="card-text text-muted small">{{ $member->position ?? 'Peran' }}</p>
                                        </div>
                                    </a>
                                    @if ($firstTeam->members->count() > 1)
                                        <form action="{{ route('team.members.destroy', ['team' => Crypt::encryptString($firstTeam->id), 'member' => Crypt::encryptString($member->id)]) }}" method="POST" class="d-inline-block w-100 px-3 pb-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteMember(event, this.parentElement)" class="btn btn-danger btn-sm w-100">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('team.members.create', Crypt::encryptString($firstTeam->id)) }}"
                                   class="card h-100 shadow-sm text-center d-flex flex-column justify-content-center align-items-center text-decoration-none text-muted member-card-link add-member-card">
                                    <div class="card-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                        </svg>
                                        <h6 class="card-title mt-2 mb-0">Tambah Anggota</h6>
                                        <p class="card-text text-muted small">Slot Kosong {{ $i + 1 }}</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endfor
                </div>
            @endif
        </div>

        {{-- Tab 'Event Saya' --}}
        <div class="tab-pane fade @if(request('active_tab') == 'event-saya') show active @endif" id="event-saya" role="tabpanel" aria-labelledby="event-saya-tab">
            @if ($registeredTournaments->isEmpty())
                <p class="text-center text-muted">Anda belum terdaftar ke lomba manapun.</p>
            @else
                @foreach ($registeredTournaments as $registration)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>{{ $registration->tournament->title ?? 'Nama Turnamen' }}</h4>
                                @php
                                    $badgeClass = '';
                                    switch($registration->status) {
                                        case 'pending': $badgeClass = 'bg-warning text-dark'; break;
                                        case 'approved': $badgeClass = 'bg-success'; break;
                                        case 'rejected': $badgeClass = 'bg-danger'; break;
                                        case 'completed': $badgeClass = 'bg-primary'; break;
                                        default: $badgeClass = 'bg-secondary'; break;
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($registration->status ?? 'Status') }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                @php
                                    $progressWidth = 0;
                                    $progressBarClass = '';
                                    switch($registration->status) {
                                        case 'pending': $progressWidth = 25; $progressBarClass = 'bg-warning'; break;
                                        case 'approved': $progressWidth = 50; $progressBarClass = 'bg-info'; break;
                                        case 'completed': $progressWidth = 100; $progressBarClass = 'bg-success'; break;
                                        case 'rejected': $progressWidth = 10; $progressBarClass = 'bg-danger'; break;
                                        default: $progressWidth = 0; $progressBarClass = 'bg-secondary'; break;
                                    }
                                @endphp
                                <div class="progress-bar {{ $progressBarClass }}" role="progressbar" style="width: {{ $progressWidth }}%" aria-valuenow="{{ $progressWidth }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted small">
                                Tanggal Turnamen: {{ \Carbon\Carbon::parse($registration->tournament->registration_start ?? 'N/A')->format('d M Y') }} - {{ \Carbon\Carbon::parse($registration->tournament->registration_end ?? 'N/A')->format('d M Y') }} |
                                Status Pendaftaran: {{ ucfirst($registration->status ?? 'N/A') }}
                                @if ($registration->rejection_reason)
                                    <br>Alasan Penolakan: {{ $registration->rejection_reason }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Tab 'Permohonan Tuan Rumah' --}}
        <div class="tab-pane fade @if(request('active_tab') == 'permohonan') show active @endif" id="permohonan" role="tabpanel" aria-labelledby="permohonan-tab">
            @if ($hostApplications->isEmpty())
                <div class="text-center text-muted p-4 border rounded">
                    <p class="mb-0">Anda belum mengajukan permohonan tuan rumah.</p>
                    <p class="mt-2"><a href="{{ route('host-request.create') }}">Ajukan Permohonan Sekarang</a></p>
                </div>
            @else
                @foreach ($hostApplications as $hostApplication)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $hostApplication->tournament_title ?? 'Judul Turnamen' }}</h5>
                            <p class="card-text">
                                <strong>Penanggung Jawab:</strong> {{ $hostApplication->responsible_name ?? '-' }} <br>
                                <strong>Email:</strong> {{ $hostApplication->email ?? '-' }} <br>
                                <strong>Telepon:</strong> {{ $hostApplication->phone ?? '-' }} <br>
                                <strong>Lokasi:</strong> {{ $hostApplication->venue_name ?? '-' }}, {{ $hostApplication->venue_address ?? '-' }} <br>
                                <strong>Tanggal Diajukan:</strong> {{ \Carbon\Carbon::parse($hostApplication->proposed_date ?? 'N/A')->format('d M Y') }} <br>
                                <strong>Status:</strong> @php
                                    $badgeClass = '';
                                    switch($hostApplication->status) {
                                        case 'pending': $badgeClass = 'bg-info text-dark'; break;
                                        case 'approved': $badgeClass = 'bg-success'; break;
                                        case 'rejected': $badgeClass = 'bg-danger'; break;
                                        default: $badgeClass = 'bg-secondary'; break;
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($hostApplication->status ?? 'N/A') }}</span>
                                @if ($hostApplication->rejection_reason)
                                    <br> <strong>Alasan Penolakan:</strong> {{ $hostApplication->rejection_reason }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Tab 'Donasi Saya' - VERSI SEDERHANA --}}
        <div class="tab-pane fade @if(request('active_tab') == 'donasi-saya') show active @endif" id="donasi-saya" role="tabpanel" aria-labelledby="donasi-saya-tab">
            @if ($userDonations->isEmpty())
                <div class="text-center text-muted p-4 border rounded">
                    <p class="mb-0">Anda belum mengajukan donasi/sponsor.</p>
                    <p class="mt-2"><a href="{{ route('donations.create') }}">Ajukan Donasi/Sponsor Sekarang</a></p>
                </div>
            @else
                @foreach ($userDonations as $donation)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">{{ $donation->name_brand ?? 'Nama Brand' }}</h5>
                                @php
                                    $badgeClass = '';
                                    switch($donation->status) {
                                        case 'pending': $badgeClass = 'bg-warning text-dark'; break;
                                        case 'approved': $badgeClass = 'bg-success'; break;
                                        case 'rejected': $badgeClass = 'bg-danger'; break;
                                        default: $badgeClass = 'bg-secondary'; break;
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($donation->status ?? 'N/A') }}</span>
                            </div>
                            <p class="card-text mb-0">
                                <strong>Jenis:</strong> {{ ucfirst($donation->donation_type ?? '-') }} 
                                @if($donation->sponsor_type && $donation->donation_type == 'sponsor')
                                    ({{ $donation->sponsor_type }})
                                @endif
                                <br>
                                <strong>Event:</strong> {{ $donation->event_name ?? '-' }} <br>
                                <strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($donation->created_at ?? 'N/A')->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination untuk Donasi Saya --}}
                @if($userDonations->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        <nav aria-label="Page navigation for User Donations">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($userDonations->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userDonations->previousPageUrl() . '&active_tab=donasi-saya&page_registered=' . request('page_registered', 1) . '&page_host=' . request('page_host', 1) }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $currentPage = $userDonations->currentPage();
                                    $lastPage = $userDonations->lastPage();
                                    $pageRange = 5;
                                    $startPage = max(1, $currentPage - floor($pageRange / 2));
                                    $endPage = min($lastPage, $currentPage + floor($pageRange / 2));

                                    if ($currentPage <= floor($pageRange / 2) && $lastPage >= $pageRange) {
                                        $endPage = $pageRange;
                                    }
                                    if ($currentPage > ($lastPage - floor($pageRange / 2)) && $lastPage >= $pageRange) {
                                        $startPage = $lastPage - $pageRange + 1;
                                    }
                                @endphp

                                @for ($i = $startPage; $i <= $endPage; $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $userDonations->url($i) . '&active_tab=donasi-saya&page_registered=' . request('page_registered', 1) . '&page_host=' . request('page_host', 1) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Next Page Link --}}
                                @if ($userDonations->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $userDonations->nextPageUrl() . '&active_tab=donasi-saya&page_registered=' . request('page_registered', 1) . '&page_host=' . request('page_host', 1) }}" rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
    {{-- Memuat CSS eksternal Anda --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        /* Gaya tambahan yang mungkin relevan dari edit.blade.php */
        .profile-info-card {
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
        .edit-profile-btn {
            z-index: 10; /* Pastikan tombol di atas konten lain */
        }
        /* Definisi variabel warna jika belum ada di tempat lain */
        :root {
            --shadow-color-cf2585: #cf2585; /* Sesuaikan dengan warna shadow Anda */
            --kamcup-pink: #cb2786;
            --kamcup-blue-green: #00617a;
            --kamcup-yellow: #f4b704;
            --kamcup-dark-text: #212529;
            --kamcup-light-text: #ffffff;
        }

        /* ----- Gaya Baru untuk Gambar Persegi dengan Sudut Membulat ----- */
        .img-square-rounded {
            border-radius: 8px; /* Sesuaikan nilai ini untuk seberapa membulat sudutnya */
            object-fit: cover; /* Pastikan gambar tetap proporsional */
        }

        /* Gaya umum untuk semua kartu anggota yang bisa diklik */
        .member-card-link {
            /* Pastikan elemen <a> ini berperilaku seperti card */
            display: flex; /* Untuk mengaktifkan d-flex flex-column */
            flex-direction: column; /* Untuk d-flex flex-column */
            justify-content: center; /* Untuk justify-content-center */
            align-items: center; /* Untuk align-items-center */
            text-decoration: none; /* Hilangkan garis bawah link */
            color: inherit; /* Warisi warna teks dari parent atau reset */

            /* Pastikan ini dapat diklik */
            position: relative;
            z-index: 1; /* Mungkin perlu disesuaikan jika ada overlay */
            cursor: pointer;
        }

        .member-card-link:hover {
            background-color: #e9ecef; /* Sedikit lebih gelap saat hover */
            border-color: #0d6efd; /* Ubah warna border saat hover */
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); /* Efek focus seperti form-control */
        }

        /* Gaya untuk kartu "Tambah Anggota" (slot kosong) */
        .add-member-card {
            border: 1px dashed #ccc; /* Border putus-putus */
            background-color: #f8f9fa; /* Latar belakang sedikit abu-abu */
        }

        .add-member-card:hover {
            /* Overwrite hover effect for add-member-card if needed, or let member-card-link handle it */
            background-color: #e9ecef;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Pastikan card-body di dalam link tidak memiliki padding berlebihan jika tidak diinginkan */
        .member-card-link .card-body {
            width: 100%; /* Pastikan body mengisi lebar card link */
        }

        /* Gaya baru untuk pembungkus kartu anggota agar tombol hapus bisa diletakkan di bawah */
        .member-card-wrapper {
            position: relative;
            background-color: #fff;
            border-radius: 0.5rem;
            border: 1px solid rgba(0,0,0,.125);
            padding: 0; /* Reset padding jika card-body yang menangani */
        }
        .member-card-wrapper:hover {
             /* Konsisten dengan hover member-card-link */
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* --- Custom Pagination Styling --- */
        .pagination {
            --bs-pagination-color: var(--kamcup-blue-green); /* Default text color for links */
            --bs-pagination-active-bg: var(--kamcup-pink); /* Background for active page */
            --bs-pagination-active-border-color: var(--kamcup-pink); /* Border for active page */
            --bs-pagination-hover-color: var(--kamcup-pink); /* Text color on hover */
            --bs-pagination-hover-bg: #e9ecef; /* Background on hover for inactive links */
            --bs-pagination-border-color: #dee2e6; /* Default border color for links */
            --bs-pagination-disabled-color: #6c757d; /* Text color for disabled links */
            --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(203, 39, 134, 0.25); /* Focus shadow using KAMCUP pink */
        }

        .page-item .page-link {
            border-radius: 8px; /* Slightly rounded corners */
            margin: 0 5px; /* Space between pagination buttons (changed from 4px to 5px based on your ref) */
            min-width: 40px; /* Minimum width to make buttons consistent */
            text-align: center;
            transition: all 0.3s ease; /* Smooth transition for hover effects */
            display: flex; /* Use flexbox for centering content */
            align-items: center;
            justify-content: center;
            height: 40px; /* Consistent height for buttons */
            font-weight: 500; /* Added from your ref */
            color: var(--bs-pagination-color); /* Ensure text color respects variable */
        }

        /* Active page styling */
        .pagination .page-item.active .page-link { /* Specificity added */
            background-color: var(--secondary-color); /* From your ref */
            border-color: var(--secondary-color); /* From your ref */
            color: white; /* Text color for active page */
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(203, 39, 134, 0.3); /* Subtle shadow for active page */
        }

        /* Hover effect for inactive pagination links */
        .pagination .page-item .page-link:hover:not(.active) { /* Specificity added, combined with your ref */
            background-color: var(--accent-color); /* From your ref */
            border-color: var(--accent-color); /* From your ref */
            color: white; /* Text color on hover */
            transform: translateY(-2px); /* Slight lift on hover */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
        }

        /* Disabled page item styling */
        .page-item.disabled .page-link {
            opacity: 0.6; /* Slightly fade out disabled links */
            cursor: not-allowed;
            transform: none; /* Remove any hover transform */
            box-shadow: none; /* Remove any hover shadow */
        }

        /* Adjusting focus outline if needed (Bootstrap usually handles this well) */
        .page-item .page-link:focus {
            box-shadow: var(--bs-pagination-focus-box-shadow);
            border-color: var(--kamcup-pink);
        }

        /* Define new color variables from your reference, ensure they are recognized */
        :root {
            --primary-color: #cb2786;
            --secondary-color: #00617a;
            --accent-color: #f4b704;
            --text-dark: #333;
            --text-light: #f8f9fa;

            /* Mapped to your existing KAMCUP variables for consistency */
            --kamcup-pink: var(--primary-color);
            --kamcup-blue-green: var(--secondary-color);
            --kamcup-yellow: var(--accent-color);
            --kamcup-dark-text: var(--text-dark);
            --kamcup-light-text: var(--text-light);
        }
    </style>
@endpush

@push('scripts')
    {{-- Pastikan SweetAlert2 sudah dimuat di layout master_nav atau di sini --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // SweetAlert for general success/error messages from session
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ session('error') }}',
                confirmButtonText: 'Oke'
            });
            @endif

            @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                confirmButtonText: 'Oke'
            });
            @endif

            // Fungsi untuk konfirmasi hapus anggota tim
            window.confirmDeleteMember = function(event, form) {
                event.preventDefault(); // Mencegah form disubmit secara default

                Swal.fire({
                    title: "Konfirmasi Hapus?",
                    text: "Anda yakin ingin menghapus anggota tim ini? Data tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545", // Warna merah untuk konfirmasi hapus
                    cancelButtonColor: "#6c757d", // Warna abu-abu untuk batal
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batalkan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Jika dikonfirmasi, submit form
                    }
                });
            }

            // JavaScript to handle tab switching on page load if active_tab is in URL
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('active_tab');
            if (activeTab) {
                const tabElement = document.getElementById(activeTab + '-tab');
                if (tabElement) {
                    const tab = new bootstrap.Tab(tabElement);
                    tab.show();
                }
            }

            // Optional: Update URL on tab click for better UX when sharing/refreshing
            const profileTabs = document.getElementById('profileTabs');
            if (profileTabs) {
                profileTabs.addEventListener('shown.bs.tab', function (event) {
                    const newTabId = event.target.id; // e.g., "donasi-saya-tab"
                    const tabName = newTabId.replace('-tab', ''); // e.g., "donasi-saya"
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('active_tab', tabName);

                    // Preserve other pagination parameters when switching tabs
                    if (tabName !== 'event-saya') {
                        currentUrl.searchParams.delete('page_registered');
                    }
                    if (tabName !== 'permohonan') {
                        currentUrl.searchParams.delete('page_host');
                    }
                    if (tabName !== 'donasi-saya') {
                        currentUrl.searchParams.delete('page_donations');
                    }

                    window.history.pushState({}, '', currentUrl.toString());
                });
            }
        });
    </script>
@endpush
