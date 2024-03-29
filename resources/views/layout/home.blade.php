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
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body pb-0 p-4 d-flex justify-content-between">
                    <div>
                        <h4 class="mb-1">Grafik Pendapatan</h4>
                    </div>
                </div>
                <div class="chart-wrapper p-4">
                    <canvas id="chartLine"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body pb-0 p-4 d-flex justify-content-between">
                    <div>
                        <h4 class="mb-2">Transaksi</h4>
                        <div class="btn btn-sm btn-danger float-right mb-2"><a href="orderan" class="text-white">Semua
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
