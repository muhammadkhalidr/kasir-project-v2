<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Aplikasi Kasir Percetakan - Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #ddd;
        }

        .tanggal {
            text-align: right;
        }

        .status-lunas {
            color: green;
            text-transform: uppercase;
            font-weight: bold;
        }

        .status-belum-lunas {
            color: red;
            text-transform: uppercase;
            font-weight: bold;

        }

        .dp,
        .sisa {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #ffffff;
            padding: 10px;
            background-color: rgb(110, 0, 0);
        }

        .kotak {
            width: 35%;
            padding: 10px;
            border: solid 2px;
            background-size: 160px;
            background-position: center;
            background-repeat: no-repeat;
        }

        .alamat {
            width: max-content;
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
        }
    </style>
</head>

<body>
    <h1>Laporan Pengeluaran</h1>
    <table>
        <tr>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Via</th>
        </tr>
        @foreach ($groupedPengeluarans as $id_pengeluaran => $groupedPengeluaran)
            @foreach ($groupedPengeluaran as $cetak)
                <tr>
                    <td>{{ $cetak->keterangan }}</td>
                    <td class="text-left">{{ $cetak->jumlah }}</td>
                    <td class="text-center">{{ formatRupiah($cetak->harga, true) }}</td>
                    <td class="text-right">{{ formatRupiah($cetak->total, true) }}</td>
                    <td>
                        @php
                            $id_bank = $cetak->id_bank;
                            $bank = \App\Models\Rekening::where('id', $id_bank)->value('bank');
                            if ($bank) {
                                echo $bank;
                            } else {
                                echo 'Kas Penjualan';
                            }
                        @endphp
                    </td>

                </tr>
            @endforeach
            <tr style="background-color: #4d4d4d;color:white;">
                <td></td>
                <td></td>
                <td class="text-right">
                    <b><i>Sub Total</i></b>
                </td>
                <td class="text-right">
                    <b><i>{{-- Add a meaningful value here --}}</i></b>
                    {{ formatRupiah($totals[$id_pengeluaran], true) }}
                </td>
                <td></td>
            </tr>
        @endforeach
    </table>

    {{-- <p>Via : {{ $groupedPengeluaran->bank }}</p> --}}

    <footer class="footer">Copyright &copy; Khalid R {{ date('Y') }}</footer>
</body>

</html>
