@extends('omset.index')

@section('judul')
    <h4>Omset Penjualan</h4>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="card-header pb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <form method="POST" action="{{ route('omset.cari') }}" id="searchFormDate">
                            @csrf
                            <input type="hidden" name="start_date" id="start_date" />
                            <input type="hidden" name="end_date" id="end_date" />
                            <input type="text" class="form-control w-10" name="daterange" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table header-border table-hover verticle-middle">
                    <thead class="thead-success">

                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Jumlah</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($omset as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $item->produk }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td class="text-right">{{ formatRupiah($item->total, true) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="thead-primary">
                        <tr>
                            <th colspan="3">Total</th>
                            <th class="text-right">{{ formatRupiah($omset->sum('total'), true) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
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
    </script>
@endsection
