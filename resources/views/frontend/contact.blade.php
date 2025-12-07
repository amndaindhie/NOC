@extends('frontend.layout')

@section('body_class', 'contact-page')

@section('title', 'Network Operation Center - KITB')

@section('content')
  <!-- Page Title -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Contact Us</h1>
      <p>
        
          For more information about our services or to submit a network installation request,<br>
          please contact us using the details below. Our Network Operation Center team is ready to support your needs.

      </p>
    </div>
  </div>
  <!-- End Page Title -->

  <!-- Contact Section -->
  <section id="contact" class="contact section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <!-- Kolom Kiri: Info Kontak -->
        <div class="col-lg-6">
          <div class="row gy-4">
            <div class="col-lg-12">
              <div
                class="info-item d-flex flex-column justify-content-center align-items-center"
                data-aos="fade-up"
                data-aos-delay="200"
              >
                <i class="bi bi-geo-alt"></i>
                <h3>Address</h3>
                <p class="address-text">
                  Jl. Kws. Industri Terpadu Batang, Segan, Sawangan, Kec.
                  Gringsing, Kabupaten Batang, Jawa Tengah 51281
                </p>
              </div>
            </div>

            <div class="col-md-6">
              <div
                class="info-item d-flex flex-column justify-content-center align-items-center"
                data-aos="fade-up"
                data-aos-delay="300"
              >
                <i class="bi bi-telephone"></i>
                <h3>Call Us</h3>
                <p>(+62) 8123-1323</p>
              </div>
            </div>

            <div class="col-md-6">
              <div
                class="info-item d-flex flex-column justify-content-center align-items-center"
                data-aos="fade-up"
                data-aos-delay="400"
              >
                <i class="bi bi-envelope"></i>
                <h3>Email Us</h3>
                <p>info@example.com</p>
              </div>
            </div>
          </div>
        </div>
        <!-- End Kolom Kiri -->

        <!-- Kolom Kanan: Map -->
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3960.386625087646!2d110.0015715749969!3d-6.96363569303688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwNTcnNDkuMSJTIDExMMKwMDAnMTQuOSJF!5e0!3m2!1sen!2sid!4v1758597099474!5m2!1sen!2sid"
            style="border: 0; width: 100%; height: 400px"
            allowfullscreen=""
            loading="lazy"
          ></iframe>
        </div>
        <!-- End Kolom Kanan -->
      </div>
    </div>
  </section>
  <!-- /Contact Section -->
@endsection
