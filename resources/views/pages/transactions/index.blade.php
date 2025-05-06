<?php

use App\Models\Transaction;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state};
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("transactions.index");

state([
    "currentMonth" => fn() => Transaction::select(DB::raw("DATE_FORMAT(date, '%Y-%m') as month"))->groupBy("month")->orderBy("month", "desc")->pluck("month")->first() ?? now()->format("Y-m"),
]);

$availableMonths = computed(function () {
    return Transaction::select(DB::raw("DATE_FORMAT(date, '%Y-%m') as month"))->groupBy("month")->orderBy("month", "desc")->pluck("month");
});

$transactionsByMonth = computed(function () {
    return Transaction::query()
        ->with("recipient")
        ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$this->currentMonth])
        ->orderBy("date", "asc") // ✅ BENAR
        ->get();
});

$previousMonth = function () {
    $currentIndex = $this->availableMonths->search($this->currentMonth);
    if ($currentIndex !== false && $currentIndex < $this->availableMonths->count() - 1) {
        $this->currentMonth = $this->availableMonths[$currentIndex + 1];
    }
};

$nextMonth = function () {
    $currentIndex = $this->availableMonths->search($this->currentMonth);
    if ($currentIndex > 0) {
        $this->currentMonth = $this->availableMonths[$currentIndex - 1];
    }
};

$totalDebit = computed(function () {
    return Transaction::whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$this->currentMonth])
        ->where("category", "debit")
        ->sum("amount");
});

$totalCredit = computed(function () {
    return Transaction::whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$this->currentMonth])
        ->where("category", "credit")
        ->sum("amount");
});

$endingBalance = computed(function () {
    $debitTotal = Transaction::whereRaw("DATE_FORMAT(date, '%Y-%m') <= ?", [$this->currentMonth])
        ->where("category", "debit")
        ->sum("amount");

    $creditTotal = Transaction::whereRaw("DATE_FORMAT(date, '%Y-%m') <= ?", [$this->currentMonth])
        ->where("category", "credit")
        ->sum("amount");

    return $debitTotal - $creditTotal;
});

$destroy = function (Transaction $transaction) {
    try {
        $transaction->delete();
        LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();
        $this->redirectRoute("transactions.index");
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error("Error deleting transaction: " . $e->getMessage(), [
            "trace" => $e->getTraceAsString(),
        ]);
        LivewireAlert::text("Data gagal di proses.")->error()->toast()->show();
        $this->redirectRoute("transactions.index");
    }
};
?>

<x-app-layout>
    <x-slot name="title">Data Transaksi</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
    </x-slot>

    @include("pages.transactions.chart")

    @volt
        {{-- Terkait dengan logic Volt --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route("transactions.create") }}" class="btn btn-primary">Tambah Transaksi</a>
                <h5 class="mb-0">
                    {{ \Carbon\Carbon::createFromFormat("Y-m", $currentMonth)->translatedFormat("F Y") }}
                </h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Penerima</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->transactionsByMonth as $no => $item)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->date)->format("d M Y") }}</td>
                                    <td class="text-success">
                                        {{ $item->category === "debit" ? formatRupiah($item->amount) : "" }}
                                    </td>
                                    <td class="text-danger">
                                        {{ $item->category === "credit" ? formatRupiah($item->amount) : "" }}
                                    </td>
                                    <td>{{ $item->recipient->name }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route("transactions.edit", ["transaction" => $item->id]) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ route("transactions.invoice", $item->id) }}" target="blank"
                                                class="btn btn-sm btn-secondary">Invoice</a>
                                            <button wire:loading.attr="disabled" wire:click="destroy({{ $item->id }})"
                                                wire:confirm="Apakah kamu yakin ingin menghapus data ini?"
                                                class="btn btn-sm btn-danger">
                                                {{ __("Hapus") }}
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Tidak ada transaksi bulan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total Debit</th>
                                <td class="text-success">{{ formatRupiah($this->totalDebit) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="2">Total Kredit</th>
                                <td></td>
                                <td class="text-danger">{{ formatRupiah($this->totalCredit) }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="2">Saldo Akhir (Kumulatif)</th>
                                <td colspan="2" class="fw-bold">{{ formatRupiah($this->endingBalance) }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class=" mt-2 d-flex justify-content-between align-items-center mt-3">
                        <button wire:click="previousMonth" class="btn btn-outline-secondary"
                            @if ($currentMonth == $this->availableMonths->last()) disabled @endif>
                            &laquo; Bulan Sebelumnya
                        </button>

                        <button wire:click="nextMonth" class="btn btn-outline-secondary"
                            @if ($currentMonth == $this->availableMonths->first()) disabled @endif>
                            Bulan Berikutnya &raquo;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endvolt

</x-app-layout>
