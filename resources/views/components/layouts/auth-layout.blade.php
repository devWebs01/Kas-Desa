<!doctype html>
<html lang="en">

    <head>
        <title>{{ $title ?? "Website Kas" }}</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Carattere&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

            * {
                font-family: "Poppins", sans-serif;
                font-weight: 400;
                font-style: normal;
            }
        </style>
    </head>

    <body>

        <section class="min-vh-100 d-flex align-items-center justify-content-center">
            <div class="container-fluid p-lg-0 mx-5">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <div class="col-lg-8 mx-auto">
                            <span class="text-muted">Selamat Datang</span>
                            <h2 class="display-5 fw-bold">Masuk ke Akun Anda</h2>
                            <p class="lead">
                                {{ $text ?? "Silakan masukkan email dan kata sandi untuk mengakses sistem." }}
                            </p>
                            {{ $slot }}
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="mt-5 mt-lg-0">
                            <img alt="Ilustrasi Masuk" class="img-fluid"
                                src="{{ asset("assets/img/illustrations/auth-image.png") }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    </body>

</html>
