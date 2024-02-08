@extends('supplier.index')

@section('css')
    <style>
        /* Menambahkan kelas modal-dialog-fullscreen */
        .modal-dialog-fullscreen {
            display: flex;
            margin: 0;
            height: 100%;
            width: 100%;
            max-width: 100%;
        }

        /* Menyesuaikan gaya scrollbar jika modal melebihi tinggi layar */
        .modal-content {
            overflow-y: auto;
        }

        /* Menambahkan padding pada modal agar kontennya tidak menempel ke tepi */
        .modal-body {
            padding: 20px;
        }
    </style>
@endsection

@section('judul')
    <h4>Supplier</h4>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header pb-2">
                        <div class="input-group">
                            <div class="input-group-prepend mb-2 mb-md-0">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#tambahDataSupplier">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-plus fa-fw"></i>
                                    </span>
                                    Tambah Data
                                </button>
                            </div>

                            <div class="input-group-prepend ml-2 mb-2 mb-md-0">
                                <span class="input-group-text">Limit</span>
                            </div>
                            <form method="post" action="{{ route('supplier.limit') }}">
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
                            <!-- Search input -->
                            <div class="input-group-prepend mb-2 mb-md-0">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <form method="get" action="{{ url('supplier') }}" id="searchForm">
                                @csrf
                                <input type="text" class="form-control" name="q" id="searchInput"
                                    placeholder="Search..." value="{{ request()->q }}" />
                            </form>
                            <button class="btn btn-danger ml-2" id="clear">Clear</button>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Perusahaan</th>
                                    <th>Atas Nama</th>
                                    <th>Jabatan</th>
                                    <th>No Hp</th>
                                    <th>Jenis Usaha</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($datas as $index => $item)
                                    <tr>
                                        <td>{{ $index + $datas->firstItem() }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->pemilik }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->nohp }}</td>
                                        <td>{{ $item->jenis_usaha }}</td>
                                        <td>
                                            @if ($item->status == 'Y')
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editSupplier{{ $item->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form id="hapusSupplier{{ $item->id }}"
                                                action="{{ url('supplier/' . $item->id) }}" method="POST"
                                                style="display: inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" title="Hapus Data" class="btn btn-sm btn-danger"
                                                    onclick="hapusSupplier({{ $item->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($datas->count() == 0)
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <p>Tidak Ada Data</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-start">
                            <p class="mr-3">Menampilkan {{ $datas->firstItem() }} hingga {{ $datas->lastItem() }} dari
                                {{ $datas->total() }} data</p>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{ $datas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Edit Data --}}
    @foreach ($datas as $item)
        <div class="modal fade" id="editSupplier{{ $item->id }}" tabindex="-1" aria-labelledby="editSupplierLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSupplierLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('supplier.update', ['id' => $item->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="perusahaan">Perusahaan</label>
                                    <input type="text" class="form-control" id="perusahaan" name="perusahaan"
                                        value="{{ $item->nama }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nama">Atas Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $item->pemilik }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        value="{{ $item->jabatan }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nohp">No Hp</label>
                                    <input type="text" class="form-control" id="nohp" name="nohp"
                                        value="{{ $item->nohp }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $item->email }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jenisusaha">Jenis Usaha</label>
                                    <input type="text" class="form-control" id="jenisusaha" name="jenisusaha"
                                        value="{{ $item->jenis_usaha }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="norek">No Rekening</label>
                                    <input type="text" class="form-control" id="norek" name="norek"
                                        value="{{ $item->norek }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        value="{{ $item->alamat }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        @php
                                            $status = ['Y' => 'Aktif', 'N' => 'Tidak Aktif'];
                                        @endphp
                                        @foreach ($status as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $item->status == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="tombol mb-4">
                                <button type="submit" class="btn btn-primary float-right ml-2">Simpan</button>
                                <button type="button" class="btn btn-danger float-right"
                                    data-dismiss="modal">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal Edit Data --}}

    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="tambahDataSupplier" tabindex="-1" aria-labelledby="tambahDataSupplierLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataSupplierLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('supplier.tambah') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="perusahaan">Perusahaan</label>
                                <input type="text" class="form-control" id="perusahaan" name="perusahaan">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nama">Atas Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nohp">No Hp</label>
                                <input type="text" class="form-control" id="nohp" name="nohp">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jenisusaha">Jenis Usaha</label>
                                <input type="text" class="form-control" id="jenisusaha" name="jenisusaha">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="norek">No Rekening</label>
                                <input type="text" class="form-control" id="norek" name="norek">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" name="status">
                                    <option value="Y">Aktif</option>
                                    <option value="N">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="tombol mb-4">
                            <button type="submit" class="btn btn-primary float-right ml-2">Simpan</button>
                            <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Modal Tambah Data --}}
    @endsection
    @section('js')
        <script>
            function hapusSupplier(id) {
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Anda yakin ingin menghapus data ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('hapusSupplier' + id).submit();
                    }
                });
            }
        </script>
    @endsection
