@extends('frontend.layout')

@section('title', 'Lacak Tiket NOC')

@section('description', 'Pantau status permintaan layanan Anda secara real-time dengan mudah dan cepat')

@section('keywords', 'tracking, tiket, NOC, layanan')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Lacak Tiket NOC</h1>
      <p>
        Pantau status permintaan layanan Anda secara real-time dengan mudah dan cepat
      </p>
    </div>
  </div>

  <div class="container">
    <!-- Success/Error Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="form-section">
      <!-- Search Section -->
      <div class="mb-3">
        <label class="form-label">Masukkan Nomor Tiket</label>
        <div class="input-group">
          <input type="text" id="ticketNumber" class="form-control" placeholder="Contoh: INS-5F2A1C3E atau MTN-ABC123" value="{{ request()->query('nomor_tiket', '') }}">
          <button id="trackBtn" class="btn btn-primary">Lacak Tiket</button>
        </div>
      </div>
      <div id="error" class="alert alert-danger" style="display: none;"></div>
    </div>

    <!-- Loading State -->
    <div id="loading" class="text-center" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p>Mencari Tiket...</p>
    </div>

    <!-- Result Section -->
    <div id="resultCard" class="card" style="display: none;">
      <div class="card-header text-white" style="background-color: #1e4356;">
        <h2 class="card-title mb-0">Detail Tiket</h2>
        <p class="mb-0">Informasi lengkap status permintaan Anda</p>
      </div>
      <div class="card-body">
        <!-- Ticket Info -->
        <div class="row">
          <div class="col-md-4">
            <div class="card mb-3">
              <div class="card-body text-center">
                <i class="bi bi-tag-fill fs-1 text-primary mb-2"></i>
                <h5>Nomor Tiket</h5>
                <p id="ticketNumberDisplay" class="fw-bold">-</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-3">
              <div class="card-body text-center">
                <i class="bi bi-check-circle-fill fs-1 text-success mb-2"></i>
                <h5>Status Saat Ini</h5>
                <span id="statusBadge" class="badge fs-6"></span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-3">
              <div class="card-body text-center">
                <i class="bi bi-calendar-event fs-1 text-info mb-2"></i>
                <h5>Tanggal Permintaan</h5>
                <p id="requestDate" class="fw-bold">-</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Timeline Section -->
        <h3 class="mt-4">Riwayat Status</h3>
        <div id="timelineContainer" class="list-group"></div>
        <div id="noTimeline" class="text-center text-muted" style="display: none;">
          <i class="bi bi-info-circle fs-1"></i>
          <p>Belum Ada Riwayat</p>
        </div>

        <!-- Additional Info -->
        <div class="card mt-4">
          <div class="card-header">
            <h4 class="mb-0">Informasi Tambahan</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <strong>Jenis Layanan</strong>
                <p id="serviceType">-</p>
              </div>
              <div class="col-md-3">
                <strong>Nomor Tenant</strong>
                <p id="tenantNumber">-</p>
              </div>
              <div class="col-md-3">
                <strong>Nama Perusahaan</strong>
                <p id="companyName">-</p>
              </div>
              <div class="col-md-3">
                <strong>Kontak Person</strong>
                <p id="contactPerson">-</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

