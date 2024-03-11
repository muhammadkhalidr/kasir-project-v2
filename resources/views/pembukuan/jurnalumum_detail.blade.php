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
                        <h4 class="card-title">Jurnal Umum Detail</h4>
                        <table class="table align-items-center table-flush mt-5" id="jurnal-umum">
                            <thead class="thead-light">
                                <tr>
                                    <th class="w-5">Tanggal</th>
                                    <th scope="col">Keterangan</th>
                                    <th>No Akun</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $index => $data)
                                    <tr>
                                        <td>{{ $data->created_at->isoFormat('D MMMM Y') }}</td>
                                        <td>
                                            @if ($data->tipe == 'debit')
                                                <p class="text-left">{{ $data->akuns->first()->nama_reff }}</p>
                                            @elseif ($data->tipe == 'kredit')
                                                <p class="text-right">{{ $data->akuns->first()->nama_reff }}</p>
                                            @endif
                                        </td>
                                        <td>{{ $data->no_reff }}</td>
                                        @if ($data->tipe == 'debit')
                                            <td>{{ formatRupiah($data->nominal, true) }}</td>
                                            <td>Rp.0</td>
                                        @elseif ($data->tipe == 'kredit')
                                            <td>Rp.0</td>
                                            <td>{{ formatRupiah($data->nominal, true) }}</td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editJurnal{{ $data->id_transaksi }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form
                                                action="{{ route('jurnal.delete', ['id_transaksi' => $data->id_transaksi]) }}"
                                                method="POST" id="hapusJurnal{{ $data->id_transaksi }}"
                                                style="display: inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" title="Hapus Data" class="btn btn-sm btn-danger"
                                                    onclick="hapusJurnal({{ $data->id_transaksi }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if (count($datas) == 0)
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <p>Belum ada data jurnal</p>
                                    </td>
                                </tr>
                            @endif
                            <tfoot>
                                <tr>
                                    <th class="w-5">Jumlah Total</th>
                                    <th scope="col"></th>
                                    <th></th>
                                    <th
                                        class="{{ $datas->where('tipe', 'debit')->sum('nominal') == $datas->where('tipe', 'debit')->sum('nominal') ? 'text-success' : 'text-danger' }}">
                                        {{ formatRupiah($datas->where('tipe', 'debit')->sum('nominal'), true) }}</th>
                                    <th
                                        class="{{ $datas->where('tipe', 'kredit')->sum('nominal') == $datas->where('tipe', 'kredit')->sum('nominal') ? 'text-success' : 'text-danger' }}">
                                        {{ formatRupiah($datas->where('tipe', 'kredit')->sum('nominal'), true) }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>

                        </table>
                        <div
                            class="d-flex w-full p-2 text-white h3 justify-content-center {{ $datas->where('tipe', 'debit')->sum('nominal') == $datas->where('tipe', 'kredit')->sum('nominal') ? 'bg-success' : 'bg-danger' }}">
                            {{ $datas->where('tipe', 'debit')->sum('nominal') == $datas->where('tipe', 'kredit')->sum('nominal') ? 'SEIMBANG' : 'TIDAK SEIMBANG' }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    @foreach ($datas as $data)
        <div class="modal fade" id="editJurnal{{ $data->id_transaksi }}" tabindex="-1"
            aria-labelledby="editJurnalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editJurnalLabel{{ $data->id_transaksi }}">Edit Jurnal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('jurnal.edit', ['id_transaksi' => $data->id_transaksi]) }}"
                            method="POST">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <input type="date" name="tgl" class="form-control"
                                    value="{{ $data->created_at->format('Y-m-d') }}">
                            </div>

                            <div class="form-group">
                                <label for="akun">Akun</label>
                                <select name="akun" id="akun" class="form-control" required>
                                    @foreach ($akuns as $akun)
                                        <option value="{{ $akun->id_akun }}"
                                            {{ $data->akuns->first()->id_akun == $akun->id_akun ? 'selected' : '' }}>
                                            {{ $akun->nama_reff }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nominal">Nominal</label>
                                <input type="text" class="form-control" id="saldo" name="saldo"
                                    value="{{ formatRupiah($data->nominal) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="jsaldo">Jeni Saldo</label>
                                <select name="jsaldo" id="jsaldo" class="form-control" required>
                                    @php
                                        $jsaldo = ['kredit' => 'Kredit', 'debit' => 'Debit'];
                                    @endphp
                                    @foreach ($jsaldo as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $data->tipe == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
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
</div>
@endforeach
{{-- End Modal Edit --}}

</div>


<!-- #/ container -->
<!--**********************************
                Content body end
            ***********************************-->
@include('partials.footer')
<script type="text/javascript">
    function hapusJurnal(id) {
        Swal.fire({
            title: 'Hapus Jurnal ?',
            text: "Data yang di hapus tidak dapat dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('hapusJurnal' + id).submit();
            }
        });
    }

    $(document).ready(function() {
        $('#saldo').mask('#.##0', {
            reverse: true
        });
    });
</script>
