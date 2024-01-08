@include('partials.header')
@include('partials.sidebar')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $breadcrumb }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <h4 class="card-title">Data Gaji Karyawan & Kas Bon</h4>
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header pb-2">
                        <div class="input-group">
                            <div class="input-group-prepend mr-2">
                                @if (auth()->check())
                                    @if (auth()->user()->level == 1)
                                        <button type="button" class="btn btn-primary"
                                            onclick="window.location='{{ url('tambah-gajiv2') }}'">
                                            <i class="fa fa-plus-circle"></i> Tambah Data Baru
                                        </button>
                                    @elseif (auth()->user()->level == 2)
                                    @endif
                                @endif
                            </div>
                            <div class="input-group-prepend">
                                <span class="input-group-text">PERIODE</span>
                            </div>
                            <form method="POST" action="{{ route('gajikaryawanv2.cariKasbon') }}" id="searchFormDate">
                                @csrf
                                <input type="hidden" name="start_date" id="start_date" />
                                <input type="hidden" name="end_date" id="end_date" />
                                <input type="text" class="form-control w-10" name="daterange" />
                            </form>
                            <div class="input-group-prepend ml-2">
                                <span class="input-group-text">Limit</span>
                            </div>
                            <form method="get" action="{{ route('gajikaryawanv2.filterJumlah') }}">
                                @csrf
                                <div class="input-group-prepend mr-2">
                                    <select class="form-control" id="dataOptions" name="dataOptions"
                                        onchange="this.form.submit()">
                                        @foreach ($perPageOptions as $option)
                                            <option
                                                value="{{ $option }}"{{ $datas->perPage() == $option ? 'selected' : '' }}>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                            <form method="GET" action="{{ route('gajikaryawanv2.cari') }}" id="searchForm">
                                @csrf
                                <input type="text" class="form-control w-full" name="searchdata" id="searchInput"
                                    placeholder="Search..." />
                            </form>
                            <div class="input-group-append">
                                <button type="submit" data-info="cari" class="btn btn-success caridata"
                                    data-id="0"><i class="fa fa-search"></i> Cari</button>
                                <button class="btn btn-info print_pdf_piutang" data-url="piutang" type="button"
                                    data-toggle="tooltip" data-original-title="Cetak KasBon" data-placement="left"><i
                                        class="fa fa-file-pdf-o"></i> Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="pesan mt-2">
                            @if (session('msg'))
                                <div class="alert alert-primary alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                    </button> {{ session('msg') }}
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karywan</th>
                                        <th>Jumlah Gaji</th>
                                        <th>% Bonus</th>
                                        <th>Bonus</th>
                                        <th>Kas Bon</th>
                                        <th>Sisa Gaji</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($datas)
                                        @foreach ($datas as $gaji)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <th>{{ $gaji->karyawans->nama_karyawan }}</th>
                                                <th>{{ formatRupiah($gaji->jumlah_gaji, true) }}</th>
                                                <th>{{ $gaji->persen_bonus ?? '0' }} %</th>
                                                <th>{{ formatRupiah($gaji->bonus, true) }}</th>

                                                {{-- Display Total Kasbon --}}
                                                @php
                                                    $idKaryawan = $gaji->karyawans->id_karyawan;
                                                    $totalKasbon = $totalKasBon->where('id_karyawan', $idKaryawan)->first();
                                                @endphp

                                                <th>Rp.
                                                    {{ isset($totalKasbon) ? number_format($totalKasbon->total_nominal, 0, ',', '.') : '0' }}
                                                </th>

                                                <th>Rp. {{ number_format($gaji->sisa_gaji, 0, ',', '.') }}</th>
                                                <th>{{ $gaji->created_at }}</th>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    @if ($datas->count() == 0)
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <h5>Tidak Ada Data</h5>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $datas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
@include('partials.footer')
<script>
    $(function() {
        var startDate;
        var endDate;

        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            $('#searchFormDate').submit();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchInput');
        var searchForm = document.getElementById('searchForm');
        var btn = document.querySelector('.caridata');

        btn.addEventListener('click', function() {
            searchForm.submit();
        });
    });
</script>
