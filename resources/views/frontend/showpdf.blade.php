@extends('frontend.layout')

@section('body_class', 'index-page')

@section('title', 'Regulations - Network Operation Center KITB')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container position-relative text-center">
            <h1>Regulations</h1>
            <p>A collection of official regulations, guidelines, and policies available for reading or downloading.</p>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- PDF Switch Section -->
    <section class="pdf-section py-5">
        <div class="container">

            <!-- Menu PDF + Download -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-center flex-grow-1">
                    <span id="tab-pdf1" class="pdf-tab active me-3" onclick="showPDF('pdf1')">PDF 1</span>
                    <span id="tab-pdf2" class="pdf-tab" onclick="showPDF('pdf2')">PDF 2</span>
                </div>
                <!-- Tombol download (berubah sesuai PDF aktif) -->
                <a id="download-btn"
                   href="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}"
                   class="btn btn-noc btn-sm ms-3" target="_blank">
                    <i class="bi bi-box-arrow-down"></i> Download PDF
                </a>
            </div>

            <!-- PDF 1 -->
            <div id="pdf1" class="pdf-container shadow rounded">
                <h3 class="text-center mb-3">Regulasi Penyambungan Fiber Optik</h3>
                <iframe src="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}"
                        width="100%" height="700px" style="border: none; border-radius: 10px">
                </iframe>
            </div>

            <!-- PDF 2 (hidden awalnya) -->
            <div id="pdf2" class="pdf-container shadow rounded d-none">
                <h3 class="text-center mb-3">Regulasi Penggunaan Jaringan Internet</h3>
                <iframe src="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT BPSP & RUSUN.pdf') }}"
                        width="100%" height="700px" style="border: none; border-radius: 10px">
                </iframe>
            </div>

        </div>
    </section>
    <!-- /PDF Switch Section -->

    <style>
        .pdf-tab {
            cursor: pointer;
            font-weight: 500;
            padding-bottom: 5px;
        }
        .pdf-tab.active {
            border-bottom: 2px solid #1e4356; /* warna biru bootstrap */
            color: #1e4356;
            font-weight: 600;
        }
    </style>

    <script>
        function showPDF(id) {
            // sembunyikan semua pdf
            document.getElementById('pdf1').classList.add('d-none');
            document.getElementById('pdf2').classList.add('d-none');

            // tampilkan pdf yg dipilih
            document.getElementById(id).classList.remove('d-none');

            // reset tab
            document.getElementById('tab-pdf1').classList.remove('active');
            document.getElementById('tab-pdf2').classList.remove('active');

            // update tab aktif + link download
            let downloadBtn = document.getElementById('download-btn');
            if (id === 'pdf1') {
                document.getElementById('tab-pdf1').classList.add('active');
                downloadBtn.href = "{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}";
            } else {
                document.getElementById('tab-pdf2').classList.add('active');
                downloadBtn.href = "{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT BPSP & RUSUN.pdf') }}";
            }
        }
    </script>
@endsection
