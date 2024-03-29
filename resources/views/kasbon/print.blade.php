<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cetak Kasbon</title>
    <style>
        @page {
            width: 21cm;
            height: 14.8cm;
            margin: 0.6cm 0.5cm 0.1cm 0.5cm;
        }

        .invoice-box {
            width: 100%;
            margin: auto;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 12px;
            line-height: 18px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 0 5px 0 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {}

        .invoice-box table tr.top table td {
            padding-bottom: 0;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {}

        .invoice-box table tr.heading td {
            background: red;
            color: #fff;
            font-weight: bold;
            padding: 5px;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #000;

        }

        .invoice-box table tr.kepada td {
            color: #fff;
            border-bottom: 1px dotted #000
        }

        .invoice-box table tr.item.last td {}

        .invoice-box table tr.total {
            font-weight: bold;
            text-align: right;
        }

        .invoice-box table tr.hormat {
            font-weight: bold;
            text-align: left;
        }

        .invoice-box table tr.pelanggan {
            font-weight: bold;
            text-align: center;
        }

        .invoice-box table td.total {
            text-align: right;
        }

        .invoice-box table td.tgl {
            border-bottom: 1px dotted #000;
            font-weight: bold;
        }

        .invoice-box table td.tkepada {
            background: red;
            width: 12% !important
        }

        .invoice-box table tr.kepada td.bawah {
            color: #000;
            width: 30% !important
        }

        .invoice-box table td.total1 {
            border-left: 1px solid #000;
            border-top: 1px solid #000;
            border-bottom: 1px dotted #000;
        }

        .invoice-box table td.total2 {
            border-top: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px dotted #000;
            text-align: right;
            font-weight: bold;
        }

        .invoice-box table td.umuka1 {
            border-left: 1px solid #000;
            border-bottom: 1px dotted #000;
        }

        .invoice-box table td.umuka2 {
            border-right: 1px solid #000;
            border-bottom: 1px dotted #000;
            text-align: right;
            font-weight: bold;
        }

        .invoice-box table td.sisa1 {
            border-left: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .invoice-box table td.sisa2 {
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            text-align: right;
            font-weight: bold;
        }

        .invoice-box table td.ttd {
            border-bottom: 1px dotted #000;
            text-align: center;
            font-weight: bold;
        }

        .invoice-box table td.border {
            border-right: 1px dotted #000;
        }


        .invoice-box .table img {
            position: fixed;
            z-index: -1000;
        }

        .watermark {
            right: 4cm;
            width: 4.5cm;
            height: auto;
            opacity: 0.2;
            z-index: -1
        }
    </style>
</head>

<body>
    <?php
    // print_r($bdetail);
    ?>
    <div class="invoice-box">
        <h2 style="text-align: center; text-transform: uppercase">Kasbon Karyawan</h2>
        <table style="width:100%;margin-top:5px" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td style="width:10%!important">Keterangan</td>
                <td align="center" style="width:5%!important">Jenis</td>
                <td align="center" style="width:5%!important">Nama Karyawan</td>
                <td style="width:5%!important;text-align:right">Nominal</td>
                <td align="center" style="width:5%!important">Tanggal</td>
            </tr>
            @foreach ($datas as $item)
                <tr class="item">
                    <td class="border">{{ $item->pengeluarans->first()->keterangan }}</td>
                    <td class="border">{{ $item->pengeluarans->first()->jenisp->nama_jenis }}</td>
                    <td align="center" class="border">{{ $item->karyawans->nama_karyawan }}</td>
                    <td class="border" align="right">{{ formatRupiah($item->nominal, true) }}</td>
                    <td class="border" align="center">{{ $item->created_at }}</td>
                </tr>
            @endforeach

        </table>
        <table class="table" style="width:100%;margin-top:10px" cellpadding="0" cellspacing="0">
            <tr>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="total1" style="width:12%">Total</td>
                <td class="total2" style="width:19%">{{ formatRupiah($total, true) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
