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
                                <button type="button" class="btn btn-primary" data-toggle="modal" id="tambahT"
                                    data-target=".bd-transaksi-modal-lg">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-cart-plus fa-fw"></i>
                                    </span>
                                    <span class="text">Tambah Transaksi</span>
                                </button>
                            </div>

                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <form method="POST" action="{{ url('orderan.cari') }}" id="searchFormDate">
                                @csrf
                                <input type="hidden" name="start_date" id="start_date" />
                                <input type="hidden" name="end_date" id="end_date" />
                                <input type="text" class="form-control w-10" name="daterange" />
                            </form>

                            <div class="input-group-prepend ml-2">
                                <span class="input-group-text">Limit</span>
                            </div>
                            <form method="post" action="{{ route('orderan.filterJumlah') }}">
                                @csrf
                                <div class="input-group-prepend mr-2">
                                    <select class="form-control" id="dataOptions" name="dataOptions"
                                        onchange="this.form.submit()">
                                        @foreach ($perPageOptions as $option)
                                            <option
                                                value="{{ $option }}"{{ $dataOrderan->perPage() == $option ? 'selected' : '' }}>
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>

                            <!-- Search input -->
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <form method="get" action="{{ url('orderan') }}" id="searchForm">
                                @csrf
                                <input type="text" class="form-control" name="searchdata" id="searchInput"
                                    placeholder="Search..." value="{{ request('searchdata') }}" />
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
                        <div id="pesanoff"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO ORDER</th>
                                        <th>PELANGGAN</th>
                                        <th>TGL ORDER</th>
                                        <th>KASIR</th>
                                        <th>TOTAL</th>
                                        <th>DP</th>
                                        <th>SISA</th>
                                        <th>STATUS</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataOrderan as $index => $item)
                                        @if (!$loop->first && $item->notrx == $dataOrderan[$loop->index - 1]->notrx)
                                            @continue
                                        @endif
                                        <tr>
                                            <td><a class="badge badge-success text-white p-2 notrx"
                                                    style="cursor: pointer" data-toggle="modal"
                                                    data-target=".bd-datatransaksi-modal-lg{{ $item->notrx }}"><i
                                                        class="fa fa-search"></i> {{ $item->notrx }}</a>
                                            </td>
                                            <td>{{ $item->pelanggans->nama }}</td>
                                            <td>{{ $item->created_at->translatedFormat('l, d F Y') }}
                                            </td>
                                            <td>{{ $item->name_kasir }}</td>
                                            <td>{{ formatRupiah($item->subtotal) }}</td>
                                            <td>{{ formatRupiah($item->uangmuka) }}</td>
                                            <td>{{ formatRupiah($item->sisa) }}</td>
                                            <td><span
                                                    class="badge badge-{{ $item->status == 'Lunas' ? 'success' : 'warning' }} text-white p-2 notrx">{{ $item->status }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    if ($item->status == 'Lunas') {
                                                        $disable = 'disabled';
                                                    } else {
                                                        $disable = '';
                                                    }
                                                @endphp
                                                <button class="btn btn-sm btn-success" title="Pelunasan"
                                                    {{ $disable }} data-toggle="modal"
                                                    data-target="#pelunasanModal{{ $item->notrx }}">
                                                    <i class="fa fa-money"></i> BAYAR
                                                </button>
                                                <div class="btn-group mt-1" role="group">
                                                    <button type="button"
                                                        class="btn btn-sm mb-1 btn-primary flat dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <p class="ml-2">NO. #{{ $item->notrx }}</p>

                                                        <a href="{{ route('orderan.print_invoice58', $item->notrx) }}"
                                                            class="dropdown-item" target="_blank">
                                                            <span class="badge badge-info flat">
                                                                <i class="fa fa-print"></i> PRINT STRUK
                                                            </span>
                                                        </a>

                                                        <a href="{{ route('orderan.print_invoice', $item->notrx) }}"
                                                            class="dropdown-item" target="_blank">
                                                            <span class="badge badge-warning flat">
                                                                <i class="fa fa-file-pdf-o"></i> PRINT PDF
                                                            </span>
                                                        </a>
                                                        @if (auth()->check())
                                                            @if (auth()->user()->level == 1 || auth()->user()->level == 2)
                                                                <form method="POST"
                                                                    action="{{ route('orderan.destroy', $item->notrx) }}"
                                                                    style="display: inline" id="hapusOrderanForm">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" title="Hapus Data"
                                                                        data-notrx="{{ $item->notrx }}"
                                                                        class="dropdown-item"
                                                                        onclick="konfirmasiHapus('{{ $item->notrx }}')">
                                                                        <span class="badge badge-danger flat">
                                                                            <i class="fa fa-trash"></i> HAPUS DATA
                                                                        </span>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($dataOrderan->count() == 0)
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <p>Belum ada data transaksi</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th id="total"></th>
                                        <th id="uangmuka"></th>
                                        <th id="sisa"></th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </tfoot>

                            </table>
                            <div class="d-flex justify-content-start">
                                @php
                                    $hitungNoTrx = $dataOrderan->unique('notrx')->count();
                                @endphp

                                <p class="mr-3">Menampilkan {{ $hitungNoTrx }} hingga {{ $hitungNoTrx }} dari
                                    {{ $hitungNoTrx }} data</p>
                            </div>

                            <div class="d-flex justify-content-end">
                                {{ $dataOrderan->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    @include('orderan.components.modal')

    <!-- #/ container -->

</div>


{{-- End Modal --}}
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

            // Mengubah atribut id_produk untuk menghindari konflik
            var formIndex = $(".form-transaksi").length + 1;
            newForm.find(".id_produk").attr("id", "idnya" + formIndex);
            newForm.find(".produk").attr("id", "produk" + formIndex);

            // Bersihkan nilai input di form baru kecuali nama pelanggan
            // newForm.find(".produk").val("");
            // newForm.find(".id_produk").val("");
            // newForm.find(".id_kategori").val("");
            // newForm.find(".jumlah").val("");
            // newForm.find(".keterangan").val("");
            // newForm.find(".ukuran").val("");
            // newForm.find(".harga").val("");
            // newForm.find(".total").val("");

            // Hapus label dari form baru
            newForm.find("label").text("");
            // Sisipkan form baru setelah form terakhir
            $(".form-transaksi:last").after(newForm);

            // Tambahkan event handler untuk tombol hapus pada form baru
            newForm.find(".hapusform").on("click", function() {
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

            // Mengambil nilai uang muka
            var uangMuka = parseFloat($(".uangmuka").val().replace(/\./g, '').replace(',', '.')) || 0;

            // Mengurangkan uang muka dari total, bukan dari subtotal
            var totalSetelahUangMuka = subtotal - uangMuka;

            // Mengupdate nilai input subtotal
            $(".subtotal").val(formatRupiah(subtotal.toString()));

            var sisaPembayaran = parseFloat($(".sisa").val().replace(/\./g, '').replace(',', '.')) || 0;

            // Format sisa pembayaran sesuai dengan harga
            $(".sisa").val(formatRupiah(totalSetelahUangMuka.toString()));
        });

        // Menambahkan event listener untuk input uangmuka
        $(document).on("input", ".uangmuka", function() {
            // Menghitung kembali subtotal saat input uangmuka diubah
            var subtotal = 0;
            $(".form-transaksi").each(function() {
                subtotal += parseFloat($(this).find(".total").val().replace(/\./g, '').replace(
                    ',', '.')) || 0;
            });

            // Mengambil nilai uang muka
            var uangMuka = parseFloat($(".uangmuka").val().replace(/\./g, '').replace(',', '.')) || 0;

            // Mengurangkan uang muka dari total
            var totalSetelahUangMuka = uangMuka;

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
<script>
    $(document).ready(function() {
        // Tampilkan atau sembunyikan opsi bank dan bukti transfer berdasarkan pilihan cara bayar
        $('.caraBayar').change(function() {
            const notrx = $(this).data('notrx');
            const bankOptions = $(`#bankOptions${notrx}`);
            const buktiTransferOptions = $(`#buktiTransferOptions${notrx}`);
            const viaElement = $(`#via${notrx}`);

            if ($(this).val() === 'transfer') {
                bankOptions.show();
                buktiTransferOptions.show();
                viaElement.prop('disabled', false); // Aktifkan elemen via jika transfer dipilih
            } else {
                bankOptions.hide();
                buktiTransferOptions.hide();
                viaElement.prop('disabled', true); // Nonaktifkan elemen via jika tidak transfer
            }
        });

        // Sembunyikan opsi bank dan bukti transfer saat halaman dimuat jika caraBayar awalnya bukan 'transfer'
        $('.caraBayar').each(function() {
            const notrx = $(this).data('notrx');
            const bankOptions = $(`#bankOptions${notrx}`);
            const buktiTransferOptions = $(`#buktiTransferOptions${notrx}`);
            const viaElement = $(`#via${notrx}`);

            if ($(this).val() !== 'transfer') {
                bankOptions.hide();
                buktiTransferOptions.hide();
                viaElement.prop('disabled', true);
            }
        });

        // Hitung total yang harus dibayar berdasarkan jumlah bayar
        $('.jumlahBayar').on('input', function() {
            const notrx = $(this).data('notrx');
            const totalBayar = $(`#totalBayar${notrx}`);
            totalBayar.val($(this).val());
        });
    });
</script>
<script type="text/javascript">
    // Pencarian Pelanggan
    $('#cariPelanggan').on('keyup', function() {
        var queryPelanggan = $(this).val();
        $.ajax({
            url: "{{ url('orderan') }}",
            type: "GET",
            data: {
                'query': queryPelanggan
            },
            success: function(data) {
                $('#listPelanggan').html(data);
            }
        });
    });

    // Menangani Klik pada Pelanggan
    $('body').on('click', '#listPelanggan li', function() {
        var idPelanggan = $(this).data('id');
        var namaPelanggan = $(this).text();

        // Set nilai untuk input pelanggan
        $('#pemesan2').val(namaPelanggan);
        $('#pemesan').val(namaPelanggan);

        // Set nilai ID pelanggan pada input terkait
        $('.namapemesan').each(function(index, element) {
            if ($(element).val() === namaPelanggan) {
                $(element).next('.idpemesan').val(idPelanggan);
            }
        });
    });

    // Pencarian Produk
    $(document).ready(function() {
        $('#cari_produk').on('input', function() {
            var queryProduk = $(this).val();
            $.ajax({
                url: "{{ route('ajax.search.product') }}",
                type: "GET",
                data: {
                    'query': queryProduk
                },
                success: function(data) {
                    $('#product-list').html(data);
                }
            });
        });

        // Menangani Klik pada Produk
        $(document).on('click', '#product-list .list-group-item', function() {
            var product_name = $(this).text();
            var bahan_name = $(this).text();
            var product_id = $(this).data('id');
            var bahan_id = $(this).data('id');

            // Update product input values in the last duplicated form
            var lastForm = $(".form-transaksi:last");
            lastForm.find('.produk').val(product_name);
            lastForm.find('.id_produk').val(product_id);
            lastForm.find('.id_bahan').val(bahan_id);
            lastForm.find('.bahan').val(bahan_name);

            // Clear the product list
            $('#product-list').html('');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(document).keydown(function(e) {
            if (e.which == 113) {
                buttonFunction();
            } else if (e.which == 115) {
                $('#tambahP').click();
            }
        });

        function buttonFunction() {
            $('#cariP').click();
        }
    });
</script>
{{-- <script>
    function updateStatus() {
        let date = new Date();
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let tombol = document.getElementById('tambahT');
        let pesan = document.querySelector('#pesanoff');

        let darijam = parseInt("{{ $jamTransaksi->darijam }}");
        let sampaijam = parseInt("{{ $jamTransaksi->sampaijam }}");

        if ((hours === darijam && minutes >= 55) || (hours === darijam - 1 && minutes >= 55)) {
            pesan.innerHTML = '<div class="alert alert-info mt-2">Pemesanan akan ditutup 5 menit lagi.</div>';
        } else if (hours >= darijam || hours < sampaijam) {
            tombol.disabled = true;
            pesan.innerHTML =
                '<div class="alert alert-info mt-2">Pemesanan sudah ditutup, Akan Buka Kembali Pada Pukul 08:00 WIB</div>';
        } else {
            pesan.style.display = 'none';
        }
    }

    document.getElementById('tambahT').addEventListener('click', function() {
        updateStatus();
    });

    setInterval(updateStatus, 60000);
    updateStatus();
</script> --}}


<script>
    $(function() {
        var startDate;
        var endDate;

        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            $('#searchFormDate').submit();
        });
    });
</script>
<script>
    let clear = document.querySelector('#clear');
    clear.addEventListener('click', function() {
        window.location = "{{ url('orderan') }}";
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchInput');
        var searchForm = document.getElementById('searchForm');

    });
</script>
<script>
    $(document).ready(function() {
        function updateSimpanButtonState() {
            var dpInput = document.getElementById('dp');
            var bayarDpSelect = document.getElementById('bayarDpSelect');
            var submitButton = document.getElementById('submitBtn');
            var pesan = document.getElementById('pesanMetode');

            if (dpInput.value && bayarDpSelect.value === "") {
                submitButton.disabled = true;
                $('#pesanMetode').append(
                    '<div class="alert alert-danger text-center" role="alert">Silakan pilih metode pembayaran dulu.</div>'
                );


                // Swal.fire({
                //     icon: 'warning',
                //     title: 'Oops...',
                //     text: 'Silakan pilih metode pembayaran dulu.',
                // });


            } else {
                submitButton.disabled = false;
                $('#pesanMetode').empty();
            }
        }

        // Attach the event listeners
        $('#dp, #bayarDpSelect').on('change', updateSimpanButtonState);
        $('#bayarDpModal').on('shown.bs.modal', updateSimpanButtonState);
    });
</script>
<script>
    function konfirmasiHapus(notrx) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                hapusOrderan(notrx);
            }
        });
    }

    function hapusOrderan(notrx) {
        $.ajax({
            type: 'POST',
            url: '/orderan/' + notrx,
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.success,
                    icon: 'success',
                }).then(() => {
                    location.reload();
                });
            },
            error: function(error) {
                console.error('Error:', error);
                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $(document).on('keyup', '.harga', function() {
            $(this).val(formatRupiah($(this).val()));
        });

        $('#dp').on('keyup', function() {
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

    $(document).ready(function() {
        $('.jumlahBayar').mask('#.##0', {
            reverse: true
        });
    });
</script>
<script>
    var dataProduk = [];

    function initAutocomplete() {
        $.ajax({
            type: "GET",
            url: "/cari-produk",
            success: function(response) {
                // console.log(response);
                dataProduk = response;
            }
        });
    }

    function getDataProduk(judul) {
        var result;
        $.ajax({
            type: "GET",
            url: "/get-data-produk",
            data: {
                judul: judul
            },
            async: false,
            success: function(response) {
                if (response.error) {
                    // alert(response.error); // Tampilkan pesan error jika ada
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan.!!',
                        text: response.error,
                    })
                    return; // Berhenti dan tidak melanjutkan eksekusi
                }

                // Cek status bahan
                if (response.bahans.status === "Y") {
                    // Lanjutkan dengan memeriksa stok jika status bahan aktif
                    result = response;
                } else {
                    alert("Stok bahan tidak aktif"); // Tampilkan pesan jika status bahan tidak aktif
                    return; // Berhenti dan tidak melanjutkan eksekusi
                }
            },
            error: function() {
                console.error("Error fetching data for " + judul);
            }
        });
        return result;
    }


    function masukkanProduk($data, $form) {
        if ($data && $form) {
            // Set data produk ke dalam inputan di form terakhir
            $form.find('.id_produk').val($data.id);
            $form.find('.id_bahan').val($data.id_bahan);
            $form.find('.id_kategori').val($data.id_kategori);
            $form.find('.produk').val($data.judul);
            $form.find('.harga').val(new Intl.NumberFormat('id-ID').format($data.harga_jual));
            $form.find('.ukuran').val($data.ukuran);
            $form.find('.bahan').val($data.bahans.bahan);
            $form.find('.jumlah').val($data.jumlah);
        }
    }

    $(document).ready(function() {
        initAutocomplete();

        $('.bd-transaksi-modal-lg').on('shown.bs.modal', function() {
            $('#cari_produk').autocomplete({
                source: dataProduk,
                appendTo: '.modal-body',
                select: function(event, ui) {
                    $('#btnTambahProduk').prop('disabled', false);
                }
            });

            $('#cari_produk').on('keyup', function() {
                var inputValue = $(this).val();
                $('#btnTambahProduk').prop('disabled', inputValue.trim() === '');
            });
        });

        $('#btnTambahProduk').click(function() {
            var judul = $('#cari_produk').val();
            var data = getDataProduk(judul);

            if (data) {
                // Duplikat form-transaksi
                var newForm = $(".form-transaksi:first").clone();

                // Mengubah atribut id_produk untuk menghindari konflik
                var formIndex = $(".form-transaksi").length;
                newForm.find(".id_produk").attr("id", "idnya" + formIndex);
                newForm.find(".produk").attr("id", "produk" + formIndex);

                // Bersihkan nilai input di form baru kecuali nama pelanggan
                newForm.find(".produk").val("");
                newForm.find(".id_produk").val("");
                newForm.find(".id_kategori").val("");
                newForm.find(".jumlah").val("");
                newForm.find(".keterangan").val("");
                newForm.find(".ukuran").val("");
                newForm.find(".harga").val("");
                newForm.find(".total").val("");

                // Hapus label dari form baru
                newForm.find("label").text("");
                // Sisipkan form baru setelah form terakhir
                $(".form-transaksi:last").after(newForm);

                // Set data produk ke dalam inputan di form terbaru
                masukkanProduk(data, newForm);

                // Memuat data bahan berdasarkan id_kategori
                var id_kategori = data.id_kategori;
                $.ajax({
                    type: "GET",
                    url: "/get-bahan/" + id_kategori,
                    success: function(response) {
                        // Mengosongkan dan mengisi opsi select dengan data bahan baru
                        newForm.find('#bahan').empty();
                        newForm.find('#bahan').append(
                            '<option value="0">Pilih Bahan</option>');
                        $.each(response, function(index, item) {
                            newForm.find('#bahan').append('<option value="' + item
                                .bahan + '">' +
                                item.bahan + '</option>');
                        });
                    },
                    error: function() {
                        console.error("Error fetching data bahan for id_kategori " +
                            id_kategori);
                    }
                });
            }
        });

        // Tambahkan event handler untuk tombol hapus pada form
        $(document).on("click", ".hapusform", function() {
            // Hapus form saat tombol hapus diklik
            $(this).closest(".form-transaksi").remove();
        });
    });
</script>
<script>
    function validateForm() {
        var namaPemesan = document.getElementById('pemesan').value;

        if (namaPemesan.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!!',
                text: 'Nama pemesan tidak boleh kosong',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            });
            return false;
        }
        return true;
    }

    var submitButton = document.getElementById('submitBtn');
    submitButton.addEventListener('click', function() {
        validateForm()
    });
</script>
