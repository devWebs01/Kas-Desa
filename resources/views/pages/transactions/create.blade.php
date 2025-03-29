<?php

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Item;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads};
use function Laravel\Folio\name;

usesFileUploads();

name("transactions.create");

state([
    // transaction field
    "category_id",
    "title",
    "type",
    "date",
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

    $transaction = transaction::create($validateData);

    // Jika ada item detail, simpan masing-masing sebagai relasi ke transaksi
    if (!empty($this->items)) {
        $this->validate([
            // Jika ingin validasi detail item juga, gunakan sintaks array "items.*"
            "items" => "nullable|array",
            "items.*.description" => "required_with:items|string",
            "items.*.amount" => "required_with:items|numeric|min:0",
        ]);

        foreach ($this->items as $item) {
            // Pastikan field description dan amount telah diisi atau sesuai dengan validasi tambahan
            Item::create([
                "transaction_id" => $transaction->id,
                "description" => $item["description"],
                "amount" => $item["amount"],
            ]);
        }
    }

    $this->reset();

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

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
                                                wire:model="category_id" id="category_id">
                                                <option selected>Pilih Satu</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("category_id")
                                                <small class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Jenis Transaksi</label>
                                            <select class="form-select @error("type") is-invalid @enderror"
                                                wire:model="type" id="type">
                                                <option selected>Pilih Satu</option>
                                                <option value="DEBIT">Debit</option>
                                                <option value="CREDIT">Kredit</option>
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
                                                    class="form-label">Deskripsi</label>
                                                <textarea class="form-control @error("items." . $index . ".description") is-invalid @enderror"
                                                    wire:model="items.{{ $index }}.description" id="description_{{ $index }}"
                                                    placeholder="Masukkan deskripsi..."></textarea>
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
                                        <div class="col-md">
                                            <div class="mb-3">
                                                <label class="form-label text-white">X</label>
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
