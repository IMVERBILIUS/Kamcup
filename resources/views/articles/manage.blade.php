@extends('layouts.admin')

@section('content')
<style>
/* Custom Select Dropdown - Menekankan Youthful & Sporty */
.custom-select-dropdown {
    background-color: #f0f8ff; /* Light blueish tint for a refreshing feel */
    border-radius: 0.75rem; /* Lebih membulat untuk kesan sporty */
    padding: 0.6rem 1.2rem;
    font-size: 0.9rem;
    font-weight: 600; /* Sedikit lebih tebal */
    color: #00617a; /* Warna teks primer */
    transition: all 0.3s ease-in-out;
    border: 1px solid rgba(0, 97, 122, 0.2); /* Border tipis dengan warna primer */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); /* Sedikit bayangan */
}

.custom-select-dropdown:hover {
    background-color: #e0f2fe; /* Warna hover yang lebih cerah */
}

.custom-select-dropdown:focus {
    border-color: #00617a; /* Fokus pada warna primer */
    box-shadow: 0 0 0 0.25rem rgba(0, 97, 122, 0.25); /* Glow dengan warna primer */
    outline: none; /* Hapus outline default */
}

.custom-select-dropdown option {
    font-weight: normal;
    color: #495057; /* Warna teks default untuk opsi */
}

/* General button styling for consistent sporty feel */
.btn-sporty-primary {
    background-color: #00617a;
    border-color: #00617a;
    color: white;
    border-radius: 0.75rem; /* Consistent sporty rounded corners */
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(0, 97, 122, 0.2);
}

.btn-sporty-primary:hover {
    background-color: #004a5c;
    border-color: #004a5c;
    transform: translateY(-2px); /* Efek hover ringan */
}

.btn-sporty-accent {
    background-color: #f4b704;
    border-color: #f4b704;
    color: #333; /* Kontras dengan kuning */
    border-radius: 0.75rem;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(244, 183, 4, 0.2);
}

.btn-sporty-accent:hover {
    background-color: #e0a700;
    border-color: #e0a700;
    transform: translateY(-2px);
}

.btn-sporty-danger {
    background-color: #cb2786;
    border-color: #cb2786;
    color: white;
    border-radius: 0.75rem;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(203, 39, 134, 0.2);
}

.btn-sporty-danger:hover {
    background-color: #a7206f;
    border-color: #a7206f;
    transform: translateY(-2px);
}

/* Table styling for clean, modern look */
.table th, .table td {
    padding: 1rem; /* Padding lebih banyak */
    border-color: #e9ecef; /* Garis pemisah yang lebih halus */
}

.table thead th {
    background-color: #f8f9fa; /* Latar belakang header tabel */
    border-bottom: 2px solid #e9ecef; /* Garis bawah yang lebih menonjol */
    color: #6c757d !important; /* Warna abu-abu standar */
}

/* Alert styling based on design colors */
.alert-custom-success {
    background-color: rgba(0, 97, 122, 0.1); /* Light tint of primary */
    color: #00617a; /* Primary color text */
    border: 1px solid rgba(0, 97, 122, 0.3);
}

.alert-custom-info {
    background-color: rgba(244, 183, 4, 0.1); /* Light tint of accent */
    color: #f4b704; /* Accent color text */
    border: 1px solid rgba(244, 183, 4, 0.3);
}

/* Badge styling for status */
.badge-status-published {
    background-color: rgba(0, 97, 122, 0.15); /* Light blue from primary */
    color: #00617a; /* Primary blue for text */
    font-weight: 600;
    padding: 0.4em 0.8em;
    border-radius: 0.5rem;
}

.badge-status-draft {
    background-color: rgba(203, 39, 134, 0.15); /* Light magenta from danger */
    color: #cb2786; /* Magenta for text */
    font-weight: 600;
    padding: 0.4em 0.8em;
    border-radius: 0.5rem;
}

