@extends('kategori.index')

@section('judul')
    <h4>Kategori</h4>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card-header pb-2">
                    <div class="input-group">
                        <div class="input-group-prepend mr-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahDataJenis">
                                <span class="icon text-white-50">
                                    <i class="fa fa-plus fa-fw"></i>
                                </span>
                                Tambah Data
                            </button>
                        </div>
                        <div class="col-10 d-flex justify-content-end">
                        <div class="input-group-prepend ml-2">
                            <span class="input-group-text">Limit</span>
                        </div>
                        <form method="post" action="{{ route('kategori.limit') }}">
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
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <form method="get" action="{{ url('kategori') }}" id="searchForm">
                            @csrf
                            <input type="text" class="form-control" name="searchdata" id="searchInput"
                                placeholder="Search..." />
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

                    <div class="pesan mt-2">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button> {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
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
                                        <td>{{ $item->kategori }}</td>
                                        <td>
                                            @if ($item->status == 'Y')
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editJenisBahan{{ $item->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ url('kategori/' . $item->id) }}" method="POST"
                                                id="hapusKategori" style="display: inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" title="Hapus Data" class="btn btn-sm btn-danger"
                                                    onclick="hapusKategori()">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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
    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="tambahDataJenis" tabindex="-1" aria-labelledby="tambahDataJenisLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataJenisLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('kategori') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="jenis">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Y">Aktif</option>
                                <option value="N">Tidak Aktif</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah Data --}}

    {{-- Modal Edit Data --}}
    {{-- @foreach ($datas as $item)
        <div class="modal fade" id="editJenisP{{ $item->id }}" tabindex="-1" aria-labelledby="editJenisPLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editJenisPLabel">Edit Jenis Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('jenis-pengeluaran.update', ['id' => $item->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="id_jenis">ID Jenis</label>
                                <input type="text" class="form-control" id="id_jenis" name="id_jenis"
                                    value="{{ $item->id_jenis }}">
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <input type="text" class="form-control" id="jenis" name="jenis"
                                    value="{{ $item->nama_jenis }}">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach --}}
    {{-- End Modal Edit Data --}}
@endsection
@section('js')
    <script>
        function hapusKategori() {
            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('hapusKategori').submit();
                }
            });
        }
    </script>
@endsection
