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
                        <h6 class="m-0 font-weight-bold text-primary">Laporan Laba Rugi</h6>
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
                        <table class="table align-items-center table-flush mt-5" id="labarugi">
                            <thead class="thead-primary">
                                <tr>
                                    <th>Pendapatan</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aktiva_pendapatan as $item)
                                    <tr>
                                        <td>{{ $item->nama_reff }}</td>
                                        <td class="text-right"></td>
                                        <td class="text-right">{{ formatRupiah($item->kas, true) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="thead">
                                <tr>
                                    <th>Laba Kotor</th>
                                    <th>&nbsp;</th>
                                    <th class="text-right">{{ formatRupiah($laba_kotor, true) }}</th>
                                </tr>
                            </thead>
                            <thead class="thead-primary">
                                <tr>
                                    <th>Biaya</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <thead class="thead">
                                @foreach ($biayas as $biaya)
                                    <tr>
                                        <th>{{ $biaya->nama_reff }}</th>
                                        <th class="text-right"></th>
                                        <th class="text-right">{{ formatRupiah($biaya->kas, true) }}</th>
                                    </tr>
                                @endforeach
                            </thead>
                            <thead class="thead">
                                @foreach ($prive as $p)
                                    <tr>
                                        <th>{{ $p->nama_reff }}</th>
                                        <th class="text-right"></th>
                                        <th class="text-right">{{ formatRupiah($p->kas, true) }}</th>
                                    </tr>
                                @endforeach
                            </thead>
                            <thead class="thead-primary">
                                <tr>
                                    <th>Beban</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <thead class="thead">
                                @foreach ($beban as $b)
                                    <tr>
                                        <th>{{ $b->nama_reff }}</th>
                                        <th class="text-right"></th>
                                        <th class="text-right">{{ formatRupiah($b->kas, true) }}</th>
                                    </tr>
                                @endforeach
                            </thead>
                            <tr>
                                <th>Total </th>
                                <th class="text-right"></th>
                                <th class="text-right">{{ formatRupiah($total_beban, true) }}</th>
                            </tr>

                            <tfoot class="thead-primary">
                                <tr>
                                    <th>LABA BERSIH</th>
                                    <th>&nbsp;</th>
                                    <th class="text-right">{{ formatRupiah($laba_bersih, true) }}</th>
                                </tr>
                            </tfoot>
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
