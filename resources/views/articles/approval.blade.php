@extends('layouts.admin')

@section('content')
<style>
    /* Variabel Warna Utama */
    :root {
        --theme-primary: #00617a;
        --theme-accent: #f4b704;
        --theme-danger: #cb2786;
    }

    /* [BARU] Styling untuk Kartu Mobile di Halaman Approval */
    .mobile-approval-card {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .mobile-approval-card .card-thumbnail {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    .mobile-approval-card .card-thumbnail-placeholder {
        width: 100%;
        height: 160px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mobile-approval-card .card-body-content {
        padding: 1rem;
    }
    .mobile-approval-card .card-title {
        font-weight: 700;
        color: #212529;
        font-size: 1.05rem;
        margin-bottom: 0.5rem;
    }
    .mobile-approval-card .card-author {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    .mobile-approval-card .publish-button {
        background-color: var(--theme-primary);
        color: white;
        border: none;
        width: 100%;
        padding: 0.75rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .mobile-approval-card .publish-button:hover {
        background-color: #004a5c;
    }

    /* Badge Status */
    .badge-status-custom {
        border-radius: 0.5rem;
        font-weight: 600;
        padding: 0.4em 0.8em;
    }
</style>

<div class="container-fluid px-4" style="min-height: 100vh;">
    {{-- Header Halaman --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4" style="border-left: 8px solid var(--theme-primary);">
        <div class="d-flex align-items-center">
            <div class="d-flex justify-content-center align-items-center rounded-circle me-4" style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                <i class="fas fa-clipboard-check fs-2" style="color: var(--theme-primary);"></i>
            </div>
            <div>
                <h2 class="fs-3 fw-bold mb-1" style="color: var(--theme-primary);">Persetujuan Artikel</h2>
                <p class="text-muted mb-0">Tinjau dan publikasikan artikel yang dikirimkan.</p>
            </div>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-3 p-md-4">
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($draftArticles->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                    <p class="mb-0">Tidak ada artikel yang menunggu persetujuan.</p>
                </div>
            @else

            {{-- Tampilan Mobile (Card View) --}}
            <div class="d-block d-lg-none">
                @foreach($draftArticles as $article)
                    <div class="mobile-approval-card">
                        @if($article->thumbnail)
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="card-thumbnail">
                        @else
                            <div class="card-thumbnail-placeholder">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body-content">
                            {{-- [DIPERBAIKI] Logika status ditambahkan di sini --}}
                            @php
                                $statusText = ucfirst($article->status);
                                $statusBgColor = 'rgba(108, 117, 125, 0.15)'; // Default (abu-abu)
                                $statusTextColor = '#6c757d';

                                if ($article->status == 'draft') {
                                    $statusBgColor = 'rgba(244, 183, 4, 0.15)';
                                    $statusTextColor = '#b8860b';
                                } elseif ($article->status == 'published') {
                                    $statusBgColor = 'rgba(0, 97, 122, 0.15)';
                                    $statusTextColor = '#00617a';
                                }
                            @endphp
                            <span class="badge badge-status-custom mb-2" style="background-color: {{ $statusBgColor }}; color: {{ $statusTextColor }};">
                                {{ $statusText }}
                            </span>
                            <h3 class="card-title">{{ $article->title }}</h3>
                            <p class="card-author">oleh {{ $article->author ?? 'N/A' }} &bull; {{ $article->created_at->diffForHumans() }}</p>
                            <form action="{{ route('admin.articles.updateStatus', $article->slug) }}" method="POST" onsubmit="confirmPublish(event, this)">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="publish-button">
                                    <i class="fas fa-paper-plane me-2"></i>Publikasikan
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tampilan Desktop (Table View) --}}
            <div class="d-none d-lg-block table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th class="py-3">Thumbnail</th>
                            <th class="py-3">Judul Artikel</th>
                            <th class="py-3">Penulis</th>
                            <th class="py-3">Dibuat Pada</th>
                            <th class="py-3">Status</th> {{-- [DIPERBAIKI] Kolom Status Dikembalikan --}}
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($draftArticles as $article)
                           <tr style="border-bottom: 1px solid #eee;">
                                <td class="py-3">
                                    @if($article->thumbnail)
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="thumbnail" class="rounded-3 object-fit-cover" style="width: 150px; height: 80px;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex justify-content-center align-items-center" style="width: 150px; height: 80px;">
                                            <span class="text-muted small">Tanpa Gambar</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 fw-semibold" style="max-width: 300px;">{{ $article->title }}</td>
                                <td class="py-3 text-muted">{{ $article->author ?? 'Tidak Diketahui' }}</td>
                                <td class="py-3 text-muted">{{ $article->created_at->format('d M Y, H:i') }}</td>
                                {{-- [DIPERBAIKI] Logika Status Dikembalikan ke Tabel --}}
                                <td class="py-3">
                                     @php
                                        $statusColor = '';
                                        switch ($article->status) {
                                            case 'draft': $statusColor = '#f4b704'; break;
                                            case 'published': $statusColor = '#00617a'; break;
                                            default: $statusColor = '#6c757d'; break;
                                        }
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2 text-white" style="background-color: {{ $statusColor }};">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <form action="{{ route('admin.articles.updateStatus', $article->slug) }}" method="POST" onsubmit="confirmPublish(event, this)">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn text-white rounded-pill btn-sm px-3 py-2" style="background-color: var(--theme-primary);">
                                            <i class="fas fa-paper-plane me-1"></i> Publikasikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            @if ($draftArticles->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $draftArticles->links() }}
                </div>
            @endif

            @endif
        </div>
    </div>
</div>

<script>
function confirmPublish(event, form) {
    event.preventDefault();
    Swal.fire({
        title: 'Anda yakin?',
        text: "Artikel ini akan dipublikasikan dan dapat dilihat oleh semua orang.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00617a',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Publikasikan!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-4',
            confirmButton: 'rounded-pill px-4',
            cancelButton: 'rounded-pill px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection