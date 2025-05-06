<?php

use App\Models\Recipient;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed};
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("recipients.index"); // Contoh: users.index atau posts.index

// Ambil data dari model, gunakan computed agar data direfresh secara otomatis
$recipients = computed(function () {
    return recipient::query()->latest()->get();
});

// Fungsi untuk menghapus data dengan try-catch
$destroy = function (recipient $recipient) {
    try {
        $recipient->delete();
        LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();
        $this->redirectRoute("recipients.index");
    } catch (\Throwable $e) {
        // Logging error jika diperlukan
        \Illuminate\Support\Facades\Log::error("Error deleting recipient: " . $e->getMessage(), [
            "trace" => $e->getTraceAsString(),
        ]);
        LivewireAlert::text("Data gagal di proses.")->error()->toast()->show();
        $this->redirectRoute("recipients.index");
    }
};
?>

<x-app-layout>
    <x-slot name="title">Data Penerima</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("recipients.index") }}">Penerima Dana</a></li>
    </x-slot>

    @include("layouts.datatables")

    @volt
        <div class="card">
            <div class="card-header">
                <a href="{{ route("recipients.create") }}" class="btn btn-primary">Tambah Penerima</a>
            </div>

            <div class="card-body">
                <div class="table-responsive border rounded p-3">
                    <table class="table text-center text-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <!-- Sesuaikan kolom tabel sesuai atribut model -->
                                <th>Nama</th>
                                <th>Telephone</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->recipients as $no => $item)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <!-- Ganti property sesuai model, misalnya: name, email, telp -->
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route("recipients.edit", ["recipient" => $item->id]) }}"
                                                class="btn btn-sm btn-warning">Edit</a>

                                            <a href="{{ route("recipients.history", ["recipient" => $item->id]) }}"
                                                class="btn btn-sm btn-secondary">Riwayat</a>

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
