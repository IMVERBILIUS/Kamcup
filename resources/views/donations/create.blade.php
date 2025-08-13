@extends('../layouts/master_nav')

@section('title', 'Ajukan Donasi/Sponsor')

@section('content')
    <div class="bg-donasi-wrapper">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    {{-- Kartu untuk Form Sponsor/Donasi --}}
                    <div class="card shadow-sm profile-edit-card">
                        <div class="card-header bg-white text-center py-3">
                            <h4 class="mb-0 profile-section-title card-title">Ajukan Sponsorship/Donasi</h4>
                        </div>
                        <div class="card-body">

                            <form id="donationForm" action="{{ route('donations.store') }}" method="POST">
                                @csrf

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- NAMA BISA DIEDIT, EMAIL READONLY --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="namaBrand" class="form-label">Nama/Brand <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control editable-field @error('name_brand') is-invalid @enderror"
                                               id="namaBrand" 
                                               name="name_brand" 
                                               value="{{ old('name_brand', Auth::user()->name) }}" 
                                               placeholder="Masukkan nama perusahaan/brand Anda" 
                                               required>
                                        <small class="text-muted">Anda bisa menggunakan nama perusahaan atau brand</small>
                                        @error('name_brand')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email Kontak</label>
                                        <input type="email" 
                                               class="form-control readonly-field" 
                                               value="{{ Auth::user()->email }}" 
                                               readonly>
                                        <small class="text-muted">Email diambil dari akun Anda</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon (WhatsApp) <span class="text-danger">*</span></label>
                                    <input type="tel" 
                                           class="form-control editable-field @error('phone_whatsapp') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone_whatsapp" 
                                           value="{{ old('phone_whatsapp') }}" 
                                           placeholder="Contoh: 081234567890" 
                                           required>
                                    @error('phone_whatsapp')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tournament_id" class="form-label">Nama Acara/Pertandingan <span class="text-danger">*</span></label>
                                    <select id="tournament_id" 
                                            name="tournament_id" 
                                            class="form-control editable-field @error('tournament_id') is-invalid @enderror" 
                                            required>
                                        <option value="">Pilih Pertandingan</option>
                                        @foreach ($tournaments as $tournament)
                                            <option value="{{ $tournament->id }}" {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
                                                {{ $tournament->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tournament_id')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="donationType" class="form-label">Jenis Pendanaan <span class="text-danger">*</span></label>
                                    <select id="donationType" 
                                            name="donation_type" 
                                            class="form-control editable-field @error('donation_type') is-invalid @enderror" 
                                            required>
                                        <option value="">Pilih Jenis Pendanaan</option>
                                        <option value="sponsor" {{ old('donation_type') == 'sponsor' ? 'selected' : '' }}>
                                            Sponsor
                                        </option>
                                        <option value="donatur" {{ old('donation_type') == 'donatur' ? 'selected' : '' }}>
                                            Donatur
                                        </option>
                                    </select>
                                    @error('donation_type')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="sponsorTypeGroup" style="display: {{ old('donation_type') == 'sponsor' ? 'block' : 'none' }};">
                                    <label for="sponsorType" class="form-label">Jenis Sponsor <span class="text-danger">*</span></label>
                                    <select id="sponsorType" 
                                            name="sponsor_type" 
                                            class="form-control editable-field @error('sponsor_type') is-invalid @enderror">
                                        <option value="">Pilih Jenis Sponsor</option>
                                        <option value="XXL" {{ old('sponsor_type') == 'XXL' ? 'selected' : '' }}>XXL</option>
                                        <option value="XL" {{ old('sponsor_type') == 'XL' ? 'selected' : '' }}>XL</option>
                                        <option value="L" {{ old('sponsor_type') == 'L' ? 'selected' : '' }}>L</option>
                                        <option value="M" {{ old('sponsor_type') == 'M' ? 'selected' : '' }}>M</option>
                                        <option value="Pilihan Lainnya" {{ old('sponsor_type') == 'Pilihan Lainnya' ? 'selected' : '' }}>
                                            Pilihan Lainnya
                                        </option>
                                    </select>
                                    @error('sponsor_type')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror

                                    <div class="sponsor-benefits mt-3" id="sponsorBenefits" style="display: {{ old('sponsor_type') ? 'block' : 'none' }};">
                                        <h4>Benefit</h4>
                                        <ul id="benefitsList">
                                            {{-- Content diisi oleh JavaScript --}}
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Kesan/Pesan</label>
                                    <textarea id="message" 
                                              name="message" 
                                              placeholder="Opsional - Sampaikan pesan atau harapan Anda" 
                                              class="form-control editable-field" 
                                              rows="4">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- QR Code Section --}}
                                <div class="qr-code" id="qrCodeSection" style="display: none;">
                                    <div class="qr-placeholder text-center">
                                        <p class="fw-bold">Silakan lakukan pembayaran ke QR Code berikut:</p>
                                        <div class="mb-4">
                                            <svg width="250" height="250" viewBox="0 0 292 292" fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect width="292" height="292" fill="url(#pattern0_6928_977)" />
                                                <defs>
                                                    <pattern id="pattern0_6928_977" patternContentUnits="objectBoundingBox"
                                                        width="1" height="1">
                                                        <use xlink:href="#image0_6928_977"
                                                            transform="scale(0.00444444)" />
                                                    </pattern>
                                                    <image id="image0_6928_977" width="225" height="225"
                                                        preserveAspectRatio="none"
                                                        xlink:href="data:image/png;base64,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" />
                                                </defs>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Pengajuan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Background Image */
        .bg-donasi-wrapper {
            background-image: url('{{ asset('assets/img/bg-form.svg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            z-index: 0;
            min-height: 100vh;
            padding-top: 5rem;
            padding-bottom: 5rem;
        }

        /* Card styles */
        .profile-edit-card {
            border-radius: 12px;
            box-shadow:
                8px 8px 0px 0px var(--kamcup-pink),
                5px 5px 15px rgba(0, 0, 0, 0.1) !important;
            position: relative;
            z-index: 1;
            border: 1px solid #dee2e6;
        }

        .profile-section-title {
            color: var(--kamcup-pink);
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        /* PERBAIKAN: Form control styles yang bisa diedit */
        .form-control.editable-field {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #ffffff; /* Pastikan background putih */
            color: #495057; /* Warna text normal */
        }

        .form-control.editable-field:focus {
            border-color: var(--kamcup-pink);
            box-shadow: 0 0 0 0.2rem rgba(203, 39, 134, 0.25);
            background-color: #ffffff;
        }

        /* PERBAIKAN: Readonly input styling yang berbeda */
        .form-control.readonly-field {
            background-color: #f8f9fa !important;
            border: 1px solid #e9ecef !important;
            color: #6c757d !important;
            cursor: not-allowed;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }

        /* Required field indicator */
        .text-danger {
            color: #dc3545 !important;
        }

        /* Button styles */
        .btn-primary {
            background-color: var(--kamcup-yellow) !important;
            border-color: var(--kamcup-yellow) !important;
            color: var(--kamcup-dark-text) !important;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #e0ac00 !important;
            border-color: #e0ac00 !important;
            transform: translateY(-2px);
        }

        .btn-primary:disabled {
            background-color: #e0ac00 !important;
            border-color: #e0ac00 !important;
            opacity: 0.7;
            transform: none;
        }

        .field-error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        .sponsor-benefits {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        /* QR Code placeholder styling */
        .qr-placeholder-box {
            border-radius: 8px;
        }

        /* Small text styling */
        small.text-muted {
            font-size: 0.85em;
            color: #6c757d !important;
        }

        /* KAMCUP brand color variables */
        :root {
            --kamcup-pink: #cb2786;
            --kamcup-blue-green: #00617a;
            --kamcup-yellow: #f4b704;
            --kamcup-dark-text: #212529;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .row.mb-4 .col-md-6 {
                margin-bottom: 1rem;
            }
            
            .bg-donasi-wrapper {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
        }

        /* DEBUGGING: Pastikan tidak ada CSS yang override input */
        input[readonly] {
            background-color: #f8f9fa !important;
            cursor: not-allowed !important;
        }

        input:not([readonly]) {
            background-color: #ffffff !important;
            cursor: text !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Debug: Pastikan field nama tidak readonly
            const nameField = document.getElementById('namaBrand');
            if (nameField) {
                nameField.removeAttribute('readonly');
                console.log('Name field is editable:', !nameField.hasAttribute('readonly'));
            }

            // Data untuk benefit sponsor
            const benefitsData = {
                "XXL": [
                    "Logo perusahaan di Web", 
                    "Mendapatkan seluruh kontraprestasi yang didapatkan oleh sponsor khusus",
                    "Booth khusus di area event", 
                    "Branding di semua media promosi", 
                    "Merchandise khusus",
                    "Sertifikat apresiasi"
                ],
                "XL": [
                    "Logo perusahaan di Web", 
                    "Mendapatkan seluruh kontraprestasi yang didapatkan oleh sponsor khusus",
                    "Branding di media promosi utama", 
                    "Merchandise khusus"
                ],
                "L": [
                    "Logo perusahaan di Web", 
                    "Mendapatkan kontraprestasi sponsor", 
                    "Branding di beberapa media promosi"
                ],
                "M": [
                    "Logo perusahaan di Web", 
                    "Mendapatkan kontraprestasi dasar"
                ]
            };

            // Elemen-elemen form
            const donationTypeSelect = document.getElementById('donationType');
            const sponsorTypeGroup = document.getElementById('sponsorTypeGroup');
            const sponsorTypeSelect = document.getElementById('sponsorType');
            const sponsorBenefitsDiv = document.getElementById('sponsorBenefits');
            const benefitsList = document.getElementById('benefitsList');
            const qrCodeSection = document.getElementById('qrCodeSection');
            const donationForm = document.getElementById('donationForm');
            const submitBtn = document.getElementById('submitBtn');

            // Fungsi untuk menampilkan/menyembunyikan elemen
            function toggleSponsorFields() {
                const isSponsor = donationTypeSelect.value === 'sponsor';
                sponsorTypeGroup.style.display = isSponsor ? 'block' : 'none';
                if (!isSponsor) {
                    sponsorBenefitsDiv.style.display = 'none';
                }
            }
            
            // Logika JavaScript untuk menampilkan QR Code secara kondisional
            function toggleQrCode() {
                const isFundingTypeSelected = donationTypeSelect.value !== '';
                qrCodeSection.style.display = isFundingTypeSelected ? 'block' : 'none';
            }

            function updateSponsorBenefits() {
                const selectedType = sponsorTypeSelect.value;
                if (selectedType && benefitsData[selectedType]) {
                    benefitsList.innerHTML = ''; // Kosongkan list sebelumnya
                    benefitsData[selectedType].forEach(benefit => {
                        const li = document.createElement('li');
                        li.textContent = benefit;
                        benefitsList.appendChild(li);
                    });
                    sponsorBenefitsDiv.style.display = 'block';
                } else {
                    sponsorBenefitsDiv.style.display = 'none';
                }
            }

            // Event listeners
            donationTypeSelect.addEventListener('change', function() {
                toggleSponsorFields();
                toggleQrCode();
            });
            
            sponsorTypeSelect.addEventListener('change', updateSponsorBenefits);

            donationForm.addEventListener('submit', function(e) {
                if(submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                    submitBtn.disabled = true;
                }
            });

            // Inisialisasi tampilan form saat halaman dimuat
            toggleSponsorFields();
            toggleQrCode();
            updateSponsorBenefits();
        });
    </script>
@endpush
