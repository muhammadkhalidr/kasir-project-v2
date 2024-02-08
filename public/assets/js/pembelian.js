$(document).ready(function() {
    $('#jumlahBayar').mask('#.##0', {
        reverse: true
    });

});

$(document).ready(function() {
    $(document).on('keyup', '#nominal', function() {
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

function hapusPembelian(id) {
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
            document.getElementById('hapusPembelian' + id).submit();
        }
    });
}
var dataBahan = [];
var dataJenisPengeluaran = [];
var dataSupplier = [];

function initAutocomplete() {
    $.ajax({
        type: "GET",
        url: "/cari-bahan",
        success: function(response) {
            dataBahan = response;
        }
    });

    $.ajax({
        type: "GET",
        url: "/cari-jenispengeluaran",
        success: function(response) {
            dataJenisPengeluaran = response;
        }
    });

    $.ajax({
        type: "GET",
        url: "/cari-supplier",
        success: function(response) {
            dataSupplier = response;
        }
    });
}

function getDataBahan(judul) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "GET",
            url: "/get-data-bahan",
            data: {
                judul: judul
            },
            success: function(response) {
                resolve(response);
            },
            error: function() {
                console.error("Error fetching data for " + judul);
                reject();
            }
        });
    });
}

function getDataJenisPengeluaran(judul) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "GET",
            url: "/get-data-jenispengeluaran",
            data: {
                judul: judul
            },
            success: function(response) {
                resolve(response);
            },
            error: function() {
                console.error("Error fetching data for " + judul);
                reject();
            }
        });
    });
}

function getSupplier(judul) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: "GET",
            url: "/get-data-supplier",
            data: {
                judul: judul
            },
            success: function(response) {
                resolve(response);
            },
            error: function() {
                console.error("Error fetching data for " + judul);
                reject();
            }
        });
    });
}

$(document).ready(function() {
    initAutocomplete();

    $('.bd-pembelian-modal-lg').on('shown.bs.modal', function() {
        // Tambahkan event handler autocomplete untuk formulir yang baru ditambahkan
        $(".body-tabel").on('focus', '.bahan', function() {
            $(this).autocomplete({
                source: dataBahan,
                appendTo: '.modal-body',
                select: function(event, ui) {
                    var selectedIdBahan = ui.item.id;
                    $(this).closest('tr').find('#idBahanSelected').val(selectedIdBahan);
                }
            });
        });

        $(".body-tabel").on('focus', '.jenisakun', function() {
            $(this).autocomplete({
                source: dataJenisPengeluaran,
                appendTo: '.modal-body',
                select: function(event, ui) {
                    var selectedIdJenisPengeluaran = ui.item.id;
                    $(this).closest('tr').find('#idJenis').val(selectedIdJenisPengeluaran);
                }
            });
        });

        $(".body-tabel").on('focus', '.supplier', function() {
            $(this).autocomplete({
                source: dataSupplier,
                appendTo: '.modal-body',
                select: function(event, ui) {
                    var selectedIdSupplier = ui.item.id;
                    $(this).closest('tr').find('#idSupplier').val(selectedIdSupplier);
                }
            });
        });
    });

    // Menangani klik pada tombol tambahform
    $(document).on("click", ".add_mores", function() {
        // Duplikat baris formulir
        var newRow = $("#form_pembelian").clone();

        // Mengatur atribut id untuk menghindari konflik
        var formIndex = $(".form-pembelian").length + 1;
        newRow.attr("id", "form_pembelian" + formIndex);

        // Reset nilai input pada baris baru
        // newRow.find("input").val("");
        // newForm.find(".produk").val("");

        // Sisipkan baris baru ke dalam .body-tabel
        $(".body-tabel").append(newRow);
    });

    // Menangani klik pada tombol hapusform
    $(document).on("click", ".hapusform", function() {
        // Hapus baris formulir saat tombol hapus diklik
        $(this).closest("tr").remove();
    });
    $(document).on("input", ".jumlah, .harga", function() {
        // Menghitung total untuk setiap form
        $(".form_pembelian").each(function() {
            var jumlah = parseFloat($(this).find(".jumlah").val()) || 0;
            var harga = parseFloat($(this).find(".harga").val().replace(/\./g, '').replace(
                ',', '.')) || 0;

            var total = jumlah * harga;

            // Format total sesuai dengan harga
            $(this).find(".total").val(formatRupiah(total.toString()));
        });

        // Menghitung subtotal dari semua total
        var subtotal = 0;
        $(".form_pembelian").each(function() {
            subtotal += parseFloat($(this).find(".total").val().replace(/\./g, '').replace(
                ',', '.')) || 0;
        });

        // Mengupdate nilai input subtotal
        $(".subtotal").val(formatRupiah(subtotal.toString()));
    });

    // Menangani perubahan nilai saat formulir baru ditambahkan
    $(document).on("input", ".form_pembelian:last .jumlah, .form_pembelian:last .harga", function() {
        var jumlah = parseFloat($(this).closest(".row").find(".jumlah").val()) || 0;
        var harga = parseFloat($(this).closest(".row").find(".harga").val().replace(/\./g, '')
            .replace(',', '.')) || 0;

        var total = jumlah * harga;

        // Format total sesuai dengan harga
        $(this).closest(".row").find(".total").val(formatRupiah(total.toString()));
    });
});

