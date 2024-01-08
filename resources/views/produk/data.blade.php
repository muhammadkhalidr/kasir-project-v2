@extends('jbahan.index')

@section('judul')
    <h4>Jenis Bahan</h4>
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header pb-2">
                    <div class="input-group">
                        <div class="input-group-prepend mr-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahDataProduk">
                                <span class="icon text-white-50">
                                    <i class="fa fa-plus fa-fw"></i>
                                </span>
                                Tambah Data
                            </button>
                        </div>

                        <div class="input-group-prepend ml-2">
                            <span class="input-group-text">Limit</span>
                        </div>
                        {{-- <form method="post" action="{{ url('bahan') }}">
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
                        </form> --}}

                        <!-- Search input -->
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <form method="get" action="{{ url('jenis-pengeluaran') }}" id="searchForm">
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
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button> {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                @foreach ($datas as $produk)
                                <div class="col-md-6 col-lg-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $produk->judul }}</h5>
                                            <p class="card-text">{{ $produk->barcode }}</a>
                                            <p class="card-text">{{ $produk->kategories->kategori }} | {{ $produk->bahans->bahan }}</a>
                                        </div>
                                        <div class="card-footer text-muted" style="display: inline">
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card shadow d-flex justify-content-start">
                        <div>
                            <p class="mr-3">Menampilkan {{ $datas->firstItem() }} hingga {{ $datas->lastItem() }} dari
                                {{ $datas->total() }} data</p>
                        </div>
                    </div> --}}

                    <div class="d-flex justify-content-end">
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="tambahDataProduk" tabindex="-1" aria-labelledby="tambahDataProdukLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataProdukLabel">Tambah Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('produk') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="id_jenis">Nama Produk</label>
                            <input type="text" class="form-control" id="produk" name="produk">
                        </div>
                
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="barcode" name="barcode">
                            <div class="input-group-append">
                                <button class="btn btn-outline-dark" type="button" onclick="generateRandomBarcode()">Generate</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jenis">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control">
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jenis">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control">
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="publikasi">Publikasi</label>
                            <select name="publikasi" id="publikasi" class="form-control">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
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
    @foreach ($datas as $item)
        <div class="modal fade" id="editJenisBahan{{ $item->id }}" tabindex="-1" aria-labelledby="editJenisBahan"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editJenisBahan">Edit Jenis Bahan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('bahan', ['id' => $item->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="bahan">Bahan</label>
                                <input type="text" class="form-control" id="bahan" name="bahan"
                                    value="{{ $item->bahan }}">
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="{{ $item->kategories->id }}">{{ $item->kategories->kategori }}</option>

                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="{{ $item->status }}">{{ ($item->status == 'Y' ? 'Aktif' : 'Tidak Aktif' ) }}</option>
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
    @endforeach
    {{-- End Modal Edit Data --}}
@endsection
@section('js')
    <script>
    function hapusBahan(id) {
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
                document.getElementById('hapusBahan' + id).submit();
            }
        });
    }

    function generateRandomBarcode() {
            var barcodeValue = generateRandomEAN13();
            document.getElementById('barcode').value = barcodeValue;
        }

        function generateRandomEAN13() {
            var randomNumber = Math.floor(100000000000 + Math.random() * 900000000000);

            var checkDigit = calculateEAN13CheckDigit(randomNumber);

            return randomNumber.toString() + checkDigit.toString();
        }

        function calculateEAN13CheckDigit(barcodeWithoutCheckDigit) {
            var sum = 0;

            for (var i = 0; i < barcodeWithoutCheckDigit.length; i++) {
                var digit = parseInt(barcodeWithoutCheckDigit[i]);
                sum += i % 2 === 0 ? digit : digit * 3;
            }

            var nextMultipleOfTen = Math.ceil(sum / 10) * 10;

            return nextMultipleOfTen - sum;
        }
    </script>
@endsection
