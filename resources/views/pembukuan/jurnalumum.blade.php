@include('partials.header')
@include('partials.sidebar')

<!--**********************************
                Content body start
            ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pembukuan</a></li>
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
                        <h4 class="card-title">Jurnal Umum</h4>
                        @if (auth()->user()->level == 1 || auth()->user()->level == 2)
                            <button type="button" class="btn btn-primary d-flex justify-content-end"
                                data-toggle="modal" data-target="#modalTambahAkun">
                                Tambah Jurnal
                            </button>
                        @endif
                        <table class="table align-items-center table-flush mt-5" id="jurnal-umum">
                            <thead class="thead-light">
                                <tr>
                                    <th class="w-5">No.</th>
                                    <th scope="col">Bulan Dan Tahun</th>
                                    <th class="text-right ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $index => $group)
                                    <tr>
                                        <td scope="col">{{ $loop->iteration }}</td>
                                        <td scope="col">
                                            <a
                                                href="{{ route('jurnal.detail', $group['formatted_date']) }}">{{ $group['formatted_date'] }}</a>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-success"> <a
                                                    href="{{ route('jurnal.detail', $group['formatted_date']) }}"
                                                    class="text-white">Detail</a></button>
                                        </td>
                                    </tr>
                                @endforeach

                                @if (count($datas) == 0)
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <p>Belum ada data jurnal</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Jurnal --}}
<div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-labelledby="modalTambahAkunLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahAkunLabel">Tambah Jurnal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('jurnal-umum') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="form-group">
                        <input type="date" name="tgl" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="akun">Akun</label>
                        <select name="akun" id="akun" class="form-control" required>
                            @foreach ($akuns as $akun)
                                <option value="{{ $akun->id_akun }}">
                                    {{ $akun->nama_reff }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" class="form-control" id="saldo" name="saldo" required>
                    </div>
                    <div class="form-group">
                        <label for="jsaldo">Jeni Saldo</label>
                        <select name="jsaldo" id="jsaldo" class="form-control" required>
                            <option value="kredit">Kredit</option>
                            <option value="debit">Debit</option>
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
{{-- End Modal Tambah Jurnal --}}


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
