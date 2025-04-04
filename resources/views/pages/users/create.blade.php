<?php

use App\Models\user;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads};
use function Laravel\Folio\name;

usesFileUploads();

name("users.create");

state(["name", "email", "password", "identity", "avatar", "role"]);

rules([
    "name" => "required",
    "email" => "required|email",
    "password" => "required|min:6",
    "identity" => "required",
    "avatar" => "nullable|image",
    "role" => "required|in:ADMIN,BENDAHARA",
]);

$store = function () {
    $validateData = $this->validate();

    if ($this->avatar) {
        $validateData["avatar"] = $this->avatar->store("public/avatar");
    }

    $validateData["password"] = bcrypt($this->password);

    user::create($validateData);

    $this->reset();

    LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

    $this->redirectRoute("users.index");
};

?>

<x-app-layout>
    <x-slot name="title">Tambah user Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Akun Pengguna</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Akun</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Tambah akun pengguna</strong>
                    <p>Pada halaman tambah akun pengguna, kamu dapat memasukkan informasi dari akun pengguna baru yang akan
                        disimpan ke sistem.
                    </p>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit="store">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">nama lengkap</label>
                                <input type="text" class="form-control @error("name") is-invalid @enderror"
                                    wire:model="name" id="name" aria-describedby="nameId" placeholder="Enter user name"
                                    autofocus autocomplete="name" />
                                @error("name")
                                    <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">email</label>
                                <input type="email" class="form-control @error("email") is-invalid @enderror"
                                    wire:model="email" id="email" aria-describedby="emailId"
                                    placeholder="Enter user email" />
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
                                    placeholder="Enter user password" />
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
                                    placeholder="Enter user identity" />
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
                                <select
                                    class="form-select @error("role")
                                    is-invalid
                                @enderror"
                                    name="role" id="role" wire:model="role">
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
                            <button type="submit" class="btn btn-primary">
                                Simpan
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
