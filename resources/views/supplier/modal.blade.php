 {{-- Modal Tambah Data --}}
 <div class="modal fade" id="tambahDataSupplier" tabindex="-1" aria-labelledby="tambahDataSupplierLabel" aria-hidden="true">
     <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="tambahDataSupplierLabel">Tambah Data</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="{{ url('supplier') }}" method="post">
                     @method('POST')
                     @csrf
                     <div class="form-row">
                         <div class="form-group col-md-6">
                             <label for="perusahaan">Perusahaan</label>
                             <input type="text" class="form-control" id="perusahaan" name="perusahaan">
                         </div>
                         <div class="form-group col-md-6">
                             <label for="nama">Atas Nama</label>
                             <input type="text" class="form-control" id="nama" name="nama">
                         </div>
                     </div>
                     <div class="form-row">
                         <div class="form-group col-md-6">
                             <label for="jabatan">Jabatan</label>
                             <input type="text" class="form-control" id="jabatan" name="jabatan">
                         </div>
                         <div class="form-group col-md-6">
                             <label for="nohp">No Hp</label>
                             <input type="text" class="form-control" id="nohp" name="nohp">
                         </div>
                     </div>
                     <div class="form-row">
                         <div class="form-group col-md-6">
                             <label for="email">Email</label>
                             <input type="email" class="form-control" id="email" name="email">
                         </div>
                         <div class="form-group col-md-6">
                             <label for="jenisusaha">Jenis Usaha</label>
                             <input type="text" class="form-control" id="jenisusaha" name="jenisusaha">
                         </div>
                     </div>
                     <div class="form-row">
                         <div class="form-group col-md-4">
                             <label for="norek">No Rekening</label>
                             <input type="text" class="form-control" id="norek" name="norek">
                         </div>
                         <div class="form-group col-md-6">
                             <label for="alamat">Alamat</label>
                             <input type="text" class="form-control" id="alamat" name="alamat">
                         </div>
                         <div class="form-group col-md-2">
                             <label for="status">Status</label>
                             <select id="status" class="form-control" name="status">
                                 <option value="Y">Aktif</option>
                                 <option value="N">Tidak Aktif</option>
                             </select>
                         </div>
                     </div>

                     <div class="tombol mb-4">
                         <button type="submit" class="btn btn-primary float-right ml-2">Simpan</button>
                         <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Tutup</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
     {{-- End Modal Tambah Data --}}
