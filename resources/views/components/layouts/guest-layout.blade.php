<!DOCTYPE html>
<!--
Template name: Nova
Template author: FreeBootstrap.net
Author website: https://freebootstrap.net/
License: https://freebootstrap.net/license
-->
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> {{ $website->name ?? "Kas Desa Website" }} </title>

        <!-- ======= Google Font =======-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet">
        <!-- End Google Font-->

        <!-- ======= Styles =======-->
        <link href="{{ asset("assets_2/vendors/bootstrap/bootstrap.min.css") }}" rel="stylesheet">
        <link href="{{ asset("assets_2/vendors/bootstrap-icons/font/bootstrap-icons.min.css") }}" rel="stylesheet">
        <link href="{{ asset("assets_2/vendors/glightbox/glightbox.min.css") }}" rel="stylesheet">
        <link href="{{ asset("assets_2/vendors/swiper/swiper-bundle.min.css") }}" rel="stylesheet">
        <link href="{{ asset("assets_2/vendors/aos/aos.css") }}" rel="stylesheet">
        <!-- End Styles-->

        <!-- ======= Theme Style =======-->
        <link href="{{ asset("assets_2/css/style.css") }}" rel="stylesheet">
        <!-- End Theme Style-->

        <!-- ======= Apply theme =======-->
        <script>
            // Apply the theme as early as possible to avoid flicker
            (function() {
                const storedTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-bs-theme', storedTheme);
            })();
        </script>

        <style>
            .custom-scroll {
                max-height: 300px;
                overflow-y: scroll;
                scrollbar-width: none;
                /* Firefox */
                -ms-overflow-style: none;
                /* IE and Edge */
            }

            .custom-scroll::-webkit-scrollbar {
                display: none;
                /* Chrome, Safari */
            }
        </style>

        @vite([])
    </head>

    <body>

        <!-- ======= Site Wrap =======-->
        <div class="site-wrap">

            <!-- ======= Header =======-->
            <header class="fbs__net-navbar navbar navbar-expand-lg dark" aria-label="freebootstrap.net navbar">
                <div class="container d-flex align-items-center justify-content-between">

                    <!-- Start Logo-->
                    <a class="navbar-brand w-auto" href="index.html">
                        <!-- If you use a text logo, uncomment this if it is commented-->
                        <!-- Vertex-->

                        <!-- If you plan to use an image logo, uncomment this if it is commented-->

                        <!-- logo dark-->
                        <div class="logo dark img-fluid">
                            <i class="bi bi-coin"></i>
                        </div>

                        <!-- logo light-->
                        <div class="logo light img-fluid">
                            <i class="bi bi-coin"></i>
                        </div>

                    </a>
                    <!-- End Logo-->

                    <!-- Start offcanvas-->
                    <div class="offcanvas offcanvas-start w-75" id="fbs__net-navbars" tabindex="-1"
                        aria-labelledby="fbs__net-navbarsLabel">

                        <div class="offcanvas-header">
                            <div class="offcanvas-header-logo">
                                <!-- If you use a text logo, uncomment this if it is commented-->

                                <!-- h5#fbs__net-navbarsLabel.offcanvas-title Vertex-->

                                <!-- If you plan to use an image logo, uncomment this if it is commented-->
                                <a class="logo-link" id="fbs__net-navbarsLabel" href="index.html">

                                    <!-- logo dark-->
                                    <img class="logo dark img-fluid" src="{{ asset("assets_2/images/logo-dark.svg") }}"
                                        alt="FreeBootstrap.net image placeholder">

                                    <!-- logo light-->
                                    <img class="logo light img-fluid"
                                        src="{{ asset("assets_2/images/logo-light.svg") }}"
                                        alt="FreeBootstrap.net image placeholder">
                                </a>

                            </div>
                            <button class="btn-close btn-close-black" type="button" data-bs-dismiss="offcanvas"
                                aria-label="Close">
                            </button>
                        </div>

                        <div class="offcanvas-body align-items-lg-center">

                            <ul class="navbar-nav nav me-auto ps-lg-5 mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link scroll-link active" aria-current="page"
                                        href="#home">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link scroll-link" href="#about">Tentang Kami</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link scroll-link" href="#features">Fitur Utama</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link scroll-link" href="#dashboard">Laporan</a>
                                </li>

                            </ul>

                        </div>
                    </div>
                    <!-- End offcanvas-->

                    <div class="ms-auto w-auto">

                        <div class="header-social d-flex align-items-center gap-1">
                            @auth
                                <a class="btn btn-primary py-2" href="{{ route("home") }}">Dashboard</a>
                            @else
                                <a class="btn btn-primary py-2" href="#home">Mulai</a>
                            @endauth

                            <button class="fbs__net-navbar-toggler justify-content-center align-items-center ms-auto"
                                data-bs-toggle="offcanvas" data-bs-target="#fbs__net-navbars"
                                aria-controls="fbs__net-navbars" aria-label="Toggle navigation" aria-expanded="false">
                                <svg class="fbs__net-icon-menu" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="21" x2="3" y1="6" y2="6">

                                    </line>
                                    <line x1="15" x2="3" y1="12" y2="12">

                                    </line>
                                    <line x1="17" x2="3" y1="18" y2="18">

                                    </line>
                                </svg>
                                <svg class="fbs__net-icon-close" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18">

                                    </path>
                                    <path d="m6 6 12 12">

                                    </path>
                                </svg>
                            </button>

                        </div>

                    </div>
                </div>
            </header>
            <!-- End Header-->

            <!-- ======= Main =======-->
            <main>

                {{ $slot }}

            </main>

            <!-- ======= Footer =======-->
            <footer class="footer pt-5 pb-5">
                <div class="container">

                    <div class="row credits pt-3">
                        <div class="col-xl-8 text-center text-xl-start mb-3 mb-xl-0">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Nurkhofifah.

                        </div>
                        <div
                            class="col-xl-4 justify-content-start justify-content-xl-end quick-links d-flex flex-column flex-xl-row text-center text-xl-start gap-1">
                            <a href="#home" target="_blank">{{ $website->name ?? "" }},
                                {{ $website->address ?? "" }}</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer-->
        </div>

        <!-- ======= Back to Top =======-->
        <button id="back-to-top">
            <i class="bi bi-arrow-up-short">
            </i>
        </button>
        <!-- End Back to top-->

        <!-- ======= Javascripts =======-->
        <script src="{{ asset("assets_2/vendors/bootstrap/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset("assets_2/vendors/gsap/gsap.min.js") }}"></script>
        <script src="{{ asset("assets_2/vendors/imagesloaded/imagesloaded.pkgd.min.js") }}"></script>
        <script src="{{ asset("assets_2/vendors/isotope/isotope.pkgd.min.js") }}"></script>
        <script src="{{ asset("assets_2/vendors/glightbox/glightbox.min.js") }}"></script>
        <script src="{{ asset("assets_2/vendors/swiper/swiper-bundle.min.js") }}"></script>
        <script src="{{ asset("assets_2/vendors/aos/aos.js") }}"></script>
        <script src="{{ asset("assets_2/vendors/purecounter/purecounter.js") }}"></script>
        <script src="{{ asset("assets_2/js/custom.js") }}"></script>
        <script src="{{ asset("assets_2/js/send_email.js") }}"></script>
        <!-- End JavaScripts-->
    </body>

</html>
