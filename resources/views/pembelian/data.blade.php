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
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header pb-2">
                            <div class="input-group mb-3">

                                <!-- Pemilih Batas -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Batas</span>
                                    <form method="post" action="{{ route('pembelian.limit') }}">
                                        @csrf
                                        <div class="input-group-prepend ">
                                            <select class="form-control w-5" id="dataOptions" name="dataOptions"
                                                onchange="this.form.submit()">
                                                @foreach ($perPageOptions as $option)
                                                    <option
                                                        value="{{ $option }}"{{ $datas->perPage() == $option ? 'selected' : '' }}>
                                                        {{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>

                                <!-- Pemilih Jenis -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Jenis</span>
                                    <select name="jenis" id="jenis" class="form-control w-10">
                                        @foreach ($datas->unique('jenisP.id_jenis') as $jenis)
                                            <option value="">Semua</option>
                                            <option value="{{ $jenis->jenisP->id_jenis }}">
                                                {{ $jenis->jenisP->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pemilih Pencatat -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Pencatat</span>
                                    <select name="pencatat" id="pencatat" class="form-control w-10">
                                        <option value="">Semua</option>
                                        @foreach ($datas->unique('id_user') as $pencatat)
                                            <option value="{{ $pencatat->users->id }}">{{ $pencatat->users->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Input Pencarian -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    <form method="get" action="{{ url('pembelian') }}" id="searchForm">
                                        {{-- @csrf --}}
                                        <input type="text" class="form-control w-5" name="search" id="searchInput"
                                            placeholder="Search..." value="{{ request('search') }}" />

                                        <input type="hidden" name="jenis" id="hiddenJenis"
                                            value="{{ request('jenis') }}">
                                        <input type="hidden" name="pencatat" id="hiddenpencatat"
                                            value="{{ request('pencatat') }}">
                                    </form>
                                </div>

                                <!-- Input Rentang Tanggal -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>

                                    <input type="hidden" name="start_date" id="start_date" />
                                    <input type="hidden" name="end_date" id="end_date" />
                                    <input type="text" class="form-control w-10" name="daterange" />

                                </div>

                                <!-- Tombol Tambah -->
                                <button type="button" class="btn btn-primary btn-sm ml-1 mr-1" data-toggle="modal"
                                    data-target=".bd-pembelian-modal-lg">
                                    <i class="fa fa-plus"></i>
                                </button>

                                <!-- Tombol Cari -->
                                <button type="submit" class="btn btn-danger btn-sm mr-1" id="cari"><i
                                        class="fa fa-search"></i></button>

                                <!-- Tombol Cetak -->
                                <button class="btn btn-info btn-sm" type="submit" data-placement="left"
                                    form="searchForm" formaction="{{ route('pembelian.print') }}" formtarget="_blank">
                                    <i class="fa fa-file-pdf-o"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
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
                                                                    <th>Pencatat :
                                                                        <span
                                                                            class="label label-dark">{{ $groupedPembelian[0]->users->name }}</span>
                                                                    </th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <thead class="thead-primary">
                                                                <tr>
                                                                    <th>Keterangan</th>
                                                                    <th class="text-left" style="width:10%!important">
                                                                        Jumlah
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
                                                                                    <button type="button"
                                                                                        title="Hapus Data"
                                                                                        class="btn btn-sm btn-danger hapus-btn"
                                                                                        onclick="hapusPembelian('{{ $pembelian->id_pembelian_generate }}')">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </form>

                                                                                {{-- <form method="POST"
                                                                            action="{{ 'pembelian/' . $pembelian->id_pembelian_generate }}"
                                                                            class="mt-2">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <button type="button" title="BAYAR"
                                                                                class="btn btn-sm btn-success"
                                                                                data-toggle="modal"
                                                                                data-target=".bd-editPembelian-modal-lg{{ $pembelian->id_pembelian_generate }}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </button>
                                                                        </form> --}}
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
                                                <td colspan="3" class="text-left"><strong>Total Pembelian</strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong>{{ formatRupiah($totalPembelian->sum(), true) }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                            @if ($groupedPembelians->count() == 0)
                                                <tr>
                                                    <td colspan="10" class="text-center">
                                                        <p>Belum ada data </p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-start">
                                        @php
                                            $hitungNoTrx = $datas->unique('id')->count();
                                        @endphp

                                        <p class="mr-3">Menampilkan {{ $hitungNoTrx }} hingga {{ $hitungNoTrx }}
                                            dari
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
