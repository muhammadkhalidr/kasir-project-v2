@extends('keuangan.main')

@section('judul')
    <h3>Log Keuangan</h3>
@endsection

@section('content')
    <div class="filter mb-3">
        <div class="row">
            <div class="col d-flex justify-content-end">
                <div class="card-header pb-2">
                    <form id="datepickerForm" method="GET" action="{{ url('keuangan') }}">
                        @csrf
                        <div class="input-group ml-auto">
                            <div class="input-group-prepend mr-2">
                                <label for="datepicker" class="input-group-text">Filter</label>
                                <input type="text" class="form-control" id="datepicker" name="filterTgl"
                                    value="{{ $selectedDate ?? \Carbon\Carbon::now()->toDateString() }}" autocomplete="off"
                                    autofocus>
                            </div>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card card-widget">
                <div class="card-body gradient-3">
                    <div class="media">
                        <span class="card-widget__icon"><a href="{{ url('pengeluaran') }}"><i
                                    class="icon-credit-card"></i></a></span>
                        <div class="media-body">
                            <h2 class="card-widget__title">Pengeluaran</h2>
                            <h5 class="card-widget__subtitle">{{ formatRupiah($kaskeluar, true) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-widget">
                <div class="card-body gradient-4">
                    <div class="media">
                        <span class="card-widget__icon"><a href="{{ url('orderan') }}"><i
                                    class="icon-credit-card"></i></a></span>
                        <div class="media-body">
                            <h2 class="card-widget__title">Pemasukan</h2>
                            <h5 class="card-widget__subtitle">{{ formatRupiah($kasmasuk, true) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-widget">
                <div class="card-body gradient-6">
                    <div class="media">
                        <span class="card-widget__icon"><a href="#"><i class="icon-credit-card"></i></a></span>
                        <div class="media-body">
                            <h2 class="card-widget__title">Total Pengeluran</h2>
                            <h5 class="card-widget__subtitle">
                                {{ formatRupiah($gajiKaryawans + $kaskeluar, true) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm',
                startView: "months",
                minViewMode: "months",
                // other datepicker options...
            });

            // Otomatis submit form saat tanggal dipilih
            $('#datepicker').on('changeDate', function() {
                $('#datepickerForm').submit();
            });
        });
    </script>
@endpush
