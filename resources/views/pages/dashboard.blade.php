<?php

use function Livewire\Volt\{state};
use App\Models\Transaction;
use Carbon\Carbon;

state([
    "transactions" => function () {
        $lastTransaction = Transaction::orderBy("date", "desc")->first();

        if (!$lastTransaction) {
            return collect();
        } // Jika tidak ada data sama sekali

        $lastMonth = $lastTransaction->date->month;
        $lastYear = $lastTransaction->date->year;

        return Transaction::whereMonth("date", $lastMonth)
            ->whereYear("date", $lastYear)
            ->orderBy("date", "desc") // ← Urutkan dari tanggal paling lama ke baru
            ->take(10)
            ->get();
    },
    "pemasukan" => fn() => Transaction::where("category", "debit")->sum("amount"),
    "pengeluaran" => fn() => Transaction::where("category", "credit")->sum("amount"),
    "saldo" => fn() => $this->pemasukan - $this->pengeluaran,
    "monthlyData" => function () {
        $data = [];
        $year = now()->year;

        foreach (range(1, now()->month) as $month) {
            $monthLabel = Carbon::createFromDate($year, $month, 1)->translatedFormat("M");

            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = Carbon::create($year, $month, 1)->endOfMonth();

            $debit = Transaction::where("category", "debit")
                ->whereBetween("date", [$start, $end])
                ->sum("amount");

            $credit = Transaction::where("category", "credit")
                ->whereBetween("date", [$start, $end])
                ->sum("amount");

            $total = max($debit + $credit, 1); // hindari pembagian nol

            $data[] = [
                "bulan" => $monthLabel,
                "debit" => $debit,
                "credit" => $credit,
                "debit_percent" => ($debit / $total) * 100,
                "credit_percent" => ($credit / $total) * 100,
            ];
        }

        return $data;
    },
]);

?>

@volt
    <div>
        <section class="section pricing__v2" id="dashboard">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-5 mx-auto text-center">
                        <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Laporan</span>
                        <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Keuangan Kas Adat</h2>
                        <p data-aos="fade-up" data-aos-delay="200">Pantau keuangan Kas Adat Dusun Kebun dengan
                            ringkasan pemasukan, pengeluaran, dan transaksi terbaru.
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="p-5 rounded-4 price-table h-100">
                            <h6>Pemasukan & Pengeluaran Tahun {{ now()->year }}</h6>
                            <div class="mb-3">
                                @foreach ($monthlyData as $item)
                                    <small>{{ $item["bulan"] }}</small>
                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $item["debit_percent"] }}%"
                                            aria-valuenow="{{ $item["debit_percent"] }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ formatRupiah($item["debit"]) }}
                                        </div>
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ $item["credit_percent"] }}%"
                                            aria-valuenow="{{ $item["credit_percent"] }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ formatRupiah($item["credit"]) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <div class="col-md-7" data-aos="fade-up" data-aos-delay="400">
                        <div class="p-5 rounded-4 price-table popular h-100">
                            <div class="row">
                                <h6 class="mb-3 text-white">Transaksi Terbaru</h6>
                                <div class="rounded shadow-sm">
                                    <div class="custom-scroll" style=" overflow-y: auto;">
                                        <ul class="list-group">
                                            @foreach ($transactions as $trx)
                                                <li
                                                    class="list-group-item {{ $trx->category === "debit" ? "bg-success-subtle" : "bg-light" }} d-flex justify-content-between flex-column mb-2 rounded">
                                                    <div class="d-flex justify-content-between">
                                                        <span
                                                            class="fw-semibold">{{ Str::limit($trx->title, "30", "...") }}</span>
                                                        <span
                                                            class="fw-semibold {{ $trx->category === "debit" ? "text-success" : "text-danger" }}">
                                                            {{ formatRupiah($trx->amount) }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-between small">
                                                        <span>{{ $trx->date->format("d M Y") }}</span>
                                                        <span
                                                            class="{{ $trx->category === "debit" ? "text-success" : "text-danger" }}">
                                                            {{ ucfirst($trx->category) }}
                                                        </span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p class="small text-center">
                                Scroll
                                <i class="bi bi-arrow-down-circle"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End dashboard -->

        <!-- ======= Stats =======-->
        <section class="stats__v3 section pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap content rounded-4" data-aos="fade-up" data-aos-delay="0">
                            <div class="rounded-borders">
                                <div class="rounded-border-1"></div>
                                <div class="rounded-border-2"></div>
                                <div class="rounded-border-3"></div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up"
                                data-aos-delay="100">
                                <div class="stat-item">
                                    <h3 class="fs-4 fw-bold">{{ formatRupiah($pemasukan) }}</h3>
                                    <p class="mb-0">Total Pemasukan</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up"
                                data-aos-delay="200">
                                <div class="stat-item">
                                    <h3 class="fs-4 fw-bold">{{ formatRupiah($pengeluaran) }}</h3>
                                    <p class="mb-0">Total Pengeluaran</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up"
                                data-aos-delay="300">
                                <div class="stat-item">
                                    <h3 class="fs-4 fw-bold">{{ formatRupiah($saldo) }}</h3>
                                    <p class="mb-0">Saldo Sekarang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Stats-->
    </div>
@endvolt
