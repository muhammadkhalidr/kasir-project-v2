$(document).ready(function() {
    $('#nominal').mask('#.##0', {
        reverse: true
    });
    $('#subtotal').mask('#.##0', {
        reverse: true
    });
});
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
            console.log(response);
            dataBahan = response;
        }
    });

    $.ajax({
        type: "GET",
        url: "/cari-jenispengeluaran",
        success: function(response) {
            console.log(response);
            dataJenisPengeluaran = response;
        }
    });

    $.ajax({
        type: "GET",
        url: "/cari-supplier",
        success: function(response) {
            console.log(response);
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
                console.log("Data Bahan Detail:", response);
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
                console.log("Data Jenis Detail:", response);
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
                console.log("Data Supplier Detail:", response);
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
        $('#bahan').autocomplete({
            source: dataBahan,
            appendTo: '.modal-body',
            select: function(event, ui) {
                var selectedIdBahan = ui.item.id;
                console.log("Selected ID Bahan:", selectedIdBahan);
                $('#idBahanSelected').val(selectedIdBahan);
            }
        });

        $('#jenisakun').autocomplete({
            source: dataJenisPengeluaran,
            appendTo: '.modal-body',
            select: function(event, ui) {
                var selectedIdJenisPengeluaran = ui.item.id;
                console.log("Selected ID Jenis:", selectedIdJenisPengeluaran);
                $('#idJenis').val(selectedIdJenisPengeluaran);
            }
        });

        $('#supplier').autocomplete({
            source: dataSupplier,
            appendTo: '.modal-body',
            select: function(event, ui) {
                var selectedIdSupplier = ui.item.id;
                console.log("Selected ID Supplier:", selectedIdSupplier);
                $('#idSupplier').val(selectedIdSupplier);
            }
        });
    });
});

