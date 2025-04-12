<?php

use App\Models\Transaction;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

name("transactions.edit");

state([
    "title" => fn() => $this->transaction->invoice,
    "category" => fn() => $this->transaction->invoice,
    "amount" => fn() => $this->transaction->invoice,
    "invoice" => fn() => $this->transaction->invoice,
    "date" => fn() => $this->transaction->invoice,
    "description" => fn() => $this->transaction->invoice,
    "recipient_id" => fn() => $this->transaction->invoice,
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

    LivewireAlert::title("Berhasil")->text("Data berhasil di proses.")->success()->show();

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
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="contoh1" class="form-label">Contoh1</label>
                                <input type="text" class="form-control @error("contoh1") is-invalid @enderror"
                                    wire:model="contoh1" id="contoh1" aria-describedby="contoh1Id"
                                    placeholder="Enter transaction contoh1" autofocus autocomplete="contoh1" />
                                @error("contoh1")
                                    <small id="contoh1Id" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="contoh2" class="form-label">Contoh2</label>
                                <input type="text" class="form-control @error("contoh2") is-invalid @enderror"
                                    wire:model="contoh2" id="contoh2" aria-describedby="contoh2Id"
                                    placeholder="Enter transaction contoh2" />
                                @error("contoh2")
                                    <small id="contoh2Id" class="form-text text-danger">{{ $message }}</small>
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
