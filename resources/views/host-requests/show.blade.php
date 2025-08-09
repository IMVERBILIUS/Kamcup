@extends('layouts.admin')

@section('title', 'Detail Permohonan Tuan Rumah')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Detail Permohonan Tuan Rumah</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Permohonan</h6>
                    <a href="{{ route('admin.host-requests.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID Permohonan:</dt>
                        <dd class="col-sm-8">{{ $request->id }}</dd>

                        <dt class="col-sm-4">Diajukan Oleh:</dt>
                        <dd class="col-sm-8">{{ $request->user->name ?? 'User Tidak Dikenal' }} ({{ $request->user->email ?? '-' }})</dd>

                        <dt class="col-sm-4">Nama Penanggung Jawab:</dt>
                        <dd class="col-sm-8">{{ $request->responsible_name }}</dd>

                        <dt class="col-sm-4">Email Kontak:</dt>
                        <dd class="col-sm-8">{{ $request->email }}</dd>

                        <dt class="col-sm-4">Telepon Kontak:</dt>
                        <dd class="col-sm-8">{{ $request->phone }}</dd>

                        <dt class="col-sm-4">Judul Turnamen:</dt>
                        <dd class="col-sm-8">{{ $request->tournament_title }}</dd>

                        <dt class="col-sm-4">Nama Lokasi/Venue:</dt>
                        <dd class="col-sm-8">{{ $request->venue_name }}</dd>

                        <dt class="col-sm-4">Alamat Lokasi:</dt>
                        <dd class="col-sm-8">{{ $request->venue_address }}</dd>

                        <dt class="col-sm-4">Kapasitas Estimasi:</dt>
                        <dd class="col-sm-8">{{ $request->estimated_capacity ?? '-' }} orang</dd>

                        <dt class="col-sm-4">Tanggal Diusulkan:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($request->proposed_date)->format('d F Y') }}</dd>

                        <dt class="col-sm-4">Fasilitas Tersedia:</dt>
                        <dd class="col-sm-8">{{ $request->available_facilities ?? '-' }}</dd>

                        <dt class="col-sm-4">Catatan Tambahan:</dt>
                        <dd class="col-sm-8">{{ $request->notes ?? '-' }}</dd>

                        <dt class="col-sm-4">Status Saat Ini:</dt>
                        <dd class="col-sm-8">
                            @php
                                $badgeClass = '';
                                switch($request->status) {
                                    case 'pending': $badgeClass = 'badge-info'; break;
                                    case 'approved': $badgeClass = 'badge-success'; break;
                                    case 'rejected': $badgeClass = 'badge-danger'; break;
                                    default: $badgeClass = 'badge-secondary'; break;
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($request->status) }}</span>
                        </dd>

                        @if($request->rejection_reason)
                        <dt class="col-sm-4 text-danger">Alasan Penolakan:</dt>
                        <dd class="col-sm-8 text-danger">{{ $request->rejection_reason }}</dd>
                        @endif

                        <dt class="col-sm-4">Diajukan Pada:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($request->created_at)->format('d F Y H:i:s') }}</dd>

                        <dt class="col-sm-4">Terakhir Diperbarui:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($request->updated_at)->format('d F Y H:i:s') }}</dd>
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
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($request->status === 'pending')
                        <form action="{{ route('admin.host-requests.approve', $request->id) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-block">Setujui Permohonan</button>
                        </form>

                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">Tolak Permohonan</button>
                    @else
                        <div class="alert alert-warning" role="alert">
                            Permohonan ini sudah **{{ ucfirst($request->status) }}**. Tidak ada aksi lebih lanjut.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Permohonan Tuan Rumah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.host-requests.reject', $request->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Alasan Penolakan:</label>
                        <textarea class="form-control @error('rejection_reason') is-invalid @enderror" id="rejection_reason" name="rejection_reason" rows="5" required minlength="10">{{ old('rejection_reason') }}</textarea>
                        @error('rejection_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SweetAlert2 for handling validation errors from modal submission --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // This script ensures the reject modal reappears if there are validation errors
    // from the rejection_reason field after submission.
    @if($errors->has('rejection_reason'))
        $(document).ready(function() {
            $('#rejectModal').modal('show');
        });
    @endif

    // Basic script for Bootstrap 4/5 modal close button fix if needed
    // (If data-dismiss="modal" doesn't work out of the box with Bootstrap 5,
    // you might need to use Bootstrap's JS directly, but usually it's fine)
    // For Bootstrap 5, 'data-bs-dismiss' is preferred over 'data-dismiss'
    // Ensure you load Bootstrap's JS bundle (bootstrap.bundle.min.js) in your admin_master.blade.php
</script>
@endpush
