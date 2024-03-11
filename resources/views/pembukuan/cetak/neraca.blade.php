<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Neraca - {{ $selectedDate }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    {{-- <link href="{{ asset('/') }}assets/css/style.css" rel="stylesheet"> --}}

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
            background: #7571f9;
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
            background: #7571f9;
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
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4" rowspan="5"> <img
                        src="{{ public_path('/assets/images/settings/' . $info->first()->login_logo) }}"
                        alt="{{ $info->first()->perusahaan }}" style="width: 80%; max-width: 150px;">
                <td colspan="2" class="tgl">LAPORAN NERACA</td>
            </tr>
            <tr class="">
                <td colspan="2">Periode, {{ $selectedDate }} </td>
            </tr>
            <tr class="">
                <td colspan="2"></td>
            </tr>
            <tr class="kepada">
                <td class="tkepada">Pencatat</td>
                <td class="bawah">{{ $name_user }}</td>
            </tr>
            <tr class="">
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="4"><i style="margin-top:2px" class="fa fa-whatsapp"></i>&nbsp;<span
                        class="sosmed">{{ $info->first()->phone }}</span> <i style="margin-top:2px"
                        class="fa fa-envelope-square"></i>&nbsp;<span class="sosmed">{{ $info->first()->email }}</span>
                    <i style="margin-top:2px" class="fa fa-facebook-square"></i>&nbsp;<i style="margin-top:2px"
                        class="fa fa-instagram"></i>&nbsp;<span class="sosmed">{{ $info->first()->instagram }}</span>
                </td>
                <td colspan="2"></td>
            </tr>
        </table>
        <table class="table align-items-center table-flush mt-5" id="neraca">
            <thead class="thead-primary">
                <tr>
                    <th>Aset Lancar</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aktiva_lancar as $lancar)
                    <tr>
                        <td>{{ $lancar->nama_reff }}</td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ formatRupiah($lancar->kas, true) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <thead class="thead">
                <tr>
                    <th>Jumlah Aset Lancar</th>
                    <th>&nbsp;</th>
                    <th class="text-right">{{ formatRupiah($total_aset, true) }}</th>
                </tr>
            </thead>
            <thead class="thead-primary">
                <tr>
                    <th>Aset Tetap</th>
                    <th>&nbsp;</th>
                    <th class="text-right text-white"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aktiva_tetap as $tetap)
                    <tr>
                        <td>{{ $tetap->nama_reff }}</td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ formatRupiah($tetap->kas, true) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <thead class="thead">
                <tr>
                    <th>Jumlah Aset Tetap</th>
                    <th class="text-right"></th>
                    <th class="text-right">{{ formatRupiah($total_aset_tetap, true) }}</th>
                </tr>
            </thead>
            <thead class="thead-primary">
                <tr>
                    <th>Kewajiban</th>
                    <th>&nbsp;</th>
                    <th class="text-right text-white"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasiva_lancar as $pasiva)
                    <tr>
                        <td>{{ $pasiva->nama_reff }}</td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ formatRupiah($pasiva->kas, true) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <thead class="thead">
                <tr>
                    <th>Total Kewajiban</th>
                    <th class="text-right">{{ formatRupiah($total_pasiva_lancar, true) }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <thead class="thead-primary">
                <tr>
                    <th>Pendapatan</th>
                    <th>&nbsp;</th>
                    <th class="text-right text-white"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendapatan as $p)
                    <tr>
                        <td>{{ $p->nama_reff }}</td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ formatRupiah($p->kas, true) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <thead class="thead">
                <tr>
                    <th>Total Pendapatan</th>
                    <th>&nbsp;</th>
                    <th class="text-right">{{ formatRupiah($total_pendapatan_aset, true) }}</th>
                </tr>
            </thead>

            <thead class="thead-primary">
                <tr>
                    <th>Beban</th>
                    <th>&nbsp;</th>
                    <th class="text-right text-white"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($beban_lancar as $beban)
                    <tr>
                        <td>{{ $beban->nama_reff }}</td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ formatRupiah($beban->kas, true) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <thead class="thead">
                <tr>
                    <th>Total Beban</th>
                    <th class="text-right">{{ formatRupiah($total_beban_lancar, true) }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

        </table>
    </div>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>
