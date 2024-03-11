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
                        <div class="card-header pb-2">
                            <form id="datepickerForm" method="GET" action="{{ url('laba-rugi') }}">
                                @csrf
                                <div class="input-group ml-auto">
                                    <div class="input-group-prepend mr-2">
                                        <label for="datepicker" class="input-group-text">Filter</label>
                                        <input type="month" class="form-control" id="datepicker" name="filterTgl"
                                            value="{{ $selectedDate ?? \Carbon\Carbon::now()->toDateString() }}"
                                            autocomplete="off" autofocus>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-success ml-2">
                                            <a href="{{ route('cetak-laba-rugi', ['filterTgl' => $selectedDate ?? \Carbon\Carbon::now()->toDateString()]) }}"
                                                target="_blank" class="text-white">
                                                <i class="fa fa-print"></i> Cetak Laporan
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </form>
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
<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            format: 'yyyy-mm',
            startView: "months",
            minViewMode: "months",
            endDate: new Date()
        });

        // Otomatis submit form saat tanggal dipilih
        $('#datepicker').on('changeDate', function() {
            $('#datepickerForm').submit();
        });
    });
</script>
