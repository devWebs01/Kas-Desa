<?php

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads, computed};
use function Laravel\Folio\name;

usesFileUploads();

name("transactions.create");

state(["category_id"])->url();

state([
    // transaction field
    "title",
    "date",
    "type",
    "total",

    // "status",

    // item field
    "items" => [],

    // dataset
    "categories" => fn() => Category::get(),
]);

rules([
    // Validasi untuk field transaksi
    "category_id" => "required|exists:categories,id",
    "title" => "required|string|max:255",
    "type" => "required|in:DEBIT,CREDIT",
    "date" => "required|date",
]);

$store = function () {
    $validateData = $this->validate();

    // Cari transaksi terakhir (jika ada)
    $lastTransaction = Transaction::latest("id")->first();
    $previousTotal = $lastTransaction ? $lastTransaction->total : 0;

    // Buat transaksi baru dulu, total kosong dulu
    $transaction = Transaction::create(array_merge($validateData, ["total" => 0]));

    // Validasi item
    $this->validate([
        "items" => "nullable|array",
        "items.*.description" => "required_with:items|string",
        "items.*.amount" => "required_with:items|numeric|min:0",
    ]);

    $itemTotal = 0;

    // Simpan item
    if (!empty($this->items)) {
        foreach ($this->items as $item) {
            $transaction->items()->create([
                "description" => $item["description"],
                "amount" => $item["amount"],
            ]);
            $itemTotal += $item["amount"];
        }
    }

    // Hitung total baru berdasarkan tipe transaksi
    $newTotal = $transaction->type === "DEBIT" ? $previousTotal + $itemTotal : $previousTotal - $itemTotal;

    $transaction->update(["total" => $newTotal]);

    LivewireAlert::text("Data berhasil diproses.")->success()->toast()->show();
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

$typeTransaction = computed(function () {
    if ($this->category_id) {
        $category = Category::find($this->category_id)->name;

        if ($category === "Pembelanjaan") {
            return $this->type = "CREDIT";
        } elseif ($category === "Pendapatan") {
            return $this->type = "DEBIT";
        }
    } else {
        return "";
    }
});

?>

<x-app-layout>
    <x-slot name="title">Tambah transaction Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Transaksi</a></li>
    </x-slot>

    <style>
        .fixed-item-container {
            max-height: 400px;
            /* atau tinggi yang diinginkan */
            overflow-y: auto;
        }
    </style>

    @volt
        <div>
            <div class="alert alert-primary" role="alert">
                <strong>Tambah Transaksi</strong>
                <p>Pada halaman tambah Transaksi, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
                    sistem.</p>
            </div>

            <form wire:submit="store">
                @csrf

                <div class="row gap-1">
                    <div class="col-md-6 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Judul Transaksi</label>
                                            <input type="text" class="form-control @error("title") is-invalid @enderror"
                                                wire:model="title" id="title" aria-describedby="titleId"
                                                placeholder="Enter transaction title" autofocus autocomplete="title" />
                                            @error("title")
                                                <small id="titleId" class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Tanggal Transaksi</label>
                                            <input type="date" class="form-control @error("date") is-invalid @enderror"
                                                wire:model="date" id="date" aria-describedby="dateId"
                                                placeholder="Enter transaction date" autofocus autocomplete="date" />
                                            @error("date")
                                                <small id="dateId" class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Kategori</label>
                                            <select class="form-select @error("category_id") is-invalid @enderror"
                                                wire:model.live="category_id" id="category_id">
                                                <option value='' selected>Pilih Satu</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("category_id")
                                                <small class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <small class="d-none"> {{ $this->typeTransaction }}</small>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Jenis Transaksi</label>
                                            <select class="form-select @error("type") is-invalid @enderror"
                                                wire:model="type" id="type"
                                                {{ $category_id === null ? "disabled" : "" }}>
                                                <option>Pilih Satu</option>
                                                <option value="DEBIT">Debit
                                                </option>
                                                <option value="CREDIT">
                                                    Kredit
                                                </option>
                                            </select>
                                            @error("type")
                                                <small class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                        <div class="col-md align-self-center text-end">
                                            <span wire:loading class="spinner-border spinner-border-sm"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md">

                        <div class="card">

                            <div class="card-body">
                                @foreach ($items as $index => $item)
                                    <div class="row mb-3">
                                        <!-- Field Description -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description_{{ $index }}"
                                                    class="form-label">keterangan</label>
                                                <textarea class="form-control @error("items." . $index . ".description") is-invalid @enderror"
                                                    wire:model="items.{{ $index }}.description" id="description_{{ $index }}"
                                                    placeholder="Masukkan keterangan..."></textarea>
                                                @error("items." . $index . ".description")
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Field Amount -->
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <label for="amount_{{ $index }}" class="form-label">Jumlah</label>
                                                <input type="number"
                                                    class="form-control @error("items." . $index . ".amount") is-invalid @enderror"
                                                    wire:model="items.{{ $index }}.amount"
                                                    id="amount_{{ $index }}" placeholder="0" />
                                                @error("items." . $index . ".amount")
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Remove Button -->
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label text-white">Hapus</label>
                                                <button type="button" wire:click="removeItem({{ $index }})"
                                                    class="btn btn-danger">
                                                    X
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>
                                @endforeach

                                <!-- Button Tambah Item -->
                                <div class="row mb-3">
                                    <div class="col-auto">
                                        <button type="button" wire:click="addItem" class="btn btn-primary">
                                            Tambah Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    @endvolt
</x-app-layout>
