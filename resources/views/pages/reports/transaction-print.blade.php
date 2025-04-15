<!DOCTYPE html>
<html>

    <head>
        <title>Cetak Laporan Transaksi</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 14px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: center;
            }

            .text-success {
                color: green;
            }

            .text-danger {
                color: red;
            }

            .fw-bold {
                font-weight: bold;
            }
        </style>
    </head>

    <body onload="window.print()">

        <h2 style="text-align: center;">Laporan Transaksi</h2>

        <table class="text-nowrap">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Penerima</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $item)
                    <tr>
                        <td>{{ $item->invoice }}</td>
                        <td>{{ Str::limit($item->title, 30, "...") }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format("d M Y") }}</td>
                        <td class="text-success">
                            {{ $item->category === "debit" ? formatRupiah($item->amount) : "" }}
                        </td>
                        <td class="text-danger">
                            {{ $item->category === "credit" ? formatRupiah($item->amount) : "" }}
                        </td>
                        <td>{{ $item->recipient->name ?? "-" }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total Debit</th>
                    <td class="text-success">{{ formatRupiah($totalDebit) }}</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <th colspan="2">Total Kredit</th>
                    <td></td>
                    <td class="text-danger">{{ formatRupiah($totalCredit) }}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <th colspan="2">Saldo Akhir</th>
                    <td colspan="4" class="fw-bold">{{ formatRupiah($endingBalance) }}</td>
                </tr>
            </tfoot>
        </table>

    </body>

</html>
