<?php

use App\Models\Category;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed};
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("categories.index"); // Contoh: users.index atau posts.index

// Ambil data dari model, gunakan computed agar data direfresh secara otomatis
$categories = computed(function () {
    return category::query()->latest()->get();
});

// Fungsi untuk menghapus data dengan try-catch
$destroy = function (category $category) {
    try {
        $category->delete();
        LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();
        $this->redirectRoute("categories.index");
    } catch (\Throwable $e) {
        // Logging error jika diperlukan
        \Illuminate\Support\Facades\Log::error("Error deleting category: " . $e->getMessage(), [
            "trace" => $e->getTraceAsString(),
        ]);
        LivewireAlert::text("Data gagal di proses.")->error()->toast()->show();
        $this->redirectRoute("categories.index");
    }
};
?>

<x-app-layout>
    <x-slot name="title">Data category</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("categories.index") }}">Kategori</a></li>
    </x-slot>

    @include("layouts.datatables")

    @volt
        <div class="card">
            <div class="card-body">
                <a href="{{ route("categories.create") }}" class="btn btn-primary mb-3">Tambah Kategori</a>
                <div class="table-responsive border rounded p-3">
                    <table class="table text-center text-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <!-- Sesuaikan kolom tabel sesuai atribut model -->
                                <th>Nama Kategori</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->categories as $no => $item)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <!-- Ganti property sesuai model, misalnya: name, email, telp -->
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route("categories.edit", ["category" => $item->id]) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button wire:loading.attr="disabled" wire:click="destroy({{ $item->id }})"
                                                wire:confirm="Apakah kamu yakin ingin menghapus data ini?"
                                                class="btn btn-sm btn-danger">
                                                {{ __("Hapus") }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
