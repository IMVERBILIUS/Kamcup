@extends('layouts.admin')

@section('content')
<style>
    /* Variabel Warna Utama */
    :root {
        --theme-primary: #00617a;
        --theme-accent: #f4b704;
        --theme-danger: #cb2786;
    }

    /* Dropdown Filter */
    .custom-select-dropdown {
        background-color: #f5f5f5;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    /* Styling untuk Tampilan Kartu Mobile */
    .mobile-gallery-card {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .mobile-gallery-card .card-thumbnail {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    .mobile-gallery-card .card-thumbnail-placeholder {
        width: 100%;
        height: 160px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mobile-gallery-card .card-body-content {
        padding: 1rem;
    }
    .mobile-gallery-card .card-title {
        font-weight: 700;
        color: #212529;
        font-size: 1.05rem;
        margin-bottom: 0.75rem;
    }
    .mobile-gallery-card .meta-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .mobile-gallery-card .action-buttons {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }
    .mobile-gallery-card .action-buttons .btn {
        background-color: #fff;
        border-width: 1.5px;
        border-style: solid;
        padding: 0.5rem;
        font-size: 1rem;
        border-radius: 0.75rem;
    }
    .mobile-gallery-card .btn-view-custom { border-color: var(--theme-primary); color: var(--theme-primary); }
    .mobile-gallery-card .btn-edit-custom { border-color: var(--theme-accent); color: var(--theme-accent); }
    .mobile-gallery-card .btn-delete-custom { border-color: var(--theme-danger); color: var(--theme-danger); }
</style>

<div class="container-fluid px-3 px-md-4" style="min-height: 100vh;">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;">
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4" style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                        <i class="fas fa-camera-retro fs-2" style="color: #00617a;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Manajemen Dokumentasi Turnamen</h2>
                        <p class="text-muted mb-0">Kelola video dan gambar turnamen untuk komunitas Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('admin.galleries.create') }}" class="btn text-white d-flex align-items-center px-4 py-2 rounded-pill" style="background-color: #f4b704; border: none; font-weight: 600;">
                <i class="fas fa-plus me-2"></i>
                <span class="fw-small">Tambah Dokumentasi Baru</span>
            </a>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-3 p-md-4">
            @if(session('success'))
                <div class="alert rounded-3 text-white m-0" style="background-color: #00617a; border: none;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- [PERBAIKAN] Filter dibuat responsif --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-3">
                <h1 class="fs-5 fw-semibold mb-3 mb-md-0" style="color: #00617a;">Semua Dokumentasi</h1>
                <form method="GET" class="d-flex align-items-center gap-2 w-100 w-md-auto">
                    {{-- Teks "Urutkan" disembunyikan di mobile --}}
                    <span class="text-muted fw-semibold d-none d-md-inline">Urutkan:</span>
                    <select name="sort" class="form-select form-select-sm custom-select-dropdown border-0 flex-grow-1" onchange="this.form.submit()" style="cursor: pointer;">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="view" {{ request('sort') == 'view' ? 'selected' : '' }}>Jumlah Dilihat</option>
                    </select>
                </form>
            </div>


            {{-- Tampilan Mobile (Card View) --}}
            <div class="d-block d-lg-none">
                @forelse($galleries as $gallery)
                    <div class="mobile-gallery-card">
                        @if($gallery->thumbnail)
                            <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="thumbnail" class="card-thumbnail">
                        @else
                            <div class="card-thumbnail-placeholder">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body-content">
                            <h3 class="card-title">{{ $gallery->tournament_name ?? '-' }}</h3>
                            <div class="meta-info">
                                @php
                                    $statusBgColor = '#f4b704';
                                    $statusTextColor = '#212529';
                                    if ($gallery->status == 'Published') {
                                        $statusBgColor = '#00617a';
                                        $statusTextColor = 'white';
                                    }
                                @endphp
                                <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusBgColor }}; color: {{ $statusTextColor }};">
                                    {{ $gallery->status }}
                                </span>
                                <span class="text-muted small"><i class="fas fa-eye me-1"></i>{{ $gallery->views }}</span>
                            </div>
                            <div class="action-buttons">
                                <a href="{{ route('admin.galleries.show', $gallery->slug) }}" class="btn btn-view-custom" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.galleries.edit', $gallery->slug) }}" class="btn btn-edit-custom" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.galleries.destroy', $gallery->slug) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete-custom w-100" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-camera-retro fa-3x mb-3"></i>
                        <p>Belum ada dokumentasi ditemukan.</p>
                    </div>
                @endforelse
            </div>


            {{-- Tampilan Desktop (Table View) --}}
            <div class="d-none d-lg-block table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="py-3">Thumbnail</th>
                            <th class="py-3">Nama Turnamen</th>
                            <th class="py-3">Tautan Video</th>
                            <th class="py-3">Penulis</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Dilihat</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $gallery)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td class="py-3">
                                    @if($gallery->thumbnail)
                                        <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="thumbnail" class="rounded-3 object-fit-cover" style="width: 200px; height: 100px;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex justify-content-center align-items-center" style="width: 200px; height: 100px;">
                                            <span class="text-muted small">Tanpa Gambar</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 fw-semibold">{{ $gallery->tournament_name ?? '-' }}</td>
                                <td class="py-3">
                                    @if($gallery->video_link)
                                        <a href="{{ $gallery->video_link }}" target="_blank" class="text-decoration-none fw-medium" style="color: #00617a;">
                                            Lihat Video <i class="fas fa-external-link-alt ms-1"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">Tanpa Video</span>
                                    @endif
                                </td>
                                <td class="py-3 text-muted">{{ $gallery->author ?? '-' }}</td>
                                <td class="py-3">
                                    @php
                                        $statusBgColor = ($gallery->status == 'Published') ? '#00617a' : '#f4b704';
                                        $statusTextColor = ($gallery->status == 'Published') ? 'white' : '#212529';
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusBgColor }}; color: {{ $statusTextColor }};">
                                        {{ $gallery->status }}
                                    </span>
                                </td>
                                <td class="py-3 fw-semibold">{{ $gallery->views }}</td>
                                <td class="py-3">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.galleries.show', $gallery->slug) }}" class="btn btn-sm px-2 py-1 rounded-pill" style="background-color: #00617a; color: white;" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.galleries.edit', $gallery->slug) }}" class="btn btn-sm px-2 py-1 rounded-pill" style="background-color: #f4b704; color: #212529;" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.galleries.destroy', $gallery->slug) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event, this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm px-2 py-1 rounded-pill" style="background-color: #cb2786; color: white;" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada dokumentasi ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            {{-- Paginasi --}}
            @if($galleries->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function confirmDelete(event, form) {
    event.preventDefault();
    Swal.fire({
        title: "Konfirmasi Hapus?",
        text: "Anda yakin ingin menghapus dokumentasi ini? Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#cb2786",
        cancelButtonColor: "#00617a",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batalkan"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection