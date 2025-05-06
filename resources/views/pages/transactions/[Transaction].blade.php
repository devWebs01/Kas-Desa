<?php

use App\Models\Recipient;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, computed, mount};
use function Laravel\Folio\name;
use Illuminate\Validation\Rule;

name("transactions.edit");

state([
    "recipients" => fn() => Recipient::get(),

    "title" => fn() => $this->transaction->title,
    "category" => fn() => $this->transaction->category,
    "amount" => fn() => $this->transaction->amount,
    "date" => fn() => Carbon\Carbon::parse($this->transaction->date)->format("Y-m-d"),
    "description" => fn() => $this->transaction->description,

    "phone",
    "transaction",
    "recipient_id",
]);

mount(function () {
    $this->recipient_id = $this->transaction->recipient_id;
    $this->phone = $this->transaction->recipient->phone;
});

$showRecipient = computed(function () {
    if (is_numeric($this->recipient_id)) {
        return Recipient::find($this->recipient_id);
    } else {
        return null;
    }
});

rules([
    "title" => ["required", "string"],
    "category" => ["required", "in:credit,debit"],
    "amount" => ["required", "numeric", "between:-999999.99,999999.99"],
    "date" => ["required", "date"],
    "description" => ["required", "string"],
    "recipient_id" => ["required"],
    "phone" => ["required", "string", "regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/"],
]);

$edit = function () {
    $transaction = $this->transaction;

    $validated = $this->validate();

    // Cek apakah recipient_id adalah angka atau nama baru
    if (!is_numeric($validated["recipient_id"])) {
        // Buat recipient baru
        $newRecipient = Recipient::create([
            "name" => $validated["recipient_id"],
            "phone" => $validated["phone"],
        ]);

        // Set recipient_id dengan ID yang baru dibuat
        $validated["recipient_id"] = $newRecipient->id;
    }

    $transaction->update($validated);

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

    $this->redirectRoute("transactions.index");
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
        @include("components.partials.tom-select")

        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit Transaksi</strong>
                    <p>Pada halaman edit transaksi, kamu dapat mengubah informasi data yang sudah ada.</p>
                </div>
            </div>

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

            <div class="card-body">
                <form wire:submit="edit">
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
                                        wire:model.live="recipient_id" name="recipient_id" id="tom-select">
                                        <option value=" ">Pilih Penerima</option>
                                        @foreach ($recipients as $recipient)
                                            <option {{ $recipient->id !== $recipient_id ?: "selected" }}
                                                value="{{ $recipient->id }}">{{ $recipient->name }}</option>
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
                                <label for="phone" class="form-label">No. Telephone</label>
                                <input type="text" class="form-control" wire:model="phone" name="phone" id="phone"
                                    aria-describedby="phoneId" value="{{ $this->showRecipient->phone ?? "" }}"
                                    placeholder="phone" />
                                @error("phone")
                                    <small id="phone" class="form-text text-danger">{{ $message }}</small>
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
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
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
