<?php

use App\Models\modelName;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

name("modelNames.edit");

state([
    "modelName", // instance modelName yang akan diedit
    "contoh1", // properti contoh1 dari modelName
    "contoh2", // properti contoh2 dari modelName
]);

rules([
    "contoh1" => "required",
    "contoh2" => "required",
    // tambahkan validasi lain sesuai kebutuhan properti modelName Anda
]);

$edit = function () {
    $modelName = $this->modelName;
    $validateData = $this->validate();

    $modelName->update($validateData);

    LivewireAlert::title("Berhasil")->text("Data berhasil di proses.")->success()->show();

    $this->redirectRoute("modelNames.index");
};
?>

<x-app-layout>
    <x-slot name="title">Edit modelName</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("modelNames.index") }}">modelName</a></li>
        <li class="breadcrumb-item"><a href="#">Edit modelName</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit modelName</strong>
                    <p>Pada halaman edit modelName, kamu dapat mengubah informasi data yang sudah ada.</p>
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
                                    placeholder="Enter modelName contoh1" autofocus autocomplete="contoh1" />
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
                                    placeholder="Enter modelName contoh2" />
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
