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

            const signatureInput = document.getElementById("signature-data");
            const signatureCodeInput = document.getElementById("signature-code");

            // Fungsi resize canvas untuk high-DPI device
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = 300 * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            // Lakukan resize sebelum inisialisasi
            resizeCanvas();

            // Muat data signature yang sudah tersimpan (jika ada)
            let savedSignatureJson = {!! json_encode($item->signature_code) !!};
            if (savedSignatureJson && savedSignatureJson !== "null") {
                try {
                    let data = JSON.parse(savedSignatureJson);
                    signaturePad.fromData(data);
                } catch (error) {
                    console.error("Gagal memuat tanda tangan:", error);
                }
            }

            // Event resize window
            window.addEventListener("resize", () => {
                const data = signaturePad.toData();
                resizeCanvas();
                signaturePad.clear();
                signaturePad.fromData(data);
            });

            // Tombol Reset
            document.getElementById("clear-signature").addEventListener("click", function() {
                signaturePad.clear();
                signatureInput.value = "";
                signatureCodeInput.value = "";
            });

            // Sebelum form disubmit, simpan data signature ke input hidden
            document.querySelector("form").addEventListener("submit", function() {
                if (!signaturePad.isEmpty()) {
                    signatureInput.value = signaturePad.toDataURL("image/png");
                    signatureCodeInput.value = JSON.stringify(signaturePad.toData());
                }
            });
        });
    </script>