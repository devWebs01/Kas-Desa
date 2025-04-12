<?php

use App\Models\Recipient;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

name("transactions.edit");

state([
    "recipients" => fn() => Recipient::get(),

    "title" => fn() => $this->transaction->title,
    "category" => fn() => $this->transaction->category,
    "amount" => fn() => $this->transaction->amount,
    "invoice" => fn() => $this->transaction->invoice,
    "date" => fn() => Carbon\Carbon::parse($this->transaction->date)->format("Y-m-d"),
    "description" => fn() => $this->transaction->description,
    "recipient_id" => fn() => $this->transaction->recipient_id,
    "transaction",
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

$edit = function () {
    $transaction = $this->transaction;

    $validateData = $this->validate();

    $transaction->update($validateData);

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

    $this->redirectRoute("transactions.index");
};
?>

<x-app-layout>
    <x-slot name="title">Edit transaction</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">transaction</a></li>
        <li class="breadcrumb-item"><a href="#">Edit transaction</a></li>
    </x-slot>

    @volt
        @include("layouts.tom-select")

        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit transaction</strong>
                    <p>Pada halaman edit transaction, kamu dapat mengubah informasi data yang sudah ada.</p>
                </div>
            </div>

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
                                        wire:model="recipient_id" name="recipient_id" id="recipient_id">
                                        <option selected disabled></option>
                                        @foreach ($recipients as $recipient)
                                            <option {{ $recipient->id !== $recipient_id ? :'selected' }} value="{{ $recipient->id }}">{{ $recipient->name }}</option>
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
