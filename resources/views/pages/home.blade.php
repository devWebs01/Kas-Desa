<?php

use App\Models\Transaction;
use App\Models\Recipient;
use Illuminate\Support\Facades\DB;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state};

name("home");

state([]);

$totalDebit = computed(fn() => Transaction::where("category", "debit")->sum("amount"));
$totalCredit = computed(fn() => Transaction::where("category", "credit")->sum("amount"));

$monthlyTotals = computed(function () {
    return Transaction::selectRaw("DATE_FORMAT(date, '%Y-%m') as month, SUM(amount) as total")
        ->groupBy("month")
        ->orderBy("month")
        ->pluck("total", "month")
        ->toArray();
});

$monthlyBalances = computed(function () {
    $transactions = Transaction::selectRaw("DATE_FORMAT(date, '%Y-%m') as month, category, SUM(amount) as total")
        ->groupBy("month", "category")
        ->get()
        ->groupBy("month");

    $saldo = 0;
    $result = [];

    foreach ($transactions as $month => $items) {
        $debit = $items->where("category", "debit")->sum("total");
        $credit = $items->where("category", "credit")->sum("total");

        $saldo += $debit - $credit;
        $result[$month] = $saldo;
    }

    return $result;
});

$topRecipients = computed(function () {
    return Recipient::withCount("transactions")
        ->withSum("transactions", "amount")
        ->orderByDesc("transactions_count")
        ->limit(5)
        ->get();
});

$balancePerDay = computed(function () {
    return Transaction::select(
        DB::raw("DATE(date) as day"),
        DB::raw("SUM(CASE WHEN category = 'debit' THEN amount ELSE 0 END) as total_debit"),
        DB::raw("SUM(CASE WHEN category = 'credit' THEN amount ELSE 0 END) as total_credit")
    )
        ->groupBy("day")
        ->orderBy("day", "asc")
        ->get()
        ->map(function ($item) {
            return [
                "day" => $item->day,
                "balance" => $item->total_debit - $item->total_credit,
            ];
        });
});

?>

<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item active">Dashboard</li>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @volt
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center fw-bold">Total Transaksi per Bulan</div>
                    <div class="card-body">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center fw-bold">Perbandingan Debit vs Kredit</div>
                    <div class="card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-center fw-bold">Statistik Per Kategori</div>
                    <div class="card-body">
                        @include("pages.transactions.chart")
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-center fw-bold">Saldo Akhir per Hari</div>
                    <div class="card-body">
                        <canvas id="balanceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg">
                <div class="card">
                    <div class="card-header text-center fw-bold">Penerima Teraktif</div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jumlah Transaksi</th>
                                    <th>Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->topRecipients as $recipient)
                                    <tr>
                                        <td>{{ $recipient->name }}</td>
                                        <td>{{ $recipient->transactions_count }}</td>
                                        <td>{{ formatRupiah($recipient->transactions_sum_amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @push("scripts")
            <script>
                new Chart(document.getElementById('categoryChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Debit', 'Kredit'],
                        datasets: [{
                            data: [{{ $this->totalDebit }}, {{ $this->totalCredit }}],
                            backgroundColor: ['#28a745', '#dc3545'],
                        }]
                    }
                });

                new Chart(document.getElementById('monthlyChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_keys($this->monthlyTotals)) !!},
                        datasets: [{
                            label: 'Total Transaksi',
                            data: {!! json_encode(array_values($this->monthlyTotals)) !!},
                            backgroundColor: '#0d6efd',
                        }]
                    }
                });

                const balanceData = @json($this->balancePerDay);

                new Chart(document.getElementById('balanceChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: balanceData.map(item => item.day),
                        datasets: [{
                            label: 'Saldo Akhir',
                            data: balanceData.map(item => item.balance),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            tension: 0.4,
                            fill: true,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + new Intl.NumberFormat().format(value);
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    autoSkip: true,
                                    maxTicksLimit: 10,
                                }
                            }
                        }
                    }
                });
            </script>
        @endpush
    @endvolt
</x-app-layout>
