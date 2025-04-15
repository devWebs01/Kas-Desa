<?php

use App\Models\Setting;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

name("settings.edit");

state([
    "setting", // instance setting yang akan diedit
    "name",
    "address",
]);

rules([
    "name" => "required|min:5",
    "address" => "required|min:5",
]);

$edit = function () {
    $setting = $this->setting;
    $validateData = $this->validate();

    $setting->update($validateData);

    LivewireAlert::title("Berhasil")->text("Data berhasil di proses.")->success()->show();

    $this->redirectRoute("settings.index");
};
?>

<x-app-layout>
    <x-slot name="title">Edit setting</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("settings.index") }}">setting</a></li>
        <li class="breadcrumb-item"><a href="#">Edit setting</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit setting</strong>
                    <p>Pada halaman edit setting, kamu dapat mengubah informasi data yang sudah ada.</p>
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
                                    placeholder="Enter setting contoh1" autofocus autocomplete="contoh1" />
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
                                    placeholder="Enter setting contoh2" />
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
