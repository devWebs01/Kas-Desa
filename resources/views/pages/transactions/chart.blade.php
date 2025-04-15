<?php

use App\Models\Transaction;
use function Livewire\Volt\{computed, state};

$monthlySummaries = computed(function () {
    $months = Transaction::select(DB::raw("DATE_FORMAT(date, '%Y-%m') as month"))->groupBy("month")->orderBy("month")->pluck("month");

    $summaries = [];
    $runningBalance = 0;

    foreach ($months as $month) {
        $debit = Transaction::whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month])
            ->where("category", "debit")
            ->sum("amount");

        $credit = Transaction::whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month])
            ->where("category", "credit")
            ->sum("amount");

        $runningBalance += $debit - $credit;

        $summaries[] = [
            "month" => $month,
            "debit" => $debit,
            "credit" => $credit,
            "balance" => $runningBalance,
        ];
    }

    return $summaries;
});
?>

@volt
    <div class="card mb-4">
        <div class="card-body">
            <canvas id="transactionChart" height="100"></canvas>
        </div>
    </div>

    @push("scripts")
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById("transactionChart").getContext("2d");

                const labels = @json(collect($this->monthlySummaries)->pluck("month")->map(fn($m) => \Carbon\Carbon::createFromFormat("Y-m", $m)->translatedFormat("M Y")));
                const debitData = @json(collect($this->monthlySummaries)->pluck("debit"));
                const creditData = @json(collect($this->monthlySummaries)->pluck("credit"));
                const balanceData = @json(collect($this->monthlySummaries)->pluck("balance"));

                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: labels,
                        datasets: [{
                                label: "Debit",
                                data: debitData,
                                borderColor: "green",
                                backgroundColor: "rgba(0,128,0,0.2)",
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: "Kredit",
                                data: creditData,
                                borderColor: "red",
                                backgroundColor: "rgba(255,0,0,0.2)",
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: "Saldo Akhir",
                                data: balanceData,
                                borderColor: "blue",
                                backgroundColor: "rgba(0,0,255,0.2)",
                                fill: false,
                                tension: 0.4
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: "index",
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: "top",
                            },
                            title: {
                                display: true,
                                text: "Grafik Transaksi Per Bulan"
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endvolt
