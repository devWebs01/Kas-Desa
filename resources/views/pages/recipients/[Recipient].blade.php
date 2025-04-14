<?php

use App\Models\Recipient;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, uses};
use function Laravel\Folio\name;

name("recipients.edit");

state([
    "recipient", // instance recipient yang akan diedit
]);

?>

<x-app-layout>
    <x-slot name="title">Edit Penerima</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("recipients.index") }}">Penerima Dana</a></li>
        <li class="breadcrumb-item"><a href="#">Edit Penerima</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Edit Penerima</strong>
                    <p>Pada halaman edit penerima, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
                        sistem.</p>
                </div>
            </div>

            @include("layouts.signature-pad")

            <div class="card-body">
                <form method="post" action="{{ route("recipients.update", $recipient->id) }}">
                    @method("put")

                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error("name") is-invalid @enderror"
                                    name="name" id="name" value="{{ old("name", $recipient->name) }}"
                                    placeholder="Enter recipient name" autofocus autocomplete="name" />
                                @error("name")
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telephone</label>
                                <input type="number" class="form-control @error("phone") is-invalid @enderror"
                                    name="phone" id="phone" aria-describedby="phoneId"
                                    value="{{ old("phone", $recipient->phone) }}" placeholder="Enter recipient phone" />
                                @error("phone")
                                    <small id="phoneId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Signature Area -->
                        <div class="mb-3">
                            <label class="form-label">Tanda Tangan Baru (kosongkan jika tidak ingin diubah)</label>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-signature-old-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-signature-old" type="button" role="tab"
                                        aria-controls="pills-signature-old" aria-selected="true">Tanda tangan lama</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-signature-new-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-signature-new" type="button" role="tab"
                                        aria-controls="pills-signature-new" aria-selected="false">Buat tanda tangan
                                        baru</button>
                                </li>

                            </ul>
                            <div class="tab-content p-0" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-signature-old" role="tabpanel"
                                    aria-labelledby="pills-signature-old-tab">
                                    <div class="border rounded">
                                        @if ($recipient->signature)
                                            <img src="{{ Storage::url($recipient->signature) }}" alt="Signature"
                                                style="max-width: 100%; height: auto;">
                                        @else
                                            <div style="height: 300px;" class="bg-secondary position-relative">
                                                <div
                                                    class="position-absolute top-50 start-50 translate-middle h5 text-white">
                                                    Tanda Tangan
                                                    Tidak ditemukan
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-signature-new" role="tabpanel"
                                    aria-labelledby="pills-signature-new-tab">
                                    <div class="border rounded" style="border: 2px dotted #CCCCCC;">
                                        <canvas id="signature-pad" style="width: 100%; height: 300px;"></canvas>
                                    </div>

                                    <div class="mt-2 text-end">
                                        <button type="button" id="clear-signature"
                                            class="btn btn-danger btn-sm">Hapus</button>
                                    </div>

                                    <input type="hidden" name="signature" id="signature">
                                    <input type="hidden" name="signature_code" id="signature-code">
                                </div>
                            </div>

                            @error("signature")
                                <small id="signatureId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                            @error("signature_code")
                                <small id="signature_codeId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md">
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
