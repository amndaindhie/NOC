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

            <!-- Header PDF -->
            <div class="pdf-header d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <!-- Tabs kiri -->
                <div class="d-flex align-items-center">
                    <span id="tab-pdf1" class="pdf-tab active me-3" onclick="showPDF('pdf1')">PDF 1</span>
                    <span id="tab-pdf2" class="pdf-tab" onclick="showPDF('pdf2')">PDF 2</span>
                </div>

                <!-- Judul di tengah -->
                <h4 id="pdf-title" class="fw-bold m-0 text-center flex-grow-1">
                    Regulasi KITB ke Tenant Manufacture
                </h4>

                <!-- Download kanan -->
                <a id="download-btn"
                   href="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}"
                   class="btn btn-noc btn-sm ms-3" target="_blank">
                    <i class="bi bi-box-arrow-down"></i> Download PDF
                </a>
            </div>

            <!-- PDF 1 -->
            <div id="pdf1" class="pdf-container shadow rounded">
                <div class="pdf-wrapper">
                    <iframe 
                        src="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}#view=FitH"
                        class="pdf-frame">
                    </iframe>
                </div>
            </div>

            <!-- PDF 2 (hidden awalnya) -->
            <div id="pdf2" class="pdf-container shadow rounded d-none">
                <div class="pdf-wrapper">
                    <iframe 
                        src="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT BPSP & RUSUN.pdf') }}#view=FitH"
                        class="pdf-frame">
                    </iframe>
                </div>
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
            border-bottom: 2px solid #1e4356;
            color: #1e4356;
            font-weight: 600;
        }

        /* iframe wrapper biar responsif */
        .pdf-wrapper {
            position: relative;
            width: 100%;
            padding-top: 130%; /* aspect ratio */
        }

        .pdf-frame {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 10px;
        }

        /* Responsive tablet */
        @media (max-width: 768px) {
            .pdf-wrapper {
                padding-top: 150%;
            }
            .pdf-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        /* Responsive HP kecil */
        @media (max-width: 480px) {
            .pdf-wrapper {
                padding-top: 180%;
            }
            .pdf-header {
                flex-direction: column;
                align-items: center;
            }
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

            // update judul + tab aktif + link download
            let downloadBtn = document.getElementById('download-btn');
            let pdfTitle = document.getElementById('pdf-title');

            if (id === 'pdf1') {
                document.getElementById('tab-pdf1').classList.add('active');
                downloadBtn.href = "{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}";
                pdfTitle.textContent = "Regulasi KITB ke Tenant Manufacture";
            } else {
                document.getElementById('tab-pdf2').classList.add('active');
                downloadBtn.href = "{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT BPSP & RUSUN.pdf') }}";
                pdfTitle.textContent = "Regulasi KITB ke Tenant BPSP & Rusun";
            }
        }
    </script>
@endsection
    