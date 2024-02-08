@extends('satuan.index')

@section('judul')
    <h4>Satuan</h4>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header pb-2">
                    <div class="input-group">
                        <div class="input-group-prepend mr-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahDataSatuan">
                                <span class="icon text-white-50">
                                    <i class="fa fa-plus fa-fw"></i>
                                </span>
                                Tambah Data
                            </button>
                        </div>

                        <div class="input-group-prepend ml-2">
                            <span class="input-group-text">Limit</span>
                        </div>
                        <form method="post" action="{{ route('satuan.limit') }}">
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
                        <form method="get" action="{{ url('satuan') }}" id="searchForm">
                            @csrf
                            <input type="text" class="form-control" name="q" id="searchInput"
                                placeholder="Search..." value="{{ request('q') }}" />
                        </form>
                        <button class="btn btn-danger ml-2" id="clear">Clear</button>
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
                                    <th>Satuan</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($datas as $index => $item)
                                    <tr>
                                        <td>{{ $index + $datas->firstItem() }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editSatuan{{ $item->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ url('satuan/' . $item->id) }}" method="POST"
                                                id="hapusSatuan{{ $item->id }}" style="display: inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" title="Hapus Data" class="btn btn-sm btn-danger"
                                                    onclick="hapusSatuan('{{ $item->id }}')">
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
    <div class="modal fade" id="tambahDataSatuan" tabindex="-1" aria-labelledby="tambahDataSatuanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataSatuanLabel">Tambah Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('satuan.tambah') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" autocomplete="off"
                                autofocus>
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
    @foreach ($datas as $item)
        <div class="modal fade" id="editSatuan{{ $item->id }}" tabindex="-1" aria-labelledby="editSatuanLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSatuanLabel">Edit Satuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('satuan', ['id' => $item->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan"
                                    value="{{ $item->satuan }}">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal Edit Data --}}
@endsection
@section('js')
    <script>
        function hapusSatuan(id) {
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
                    document.getElementById('hapusSatuan' + id).submit();
                }
            });
        }
    </script>
@endsection
