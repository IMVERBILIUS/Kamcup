@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4" style="min-height: 100vh;">

        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                            style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                            <i class="fas fa-volleyball-ball fs-2" style="color: #00617a;"></i>
                        </div>
                        <div>
                            <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Kelola Pertandingan</h2>
                            <p class="text-muted mb-0">Lihat dan atur daftar pertandingan yang terdaftar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Button --}}
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-end">
                <a href="{{ route('admin.matches.create') }}"
                    class="btn text-white d-flex align-items-center px-4 py-2 rounded-pill"
                    style="background-color: #f4b704; border: none; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>
                    <span class="fw-small">Tambah Pertandingan Baru</span>
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert rounded-3 text-white m-0" style="background-color: #00617a; border: none;">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <h1 class="fs-5 fw-semibold mb-4 mt-3" style="color: #00617a;">Daftar Pertandingan</h1>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th class="py-3">Turnamen</th>
                                <th class="py-3">Waktu</th>
                                <th class="py-3">Tim 1</th>
                                <th class="py-3">Skor</th>
                                <th class="py-3">Tim 2</th>
                                <th class="py-3">Lokasi</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($matches as $match)
                                <tr>
                                    <td>{{ $match->tournament->title ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($match->match_datetime)->format('d M Y H:i') }}</td>
                                    <td>{{ $match->team1->name ?? '-' }}</td>
                                    <td>
                                        @if ($match->status == 'completed' || $match->status == 'in-progress')
                                            <strong>{{ $match->team1_score ?? 0 }}</strong> -
                                            <strong>{{ $match->team2_score ?? 0 }}</strong>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $match->team2->name ?? '-' }}</td>
                                    <td>{{ $match->location }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            $statusText = ucfirst(str_replace('-', ' ', $match->status));
                                            switch ($match->status) {
                                                case 'scheduled':
                                                    $statusClass = 'badge bg-secondary';
                                                    break;
                                                case 'in-progress':
                                                    $statusClass = 'badge bg-primary';
                                                    break;
                                                case 'completed':
                                                    $statusClass = 'badge bg-success';
                                                    break;
                                                case 'cancelled':
                                                    $statusClass = 'badge bg-danger';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.matches.edit', $match->id) }}"
                                                class="btn btn-sm px-2 py-1 rounded-pill"
                                                style="background-color: #f4b704; color: #212529;" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(event, this.parentElement)"
                                                    class="btn btn-sm px-2 py-1 rounded-pill"
                                                    style="background-color: #cb2786; color: white;" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">Belum ada pertandingan tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, form) {
            event.preventDefault();

            Swal.fire({
                title: "Konfirmasi Hapus?",
                text: "Yakin ingin menghapus pertandingan ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#cb2786",
                cancelButtonColor: "#00617a",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: 'rounded-pill px-4',
                    cancelButton: 'rounded-pill px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'rounded-4'
                }
            });
        @endif
    </script>
@endsection
