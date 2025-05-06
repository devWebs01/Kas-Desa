<x-app-layout>
    <x-slot name="title">Edit Pengaturan</x-slot>

    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route("home") }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route("settings.show") }}">Pengaturan</a></li>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route("settings.update") }}" method="POST">
                @csrf

                {{-- Nama Desa --}}
                <div class="mb-3">
                    <label class="form-label">Nama Aplikasi</label>
                    <input type="text" name="name" value="{{ old("name", $setting->name) }}"
                        class="form-control @error("name") is-invalid @enderror">
                    @error("name")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" rows="3" class="form-control @error("address") is-invalid @enderror">{{ old("address", $setting->address) }}</textarea>
                    @error("address")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Penanggung Jawab --}}
                <div class="mb-3">
                    <label class="form-label">Nama Penanggung Jawab</label>
                    <input type="text" name="responsible_person"
                        value="{{ old("responsible_person", $setting->responsible_person) }}"
                        class="form-control @error("responsible_person") is-invalid @enderror">
                    @error("responsible_person")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Signature Pad --}}

                <div class="mb-3">
                    <label class="form-label">Tanda Tangan Digital</label>

                    <!-- Jika tanda tangan sudah ada, tampilkan sebagai gambar -->
                    <div id="signature-container" class="mb-3"
                        style="display: {{ !empty($setting->signature) ? "block" : "none" }};">
                        <img id="signature-image"
                            src="{{ !empty($setting->signature) ? Storage::url($setting->signature) : "" }}"
                            class="img-fluid w-100 border">

                        @if (empty($setting->signature))
                            <button type="button" id="edit-signature" class="btn btn-primary my-2">Buat Tanda
                                Tangan</button>
                        @else
                            <div class="d-flex justify-content-between">
                                <button type="button" id="edit-signature" class="btn btn-warning my-2">Ubah Tanda
                                    Tangan</button>

                                <a class="btn btn-danger my-2" href="{{ route("signature.destroy") }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('signature-destroy').submit();">
                                    Hapus Tanda Tangan
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Signature Pad untuk menggambar ulang -->
                    <div id="signature-pad-container" class="mb-3"
                        style="display: {{ !empty($setting->signature) ? "none" : "block" }};">
                        <div class="rounded">
                            <canvas id="signature-pad" class="border w-100"
                                style="border: 2px dotted #CCCCCC; cursor: crosshair;"></canvas>
                        </div>
                        <input type="hidden" name="signature_data" id="signature-data">
                        <input type="hidden" name="signature_code" id="signature-code">

                        <div class="text-end">
                            <button type="button" id="clear-signature" class="btn btn-danger my-2">Reset</button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <form id="signature-destroy" action="{{ route("signature.destroy") }}" method="POST"
        onsubmit="return confirm('Apakah Anda yakin ingin menghapus tanda tangan?')">
        @csrf

    </form>

    @push("scripts")
        <!-- Signature Pad Library -->
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const canvas = document.getElementById("signature-pad");
                const ctx = canvas.getContext("2d");
                const signaturePad = new SignaturePad(canvas, {
                    minWidth: 1,
                    maxWidth: 3,
                    penColor: "black"
                });

                const clearButton = document.getElementById("clear-signature");
                const signatureInput = document.getElementById("signature-data");
                const signatureJsonInput = document.getElementById("signature-code");
                const signatureContainer = document.getElementById("signature-container");
                const signatureImage = document.getElementById("signature-image");
                const editSignatureButton = document.getElementById("edit-signature");
                const signaturePadContainer = document.getElementById("signature-pad-container");

                let savedSignatureJson = {!! json_encode($setting->signature_code) !!};

                // ✅ Tampilkan tanda tangan sebagai gambar jika ada
                if (signatureImage.src && signatureImage.src !== "") {
                    signatureContainer.style.display = "block";
                    signaturePadContainer.style.display = "none";
                }

                // ✅ Jika ada stroke tanda tangan di database, muat ulang
                function loadSavedSignature() {
                    if (savedSignatureJson && savedSignatureJson !== "null") {
                        signaturePad.fromData(JSON.parse(savedSignatureJson));
                    }
                }

                loadSavedSignature(); // Muat tanda tangan saat pertama kali halaman dibuka

                // 🔥 Fungsi untuk mereset ukuran canvas agar Signature Pad bisa digunakan kembali
                function resizeCanvas() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const width = canvas.offsetWidth;
                    const height = 300; // Tinggi 300px agar lebih fleksibel
                    canvas.width = width * ratio;
                    canvas.height = height * ratio;
                    ctx.scale(ratio, ratio);
                    signaturePad.clear(); // Bersihkan canvas agar ukuran sesuai
                }

                // **Tombol "Ubah Tanda Tangan"**
                editSignatureButton.addEventListener("click", function() {
                    signatureContainer.style.display = "none";
                    signaturePadContainer.style.display = "block";
                    signaturePad.clear(); // Bersihkan tanda tangan sebelumnya
                    resizeCanvas(); // Pastikan canvas sesuai
                    loadSavedSignature(); // Jika ada tanda tangan sebelumnya, muat ulang
                });

                // **Tombol "Hapus Tanda Tangan"**
                clearButton.addEventListener("click", function() {
                    signaturePad.clear();
                    signatureInput.value = "";
                    signatureJsonInput.value = "";
                });

                // **Simpan tanda tangan sebelum form disubmit**
                document.querySelector("form").addEventListener("submit", function() {
                    if (!signaturePad.isEmpty()) {
                        signatureInput.value = signaturePad.toDataURL("image/png"); // Simpan sebagai gambar
                        signatureJsonInput.value = JSON.stringify(signaturePad.toData()); // Simpan stroke JSON
                    }
                });

                window.addEventListener("resize", resizeCanvas);
                resizeCanvas();
            });
        </script>
    @endpush

</x-app-layout>
