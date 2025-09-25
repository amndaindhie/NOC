@extends('frontend.layout')

@section('body_class', 'index-page')

@section('title', 'Network Operation Center - KITB')

@section('content')
  <!-- Hero Section -->
  <section id="hero" class="hero section dark-background">
    <!-- <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in"> -->

    <div
      id="hero-carousel"
      class="carousel slide"
      data-bs-ride="carousel"
      data-bs-interval="5000"
    >
      <div class="container position-relative">
        <div class="carousel-item active">
          <div class="carousel-container">
            <h2>Network Operation Center</h2>
            <p>
              Network Operation Center is the network monitoring center for
              all companies in the Batang Integrated Industrial Estate.
            </p>
            <a href="{{ route('frontend.about') }}" class="btn-get-started">Read More</a>
          </div>
        </div>
        <!-- End Carousel Item -->

        <div class="carousel-item">
          <div class="carousel-container">
            <h2>24 Hour Service</h2>
            <p>
              The NOC operates 24 hour with a professional team to ensure
              all network activities run optimally without interruption.
            </p>
            <a href="about.html" class="btn-get-started">Read More</a>
          </div>
        </div>
        <!-- End Carousel Item -->

        <div class="carousel-item">
          <div class="carousel-container">
            <h2>Advanced Technology</h2>
            <p>
              Our monitoring system is equipped with real-time technology
              for early detection and rapid response to network outages.
            </p>
            <a href="about.html" class="btn-get-started">Read More</a>
          </div>
        </div>
        <!-- End Carousel Item -->

        <a
          class="carousel-control-prev"
          href="#hero-carousel"
          role="button"
          data-bs-slide="prev"
        >
          <span
            class="carousel-control-prev-icon bi bi-chevron-left"
            aria-hidden="true"
          ></span>
        </a>

        <a
          class="carousel-control-next"
          href="#hero-carousel"
          role="button"
          data-bs-slide="next"
        >
          <span
            class="carousel-control-next-icon bi bi-chevron-right"
            aria-hidden="true"
          ></span>
        </a>

        <ol class="carousel-indicators"></ol>
      </div>
    </div>
  </section>
  <!-- /Hero Section -->

  <!-- About Section -->
  <section id="about" class="about section light-background">
    <div class="container">
      <div class="row gy-4">
        <div
          class="col-lg-6 position-relative align-self-start"
          data-aos="fade-up"
          data-aos-delay="100"
        >
          <img src="{{ asset('assets/img/noc.jpg') }}" class="img-fluid" alt="" />
        </div>
        <div
          class="col-lg-6 content"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <h3>What Is NOC?</h3>
          <p class="fst-italic">
            NOC KITB refers to the Network Operations Center (NOC) located
            within the Kawasan Industri Terpadu Batang (KITB), which is a
            special economic zone in Batang, Central Java.
          </p>
          <p>
            The NOC is a central facility for monitoring and managing the
            network infrastructure and ICT (Information and Communication
            Technology) of the industrial area.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- /About Section -->

  <!-- Featured Services Section -->
  <section id="featured-services" class="featured-services section">
    <div class="container">
      <div class="row gy-4">
        <div
          class="col-lg-3 col-md-6"
          data-aos="fade-up"
          data-aos-delay="100"
        >
          <div class="service-item item-cyan position-relative">
            <div class="icon">
              <i class="bi bi-plug"></i>
            </div>
            <a href="{{ route('noc.instalasi.form') }}" class="stretched-link">
              <h3>Network Installation</h3>
            </a>
            <p>
              Installing a new network to ensure optimal internet or
              intranet connectivity.
            </p>
          </div>
        </div>
        <!-- End Service Item -->

        <div
          class="col-lg-3 col-md-6"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <div class="service-item item-orange position-relative">
            <div class="icon">
              <i class="bi bi-wrench"></i>
            </div>
            <a href="{{ route('noc.maintenance.form') }}" class="stretched-link">
              <h3>Maintenance</h3>
            </a>
            <p>
              Routine network maintenance and repairs ensure stable and
              uninterrupted performance.
            </p>
          </div>
        </div>
        <!-- End Service Item -->

        <div
          class="col-lg-3 col-md-6"
          data-aos="fade-up"
          data-aos-delay="300"
        >
          <div class="service-item item-teal position-relative">
            <div class="icon">
              <i class="bi bi-exclamation-triangle"></i>
            </div>
            <a href="{{ route('noc.keluhan.form') }}" class="stretched-link">
              <h3>Network Complaints</h3>
            </a>
            <p>
              Reporting network issues or problems to be handled by the
              technical team.
            </p>
          </div>
        </div>
        <!-- End Service Item -->

        <div
          class="col-lg-3 col-md-6"
          data-aos="fade-up"
          data-aos-delay="400"
        >
          <div class="service-item item-red position-relative">
            <div class="icon">
              <i class="bi bi-x-circle"></i>
            </div>
            <a href="{{ route('noc.terminasi.form') }}" class="stretched-link">
              <h3>Service Termination</h3>
            </a>
            <p>
              Network service termination at the request of the user or
              company.
            </p>
          </div>
        </div>
        <!-- End Service Item -->
      </div>
    </div>
  </section>
  <!-- /Featured Services Section -->

  <!-- Features Section -->
  <section id="features" class="features section light-background">
    <div class="container">
      <div class="row gy-4 align-items-center">
        <!-- Gambar di kiri -->
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
          <div class="p-4 rounded shadow bg-light">
            <h2 class="mb-3">Our Location</h2>
            <p>
              22P3+5G2, Jl. Kw. Industri Terpadu Batang, Segan, Sawangan,
              Kec. Gringsing, Kabupaten Batang, Jawa Tengah 51281
            </p>
          </div>
        </div>

        <!-- Maps di kanan -->
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
          <div class="ratio ratio-16x9">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.737614346236!2d109.93282991082431!3d-6.921937667722151!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e703f3dd6c20939%3A0x4d4a0fc9996dc09!2sGRAND%20BATANG%20CITY!5e0!3m2!1sen!2sid!4v1756693747427!5m2!1sen!2sid"
              style="border: 0; width: 100%; height: 350px"
              allowfullscreen=""
              loading="lazy"
            >
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Features Section -->
@endsection
