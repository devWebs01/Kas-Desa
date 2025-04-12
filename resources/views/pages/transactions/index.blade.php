<?php

use App\Models\Transaction;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed};
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("transactions.index"); // Contoh: users.index atau posts.index

// Ambil data dari model, gunakan computed agar data direfresh secara otomatis
$transactions = computed(function () {
    return transaction::query()->latest()->get();
});

// Fungsi untuk menghapus data dengan try-catch
$destroy = function (Transaction $transaction) {
    try {
        $transaction->delete();
        LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();
        $this->redirectRoute("transactions.index");
    } catch (\Throwable $e) {
        // Logging error jika diperlukan
        \Illuminate\Support\Facades\Log::error("Error deleting transaction: " . $e->getMessage(), [
            "trace" => $e->getTraceAsString(),
        ]);
        LivewireAlert::text("Data gagal di proses.")->error()->toast()->show();
        $this->redirectRoute("transactions.index");
    }
};
?>

<x-app-layout>
    <x-slot name="title">Data Transaksi</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
    </x-slot>

    @include("layouts.datatables")

    @volt
        <div class="card">
            <div class="card-header">
                <a href="{{ route("transactions.create") }}" class="btn btn-primary">Tambah Transaksi</a>
            </div>
            <div class="card-body">
                <div class="table-responsive border rounded p-3">
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
                            @foreach ($this->transactions as $no => $item)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <!-- Ganti property sesuai model, misalnya: name, email, telp -->
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->telp }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route("transactions.edit", ["transaction" => $item->id]) }}"
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
