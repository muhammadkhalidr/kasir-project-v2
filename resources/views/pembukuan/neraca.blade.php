@include('partials.header')
@include('partials.sidebar')

<!--**********************************
                Content body start
            ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pembukuan</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $breadcrumb }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Laporan Neraca</h6>
                        <div class="input-group input-group-sm w-25">
                            <div class="input-group-prepend">
                                <button class="btn btn-info" id="cetak_neraca"><i class="fa fa-file-pdf-o"></i>
                                    Print</button>
                            </div>
                            <input type="text" id="tanggal" value="" class="form-control"
                                placeholder="mm/yyyy" />
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table align-items-center table-flush mt-5" id="jurnal-umum">
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
                </div>
            </div>
        </div>
    </div>
</div>



<!-- #/ container -->
<!--**********************************
                Content body end
            ***********************************-->
@include('partials.footer')
