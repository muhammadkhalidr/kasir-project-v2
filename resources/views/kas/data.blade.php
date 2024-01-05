@extends('kas.index')


@section('tombol')
    <div class="col mb-3">
        <button class="btn btn-info mr-2" data-toggle="modal" data-target="#tambahKasKecilModal">Tambah Modal</button>
    </div>
@endsection

@section('content')
    <div class="pesan mt-2">
        @if (session('success'))
            <div class="alert alert-primary alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button> {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">



        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <span class="display-5"><i class="icon-wallet gradient-1-text"></i></span>
                        <h2 class="mt-3">
                            {{ formatRupiah($kasKecil, true) }}</h2>
                        <p>Kas Kecil</p>
                        @if (auth()->check())
                            @if (auth()->user()->level == 2)
                                @foreach ($kasKecils as $kasKecil)
                                    @if (!$loop->first && $kasKecil->no_reff == $kasKecils[$loop->index - 1]->no_reff)
                                        @continue
                                    @endif
                                    <form id="deleteForm" action="{{ route('kas.hapusKasKecil', $kasKecil->no_reff) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete()">Hapus</button>
                                    </form>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <span class="display-5"><i class="icon-wallet gradient-2-text"></i></span>
                        <h2 class="mt-3">
                            {{ formatRupiah($tunai, true) }}</h2>
                        <p>Kas Penjualan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <span class="display-5"><i class="icon-credit-card gradient-3-text"></i></span>
                        <h2 class="mt-3" data-toggle="modal" data-target="#detailBankSaldoModal">
                            {{ formatRupiah($bank, true) }}</h2>
                        <p>Kas Bank</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('modal')
    <div class="modal fade" id="detailBankSaldoModal" tabindex="-1" aria-labelledby="detailBankSaldoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailBankSaldoModalLabel">Detail Kas Bank </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bank</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankDetails as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail['bank'] }}</td>
                                        <td>Rp. {{ formatRupiah($detail['saldo'], true) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Saldo Kas Kecil --}}
    <div class="modal fade" id="tambahKasKecilModal" tabindex="-1" aria-labelledby="tambahKasKecilModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKasKecilModalLabel">Tambah Saldo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form action="{{ route('kas.tambahKas') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $name_user }}" name="kasir">
                        <input type="hidden" name="idgenerate">
                        <input type="hidden" name="noreff" value="111">
                        <div class="form-group">
                            <label for="Akun">Akun</label>
                            <select name="kaskecil" id="kaskecil" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="kaskecil">Kas Kecil</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" class="form-control" id="nominal" name="nominal">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script>
    function confirmDelete() {
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
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
