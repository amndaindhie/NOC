@extends('frontend.layout')

@section('body_class', 'index-page')

@section('title', 'SHOW PDF - Network Operation Center KITB')

@section('content')
  <!-- Page Title -->
  <div class="page-title dark-background">
    <div class="container position-relative text-center">
      <h1>SHOW PDF</h1>
      <p>Baca atau Unduh Dokumen</p>
    </div>
  </div>
  <!-- End Page Title -->

  <!-- PDF Viewer Section -->
  <section class="pdf-section py-5">
    <div class="container">
      <div class="text-center mb-4">
        <a
          href="{{ asset('assets/pdf/VARIASI BAHASA GEN.pdf') }}"
          class="btn btn-noc"
          target="_blank"
        >
          <i class="bi bi-box-arrow-down"></i> Unduh PDF
        </a>
        <a
          href="{{ asset('assets/pdf/VARIASI BAHASA GEN.pdf') }}"
          class="btn btn-secondary"
          target="_blank"
        >
          <i class="bi bi-printer"></i> Cetak
        </a>
      </div>
      <div class="pdf-container shadow rounded">
        <iframe
          src="{{ asset('assets/pdf/VARIASI BAHASA GEN.pdf') }}"
          width="100%"
          height="700px"
          style="border: none; border-radius: 10px"
        >
        </iframe>
      </div>
    </div>
  </section>
  <!-- /PDF Viewer Section -->
@endsection