<?php

use App\Models\category;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads};
use function Laravel\Folio\name;

usesFileUploads();

name("categories.create");

state(["name", "email", "password", "identity", "avatar", "role"]);

rules([
    "name" => "required|min:5",
]);

$create = function () {
    $validateData = $this->validate();

    category::create($validateData);

    $this->reset();

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

    $this->redirectRoute("categories.index");
};

?>

<x-app-layout>
    <x-slot name="title">Tambah Kategori Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("categories.index") }}">Kategori</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Kategori</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Tambah Kategori</strong>
                    <p>Pada halaman tambah Kategori, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
                        sistem.</p>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit="create">
                    @csrf
                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control @error("name") is-invalid @enderror"
                                    wire:model="name" id="name" aria-describedby="nameId"
                                    placeholder="Enter category name" autofocus autocomplete="name" />
                                @error("name")
                                    <small id="nameId" class="form-text text-danger">{{ $message }}</small>
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
