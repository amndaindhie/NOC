@extends('frontend.layout')

@php
    $hide_footer = true;
    $hide_navbar = true;
@endphp

@section('content')
    @if (Auth::user()->hasRole('admin'))
        @include('layouts.partials.sidebar')
    @else
        @include('layouts.partials.sidebar_profile')
    @endif

    <div class="main-content">
        <div class="container-fluid">

            {{-- Konten --}}
            @if (isset($tickets) && $tickets->count() > 0)
                <div class="card card-wrapper shadow-sm border-0">
                    {{-- Header di dalam card --}}
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-0">
                        <h4 class="fw-bold mb-0 d-flex align-items-center">
                            <i class="bx bx-history text-primary fs-4 me-2"></i>
                            Service History
                        </h4>
                        <a href="{{ route('noc.instalasi.form') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
                            <i class="bx bx-plus me-1"></i> Submit New Request
                        </a>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4">
                        <div class="row g-4">
                            @foreach ($tickets as $ticket)
                                <div class="col-md-6 col-lg-4">
                                    <div class="ticket-card shadow-sm border-0 h-100">
                                        {{-- Header --}}
                                        <div class="ticket-header d-flex justify-content-between align-items-center">
                                            <span class="ticket-number" data-ticket="{{ $ticket['nomor_tiket'] }}"
                                                title="Click to copy">
                                                🎫 {{ $ticket['nomor_tiket'] }}
                                            </span>
                                            <button class="btn btn-sm btn-light copy-btn rounded-circle shadow-sm"
                                                data-copy-target="ticket-{{ $loop->index }}" title="copy ticket number">
                                                <i class="bx bx-copy"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" id="ticket-{{ $loop->index }}"
                                            value="{{ $ticket['nomor_tiket'] }}">

                                        {{-- Body --}}
                                        <div class="ticket-body">
                                            <div class="mb-3">
                                                <span class="badge bg-soft-primary text-primary rounded-pill me-1">
                                                    {{ ucfirst($ticket['tipe']) }}
                                                </span>
                                                <span
                                                    class="badge rounded-pill
                                                    @if ($ticket['status'] == 'pending') bg-soft-warning text-warning
                                                    @elseif($ticket['status'] == 'approved') bg-soft-success text-success
                                                    @else bg-soft-secondary text-secondary @endif">
                                                    {{ ucfirst($ticket['status']) }}
                                                </span>
                                            </div>
                                            <ul class="list-unstyled small mb-0">
                                                <li class="mb-2 d-flex align-items-center">
                                                    <i class="bx bx-calendar text-secondary me-2"></i>
                                                    {{ isset($ticket['tanggal_permintaan'])
                                                        ? \Carbon\Carbon::parse($ticket['tanggal_permintaan'])->format('d M Y')
                                                        : 'N/A' }}
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="bx bx-building text-secondary me-2"></i>
                                                    {{ $ticket['nama_perusahaan'] ?? ($ticket['nama_tenant'] ?? 'N/A') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="card card-wrapper shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <div class="empty-icon mb-3">
                            <i class="bx bx-history display-1 text-muted"></i>
                        </div>
                        <h4 class="fw-bold text-dark">No service history available.</h4>
                        <p class="text-muted mb-4">You have not submitted any service requests.</p>
                        <a href="{{ route('noc.instalasi.form') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
                            <i class="bx bx-plus me-1"></i> Submit a New Request
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- CSS --}}
    <style>
        .main-content {
            margin-left: 78px;
            transition: all 0.5s ease;
            padding: 2rem 0;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            min-height: 100vh;
        }

        .sidebar.open~.main-content {
            margin-left: 250px;
        }

        /* Wrapper Card */
        .card-wrapper {
            border-radius: 20px;
            background: #fff;
            overflow: hidden;
        }

        /* Card Tiket */
        .ticket-card {
            border-radius: 16px;
            background: #fff;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .ticket-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
        }

        .ticket-header {
            background: #f9fafb;
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid #e9ecef;
        }

        .ticket-number {
            font-weight: 600;
            color: #1e4356;
            cursor: pointer;
        }

        .ticket-body {
            padding: 1.25rem 1.5rem;
        }

        .badge {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.45em 0.85em;
            border-radius: 50px;
        }

        /* Soft Badge */
        .bg-soft-primary {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-soft-success {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-soft-warning {
            background-color: rgba(255, 193, 7, 0.15);
        }

        .bg-soft-secondary {
            background-color: rgba(108, 117, 125, 0.1);
        }

        /* Gradient Button */
        .btn-gradient {
            background: linear-gradient(90deg, #1e4356, #1e4356);
            color: #fff !important;
            border: none;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #1e4356, #1e4356);
            color: #fff !important;
        }

        /* Empty state icon */
        .empty-icon {
            background: #f1f5f9;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 90px;
            height: 90px;
            border-radius: 50%;
        }

        .container-fluid {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    </style>
    {{-- JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy button
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-copy-target');
                    const input = document.getElementById(targetId);
                    if (input) {
                        navigator.clipboard.writeText(input.value.trim()).then(() => {
                            this.innerHTML = '<i class="bx bx-check text-success"></i>';
                            setTimeout(() => {
                                this.innerHTML = '<i class="bx bx-copy"></i>';
                            }, 2000);
                        });
                    }
                });
            });

            // Klik nomor tiket langsung salin
            document.querySelectorAll('.ticket-number').forEach(ticket => {
                ticket.addEventListener('click', function() {
                    navigator.clipboard.writeText(this.dataset.ticket).then(() => {
                        const originalText = this.textContent;
                        this.textContent = '✅ Disalin!';
                        this.style.color = '#198754';
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.style.color = '#0d6efd';
                        }, 1500);
                    });
                });
            });
        });
    </script>
@endsection
