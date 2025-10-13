@extends('layouts.admin')

@section('content')
<style>
/* Custom select dropdown styling, updated for interactive care and sporty youthful feel */
.custom-select-dropdown {
    background-color: #f5f5f5;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
}
.custom-select-dropdown:focus {
    border-color: #00617a;
    box-shadow: 0 0 0 0.2rem rgba(0, 97, 122, 0.25);
}

/* Styling untuk tampilan kartu di mobile */
.gallery-card-mobile {
    display: flex;
    align-items: flex-start; /* Mengubah align-items-center menjadi flex-start */
    gap: 1rem;
    background-color: #fff;
    padding: 1rem;
    border-radius: 0.75rem; /* Menyesuaikan dengan style lain */
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    margin-bottom: 1rem;
    border-left: 5px solid #00617a;
}
.gallery-card-mobile .thumbnail {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.5rem;
}
.gallery-card-mobile .details {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}
.gallery-card-mobile .title {
    font-weight: 600;
    color: #343a40;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}
.gallery-card-mobile .meta-info {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 0.75rem;
}
.gallery-card-mobile .actions {
    margin-top: auto; /* Mendorong tombol ke bawah */
}
</style>

<div class="container-fluid px-4">
    {{-- Approval Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;">
                <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-md-4 mb-3 mb-md-0"
                         style="flex-shrink: 0; width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                        <i class="fas fa-images fs-2" style="color: #00617a;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Tinjauan Galeri</h2>
                        <p class="text-muted mb-0">Kelola galeri yang diterbitkan dan draft untuk komunitas Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sorting & Status Filter Form --}}
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" class="d-block d-md-flex align-items-md-center gap-md-3 bg-white p-3 rounded-4 shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                    <span class="text-muted fw-semibold">Urutkan:</span>
                    <select name="sort" class="form-select form-select-sm border-0 flex-grow-1" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2 ms-md-auto">
                    <span class="text-muted fw-semibold">Status:</span>
                    <select name="status" class="form-select form-select-sm custom-select-dropdown border-0 flex-grow-1" onchange="this.form.submit()" style="cursor: pointer;">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Terpublikasi</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Galleries Section --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-lg-4 p-0">
            @if (session('success'))
                <div class="alert m-3 mb-0 border-0 rounded-3 text-white" style="background-color: #00617a;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($draftGalleries->isEmpty())
                <div class="alert alert-info m-3 border-0 rounded-3 text-dark" style="background-color: #f4b704;">
                    <i class="fas fa-info-circle me-2"></i>Tidak ada galeri draft yang tersedia untuk ditinjau.
                </div>
            @else
                {{-- PERBAIKAN: Tampilan Tabel untuk Desktop (Medium screen and up) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th class="py-3" style="color: #6c757d;">Thumbnail</th>
                                <th class="py-3" style="color: #6c757d;">Judul</th>
                                <th class="py-3" style="color: #6c757d;">Penulis</th>
                                <th class="py-3" style="color: #6c757d;">Dibuat Pada</th>
                                <th class="py-3" style="color: #6c757d;">Status</th>
                                <th class="py-3 text-center" style="color: #6c757d;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($draftGalleries as $gallery)
                               <tr style="border-bottom: 1px solid #eee;">
                                    <td class="py-3">
                                        @if($gallery->thumbnail)
                                            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="thumbnail" class="rounded-3 object-fit-cover" style="width: 150px; height: 80px;">
                                        @else
                                            <div class="bg-light rounded-3 d-flex justify-content-center align-items-center" style="width: 150px; height: 80px;">
                                                <span class="text-muted small">Tanpa Gambar</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 fw-semibold" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $gallery->title }}</td>
                                    <td class="py-3 text-muted">{{ $gallery->author ?? 'Tidak Diketahui' }}</td>
                                    <td class="py-3 text-muted">{{ $gallery->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-3">
                                        @php
                                            $statusColor = $gallery->status == 'draft' ? '#f4b704' : ($gallery->status == 'published' ? '#00617a' : '#6c757d');
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 text-white" style="background-color: {{ $statusColor }};">
                                            {{ ucfirst($gallery->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <form action="{{ route('admin.galleries.updateStatus', $gallery->slug) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn text-white rounded-pill btn-sm px-3 py-2" style="background-color: #00617a;" onclick="confirmPublish(event, this.parentElement)">
                                                <i class="fas fa-paper-plane me-1"></i> Publikasikan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PERBAIKAN: Tampilan Kartu untuk Mobile (Small screen and down) --}}
                <div class="d-block d-md-none p-3">
                    @foreach($draftGalleries as $gallery)
                        <div class="gallery-card-mobile">
                            @if($gallery->thumbnail)
                                <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="thumbnail" class="thumbnail">
                            @else
                                <div class="bg-light rounded-3 d-flex justify-content-center align-items-center thumbnail">
                                    <span class="text-muted small text-center">Tanpa Gambar</span>
                                </div>
                            @endif
                            
                            <div class="details">
                                <div>
                                    <p class="title">{{ $gallery->title }}</p>
                                    <div class="meta-info">
                                        <span>Oleh: {{ $gallery->author ?? 'Tidak Diketahui' }}</span><br>
                                        <span>{{ $gallery->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @php
                                        $statusColor = $gallery->status == 'draft' ? '#f4b704' : ($gallery->status == 'published' ? '#00617a' : '#6c757d');
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2 text-white" style="background-color: {{ $statusColor }}; font-size: 0.75rem;">
                                        {{ ucfirst($gallery->status) }}
                                    </span>
                                </div>
                                <div class="actions mt-3">
                                    <form action="{{ route('admin.galleries.updateStatus', $gallery->slug) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn text-white rounded-pill btn-sm w-100 py-2" style="background-color: #00617a;" onclick="confirmPublish(event, this.parentElement)">
                                            <i class="fas fa-paper-plane me-1"></i> Publikasikan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Custom Pagination --}}
    @if ($draftGalleries->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            <nav aria-label="Gallery pagination">
                <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($draftGalleries->onFirstPage())
                        <li class="page-item disabled"><span class="page-link rounded-3 border-0">&laquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link rounded-3 border-0" href="{{ $draftGalleries->previousPageUrl() }}" rel="prev" style="color: #00617a;">&laquo;</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php /* Kode pagination tidak diubah */ @endphp
                    @for ($i = $startPage; $i <= $endPage; $i++)
                        @if ($i == $currentPage)
                            <li class="page-item active"><span class="page-link rounded-3 border-0" style="background-color: #00617a; color: white;">{{ $i }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded-3 border-0" href="{{ $draftGalleries->url($i) }}" style="color: #00617a;">{{ $i }}</a></li>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($draftGalleries->hasMorePages())
                        <li class="page-item"><a class="page-link rounded-3 border-0" href="{{ $draftGalleries->nextPageUrl() }}" rel="next" style="color: #00617a;">&raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link rounded-3 border-0">&raquo;</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>

{{-- SweetAlert (Tidak ada perubahan) --}}
<script>
function confirmPublish(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Konfirmasi Publikasi Galeri',
        text: "Anda yakin ingin mempublikasikan galeri ini? Setelah publikasi, galeri akan terlihat oleh pengguna.",
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
Swal.fire({ icon: 'success', title: "{{ session('success') }}", showConfirmButton: false, timer: 2000, customClass: { popup: 'rounded-4' }});
@endif

@if(session('error'))
Swal.fire({ icon: 'error', title: "Terjadi Kesalahan!", text: "{{ session('error') }}", showConfirmButton: true, confirmButtonColor: '#cb2786', customClass: { confirmButton: 'rounded-pill px-4', popup: 'rounded-4' }});
@endif
</script>
@endsection