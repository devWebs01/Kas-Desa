<?php

use function Laravel\Folio\name;

name("recipients.create"); // Contoh: users.index atau posts.index ?>

<x-app-layout>
    <x-slot name="title">Tambah Penerima Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("recipients.index") }}">Penerima Dana</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Penerima Dana</a></li>
    </x-slot>

    @volt
        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Tambah Penerima</strong>
                    <p>Pada halaman tambah penerima, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
                        sistem.</p>
                </div>
            </div>

            @include("layouts.signature-pad")

            <div class="card-body">
                <form method="post" action="{{ route("recipients.store") }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error("name") is-invalid @enderror"
                                    name="name" id="name" aria-describedby="nameId"
                                    placeholder="Enter recipient name" autofocus autocomplete="name" />
                                @error("name")
                                    <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telephone</label>
                                <input type="number" class="form-control @error("phone") is-invalid @enderror"
                                    name="phone" id="phone" aria-describedby="phoneId"
                                    placeholder="Enter recipient phone" />
                                @error("phone")
                                    <small id="phoneId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Signature Area -->
                        <div class="mb-3">
                            <label class="form-label">Tanda Tangan</label>
                            <div wire:ignore>
                                <div class="border rounded" style="border: 2px dotted #CCCCCC;">
                                    <canvas id="signature-pad" style="width: 100%; height: 300px;"
                                        name="signature"></canvas>
                                </div>

                                <div class="mt-2 text-end">
                                    <button type="button" id="clear-signature" class="btn btn-danger btn-sm">Hapus</button>
                                </div>

                                <!-- Field yang dikirim ke Livewire -->
                                <input type="hidden" name="signature" id="signature">
                                <input type="hidden" name="signature_code" id="signature-code">
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
