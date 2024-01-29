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
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Pembelian</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target=".bd-pembelian-modal-lg"> <i class="fa fa-plus"></i> Tambah Data</button>
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
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Faktur</th>
                                        <th>Bahan</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Total</th>
                                        <th>DP</th>
                                        <th>Sisa</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelians as $data)
                                        <tr>
                                            <th><span class="label label-info">{{ $loop->iteration }}</span></th>
                                            <th>{{ $data->id_pembelian }}</th>
                                            <th>{{ $data->bahan }}</th>
                                            <th>{{ $data->jenis }}</th>
                                            <th>{{ $data->jumlah }}</th>
                                            <th>{{ $data->satuan }}</th>
                                            <th>{{ formatRupiah($data->total, true) }}</th>
                                            <th>{{ formatRupiah($data->uang_muka, true) }}</th>
                                            <th>{{ formatRupiah($data->sisa_pembayaran, true) }}</th>
                                            <th>{{ $data->created_at }}</th>
                                            <th>
                                                <button
                                                    onclick="window.location='{{ url('pembelian/' . $data->id_pembelian) }}'"
                                                    class="btn btn-sm btn-info" title="Edit Data">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form method="POST" action="{{ 'pembelian/' . $data->id_pembelian }}"
                                                    style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus Data"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('pembelian.print_faktur', $data->id_pembelian) }}"
                                                    class="btn btn-sm btn-primary mb-1" title="Print Faktur"
                                                    target="_blank">
                                                    <i class="fa fa-print"></i>
                                                </a>

                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                    <input type="hidden" id="idpembelian" value="" readonly>
                                    <div class="mr-auto p-2">
                                        <div class="d-inline p-2 bg-info text-white">No. <span id="id_pembelian"></span>
                                        </div>
                                        <div class="d-inline p-2 bg-default">Kasir : <span id="nama"></span></div>
                                    </div>
                                    <div class="p-2">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">Tanggal Transaksi</span>
                                            </span>
                                            <input type="text" class="form-control form-control-sm w-150px date_p"
                                                id="date_p" value="" readonly>
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
                                                            id="bahan" name="bahan" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="jenisakun" name="jenis" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="supplier" name="supplier" />
                                                    </div>

                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="jumlah" name="jumlah" />
                                                    </div>
                                                </td>
                                                <td class="col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="bahan_" name="bahan" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="nominal" name="nominal" />
                                                    </div>
                                                </td>
                                                <td class="col-12 col-md-1">
                                                    <div class="form-group p-0 m-0">
                                                        <input type="text" class="form-control input-default"
                                                            id="satuan" name="satuan" />
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
                                                        id="total_pembelian" type="text" readonly></td>
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
