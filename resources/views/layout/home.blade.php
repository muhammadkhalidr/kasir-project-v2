@extends('layout.main')

@section('judul')
    <h3>Dashboard</h3>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-sm-6">
            <div class="card gradient-4">
                <div class="card-body">
                    <h3 class="card-title text-white">Orderan Total</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $totalOrderan }} </h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card gradient-2">
                <div class="card-body">
                    <h3 class="card-title text-white">Orderan Hari Ini</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $orderanHariIni }}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card gradient-1">
                <div class="card-body">
                    <h3 class="card-title text-white">Konsumen</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $konsumen }}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h4 class="mb-2">Transaksi</h4>
                        <div class="btn btn-sm btn-danger float-right mb-2"><a href="{{ url('orderan') }}"
                                class="text-white">Semua
                                &#10095;</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table thead-primary">
                                <tr>
                                    <th>Invoice</th>
                                    <th>Konsumen</th>
                                    <th>Status</th>
                                    <th>Kasir</th>
                                </tr>
                                <tbody>
                                    @foreach ($orderan as $item)
                                        @if (!$loop->first && $item->notrx == $orderan[$loop->index - 1]->notrx)
                                            @continue
                                        @endif
                                        <tr>
                                            <td><span class="badge badge-info">{{ $item->notrx }}</span></td>
                                            <td style="font-size:12px">{{ $item->pelanggans->nama }}</td>
                                            <td><span
                                                    class="badge badge-{{ $item->status == 'Lunas' ? 'success' : 'danger' }}">{{ $item->status }}</span>
                                            </td>
                                            <td style="font-size:12px">{{ $item->name_kasir }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h4 class="mb-1">Grafik Pendapatan</h4>
                    </div>
                </div>
                <div class="chart-wrapper p-4">
                    <canvas id="chartLine"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- ------------------------ --}}

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h4 class="mb-2">Piutang Terbesar</h4>
                        <div class="btn btn-sm btn-danger float-right mb-2"><a href="{{ url('piutang') }}"
                                class="text-white">Semua
                                &#10095;</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table thead-primary">
                                <tr>
                                    <th>Invoice</th>
                                    <th>Konsumen</th>
                                    <th>Total</th>
                                </tr>
                                <tbody>
                                    @foreach ($piutang as $item)
                                        @if (!$loop->first && $item->notrx == $piutang[$loop->index - 1]->notrx)
                                            @continue
                                        @endif
                                        <tr>
                                            <td><span class="badge badge-info">{{ $item->notrx }}</span></td>
                                            <td style="font-size:12px">{{ $item->pelanggans->nama }}</td>
                                            <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @if (count($piutang) == 0)
                                    <tr>
                                        <td>Belum ada data piutang</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h4 class="mb-2">Penjualan Terbesar</h4>
                        <div class="table-responsive">
                            {{-- Filter per tahun --}}
                            <div class="btn-group dropdown mb-2 float-right">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Per
                                    Tahun</button>
                                <div class="dropdown-menu">
                                    @foreach ($tahunUnik as $tahun)
                                        <a class="dropdown-item"
                                            href="{{ route('penjualan.filter', ['tahun' => $tahun]) }}">{{ $tahun }}</a>
                                    @endforeach
                                </div>
                            </div>
                            {{-- End Filter per tahun --}}

                            {{-- Filter per bulan --}}
                            <div class="btn-group dropleft mb-2 mr-2 float-right">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Per
                                    Bulan</button>
                                <div class="dropdown-menu">
                                    @foreach ($tahunUnik as $tahun)
                                        @for ($i = 1; $i <= 12; $i++)
                                            @php
                                                $bulan = DateTime::createFromFormat('!m', $i)->format('F');
                                            @endphp
                                            <a class="dropdown-item"
                                                href="{{ route('penjualan.filter.month', ['tahun' => $tahun, 'bulan' => $i]) }}">{{ $bulan }}</a>
                                        @endfor
                                    @endforeach
                                </div>
                            </div>
                            {{-- End Filter per bulan --}}


                            <table class="table thead-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga Satuan / Meter</th>
                                    <th>Jumlah</th>
                                    <th>Total Penjualan</th>
                                    <th>Kontribusi</th>
                                </tr>
                                <tbody>
                                    @php
                                        // Menghitung total penjualan dari semua produk
                                        $totalPenjualan = $penjualanTerbesar->sum('total_penjualan');
                                        // Menghitung total biaya pokok dari semua produk
                                        $totalBiayaPokok = $penjualanTerbesar->sum(function ($item) {
                                            return $item->total_jumlah * $item->produks->harga_jual;
                                        });
                                        // Menghitung kontribusi keseluruhan
                                        $kontribusiKeseluruhan = $totalPenjualan - $totalBiayaPokok;
                                    @endphp
                                    @foreach ($penjualanTerbesar as $index => $item)
                                        <tr>
                                            <td><span
                                                    class="badge badge-info">{{ $index + $penjualanTerbesar->firstItem() }}</span>
                                            </td>
                                            <td>{{ $item->produks->judul }}</td>
                                            <td class="text-center">{{ formatRupiah($item->produks->harga_jual, true) }}
                                            </td>
                                            <td class="text-center">{{ $item->total_jumlah }}</td>
                                            <td>Rp. {{ number_format($item->total_penjualan, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $kontribusiProduk =
                                                        $item->total_penjualan -
                                                        $item->total_jumlah * $item->produks->harga_jual;
                                                    $persentaseKontribusi = ($kontribusiProduk / $totalPenjualan) * 100;
                                                @endphp
                                                {{ number_format($persentaseKontribusi, 2) }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <div class="d-flex justify-content-start">
                                @php
                                    $hitungProduk = $penjualanTerbesar->unique('id_produk')->count();
                                @endphp

                                <p class="mr-3">Menampilkan {{ $hitungProduk }} hingga {{ $hitungProduk }} dari
                                    {{ $hitungProduk }} data</p>
                            </div>

                            <div class="d-flex justify-content-end">
                                {{ $penjualanTerbesar->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    </div>
@endsection
@section('js')
    <script>
        var totalPendapatan = @json($pendapatanData);
        var totalPengeluaran = @json($pengeluaranData);

        var ctx = document.getElementById('chartLine').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pendapatan',
                    data: totalPendapatan,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }, {
                    label: 'Pengeluaran',
                    data: totalPengeluaran,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
