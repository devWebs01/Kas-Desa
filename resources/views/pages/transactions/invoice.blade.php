<!doctype html>
<html lang="en">

    <head>
        <title>{{ $transaction->invoice }}</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Carattere&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

            * {
                font-family: "Poppins", sans-serif;
                font-weight: 400;
                font-style: normal;
            }

            .header {
                background: url('/path/to/wave.svg') no-repeat center top;
                background-size: cover;
                padding-top: 100px;
                /* Sesuaikan tinggi wave */
            }

            @media print {
                body * {
                    visibility: hidden;
                }

                .card,
                .card * {
                    visibility: visible;
                }

                .card {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    box-shadow: none !important;
                }
            }
        </style>

        @vite([])
    </head>

    <body onclick="window.print()">

        <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 py-4"
            style="background: #f0f2f5;">

            <div class="card shadow-sm d-print" style="max-width: 800px; width: 100%;">

                <div class="card-body">
                    <div class="text-center my-4">
                        <h4 class="text-primary mb-0 fw-bold">{{ $setting->name }}</h4>
                    </div>

                    <table class="table table-borderless table-sm mb-4">
                        <tbody>
                            <tr>
                                <td><strong>Tanggal</strong></td>
                                <td class="text-end">
                                    {{ \Carbon\Carbon::parse($transaction->date)->format("d-m-Y") }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Referensi</strong></td>
                                <td class="text-end">{{ $transaction->invoice }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <table class="table table-borderless table-sm mb-4">
                        <tbody>
                            <tr>
                                <td><strong>Judul</strong></td>
                                <td class="text-end">{{ $transaction->title }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kategori</strong></td>
                                <td class="text-end">{{ ucfirst($transaction->category) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Penerima</strong></td>
                                <td class="text-end">{{ $transaction->recipient->name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td style="width: 150px;"><strong>Catatan</strong></td>
                                <td class="text-end">{{ $transaction->description ?? "-" }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <td><strong>Nominal</strong></td>
                                <td class="text-end">Rp{{ number_format($transaction->amount, 0, ",", ".") }}</td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="text-center my-4">
                        <h5 class="text-primary fw-semibold mb-1">Total</h5>
                        <h2 class="fw-bold">Rp{{ number_format($transaction->amount, 0, ",", ".") }}</h2>
                    </div>

                    <div class="d-flex justify-content-around text-center my-5">
                        <div>
                            <p class="fw-bold mb-2">Penerima</p>
                            {{-- Area kosong untuk tanda tangan penerima --}}
                            <div style="width:300px; height:100px;  display:inline-block;"></div>
                            <p class="fw-bold my-2">{{ $transaction->recipient->name }}</p>
                        </div>
                        <div>
                            <p class="fw-bold mb-2">Penanggung Jawab</p>
                            @if ($setting->signature)
                                <img src="{{ Storage::url($setting->signature) }}" class="w-100"
                                    style="width:300px; height:100px;" alt="Tanda Tangan Penanggung Jawab" />
                            @else
                                {{-- Area kosong untuk tanda tangan penerima --}}
                                <div style="width:300px; height:100px;  display:inline-block;"></div>
                            @endif
                            <p class="fw-bold my-3">{{ $setting->responsible_person }}</p>
                        </div>
                    </div>

                    <p class="text-center text-muted small mt-4 mb-0">
                        © 2025 Aplikasi Kas Desa. Terdaftar dan diawasi oleh Otoritas Keuangan Desa.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    </body>

</html>