@endsection

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const trackBtn = document.getElementById('trackBtn');
      const ticketNumberInput = document.getElementById('ticketNumber');
      const loadingEl = document.getElementById('loading');
      const errorEl = document.getElementById('error');
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
            color: 'bg-success',
            icon: 'bi-check-circle-fill',
            textColor: 'text-white'
          },
          'diproses': {
            color: 'bg-warning',
            icon: 'bi-clock-fill',
            textColor: 'text-dark'
          },
          'selesai': {
            color: 'bg-success',
            icon: 'bi-check-circle-fill',
            textColor: 'text-white'
          },
          'ditolak': {
            color: 'bg-danger',
            icon: 'bi-x-circle-fill',
            textColor: 'text-white'
          },
          'pending': {
            color: 'bg-secondary',
            icon: 'bi-clock-fill',
            textColor: 'text-white'
          }
        };

        const statusKey = status ? status.toLowerCase() : 'pending';
        return configs[statusKey] || configs['pending'];
      }

      function createTimelineEntry(entry, isLast = false) {
        const config = getStatusConfig(entry.status);

        const entryDiv = document.createElement('div');
        entryDiv.className = 'list-group-item d-flex align-items-start';

        // Timeline dot
        const dotDiv = document.createElement('div');
        dotDiv.className = `me-3 mt-1`;
        dotDiv.innerHTML = `<i class="bi ${config.icon} ${config.color} ${config.textColor} rounded-circle p-2"></i>`;
        entryDiv.appendChild(dotDiv);

        // Content
        const contentDiv = document.createElement('div');
        contentDiv.className = 'flex-grow-1';

        const headerDiv = document.createElement('div');
        headerDiv.className = 'd-flex justify-content-between align-items-center mb-2';

        const statusSpan = document.createElement('span');
        statusSpan.className = `badge ${config.color} ${config.textColor}`;
        statusSpan.innerHTML = `<i class="bi ${config.icon} me-1"></i>${entry.status}`;
        headerDiv.appendChild(statusSpan);

        const timeSpan = document.createElement('small');
        timeSpan.className = 'text-muted';
        timeSpan.textContent = entry.waktu;
        headerDiv.appendChild(timeSpan);

        contentDiv.appendChild(headerDiv);

        const personP = document.createElement('p');
        personP.className = 'mb-1 text-muted small';
        personP.textContent = `Oleh: ${entry.oleh || 'Sistem'}`;
        contentDiv.appendChild(personP);

        const descP = document.createElement('p');
        descP.className = 'mb-0';
        descP.textContent = entry.keterangan || 'Status tiket telah diperbarui';
        contentDiv.appendChild(descP);

        entryDiv.appendChild(contentDiv);

        return entryDiv;
      }

      function fetchTicketData(nomorTiket) {
        console.log('fetchTicketData called with:', nomorTiket);
        if (!nomorTiket) {
          showError('Nomor tiket harus diisi.');
          return;
        }

        clearError();
        showLoading(true);
        clearResults();

        let fetchUrl = `/api/tracking/${encodeURIComponent(nomorTiket)}`;
        console.log('Fetching URL:', fetchUrl);
        fetch(fetchUrl)
          .then(response => {
            showLoading(false);
            console.log('Response status:', response.status);
            if (!response.ok) {
              throw new Error('Tiket tidak ditemukan');
            }
            return response.json();
          })
          .then(data => {
            console.log('Response data:', data);
            if (!data.success) {
              throw new Error(data.message || 'Terjadi kesalahan saat memproses data');
            }

            displayResults(data.data, nomorTiket);
          })
          .catch(err => {
            console.error('Fetch error:', err);
            showError(err.message);
          });
      }

      function showError(message) {
        errorEl.textContent = message;
        errorEl.style.display = 'block';
        resultCard.style.display = 'none';
        loadingEl.style.display = 'none';
      }

      function clearError() {
        errorEl.textContent = '';
        errorEl.style.display = 'none';
      }

      function showLoading(show) {
        loadingEl.style.display = show ? 'block' : 'none';
      }

      function clearResults() {
        resultCard.style.display = 'none';
        timelineContainer.innerHTML = '';
      }

      function displayResults(data, nomorTiket) {
        const ticket = data.ticket;
        const currentStatus = data.current_status;
        const timeline = data.timeline;

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
            requestDateValue = ticket.data.tanggal_permintaan || ticket.data.created_at || '-';
            serviceTypeValue = ticket.data.jenis_gangguan || '-';
            tenantNumberValue = ticket.data.nomor_tenant || '-';
            companyNameValue = ticket.data.nama_tenant || '-';
            contactPersonValue = ticket.data.kontak_person || '-';
          } else if (ticket.tipe === 'terminasi') {
            nomorTiketDisplay = ticket.data.nomor_tiket || nomorTiket;
            requestDateValue = ticket.data.tanggal_permintaan || ticket.data.created_at || '-';
            serviceTypeValue = 'Terminasi Layanan';
            tenantNumberValue = ticket.data.nomor_tenant || '-';
            companyNameValue = ticket.data.nama_tenant || '-';
          }
        }

        ticketNumberDisplay.textContent = nomorTiketDisplay;
        requestDate.textContent = formatDateDisplay(requestDateValue);
        serviceType.textContent = serviceTypeValue;
        tenantNumber.textContent = tenantNumberValue;
        companyName.textContent = companyNameValue;
        contactPerson.textContent = contactPersonValue;

        // Update status badge
        const config = getStatusConfig(currentStatus);
        statusBadge.className = `badge ${config.color} ${config.textColor}`;
        statusBadge.innerHTML = `<i class="bi ${config.icon} me-1"></i>${currentStatus || 'Unknown'}`;

        // Update timeline
        if (timeline && timeline.length > 0) {
          noTimeline.style.display = 'none';
          timeline.forEach((entry, index) => {
            const isLast = index === timeline.length - 1;
            timelineContainer.appendChild(createTimelineEntry(entry, isLast));
          });
        } else {
          noTimeline.style.display = 'block';
        }

        resultCard.style.display = 'block';

        // Smooth scroll to results
        resultCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
      const urlParams = new URLSearchParams(window.location.search);
      const nomorTiket = urlParams.get('nomor_tiket');
      if (nomorTiket) {
        ticketNumberInput.value = nomorTiket;
        fetchTicketData(nomorTiket);
      }

      // Helper function to format date string to YYYY-MM-DD
      function formatDateDisplay(dateStr) {
        if (!dateStr || dateStr === '-') return '-';
        // Try to parse date string and format to YYYY-MM-DD
        try {
          const date = new Date(dateStr);
          if (isNaN(date)) return dateStr;
          const year = date.getFullYear();
          const month = (date.getMonth() + 1).toString().padStart(2, '0');
          const day = date.getDate().toString().padStart(2, '0');
          return `${year}-${month}-${day}`;
        } catch (e) {
          return dateStr;
        }
      }
    });
  </script>
