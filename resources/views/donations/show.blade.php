@extends('layouts.admin')

@section('title', 'Detail Sponsor/Donasi')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4 text-gray-800">Detail Sponsor/Donasi</h1>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Sponsor/Donasi</h6>
                        <a href="{{ route('admin.donations.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nama Brand:</dt>
                            <dd class="col-sm-8">{{ $donation->name_brand }}</dd>

                            <dt class="col-sm-4">Email Kontak:</dt>
                            <dd class="col-sm-8">{{ $donation->email }}</dd>

                            <dt class="col-sm-4">Telepon Kontak:</dt>
                            <dd class="col-sm-8">{{ $donation->phone_whatsapp }}</dd>

                            <dt class="col-sm-4">Judul Turnamen:</dt>
                            <dd class="col-sm-8">{{ $donation->event_name }}</dd>

                            <dt class="col-sm-4">Donasi/Sponsor:</dt>
                            <dd class="col-sm-8">{{ $donation->donation_type }}</dd>

                            <dt class="col-sm-4">Tipe Sponsor:</dt>
                            <dd class="col-sm-8">{{ $donation->sponsor_type ?? '-' }}</dd>

                            <dt class="col-sm-4">Status Saat Ini:</dt>
                            <dd class="col-sm-8">
                                @php
                                    $color = match ($donation->status) {
                                        'pending' => '#f4b704',
                                        'approved' => '#00617a',
                                        'rejected' => '#cb2786',
                                        default => '#6c757d',
                                    };
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 text-white"
                                    style="background-color: {{ $color }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </dd>

                            @if ($donation->admin_notes)
                                <dt class="col-sm-4 text-danger">Alasan Penolakan:</dt>
                                <dd class="col-sm-8 text-danger">{{ $donation->admin_notes }}</dd>
                            @endif

                            <dt class="col-sm-4">Diajukan Pada:</dt>
                            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($donation->created_at)->format('d F Y H:i:s') }}
                            </dd>

                            <dt class="col-sm-4">Terakhir Diperbarui:</dt>
                            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($donation->updated_at)->format('d F Y H:i:s') }}
                            </dd>

                            <dt class="col-sm-4">Kesan/Pesan:</dt>
                            <dd class="col-sm-8">{{ $donation->message }}</dd>

                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aksi Admin</h6>
                    </div>
                    <div class="card-body">
                        @if ($donation->status == 'pending')
                            <form action="{{ route('admin.donations.updateStatus', $donation->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-sm text-white rounded-pill"
                                    style="background-color: #00617a; border-color: #00617a;"
                                    onclick="confirmAction(event, this.parentElement, 'approve')">
                                    <i class="fas fa-check-circle me-1"></i> Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.donations.updateStatus', $donation->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-sm text-white rounded-pill"
                                    style="background-color: #cb2786; border-color: #cb2786;"
                                    onclick="confirmAction(event, this.parentElement, 'reject')">
                                    <i class="fas fa-times-circle me-1"></i> Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                text = "Anda yakin bahwa donasi/sponsor sudah sukses di terima?";
                icon = 'question';
                confirmButtonText = 'Ya, Setujui!';
                confirmButtonColor = '#00617a';
            } else if (actionType === 'reject') {
                title = 'Konfirmasi Penolakan';
                text = "Anda yakin ingin membatalkan Donasi/Sponsor ini?";
                icon = 'warning';
                confirmButtonText = 'Ya, Cancel!';
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
