<?php

use App\Models\Recipient;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules};
use function Laravel\Folio\name;

name("recipients.edit");

state([
    "name" => fn() => $this->recipient->name,
    "phone" => fn() => $this->recipient->phone,
    "recipient",
]);

rules([
    "name" => ["required", "string", "min:3"],
    "phone" => ["required", "string", 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
]);

$create = function () {
    $validateData = $this->validate();

    $recipient = $this->recipient;

    $recipient->update($validateData);

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

    $this->redirectRoute("recipients.index");
};

?>

<x-app-layout>
    <x-slot name="title">Tambah Penerima Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("recipients.index") }}">Penerima Dana</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Penerima Dana</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Tambah recipient</strong>
                    <p>Pada halaman tambah recipient, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
                        sistem.</p>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit="create">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error("name") is-invalid @enderror"
                                    wire:model="name" id="name" aria-describedby="nameId"
                                    placeholder="Enter recipient name" autofocus autocomplete="name" />
                                @error("name")
                                    <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telephone</label>
                                <input type="number" class="form-control @error("phone") is-invalid @enderror"
                                    wire:model="phone" id="phone" aria-describedby="phoneId"
                                    placeholder="Enter recipient phone" />
                                @error("phone")
                                    <small id="phoneId" class="form-text text-danger">{{ $message }}</small>
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
