{{-- resources/views/front/teams/members/edit.blade.php --}}

@extends('../layouts/master_nav')

@section('title', 'Edit Anggota Tim')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Kartu Edit Anggota Tim --}}
            <div class="card shadow-sm profile-edit-card">
                <div class="card-header bg-white text-center py-3">
                    <h4 class="mb-0 profile-section-title">Edit Anggota Tim: {{ $member->name }} (Tim {{ $team->name }})</h4>
                </div>
                <div class="card-body">
                    {{-- Form untuk Edit Anggota Tim --}}
                    {{-- Perhatikan rute 'update' membutuhkan ID tim DAN ID anggota --}}
                    <form action="{{ route('team.members.update', ['team' => \Illuminate\Support\Facades\Crypt::encryptString($team->id), 'member' => \Illuminate\Support\Facades\Crypt::encryptString($member->id)]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Penting: Gunakan method PUT untuk update --}}

                        {{-- Input Foto Anggota --}}
                        <div class="mb-4 text-center">
                            <label for="photo" class="form-label d-block mb-3 profile-photo-upload-area">
                                <div class="profile-photo-wrapper mb-2">
                                    {{-- Preview foto anggota: tampilkan foto lama jika ada, atau placeholder --}}
                                    <img src="{{ $member->photo ? asset('storage/' . $member->photo) : asset('assets/img/profile-placeholder.png') }}"
                                         alt="Foto Anggota" class="img-fluid editable-profile-photo" width="120" height="120">
                                    <div class="profile-photo-overlay">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                </div>
                                <div class="btn btn-sm btn-outline-secondary d-block mx-auto upload-button">Ganti Foto</div>
                            </label>
                            <input type="file" class="form-control d-none" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maksimal ukuran 2MB (jpeg, png, jpg, gif, webp).</small>

                            {{-- Checkbox untuk Hapus Foto --}}
                            @if($member->photo)
                                <div class="form-check mt-2 d-inline-block">
                                    <input class="form-check-input" type="checkbox" name="clear_photo" id="clear_photo" value="1">
                                    <label class="form-check-label" for="clear_photo">
                                        Hapus Foto
                                    </label>
                                </div>
                            @endif
                        </div>

                        {{-- Input Nama Anggota --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap Anggota</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $member->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Tanggal Lahir --}}
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Tanggal Lahir</label>
                            {{-- Format tanggal untuk input type="date" harus YYYY-MM-DD --}}
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate', $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('Y-m-d') : '') }}">
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Jenis Kelamin --}}
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                <option value="other" {{ old('gender', $member->gender) == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Posisi --}}
                        <div class="mb-3">
                            <label for="position" class="form-label">Posisi (Opsional)</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $member->position) }}" placeholder="Contoh: Striker, Midfielder">
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Nomor Punggung (Jersey Number) --}}
                        <div class="mb-3">
                            <label for="jersey_number" class="form-label">Nomor Punggung (Opsional)</label>
                            <input type="number" class="form-control @error('jersey_number') is-invalid @enderror" id="jersey_number" name="jersey_number" value="{{ old('jersey_number', $member->jersey_number) }}" min="1" max="99">
                            @error('jersey_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Kontak Anggota --}}
                        <div class="mb-3">
                            <label for="contact" class="form-label">Kontak Anggota (Opsional)</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact', $member->contact) }}" placeholder="No. Telepon atau Link Sosial Media">
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Email Anggota --}}
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Anggota (Opsional, Unik)</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $member->email) }}" placeholder="email@contoh.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Update Anggota</button>
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
        /* Gaya tambahan khusus untuk halaman edit anggota tim, meniru edit.profile */
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

        /* Gaya untuk area upload foto/logo, sama dengan edit.profile */
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const photoInput = document.getElementById('photo');
            const photoPreview = document.querySelector('.editable-profile-photo');
            const photoUploadArea = document.querySelector('.profile-photo-upload-area');
            const clearPhotoCheckbox = document.getElementById('clear_photo'); // Ambil checkbox clear photo

            // Dapatkan URL foto asli dari Blade jika ada
            const originalPhotoSrc = photoPreview.src;

            photoUploadArea.addEventListener('click', function(event) {
                if (event.target !== photoInput && event.target !== clearPhotoCheckbox) { // Hindari klik ganda pada input file/checkbox
                    event.preventDefault();
                    photoInput.click();
                }
            });

            function previewImage(inputElement, previewElement) {
                if (inputElement.files && inputElement.files[0]) {
                    const file = inputElement.files[0];
                    const fileSize = file.size / (1024 * 1024); // Size in MB
                    const maxFileSize = 2; // Max size in MB, corresponds to 2048 KB in validation

                    if (fileSize > maxFileSize) {
                        alert(`Ukuran foto tidak boleh lebih dari ${maxFileSize} MB.`);
                        inputElement.value = ''; // Clear the selected file
                        // Kembalikan ke foto lama atau placeholder
                        if (originalPhotoSrc && !clearPhotoCheckbox.checked) {
                            previewElement.src = originalPhotoSrc;
                        } else {
                            previewElement.src = '{{ asset('assets/img/profile-placeholder.png') }}';
                        }
                        return; // Stop further processing
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        if (clearPhotoCheckbox) { // Jika ada checkbox, pastikan tidak dicentang saat foto baru dipilih
                            clearPhotoCheckbox.checked = false;
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika tidak ada file baru dipilih
                    if (originalPhotoSrc && !clearPhotoCheckbox.checked) {
                        previewElement.src = originalPhotoSrc; // Kembali ke foto lama jika ada dan tidak dihapus
                    } else {
                        previewElement.src = '{{ asset('assets/img/profile-placeholder.png') }}'; // Kembali ke placeholder
                    }
                }
            }

            photoInput.addEventListener('change', function(event) {
                previewImage(event.target, photoPreview);
            });

            // Logika untuk checkbox "Hapus Foto"
            if (clearPhotoCheckbox) {
                clearPhotoCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        photoPreview.src = '{{ asset('assets/img/profile-placeholder.png') }}'; // Tampilkan placeholder
                        photoInput.value = ''; // Hapus file yang mungkin sudah dipilih
                    } else {
                        // Jika tidak dicentang, kembalikan ke foto asli jika ada
                        if (originalPhotoSrc) {
                            photoPreview.src = originalPhotoSrc;
                        }
                    }
                });
            }
        });
    </script>
@endpush
