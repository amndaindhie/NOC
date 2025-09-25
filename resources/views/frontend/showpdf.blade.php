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

    <!-- PDF Viewer Section -->
    <section class="pdf-section py-5">
        <div class="container">
            <div class="text-center mb-4">
                <a href="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}" class="btn btn-noc" target="_blank">
                    <i class="bi bi-box-arrow-down"></i> Download PDF
                </a>
            </div>
            <div class="pdf-container shadow rounded">
                <iframe src="{{ asset('assets/pdf/REGULASI PENYAMBUNGAN FIBER OPTIK KITB KE TENANT MANUFACTURE.pdf') }}" width="100%" height="700px"
                    style="border: none; border-radius: 10px">
                </iframe>
            </div>
        </div>
    </section>
    <!-- /PDF Viewer Section -->
@endsection