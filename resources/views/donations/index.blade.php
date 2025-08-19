@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-white rounded-4 shadow-sm p-4" style="border-left: 8px solid #00617a;">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-center align-items-center rounded-circle me-4"
                            style="width: 70px; height: 70px; background-color: rgba(0, 97, 122, 0.1);">
                            <i class="fas fa-donate fs-2" style="color: #00617a;"></i>
                        </div>
                        <div>
                            <h2 class="fs-3 fw-bold mb-1" style="color: #00617a;">Sponsor dan Donasi</h2>
                            <p class="text-muted mb-0">Kelola dan tinjau Sponsor / Donasi.</p>
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
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Success</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Canceled</option>
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

                @if ($donations->isEmpty())
                    <div class="alert alert-info m-3 border-0 rounded-3" style="background-color: #eaf6fe; color: #337ab7;">
                        <i class="fas fa-info-circle me-2"></i>Tidak ada permintaan host yang perlu ditinjau saat ini.
                    </div>
                @else
                    <div class="table-responsive p-4">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th class="py-3" style="color: #6c757d;">Nama Brand</th>
                                    {{-- <th class="py-3" style="color: #6c757d;">Email Kontak</th> --}}
                                    {{-- <th class="py-3" style="color: #6c757d;">Telepon</th> --}}
                                    <th class="py-3" style="color: #6c757d;" title="Sponsor/Donasi">Kategori</th>
                                    <th class="py-3" style="color: #6c757d;">Tipe sponsor</th>
                                    <th class="py-3" style="color: #6c757d;">Judul Turnamen</th>
                                    <th class="py-3" style="color: #6c757d;">Tanggal Diajukan</th>
                                    <th class="py-3" style="color: #6c757d;">Status</th>
                                    <th class="py-3" style="color: #6c757d;">Aksi Cepat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations as $request)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td class="py-3 fw-semibold">{{ $request->name_brand }}</td>
                                        {{-- <td class="py-3">{{ $request->email }}</td> --}}
                                        {{-- <td class="py-3">{{ $request->phone_whatsapp }}</td> --}}
                                        <td class="py-3">{{ $request->donation_type }}</td>
                                        <td class="py-3">{{ $request->sponsor_type ?? '-' }}</td>
                                        <td class="py-3">{{ $request->event_name }}</td>
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
                                                <a href="{{ route('admin.donations.show', $request->id) }}"
                                                    class="btn btn-sm text-white rounded-pill"
                                                    style="background-color: #00617a; border-color: #00617a;"
                                                    title="Lihat Detail">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                </a>
                                                @if ($request->status == 'pending')
                                                    <form
                                                        action="{{ route('admin.donations.updateStatus', $request->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-sm text-white rounded-pill"
                                                            style="background-color: #f4b704; border-color: #f4b704;"
                                                            onclick="confirmAction(event, this.parentElement, 'approve')"
                                                            title="Success">
                                                            <i class="fas fa-check-circle me-1"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.donations.updateStatus', $request->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn btn-sm text-white rounded-pill"
                                                            style="background-color: #cb2786; border-color: #cb2786;"
                                                            onclick="confirmAction(event, this.parentElement, 'reject')"
                                                            title="Cancel">
                                                            <i class="fas fa-times-circle me-1"></i>
                                                        </button>
                                                    </form>
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
        @if ($donations->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $donations->links('pagination::bootstrap-5') }}
            </div>
        @endif
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
                text = "Anda yakin bahwa donasi/sponsor sudah sukses?";
                icon = 'question';
                confirmButtonText = 'Ya, Setujui!';
                confirmButtonColor = '#00617a';
            } else if (actionType === 'reject') {
                title = 'Konfirmasi Penolakan';
                text = "Anda yakin ingin membatalkan donasi/sponsor ini?";
                icon = 'warning';
                confirmButtonText = 'Ya, Batalkan!';
                confirmButtonColor = '#cb2786';
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
