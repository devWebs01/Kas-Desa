<?php

use App\Models\Recipient;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

name("recipients.edit");

state([
    "recipient", // instance recipient yang akan diedit
    "contoh1", // properti contoh1 dari recipient
    "contoh2", // properti contoh2 dari recipient
]);

rules([
    "contoh1" => "required",
    "contoh2" => "required",
    // tambahkan validasi lain sesuai kebutuhan properti recipient Anda
]);

$edit = function () {
    $recipient = $this->recipient;
    $validateData = $this->validate();

    $recipient->update($validateData);

    LivewireAlert::title("Berhasil")->text("Data berhasil di proses.")->success()->show();

    $this->redirectRoute("recipients.index");
};
?>

<x-app-layout>
    <x-slot name="title">Edit Penerima</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("recipients.index") }}">Penerima Dana</a></li>
        <li class="breadcrumb-item"><a href="#">Edit Penerima</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit recipient</strong>
                    <p>Pada halaman edit recipient, kamu dapat mengubah informasi data yang sudah ada.</p>
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
                                    placeholder="Enter recipient contoh1" autofocus autocomplete="contoh1" />
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
                                    placeholder="Enter recipient contoh2" />
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
