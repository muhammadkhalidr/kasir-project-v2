@extends('piutang.index')

@section('judul')
    <h1>
        Data Piutang</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="" style="display:flex; position:relative;float:right;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <form action="{{ route('piutang.cari') }}" method="GET">
                            <input type="text" class="form-control" name="q" id="searchInput"
                                placeholder="Search..." value="{{ request()->q }}" />
                        </form>
                        <div class="input-group-prepend ml-2">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <form method="POST" action="#" id="searchForm">
                            @csrf
                            <input type="hidden" name="start_date" id="start_date" />
                            <input type="hidden" name="end_date" id="end_date" />
                            <input type="text" class="form-control w-10" name="daterange" />
                        </form>
                        {{-- <button class="btn btn-info ml-2" type="button" data-placement="left">
                            <i class="fa fa-file-pdf-o"></i>
                            <a href="{{ route('print.piutang') }}" class="text-white" target="_blank">Print</a>
                        </button> --}}
                        <button class="btn btn-info ml-2" type="button" data-placement="left">
                            <i class="fa fa-file-pdf-o"></i>
                            <a href="{{ route('print.piutang', ['q' => request()->q]) }}" class="text-white"
                                target="_blank">Print</a>
                        </button>
                        <button class="btn btn-danger ml-2"><a href="piutang" class="text-white">Clear</a></button>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No TRX</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $index => $item)
                                    @if ($item->status != 'Lunas')
                                        @if (!$loop->first && $item->notrx == $data[$loop->index - 1]->notrx)
                                            @continue
                                        @endif
                                        <tr>
                                            <td>{{ $index + $data->firstItem() }}</td>
                                            <td>{{ $item->notrx }}</td>
                                            <td>{{ $item->pelanggans->nama }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($data as $k => $data_item)
                                                        @if ($data_item->notrx == $item->notrx)
                                                            <li>{{ $data_item->keterangan }}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ formatRupiah($item->sisa, true) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" title="Pelunasan" data-toggle="modal"
                                                    data-target="#pelunasanModal{{ $item->notrx }}">
                                                    <a href="javascript:void(0)" class="text-white">Bayar</a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>



                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    {{-- Modal Pelunasan --}}
    @foreach ($data as $bayar)
        <div class="modal fade" id="pelunasanModal{{ $bayar->notrx }}" tabindex="-1"
            aria-labelledby="pelunasanModalLabel{{ $bayar->notrx }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pelunasanModalLabel{{ $bayar->notrx }}">Pelunasan Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('orderan.pelunasan') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="notrx" value="{{ $bayar->notrx }}">

                            <div class="form-group">
                                <label for="caraBayar{{ $bayar->notrx }}">Pilih Cara Bayar:</label>
                                <select class="form-control caraBayar" data-notrx="{{ $bayar->notrx }}" name="caraBayar">
                                    <option value="888">Tunai</option>
                                    <option value="transfer">Transfer Bank</option>
                                </select>
                            </div>

                            <div class="bankOptions" id="bankOptions{{ $bayar->notrx }}" style="display:none;">
                                <div class="form-group">
                                    <label for="via{{ $bayar->notrx }}">Pilih Bank:</label>
                                    <select class="form-control" id="via{{ $bayar->notrx }}" name="via">
                                        @foreach ($rekening as $data)
                                            <option value="{{ $data->id }}">{{ $data->bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jumlahBayar{{ $bayar->notrx }}">Jumlah Bayar:</label>
                                <input type="text" class="form-control jumlahBayar" id="jumlahBayar{{ $bayar->notrx }}"
                                    name="jumlahBayar" required>
                            </div>

                            <div class="form-group">
                                <label for="totalBayar{{ $bayar->notrx }}">Total yang Harus Dibayar:</label>
                                <input type="text" class="form-control totalBayar" id="totalBayar{{ $bayar->notrx }}"
                                    name="totalBayar" value="{{ formatRupiah($bayar->sisa) }}" readonly>
                            </div>

                            <div class="buktiTransferOptions" id="buktiTransferOptions{{ $bayar->notrx }}"
                                style="display:none;">
                                <div class="form-group">
                                    <label for="buktiTransfer{{ $bayar->notrx }}">Bukti Transfer:</label>
                                    <input type="file" class="form-control-file"
                                        id="buktiTransfer{{ $bayar->notrx }}" name="buktiTransfer">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Bayar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- modal details keterangan --}}
        <div class="modal fade" id="detailsModal{{ $bayar->notrx }}" tabindex="-1" aria-labelledby="detailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel">Detail Keterangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($ket as $data)
                            @if ($data->notrx == $bayar->notrx)
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{ $data->keterangan }}</li>
                                </ul>
                            @endif
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
        </div>
        </div>
    @endforeach
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Tampilkan atau sembunyikan opsi bank dan bukti transfer berdasarkan pilihan cara bayar
            $('.caraBayar').change(function() {
                const notrx = $(this).data('notrx');
                const bankOptions = $(`#bankOptions${notrx}`);
                const buktiTransferOptions = $(`#buktiTransferOptions${notrx}`);

                if ($(this).val() === 'transfer') {
                    bankOptions.show();
                    buktiTransferOptions.show();
                } else {
                    bankOptions.hide();
                    buktiTransferOptions.hide();
                }
            });

            // Hitung total yang harus dibayar berdasarkan jumlah bayar
            $('.jumlahBayar').on('input', function() {
                const notrx = $(this).data('notrx');
                const totalBayar = $(`#totalBayar${notrx}`);
                totalBayar.val($(this).val());
            });
        });

        $(document).ready(function() {
            $('.jumlahBayar').mask('#.##0', {
                reverse: true
            });
        });
    </script>
@endsection
