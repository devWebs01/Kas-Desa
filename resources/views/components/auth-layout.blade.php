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
            <div class="container p-lg-0">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <div class="col-lg-8 mx-auto">
                            <span class="text-muted">Selamat Datang</span>
                            <h2 class="display-5 fw-bold">Masuk ke Akun Anda</h2>
                            <p class="lead">Silakan masukkan email dan kata sandi untuk mengakses sistem. </p>
                            {{ $slot }}
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="mt-5 mt-lg-0">
                            <img alt="Ilustrasi Masuk" class="img-fluid"
                                src="https://sdmntprsouthcentralus.oaiusercontent.com/files/00000000-7c70-61f7-9dc9-3a48738623c1/raw?se=2025-04-12T09%3A29%3A07Z&sp=r&sv=2024-08-04&sr=b&scid=5e178d30-5439-5a6d-9c17-efb2419350bd&skoid=dfdaf859-26f6-4fed-affc-1befb5ac1ac2&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2025-04-11T22%3A26%3A43Z&ske=2025-04-12T22%3A26%3A43Z&sks=b&skv=2024-08-04&sig=n3phC6KLTnLJQ9ECr8NakiKF3Lhah5Yl12SXKjlc1zw%3D">
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
