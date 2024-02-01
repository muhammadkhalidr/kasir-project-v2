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
                                    @foreach ($groupedPembelians as $id => $groupedPembelian)
                                        <tr data-parent="#table-guest">
                                            <td colspan="5" class="p-0">
                                                <table class="table table-striped">
                                                    <thead class="thead-success">
                                                        <tr>
                                                            <th>No Pembelian</th>
                                                            <th>
                                                                <button class="btn btn-dark btn-sm">#
                                                                    {{ $groupedPembelian[0]->id_pembelian_generate }}</button>
                                                            </th>
                                                            <th></th>
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
                                                            <th class="text-center">Supplier</th>
                                                            <th class="text-center">Bahan</th>
                                                            <th class="text-right">Nominal</th>
                                                            <th class="text-right">Jenis</th>
                                                            <th class="text-right">Tanggal</th>
                                                            <th class="w-10 text-right">Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php $firstRow = true; @endphp
                                                        @foreach ($groupedPembelian as $pembelian)
                                                            <tr>
                                                                <td>{{ $pembelian->keterangan }}</td>
                                                                <td class="text-left">{{ $pembelian->jumlah }}
                                                                    {{ $pembelian->satuan }}</td>
                                                                <td class="text-center">
                                                                    {{ $pembelian->suppliers->nama ?? 'kosong' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $pembelian->bahans->bahan }}
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
                                                                            action="{{ 'pembelian/' . $pembelian->id_pembelian_generate }}"
                                                                            id="hapusPembelian{{ $pembelian->id_pembelian_generate }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" title="Hapus Data"
                                                                                class="btn btn-sm btn-danger hapus-btn"
                                                                                onclick="hapusPembelian('{{ $pembelian->id_pembelian_generate }}')">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </form>

                                                                        <form method="POST"
                                                                            action="{{ 'pembelian/' . $pembelian->id_pembelian_generate }}"
                                                                            class="mt-2">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <button type="button" title="BAYAR"
                                                                                class="btn btn-sm btn-success">
                                                                                <i class="fa fa-edit"></i>
                                                                            </button>
                                                                        </form>
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
                                                            <td class="text-center"></td>
                                                            <td class="text-right">
                                                                <b><i>Total</i></b>
                                                            </td>
                                                            <td class="text-right">
                                                                <b><i></i></b>

                                                                {{ formatRupiah($pembelian->subtotal, true) }}
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
                                            <strong>{{ formatRupiah($subtotals->sum(), true) }}</strong>
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

    @include('pembelian.components.modal')

    <!--**********************************
            Content body end
        ***********************************-->
    @include('partials.footer')
