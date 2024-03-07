    {{-- Modal Tambah Pengeluaran --}}
    <div class="modal fade bd-transaksi-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengeluaran Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row d-flex justify-content-end">
                        <div class="col-1">
                            <a class="btn btn-success tambahform" title="Copy"> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <form action="{{ url('pengeluaran') }}" method="POST">
                        @csrf
                        <div id="formContainer" class="form-transaksi">
                            <div class="row">
                                <div class="col">
                                    <label for="">No Pengeluaran</label>
                                    <input type="text" class="form-control nomorp" name="nopengeluaran[]"
                                        value="{{ $nomorP }}">
                                </div>
                                <div class="col">
                                    <label for="">Jenis Pengeluaran</label>
                                    <select class="form-control" name="jenispengeluaran[]" id="jenispengeluaran">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($dataJenis as $item)
                                            <option value="{{ $item->id_akun }}">{{ $item->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col" id="karyawan">
                                    <label for="">Karyawan</label>
                                    <select class="form-control" name="karyawan[]" id="karyawanSelect">
                                        @foreach ($dataKaryawan as $item)
                                            <option value="{{ $item->id_karyawan }}">{{ $item->nama_karyawan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="">Keterangan</label>
                                    <input type="text" class="form-control keterangan" name="keterangan[]">
                                </div>
                                <div class="col">
                                    <label for="">Jumlah</label>
                                    <input type="text" class="form-control jumlah" id="jumlah" name="jumlah[]">
                                </div>
                                <div class="col">
                                    <label for="">Harga</label>
                                    <input type="text" class="form-control harga" id="harga" name="harga[]">
                                </div>
                                <div class="col">
                                    <label for="">Total</label>
                                    <input type="text" class="form-control total" id="total" name="total[]"
                                        readonly>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-danger hapusform"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col">
                                <label for="">Sub Total</label>
                                <input type="text" class="form-control subtotal" id="subtotal" name="subtotal"
                                    readonly>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <p class="btn btn-danger" data-toggle="modal" data-target="#bayarPengeluaran">Bayar</p>
                        </div>

                        <div class="modal fade" id="bayarPengeluaran" data-backdrop="static" data-keyboard="false"
                            tabindex="-1" aria-labelledby="bayarPengeluaranLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bayarPengeluaranLabel">Pilih Metode Pembayaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col">
                                                <select name="metode" class="form-control">
                                                    <option value="">Pilih Metode</option>
                                                    @foreach ($bank as $via)
                                                        <option value="{{ $via->id }}">Kas Bank
                                                            {{ $via->bank }}
                                                        </option>
                                                    @endforeach
                                                    <option value="888">Kas Penjualan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{-- Modal Bayar Pembelian --}}
                        {{-- <div class="modal fade" id="bayarPengeluaran" data-backdrop="static" data-keyboard="false"
                            tabindex="-1" aria-labelledby="bayarPengeluaranLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bayarPengeluaranLabel">Pilih Metode Pembayaran
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <div class="form-group row mb-0">
                                            <label class="col-4 col-form-label">
                                                <div class="input-group">
                                                    BAYAR
                                                </div>
                                            </label>
                                            <div class="col-8">
                                                <div class="input-group input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" for="caraBayar">CARA
                                                            BAYAR</span>
                                                    </div>
                                                    <input type="hidden" id="id_bank" name="id_bank[]">
                                                    <select name="caraBayar" id="caraBayar"
                                                        class="custom-select form-control form-control-sm" required>
                                                        <option value="tunai" selected>Tunai</option>
                                                        <option value="transfer">Transfer</option>
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">AKUN</span>
                                                    </div>
                                                    <select name="tunai" id="tunai"
                                                        class="custom-select form-control form-control-sm tunai">
                                                        <option value="888" selected>Kas Penjualan</option>
                                                    </select>
                                                    <select name="rekening" id="rekening"
                                                        class="custom-select form-control form-control-sm rekening">
                                                        @foreach ($bank as $item)
                                                            <option value="{{ $item->id }}" selected>
                                                                {{ $item->bank }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label for="saldoKas" class="col-4 col-form-label">SALDO KAS</label>
                                            <div class="col-8">
                                                <div class="input-group">
                                                    <input id="saldoKas" name="saldoKas" type="text"
                                                        class="form-control form-control-sm" value="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label for="totalBayar" class="col-4 col-form-label">TOTAL BAYAR</label>
                                            <div class="col-8">
                                                <div class="input-group">
                                                    <input id="totalBayar" name="totalBayar" type="text"
                                                        class="form-control form-control-sm subtotal" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0 flat">
                                            <label for="jumlahBayar" class="col-4 col-form-label">JUMLAH BAYAR</label>
                                            <div class="col-8">
                                                <div class="input-group flat">
                                                    <input id="jumlahBayar" name="jumlahBayar" type="text"
                                                        class="form-control form-control-sm input jumlahBayar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                    </form>
                </div>
            </div>
        </div> --}}


                    </form>
                </div>
            </div>
        </div>
    </div>
