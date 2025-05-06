@push("styles")
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <style>
        table.dataTable thead tr,
        table.dataTable thead th,
        table.dataTable tbody th,
        table.dataTable tbody td {
            text-align: center;
        }
    </style>
@endpush

@push("scripts")
    {{-- HAPUS bootstrap.bundle.min.js jika sudah ada di layout --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.table').DataTable();
        });
    </script>
@endpush
