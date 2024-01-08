@extends('omset.index')

@section('judul')
    <h4>Omset Penjualan</h4>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table header-border table-hover verticle-middle">
                    <thead>

                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Produk</th>
                            <th class="text-right">Jumlah</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($omset as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $item->judul }}</td>
                                <td class="text-right">{{ formatRupiah($item->subtotal, true) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <th>{{ formatRupiah($omset->sum('subtotal'), true) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
