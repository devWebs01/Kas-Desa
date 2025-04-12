<?php

use App\Models\Transaction;
use App\Models\Recipient;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads};
use function Laravel\Folio\name;

usesFileUploads();

name("transactions.create");

state([
    "recipients" => fn() => Recipient::get(),
    "title",
    "category",
    "amount",
    "invoice",
    "date",
    "description",
    "recipient_id",
]);

rules([
    "title" => ["required", "string"],
    "category" => ["required", "in:credit,debit"],
    "amount" => ["required", "numeric", "between:-999999.99,999999.99"],
    "invoice" => ["nullable", "string", "unique:transactions,invoice"],
    "date" => ["required", "date"],
    "description" => ["required", "string"],
    "recipient_id" => ["required", "integer", "exists:recipients,id"],
]);

$create = function () {
    $validateData = $this->validate();

    Transaction::create($validateData);

    $this->reset();

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

    $this->redirectRoute("transactions.index");
};

?>

<x-app-layout>
    <x-slot name="title">Tambah Transaksi Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Transaksi</a></li>
    </x-slot>

    @push("styles")
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>

        <style>
            .ts-wrapper {
                width: 100%;
            }

            .ts-wrapper .ts-control {
                height: calc(2.375rem + 2px);
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #212529;
                background-color: #fff;
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .ts-wrapper .ts-control.focus {
                border-color: #86b7fe;
                outline: 0;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }

            .ts-dropdown {
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, .15);
            }

            .dropdown-menu {
                width: 100% !important;
                min-width: 100% !important;
                box-sizing: border-box;
            }

            .option {
                padding: 10px;
            }

            /* Saat item di-hover */
            .dropdown-menu .option:hover {
                background-color: #0d6efd !important;
                /* warna biru Bootstrap */
                color: #fff !important;
            }

            /* Saat item aktif (selected/focus) */
            .dropdown-menu .active {
                background-color: #0d6efd !important;
                color: #fff !important;
            }
        </style>
    @endpush

    @push("scripts")
        <script>
            var settings = {};
            new TomSelect("#recipient_id", {
                persist: false,
                createOnBlur: true,
                placeholder: "Pilih penerima...",
                dropdownClass: 'dropdown-menu show', // agar dropdown seperti bootstrap

            });
        </script>
    @endpush

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Tambah transaction</strong>
                    <p>Pada halaman tambah transaction, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
                        sistem.</p>
                </div>
            </div>

            <input class="form-control" list="penerimaList" id="penerimaInput" placeholder="Cari penerima...">
            <datalist id="penerimaList">
                <option value="Nakia Tillman">
                <option value="Garfield Johns DDS">
                <option value="Trystan McDermott PhD">
                <option value="Melisa Fadel III">
                <option value="Westley Heaney">
            </datalist>

            <div class="card-body">
                <form wire:submit="create">
                    @csrf
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah (Angka)</label>
                                <input type="number" class="form-control @error("amount") is-invalid @enderror"
                                    wire:model="amount" id="amount" aria-describedby="amountId"
                                    placeholder="Enter transaction amount" autocomplete="amount" />
                                @error("amount")
                                    <small id="amountId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error("date") is-invalid @enderror"
                                    wire:model="date" id="date" aria-describedby="dateId"
                                    placeholder="Enter transaction date" autocomplete="date" />
                                @error("date")
                                    <small id="dateId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select @error("category") is-invalid @enderror" wire:model="category"
                                    name="category" id="category">
                                    <option selected>Pilih Satu</option>
                                    <option value="debit">Uang Masuk</option>
                                    <option value="credit">Uang Keluar</option>
                                </select>
                                @error("category")
                                    <small id="categoryId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="recipient_id" class="form-label">Penerima</label>
                                <div wire:ignore>
                                    <select class="tom-select  @error("recipient_id") is-invalid @enderror"
                                        wire:model="recipient_id" name="recipient_id" id="recipient_id">
                                        <option selected disabled></option>
                                        @foreach ($recipients as $recipient)
                                            <option value="{{ $recipient->id }}">{{ $recipient->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @error("recipient_id")
                                    <small id="recipient_id" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea class="form-control @error("description") is-invalid @enderror" name="description" id="description"
                                    wire:model="description" rows="3"></textarea>
                                @error("description")
                                    <small id="descriptionId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
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
                </form>
            </div>
        </div>
    @endvolt
</x-app-layout>
