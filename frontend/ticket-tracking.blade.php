@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 md:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-10 md:mb-12">
            <div class="flex justify-center mb-6">
                <div class="bg-white p-4 rounded-2xl shadow-xl border border-gray-100">
                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 md:mb-4">Lacak Tiket NOC</h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">Pantau status permintaan layanan Anda secara real-time dengan mudah dan cepat</p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 md:p-8 mb-8">
            <div class="mb-6">
                <label for="ticketNumber" class="block text-lg font-semibold text-gray-700 mb-4">
                    Masukkan Nomor Tiket
                </label>
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" id="ticketNumber"
                               class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 transition-all duration-300 placeholder-gray-400"
                               placeholder="Contoh: INS-5F2A1C3E atau MTN-ABC123"
                               value="{{ request()->query('nomor_tiket', '') }}">
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <button id="trackBtn"
                            class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 min-w-[200px]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Lacak Tiket
                    </button>
                </div>
                <div id="error" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 font-medium hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="errorText"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading" class="bg-white rounded-2xl shadow-xl p-12 text-center hidden">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-indigo-600 mx-auto mb-6"></div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Mencari Tiket...</h3>
            <p class="text-gray-500">Mohon tunggu sebentar, kami sedang memproses permintaan Anda</p>
        </div>

        <!-- Result Section -->
        <div id="resultCard" class="bg-white rounded-2xl shadow-xl overflow-hidden hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Detail Tiket</h2>
                        <p class="text-indigo-100 mt-1">Informasi lengkap status permintaan Anda</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Ticket Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nomor Tiket</p>
                                <p class="text-lg font-bold text-gray-900" id="ticketNumberDisplay">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status Saat Ini</p>
                                <span id="statusBadge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold"></span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center mb-3">
                            <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tanggal Permintaan</p>
                                <p class="text-lg font-bold text-gray-900" id="requestDate">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-7 h-7 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Riwayat Status
                    </h3>

                    <div id="timelineContainer" class="space-y-4">
                        <!-- Timeline entries will be appended here -->
                    </div>

                    <div id="noTimeline" class="text-center py-12 text-gray-500 hidden">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat</h4>
                        <p>Tiket ini belum memiliki riwayat status yang tercatat</p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jenis Layanan</p>
                            <p class="text-base font-semibold text-gray-900" id="serviceType">-</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nomor Tenant</p>
                            <p class="text-base font-semibold text-gray-900" id="tenantNumber">-</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Perusahaan</p>
                            <p class="text-base font-semibold text-gray-900" id="companyName">-</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kontak Person</p>
                            <p class="text-base font-semibold text-gray-900" id="contactPerson">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-12 bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Butuh Bantuan?</h3>
                <p class="text-gray-600 mb-6">Jika Anda mengalami kesulitan melacak tiket atau memiliki pertanyaan lainnya</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/contact" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Hubungi Support
                    </a>
                    <a href="/faq" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const trackBtn = document.getElementById('trackBtn');
    const ticketNumberInput = document.getElementById('ticketNumber');
    const loadingEl = document.getElementById('loading');
    const errorEl = document.getElementById('error');
    const errorText = document.getElementById('errorText');
    const resultCard = document.getElementById('resultCard');
    const ticketNumberDisplay = document.getElementById('ticketNumberDisplay');
    const statusBadge = document.getElementById('statusBadge');
    const requestDate = document.getElementById('requestDate');
    const serviceType = document.getElementById('serviceType');
    const tenantNumber = document.getElementById('tenantNumber');
    const companyName = document.getElementById('companyName');
    const contactPerson = document.getElementById('contactPerson');
    const timelineContainer = document.getElementById('timelineContainer');
    const noTimeline = document.getElementById('noTimeline');

    function getStatusConfig(status) {
        const configs = {
            'diterima': {
                color: 'bg-blue-100 text-blue-800 border-blue-200',
                icon: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-blue-500'
            },
            'diproses': {
                color: 'bg-yellow-100 text-yellow-800 border-yellow-200',
                icon: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-yellow-500'
            },
            'selesai': {
                color: 'bg-green-100 text-green-800 border-green-200',
                icon: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-green-500'
            },
            'ditolak': {
                color: 'bg-red-100 text-red-800 border-red-200',
                icon: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-red-500'
            },
            'pending': {
                color: 'bg-gray-100 text-gray-800 border-gray-200',
                icon: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-gray-500'
            }
        };

        const statusKey = status ? status.toLowerCase() : 'pending';
        return configs[statusKey] || configs['pending'];
    }

    function createTimelineEntry(entry, isLast = false) {
        const config = getStatusConfig(entry.status);

        const entryDiv = document.createElement('div');
        entryDiv.className = 'flex items-start space-x-4 timeline-entry';

        // Timeline line and dot
        const timelineDiv = document.createElement('div');
        timelineDiv.className = 'flex flex-col items-center';

        const dot = document.createElement('div');
        dot.className = `w-4 h-4 rounded-full ${config.bgColor} border-4 border-white shadow-lg`;
        timelineDiv.appendChild(dot);

        if (!isLast) {
            const line = document.createElement('div');
            line.className = 'w-0.5 h-16 bg-gray-200 mt-2';
            timelineDiv.appendChild(line);
        }

        entryDiv.appendChild(timelineDiv);

        // Content
        const contentDiv = document.createElement('div');
        contentDiv.className = 'flex-1 bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200';

        const headerDiv = document.createElement('div');
        headerDiv.className = 'flex items-center justify-between mb-3';

        const statusDiv = document.createElement('div');
        statusDiv.className = 'flex items-center space-x-2';

        const statusBadge = document.createElement('span');
        statusBadge.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border ${config.color}`;
        statusBadge.innerHTML = `${config.icon} <span class="ml-1">${entry.status}</span>`;
        statusDiv.appendChild(statusBadge);

        const timeDiv = document.createElement('div');
        timeDiv.className = 'text-sm text-gray-500';
        timeDiv.textContent = entry.waktu;
        statusDiv.appendChild(timeDiv);

        headerDiv.appendChild(statusDiv);

        const personDiv = document.createElement('div');
        personDiv.className = 'text-sm text-gray-600';
        personDiv.textContent = `Oleh: ${entry.oleh || 'Sistem'}`;
        headerDiv.appendChild(personDiv);

        contentDiv.appendChild(headerDiv);

        const descDiv = document.createElement('div');
        descDiv.className = 'text-gray-700 leading-relaxed';
        descDiv.textContent = entry.keterangan || 'Status tiket telah diperbarui';
        contentDiv.appendChild(descDiv);

        entryDiv.appendChild(contentDiv);

        return entryDiv;
    }

    function fetchTicketData(nomorTiket) {
        if (!nomorTiket) {
            errorText.textContent = 'Nomor tiket harus diisi.';
            errorEl.classList.remove('hidden');
            resultCard.classList.add('hidden');
            loadingEl.classList.add('hidden');
            return;
        }

        errorEl.classList.add('hidden');
        loadingEl.classList.remove('hidden');
        resultCard.classList.add('hidden');
        timelineContainer.innerHTML = '';

        let fetchUrl = `/api/tracking/${encodeURIComponent(nomorTiket)}`;
        fetch(fetchUrl)
            .then(response => {
                loadingEl.classList.add('hidden');
                if (!response.ok) {
                    throw new Error('Tiket tidak ditemukan atau terjadi kesalahan server');
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Terjadi kesalahan saat memproses data');
                }

                const ticket = data.data.ticket;
                const currentStatus = data.data.current_status;
                const timeline = data.data.timeline;

                // Update ticket info
                let nomorTiketDisplay = nomorTiket;
                let requestDateValue = '-';
                let serviceTypeValue = '-';
                let tenantNumberValue = '-';
                let companyNameValue = '-';
                let contactPersonValue = '-';

                if (ticket && ticket.data) {
                    if (ticket.tipe === 'instalasi') {
                        nomorTiketDisplay = ticket.data.nomor_tiket || nomorTiket;
                        requestDateValue = ticket.data.tanggal_permintaan || ticket.data.created_at || '-';
                        serviceTypeValue = ticket.data.jenis_layanan || '-';
                        tenantNumberValue = ticket.data.nomor_tenant || '-';
                        companyNameValue = ticket.data.nama_perusahaan || '-';
                        contactPersonValue = ticket.data.kontak_person || '-';
                    } else if (ticket.tipe === 'maintenance') {
                        nomorTiketDisplay = ticket.data.nomor_tracking || nomorTiket;
                        requestDateValue = ticket.data.tanggal_permintaan || ticket.data.created_at || '-';
                        serviceTypeValue = ticket.data.jenis_maintenance || '-';
                        tenantNumberValue = ticket.data.nomor_tenant || '-';
                        companyNameValue = ticket.data.nama_tenant || '-';
                    } else if (ticket.tipe === 'keluhan') {
                        nomorTiketDisplay = ticket.data.nomor_tiket || nomorTiket;
                        requestDateValue = ticket.data.waktu_mulai_gangguan || ticket.data.created_at || '-';
                        serviceTypeValue = ticket.data.jenis_gangguan || '-';
                        tenantNumberValue = ticket.data.nomor_tenant || '-';
                        companyNameValue = ticket.data.nama_tenant || '-';
                        contactPersonValue = ticket.data.kontak_person || '-';
                    } else if (ticket.tipe === 'terminasi') {
                        nomorTiketDisplay = ticket.data.nomor_tiket || nomorTiket;
                        requestDateValue = ticket.data.tanggal_efektif || ticket.data.created_at || '-';
                        serviceTypeValue = 'Terminasi Layanan';
                        tenantNumberValue = ticket.data.nomor_tenant || '-';
                        companyNameValue = ticket.data.nama_tenant || '-';
                    }
                }

                ticketNumberDisplay.textContent = nomorTiketDisplay;
                requestDate.textContent = requestDateValue;
                serviceType.textContent = serviceTypeValue;
                tenantNumber.textContent = tenantNumberValue;
                companyName.textContent = companyNameValue;
                contactPerson.textContent = contactPersonValue;

                // Update status badge
                const config = getStatusConfig(currentStatus);
                statusBadge.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border ${config.color}`;
                statusBadge.innerHTML = `${config.icon} <span class="ml-1">${currentStatus || 'Unknown'}</span>`;

                // Update timeline
                if (timeline && timeline.length > 0) {
                    noTimeline.classList.add('hidden');
                    timeline.forEach((entry, index) => {
                        const isLast = index === timeline.length - 1;
                        timelineContainer.appendChild(createTimelineEntry(entry, isLast));
                    });
                } else {
                    noTimeline.classList.remove('hidden');
                }

                resultCard.classList.remove('hidden');

                // Smooth scroll to results
                resultCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .catch(err => {
                console.error('Error fetching ticket data:', err);
                errorText.textContent = err.message;
                errorEl.classList.remove('hidden');
                resultCard.classList.add('hidden');
                loadingEl.classList.add('hidden');
            });
    }

    // Event listeners
    trackBtn.addEventListener('click', () => {
        const nomorTiket = ticketNumberInput.value.trim();
        fetchTicketData(nomorTiket);
    });

    ticketNumberInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            const nomorTiket = ticketNumberInput.value.trim();
            fetchTicketData(nomorTiket);
        }
    });

    // Auto-load if ticket number is in URL
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const nomorTiket = urlParams.get('nomor_tiket');
        if (nomorTiket) {
            ticketNumberInput.value = nomorTiket;
            fetchTicketData(nomorTiket);
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #resultCard {
        animation: fadeIn 0.5s ease-out;
    }

    .timeline-entry {
        animation: fadeIn 0.3s ease-out;
    }

    .timeline-entry:nth-child(1) { animation-delay: 0.1s; }
    .timeline-entry:nth-child(2) { animation-delay: 0.2s; }
    .timeline-entry:nth-child(3) { animation-delay: 0.3s; }
    .timeline-entry:nth-child(4) { animation-delay: 0.4s; }
    .timeline-entry:nth-child(5) { animation-delay: 0.5s; }
</style>
@endsection
