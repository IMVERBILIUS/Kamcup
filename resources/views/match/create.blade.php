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
                {{-- Tambahkan pesan validasi di sini jika diperlukan --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.matches.store') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        {{-- Tournament --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium" for="tournament_id">Turnamen <span
                                    class="text-danger">*</span></label>
                            <select name="tournament_id" id="tournament_id" class="form-control" required>
                                <option value="">Select a Tournament</option>
                                @foreach ($tournaments as $tournament)
                                    <option value="{{ $tournament->id }}">{{ $tournament->title }}</option>
                                @endforeach
                            </select>
                            @error('tournament_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Match Date & Time --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium" for="match_datetime">Tanggal & Waktu
                                Pertandingan <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="match_datetime" id="match_datetime"
                                class="form-control border-success rounded-3 @error('match_datetime') is-invalid @enderror"
                                value="{{ old('match_datetime') }}" required>
                            @error('match_datetime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        {{-- Stage --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium" for="stage">Tahapan Pertandingan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="stage" id="stage"
                                class="form-control border-success rounded-3 @error('stage') is-invalid @enderror"
                                value="{{ old('stage') }}" placeholder="Contoh: Penyisihan, Final" required>
                            @error('stage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium" for="location">Lokasi Pertandingan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="location" id="location"
                                class="form-control border-success rounded-3 @error('location') is-invalid @enderror"
                                value="{{ old('location') }}" placeholder="Lokasi pertandingan" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        {{-- Team 1 --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium" for="team1_id">Tim 1 <span
                                    class="text-danger">*</span></label>
                            <select name="team1_id" id="team1_id" class="form-control" required>
                                <option value="">Select a Tournament first</option>
                            </select>

                            @error('team1_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Team 2 --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-medium" for="team2_id">Tim 2 <span
                                    class="text-danger">*</span></label>
                            <select name="team2_id" id="team2_id" class="form-control" required>
                                <option value="">Select a Tournament first</option>
                            </select>
                            @error('team2_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-3">Save Match</button>
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
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tournament_id').change(function() {
                var tournamentId = $(this).val();
                var teamsDropdown1 = $('#team1_id');
                var teamsDropdown2 = $('#team2_id');

                teamsDropdown1.empty().append('<option value="">Loading teams...</option>');
                teamsDropdown2.empty().append('<option value="">Loading teams...</option>');

                if (tournamentId) {
                    $.ajax({
                        url: '/admin/matches/get-confirmed-teams',
                        type: 'GET',
                        data: {
                            tournament_id: tournamentId
                        },
                        success: function(teams) {
                            teamsDropdown1.empty().append(
                                '<option value="">Select Team 1</option>');
                            teamsDropdown2.empty().append(
                                '<option value="">Select Team 2</option>');

                            $.each(teams, function(key, team) {
                                teamsDropdown1.append('<option value="' + team.id +
                                    '">' + team.name + '</option>');
                                teamsDropdown2.append('<option value="' + team.id +
                                    '">' + team.name + '</option>');
                            });

                            updateTeam2Dropdown();
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching teams: ", error);
                            teamsDropdown1.empty().append(
                                '<option value="">Error loading teams</option>');
                            teamsDropdown2.empty().append(
                                '<option value="">Error loading teams</option>');
                        }
                    });

                    $.ajax({
                        url: '/admin/matches/get-tournament-location',
                        type: 'GET',
                        data: {
                            tournament_id: tournamentId
                        },
                        success: function(data) {
                            $('#location').val(data.location);
                        },
                        error: function(xhr) {
                            console.error("Gagal mengambil lokasi:", xhr.responseJSON?.error ??
                                xhr.statusText);
                            $('#location').val('');
                        }
                    });

                } else {
                    teamsDropdown1.empty().append('<option value="">Select a Tournament first</option>');
                    teamsDropdown2.empty().append('<option value="">Select a Tournament first</option>');
                    $('#location').val('');
                }
            });

            $('#team1_id').change(function() {
                updateTeam2Dropdown();
            });

            function updateTeam2Dropdown() {
                var selectedTeam1Id = $('#team1_id').val();
                var teamsDropdown2 = $('#team2_id');

                teamsDropdown2.find('option').prop('disabled', false);

                if (selectedTeam1Id) {
                    teamsDropdown2.find('option[value="' + selectedTeam1Id + '"]').prop('disabled', true);
                }
            }
        });
    </script>
@endpush
