@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Approval Header --}}
    <div class="row mb-4">
        <div class="col-12">
            {{-- Applying sportive.inspiration refresh with a bold left border --}}
            <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;">
                <div class="d-flex align-items-center">
                    {{-- Interactive care: icon background with primary color transparency, reflecting sporty visioner --}}
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                         style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                        <i class="fas fa-clipboard-list fs-2" style="color: #00617a;"></i>
                    </div>
                    <div>
                        {{-- Sporty youthful title with main color --}}
                        <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Tinjauan Artikel Olahraga</h2>
                        {{-- Reflecting community active process and growth --}}
                        <p class="text-muted mb-0">Kelola dan publikasikan artikel untuk pertumbuhan komunitas aktif.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sorting Form --}}
    <div class="row mb-4">
        <div class="col-12">
            {{-- Interactive care: rounded, slightly elevated form --}}
            <form method="GET" class="d-flex align-items-center gap-3 bg-white p-3 rounded-4 shadow-sm">
                <span class="text-muted fw-semibold">Urutkan Berdasarkan:</span>
                <select name="sort" class="form-select form-select-sm border-0 bg-light rounded-pill px-3 py-2" onchange="this.form.submit()" style="width: auto; cursor: pointer;">
                    {{-- Commitment & growth: clearer options, using 'latest' for DESC and 'oldest' for ASC --}}
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
                {{-- Adding status filter for better management and interactive care --}}

            </form>
        </div>
    </div>

    {{-- Articles Table --}}
    {{-- Sporty youthful: rounded card with shadow --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            @if (session('success'))
                {{-- Expressive: success alert with consistent styling --}}
                <div class="alert m-3 mb-0 border-0 rounded-3 text-white" style="background-color: #00617a;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($draftArticles->isEmpty())
                {{-- Interactive care: clear message for empty state --}}
                <div class="alert alert-info m-3 border-0 rounded-3 text-dark" style="background-color: #f4b704;">
                    <i class="fas fa-info-circle me-2"></i>Belum ada artikel draft yang tersedia untuk ditinjau.
                </div>
            @else
                <div class="table-responsive p-4">
                    <table class="table table-hover align-middle">
                        <thead>
                            {{-- Competitive: slightly distinct header row --}}
                            <tr style="background-color: #f8f9fa;">
                                <th class="py-3" style="color: #6c757d;">Thumbnail</th>
                                <th class="py-3" style="color: #6c757d;">Judul Artikel</th>
                                <th class="py-3" style="color: #6c757d;">Penulis</th>
                                <th class="py-3" style="color: #6c757d;">Dibuat Pada</th>
                                <th class="py-3" style="color: #6c757d;">Status</th>
                                <th class="py-3" style="color: #6c757d;">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($draftArticles as $article)
                               <tr style="border-bottom: 1px solid #eee;">
                                    <td class="py-3">
                                        @if($article->thumbnail)
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                                alt="thumbnail"
                                                class="rounded-3 object-fit-cover"
                                                style="width: 150px; height: 80px;">
                                        @else
                                            <div class="bg-light rounded-3 d-flex justify-content-center align-items-center"
                                                style="width: 150px; height: 80px;">
                                                <span class="text-muted small">Tanpa Gambar</span>
                                            </div>
                                        @endif
                                    </td>
                                    {{-- Community active process: concise title display --}}
                                    <td class="py-3 fw-semibold" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $article->title }}</td>
                                    <td class="py-3 text-muted">{{ $article->author ?? 'Tidak Diketahui' }}</td>
                                    <td class="py-3 text-muted">{{ $article->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-3">
                                        @php
                                            $statusColor = '';
                                            switch ($article->status) {
                                                case 'draft':
                                                    $statusColor = '#f4b704'; // Kuning dari palet
                                                    break;
                                                case 'published':
                                                    $statusColor = '#00617a'; // Biru dari palet
                                                    break;
                                                default:
                                                    $statusColor = '#6c757d'; // Abu-abu default
                                                    break;
                                            }
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 text-white"
                                              style="background-color: {{ $statusColor }};">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            {{-- Commitment & growth: clear action button --}}
                                           <form action="{{ route('admin.articles.updateStatus', $article->slug) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn text-white rounded-pill btn-sm px-3 py-2"
                                                    style="background-color: #00617a;"
                                                    onclick="confirmPublish(event, this.parentElement)">
                                                    <i class="fas fa-paper-plane me-1"></i> Publikasikan
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

{{-- Custom Pagination --}}
@if ($draftArticles->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        <nav aria-label="Article pagination">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if ($draftArticles->onFirstPage())
                    <li class="page-item disabled"><span class="page-link rounded-3 border-0">&laquo;</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-3 border-0" href="{{ $draftArticles->previousPageUrl() }}" rel="prev" style="color: #00617a;">&laquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $draftArticles->currentPage();
                    $lastPage = $draftArticles->lastPage();
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
                            <span class="page-link rounded-3 border-0" style="background-color: #00617a; color: white;">{{ $i }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-3 border-0" href="{{ $draftArticles->url($i) }}" style="color: #00617a;">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Next Page Link --}}
                @if ($draftArticles->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-3 border-0" href="{{ $draftArticles->nextPageUrl() }}" rel="next" style="color: #00617a;">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link rounded-3 border-0">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endif

</div>

{{-- SweetAlert --}}
<script>
function confirmPublish(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Konfirmasi Publikasi Artikel',
        text: "Anda yakin ingin mempublikasikan artikel ini? Setelah publikasi, artikel akan terlihat oleh pengguna.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00617a',
        cancelButtonColor: '#cb2786',
        confirmButtonText: 'Ya, Publikasikan!',
        cancelButtonText: 'Batalkan',
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

@if(session('success'))
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

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: "Terjadi Kesalahan!",
    text: "{{ session('error') }}",
    showConfirmButton: true,
    confirmButtonColor: '#cb2786',
    customClass: {
        confirmButton: 'rounded-pill px-4',
        popup: 'rounded-4'
    }
});
@endif
</script>

@endsection
