@extends('pelanggan.index')

@section('judul')
    {{-- <h1>Data Pelanggan</h1> --}}
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header pb-2">
                    <div class="input-group">
                        <div class="input-group-prepend mr-2">
                            <button type="button" class="btn btn-primary"
                                onclick="window.location='{{ url('tambah-pelanggan') }}'">
                                <i class="fa fa-plus-circle"></i> Tambah Data Baru
                            </button>
                        </div>

                        <div class="input-group-prepend ml-2">
                            <span class="input-group-text">Limit</span>
                        </div>
                        <form method="post" action="{{ route('pelanggan.limit') }}">
                            @csrf
                            <div class="input-group-prepend mr-2">
                                <select class="form-control" id="dataOptions" name="dataOptions"
                                    onchange="this.form.submit()">
                                    @foreach ($perPageOptions as $option)
                                        <option
                                            value="{{ $option }}"{{ $data->perPage() == $option ? 'selected' : '' }}>
                                            {{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <!-- Search input -->
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <form method="post" action="{{ url('pelanggan') }}" id="searchForm">
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


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Pelanggan</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Handphone</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d->kode_pelanggan }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td>{{ $d->alamat }}</td>
                                        <td>{{ $d->nohp }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>
                                            <button onclick="window.location='{{ url('pelanggan/' . $d->id) }}'"
                                                class="btn btn-sm btn-info" title="Edit Data">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form method="POST" action="{{ 'pelanggan/' . $d->id }}"
                                                style="display: inline" id="hapusPelangganForm">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" title="Hapus Data" class="btn btn-sm btn-danger"
                                                    onclick="hapusPelanggan()">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-sm btn-success" type="button" onclick="comming()"><a
                                                    href="">Detail</a></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </table>
                        <div class="d-flex justify-content-start">
                            <p class="mr-3">Menampilkan {{ $data->firstItem() }} hingga {{ $data->lastItem() }} dari
                                {{ $data->total() }} data</p>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{ $data->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function hapusPelanggan() {
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
                document.getElementById('hapusPelangganForm').submit();
            }
        });
    }

    function comming() {
        Swal.fire("Coming Soon!");
    }
</script>
