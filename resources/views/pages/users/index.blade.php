<?php

use App\Models\User;
use function Laravel\Folio\name;
use function Livewire\Volt\{computed};
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

name("users.index");

$users = computed(function () {
    return user::query()->latest()->get();
});

$destroy = function (user $user) {
    try {
        $user->delete();
        LivewireAlert::text("Data berhasil di proses.")->success()->toast()->show();

        $this->redirectRoute("users.index");
    } catch (\Throwable $th) {
        LivewireAlert::text("Data gagal di proses.")->success()->toast()->show();
        $this->redirectRoute("users.index");
    }
};

?>

<x-app-layout>
    <div>
        <x-slot name="title">Data Akun</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>

            <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Akun Pengguna</a></li>
        </x-slot>
        @include("layouts.datatables")
        @volt
            <div class="card">
                <div class="card-body">
                    <a href="{{ route("users.create") }}" class="btn btn-primary mb-3">Tambah
                        Akun</a>
                    <div class="table-responsive border rounded p-3">
                        <table class="table text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telp</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->users as $no => $item)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->telp }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ route("users.edit", ["user" => $item->id]) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <button wire:loading.attr='disabled'
                                                    wire:click='destroy({{ $item->id }})'
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

    </div>
</x-app-layout>
