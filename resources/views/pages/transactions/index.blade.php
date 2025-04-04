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
$destroy = function (transaction $transaction) {
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
            <div class="card-body">
                <a href="{{ route("transactions.create") }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
                <div class="table-responsive border rounded p-3">
                    <table class="table text-center text-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <!-- Sesuaikan kolom tabel sesuai atribut model -->
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->transactions as $no => $item)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <!-- Ganti property sesuai model, misalnya: name, email, telp -->
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route("transactions.show", ["transaction" => $item->id]) }}"
                                                class="btn btn-sm btn-warning">Lihat</a>
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
