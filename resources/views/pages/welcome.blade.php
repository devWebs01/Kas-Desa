<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Milky - Dairy Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicon -->
        <link href="{{ asset("/guest/img/favicon.ico") }}" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap"
            rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset("/guest/lib/animate/animate.min.css") }}" rel="stylesheet">
        <link href="{{ asset("/guest/lib/owlcarousel/assets/owl.carousel.min.css") }}" rel="stylesheet">
        <link href="{{ asset("/guest/lib/lightbox/css/lightbox.min.css") }}" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset("/guest/css/bootstrap.min.css") }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset("/guest/css/style.css") }}" rel="stylesheet">

        @vite([])
    </head>

    <body>
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
            <a href="index.html" class="navbar-brand d-flex align-items-center">
                <h1 class="m-0">Milky</h1>
            </a>
            <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.html" class="nav-item nav-link active">Home</a>
                    <a href="about.html" class="nav-item nav-link">About</a>
                    <a href="service.html" class="nav-item nav-link">Services</a>
                    <a href="product.html" class="nav-item nav-link">Products</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu bg-light m-0">
                            <a href="gallery.html" class="dropdown-item">Gallery</a>
                            <a href="feature.html" class="dropdown-item">Features</a>
                            <a href="team.html" class="dropdown-item">Our Team</a>
                            <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404 Page</a>
                        </div>
                    </div>
                    <a href="contact.html" class="nav-item nav-link">Contact</a>
                </div>
                <div class="border-start ps-4 d-none d-lg-block">
                    <button type="button" class="btn btn-sm p-0"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Carousel Start -->
        <div class="container-fluid px-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="/guest/img/carousel-1.jpg" alt="Image">
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-start">
                                    <div class="col-lg-8 text-start">
                                        <p class="fs-4 text-white">Selamat Datang di Website Dusun Kebun</p>
                                        <h1 class="display-1 text-white mb-5 animated slideInRight">Transparansi
                                            Keuangan Kas Desa</h1>
                                        <a href="#about"
                                            class="btn btn-secondary rounded-pill py-3 px-5 animated slideInRight">Pelajari
                                            Lebih Lanjut</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="w-100" src="/guest/img/carousel-2.jpg" alt="Image">
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-end">
                                    <div class="col-lg-8 text-end">
                                        <p class="fs-4 text-white">Transparansi, Akuntabilitas, dan Akses Publik</p>
                                        <h1 class="display-1 text-white mb-5 animated slideInRight">Laporan Keuangan
                                            Real-Time</h1>
                                        <a href="#transparansi"
                                            class="btn btn-secondary rounded-pill py-3 px-5 animated slideInLeft">Lihat
                                            Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- About Start -->
        <div id="about" class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-end">
                    <div class="col-lg-6">
                        <div class="row g-2">
                            <div class="col-6 position-relative wow fadeIn" data-wow-delay="0.7s">
                                <div class="about-experience bg-secondary rounded">
                                    <h1 class="display-1 mb-0">Dusun</h1>
                                    <small class="fs-5 fw-bold">Kebun, Batang Asam</small>
                                </div>
                            </div>
                            <div class="col-6 wow fadeIn" data-wow-delay="0.1s">
                                <img class="img-fluid rounded" src="/guest/img/service-1.jpg">
                            </div>
                            <div class="col-6 wow fadeIn" data-wow-delay="0.3s">
                                <img class="img-fluid rounded" src="/guest/img/service-2.jpg">
                            </div>
                            <div class="col-6 wow fadeIn" data-wow-delay="0.5s">
                                <img class="img-fluid rounded" src="/guest/img/service-3.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <p class="section-title bg-white text-start text-primary pe-3">Tentang Dusun Kebun</p>
                        <h1 class="mb-4">Profil Wilayah dan Komitmen Transparansi</h1>
                        <p class="mb-4">Dusun Kebun, yang terletak di Kecamatan Batang Asam, Kabupaten Tanjung Jabung
                            Barat, merupakan wilayah yang berkomitmen pada tata kelola desa yang terbuka dan transparan.
                            Melalui sistem ini, kami hadirkan informasi keuangan kas desa secara real-time dan dapat
                            diakses oleh masyarakat luas.</p>
                        <div class="row g-5 pt-2 mb-5">
                            <div class="col-sm-6">
                                <img class="img-fluid mb-4" src="/guest/img/service.png" alt="">
                                <h5 class="mb-3">Pelayanan Transparan</h5>
                                <span>Data keuangan dapat diakses kapan saja oleh masyarakat sebagai bentuk keterbukaan
                                    publik.</span>
                            </div>
                            <div class="col-sm-6">
                                <img class="img-fluid mb-4" src="/guest/img/product.png" alt="">
                                <h5 class="mb-3">Laporan Akurat</h5>
                                <span>Sistem kami menyajikan laporan kas desa harian, mingguan, dan bulanan yang akurat
                                    dan terpercaya.</span>
                            </div>
                        </div>
                        <a class="btn btn-secondary rounded-pill py-3 px-5" href="#transparansi">Lihat Laporan</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Features Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <p class="section-title bg-white text-start text-primary pe-3">Mengapa Kami?</p>
                        <h1 class="mb-4">Alasan Mengapa Masyarakat Memilih Dusun Kebun</h1>
                        <p class="mb-4">Dusun Kebun dikenal sebagai wilayah yang aktif dalam pengelolaan dana desa
                            secara transparan, inklusif, dan akuntabel demi kemajuan bersama.</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Transparansi Anggaran & Keuangan Kas</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Pelayanan Publik yang Ramah dan Terbuka</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Komitmen pada Pembangunan Berkelanjutan</p>
                        <a class="btn btn-secondary rounded-pill py-3 px-5 mt-3" href="#transparansi">Lihat Data
                            Keuangan</a>
                    </div>
                    <div class="col-lg-6">
                        <div class="rounded overflow-hidden">
                            <div class="row g-0">
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                    <div class="text-center bg-primary py-5 px-4">
                                        <img class="/guest/img-fluid mb-4" src="/guest/img/experience.png"
                                            alt="">
                                        <h1 class="display-6 text-white">10+</h1>
                                        <span class="fs-5 fw-semi-bold text-secondary">Tahun Pengabdian</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                    <div class="text-center bg-secondary py-5 px-4">
                                        <img class="/guest/img-fluid mb-4" src="/guest/img/award.png" alt="">
                                        <h1 class="display-6">20+</h1>
                                        <span class="fs-5 fw-semi-bold text-primary">Program Desa Aktif</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="text-center bg-secondary py-5 px-4">
                                        <img class="/guest/img-fluid mb-4" src="/guest/img/animal.png"
                                            alt="">
                                        <h1 class="display-6">120+</h1>
                                        <span class="fs-5 fw-semi-bold text-primary">Penerima Manfaat</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                    <div class="text-center bg-primary py-5 px-4">
                                        <img class="/guest/img-fluid mb-4" src="/guest/img/client.png"
                                            alt="">
                                        <h1 class="display-6 text-white">100%</h1>
                                        <span class="fs-5 fw-semi-bold text-secondary">Komitmen Transparansi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Features End -->

        <!-- Banner Start -->
        <div class="container-fluid banner my-5 py-5" data-parallax="scroll" data-image-src="/guest/img/banner.jpg">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.3s">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm-4">
                                <img class="/guest/img-fluid rounded" src="/guest/img/banner-1.jpg" alt="">
                            </div>
                            <div class="col-sm-8">
                                <h2 class="text-white mb-3">Layanan Masyarakat Aktif</h2>
                                <p class="text-white mb-4">Berbagai program dan bantuan untuk warga dijalankan secara
                                    langsung dengan pengawasan bersama.</p>
                                <a class="btn btn-secondary rounded-pill py-2 px-4" href="#layanan">Lihat Layanan</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm-4">
                                <img class="/guest/img-fluid rounded" src="/guest/img/banner-2.jpg" alt="">
                            </div>
                            <div class="col-sm-8">
                                <h2 class="text-white mb-3">Transparansi Keuangan Kas</h2>
                                <p class="text-white mb-4">Lihat langsung alur pengeluaran dan penerimaan dana desa
                                    secara real-time dan terbuka.</p>
                                <a class="btn btn-secondary rounded-pill py-2 px-4" href="#transparansi">Cek Kas
                                    Desa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner End -->

        <!-- Service Start -->
        <div class="container-xxl py-5" id="layanan">
            <div class="container">
                <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <p class="section-title bg-white text-center text-primary px-3">Layanan Desa</p>
                    <h1 class="mb-5">Program & Pelayanan untuk Masyarakat</h1>
                </div>
                <div class="row gy-5 gx-4">
                    <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item d-flex h-100">
                            <div class="service-img">
                                <img class="/guest/img-fluid" src="/guest/img/service-1.jpg" alt="">
                            </div>
                            <div class="service-text p-5 pt-0">
                                <div class="service-icon">
                                    <img class="/guest/img-fluid rounded-circle" src="/guest/img/service-1.jpg"
                                        alt="">
                                </div>
                                <h5 class="mb-3">Program Kesejahteraan Warga</h5>
                                <p class="mb-4">Beragam bantuan langsung tunai dan sosial yang dikelola dengan
                                    transparan melalui sistem kas desa.</p>
                                <a class="btn btn-square rounded-circle" href="#transparansi"><i
                                        class="bi bi-chevron-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item d-flex h-100">
                            <div class="service-img">
                                <img class="/guest/img-fluid" src="/guest/img/service-2.jpg" alt="">
                            </div>
                            <div class="service-text p-5 pt-0">
                                <div class="service-icon">
                                    <img class="/guest/img-fluid rounded-circle" src="/guest/img/service-2.jpg"
                                        alt="">
                                </div>
                                <h5 class="mb-3">Pembangunan Infrastruktur</h5>
                                <p class="mb-4">Dari jalan hingga irigasi, pembangunan desa didanai dan dilaporkan
                                    secara rutin ke publik.</p>
                                <a class="btn btn-square rounded-circle" href="#transparansi"><i
                                        class="bi bi-chevron-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item d-flex h-100">
                            <div class="service-img">
                                <img class="/guest/img-fluid" src="/guest/img/service-3.jpg" alt="">
                            </div>
                            <div class="service-text p-5 pt-0">
                                <div class="service-icon">
                                    <img class="/guest/img-fluid rounded-circle" src="/guest/img/service-3.jpg"
                                        alt="">
                                </div>
                                <h5 class="mb-3">Pelayanan Administratif</h5>
                                <p class="mb-4">Kemudahan dalam pengurusan surat menyurat dan data warga yang efisien
                                    serta berbasis digital.</p>
                                <a class="btn btn-square rounded-circle" href="#layanan"><i
                                        class="bi bi-chevron-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->
        <!-- Footer Start -->
        <footer class="py-4">
            <div class="container">
                <div class="d-lg-flex justify-content-between py-3 py-lg-2">
                    <div class="small mb-2 mb-lg-0">
                        <p class="text-muted mb-0 me-5">© 2023 FreeFrontend.dev. All rights reserved.</p>
                    </div>
                    <div class="d-flex small align-items-end justify-content-between">
                        <div>
                            <a class="d-block d-lg-inline text-muted ms-lg-3 mb-2 mb-lg-0" href="">Privacy
                                Policy</a> <a class="d-block d-lg-inline text-muted ms-lg-3 mb-2 mb-lg-0"
                                href="">Terms</a> <a
                                class="d-block d-lg-inline text-muted ms-lg-3 mb-2 mb-lg-0" href="">Cookies</a>
                            <a class="d-block d-lg-inline text-muted ms-lg-3" href="">Sitemap</a>
                        </div>
                        <div class="d-none d-lg-block ms-3">
                            <a class="me-2" href=""><svg class="bi bi-pinterest text-primary"
                                    fill="currentColor" height="16" viewbox="0 0 16 16" width="16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z">
                                    </path>
                                </svg></a> <a class="me-2" href=""><svg class="bi bi-twitter text-primary"
                                    fill="currentColor" height="16" viewbox="0 0 16 16" width="16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
                                    </path>
                                </svg></a> <a class="me-2" href=""><svg class="bi bi-facebook text-primary"
                                    fill="currentColor" height="16" viewbox="0 0 16 16" width="16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
                                    </path>
                                </svg></a>
                        </div>
                        <div class="d-lg-none">
                            <a class="me-2" href=""><svg class="bi bi-pinterest text-primary"
                                    fill="currentColor" height="16" viewbox="0 0 16 16" width="16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z">
                                    </path>
                                </svg></a> <a class="me-2" href=""><svg class="bi bi-twitter text-primary"
                                    fill="currentColor" height="16" viewbox="0 0 16 16" width="16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
                                    </path>
                                </svg></a> <a class="me-2" href=""><svg class="bi bi-facebook text-primary"
                                    fill="currentColor" height="16" viewbox="0 0 16 16" width="16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
                                    </path>
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
                class="bi bi-arrow-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset("/guest/lib/wow/wow.min.js") }}"></script>
        <script src="{{ asset("/guest/lib/easing/easing.min.js") }}"></script>
        <script src="{{ asset("/guest/lib/waypoints/waypoints.min.js") }}"></script>
        <script src="{{ asset("/guest/lib/owlcarousel/owl.carousel.min.js") }}"></script>
        <script src="{{ asset("/guest/lib/counterup/counterup.min.js") }}"></script>
        <script src="{{ asset("/guest/lib/parallax/parallax.min.js") }}"></script>
        <script src="{{ asset("/guest/lib/lightbox/js/lightbox.min.js") }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset("/guest/js/main.js") }}"></script>
    </body>

</html>
