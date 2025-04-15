<?php

use App\Models\Transaction;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed, state, usesPagination};

usesPagination(theme: "bootstrap");

name("reports.transaction");

state([
    "currentMonth" => fn() => Transaction::select(DB::raw("DATE_FORMAT(date, '%Y-%m') as month"))->groupBy("month")->orderBy("month", "desc")->pluck("month")->first() ?? now()->format("Y-m"),

    "startDate" => null,
    "endDate" => null,
    "filterCategory" => "",
    "filterKeyword" => "",
]);

$filteredAllTransactions = computed(function () {
    return Transaction::query()
        ->with("recipient")
        ->when($this->startDate && $this->endDate, fn($query) => $query->whereBetween("date", [$this->startDate, $this->endDate]))
        ->when($this->filterCategory, fn($query) => $query->where("category", $this->filterCategory))
        ->when($this->filterKeyword, function ($query) {
            $query->where(function ($q) {
                $q->whereHas("recipient", fn($r) => $r->where("name", "like", "%" . $this->filterKeyword . "%"))
                    ->orWhere("title", "like", "%" . $this->filterKeyword . "%")
                    ->orWhere("invoice", "like", "%" . $this->filterKeyword . "%");
            });
        })
        ->get();
});

$filteredTransactions = computed(function () {
    return Transaction::query()
        ->with("recipient")
        ->when($this->startDate && $this->endDate, fn($query) => $query->whereBetween("date", [$this->startDate, $this->endDate]))
        ->when($this->filterCategory, fn($query) => $query->where("category", $this->filterCategory))
        ->when($this->filterKeyword, function ($query) {
            $query->where(function ($q) {
                $q->whereHas("recipient", fn($r) => $r->where("name", "like", "%" . $this->filterKeyword . "%"))
                    ->orWhere("title", "like", "%" . $this->filterKeyword . "%")
                    ->orWhere("invoice", "like", "%" . $this->filterKeyword . "%");
            });
        })
        ->orderBy("date", "asc")
        ->paginate(10); // ✅ PAGINATION
});

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

$totalDebit = computed(fn() => $this->filteredAllTransactions->where("category", "debit")->sum("amount"));

$totalCredit = computed(fn() => $this->filteredAllTransactions->where("category", "credit")->sum("amount"));

$endingBalance = computed(fn() => $this->totalDebit - $this->totalCredit);

?>

<x-app-layout>
    <x-slot name="title">Data Transaksi</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("reports.transaction") }}">Laporan Transaksi</a></li>
    </x-slot>

    @volt
        {{-- Terkait dengan logic Volt --}}
        <div class="card">
            <div class="card-header">
                <div class="row g-2 mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" wire:model.live="startDate" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" wire:model.live="endDate" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select wire:model.live="filterCategory" class="form-select">
                            <option value="">Semua</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Kredit</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cari (Penerima / Judul / Invoice)</label>
                        <input type="text" wire:model.live="filterKeyword" class="form-control"
                            placeholder="Masukkan kata kunci...">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Invoice</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Debit</th>
                                <th scope="col">Kredit</th>
                                <th scope="col">Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->filteredTransactions as $item)
                                <tr>
                                    <td>{{ $item->invoice }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->date)->format("d M Y") }}</td>
                                    <td class="text-success">
                                        {{ $item->category === "debit" ? formatRupiah($item->amount) : "" }}
                                    </td>
                                    <td class="text-danger">
                                        {{ $item->category === "credit" ? formatRupiah($item->amount) : "" }}
                                    </td>
                                    <td>{{ $item->recipient->name ?? "-" }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total Debit</th>
                                <td></td>
                                <td class="text-success">{{ formatRupiah($this->totalDebit) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Total Kredit</th>
                                <td></td>
                                <td></td>
                                <td class="text-danger">{{ formatRupiah($this->totalCredit) }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Saldo Akhir (Kumulatif)</th>
                                <td></td>
                                <td colspan="2" class="fw-bold">{{ formatRupiah($this->endingBalance) }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="mt-3">
                        {{ $this->filteredTransactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    @endvolt

</x-app-layout>