</style>
<div class="container-fluid px-4" style="min-height: 100vh;">

    {{-- Article Header - Sportive.Inspiration Refresh, Sporty Youthful --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;"> {{-- Warna #00617a untuk aksen --}}
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                         style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);"> {{-- Biru muda transparan --}}
                        <i class="fas fa-newspaper fs-2" style="color: #00617a;"></i> {{-- Ikon yang lebih relevan untuk artikel, warna #00617a --}}
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Manajemen Artikel Olahraga</h2> {{-- Judul yang lebih spesifik dan sporty --}}
                        <p class="text-muted mb-0">Kelola publikasi, draf, dan pantau pertumbuhan artikel Anda.</p> {{-- Menekankan growth & community --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Button - Expressive, Active Process --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-sporty-primary d-flex align-items-center px-4 py-2"> {{-- Menggunakan kelas sporty custom --}}
                <i class="fas fa-plus me-2"></i>
                <span class="fw-semibold">Tambah Artikel Baru</span> {{-- Lebih tebal --}}
            </a>
        </div>
    </div>

    {{-- Article Table - Interactive Care, Commitment Growth --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success rounded-3 alert-custom-success mb-4"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fs-5 fw-bold" style="color: #00617a;">Daftar Artikel</h1> {{-- Judul tabel dengan warna primer --}}
                <div>
                    <form method="GET" class="d-flex align-items-center gap-2">
                        <span class="text-muted fw-semibold me-2">Urutkan:</span>
                        <select name="sort" class="form-select form-select-sm custom-select-dropdown border-0" onchange="this.form.submit()" style="width: auto;">
                            <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Tanggal Terbaru</option>
                            <option value="view" {{ request('sort') == 'view' ? 'selected' : '' }}>Jumlah Dilihat</option>
                            <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status Publikasi</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="py-3">Thumbnail</th>
                            <th class="py-3">Judul Artikel</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Dilihat</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                            <tr style="border-bottom: 1px solid #f0f0f0;"> {{-- Garis pemisah yang lebih halus --}}
                                <td class="py-3">
                                    @if($article->thumbnail)
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="thumbnail" class="rounded-3 object-fit-cover shadow-sm" style="width: 200px; height: 100px; border: 1px solid #eee;"> {{-- Menambahkan sedikit bayangan dan border --}}
                                    @else
                                        <div class="bg-light rounded-3 d-flex justify-content-center align-items-center shadow-sm" style="width: 200px; height: 100px; border: 1px dashed #ccc;"> {{-- Border dashed untuk "no image" --}}
                                            <span class="text-muted small">Tanpa Gambar</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 fw-semibold text-break">{{ $article->title }}</td> {{-- Judul bold dan wrap text --}}
                                <td class="py-3">
                                    @php
                                        $statusClass = '';
                                        if ($article->status == 'Published') {
                                            $statusClass = 'badge-status-published';
                                        } else {
                                            $statusClass = 'badge-status-draft';
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ $article->status }}
                                    </span>
                                </td>
                                <td class="py-3 text-center"><i class="fas fa-eye me-1 text-muted"></i>{{ $article->views }}</td> {{-- Ikon mata untuk views --}}
                                <td class="py-3">
                                    <div class="d-flex gap-2">
                                        {{-- IMPORTANT: Pass the SLUG for show, edit, and destroy routes --}}
                                        <a href="{{ route('admin.articles.show', $article->slug) }}" class="btn btn-sm btn-outline-info rounded-pill px-3" style="border-color: #00617a; color: #00617a;" title="Lihat Detail"> {{-- Warna outline sesuai primer --}}
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article->slug) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="border-color: #f4b704; color: #f4b704;" title="Edit Artikel"> {{-- Warna outline sesuai aksen --}}
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.articles.destroy', $article->slug) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(event, this.parentElement)" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="border-color: #cb2786; color: #cb2786;" title="Hapus Artikel"> {{-- Warna outline sesuai danger --}}
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-box-open me-2"></i>Tidak ada artikel yang ditemukan. Mulai tulis artikel baru!
                                </td> {{-- Pesan yang lebih interaktif --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

{{-- Custom Pagination - Sporty Visioner Youthful, Commitment Growth --}}
@if($articles->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        <nav aria-label="Article pagination">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if ($articles->onFirstPage())
                    <li class="page-item disabled"><span class="page-link rounded-pill border-0" style="color: #ccc;">&laquo;</span></li> {{-- Rounded-pill --}}
                @else
                    <li class="page-item">
                        <a class="page-link rounded-pill border-0" href="{{ $articles->previousPageUrl() }}" rel="prev" style="color: #00617a; background-color: #e0f2fe;">&laquo;</a> {{-- Warna sesuai palet --}}
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $articles->currentPage();
                    $lastPage = $articles->lastPage();
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

                {{-- Page Number Links --}}
                @for ($i = $startPage; $i <= $endPage; $i++)
                    @if ($i == $currentPage)
                        <li class="page-item active">
                            <span class="page-link rounded-pill border-0" style="background-color: #00617a; border-color: #00617a; color: white; font-weight: bold;">{{ $i }}</span> {{-- Warna primer aktif --}}
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-pill border-0" href="{{ $articles->url($i) }}" style="color: #00617a; background-color: #e0f2fe;">{{ $i }}</a> {{-- Warna non-aktif sesuai palet --}}
                        </li>
                    @endif
                @endfor

                {{-- Next Page Link --}}
                @if ($articles->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-pill border-0" href="{{ $articles->nextPageUrl() }}" rel="next" style="color: #00617a; background-color: #e0f2fe;">&raquo;</a> {{-- Warna sesuai palet --}}
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link rounded-pill border-0" style="color: #ccc;">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endif

        </div>
    </div>
</div>

{{-- SweetAlert - Expressive, Interactive Care --}}
<script>
function confirmDelete(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "Yakin ingin menghapus artikel ini?", {{-- Lebih spesifik --}}
        text: "Anda tidak akan bisa mengembalikannya!", {{-- Lebih ekspresif --}}
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#cb2786", // Warna merah/magenta dari palet
        cancelButtonColor: "#808080", // Abu-abu netral
        confirmButtonText: "Ya, Hapus Sekarang!",
        cancelButtonText: "Batalkan",
        customClass: {
            popup: 'rounded-4', // Sudut membulat
            confirmButton: 'rounded-pill px-4',
            cancelButton: 'rounded-pill px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: "{{ session('success') }}",
    text: "Operasi berhasil!", // Changed to a more general success message
    showConfirmButton: false,
    timer: 2000, // Durasi lebih lama
    customClass: {
        popup: 'rounded-4'
    }
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: "Oops...",
    text: "{{ session('error') }}",
    confirmButtonColor: "#cb2786", // Warna merah/magenta
    customClass: {
        popup: 'rounded-4',
        confirmButton: 'rounded-pill px-4'
    }
});
@endif
</script>
@endsection
