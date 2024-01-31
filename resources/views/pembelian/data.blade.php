@include('partials.header')
@include('partials.sidebar')

<style>
    .modal-fullscreen {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        max-width: 100%;
    }

    .modal-fullscreen .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }

    .modal-fullscreen .modal-body {
        overflow-y: auto;
    }
</style>
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
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-pembelian-modal-lg">
                    <i class="fa fa-plus"></i> Tambah Data</button>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                </thead>
                                <tbody>
                                    @foreach ($groupedPembelians as $id => $groupedPenmbelian)
                                        <tr data-parent="#table-guest">
                                            <td colspan="5" class="p-0">
                                                <table class="table table-striped">
                                                    <thead class="thead-success">
                                                        <tr>
                                                            <th>No Pengeluaran</th>
                                                            <th>
                                                                <button class="btn btn-dark btn-sm">#
                                                                    {{ $groupedPenmbelian[0]->id }}</button>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <thead class="thead-primary">
                                                        <tr>
                                                            <th>Keterangan</th>
                                                            <th class="text-left" style="width:10%!important">Jumlah
                                                            </th>
                                                            <th class="text-center">Harga</th>
                                                            <th class="text-right">Nominal</th>
                                                            <th class="text-right">Jenis</th>
                                                            <th class="text-right">Tanggal</th>
                                                            <th class="w-10 text-right">Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php $firstRow = true; @endphp
                                                        @foreach ($groupedPenmbelian as $pembelian)
                                                            <tr>
                                                                <td>{{ $pembelian->keterangan }}</td>
                                                                <td class="text-left">{{ $pembelian->jumlah }}</td>
                                                                <td class="text-center">
                                                                    {{ formatRupiah($pembelian->harga, true) }}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{ formatRupiah($pembelian->total, true) }}
                                                                </td>
                                                                <td>{{ $pembelian->jenisp->nama_jenis ?? 'Kosong' }}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{ $pembelian->formatted_date }}</td>

                                                                <td class="text-right">
                                                                    @if ($firstRow)
                                                                        <form method="POST"
                                                                            action="{{ 'pembelian/' . $pembelian->id }}"
                                                                            style="display: inline"
                                                                            id="hapusPembelianForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" title="Hapus Data"
                                                                                class="btn btn-sm btn-danger hapus-btn"
                                                                                onclick="hapusPengeluaran()">
                                                                                <i class="fa fa-trash"></i> Hapus
                                                                            </button>
                                                                        </form>

                                                                        <a href="{{ route('cetak.print_invoice', $pengeluaran->id) }}"
                                                                            class="btn btn-sm btn-primary mb-1"
                                                                            title="Print Invoice" target="_blank">
                                                                            <i class="fa fa-print"></i>
                                                                        </a>
                                                                        @php $firstRow = false; @endphp
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr style="background-color: #4d4d4d;color:white;">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-right">
                                                                <b><i>Total</i></b>
                                                            </td>
                                                            <td class="text-right">
                                                                <b><i></i></b>

                                                                {{ formatRupiah($totals[$id], true) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-left"><strong>Total Pembelian</strong></td>
                                        <td class="text-right">
                                            <strong>{{ formatRupiah($totals->sum(), true) }}</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-start">
                                @php
                                    $hitungNoTrx = $datas->unique('id')->count();
                                @endphp

                                <p class="mr-3">Menampilkan {{ $hitungNoTrx }} hingga {{ $hitungNoTrx }} dari
                                    {{ $hitungNoTrx }} data</p>
                            </div>

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

    {{-- Modal --}}
    <div class="modal fade bd-pembelian-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('pembelian') }}" method="POST">
                        @csrf
                        <div class='row'>
                            <div class="col-12">
                                <div class="d-flex flex-column flex-md-row">
                                    <input type="text" id="id" value="{{ $nomorPembelian }}"
                                        name="nopembelian[]" readonly>
                                    <div class="mr-auto p-2">
                                        <div class="d-inline p-2 bg-info text-white">No. #{{ $nomorPembelian }} <span
                                                id="id_pembelian"></span>
                                        </div>
                                        <div class="d-inline p-2 bg-default">Kasir : <span
                                                id="nama">{{ $name_user }}</span></div>
                                    </div>
                                    <div class="p-2">
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">Tanggal Transaksi</span>
                                            </span>
                                            <input type="text" class="form-control form-control-sm w-150px date_p"
                                                id="date_p"
                                                value="{{ \Carbon\Carbon::now()->toFormattedDateString() }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm" id="table_pembelian">
                                        <thead>
                                            <tr>
                                                <td>Bahan</td>
                                                <td>Jenis akun</td>
                                                <td>Supplier</td>
                                                <td>Keterangan</td>
                                                <td>Qty</td>
                                                <td>Nominal</td>
                                                <td>Satuan</td>
                                                <td>Sub total</td>
                                                <td><button type="button" class="btn btn-info btn-sm add_mores"><i
                                                            class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="row_Count" id="row_Count">
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="bahan" name="bahan[]" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="jenisakun" name="jenis[]" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="supplier" name="supplier[]" />
                                                    </div>

                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="keterangan" name="keterangan[]" />
                                                    </div>

                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="jumlah" name="jumlah[]" />
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="nominal" name="nominal[]" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="satuan" name="satuan[]" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="subtotal" name="subtotal[]" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm del_more"><i
                                                            class="fa fa-times"></i></button>
                                                </td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">&nbsp;</td>
                                                <td>Total pembelian</td>
                                                <td colspan="1"><input class="form-control form-control-sm"
                                                        id="total_pembelian" type="text"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
            Content body end
        ***********************************-->
    @include('partials.footer')
