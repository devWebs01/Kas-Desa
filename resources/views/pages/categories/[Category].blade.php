<?php

use App\Models\Category;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

name("categories.edit");

state([
    "category", // instance category yang akan diedit
    "name" => fn() => $this->category->name,
]);

rules([
    "name" => "required|min:5",
]);

$edit = function () {
    $category = $this->category;
    $validateData = $this->validate();

    $category->update($validateData);

    LivewireAlert::title("Berhasil")->text("Data berhasil di proses.")->success()->show();

    $this->redirectRoute("categories.index");
};
?>

<x-app-layout>
    <x-slot name="title">Edit category</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("categories.index") }}">Kategori</a></li>
        <li class="breadcrumb-item"><a href="#">Edit Kategori</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit Kategori</strong>
                    <p>Pada halaman edit kategori, kamu dapat mengubah informasi data yang sudah ada.</p>
                </div>
            </div>
            <div class="card-body">
                <form wire:submit="edit">
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
                            <button type="submit" class="btn btn-primary">
                                Update
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
