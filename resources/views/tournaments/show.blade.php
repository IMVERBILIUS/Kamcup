@extends('layouts.master')

@section('content')

<div class="container px-4 px-lg-5 tournament-detail-page-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Top Header Section (Back Button & Date) --}}
            <div class="d-flex justify-content-between align-items-center top-header-section mb-4 mt-4">
                <a href="{{ route('admin.tournaments.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i> KEMBALI
                </a>
                <span class="date-info">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
            </div>

            {{-- Tournament Title --}}
            <h1 class="tournament-title">{{ $tournament->title }}</h1>

            {{-- Tournament Header Image --}}
            <div class="tournament-header-image-container mb-4">
                @if ($tournament->thumbnail)
                    <img src="{{ asset('storage/' . $tournament->thumbnail) }}" alt="Tournament Thumbnail" class="img-fluid rounded-lg tournament-thumbnail-img">
                @else
                    <img src="https://via.placeholder.com/900x400/F4B704/00617A?text=Tournament+Image" alt="Placeholder Thumbnail" class="img-fluid rounded-lg tournament-thumbnail-img">
                @endif
            </div>

            {{-- Summary Boxes --}}
            <div class="summary-boxes-container row g-0 mb-4">
                <div class="col-6">
                    <div class="summary-box tournament-status">
                        <span class="label">Status Turnamen</span>
                        <span class="value">{{ ucfirst($tournament->status) }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="summary-box total-participants">
                        <span class="label">Jumlah Partisipan (Dikonfirmasi)</span>
                        {{-- Count only confirmed registrations --}}
                        <span class="value">{{ $tournament->registrations->where('status', 'confirmed')->count() ?? 0 }}</span>
                    </div>
                </div>
                {{-- NEW BOX: Jumlah Pendaftar (Total) --}}
                <div class="col-12 mt-3"> {{-- Use col-12 and mt-3 for a new row below if you want it distinct --}}
                    <div class="summary-box total-registrations-overall">
                        <span class="label">Jumlah Pendaftar (Total)</span>
                        {{-- Count all registrations regardless of status --}}
                        <span class="value">{{ $tournament->registrations->count() ?? 0 }}</span>
                    </div>
                </div>
                {{-- END NEW BOX --}}
            </div>

            {{-- Navigation Tabs and Content --}}
            <div class="tabs-section mb-5">
                <ul class="nav nav-pills custom-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="peraturan-tab" data-bs-toggle="tab" data-bs-target="#peraturan" type="button" role="tab" aria-controls="peraturan" aria-selected="true">Peraturan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="event-detail-tab" data-bs-toggle="tab" data-bs-target="#event-detail" type="button" role="tab" aria-controls="event-detail" aria-selected="false">Detail Turnamen</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="partisipan-tab" data-bs-toggle="tab" data-bs-target="#partisipan" type="button" role="tab" aria-controls="partisipan" aria-selected="false">Partisipan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-person-tab" data-bs-toggle="tab" data-bs-target="#contact-person" type="button" role="tab" aria-controls="contact-person" aria-selected="false">Contact Person</button>
                    </li>
                    <li class="nav-item ms-auto social-icon-wrapper">
                        <a href="https://twitter.com" target="_blank" class="nav-link twitter-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content custom-tab-content mt-3" id="myTabContent">
                    {{-- Peraturan Tab Content --}}
                    <div class="tab-pane fade show active" id="peraturan" role="tabpanel" aria-labelledby="peraturan-tab">
                        <h5 class="tab-content-title">PERATURAN TURNAMEN</h5>
                        @forelse($tournament->rules ?? [] as $rule)
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

                                @if($categoryTitle)
                                    <h6 class="rule-category-title">{{ $categoryTitle }}</h6>
                                    @if(count($rulePoints) > 0)
                                        <ul class="rules-list-detailed">
                                            @foreach($rulePoints as $point)
                                                <li><i class="fas fa-caret-right rule-bullet-icon me-2"></i> {{ trim($point) }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @else
                                    @if(count($rulePoints) > 0)
                                        <ul class="rules-list-detailed">
                                            @foreach($rulePoints as $point)
                                                <li><i class="fas fa-caret-right rule-bullet-icon me-2"></i> {{ trim($point) }}</li>
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
                        <h5 class="tab-content-title">DETAIL WAKTU & INFORMASI TURNAMEN</h5>
                        <div class="event-details-grid">
                            <div class="detail-card">
                                <div class="detail-icon"><i class="far fa-calendar-alt"></i></div>
                                <div class="detail-content">
                                    <span class="detail-label">Pendaftaran</span>
                                    <p class="detail-value">
                                        @if($tournament->registration_start && $tournament->registration_end)
                                            {{ \Carbon\Carbon::parse($tournament->registration_start)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tournament->registration_end)->format('d F Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-icon"><i class="far fa-clock"></i></div>
                                <div class="detail-content">
                                    <span class="detail-label">Waktu Turnamen</span>
                                    <p class="detail-value">
                                        @if($tournament->event_start && $tournament->event_end)
                                            {{ \Carbon\Carbon::parse($tournament->event_start)->format('d F Y, H:i') }} WIB - {{ \Carbon\Carbon::parse($tournament->event_end)->format('H:i') }} WIB
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
                                    <p class="detail-value">{{ $tournament->location ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-icon"><i class="fas fa-dollar-sign"></i></div>
                                <div class="detail-content">
                                    <span class="detail-label">Biaya Pendaftaran</span>
                                    <p class="detail-value">{{ $tournament->registration_fee ? 'Rp ' . number_format($tournament->registration_fee, 0, ',', '.') : 'Gratis' }}</p>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-icon"><i class="fas fa-trophy"></i></div>
                                <div class="detail-content">
                                    <span class="detail-label">Total Hadiah</span>
                                    <p class="detail-value">{{ $tournament->prize_total ? 'Rp ' . number_format($tournament->prize_total, 0, ',', '.') : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-icon"><i class="fas fa-user-friends"></i></div>
                                <div class="detail-content">
                                    <span class="detail-label">Kategori Gender</span>
                                    <p class="detail-value">{{ $tournament->gender_category ? ucfirst($tournament->gender_category) : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        @if(!$tournament->registration_start && !$tournament->registration_end && !$tournament->event_start && !$tournament->event_end && !$tournament->location && !$tournament->registration_fee && !$tournament->prize_total && !$tournament->gender_category)
                            <p class="no-data-text">Detail turnamen belum tersedia.</p>
                        @endif
                    </div>


                    {{-- Partisipan Tab Content (uses real data from $tournament->registrations) --}}
                    <div class="tab-pane fade" id="partisipan" role="tabpanel" aria-labelledby="partisipan-tab">
                        <h5 class="tab-content-title">DAFTAR PARTISIPAN</h5>
                        @if($tournament->registrations && $tournament->registrations->isNotEmpty())
                            <div class="responsive-table-container"> {{-- Added container for table responsiveness --}}
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Tim</th>
                                            <th>Kapten</th>
                                            <th>Anggota</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tournament->registrations as $registration)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $registration->team->logo ? asset('storage/' . $registration->team->logo) : 'https://via.placeholder.com/40x40/CB2786/FFFFFF?text=TL' }}" alt="Team Logo" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <strong>{{ $registration->team->name ?? 'N/A' }}</strong>
                                                    </div>
                                                </td>
                                                <td>{{ $registration->user->name ?? 'N/A' }}</td> {{-- Captain is the user who registered --}}
                                                <td>
                                                    @if($registration->team && $registration->team->members->isNotEmpty())
                                                        <ul class="list-unstyled mb-0 small">
                                                            @foreach($registration->team->members as $member)
                                                                <li>
                                                                    <a href="#" class="view-member-details"
                                                                       data-bs-toggle="modal" data-bs-target="#memberDetailsModal"
                                                                       data-member-name="{{ $member->name }}"
                                                                       data-member-photo="{{ $member->photo ? asset('storage/' . $member->photo) : asset('assets/img/profile-placeholder.png') }}"
                                                                       data-member-birthdate="{{ \Carbon\Carbon::parse($member->birthdate)->format('d F Y') ?? '-' }}"
                                                                       data-member-gender="{{ ucfirst($member->gender ?? '-') }}"
                                                                       data-member-position="{{ $member->position ?? '-' }}"
                                                                       data-member-jersey="{{ $member->jersey_number ?? '-' }}"
                                                                       data-member-contact="{{ $member->contact ?? '-' }}"
                                                                       data-member-email="{{ $member->email ?? '-' }}">
                                                                        - {{ $member->name }} ({{ $member->position ?? 'Pemain' }})
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted small">Tidak ada anggota</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeClass = '';
                                                        switch($registration->status) {
                                                            case 'pending': $badgeClass = 'bg-warning text-dark'; break;
                                                            case 'confirmed': $badgeClass = 'bg-success'; break;
                                                            case 'rejected': $badgeClass = 'bg-danger'; break;
                                                            default: $badgeClass = 'bg-secondary'; break;
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($registration->status) }}</span>
                                                    @if($registration->rejection_reason)
                                                        <br><small class="text-danger" title="{{ $registration->rejection_reason }}">Alasan: {{ Str::limit($registration->rejection_reason, 30) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.tournaments.registrations.updateStatus', ['tournament' => $tournament->slug, 'registration' => $registration->id]) }}" method="POST" class="update-status-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="status" class="form-select form-select-sm mb-1 registration-status-select" data-current-status="{{ $registration->status }}">
                                                            <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="confirmed" {{ $registration->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                            <option value="rejected" {{ $registration->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                        <textarea name="rejection_reason" class="form-control form-control-sm mt-1 rejection-reason-textarea" placeholder="Alasan penolakan (opsional)" style="display: {{ $registration->status == 'rejected' ? 'block' : 'none' }};">{{ $registration->rejection_reason }}</textarea>
                                                        <button type="submit" class="btn btn-primary btn-sm mt-1">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="no-data-text">Belum ada partisipan terdaftar.</p>
                        @endif
                    </div>

                    {{-- Contact Person Tab Content --}}
                    <div class="tab-pane fade" id="contact-person" role="tabpanel" aria-labelledby="contact-person-tab">
                        <h5 class="tab-content-title">INFORMASI KONTAK</h5>
                        <div class="contact-info-card">
                            <div class="contact-icon"><i class="fas fa-user-circle"></i></div>
                            <div class="contact-content">
                                <p class="contact-person-name">{{ $tournament->contact_person ?? 'Informasi kontak tidak tersedia.' }}</p>
                                <p class="contact-description">Untuk pertanyaan lebih lanjut, silakan hubungi kontak di atas.</p>
                                @if($tournament->contact_person)
                                    @php
                                        // Bersihkan nomor telepon dari karakter non-digit
                                        $phoneNumberClean = preg_replace('/[^0-9]/', '', $tournament->contact_person);
                                        // Tambahkan awalan negara jika belum ada (contoh: untuk Indonesia, 62)
                                        if (substr($phoneNumberClean, 0, 1) === '0') {
                                            $phoneNumberClean = '62' . substr($phoneNumberClean, 1);
                                        } elseif (substr($phoneNumberClean, 0, 2) !== '62' && substr($phoneNumberClean, 0, 1) === '8') {
                                            $phoneNumberClean = '62' . $phoneNumberClean;
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $phoneNumberClean }}" target="_blank" class="btn btn-whatsapp mt-2">
                                        <i class="fab fa-whatsapp me-2"></i> Hubungi via WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL UNTUK INSPECT ANGGOTA TIM --}}
<div class="modal fade" id="memberDetailsModal" tabindex="-1" aria-labelledby="memberDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailsModalLabel">Detail Anggota Tim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalMemberPhoto" src="" alt="Foto Anggota" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                <h5 id="modalMemberName" class="mb-3 text-dark"></h5>
                <div class="text-start">
                    <p><strong>Tanggal Lahir:</strong> <span id="modalMemberBirthdate"></span></p>
                    <p><strong>Jenis Kelamin:</strong> <span id="modalMemberGender"></span></p>
                    <p><strong>Posisi:</strong> <span id="modalMemberPosition"></span></p>
                    <p><strong>Nomor Punggung:</strong> <span id="modalMemberJersey"></span></p>
                    <p><strong>Kontak:</strong> <span id="modalMemberContact"></span></p>
                    <p><strong>Email:</strong> <span id="modalMemberEmail"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Brand Identity Prism Colors */
    :root {
        --primary-pink: #CB2786; /* Main accent color */
        --accent-yellow: #F4B704; /* Secondary accent */
        --dark-blue: #00617A; /* Dominant background/text color */
        --light-blue: #F0F5FF; /* Soft background - can be removed if using white for card/tab content */
        --gray-text: #555;
        --card-bg: #FFFFFF; /* New background for main content area */
        --border-color: #EEE;
    }

    body {
        background-color: var(--light-blue); /* Keep this as the main body background */
        font-family: 'Arial', sans-serif;
        color: var(--gray-text);
    }

    .tournament-detail-page-wrapper {
        padding-top: 20px;
        padding-bottom: 20px;
    }

    /* Top Header Section */
    .top-header-section {
        margin-bottom: 25px;
        padding-top: 15px;
    }

    .btn-back {
        background-color: var(--light-blue);
        color: var(--dark-blue);
        border-radius: 8px;
        font-weight: 600;
        padding: 8px 18px;
        font-size: 0.9em;
        transition: background-color 0.2s ease, color 0.2s ease;
        border: 1px solid var(--dark-blue);
    }
    .btn-back:hover {
        background-color: var(--dark-blue);
        color: #fff;
    }

    .date-info {
        font-size: 0.85em;
        color: var(--gray-text);
    }

    /* Tournament Title */
    .tournament-title {
        font-size: 2.8em;
        font-weight: 700;
        color: var(--dark-blue);
        text-align: center;
        margin-bottom: 30px;
        line-height: 1.2;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
    }

    /* Tournament Header Image */
    .tournament-header-image-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 380px;
    }
    .tournament-header-image-container .tournament-thumbnail-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        padding: 10px;
        box-sizing: border-box;
    }


    /* Summary Boxes */
    .summary-boxes-container {
        background-color: var(--dark-blue);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px !important;
        display: flex;
        flex-wrap: wrap; /* Allow wrapping for the new box */
        animation: fadeIn 0.8s ease-out;
    }

    .summary-box {
        color: #fff;
        padding: 20px 0;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .summary-boxes-container .col-6:first-child .summary-box {
        border-right: 1px solid rgba(255, 255, 255, 0.2);
    }
    /* Style for the new full-width box */
    .summary-boxes-container .total-registrations-overall {
        background-color: rgba(0, 0, 0, 0.2); /* Slightly darker or different shade */
        border-top: 1px solid rgba(255, 255, 255, 0.2); /* Separator */
    }


    .summary-box .label {
        font-size: 0.9em;
        opacity: 0.9;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 500;
    }
    .summary-box .value {
        font-size: 2em;
        font-weight: 700;
        color: var(--accent-yellow);
    }

    /* Tabs Section */
    .tabs-section {
        background-color: var(--card-bg); /* Set tab section background to white */
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.08);
        padding: 30px;
        animation: slideInUp 0.8s ease-out;
    }

    .custom-tabs {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background-color: transparent; /* Changed from gray */
        border-radius: 0; /* Make corners sharp, blend with parent card */
        padding: 0; /* Remove internal padding */
        box-shadow: none; /* Remove inset shadow */
        border-bottom: 2px solid var(--border-color); /* Add a subtle separator line */
        padding-bottom: 5px; /* Space between line and tab content */
    }

    .custom-tabs .nav-item {
        flex-grow: 1;
        text-align: center;
    }

    .custom-tabs .nav-link {
        background-color: transparent;
        color: var(--dark-blue);
        border: none;
        border-radius: 6px;
        padding: 10px 15px;
        font-weight: 600;
        font-size: 0.95em;
        transition: all 0.3s ease;
        display: block;
    }

    .custom-tabs .nav-link:hover {
        background-color: rgba(203, 39, 134, 0.1); /* Pink hover */
        color: var(--primary-pink);
    }

    .custom-tabs .nav-link.active {
        background-color: var(--primary-pink); /* Active tab is pink */
        color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Twitter Icon */
    .social-icon-wrapper {
        flex-grow: 0;
        margin-left: 10px;
    }
    .twitter-icon {
        background-color: #1DA1F2;
        color: #fff;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 6px;
        font-size: 1.2em;
        padding: 0;
        transition: background-color 0.2s ease;
    }
    .twitter-icon:hover {
        background-color: #0c85d0;
        color: #fff;
    }

    /* Tab Content General */
    .custom-tab-content {
        padding: 20px 0;
        /* No background color here, it inherits from .tabs-section */
    }

    .tab-content-title {
        font-size: 1.8em;
        font-weight: 700;
        color: var(--dark-blue);
        margin-bottom: 20px;
        text-align: left;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 10px;
    }

    .no-data-text {
        font-style: italic;
        color: #777;
        text-align: center;
        padding: 20px;
        background-color: var(--light-blue); /* Keep this as a subtle background for empty state */
        border-radius: 8px;
        margin-top: 20px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }

    /* Peraturan Tab Content Enhancements */
    .rule-section {
        margin-bottom: 30px;
        padding: 15px;
        background-color: var(--light-blue); /* Keep a subtle background for rule sections */
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .rule-category-title {
        font-size: 1.2em;
        font-weight: 700; /* Bold the category title */
        color: var(--dark-blue);
        margin-bottom: 15px;
        display: block; /* Ensure it takes full width and new line */
        text-transform: uppercase; /* Optional: make it uppercase for emphasis */
    }

    .rules-list-detailed {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    .rules-list-detailed li {
        margin-bottom: 10px;
        padding-left: 25px;
        position: relative;
        line-height: 1.6;
        color: var(--gray-text);
        font-size: 0.98em;
    }
    .rule-bullet-icon {
        position: absolute;
        left: 0;
        top: 5px;
        color: var(--primary-pink);
        font-size: 1.1em;
    }

    /* Styles for plain paragraph if no title and no points extracted */
    .rule-text {
        font-size: 0.95em;
        line-height: 1.6;
        color: var(--gray-text);
        margin-bottom: 0;
        padding-left: 0; /* Ensure no indent if it's a plain paragraph */
    }


    /* Event Detail Tab Content Enhancements (Grid Layout) */
    .event-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .detail-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        padding: 20px;
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    .detail-icon {
        background-color: var(--light-blue);
        color: var(--primary-pink);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5em;
        margin-right: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .detail-content .detail-label {
        font-size: 0.85em;
        font-weight: 600;
        color: var(--dark-blue);
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    .detail-content .detail-value {
        font-size: 1.1em;
        font-weight: 700;
        color: var(--gray-text);
        margin-bottom: 0;
    }

    /* Partisipan Tab Content Enhancements (Table Layout) */
    .responsive-table-container {
        overflow-x: auto; /* Make table horizontally scrollable on small screens */
        margin-top: 20px;
    }
    .responsive-table-container table {
        min-width: 700px; /* Ensure table doesn't get too squished */
    }
    .responsive-table-container th,
    .responsive-table-container td {
        white-space: nowrap; /* Prevent text wrapping in table cells */
    }

    /* Custom styles for select and textarea in table */
    .registration-status-select {
        min-width: 120px; /* Ensure dropdown is wide enough */
    }
    .rejection-reason-textarea {
        min-width: 150px; /* Ensure textarea is wide enough */
        resize: vertical; /* Allow vertical resizing only */
    }

    /* Member details link style */
    .view-member-details {
        color: var(--dark-blue); /* or a different accent color */
        text-decoration: underline;
        cursor: pointer;
    }
    .view-member-details:hover {
        color: var(--primary-pink);
    }


    /* Contact Person Tab Content */
    .contact-info-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        padding: 25px;
        display: flex;
        align-items: flex-start;
        border: 1px solid var(--border-color);
        margin-top: 20px;
    }
    .contact-info-card .contact-icon {
        background-color: var(--accent-yellow);
        color: var(--dark-blue);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2em;
        margin-right: 20px;
        flex-shrink: 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .contact-info-card .contact-content {
        flex-grow: 1;
    }
    .contact-info-card .contact-person-name {
        font-size: 1.4em;
        font-weight: 700;
        color: var(--dark-blue);
        margin-bottom: 5px;
    }
    .contact-info-card .contact-description {
        font-size: 0.95em;
        color: var(--gray-text);
        margin-bottom: 15px;
    }
    .btn-whatsapp {
        background-color: #25D366; /* WhatsApp green */
        color: #fff;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.95em;
        transition: background-color 0.2s ease;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }
    .btn-whatsapp:hover {
        background-color: #1DA851;
        color: #fff;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .tournament-title {
            font-size: 2em;
        }
        .summary-box .value {
            font-size: 1.5em;
        }
        .custom-tabs {
            flex-wrap: wrap;
            justify-content: center;
            padding: 0;
            border-bottom: none;
        }
        .custom-tabs .nav-item {
            flex-basis: 50%;
            margin-bottom: 5px;
        }
        .custom-tabs .nav-link {
            padding: 8px 10px;
            font-size: 0.85em;
        }
        .social-icon-wrapper {
            flex-basis: 100%;
            margin-left: 0;
            margin-top: 10px;
            text-align: center;
        }
        .twitter-icon {
            margin: auto;
        }
        .event-details-grid, .participants-grid {
            grid-template-columns: 1fr;
        }
        .detail-card, .participant-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .detail-icon, .participant-logo {
            margin-right: 0;
            margin-bottom: 15px;
        }
        .participant-members-list ul {
            display: block;
        }
        .participant-members-list li {
            display: block;
            margin-bottom: 5px;
        }
    }

    @media (max-width: 576px) {
        .tournament-detail-page-wrapper {
            padding-left: 15px;
            padding-right: 15px;
        }
        .summary-boxes-container {
            flex-direction: column;
        }
        .summary-boxes-container .col-6:first-child .summary-box {
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
    }
</style>
@endpush

@push('scripts')
{{-- SweetAlert for status update messages --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle session messages using SweetAlert
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500
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

        // Logic for "Rejection Reason" textarea visibility
        document.querySelectorAll('.registration-status-select').forEach(selectElement => {
            const form = selectElement.closest('form');
            const rejectionReasonTextarea = form.querySelector('.rejection-reason-textarea');

            // Set initial visibility when page loads
            if (selectElement.value === 'rejected') {
                rejectionReasonTextarea.style.display = 'block';
                rejectionReasonTextarea.setAttribute('required', 'required'); // Make required if rejected
            } else {
                rejectionReasonTextarea.style.display = 'none';
                rejectionReasonTextarea.removeAttribute('required');
            }

            // Add change listener for future changes
            selectElement.addEventListener('change', function() {
                if (this.value === 'rejected') {
                    rejectionReasonTextarea.style.display = 'block';
                    rejectionReasonTextarea.setAttribute('required', 'required');
                } else {
                    rejectionReasonTextarea.style.display = 'none';
                    rejectionReasonTextarea.removeAttribute('required');
                    rejectionReasonTextarea.value = ''; // Clear content when not rejected
                }
            });
        });

        // Confirm before submitting status update
        document.querySelectorAll('.update-status-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                const currentStatus = this.querySelector('.registration-status-select').dataset.currentStatus;
                const newStatus = this.querySelector('.registration-status-select').value;
                // Safely get team name, considering it might be inside a strong tag
                const teamNameElement = this.closest('tr').querySelector('.participant-team-name');
                const teamName = teamNameElement ? teamNameElement.textContent.trim() : 'Nama Tim Tidak Diketahui';


                if (currentStatus === newStatus) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Perubahan',
                        text: 'Status pendaftaran tim ' + teamName + ' sudah ' + newStatus + '.',
                        confirmButtonText: 'Oke'
                    });
                    return; // Stop submission
                }

                Swal.fire({
                    title: "Konfirmasi Perubahan Status",
                    text: "Anda yakin ingin mengubah status pendaftaran tim " + teamName + " dari '" + currentStatus + "' menjadi '" + newStatus + "'?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Ubah!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form programmatically
                        form.submit();
                    }
                });
            });
        });

        // Logic for Member Details Modal (Inspect Information)
        const memberDetailsModal = new bootstrap.Modal(document.getElementById('memberDetailsModal'));
        document.querySelectorAll('.view-member-details').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                // Get data from data-attributes
                const memberPhoto = this.dataset.memberPhoto;
                const memberName = this.dataset.memberName;
                const memberBirthdate = this.dataset.memberBirthdate;
                const memberGender = this.dataset.memberGender;
                const memberPosition = this.dataset.memberPosition;
                const memberJersey = this.dataset.memberJersey;
                const memberContact = this.dataset.memberContact;
                const memberEmail = this.dataset.memberEmail;

                // Populate modal fields
                document.getElementById('modalMemberPhoto').src = memberPhoto;
                document.getElementById('modalMemberName').textContent = memberName;
                document.getElementById('modalMemberBirthdate').textContent = memberBirthdate;
                document.getElementById('modalMemberGender').textContent = memberGender;
                document.getElementById('modalMemberPosition').textContent = memberPosition;
                document.getElementById('modalMemberJersey').textContent = memberJersey;
                document.getElementById('modalMemberContact').textContent = memberContact;
                document.getElementById('modalMemberEmail').textContent = memberEmail;

                // Show the modal
                memberDetailsModal.show();
            });
        });
    });
</script>
@endpush
