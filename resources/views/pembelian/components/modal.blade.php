 {{-- Modal --}}
 <div class="modal fade bd-pembelian-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-fullscreen">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Tambah Pembelian</h5>
                 <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class='row'>
                     <form action="{{ url('pembelian') }}" method="POST" class="form-pembelian">
                         @csrf
                         <input type="hidden" name="id">
                         <input type="hidden" name="id_user">
                         {{-- <input type="hidden" name="metode" value="888"> --}}
                         <div class="col-12">
                             <div class="d-flex flex-column flex-md-row">
                                 <div class="mr-auto p-2">
                                     <div class="d-inline p-2 bg-info text-white">No. #{{ $nomorPembelian }} <span
                                             id="id_pembelian"></span>
                                     </div>
                                     <div class="d-inline p-2 bg-default">Kasir : <span
                                             id="nama">{{ $name_user }}</span></div>
                                 </div>
                                 <div class="p-2">
                                     <div class="input-group">
                                         <span class="input-group-prepend">
                                             <span class="input-group-text">Tanggal Transaksi</span>
                                         </span>
                                         <input type="text" class="form-control form-control-sm w-150px date_p"
                                             id="date_p" value="{{ \Carbon\Carbon::now()->toFormattedDateString() }}"
                                             readonly>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-12">
                             <div class="table-responsive">
                                 <table class="table table-striped table-sm" id="table_pembelian">
                                     <thead>
                                         <tr>
                                             <td>Bahan</td>
                                             <td>Jenis akun</td>
                                             <td>Supplier</td>
                                             <td>Keterangan</td>
                                             <td>Qty</td>
                                             <td>Nominal</td>
                                             <td>Satuan</td>
                                             <td>Sub total</td>
                                             <td>
                                                 <button type="button" class="btn btn-info btn-sm add_mores"
                                                     title="Tambah Baru">
                                                     <i class="fa fa-plus"></i>
                                                 </button>
                                             </td>
                                         </tr>
                                     </thead>
                                     <tbody class="body-tabel">
                                         <tr class="form_pembelian" id="form_pembelian">
                                             <td style="display: none;">
                                                 <input type="hidden" id="nopembelian" value="{{ $nomorPembelian }}"
                                                     name="nopembelian[]" class="newform">
                                                 <input type="hidden" name="id_generate[]" value="{{ $idgenerate }}">
                                             </td>
                                             <td class="col-12 col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <input type="text" class="form-control input-default bahan"
                                                         id="bahan" name="bahan[]" />
                                                     <input type="hidden" id="idBahanSelected" name="id_bahan[]" />
                                                 </div>
                                             </td>

                                             <td class="col-12 col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <input type="text" class="form-control input-default jenisakun"
                                                         id="jenisakun" name="jenis[]" />

                                                     <input type="hidden" id="idJenis" name="id_jenis[]" />
                                                 </div>
                                             </td>
                                             <td class="col-12 col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <input type="text" class="form-control input-default supplier"
                                                         id="supplier" name="supplier[]" />

                                                     <input type="hidden" id="idSupplier" name="id_supplier[]" />

                                                 </div>

                                             </td>
                                             <td class="col-12 col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <input type="text" class="form-control input-default keterangan"
                                                         id="keterangan" name="keterangan[]" autocomplete="off"
                                                         autofocus />
                                                 </div>

                                             </td>
                                             <td class="col-12 col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <input type="number" class="form-control input-default jumlah"
                                                         id="jumlah" name="jumlah[]" autocomplete="off" autofocus />
                                                 </div>
                                             </td>
                                             <td class="col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <input type="text" class="form-control input-default harga"
                                                         id="nominal" name="nominal[]" autocomplete="off"
                                                         autofocus />
                                                 </div>
                                             </td>
                                             <td class="col-12 col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <select class="form-control input-default satuan" id="satuan"
                                                         name="satuan[]">
                                                         @foreach ($satuan as $item)
                                                             <option value="{{ $item->satuan }}">{{ $item->satuan }}
                                                             </option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </td>
                                             <td class="col-12 col-md-1">
                                                 <div class="form-group p-0 m-0">
                                                     <input type="text" class="form-control input-default total"
                                                         id="total" name="subtotal" readonly />
                                                 </div>
                                             </td>
                                             <td class="col-12 col-md-1">
                                                 <button type="button" class="btn btn-danger btn-sm hapusform"><i
                                                         class="fa fa-times"></i></button>
                                             </td>
                                         </tr>

                                     </tbody>
                                     <tfoot>
                                         <tr>
                                             <td colspan="6">&nbsp;</td>
                                             <td>Total pembelian</td>
                                             <td colspan="1">
                                                 <input class="form-control form-control-sm subtotal" id="subtotal"
                                                     name="totalpembelian" type="text" readonly>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td colspan="8">&nbsp;</td>
                                         </tr>
                                     </tfoot>
                                 </table>
                             </div>
                         </div>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" data-toggle="modal"
                         data-target="#bayarPembelianModal">
                         Bayar
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>

 {{-- Modal Bayar Pembelian --}}
 <div class="modal fade" id="bayarPembelianModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="bayarPembelianModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="bayarPembelianModalLabel">Bayar Pembelian No# {{ $nomorPembelian }}</h5>
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
                                 <span class="input-group-text" for="caraBayar">CARA BAYAR</span>
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
                                     <option value="{{ $item->id }}" selected>{{ $item->bank }}</option>
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
                                 class="form-control form-control-sm input jumlahBayar" autofocus autocomplete="off">
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                 <button type="submit" class="btn btn-primary">Simpan</button>
             </div>
             </form>
         </div>
     </div>
 </div>

 {{-- Modal Edit Pembelian --}}
 @foreach ($datas as $item)
     <div class="modal fade bd-editPembelian-modal-lg{{ $item->id_pembelian_generate }}" tabindex="-1"
         role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-fullscreen">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">Edit Pembelian</h5>
                     <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <div class='row'>
                         <form action="{{ url('pembelian') }}" method="POST" class="form-pembelian">
                             @csrf
                             <input type="hidden" name="id">
                             <input type="hidden" name="id_user">
                             {{-- <input type="hidden" name="metode" value="888"> --}}
                             <div class="col-12">
                                 <div class="d-flex flex-column flex-md-row">
                                     <div class="mr-auto p-2">
                                         <div class="d-inline p-2 bg-info text-white">No.
                                             #{{ $item->id_pembelian_generate }} <span id="id_pembelian"></span>
                                         </div>
                                         <div class="d-inline p-2 bg-default">Kasir : <span
                                                 id="nama">{{ $name_user }}</span></div>
                                     </div>
                                     <div class="p-2">
                                         <div class="input-group">
                                             <span class="input-group-prepend">
                                                 <span class="input-group-text">Tanggal Transaksi</span>
                                             </span>
                                             <input type="text" class="form-control form-control-sm w-150px date_p"
                                                 id="date_p"
                                                 value="{{ \Carbon\Carbon::now()->toFormattedDateString() }}"
                                                 readonly>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-12">
                                 <div class="table-responsive">
                                     <table class="table table-striped table-sm" id="table_pembelian">
                                         <thead>
                                             <tr>
                                                 <td>Bahan</td>
                                                 <td>Jenis akun</td>
                                                 <td>Supplier</td>
                                                 <td>Keterangan</td>
                                                 <td>Qty</td>
                                                 <td>Nominal</td>
                                                 <td>Satuan</td>
                                                 <td>Sub total</td>
                                                 <td>
                                                     <button type="button" class="btn btn-info btn-sm add_mores"
                                                         title="Tambah Baru">
                                                         <i class="fa fa-plus"></i>
                                                     </button>
                                                 </td>
                                             </tr>
                                         </thead>
                                         <tbody class="body-tabel">
                                             <tr class="form_pembelian" id="form_pembelian">
                                                 <td style="display: none;">
                                                     <input type="hidden" id="nopembelian"
                                                         value="{{ $item->id_pembelian_generate }}"
                                                         name="nopembelian[]" class="newform">
                                                     <input type="hidden" name="id_generate[]"
                                                         value="{{ $item->id_generate }}">
                                                 </td>
                                                 <td class="col-12 col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="text"
                                                             class="form-control input-default bahan" id="bahan"
                                                             name="bahan[]" value="{{ $item->bahans->bahan }}" />
                                                         <input type="hidden" id="idBahanSelected"
                                                             name="id_bahan[]" />
                                                     </div>
                                                 </td>

                                                 <td class="col-12 col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="text"
                                                             class="form-control input-default jenisakun"
                                                             id="jenisakun" name="jenis[]"
                                                             value="{{ $item->jenisP->nama_jenis }}" />

                                                         <input type="hidden" id="idJenis" name="id_jenis[]" />
                                                     </div>
                                                 </td>
                                                 <td class="col-12 col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="text"
                                                             class="form-control input-default supplier"
                                                             id="supplier" name="supplier[]"
                                                             value="{{ $item->suppliers->nama }}" />

                                                         <input type="hidden" id="idSupplier"
                                                             name="id_supplier[]" />

                                                     </div>

                                                 </td>
                                                 <td class="col-12 col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="text"
                                                             class="form-control input-default keterangan"
                                                             id="keterangan" name="keterangan[]"
                                                             value="{{ $item->keterangan }}" />
                                                     </div>

                                                 </td>
                                                 <td class="col-12 col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="number"
                                                             class="form-control input-default jumlah" id="jumlah"
                                                             name="jumlah[]" value="{{ $item->jumlah }}" />
                                                     </div>
                                                 </td>
                                                 <td class="col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="text"
                                                             class="form-control input-default harga" id="nominal"
                                                             name="nominal[]"
                                                             value="{{ formatRupiah($item->total) }}" />
                                                     </div>
                                                 </td>
                                                 <td class="col-12 col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="text"
                                                             class="form-control input-default satuan" id="satuan"
                                                             name="satuan[]" value="{{ $item->satuan }}" />
                                                     </div>
                                                 </td>
                                                 <td class="col-12 col-md-1">
                                                     <div class="form-group p-0 m-0">
                                                         <input type="text"
                                                             class="form-control input-default total" id="total"
                                                             name="subtotal" readonly
                                                             value="{{ formatRupiah($item->subtotal) }}" />
                                                     </div>
                                                 </td>
                                                 <td class="col-12 col-md-1">
                                                     <button type="button" class="btn btn-danger btn-sm hapusform"><i
                                                             class="fa fa-times"></i></button>
                                                 </td>
                                             </tr>

                                         </tbody>
                                         <tfoot>
                                             <tr>
                                                 <td colspan="6">&nbsp;</td>
                                                 <td>Total pembelian</td>
                                                 <td colspan="1">
                                                     <input class="form-control form-control-sm subtotal"
                                                         id="subtotal" name="totalpembelian" type="text"
                                                         value="{{ formatRupiah($item->subtotal) }}" readonly>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td colspan="8">&nbsp;</td>
                                             </tr>
                                         </tfoot>
                                     </table>
                                 </div>
                             </div>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="button" class="btn btn-primary" data-toggle="modal"
                             data-target="#bayarPembelianModal">
                             Bayar
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endforeach
