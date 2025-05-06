@push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 2.5,
                penColor: 'black'
            });

            const inputImage = document.getElementById('signature');
            const inputJson = document.getElementById('signature-code');
            const clearBtn = document.getElementById('clear-signature');

            // Resize canvas to match container
            function resizeCanvas() {
                const ratio = window.devicePixelRatio || 1;
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = 300 * ratio;

                const ctx = canvas.getContext("2d");
                ctx.setTransform(1, 0, 0, 1, 0, 0); // ✅ Reset transform sebelum scaling
                ctx.scale(ratio, ratio);

                signaturePad.clear(); // ✅ Clear setelah scaling
            }


            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            // Clear button
            clearBtn.addEventListener('click', function() {
                signaturePad.clear();
                inputImage.value = '';
                inputJson.value = '';
                resizeCanvas(); // 🔁 Paksa canvas untuk refresh total
            });

            // Save when submit
            document.querySelector('form').addEventListener('submit', function() {
                if (!signaturePad.isEmpty()) {
                    inputImage.value = signaturePad.toDataURL();
                    inputJson.value = JSON.stringify(signaturePad.toData());
                }
            });
        });
    </script>
@endpush
