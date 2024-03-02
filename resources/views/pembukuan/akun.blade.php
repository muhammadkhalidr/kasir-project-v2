    @include('partials.header')
    @include('partials.sidebar')

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
                            <h4 class="card-title">Jenis Akun</h4>
                            @if (auth()->user()->level == 1 || auth()->user()->level == 2)
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalTambahAkun">
                                    Tambah Akun
                                </button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Akun</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $item)
                                        <tr>
                                            <td><span class="label label-info">{{ $loop->iteration }}</span>
                                            </td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->nama_reff }}</td>
                                            <td>
                                                @if ($item->aktif == 'Y')
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-toggle="modal" data-target="#modalEditAkun{{ $item->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form method="POST" action="{{ route('akun.hapus', $item->id) }}"
                                                    style="display: inline" id="hapusAkunTransaksi{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" title="Hapus Data"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="hapusAkunTransaksi({{ $item->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
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

    {{-- Modal Tambah Akun --}}
    <div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-labelledby="modalTambahAkunLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAkunLabel">Tambah Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('jenis-akun') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="">No Reff</label>
                            <input type="text" name="no_reff" id="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Akun</label>
                            <input type="text" name="akun" id="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" name="ket" id="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="aktif" id="" class="form-control">
                                <option value="Y">Aktif</option>
                                <option value="N">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah AKun --}}

    {{-- Modal Edit Akun --}}
    @foreach ($datas as $item)
        <div class="modal fade" id="modalEditAkun{{ $item->id }}" tabindex="-1"
            aria-labelledby="modalEditAkunLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditAkunLabel{{ $item->id }}">Edit Akun</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('akun.update', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">No Reff</label>
                                <input type="text" name="no_reff" id="" class="form-control"
                                    value="{{ $item->no_reff }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Akun</label>
                                <input type="text" name="akun" id="" class="form-control"
                                    value="{{ $item->nama_reff }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" name="ket" id="" class="form-control"
                                    value="{{ $item->keterangan }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="aktif" id="" class="form-control">
                                    <option value="Y">Aktif</option>
                                    <option value="N">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal Edit AKun --}}
    <!-- #/ container -->
    <!--**********************************
                    Content body end
                ***********************************-->
    @include('partials.footer')
    <script type="text/javascript">
        function hapusAkunTransaksi(id) {
            Swal.fire({
                title: 'Hapus Akun ?',
                text: "Data yang di hapus tidak dapat dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('hapusAkunTransaksi' + id).submit();
                }
            });
        }
    </script>