// $(document).ready(function() {
//     // Menangani klik pada tombol tambahform
//     $(document).on("click", ".add_mores", function() {
//         // Duplikat baris formulir
//         var newRow = $("#form_pembelian").clone();

//         // Mengatur atribut id untuk menghindari konflik
//         var formIndex = $(".form-pembelian").length + 1;
//         newRow.attr("id", "form_pembelian" + formIndex);

//         // Reset nilai input pada baris baru
//         newRow.find("input").val("");

//         // Sisipkan baris baru ke dalam .body-tabel
//         $(".body-tabel").append(newRow);
//     });

//     // Menangani klik pada tombol hapusform
//     $(document).on("click", ".hapusform", function() {
//         // Hapus baris formulir saat tombol hapus diklik
//         $(this).closest("tr").remove();
//     });
// });

// $(document).ready(function () {
//     // Fungsi untuk menangani perubahan pada dropdown 'caraBayar'
//     $("#caraBayar").change(function () {
//         handleCaraBayarChange();
//     });

//     // Fungsi untuk menangani perubahan saat modal dibuka
//     $("#myModal").on("shown.bs.modal", function () {
//         handleCaraBayarChange();
//     });

//     function handleCaraBayarChange() {
//         var caraBayar = $("#caraBayar").val();
//         var rekeningDropdown = $("#rekening");
//         var totalBayarInput = $("#totalBayar");

//         // Jika caraBayar adalah 'Tunai'
//         if (caraBayar === "888") {
//             // Mengambil data dari value tunai
//             var tunaiData = $("#tunai").val();

//             // Menonaktifkan dan menghapus nilai pada dropdown 'rekening'
//             rekeningDropdown.prop("disabled", true).val(0);

//         } else if (caraBayar === "transfer") {
//             // Menghapus disabled pada dropdown 'rekening'
//             rekeningDropdown.prop("disabled", false);

//             // Mengosongkan nilai pada input 'totalBayar'
//             totalBayarInput.val("");
//         }
//     }

// });

// $(document).ready(function () {
//     $('#caraBayar').change(function () {
//         var caraBayar = $(this).val();
//         var id;
//         if (caraBayar == 'tunai') {
//             $('#tunai').show().attr('name', 'akun');
//             $('#rekening').hide().removeAttr('name');
//             id = $('#tunai').val(); // ID untuk kas penjualan
//         } else if (caraBayar == 'transfer') {
//             $('#rekening').show().attr('name', 'akun');
//             $('#tunai').hide().removeAttr('name');
//             id = $('#rekening').val(); // ID untuk rekening bank
//         }
//         $('#id_bank').val(id); // Menyimpan id_bank ke dalam form
//         $.ajax({
//             url: '/getSaldo/' + id,
//             method: 'GET',
//             success: function(data) {
//                 console.log('saldo bank', + id,  data);
//                 // $('#saldoKas').val(data.saldo);
//                 $('#saldoKas').val(formatRupiah(data.saldo.toString()));
//             }
//         });
//     });
// });

$(document).ready(function () {
    // Sembunyikan dropdown akun saat halaman dimuat
    $('#rekening').hide();

    $('#caraBayar').change(function () {
        var caraBayar = $(this).val();

        if (caraBayar == 'tunai') {
            $('#tunai').show().attr('name', 'akun');
            $('#rekening').hide().removeAttr('name');
            updateSaldo($('#tunai').val());
        } else if (caraBayar == 'transfer') {
            $('#tunai').hide().removeAttr('name');
            $('#rekening').show().attr('name', 'akun');
            updateSaldo($('#rekening').val());
        }
    });

    function updateSaldo(id) {
        $('#id_bank').val(id);

        $.ajax({
            url: '/getSaldo/' + id,
            method: 'GET',
            success: function(data) {
                // console.log('saldo bank', id, data);
                $('#saldoKas').val(formatRupiah(data.saldo.toString()));
            }
        });
    }

    // Fungsi untuk memformat angka menjadi format rupiah
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + ribuan;
    }
});

$(document).ready(function () {
    // Handle 'Cari' button click event
    $('#cari').click(function (e) {
        e.preventDefault(); // Prevent the form from being submitted automatically
        $('#hiddenJenis').val($('#jenis').val());
        $('#hiddenpencatat').val($('#pencatat').val());
        $('#searchForm').submit();
    });
});

$(document).ready(function() {
    $('input[name="daterange"]').daterangepicker({
        format: 'MM/DD/YYYY'
    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $('#start_date').val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
        $('#end_date').val(picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
        $('#searchForm').submit(); // assuming your form has an id="searchForm"
    });
});
