@extends('layouts.admin')

@section('content')
<style>
/* Custom select dropdown styling, updated to match the new design aesthetic */
.custom-select-dropdown {
    background-color: #f5f5f5; /* Light gray for a modern, clean look */
    border-radius: 0.5rem; /* More rounded corners for sporty youthful feel */
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease;
    border: 1px solid #dee2e6; /* subtle border */
}

.custom-select-dropdown:focus {
    border-color: #00617a; /* Primary color for focus */
    box-shadow: 0 0 0 0.2rem rgba(0, 97, 122, 0.25); /* Primary color shadow */
}

.custom-select-dropdown option {
    font-weight: normal;
}
</style>

<div class="container-fluid px-4" style="min-height: 100vh;">

    {{-- Tournament Header --}}
    <div class="row mb-4">
        <div class="col-12">
            {{-- Applying sportive.inspiration refresh with a bold left border and primary color --}}
            <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;">
                <div class="d-flex align-items-center">
                    {{-- Interactive care: icon background with primary color transparency, reflecting sporty visioner --}}
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                         style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                        {{-- Iconic trophy for tournaments, in primary color --}}
                        <i class="fas fa-trophy fs-2" style="color: #00617a;"></i>
                    </div>
                    <div>
                        {{-- Sporty youthful title with main color --}}
                        <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Manajemen Turnamen</h2>
                        {{-- Reflecting community active process and growth --}}
                        <p class="text-muted mb-0">Kelola turnamen Anda, termasuk status publikasi dan draf.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Button --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            {{-- Expressive competitive: bold button with primary color for main action --}}
            <a href="{{ route('admin.tournaments.create') }}" class="btn text-white d-flex align-items-center px-4 py-2 rounded-pill"
               style="background-color: #f4b704; border: none; font-weight: 600;"> {{-- Yellow for prominent 'add new' action --}}
                <i class="fas fa-plus me-2"></i>
                <span class="fw-small">Tambah Turnamen Baru</span>
            </a>
        </div>
    </div>

    {{-- Tournament Table --}}
    {{-- Sporty youthful: rounded card with shadow --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-4">

            @if(session('success'))
                {{-- Expressive: success alert with consistent styling --}}
                <div class="alert rounded-3 text-white m-0" style="background-color: #00617a; border: none;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3"> {{-- Added mt-3 for spacing after alert --}}
                {{-- Personality: community active process - clear heading for the table --}}
                <h1 class="fs-5 fw-semibold" style="color: #00617a;">Semua Turnamen</h1>
                <div>
                    <form method="GET" class="d-flex align-items-center gap-2">
                        <span class="text-muted fw-semibold">Urutkan Berdasarkan:</span>
                        <select name="sort" class="form-select form-select-sm custom-select-dropdown border-0" onchange="this.form.submit()" style="width: auto; cursor: pointer;">
                            {{-- Commitment growth: clearer options --}}
                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="background-color: #f8f9fa;"> {{-- Light background for header row --}}
                            <th class="py-3" style="color: #6c757d;">Thumbnail</th>
                            <th class="py-3" style="color: #6c757d;">Judul Turnamen</th>
                            <th class="py-3" style="color: #6c757d;">Status</th>
                            <th class="py-3" style="color: #6c757d;">Mulai Pendaftaran</th>
                            <th class="py-3" style="color: #6c757d;">Akhir Pendaftaran</th>
                            <th class="py-3" style="color: #6c757d;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tournaments as $tournament)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td class="py-3">
                                    @if($tournament->thumbnail)
                                        <img src="{{ asset('storage/' . $tournament->thumbnail) }}" alt="thumbnail" class="rounded-3 object-fit-cover" style="width: 100px; height: 60px;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex justify-content-center align-items-center" style="width: 100px; height: 60px;">
                                            <span class="text-muted small">Tanpa Gambar</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 fw-semibold">{{ $tournament->title }}</td>
                                <td class="py-3">
                                    {{-- Expressive: status badges with custom colors from palette --}}
                                    @php
                                        $statusBgColor = '';
                                        $statusTextColor = 'white';
                                        switch(strtolower($tournament->status)) {
                                            case 'published':
                                                $statusBgColor = '#00617a'; // Primary blue for published
                                                break;
                                            case 'draft':
                                                $statusBgColor = '#f4b704'; // Yellow for draft
                                                $statusTextColor = '#212529'; // Dark text for yellow background
                                                break;
                                            default:
                                                $statusBgColor = '#cb2786'; // Magenta for other/unknown
                                                break;
                                        }
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2"
                                          style="background-color: {{ $statusBgColor }}; color: {{ $statusTextColor }};">
                                        {{ ucfirst($tournament->status) }}
                                    </span>
                                </td>
                                <td class="py-3 text-muted">{{ \Carbon\Carbon::parse($tournament->registration_start)->format('d M Y') }}</td>
                                <td class="py-3 text-muted">{{ \Carbon\Carbon::parse($tournament->registration_end)->format('d M Y') }}</td>
                                <td class="py-3">
                                    <div class="d-flex gap-2">
                                        {{-- CRITICAL FIX: Changed $tournament->id to $tournament->slug for show, edit, and destroy --}}
                                        <a href="{{ route('admin.tournaments.show', $tournament->slug) }}" class="btn btn-sm px-2 py-1 rounded-pill" style="background-color: #00617a; color: white;" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tournaments.edit', $tournament->slug) }}" class="btn btn-sm px-2 py-1 rounded-pill" style="background-color: #f4b704; color: #212529;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tournaments.destroy', $tournament->slug) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(event, this.parentElement)" class="btn btn-sm px-2 py-1 rounded-pill" style="background-color: #cb2786; color: white;" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada turnamen ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination --}}
            @if($tournaments->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    <nav aria-label="Tournament pagination">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($tournaments->onFirstPage())
                                <li class="page-item disabled"><span class="page-link rounded-3 border-0">&laquo;</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link rounded-3 border-0" href="{{ $tournaments->previousPageUrl() }}" rel="prev" style="color: #00617a;">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $currentPage = $tournaments->currentPage();
                                $lastPage = $tournaments->lastPage();
                                $pageRange = 5;

                                $startPage = max(1, $currentPage - floor($pageRange / 2));
                                $endPage = min($lastPage, $currentPage + floor($pageRange / 2));

                                if ($currentPage < floor($pageRange / 2)) {
                                    $endPage = min($lastPage, $pageRange);
                                }

                                if ($currentPage > $lastPage - floor($pageRange / 2)) {
                                    $startPage = max(1, $lastPage - $pageRange + 1);
                                }
                            @endphp

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                @if ($i == $currentPage)
                                    <li class="page-item active">
                                        <span class="page-link rounded-3 border-0" style="background-color: #00617a; color: white;">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link rounded-3 border-0" href="{{ $tournaments->url($i) }}" style="color: #00617a;">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($tournaments->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link rounded-3 border-0" href="{{ $tournaments->nextPageUrl() }}" rel="next" style="color: #00617a;">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link rounded-3 border-0">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif

        </div>
    </div>

</div>

{{-- SweetAlert Delete Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Konfirmasi Hapus?',
        text: "Anda yakin ingin menghapus turnamen ini? Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#cb2786', // Red/Magenta for delete confirmation
        cancelButtonColor: '#00617a', // Primary blue for cancel
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batalkan',
        customClass: { // Sporty youthful: rounded buttons
            confirmButton: 'rounded-pill px-4',
            cancelButton: 'rounded-pill px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// Display session success messages (if set from the controller)
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000, // Longer timer for better user experience
    customClass: { // Sporty youthful: rounded popup
        popup: 'rounded-4'
    }
});
@endif

// Display session error messages (if set from the controller)
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: "Terjadi Kesalahan!",
    text: "{{ session('error') }}",
    showConfirmButton: true,
    confirmButtonColor: '#cb2786', // Accent color for error confirm
    customClass: { // Sporty youthful: rounded buttons
        confirmButton: 'rounded-pill px-4',
        popup: 'rounded-4'
    }
});
@endif
</script>
@endsection
