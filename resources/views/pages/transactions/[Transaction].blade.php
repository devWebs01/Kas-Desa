<?php

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads, mount};
use function Laravel\Folio\name;

usesFileUploads();

name("transactions.show");

state([
    // Dataset
    "transaction",
    "categories" => fn() => Category::get(),

    // Field transaksi
    "category_id",
    "title",
    "type",
    "date",
    // "status",

    // Field item detail
    "items" => [],
    "runningTotal" => 0,
    "previous_total" => fn() => Item::sum("amount") - $this->transaction->items->sum("amount"),
    "after_total" => fn() => Item::sum("amount"),
    "previousTotal",
]);

rules([
    // Validasi untuk field transaksi
    "category_id" => "required|exists:categories,id",
    "title" => "required|string|max:255",
    "type" => "required|in:DEBIT,CREDIT",
    "date" => "required|date",
]);

mount(function () {
    // Ambil transaksi sebelumnya (berdasarkan urutan) (masih salah)
    $previousTransaction = Transaction::where("id", "<", $transaction->id)->orderByDesc("id")->first();
    $this->previousTotal = $previousTransaction ? $previousTransaction->total : 0;
});

// Fungsi mount untuk memuat data transaksi yang sudah ada
mount(function () {
    $transaction = $this->transaction;
    $this->category_id = $transaction->category_id;
    $this->title = $transaction->title;
    $this->type = $transaction->type;
    $this->date = Carbon\Carbon::parse($transaction->date)->format("Y-m-d"); // Asumsi field date adalah Carbon instance
    $this->items = $transaction->items
        ->map(function ($item) {
            return [
                "description" => $item->description,
                "amount" => $item->amount,
            ];
        })
        ->toArray();
});

$update = function () {
    $validateData = $this->validate();

    $transaction = Transaction::find($this->transaction->id);
    if (!$transaction) {
        LivewireAlert::text("Transaksi tidak ditemukan.")->error()->toast()->show();
        return;
    }

    // Ambil transaksi sebelumnya (berdasarkan urutan)
    $previousTransaction = Transaction::where("id", "<", $transaction->id)->orderByDesc("id")->first();
    $previousTotal = $previousTransaction ? $previousTransaction->total : 0;

    // Hitung total item lama yang akan dihapus
    $oldAmount = $transaction->items->sum("amount");

    // Update data transaksi utama (selain total)
    $transaction->update([
        "category_id" => $this->category_id,
        "title" => $this->title,
        "type" => $this->type,
        "date" => $this->date,
    ]);

    // Validasi item baru
    $this->validate([
        "items" => "nullable|array",
        "items.*.description" => "required_with:items|string",
        "items.*.amount" => "required_with:items|numeric|min:0",
    ]);

    // Hapus item lama
    $transaction->items()->delete();

    $newAmount = 0;

    // Simpan item baru
    if (!empty($this->items)) {
        foreach ($this->items as $item) {
            $transaction->items()->create([
                "description" => $item["description"],
                "amount" => $item["amount"],
            ]);
            $newAmount += $item["amount"];
        }
    }

    // Hitung ulang total berdasarkan perbedaan jumlah
    $adjustedTotal = $transaction->type === "DEBIT" ? $previousTotal + $newAmount : $previousTotal - $newAmount;

    $transaction->update(["total" => $adjustedTotal]);

    $this->reset();

    LivewireAlert::text("Data berhasil diperbarui.")->success()->toast()->show();
    $this->redirectRoute("transactions.index");
};

$addItem = function () {
    $this->items[] = [
        "description" => "",
        "amount" => "",
    ];
};

$removeItem = function ($index) {
    array_splice($this->items, $index, 1);
};

?>

<x-app-layout>
    <x-slot name="title">Edit Transaksi</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a href="#">Edit Transaksi</a></li>
    </x-slot>

    @volt
        <div>
            <ul class="nav nav-pills px-0" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-show-tab" data-bs-toggle="pill" data-bs-target="#pills-show"
                        type="button" role="tab" aria-controls="pills-show" aria-selected="false">Data
                        Transaksi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="pills-edit-tab" data-bs-toggle="pill" data-bs-target="#pills-edit"
                        type="button" role="tab" aria-controls="pills-edit" aria-selected="true">Edit
                        Transaksi</button>
                </li>
            </ul>
            <div class="tab-content px-0" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-show" role="tabpanel" aria-labelledby="pills-show-tab"
                    tabindex="0">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="table-responsive border rounded">
                                <table class="table text-nowrap table-striped-columns">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Nominal</th>
                                            <th>Uraian Perhitungan</th>
                                            <th>Tanda Tangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>Dana Terakhir</td>
                                            <td></td>
                                            <td>{{ formatRupiah($previousTotal) }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <!-- Baris header transaksi -->
                                        <tr>
                                            <td>{{ Carbon\Carbon::parse($transaction->date)->format("d M Y") }}</td>
                                            <td>{{ $transaction->title }}</td>
                                            <td colspan="4"></td>
                                        </tr>
                                        @foreach ($transaction->items as $item)
                                            <tr>
                                                <td></td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ formatRupiah($item->amount) }}</td>
                                                <td>
                                                    @if ($transaction->type === "DEBIT")
                                                        {{ formatRupiah($runningTotal += $item->amount) }}
                                                        {{ $operation = "+" }}
                                                    @else
                                                        {{ formatRupiah($runningTotal -= $item->amount) }}
                                                    @endif
                                                </td>

                                                <td>
                                                    <i
                                                        class="{{ !empty($item->signature_code) ? "bx bxs-check-circle fs-1 text-success" : "bx bxs-x-circle fs-1 text-danger" }}"></i>
                                                </td>
                                                <td>
                                                    <a href="{{ route("items.signature", ["item" => $item]) }}"
                                                        class="btn btn-primary">
                                                        {{ !empty($item->signature_code) ? "Lihat" : "Isi Tanda Tangan" }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td><strong>Total Dana</strong></td>
                                            <td></td>
                                            <td>
                                                {{ formatRupiah($after_total) }}
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab" tabindex="0">
                    @include("pages.transactions.edit")
                </div>

            </div>
        </div>
    @endvolt
</x-app-layout>
