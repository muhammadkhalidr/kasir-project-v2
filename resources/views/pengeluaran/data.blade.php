@include('partials.header')
@include('partials.sidebar')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $breadcrumb }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">


        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header pb-2">
                        <div class="input-group">
                            <div class="input-group-prepend mr-2">
                                @if (auth()->check())
                                    @if (auth()->user()->level == 1)
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target=".bd-transaksi-modal-lg"> <i class="fa fa-plus"></i> Pengeluaran
                                            Baru</button>
                                    @elseif (auth()->user()->level == 2)
                                    @endif
                                @endif
                            </div>
                            <form id="datepickerForm" method="GET" action="{{ url('gaji-karyawanv2') }}">
                                @csrf
                                <div class="input-group ml-auto">
                                    <div class="input-group-prepend mr-2">
                                        <label for="datepicker" class="input-group-text">Periode</label>
                                        <input type="text" class="form-control" id="datepicker" name="filterTgl"
                                            value="{{ $selectedMonth ?? \Carbon\Carbon::now()->toDateString() }}"
                                            autocomplete="off" autofocus>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-filter"></i></button>
                                    </div>
                                </div>
                            </form>
                            <div class="input-group-prepend ml-2">
                                <span class="input-group-text">Limit</span>
                            </div>
                            <form method="get" action="{{ route('gajikaryawanv2.filterJumlah') }}">
                                @csrf
                                <div class="input-group-prepend mr-2">
                                    <select class="form-control" id="dataOptions" name="dataOptions"
                                        onchange="this.form.submit()">
                                        {{-- @foreach ($perPageOptions as $option)
                                            <option
                                                value="{{ $option }}"{{ $datas->perPage() == $option ? 'selected' : '' }}>
                                                {{ $option }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </form>
                            <form method="GET" action="{{ route('gajikaryawanv2.cari') }}" id="searchForm">
                                @csrf
                                <input type="text" class="form-control w-full" name="searchdata" id="searchInput"
                                    placeholder="Search..." />
                            </form>
                            <div class="input-group-append">
                                <button type="submit" data-info="cari" class="btn btn-success caridata"
                                    data-id="0"><i class="fa fa-search"></i> Cari</button>
                            </div>
                            <button class="btn btn-info" type="button" data-placement="left">
                                <i class="fa fa-file-pdf-o"></i>
                                <a href="{{ route('pengeluaran.print') }}" class="text-white" target="_blank">Print</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <button type="button" class="btn btn-primary"
                            onclick="window.location='{{ url('pengeluaranbaru') }}'">
                            <i class="fa fa-plus-circle"></i> Tambah Data Baru
                        </button> --}}
                        <div class="pesan mt-2">
                            @if (session('msg'))
                                <div class="alert alert-primary alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                    </button> {{ session('msg') }}
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Data</th>
                                </thead>
                                <tbody>
                                    @foreach ($groupedPengeluarans as $id_pengeluaran => $groupedPengeluaran)
                                        <tr data-parent="#table-guest">
                                            <td colspan="5" class="p-0">
                                                <table class="table table-striped">
                                                    <thead class="thead-success">
                                                        <tr>
                                                            <th>No Faktur</th>
                                                            <th>
                                                                <button class="btn btn-dark btn-sm">#
                                                                    {{ $groupedPengeluaran[0]->id_pengeluaran }}</button>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <thead class="thead-primary">
                                                        <tr>
                                                            <th style="width:4%!important" class="text-right">#No.</th>
                                                            <th>Keterangan</th>
                                                            <th class="text-left" style="width:10%!important">Jumlah
                                                            </th>
                                                            <th class="text-center">Harga</th>
                                                            <th class="text-right">Nominal</th>
                                                            <th class="text-right">Jenis</th>
                                                            <th class="text-right">Tanggal</th>
                                                            <th class="w-10 text-right">Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php $firstRow = true; @endphp
                                                        @foreach ($groupedPengeluaran as $pengeluaran)
                                                            <tr>
                                                                <td class="text-center"><span
                                                                        class="label label-info">{{ $loop->iteration }}</span>
                                                                </td>
                                                                <td>{{ $pengeluaran->keterangan }}</td>
                                                                <td class="text-left">{{ $pengeluaran->jumlah }}</td>
                                                                <td class="text-center">
                                                                    {{ formatRupiah($pengeluaran->harga, true) }}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{ formatRupiah($pengeluaran->total, true) }}
                                                                </td>
                                                                <td>{{ $pengeluaran->jenisp->nama_jenis ?? 'Kosong' }}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{ $pengeluaran->formatted_date }}</td>

                                                                <td class="text-right">
                                                                    @if ($firstRow)
                                                                        <form method="POST"
                                                                            action="{{ 'pengeluaran/' . $pengeluaran->id_pengeluaran }}"
                                                                            style="display: inline"
                                                                            id="hapusPengeluaranForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" title="Hapus Data"
                                                                                class="btn btn-sm btn-danger hapus-btn"
                                                                                onclick="hapusPengeluaran()">
                                                                                <i class="fa fa-trash"></i> Hapus
                                                                            </button>
                                                                        </form>

                                                                        <a href="{{ route('cetak.print_invoice', $pengeluaran->id_pengeluaran) }}"
                                                                            class="btn btn-sm btn-primary mb-1"
                                                                            title="Print Invoice" target="_blank">
                                                                            <i class="fa fa-print"></i>
                                                                        </a>
                                                                        @php $firstRow = false; @endphp
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr style="background-color: #4d4d4d;color:white;">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-right">
                                                                <b><i>Total</i></b>
                                                            </td>
                                                            <td class="text-right">
                                                                <b><i></i></b>

                                                                {{ formatRupiah($totals[$id_pengeluaran], true) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-left"><strong>Total Pengeluaran</strong></td>
                                        <td class="text-right">
                                            <strong>{{ formatRupiah($totals->sum(), true) }}</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="d-flex justify-content-start">
                                <p class="mr-3">Menampilkan {{ $datas->firstItem() }} hingga
                                    {{ $datas->lastItem() }}
                                    dari
                                    {{ $datas->total() }} data</p>
                            </div> --}}


                            <div class="d-flex justify-content-start">
                                @php
                                    $hitungNoTrx = $datas->unique('id_pengeluaran')->count();
                                @endphp

                                <p class="mr-3">Menampilkan {{ $hitungNoTrx }} hingga {{ $hitungNoTrx }} dari
                                    {{ $hitungNoTrx }} data</p>
                            </div>

                            <div class="d-flex justify-content-end">
                                {{ $datas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
    @include('pengeluaran.components.modal')
</div>
<!--**********************************
            Content body end
        ***********************************-->

@include('partials.footer')

<script>
    $(document).ready(function() {
        // Menangani klik pada tombol tambahform
        $(document).on("click", ".tambahform", function() {
            // Duplikat form-transaksi
            var newForm = $(".form-transaksi:first").clone();

            // Bersihkan nilai input di form baru
            newForm.find(".keterangan").val("");
            newForm.find(".jumlah").val("");
            newForm.find(".harga").val("");
            newForm.find(".total").val("");

            // Sisipkan form baru setelah form terakhir
            $(".form-transaksi:last").after(newForm);

            // Tambahkan event handler untuk tombol hapus pada form baru
            newForm.find(".hapusform").on("click", function() {
                // Hapus form saat tombol hapus diklik
                $(this).closest(".form-transaksi").remove();
            });

            $(document).on("click", ".hapusform", function() {
                // Hapus form saat tombol hapus diklik
                $(this).closest(".form-transaksi").remove();
            });
        });

        $(document).on("input", ".jumlah, .harga, .uangmuka, .sisa", function() {
            // Menghitung total untuk setiap form
            $(".form-transaksi").each(function() {
                var jumlah = parseFloat($(this).find(".jumlah").val()) || 0;
                var harga = parseFloat($(this).find(".harga").val().replace(/\./g, '').replace(
                    ',', '.')) || 0;

                var total = jumlah * harga;

                // Format total sesuai dengan harga
                $(this).find(".total").val(formatRupiah(total.toString()));
            });

            // Menghitung subtotal dari semua total
            var subtotal = 0;
            $(".form-transaksi").each(function() {
                subtotal += parseFloat($(this).find(".total").val().replace(/\./g, '').replace(
                    ',', '.')) || 0;
            });

            // Mengupdate nilai input subtotal
            $(".subtotal").val(formatRupiah(subtotal.toString()));
        });

        // Menangani perubahan nilai saat formulir baru ditambahkan
        $(document).on("input", ".form-transaksi:last .jumlah, .form-transaksi:last .harga", function() {
            var jumlah = parseFloat($(this).closest(".row").find(".jumlah").val()) || 0;
            var harga = parseFloat($(this).closest(".row").find(".harga").val().replace(/\./g, '')
                .replace(',', '.')) || 0;

            var total = jumlah * harga;

            // Format total sesuai dengan harga
            $(this).closest(".row").find(".total").val(formatRupiah(total.toString()));
        });
    });
</script>
{{-- <script>
    // Fungsi untuk menangani perubahan pada dropdown Jenis Pengeluaran
    function handleJenisPengeluaranChange() {
        var jenisPengeluaran = document.getElementById("jenispengeluaran").value;
        var karyawanInput = document.getElementById("karyawan");

        // Jika Jenis Pengeluaran bukan kasbon karyawan, sembunyikan input Karyawan
        if (jenisPengeluaran !== "Kasbon Karyawan") {
            karyawanInput.style.display = "none"; // Sembunyikan input Karyawan
        } else {
            karyawanInput.style.display = "block"; // Tampilkan kembali input Karyawan
        }
    }

    // Tambahkan event listener untuk memanggil fungsi saat dropdown Jenis Pengeluaran berubah
    document.getElementById("jenispengeluaran").addEventListener("change", handleJenisPengeluaranChange);

    // Fungsi untuk menampilkan atau menyembunyikan input Karyawan berdasarkan nilai awal
    handleJenisPengeluaranChange();
</script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initial check on page load
        toggleKaryawanVisibility();

        // Add change event listener to the "Jenis Pengeluaran" select
        document.getElementById("jenispengeluaran").addEventListener("change", function() {
            toggleKaryawanVisibility();
        });

        function toggleKaryawanVisibility() {
            // Get the selected option value
            var selectedJenis = document.getElementById("jenispengeluaran").value;

            // Get the "Karyawan" select element
            var karyawanSelect = document.getElementById("karyawanSelect");

            // Check if the selected value is not equal to 101
            if (selectedJenis !== "101") {
                // Hide the "Karyawan" div and disable the select element
                document.getElementById("karyawan").style.display = "none";
                karyawanSelect.disabled = true;
            } else {
                // Show the "Karyawan" div and enable the select element
                document.getElementById("karyawan").style.display = "block";
                karyawanSelect.disabled = false;
            }
        }
    });
</script>
<script>
    function hapusPengeluaran() {
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('hapusPengeluaranForm').submit();
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $(document).on('keyup', '.harga', function() {
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
@if (Session::has('error'))
    <script>
        swal.fire('warning!', '{{ Session::get('error') }}', 'warning');
    </script>
@endif
