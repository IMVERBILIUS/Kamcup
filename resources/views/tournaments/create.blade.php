@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('admin.tournaments.index') }}" class="btn px-4 py-2"
                style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.tournaments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
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
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-medium">Thumbnail <span class="text-danger">*</span>
                                <small class="text-muted">(Max 2MB, JPG, PNG, WebP)</small></label>
                            <div class="position-relative border rounded-3 d-flex align-items-center justify-content-center @error('thumbnail') border-danger @enderror"
                                style="height: 240px;">
                                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                                    class="position-absolute w-100 h-100 opacity-0 cursor-pointer" style="z-index: 3;">
                                <div id="thumbnail-preview-overlay"
                                    class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center border border-success bg-white rounded-3"
                                    style="pointer-events: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none"
                                        viewBox="0 0 24 24" stroke="#36b37e" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                                    </svg>
                                </div>
                                <img id="thumbnail-image-preview" src="#" alt="Thumbnail Preview"
                                    class="position-absolute w-100 h-100 d-none"
                                    style="object-fit: cover; border-radius: 0.25rem;">
                            </div>
                            @error('thumbnail')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="mb-3">
                                    <label for="title" class="form-label text-secondary fw-medium">Title</label>
                                    <input type="text"
                                        class="form-control border-success rounded-3 @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="location" class="form-label text-secondary fw-medium">Location</label>
                                    <input type="text"
                                        class="form-control border-success rounded-3 @error('location') is-invalid @enderror"
                                        id="location" name="location" value="{{ old('location') }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label text-secondary fw-medium">Status</label>
                                    <select name="status" id="status"
                                        class="form-select border-success rounded-3 @error('status') is-invalid @enderror"
                                        required>
                                        <option value="registration"
                                            {{ old('status') == 'registration' ? 'selected' : '' }}>Registration</option>
                                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing
                                        </option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="gender_category" class="form-label text-secondary fw-medium">Gender Category</label>
                            <select name="gender_category" id="gender_category"
                                class="form-select border-success rounded-3 @error('gender_category') is-invalid @enderror"
                                required>
                                <option value="male" {{ old('gender_category') == 'male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="female" {{ old('gender_category') == 'female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="mixed" {{ old('gender_category') == 'mixed' ? 'selected' : '' }}>Mixed
                                </option>
                            </select>
                            @error('gender_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contact_person" class="form-label text-secondary fw-medium">Contact Person</label>
                            <input type="text"
                                class="form-control border-success rounded-3 @error('contact_person') is-invalid @enderror"
                                id="contact_person" name="contact_person" value="{{ old('contact_person') }}" required>
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="registration_fee" class="form-label text-secondary fw-medium">Registration
                                Fee</label>
                            <input type="number"
                                class="form-control border-success rounded-3 @error('registration_fee') is-invalid @enderror"
                                id="registration_fee" name="registration_fee" value="{{ old('registration_fee') }}"
                                required min="0">
                            @error('registration_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="prize_total" class="form-label text-secondary fw-medium">Total Prize</label>
                            <input type="number"
                                class="form-control border-success rounded-3 @error('prize_total') is-invalid @enderror"
                                id="prize_total" name="prize_total" value="{{ old('prize_total') }}" required
                                min="0">
                            @error('prize_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- START: Added max_participants field --}}
                        <div class="col-md-6 mb-3">
                            <label for="max_participants" class="form-label text-secondary fw-medium">Max Participants
                                (Opsional)</label>
                            <input type="number"
                                class="form-control border-success rounded-3 @error('max_participants') is-invalid @enderror"
                                id="max_participants" name="max_participants" value="{{ old('max_participants') }}"
                                min="1">
                            @error('max_participants')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- END: Added max_participants field --}}

                        <div class="col-md-6 mb-3">
                            <label for="registration_start" class="form-label text-secondary fw-medium">Registration
                                Start</label>
                            <input type="date"
                                class="form-control border-success rounded-3 @error('registration_start') is-invalid @enderror"
                                id="registration_start" name="registration_start"
                                value="{{ old('registration_start') }}" required>
                            @error('registration_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="registration_end" class="form-label text-secondary fw-medium">Registration
                                End</label>
                            <input type="date"
                                class="form-control border-success rounded-3 @error('registration_end') is-invalid @enderror"
                                id="registration_end" name="registration_end" value="{{ old('registration_end') }}"
                                required>
                            @error('registration_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="event_start" class="form-label text-secondary fw-medium">Event Start
                                (Opsional)</label>
                            <input type="datetime-local"
                                class="form-control border-success rounded-3 @error('event_start') is-invalid @enderror"
                                id="event_start" name="event_start" value="{{ old('event_start') }}">
                            @error('event_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="event_end" class="form-label text-secondary fw-medium">Event End
                                (Opsional)</label>
                            <input type="datetime-local"
                                class="form-control border-success rounded-3 @error('event_end') is-invalid @enderror"
                                id="event_end" name="event_end" value="{{ old('event_end') }}">
                            @error('event_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="visibility_status" class="form-label text-secondary fw-medium">Visibility
                                Status</label>
                            <select name="visibility_status" id="visibility_status"
                                class="form-select border-success rounded-3 @error('visibility_status') is-invalid @enderror"
                                required>
                                <option value="Draft" {{ old('visibility_status') == 'Draft' ? 'selected' : '' }}>Draft
                                </option>
                                <option value="Published" {{ old('visibility_status') == 'Published' ? 'selected' : '' }}>
                                    Published</option>
                            </select>
                            @error('visibility_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary fw-medium">Tournament Rules</label>
                        <div id="rules-container">
                            @if (old('rules'))
                                @foreach (old('rules') as $index => $ruleText)
                                    <div class="input-group mb-3">
                                        <input type="text" name="rules[]"
                                            class="form-control border-success rounded-3" placeholder="Rule text..."
                                            value="{{ $ruleText }}" {{ $loop->first ? 'required' : '' }}>
                                        <button type="button" class="btn btn-danger remove-rule"
                                            {{ $loop->first ? 'disabled' : '' }}>Remove</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-3">
                                    <input type="text" name="rules[]" class="form-control border-success rounded-3"
                                        placeholder="Rule text..." required>
                                    <button type="button" class="btn btn-danger remove-rule" disabled>Remove</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-primary" id="add-rule">
                            <i class="fas fa-plus me-1"></i> Add Rule
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="sponsors" class="form-label text-secondary fw-medium">Sponsors (Opsional)</label>
                        <select name="sponsors[]" id="sponsors"
                            class="form-select @error('sponsors') is-invalid @enderror" multiple="multiple"
                            style="width: 100%;">
                            @foreach ($sponsors as $sponsor)
                                {{-- Check if sponsor is in old input to pre-select --}}
                                <option value="{{ $sponsor->id }}"
                                    {{ in_array($sponsor->id, old('sponsors', [])) ? 'selected' : '' }}>
                                    {{ $sponsor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sponsors')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-success px-4 py-2">Save Tournament</button>
                        <a href="{{ route('admin.tournaments.index') }}"
                            class="btn btn-outline-secondary ms-2 px-4 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Sertakan jQuery (PENTING! Pastikan ini di atas Select2) --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        {{-- Sertakan Select2 CSS dan JS --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const rulesContainer = document.getElementById('rules-container');
                const addRuleButton = document.getElementById('add-rule');
                const thumbnailInput = document.getElementById('thumbnail');
                const thumbnailImagePreview = document.getElementById('thumbnail-image-preview');
                const thumbnailPreviewOverlay = document.getElementById('thumbnail-preview-overlay');

                // Initialize Select2 for sponsors dropdown
                $('#sponsors').select2({
                    placeholder: "Pilih Sponsor",
                    allowClear: true
                });


                // Add Rule Functionality
                addRuleButton.addEventListener('click', function() {
                    const newRuleDiv = document.createElement('div');
                    newRuleDiv.classList.add('input-group', 'mb-3');
                    newRuleDiv.innerHTML = `
                <input type="text" name="rules[]" class="form-control border-success rounded-3" placeholder="Rule text...">
                <button type="button" class="btn btn-danger remove-rule">Remove</button>
            `;
                    rulesContainer.appendChild(newRuleDiv);

                    // Enable remove button for previously disabled first rule if more than one rule exists
                    if (rulesContainer.children.length > 1) {
                        const firstRuleRemoveButton = rulesContainer.children[0].querySelector('.remove-rule');
                        if (firstRuleRemoveButton) {
                            firstRuleRemoveButton.disabled = false;
                        }
                    }
                });

                // Remove Rule Functionality
                rulesContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-rule')) {
                        // Ensure at least one rule input remains
                        if (rulesContainer.children.length > 1) {
                            e.target.closest('.input-group').remove();
                        }

                        // If only one rule remains after deletion, disable its remove button
                        if (rulesContainer.children.length === 1) {
                            rulesContainer.children[0].querySelector('.remove-rule').disabled = true;
                        }
                    }
                });

                // Initial check for remove button on page load (if only one rule initially)
                if (rulesContainer.children.length === 1) {
                    rulesContainer.children[0].querySelector('.remove-rule').disabled = true;
                }


                // Thumbnail Preview Functionality
                thumbnailInput.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const file = e.target.files[0];
                        const fileSize = file.size / (1024 * 1024); // Size in MB
                        const maxFileSize = 2; // Max size in MB, corresponds to 2048 KB in validation

                        if (fileSize > maxFileSize) {
                            alert(`Ukuran gambar tidak boleh lebih dari ${maxFileSize} MB.`);
                            thumbnailInput.value = ''; // Clear the selected file
                            thumbnailImagePreview.src = '#';
                            thumbnailImagePreview.classList.add('d-none');
                            thumbnailPreviewOverlay.classList.remove('d-none');
                            return; // Stop further processing
                        }

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            thumbnailImagePreview.src = event.target.result;
                            thumbnailImagePreview.classList.remove('d-none');
                            thumbnailPreviewOverlay.classList.add('d-none');
                        }
                        reader.readAsDataURL(file);
                    } else {
                        thumbnailImagePreview.src = '#';
                        thumbnailImagePreview.classList.add('d-none');
                        thumbnailPreviewOverlay.classList.remove('d-none');
                    }
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .form-control:focus,
            .form-select:focus {
                border-color: #24E491;
                box-shadow: 0 0 0 0.25rem rgba(36, 228, 145, 0.25);
            }

            .btn-primary {
                background-color: #5932EA;
                border-color: #5932EA;
            }

            .btn-primary:hover {
                background-color: #4920D5;
                border-color: #4920D5;
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

@endsection
