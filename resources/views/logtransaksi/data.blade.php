@extends('logtransaksi.index')

@section('judul')
    <h1>Log Transaksi</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Kasir</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($log as $d)
                                    @if (($d->pemasukan !== null && $d->pemasukan != 0) || ($d->pengeluaran !== null && $d->pengeluaran != 0))
                                        <tr>
                                            <td>
                                                @if ($d->pemasukan)
                                                    <button class="btn btn-success btn-sm text-white" title="Pemasukan"><i
                                                            class="fa fa-arrow-circle-right"></i></button>
                                                @else
                                                    <button class="btn btn-danger btn-sm text-white" title="Pengeluaran"><i
                                                            class="fa fa-arrow-circle-left"></i></button>
                                                @endif
                                            </td>
                                            <td>{{ $d->id }}</td>
                                            <td>{{ $d->created_at }}</td>
                                            <td>{{ $d->keterangan }}</td>
                                            <td>{{ $d->name_kasir }}</td>
                                            <td>
                                                @if ($d->pemasukan)
                                                    <span class="text-success text-bold">
                                                        {{ formatRupiah($d->pemasukan, true) }}</span>
                                                @else
                                                    <span class="text-danger text-bold">
                                                        {{ formatRupiah($d->pengeluaran, true) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                <tr>
                                    <td colspan="5"><span class="text-success text-bold">Total Pemasukan</span></td>
                                    <td><span class="text-success text-bold">
                                            {{ formatRupiah($pemasukan, true) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5"><span class="text-danger text-bold">Total Pengeluaran</span></td>
                                    <td><span class="text-danger text-bold">
                                            {{ formatRupiah($pengeluaran, true) }}</span>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
