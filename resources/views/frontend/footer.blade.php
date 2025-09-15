<footer id="footer" class="footer dark-background">
  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="index.html" class="d-flex align-items-center">
          <span class="sitename">Network Operation Center</span>
        </a>
        <div class="footer-contact pt-3">
          <p>Pelabuhan, Ketanggan, Gringsing,</p>
          <p>Batang Regency, Central Java 51281</p>
          <p class="mt-3">
            <strong>Phone:</strong> <span>(+62) 8123-1323-323</span>
          </p>
          <p>
            <strong>Email:</strong> <span>amandaindhie5@gmail.com </span>
          </p>
        </div>
      </div>

      <!-- filepath: c:\Users\LENOVO\noc_lastpol\resources\views\frontend\footer.blade.php -->
<!-- ...existing code... -->
<div class="col-lg-2 col-md-3 footer-links">
  <h4>Navigation</h4>
  <ul>
    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home') }}">Home</a></li>
    <li>
      <i class="bi bi-chevron-right"></i>
      <a href="{{ route('frontend.about') }}">Get to know us</a>
    </li>
    <li>
      <i class="bi bi-chevron-right"></i> <a href="{{ route('noc.instalasi.form') }}">Services</a>
    </li>
    <li>
      <i class="bi bi-chevron-right"></i>
      <a href="{{ route('frontend.tracking') }}">Tracking Request</a>
    </li>
  </ul>
</div>

<div class="col-lg-2 col-md-3 footer-links">
  <h4>Our Services</h4>
  <ul>
    <li>
      <i class="bi bi-chevron-right"></i>
      <a href="{{ route('noc.instalasi.form') }}">Network Installation</a>
    </li>
    <li>
      <i class="bi bi-chevron-right"></i>
      <a href="{{ route('noc.maintenance.form') }}">Maintenance</a>
    </li>
    <li>
      <i class="bi bi-chevron-right"></i>
      <a href="{{ route('noc.keluhan.form') }}">Network Complaints</a>
    </li>
    <li>
      <i class="bi bi-chevron-right"></i>
      <a href="{{ route('noc.terminasi.form') }}">Service Termination</a>
    </li>
  </ul>
</div>
<!-- ...existing code... -->

  <div class="container copyright text-center mt-4">
    <p>
      &copy; <span id="displayYear"></span> Network Operation Center 2025 |
      <a href="https://industropolisbatang.co.id/" target="_blank">
        PT Kawasan Industri Terpadu Batang
      </a>
    </p>
  </div>
</footer>
