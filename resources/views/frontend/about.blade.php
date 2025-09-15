@extends('frontend.layout')

@section('body_class', 'about-page')

@section('title', 'Network Operation Center - KITB')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container position-relative">
            <h1>Get To Know Us</h1>
            <p>Connecting the Future with Reliable Network Solutions</p>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ asset('assets/img/fasilitas/mnda.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
                    <h3>History of Network Operation Center (NOC)</h3>
                    <p class="fst-italic">
                        The NOC began in the 1970s in response to the
                        pressing need for monitoring and management of
                        complex telecommunications networks. The
                        telecommunications industry was the first to
                        develop NOC technology, establishing it as a
                        centralized facility for monitoring and managing
                        network systems 24/7 to ensure optimal stability
                        and uptime. Over time, the NOC's role evolved
                        from simply monitoring telecommunications
                        networks to becoming the nerve center for
                        various other industries, such as finance,
                        manufacturing, and energy, as their reliance on
                        IT infrastructure increased.

                    </p>
                    <p>
                        KITB is located in Batang, Central Java, and
                        manages Grand Batang City, an integrated
                        industrial estate managed by PT. Kawasan
                        Industri Terpadu Batang (KITB). KITB's
                        operations were inaugurated by President Joko
                        Widodo in July 2024.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- /About Section -->

   {{-- <!-- Struktur Divisi NOC -->
    <section id="struktur-noc" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">NOC Division Structure</h2>
                <p class="text-muted">
                    Organizational structure and role division in the
                    Network Operation Center

                </p>
            </div>

            <div class="text-center">
                <!-- Head of NOC -->
                <div class="mb-4">
                    <div class="p-3 rounded shadow d-inline-block head-noc">
                        <h5 class="mb-0">Head of NOC</h5>
                        <small>Manajer / Pimpinan</small>
                    </div>
                </div>

                <!-- Supervisor -->
                <div class="mb-4">
                    <div class="p-3 bg-secondary text-white rounded shadow d-inline-block">
                        <h6 class="mb-0">NOC Supervisor</h6>
                        <small>Koordinator Tim</small>
                    </div>
                </div>

                  <!-- Engineers & Support -->
                        <div class="row justify-content-center g-4">
                            <div class="col-md-2">
                                <div class="p-3 shadow-sm h-100 card-structure">
                                    <h6 class="fw-bold">NOC Engineer</h6>
                                    <p class="small mb-0">
                                        Network Monitoring & Maintenance
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="p-3 shadow-sm h-100 card-structure">
                                    <h6 class="fw-bold">Field Engineer</h6>
                                    <p class="small mb-0">
                                        Field and Repair Technicians
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="p-3 shadow-sm h-100 card-structure">
                                    <h6 class="fw-bold">Helpdesk Support</h6>
                                    <p class="small mb-0">
                                        Handling Customer Complaints
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="p-3 shadow-sm h-100 card-structure">
                                    <h6 class="fw-bold">Admin</h6>
                                    <p class="small mb-0">
                                        Documentation & Reports
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> End Struktur Divisi NOC -->--}}


    <!-- Team Section -->
    <section id="team" class="team section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Facilities</h2>
            <p>
                "Our facilities are designed to meet the needs of our team and deliver the best experience for our clients."
            </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
                    <div class="member-img">
                        <img src="{{ asset('assets/img/fasilitas/fasilitas (1).jpg') }}" class="img-fluid" alt="" />
                    </div>
                    <div class="member-info text-center">
                        <h4>Meeting Room</h4>
                        <p>
                            A spacious conference room with modern chairs and a large table, perfect for team discussions, brainstorming sessions, and client meetings.
                        </p>
                    </div>
                </div>
                <!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="200">
                    <div class="member-img">
                        <img src="{{ asset('assets/img/fasilitas/fasilitas (2).jpg') }}" class="img-fluid" alt="" />
                    </div>
                    <div class="member-info text-center">
                        <h4>Server Room</h4>
                        <p>
                            A dedicated server room with secured racks and climate control to ensure stable network and data center operations.
                        </p>
                    </div>
                </div>
                <!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="300">
                    <div class="member-img">
                        <img src="{{ asset('assets/img/fasilitas/fasilitas (3).jpg') }}" class="img-fluid" alt="" />
                    </div>
                    <div class="member-info text-center">
                        <h4>Restroom</h4>
                        <p>
                            Clean and well-maintained restrooms for employees and visitors, ensuring comfort and hygiene.
                        </p>
                    </div>
                </div>
                <!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="400">
                    <div class="member-img">
                        <img src="{{ asset('assets/img/fasilitas/fasilitas (4).jpg') }}" class="img-fluid" alt="" />
                    </div>
                    <div class="member-info text-center">
                        <h4>Workstations</h4>
                        <p>
                            Ergonomic desks and seating arrangements designed to improve focus and efficiency while working.
                        </p>
                    </div>
                </div>
                <!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="500">
                    <div class="member-img">
                        <img src="{{ asset('assets/img/fasilitas/fasilitas (5).jpg') }}" class="img-fluid" alt="" />
                    </div>
                    <div class="member-info text-center">
                        <h4>Reception Area</h4>
                        <p>
                            A welcoming reception area for guests, providing a professional first impression of our office.
                        </p>
                    </div>
                </div>
                <!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="600">
                    <div class="member-img">
                        <img src="{{ asset('assets/img/fasilitas/fasilitas (6).jpg') }}" class="img-fluid" alt="" />
                    </div>
                    <div class="member-info text-center">
                        <h4>Breakout Space</h4>
                        <p>
                            A cozy lounge area where employees can relax, recharge, and engage in informal discussions.
                        </p>
                    </div>
                </div>
                <!-- End Team Member -->
            </div>
        </div>
    </section>
    <!-- /Skills Section -->
@endsection
