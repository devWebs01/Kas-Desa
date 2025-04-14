<?php

use App\Models\Transaction;
use App\Models\Recipient;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use function Livewire\Volt\{state, rules, usesFileUploads, computed};
use function Laravel\Folio\name;

usesFileUploads();

name("transactions.create");

state(["recipient_id"])->url();

state([
    "recipients" => fn() => Recipient::get(),
    "title",
    "category",
    "amount",
    "invoice",
    "date",
    "description",
]);

state([
    "newRecipient" => false,
    "new_name",
    "new_phone",
    "signature", // base64 image
    "signature_code", // JSON signature
    "update_signature" => false,
]);

rules([
    "title" => ["required", "string"],
    "category" => ["required", "in:credit,debit"],
    "amount" => ["required", "numeric", "between:-999999.99,999999.99"],
    "invoice" => ["nullable", "string", "unique:transactions,invoice"],
    "date" => ["required", "date"],
    "description" => ["required", "string"],

    "recipient_id" => ["nullable", "exists:recipients,id"],
    "new_name" => ["nullable", "string", "required_without:recipient_id"],
    "new_phone" => ["nullable", "string", "required_without:recipient_id"],
    "signature" => ["nullable", "string", "required_with:new_name"],
    "signature_code" => ["nullable", "string", "required_with:new_name"],
]);

$showRecipient = computed(function () {
    // Jika isian berupa angka → anggap sebagai ID penerima yang sudah ada
    if (is_numeric($this->recipient_id)) {
        $this->newRecipient = false;
        return Recipient::find($this->recipient_id);
    }

    // Jika isian string (bukan angka) → anggap nama penerima baru
    if (!empty($this->recipient_id) && is_string($this->recipient_id)) {
        $this->newRecipient = true;
        $this->new_name = $this->recipient_id; // otomatis set ke input nama baru
        return null;
    }

    // Default
    $this->newRecipient = false;
    return null;
});

$create = function () {
    $this->validate();

    $recipientId = $this->recipient_id;

    // Jika membuat penerima baru
    if (!$recipientId && $this->new_name && $this->new_phone && $this->signature) {
        $filename = "signatures/" . uniqid() . ".png";
        $decoded = base64_decode(preg_replace("#^data:image/\w+;base64,#i", "", $this->signature));
        Storage::disk("public")->put($filename, $decoded);

        $recipient = Recipient::create([
            "name" => $this->new_name,
            "phone" => $this->new_phone,
            "signature" => $filename,
            "signature_code" => $this->signature_code,
        ]);

        $recipientId = $recipient->id;
    }

    // Jika update tanda tangan penerima yang sudah ada
    if ($this->recipient_id && $this->update_signature && $this->signature) {
        $filename = "signatures/" . uniqid() . ".png";
        $decoded = base64_decode(preg_replace("#^data:image/\w+;base64,#i", "", $this->signature));
        Storage::disk("public")->put($filename, $decoded);

        Recipient::whereId($this->recipient_id)->update([
            "signature" => $filename,
            "signature_code" => $this->signature_code,
        ]);
    }

    Transaction::create([
        "title" => $this->title,
        "category" => $this->category,
        "amount" => $this->amount,
        "invoice" => $this->invoice,
        "date" => $this->date,
        "description" => $this->description,
        "recipient_id" => $recipientId,
    ]);

    LivewireAlert::text("Transaksi berhasil disimpan.")->success()->toast()->show();

    $this->redirectRoute("transactions.index");
};

?>

<x-app-layout>
    <x-slot name="title">Tambah Transaksi Baru</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("transactions.index") }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a href="#">Tambah Transaksi</a></li>
    </x-slot>

    @volt
        @include("layouts.tom-select")
        @include("layouts.signature-pad")

        <div class="card">
            <div class="card-header">
                <div class="alert alert-primary" role="alert">
                    <strong>Tambah Transaksi</strong>
                    <p>Pada halaman tambah transaksi, kamu dapat memasukkan informasi dari data baru yang akan disimpan ke
                        sistem.</p>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit="create">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Transaksi</label>
                                <input type="text" class="form-control @error("title") is-invalid @enderror"
                                    wire:model="title" id="title" aria-describedby="titleId"
                                    placeholder="Enter transaction title" autofocus autocomplete="title" />
                                @error("title")
                                    <small id="titleId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah (Angka)</label>
                                <input type="number" class="form-control @error("amount") is-invalid @enderror"
                                    wire:model="amount" id="amount" aria-describedby="amountId"
                                    placeholder="Enter transaction amount" autocomplete="amount" />
                                @error("amount")
                                    <small id="amountId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error("date") is-invalid @enderror"
                                    wire:model="date" id="date" aria-describedby="dateId"
                                    placeholder="Enter transaction date" autocomplete="date" />
                                @error("date")
                                    <small id="dateId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select @error("category") is-invalid @enderror" wire:model="category"
                                    name="category" id="category">
                                    <option selected>Pilih Satu</option>
                                    <option value="debit">Uang Masuk</option>
                                    <option value="credit">Uang Keluar</option>
                                </select>
                                @error("category")
                                    <small id="categoryId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="recipient_id" class="form-label">Penerima</label>
                                <div wire:ignore>
                                    <select class="tom-select  @error("recipient_id") is-invalid @enderror"
                                        wire:model.live="recipient_id" name="recipient_id" id="tom-select">
                                        <option selected disabled></option>
                                        @foreach ($recipients as $recipient)
                                            <option value="{{ $recipient->id }}">{{ $recipient->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @error("recipient_id")
                                    <small id="recipient_id" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea class="form-control @error("description") is-invalid @enderror" name="description" id="description"
                                    wire:model="description" rows="3"></textarea>
                                @error("description")
                                    <small id="descriptionId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        @if ($this->showRecipient !== null)
                            <div class="mb-3">
                                <label class="form-label">Tanda Tangan Penerima</label>
                                <img src="{{ Storage::url($this->showRecipient->signature) }}" class="img-fluid"
                                    style="max-height: 300px;" />

                                <img src="{{ Storage::url($this->showRecipient->signature) }}"
                                    class="img-fluid rounded-top" alt="" />

                                {{ $this->showRecipient->signature }}

                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" wire:model.live="update_signature"
                                        id="update_signature">
                                    <label class="form-check-label" for="update_signature">Perbarui tanda tangan penerima
                                        ini</label>
                                </div>
                            </div>
                        @elseif ($update_signature === true)
                            <div class="mb-3">
                                <label class="form-label">Tanda Tangan Baru</label>
                                <canvas id="signature-pad" class="border w-100" style="height:300px;"></canvas>
                                <input type="hidden" wire:model.defer="signature" id="signature">
                                <input type="hidden" wire:model.defer="signature_code" id="signature-code">
                                <button type="button" class="btn btn-sm btn-danger mt-2"
                                    id="clear-signature">Clear</button>
                            </div>
                        @endif

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
