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
                                                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($produk->barcode, 'EAN13') }}"
                                                    alt="{{ $produk->judul }}" title="{{ $produk->judul }}" />
                                                <p class="card-text">{{ $produk->barcode }}</a>
                                                <p class="card-text">{{ $produk->kategories->kategori }} |
                                                    {{ $produk->bahans->bahan }}</a>
                                            </div>
                                            <div class="card-footer text-muted">
                                                <form action="{{ url('bahan' . $produk->id) }}" style="display: inline">
                                                    <button class="btn btn-sm btn-primary" type="button"
                                                        data-toggle="modal"
                                                        data-target="#editProduk{{ $produk->id }}">Edit</button>
                                                </form>

                                                <form id="hapusProduk{{ $produk->id }}"
                                                    action="{{ url('produk/' . $produk->id) }}" method="POST"
                                                    style="display: inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="button" title="Hapus Data" class="btn btn-sm btn-danger"
                                                        onclick="hapusProduk({{ $produk->id }})">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
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

                </div>
            </div>


            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header pb-2">
                            <div>
                                <p class="mr-3">Menampilkan {{ $datas->firstItem() }} hingga {{ $datas->lastItem() }}
                                    dari
                                    {{ $datas->total() }} data</p>

                                <div class="d-flex justify-content-end">
                                    {{ $datas->links() }}
                                </div>
                            </div>
                        </div>
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
                    <h5 class="modal-title" id="tambahDataProdukLabel">Tambah Profuk</h5>
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
                            <input type="number" class="form-control" id="barcode" name="barcode">
                            <div class="input-group-append">
                                <button class="btn btn-outline-dark" type="button"
                                    onclick="generateRandomBarcode()">Generate</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="ukuran">Ukuran Bawaan</label>
                                <input type="text" class="form-control" name="ukuran" id="ukuran">
                            </div>
                            <div class="col">
                                <label for="jumlah">Jumlah Bawaan</label>
                                <input type="text" class="form-control" name="jumlah" id="jumlah">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="hargabeli">Harga Beli</label>
                                <input type="text" class="form-control" name="hargabeli" id="hargabeli">
                            </div>
                            <div class="col">
                                <label for="hargajual">Harga Jual</label>
                                <input type="text" class="form-control hargajual" name="hargajual" id="hargajual">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="bahan">Bahan</label>
                                <select name="bahan" id="bahan" class="form-control">
                                    @foreach ($bahan as $item)
                                        <option value="{{ $item->id }}">{{ $item->bahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="public" value="1">
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
        <div class="modal fade" id="editProduk{{ $item->id }}" tabindex="-1" aria-labelledby="editProduk"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProduk">Edit Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('produk', ['id' => $item->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="produk">Nama Produk</label>
                                <input type="text" class="form-control" id="produk" name="produk"
                                    value="{{ $item->judul }}">
                            </div>

                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="barcode" name="barcode"
                                    value="{{ $item->barcode }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-dark" type="button"
                                        onclick="generateRandomBarcode()">Generate</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="ukuran">Ukuran Bawaan</label>
                                    <input type="text" class="form-control" name="ukuran" id="ukuran"
                                        value="{{ $item->ukuran }}">
                                </div>
                                <div class="col">
                                    <label for="jumlah">Jumlah Bawaan</label>
                                    <input type="text" class="form-control" name="jumlah" id="jumlah"
                                        value="{{ $item->jumlah }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="hargabeli">Harga Beli</label>
                                    <input type="text" class="form-control" name="hargabeli" id="hargabeli"
                                        value="{{ $item->harga_beli }}">
                                </div>
                                <div class="col">
                                    <label for="hargajual">Harga Jual</label>
                                    <input type="text" class="form-control hargajual" name="hargajual" id="hargajual"
                                        value="{{ $item->harga_jual }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="{{ $item->id_kategori }}" selected>
                                            {{ $item->kategories->kategori }}</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="bahan">Bahan</label>
                                    <select name="bahan" id="bahan" class="form-control">
                                        <option value="{{ $item->id_bahan }}" selected>{{ $item->bahans->bahan }}
                                        </option>
                                        @foreach ($bahan as $bahans)
                                            <option value="{{ $bahans->id }}">{{ $bahans->bahan }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
        function hapusProduk(id) {
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
                    document.getElementById('hapusProduk' + id).submit();
                }
            });
        }

        function generateRandomBarcode() {
            var barcodeValue = generateRandomEAN13();
            document.getElementById('barcode').value = barcodeValue;
        }

        function generateRandomEAN13() {
            var randomNumber = Math.floor(100000000000 + Math.random() * 900000000000);
            var checkDigit = calculateEAN13CheckDigit(randomNumber.toString());
            return randomNumber.toString() + checkDigit.toString();
        }

        function calculateEAN13CheckDigit(barcodeWithoutCheckDigit) {
            var sum = 0;
            for (var i = 0; i < barcodeWithoutCheckDigit.length; i++) {
                var digit = parseInt(barcodeWithoutCheckDigit[i]);
                sum += (i % 2 === 0) ? digit : digit * 3;
            }
            var checkDigit = 10 - (sum % 10);
            return (checkDigit === 10) ? 0 : checkDigit;
        }



        $(document).ready(function() {
            $(document).on('keyup', '.hargajual', function() {
                $(this).val(formatRupiah($(this).val()));
            });

            $('#hargabeli').on('keyup', function() {
                $(this).val(formatRupiah($(this).val()));
            });
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? +rupiah : '');
        }
    </script>
@endsection
