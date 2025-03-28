<?php

use App\Models\User;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\Log; // Pastikan Log di-import
use function Livewire\Volt\{state, rules, usesFileUploads};
use function Laravel\Folio\name;

usesFileUploads();

name("users.edit");

state([
    "name" => fn() => $this->user->name,
    "email" => fn() => $this->user->email,
    "identity" => fn() => $this->user->identity,
    "role" => fn() => $this->user->role,
    "avatar",
    "password",
    "user",
]);

rules([
    "name" => "required",
    "email" => "required|email",
    "identity" => "required",
    "role" => "required",
    "password" => "nullable|min:6",
    "avatar" => "nullable|image|max:2048",
]);

$update = function () {
    try {
        $validateData = $this->validate();

        Log::info("Mulai memperbarui data pengguna", ["user" => $this->user]);

        // Ambil data user dari model (asumsikan $this->user sudah merupakan model,
        // namun jika belum, gunakan id atau metode yang sesuai)
        $user = User::findOrFail($this->user->id);

        if ($this->avatar) {
            $validateData["avatar"] = $this->avatar->store("public/avatar");
        } else {
            $validateData["avatar"] = $this->user->avatar;
        }

        if ($this->password) {
            $validateData["password"] = bcrypt($this->password);
        } else {
            $validateData["password"] = $this->user->password;
        }

        $user->update($validateData);

        Log::info("Pengguna berhasil diperbarui", ["user_id" => $user->id]);

        LivewireAlert::text("Data berhasil diperbarui.")->success()->toast()->show();

        $this->redirectRoute("users.index");
    } catch (\Exception $e) {
        Log::error("Terjadi kesalahan saat memperbarui data pengguna", [
            "error" => $e->getMessage(),
            "trace" => $e->getTraceAsString(),
        ]);

        LivewireAlert::text("Terjadi kesalahan saat memperbarui data.")->error()->toast()->show();
    }
};

?>

<x-app-layout>
    <x-slot name="title">Edit User</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Akun Pengguna</a></li>
        <li class="breadcrumb-item"><a href="#">Edit Akun</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit akun pengguna</strong>
                    <p>Perbarui informasi akun pengguna.</p>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit="update">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error("name") is-invalid @enderror"
                                    wire:model="name" id="name" placeholder="Enter user name" autofocus />
                                @error("name")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error("email") is-invalid @enderror"
                                    wire:model="email" id="email" placeholder="Enter user email" />
                                @error("email")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi (Kosongkan jika tidak ingin
                                    mengubah)</label>
                                <input type="password" class="form-control @error("password") is-invalid @enderror"
                                    wire:model="password" id="password" placeholder="Enter new password" />
                                @error("password")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="identity" class="form-label">NIK/No. Identitas</label>
                                <input type="number" class="form-control @error("identity") is-invalid @enderror"
                                    wire:model="identity" id="identity" placeholder="Enter user identity" />
                                @error("identity")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Foto Profil (Opsional)</label>
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
                                    <option selected disabled>Pilih Satu</option>
                                    <option value="ADMIN">Admin</option>
                                    <option value="BENDAHARA">Bendahara</option>
                                </select>
                                @error("role")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md">
                            <button type="submit" class="btn btn-dark">Update</button>
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
