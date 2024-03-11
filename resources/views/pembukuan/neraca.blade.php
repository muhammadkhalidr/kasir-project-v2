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
                        <div class="card-header pb-2">
                            <form id="datepickerForm" method="GET" action="{{ url('neraca') }}">
                                @csrf
                                <div class="input-group ml-auto">
                                    <div class="input-group-prepend mr-2">
                                        <label for="datepicker" class="input-group-text">Filter</label>
                                        <input type="month" class="form-control" id="datepicker" name="filterTgl"
                                            value="{{ $selectedDate ?? \Carbon\Carbon::now()->format('Y-m') }}"
                                            autocomplete="off" autofocus>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-success ml-2">
                                            <a href="{{ route('cetak-neraca', ['filterTgl' => $selectedDate ?? \Carbon\Carbon::now()->format('Y-m')]) }}"
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

        // Handle click event untuk tombol cetak
        $('#printButton').on('click', function() {
            var selectedDate = $('#datepicker').val();
            var printUrl = "{{ route('cetak-neraca') }}?filterTgl=" + selectedDate;
            window.open(printUrl, '_blank');
        });
    });
</script>
