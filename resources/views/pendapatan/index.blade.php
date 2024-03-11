@include('partials.header')
@include('partials.sidebar')

<!--**********************************
                Content body start
            ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Laporan</a></li>
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
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Rincian Pendapatan</h6>
                        <div class="input-group input-group-sm w-25">
                            <div class="input-group-prepend">
                                <button class="btn btn-info" id="cetak_neraca"><i class="fa fa-file-pdf-o"></i>
                                    Print</button>
                            </div>
                            <input type="text" id="tanggal" value="" class="form-control"
                                placeholder="mm/yyyy" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice</th>
                                        <th>Tgl Order</th>
                                        <th>Konsumen</th>
                                        <th>Tgl Bayar</th>
                                        <th>Status</th>
                                        <th>Lampiran</th>
                                        <th>Jumlah Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->id_generate }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->orderans }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->bank == '888' ? 'Tunai' : 'Transfer' }}</td>
                                            <td>-</td>
                                            <td>{{ $data->pemasukan }}</td>
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
</div>



<!-- #/ container -->
<!--**********************************
                Content body end
            ***********************************-->
@include('partials.footer')
