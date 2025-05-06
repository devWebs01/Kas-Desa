   @push("styles")
       <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.css" rel="stylesheet">
       <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>

       <style>
           .ts-wrapper {
               width: 100%;
           }

           .ts-wrapper .ts-control {
               height: calc(2.375rem + 2px);
               padding: 0.375rem 0.75rem;
               font-size: 1rem;
               line-height: 1.5;
               color: #212529;
               background-color: #fff;
               border: 1px solid #ced4da;
               border-radius: 0.375rem;
               transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
           }

           .ts-wrapper .ts-control.focus {
               border-color: #86b7fe;
               outline: 0;
               box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
           }

           .ts-dropdown {
               border: 1px solid #ced4da;
               border-radius: 0.375rem;
               box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, .15);
           }

           .ts-wrapper .dropdown-menu {
               width: 100% !important;
               min-width: 100% !important;
               box-sizing: border-box;
           }

           .option,
           .create.active,
           .no-results {
               padding: 10px;
           }

           /* Saat item di-hover */
           .ts-wrapper .dropdown-menu .option:hover {
               background-color: #0d6efd !important;
               /* warna biru Bootstrap */
               color: #fff !important;
           }

           /* Saat item aktif (selected/focus) */
           .ts-wrapper .dropdown-menu .active {
               background-color: #0d6efd !important;
               color: #fff !important;
           }
       </style>
   @endpush

   @push("scripts")
       <script>
           function initTomSelect() {
               new TomSelect("#tom-select", {
                   persist: false,
                   createOnBlur: true,
                   create: true,
                   placeholder: "Pilih penerima...",
                   dropdownClass: 'dropdown-menu show',
               });
           }

           // Inisialisasi saat halaman pertama kali dimuat
           initTomSelect();

           // Re-inisialisasi setelah Livewire melakukan update DOM
           window.addEventListener('livewire:load', function() {
               Livewire.hook('message.processed', (message, component) => {
                   initTomSelect();
               });
           });
       </script>
   @endpush
