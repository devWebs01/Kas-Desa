<?php

use App\Models\Item;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads};
use function Laravel\Folio\name;

usesFileUploads();

name("items.signature");

state(["item"]);

?>

<x-app-layout>
    <x-slot name="title">Tanda Tangan</x-slot>
    @include("layouts.signature-pad")
    @volt
        <div>
            <x-slot name="header">
                <li class="breadcrumb-item">
                    <a href="{{ route("home") }}">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a
                        href="{{ route("transactions.show", ["transaction" => $item->transaction]) }}">{{ $item->transaction->title }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">{{ $item->description }}</a>
                </li>
            </x-slot>

            @if (session("success"))
                <div class="alert alert-success">{{ session("success") }}</div>
            @endif

            <form action="{{ route("items.signature.save", $item) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" class="form-control" value="{{ $item->description }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nominal</label>
                    <input type="text" class="form-control" value="{{ formatRupiah($item->amount) }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Atas Nama</label>
                    <input type="text" class="form-control" name="authorized" value="{{ $item->authorized }}"
                        placeholder="Masukkan nama penanda tangan">

                    @error("authorized")
                        <small class="text-danger fw-bold">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Signature Pad -->
                <div id="signature-pad-container" class="mb-3">
                    <label class="form-label">Tanda Tangan</label>
                    <canvas id="signature-pad" class="border w-100"
                        style="border: 2px dotted #ccc; height: 300px;"></canvas>
                    <input type="hidden" name="signature_data" id="signature-data">
                    <input type="hidden" name="signature_code" id="signature-code">

                    @error("signature_data")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    @error("signature_code")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" id="clear-signature" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    @endvolt

</x-app-layout>
