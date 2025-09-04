@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('admin.matches.index') }}" class="btn px-4 py-2"
                style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.matches.update', $match->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        {{-- Tournament --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium">Turnamen</label>
                            <input type="text" class="form-control border-success rounded-3 readonly-input"
                                value="{{ $match->tournament->title ?? '-' }}" disabled>
                            <input type="hidden" name="tournament_id" value="{{ $match->tournament_id }}">
                        </div>

                        {{-- Match Date & Time --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium">Tanggal & Waktu Pertandingan</label>
                            <input type="datetime-local" name="match_datetime" id="match_datetime"
                                class="form-control border-success rounded-3 readonly-input"
                                value="{{ \Carbon\Carbon::parse($match->match_datetime)->format('Y-m-d\TH:i') }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        {{-- Stage --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium">Tahapan Pertandingan</label>
                            <input type="text" name="stage"
                                class="form-control border-success rounded-3 readonly-input" value="{{ $match->stage }}"
                                disabled>
                        </div>

                        {{-- Location --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium">Lokasi Pertandingan</label>
                            <input type="text" name="location"
                                class="form-control border-success rounded-3 readonly-input" value="{{ $match->location }}"
                                disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        {{-- Team 1 --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium">Tim 1</label>
                            <input type="text" class="form-control border-success rounded-3 readonly-input"
                                value="{{ $match->team1->name ?? '-' }}" disabled>
                            <input type="hidden" name="team1_id" value="{{ $match->team1_id }}">
                        </div>

                        {{-- Team 2 --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium">Tim 2</label>
                            <input type="text" class="form-control border-success rounded-3 readonly-input"
                                value="{{ $match->team2->name ?? '-' }}" disabled>
                            <input type="hidden" name="team2_id" value="{{ $match->team2_id }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        {{-- Status Pertandingan --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary fw-medium" for="status">Status Pertandingan <span
                                    class="text-danger">*</span></label>
                            <select name="status" id="status"
                                class="form-select border-success rounded-3 @error('status') is-invalid @enderror" required>
                                <option value="scheduled"
                                    {{ old('status', $match->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in-progress"
                                    {{ old('status', $match->status) == 'in-progress' ? 'selected' : '' }}>In-Progress
                                </option>
                                <option value="completed"
                                    {{ old('status', $match->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled"
                                    {{ old('status', $match->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Score Team 1 --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary fw-medium" for="team1_score">Skor Tim 1</label>
                            <input type="number" name="team1_score" id="team1_score"
                                class="form-control border-success rounded-3 @error('team1_score') is-invalid @enderror"
                                value="{{ old('team1_score', $match->team1_score) }}" min="0">
                            @error('team1_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Score Team 2 --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary fw-medium" for="team2_score">Skor Tim 2</label>
                            <input type="number" name="team2_score" id="team2_score"
                                class="form-control border-success rounded-3 @error('team2_score') is-invalid @enderror"
                                value="{{ old('team2_score', $match->team2_score) }}" min="0">
                            @error('team2_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        {{-- Winner --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium" for="winner_id">Pemenang</label>
                            <select name="winner_id" id="winner_id"
                                class="form-select border-success rounded-3 @error('winner_id') is-invalid @enderror">
                                <option value="">Pilih Pemenang</option>
                                <option value="{{ $match->team1->id ?? '' }}"
                                    {{ old('winner_id', $match->winner_id) == ($match->team1->id ?? '') ? 'selected' : '' }}>
                                    {{ $match->team1->name ?? '' }}</option>
                                <option value="{{ $match->team2->id ?? '' }}"
                                    {{ old('winner_id', $match->winner_id) == ($match->team2->id ?? '') ? 'selected' : '' }}>
                                    {{ $match->team2->name ?? '' }}</option>
                            </select>
                            @error('winner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-3">Update Match</button>
                        <a href="{{ route('admin.matches.index') }}"
                            class="btn btn-outline-secondary px-4 py-2 rounded-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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
            color: #fff;
        }

        .btn-success:hover {
            background-color: #1fb47a;
            border-color: #1fb47a;
            color: #fff;
        }

        .readonly-input {
            background-color: #e9ecef !important;
            color: #6c757d !important;
            opacity: 0.7 !important;
            cursor: default !important;
            border-color: #ced4da !important;
            box-shadow: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateScore(matchId) {
            $.ajax({
                url: `/api/matches/${matchId}/score`,
                type: 'GET',
                success: function(data) {
                    // Update tampilan skor di halaman
                    $(`#score-team1-${matchId}`).text(data.team1_score);
                    $(`#score-team2-${matchId}`).text(data.team2_score);
                }
            });
        }

        setInterval(function() {
            updateScore(1);
        }, 5000);
    </script>
@endpush
