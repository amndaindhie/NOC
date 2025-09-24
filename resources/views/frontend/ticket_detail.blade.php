@extends('frontend.layout')

@php
$hide_footer = true;
$hide_navbar = true;
@endphp

@section('content')
@include('layouts.partials.sidebar_profile')

<div class="main-content">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-white border-0">
            <h2 class="card-title mb-0">📋 Service Ticket Details</h2>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('service.history') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to History
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(isset($ticket) && !empty($ticket))
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h4 class="card-title mb-1">{{ $ticket['nomor_tiket'] ?? '-' }}</h4>
                                        <span class="badge bg-primary">{{ ucfirst($ticket['tipe'] ?? '-') }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge
                                            @if(($ticket['status'] ?? '') == 'Diterima') bg-success
                                            @elseif(($ticket['status'] ?? '') == 'Diproses') bg-warning text-dark
                                            @elseif(($ticket['status'] ?? '') == 'Selesai') bg-info
                                            @elseif(($ticket['status'] ?? '') == 'Ditolak') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($ticket['status'] ?? '-') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted d-block">Request Date</small>
                                        <p class="mb-2">{{ $ticket['tanggal_permintaan'] ?? '-' }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted d-block">Company/Tenant Name</small>
                                        <p class="mb-2">{{ $ticket['nama_perusahaan'] ?? $ticket['nama_tenant'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        @if(isset($timeline) && !empty($timeline))
                            <div class="card border-0">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0"><i class="bx bx-time me-2"></i>Timeline Progress</h6>
                                </div>
                                <div class="card-body">
                                    @foreach($timeline as $item)
                                        <div class="mb-3 p-3 bg-light rounded">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $item['status'] }}</h6>
                                                    <p class="mb-1 text-muted">{{ $item['keterangan'] ?? 'Status diperbarui' }}</p>
                                                    <small class="text-muted">{{ $item['waktu'] }}</small>
                                                </div>
                                                @if(isset($item['oleh']) && $item['oleh'] != 'Sistem')
                                                    <small class="text-primary">Oleh: {{ $item['oleh'] }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Information Details</h6>
                            </div>
                            <div class="card-body">
                                @if(isset($ticket['data']) && !empty($ticket['data']))
                                    @if($ticket['tipe'] == 'instalasi')
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Installation Location</small>
                                            <p class="mb-1">{{ $ticket['data']['lokasi_instalasi'] ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Type of Service</small>
                                            <p class="mb-1">{{ $ticket['data']['jenis_layanan'] ?? '-' }}</p>
                                        </div>
                                    @elseif($ticket['tipe'] == 'maintenance')
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Types of Problem</small>
                                            <p class="mb-1">{{ $ticket['data']['jenis_gangguan'] ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Urgency</small>
                                            <p class="mb-1">{{ $ticket['data']['urgensi'] ?? '-' }}</p>
                                        </div>
                                    @elseif($ticket['tipe'] == 'keluhan')
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Type of Complaint</small>
                                            <p class="mb-1">{{ $ticket['data']['jenis_keluhan'] ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Urgency Level</small>
                                            <p class="mb-1">
                                                <span class="badge
                                                    @if(($ticket['data']['tingkat_urgensi'] ?? '') == 'Low') bg-success
                                                    @elseif(($ticket['data']['tingkat_urgensi'] ?? '') == 'Medium') bg-warning text-dark
                                                    @elseif(($ticket['data']['tingkat_urgensi'] ?? '') == 'High') bg-orange
                                                    @elseif(($ticket['data']['tingkat_urgensi'] ?? '') == 'Critical') bg-danger
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ $ticket['data']['tingkat_urgensi'] ?? '-' }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">description</small>
                                            <p class="mb-1">{{ $ticket['data']['deskripsi_keluhan'] ?? '-' }}</p>
                                        </div>
                                    @elseif($ticket['tipe'] == 'terminasi')
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Reason for Termination</small>
                                            <p class="mb-1">{{ $ticket['data']['alasan_terminasi'] ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Termination Date</small>
                                            <p class="mb-1">{{ $ticket['data']['tanggal_terminasi'] ?? '-' }}</p>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-muted">Additional details not available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bx bx-error display-1 text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Ticket Details Not Found</h4>
                    <p class="text-muted mb-4">There is no detailed information for this ticket.</p>
                    <a href="{{ route('service.history') }}" class="btn btn-primary">
                        <i class="bx bx-arrow-back me-1"></i> Back to History
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.main-content {
    margin-left: 78px;
    transition: all 0.5s ease;
    padding: 2rem;
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* saat sidebar terbuka */
.sidebar.open ~ .main-content {
    margin-left: 250px;
}

.card {
    border-radius: 12px;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #11101D;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.display-1 {
    font-size: 4rem;
}

.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endsection
