<?php

use App\Models\modelName;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed};
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("modelName.index"); // Contoh: users.index atau posts.index

// Ambil data dari model, gunakan computed agar data direfresh secara otomatis
$modelName = computed(function () {
    return modelName::query()->latest()->get();
});

// Fungsi untuk menghapus data dengan try-catch
$destroy = function (modelName $modelName) {
    try {
        $modelName->delete();
        LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();
        $this->redirectRoute("modelName.index");
    } catch (\Throwable $e) {
        // Logging error jika diperlukan
        \Illuminate\Support\Facades\Log::error("Error deleting modelName: " . $e->getMessage(), [
            "trace" => $e->getTraceAsString(),
        ]);
        LivewireAlert::text("Data gagal di proses.")->error()->toast()->show();
        $this->redirectRoute("modelName.index");
    }
};
?>

<x-app-layout>
    <x-slot name="title">Data modelName</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("modelName.index") }}">modelName</a></li>
    </x-slot>

    @include("layouts.datatables")

    @volt
        <div class="card">
            <div class="card-body">
                <a href="{{ route("modelName.create") }}" class="btn btn-dark">Tambah modelName</a>
                <div class="table-responsive border rounded px-3">
                    <table class="table text-center text-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <!-- Sesuaikan kolom tabel sesuai atribut model -->
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modelName as $no => $item); ?>
                            <tr>
                                <td>{{ ++$no }}</td>
                                <!-- Ganti property sesuai model, misalnya: name, email, telp -->
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->telp }}</td>
                                <td>
                                    <div>
                                        <a href="{{ route("modelName.edit", ["modelName" => $item->id]) }}"
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
