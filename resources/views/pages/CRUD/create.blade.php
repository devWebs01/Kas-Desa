<?php

use App\Models\modelName;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads};
use function Laravel\Folio\name;

usesFileUploads();

name("modelNames.create");

state(["name", "email", "password", "identity", "avatar", "role"]);

rules([
    "name" => "required",
    "email" => "required|email",
    "password" => "required|min:6",
    "identity" => "required",
    "avatar" => "nullable|image",
    "role" => "required",
]);

$create = function () {
    $validateData = $this->validate();

    if (!empty($this->avatar)) {
        $validateData["avatar"] = $this->avatar->store("public/avatar");
    }

    $validateData["password"] = bcrypt($this->password);

    modelName::create($validateData);

    $this->reset();

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

    $this->redirectRoute("modelNames.index");
};

?>

<x-app-layout>
    <x-slot name="title">Tambah modelName Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("modelNames.index") }}">modelName</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah modelName</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Tambah modelName</strong>
                    <p>Pada halaman tambah modelName, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
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
                                    placeholder="Enter modelName name" autofocus autocomplete="name" />
                                @error("name")
                                    <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error("email") is-invalid @enderror"
                                    wire:model="email" id="email" aria-describedby="emailId"
                                    placeholder="Enter modelName email" />
                                @error("email")
                                    <small id="emailId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" class="form-control @error("password") is-invalid @enderror"
                                    wire:model="password" id="password" aria-describedby="passwordId"
                                    placeholder="Enter modelName password" />
                                @error("password")
                                    <small id="passwordId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="identity" class="form-label">NIK/No. Identitas</label>
                                <input type="number" class="form-control @error("identity") is-invalid @enderror"
                                    wire:model="identity" id="identity" aria-describedby="identityId"
                                    placeholder="Enter modelName identity" />
                                @error("identity")
                                    <small id="identityId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Foto Profil</label>
                                <input type="file" class="form-control @error("avatar") is-invalid @enderror"
                                    wire:model="avatar" id="avatar" accept="image/*" />
                                @error("avatar")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Hak Akses</label>
                                <select class="form-select @error("role") is-invalid @enderror" wire:model="role"
                                    id="role">
                                    <option selected>Pilih Satu</option>
                                    <option value="ADMIN">admin</option>
                                    <option value="BENDAHARA">bendahara</option>
                                </select>
                                @error("role")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md">
                            <button type="submit" class="btn btn-dark">Simpan</button>
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
