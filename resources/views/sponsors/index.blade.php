@extends('layouts.admin')

@section('content')
<style>
/* Custom select dropdown styling, updated for consistency */
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

.logo-img {
    width: 120px;
    height: 60px;
    object-fit: contain;
    border-radius: 0.375rem; /* Consistent rounded corners */
}
</style>

<div class="container-fluid px-4" style="min-height: 100vh;">

    {{-- Sponsor Header --}}
    <div class="row mb-4">
        <div class="col-12">
            {{-- Applying sportive.inspiration refresh with a bold left border and primary color --}}
            <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;">
                <div class="d-flex align-items-center">
                    {{-- Interactive care: icon background with primary color transparency, reflecting sporty visioner --}}
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                         style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                        {{-- Icon for sponsors, emphasizing partnership --}}
                        <i class="fas fa-handshake fs-2" style="color: #00617a;"></i>
                    </div>
                    <div>
                        {{-- Sporty youthful title with main color --}}
                        <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Kelola Sponsor</h2>
                        {{-- Reflecting community active process and growth --}}
                        <p class="text-muted mb-0">Atur daftar sponsor dan detail informasi mereka.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Button --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            {{-- Expressive competitive: bold button with primary color for main action --}}
            <a href="{{ route('admin.sponsors.create') }}" class="btn text-white d-flex align-items-center px-4 py-2 rounded-pill"
               style="background-color: #f4b704; border: none; font-weight: 600;"> {{-- Changed to #f4b704 (yellow) for 'add new' as a prominent action --}}
                <i class="fas fa-plus me-2"></i>
                <span class="fw-small">Tambah Sponsor Baru</span>
            </a>
        </div>
    </div>

    {{-- Sponsor Table --}}
    {{-- Sporty youthful: rounded card with shadow --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-4">
            @if(session('success'))
                {{-- Expressive: success alert with primary color --}}
                <div class="alert rounded-3 text-white m-0" style="background-color: #00617a; border: none;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4 mt-3"> {{-- Added mt-3 for spacing after alert --}}
                {{-- Personality: community active process - clear heading for the table --}}
                <h1 class="fs-5 fw-semibold" style="color: #00617a;">Daftar Semua Sponsor</h1>
                <div>
                    <form method="GET" class="d-flex align-items-center gap-2">
                        <span class="text-muted fw-semibold">Urutkan Berdasarkan:</span>
                        <select name="sort" class="form-select form-select-sm custom-select-dropdown border-0" onchange="this.form.submit()" style="width: auto; cursor: pointer;">
                            {{-- Commitment growth: clear sorting options --}}
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                            <option value="sponsor_size" {{ request('sort') == 'sponsor_size' ? 'selected' : '' }}>Ukuran Sponsor</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="background-color: #f8f9fa;"> {{-- Light background for header row --}}
                            <th class="py-3" style="color: #6c757d;">Logo</th>
                            <th class="py-3" style="color: #6c757d;">Nama</th>
                            <th class="py-3" style="color: #6c757d;">Ukuran Sponsor</th>
                            <th class="py-3" style="color: #6c757d;">Deskripsi</th>
                            <th class="py-3" style="color: #6c757d;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sponsors as $sponsor)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td class="py-3">
                                    @if($sponsor->logo)
                                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="logo" class="logo-img">
                                    @else
                                        <div class="bg-light rounded-3 d-flex justify-content-center align-items-center" style="width: 120px; height: 60px;">
                                            <span class="text-muted small">Tanpa Logo</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 fw-semibold">{{ $sponsor->name }}</td>
                                <td class="py-3">{{ ucfirst($sponsor->sponsor_size) }}</td>
                                <td class="py-3 text-truncate" style="max-width: 300px;" title="{{ $sponsor->description }}">{{ $sponsor->description }}</td>
                                <td class="py-3">
                                    <div class="d-flex gap-2">
                                        {{-- Interactive care: styled action buttons --}}
                                        <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}" class="btn btn-sm px-2 py-1 rounded-pill" style="background-color: #f4b704; color: #212529;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Rute DELETE sudah benar menggunakan $sponsor->id --}}
                                        <form action="{{ route('admin.sponsors.destroy', $sponsor->id) }}" method="POST" class="d-inline">
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
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada sponsor ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination --}}
            @if($sponsors->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    <nav aria-label="Sponsor pagination">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($sponsors->onFirstPage())
                                <li class="page-item disabled"><span class="page-link rounded-3 border-0">&laquo;</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link rounded-3 border-0" href="{{ $sponsors->previousPageUrl() }}" rel="prev" style="color: #00617a;">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $currentPage = $sponsors->currentPage();
                                $lastPage = $sponsors->lastPage();
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
                                        {{-- Sporty visioner: active page with primary color --}}
                                        <span class="page-link rounded-3 border-0" style="background-color: #00617a; color: white;">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link rounded-3 border-0" href="{{ $sponsors->url($i) }}" style="color: #00617a;">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($sponsors->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link rounded-3 border-0" href="{{ $sponsors->nextPageUrl() }}" rel="next" style="color: #00617a;">&raquo;</a>
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

{{-- SweetAlert --}}
<script>
function confirmDelete(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "Konfirmasi Hapus?",
        text: "Anda yakin ingin menghapus sponsor ini? Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#cb2786", // Red/Magenta for delete confirmation
        cancelButtonColor: "#00617a", // Primary blue for cancel
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batalkan",
        customClass: { // Sporty youthful: rounded buttons
            confirmButton: 'rounded-pill px-4',
            cancelButton: 'rounded-pill px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
            // Note: The success alert after submission will be handled by Laravel's session flash,
            // so this Swal.fire success message here might be redundant or occur too quickly before page reload.
            // It's generally better to let Laravel's session flash handle post-redirect messages.
            /*
            Swal.fire({
                title: "Berhasil!",
                text: "Sponsor berhasil dihapus.",
                icon: "success",
                confirmButtonColor: "#00617a", // Primary blue for success confirmation
                customClass: { // Sporty youthful: rounded popup
                    popup: 'rounded-4',
                    confirmButton: 'rounded-pill px-4'
                }
            });
            */
        }
    });
}

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
