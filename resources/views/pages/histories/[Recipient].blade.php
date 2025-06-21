<?php

use App\Models\Recipient;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules};
use function Laravel\Folio\name;

name("recipients.history");

state([
    "transactions" => fn() => $this->recipient->transactions,
    "recipient",
]);

?>

<x-app-layout>
    <x-slot name="title">Riwayat Transaksi Penerima</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("recipients.index") }}">Penerima Dana</a></li>
        <li class="breadcrumb-item"><a href="#">Riwayat Transaksi</a></li>
    </x-slot>

    @include("components.partials.datatables")
    
    @volt
        <div class="card">
            <div class="card-body">

                <div class="table-responsive border rounded p-3">
                    <table class="table text-center text-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <!-- Sesuaikan kolom tabel sesuai atribut model -->
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $no => $item)
                                <tr>
                                    <td>
                                        {{ ++$no }}
                                    </td>
                                    <td>
                                        {{ $item->date }}
                                    </td>
                                    <td>
                                        {{ Str::limit($item->title, 35, "...") }}
                                    </td>
                                    <td>
                                        {{ $item->category }}
                                    </td>
                                    <td>
                                        {{ formatRupiah($item->amount) }}
                                    </td>
                                    <td>
                                        <a href="{{ route("transactions.invoice", $item->id) }}" target="blank"
                                            class="btn btn-sm btn-secondary">Invoice</a>
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
