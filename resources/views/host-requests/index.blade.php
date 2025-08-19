@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Host Requests Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #0F62FF;">
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                        style="width: 70px; height: 70px; background-color: rgba(15, 98, 255, 0.1);">
                        <i class="fas fa-medal fs-2" style="color: #0F62FF;"></i>
                    </div>
                    <div>
                        <h2 class="fs-3 fw-bold mb-1" style="color: #0F62FF;">Permintaan Host Turnamen</h2>
                        <p class="text-muted mb-0">Kelola dan tinjau permintaan host dari komunitas aktif kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sorting & Filtering Form --}}
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" class="d-flex align-items-center gap-3 bg-white p-3 rounded-4 shadow-sm">
                <span class="text-muted fw-semibold">Urutkan:</span>
                <select name="sort" class="form-select form-select-sm border-0 bg-light rounded-pill px-3 py-2"
                    onchange="this.form.submit()" style="width: auto; cursor: pointer;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
                <span class="text-muted fw-semibold ms-auto">Status:</span>
                <select name="status" class="form-select form-select-sm border-0 bg-light rounded-pill px-3 py-2"
                    onchange="this.form.submit()" style="width: auto; cursor: pointer;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            @if (session('success'))
                <div class="alert alert-success m-3 mb-0 border-0 rounded-3"
                    style="background-color: #e6f7f1; color: #36b37e;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($hostRequests->isEmpty())
                <div class="alert alert-info m-3 border-0 rounded-3" style="background-color: #eaf6fe; color: #337ab7;">
                    <i class="fas fa-info-circle me-2"></i>Tidak ada permintaan host yang perlu ditinjau saat ini.
                </div>
            @else
                <div class="table-responsive p-4">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th class="py-3" style="color: #6c757d;">Penanggung Jawab</th>
                                <th class="py-3" style="color: #6c757d;">Email Kontak</th>
                                <th class="py-3" style="color: #6c757d;">Telepon</th>
                                <th class="py-3" style="color: #6c757d;">Judul Turnamen</th>
                                <th class="py-3" style="color: #6c757d;">Tanggal Diajukan</th>
                                <th class="py-3" style="color: #6c757d;">Status</th>
                                <th class="py-3" style="color: #6c757d;">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hostRequests as $request)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td class="py-3 fw-semibold">{{ $request->responsible_name }}</td>
                                    <td class="py-3">{{ $request->email }}</td>
                                    <td class="py-3">{{ $request->phone }}</td>
                                    <td class="py-3">{{ Str::limit($request->tournament_title, 30) }}</td>
                                    <td class="py-3 text-muted">{{ $request->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-3">
                                        @php
                                            $statusColor = '';
                                            $statusLabel = '';

                                            switch ($request->status) {
                                                case 'pending':
                                                    $statusColor = '#f4b704';
                                                    $statusLabel = 'Pending';
                                                    break;
                                                case 'approved':
                                                    $statusColor = '#00617a';
                                                    $statusLabel = 'Success';
                                                    break;
                                                case 'rejected':
                                                    $statusColor = '#cb2786';
                                                    $statusLabel = 'Canceled';
                                                    break;
                                                default:
                                                    $statusColor = '#6c757d';
                                                    $statusLabel = ucfirst($request->status);
                                                    break;
                                            }
                                        @endphp

                                        <span class="badge rounded-pill px-3 py-2 text-white"
                                            style="background-color: {{ $statusColor }};">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.host-requests.show', $request->id) }}"
                                                class="btn btn-sm text-white rounded-pill"
                                                style="background-color: #00617a; border-color: #00617a;"
                                                title="Lihat Detail">
                                                <i class="fas fa-info-circle me-1"></i>
                                            </a>
                                            @if ($request->status == 'pending')
                                                <form
                                                    action="{{ route('admin.host-requests.approve', $request->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm text-white rounded-pill"
                                                        style="background-color: #f4b704; border-color: #f4b704;"
                                                        onclick="confirmAction(event, this.parentElement, 'approve')"
                                                        title="Setujui">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm text-white rounded-pill"
                                                    style="background-color: #cb2786; border-color: #cb2786;"
                                                    onclick="showRejectModal({{ $request->id }})"
                                                    title="Tolak">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                </button>
                                            @endif
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

    {{-- Pagination --}}
    @if ($hostRequests->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $hostRequests->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-times-circle me-2"></i>Tolak Permintaan Host
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-muted mb-3">Harap berikan alasan penolakan untuk permintaan host ini.</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Alasan Penolakan:</label>
                        <textarea class="form-control" 
                                  id="rejection_reason" 
                                  name="rejection_reason" 
                                  rows="4" 
                                  required 
                                  placeholder="Contoh: Venue tidak memenuhi standar, tanggal tidak tersedia, dokumentasi tidak lengkap, dll."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-times me-2"></i>Tolak Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        function confirmAction(event, form, actionType) {
            event.preventDefault();
            let title = '';
            let text = '';
            let icon = '';
            let confirmButtonText = '';
            let confirmButtonColor = '';

            if (actionType === 'approve') {
                title = 'Konfirmasi Persetujuan';
                text = "Anda yakin ingin menyetujui permintaan host ini?";
                icon = 'question';
                confirmButtonText = 'Ya, Setujui!';
                confirmButtonColor = '#00617a';
            }

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
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

        function showRejectModal(requestId) {
            const form = document.getElementById('rejectForm');
            form.action = `/admin/host-requests/${requestId}/reject`;
            const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
            rejectModal.show();
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

        @if (session('error'))
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
@endpush