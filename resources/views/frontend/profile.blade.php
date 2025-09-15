@extends('frontend.layout')

@php
$hide_footer = true;
$hide_navbar = true;
@endphp

@section('content')
@if(Auth::user()->hasRole('admin'))
    @include('layouts.partials.sidebar')
@else
    @include('layouts.partials.sidebar_profile')
@endif



<div class="main-content">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-white border-0">
            <h2 class="card-title mb-0">⚙️ Settings</h2>
            <div class="mt-2 mt-sm-0">
                <input type="search" class="form-control" placeholder="Search..." />
            </div>
        </div>
        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                        <i class="bx bx-user me-1"></i> Profile
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                        <i class="bx bx-lock-alt me-1"></i> Password
                    </button>
                </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">
                    <i class="bx bx-home me-1"></i> Home
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="service-history-tab" data-bs-toggle="tab" data-bs-target="#service-history" type="button" role="tab" aria-controls="service-history" aria-selected="false">
                    <i class="bx bx-history me-1"></i> Riwayat Pelayanan
                </button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content" id="profileTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="form-container">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>
            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                <div class="form-container">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="tab-pane fade" id="service-history" role="tabpanel" aria-labelledby="service-history-tab">
                @if(isset($tickets) && $tickets->count() > 0)
                    <div class="service-history-list container mt-4">
                        <div class="row">
                            @foreach($tickets as $ticket)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0 d-flex align-items-center">
                                                    <span class="ticket-number flex-grow-1" data-ticket="{{ $ticket['nomor_tiket'] }}" style="cursor: pointer; color: #007bff;" title="Klik untuk menyalin">{{ $ticket['nomor_tiket'] }}</span>
                                                    <button class="btn btn-sm btn-outline-secondary copy-btn ms-2" data-copy-target="ticket-{{ $loop->index }}" title="Salin nomor tiket">
                                                        <i class="bx bx-copy"></i>
                                                    </button>
                                                </h6>
                                            </div>
                                            <input type="hidden" id="ticket-{{ $loop->index }}" value="{{ $ticket['nomor_tiket'] }}">

                                            <div class="mb-2">
                                                <span class="badge bg-primary">{{ ucfirst($ticket['tipe']) }}</span>
                                                <span class="badge bg-{{ $ticket['status'] == 'pending' ? 'warning' : ($ticket['status'] == 'approved' ? 'success' : 'secondary') }}">
                                                    {{ ucfirst($ticket['status']) }}
                                                </span>
                                            </div>

                                            <div class="small text-muted mb-2">
                                                <i class="bx bx-calendar me-1"></i>
                                                {{ isset($ticket['tanggal_permintaan']) ? \Carbon\Carbon::parse($ticket['tanggal_permintaan'])->format('d/m/Y') : 'N/A' }}
                                            </div>

                                            <div class="small text-muted">
                                                <i class="bx bx-building me-1"></i>
                                                {{ $ticket['nama_perusahaan'] ?? $ticket['nama_tenant'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bx bx-history display-1 text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum ada riwayat pelayanan</h4>
                        <p class="text-muted mb-4">Anda belum mengajukan permintaan layanan apapun.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Ajukan Permintaan Baru
                        </a>
                    </div>
                @endif

                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const copyButtons = document.querySelectorAll('.copy-btn');
                    copyButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const targetId = this.getAttribute('data-copy-target');
                            const input = document.getElementById(targetId);
                            if (input) {
                                const textToCopy = input.value.trim();
                                navigator.clipboard.writeText(textToCopy).then(() => {
                                    this.innerHTML = '<i class="bx bx-check"></i> Berhasil disalin';
                                    setTimeout(() => {
                                        this.innerHTML = '<i class="bx bx-copy"></i>';
                                    }, 2000);
                                }).catch(() => {
                                    alert('Gagal menyalin teks.');
                                });
                            }
                        });
                    });

                    // Handle ticket number click to copy
                    const ticketNumbers = document.querySelectorAll('.ticket-number');
                    ticketNumbers.forEach(ticket => {
                        ticket.addEventListener('click', function () {
                            const ticketText = this.getAttribute('data-ticket');
                            navigator.clipboard.writeText(ticketText).then(() => {
                                // Show success feedback
                                const originalText = this.textContent;
                                this.textContent = 'Disalin!';
                                this.style.color = '#28a745';
                                setTimeout(() => {
                                    this.textContent = originalText;
                                    this.style.color = '#007bff';
                                }, 2000);
                            }).catch(() => {
                                alert('Gagal menyalin nomor tiket.');
                            });
                        });
                    });
                });
                </script>
            </div>

            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="text-center">
                    <p class="text-muted mb-3">Kembali ke halaman utama</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bx bx-home me-2"></i>Go to Home
                    </a>
                </div>
            </div>
        </div>
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

/* Tabs style */
.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}
.nav-tabs .nav-link:hover {
    color: #11101D;
    background-color: #f1f1f1;
    border-radius: 6px;
}
.nav-tabs .nav-link.active {
    color: #11101D;
    font-weight: 600;
    border-bottom: 3px solid #11101D;
    background: none;
    border-radius: 0;
}

/* Card title */
.card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #11101D;
}

/* ===== Form Styling ===== */
.form-container {
    max-width: 700px;
}

.form-container form {
    background: #fff;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.form-container label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
    color: #11101D;
}

.form-container .form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.6rem 0.75rem;
    transition: all 0.2s ease;
}

.form-container .form-control:focus {
    border-color: #11101D;
    box-shadow: 0 0 0 0.2rem rgba(17,16,29,0.1);
}

.form-container .form-text {
    font-size: 0.85rem;
    color: #6c757d;
}

.form-container button[type="submit"],
.form-container .btn-primary {
    background-color: #11101D;
    border: none;
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.form-container button[type="submit"]:hover,
.form-container .btn-primary:hover {
    background-color: #343a40;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');

    if (activeTab) {
        // Remove active class from all tabs
        const tabs = document.querySelectorAll('#profileTab .nav-link');
        tabs.forEach(tab => tab.classList.remove('active'));

        // Remove show active from all tab panes
        const panes = document.querySelectorAll('.tab-pane');
        panes.forEach(pane => pane.classList.remove('show', 'active'));

        // Activate the specified tab
        const targetTab = document.querySelector(`#${activeTab}-tab`);
        const targetPane = document.querySelector(`#${activeTab}`);

        if (targetTab && targetPane) {
            targetTab.classList.add('active');
            targetPane.classList.add('show', 'active');
        }
    }
});
</script>
@endsection
