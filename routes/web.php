<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\OrderanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardKeuanganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\GajiKaryawanController;
use App\Http\Controllers\GajiKaryawanV2Controller;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\JenisBahanController;
use App\Http\Controllers\JenisPengeluaranController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\KategoriBahanController;
use App\Http\Controllers\LogTranasksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\WarnaTemaController;
use App\Models\DetailPembelian;
use App\Models\JenisBahan;
use App\Models\Satuan;
use App\Models\StokMasuk;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pages.login', data: ['title' => 'Login']);
// });

// Route::get('login', [LoginController::class, 'index'])->name('login');

// Route::get('/', [LayoutController::class, 'index'])->middleware('auth');
Route::get('/', function () {
    return redirect()->to('home');
});
Route::get('/home', [LayoutController::class, 'index'])->middleware('auth');

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login/proses', 'proses');
    Route::get('logout', 'logout');
});

// Akses Untuk Admin
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['auth', 'CekUserLogin:1']], function () {
        // Untuk Karyawan
        Route::resource('karyawan', KaryawanController::class);
        Route::get('/karyawan', [KaryawanController::class, 'index']);
        Route::get('/tambah-karyawan', [KaryawanController::class, 'tambahKaryawan']);
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');

        // Untuk Gaji Karyawan
        Route::resource('gajikaryawan', GajiKaryawanController::class);
        Route::get('/gaji-karyawan', [GajiKaryawanController::class, 'index']);
        Route::get('/tambah-gaji', [GajiKaryawanController::class, 'tambahGaji']);

        // Gaji Karyawan V2
        Route::resource('gajikaryawanv2', GajiKaryawanV2Controller::class);
        Route::get('/gaji-karyawanv2', [GajiKaryawanV2Controller::class, 'index']);
        Route::post('/gaji-karyawanv2/cari-kasbon', [GajiKaryawanV2Controller::class, 'cariKasbon'])->name('gajikaryawanv2.cariKasbon');
        Route::get('/tambah-gajiv2', [GajiKaryawanV2Controller::class, 'tambahGajiV2']);
        Route::get('/gaji-karyawanv2/cari-data', [GajiKaryawanV2Controller::class, 'cariData'])->name('gajikaryawanv2.cari');
        Route::get('/gaji-karyawanv2/filterJumlah', [OrderanController::class, 'filterJumlah'])->name('gajikaryawanv2.filterJumlah');

        // Untuk Orderan
        Route::resource('orderan', OrderanController::class);
        Route::get('/orderan', [OrderanController::class, 'index'])->middleware('can:orderan.data');
        Route::get('/orderan-baru', [OrderanController::class, 'tambahOrderan']);
        Route::post('/orderan.pelunasan', [OrderanController::class, 'pelunasan'])->name('orderan.pelunasan');
        Route::delete('/orderan/{notrx}', [OrderanController::class, 'destroy'])->name('orderan.destroy');
        Route::post('/orderan/tambahPelanggan', [OrderanController::class, 'tambahPelanggan'])->name('orderan.tambahPelanggan');
        Route::post('/orderan.cari', [OrderanController::class, 'cariData'])->name('orderan.cari');
        Route::post('/orderan/filterJumlah', [OrderanController::class, 'filterJumlah'])->name('orderan.filterJumlah');
        Route::get('/ajax/search/product', [OrderanController::class, 'searchProduct'])->name('ajax.search.product');
        Route::get('/get-bahan/{id_kategori}', [OrderanController::class, 'getBahanByCategory']);
        Route::get('/cari-produk', [OrderanController::class, 'cariProdukAjax']);
        Route::get('/get-data-produk', [OrderanController::class, 'getDataProduk']);

        // Untuk Dashboard
        Route::get('/home', [DashboardController::class, 'index']);

        // Untuk Pembelian
        Route::resource('/pembelian', PembelianController::class);
        Route::get('/pembelianbaru', [PembelianController::class, 'tambahPembelian']);
        Route::get('/cari-bahan', [PembelianController::class, 'cariBahanAjax']);
        Route::get('/get-data-bahan', [PembelianController::class, 'getDataBahan']);
        Route::get('/cari-jenispengeluaran', [PembelianController::class, 'cariJenisPengeluaranAjax']);
        Route::get('/get-data-jenispengeluaran', [PembelianController::class, 'getDataJenisPengeluaran']);
        Route::get('/cari-supplier', [PembelianController::class, 'cariSupplier']);
        Route::get('/get-data-supplier', [PembelianController::class, 'getSupplier']);
        Route::get('pembelian/bayar', [PembelianController::class, 'bayarPembelian'])->name('pembelian.bayar');
        Route::get('/getSaldo/{id}', [PembelianController::class, 'getSaldo']);
        Route::post('pembelian/limit', [PembelianController::class, 'limit'])->name('pembelian.limit');
        Route::get('/print-pembelian', [PembelianController::class, 'printPembelian'])->name('pembelian.print');


        // Untuk Pengeluaran
        Route::resource('pengeluaran', PengeluaranController::class)->middleware('can:pengeluaran.data');
        Route::get('cetakpengeluaran', [PengeluaranController::class, 'printPengeluaran'])->name('pengeluaran.print');
        Route::get('/pengeluaranbaru', [PengeluaranController::class, 'tambahPengeluaran']);
        Route::get('/pengeluaran.cari', [PengeluaranController::class, 'cariData'])->name('pengeluaran.cari');


        // Untuk Data Keuangan
        Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan');

        Route::resource('/hutang', HutangController::class);
        Route::post('/hutang/bayar', [HutangController::class, 'bayarHutang'])->name('hutang.bayar');

        // Untuk Laporan
        // Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        // Route::post('/laporan/cetak', [LaporanController::class, 'index'])->name('laporan.cetakLaporan');

        // Untuk Profile
        Route::resource('profile', ProfileController::class);
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Untuk Setting
        Route::resource('setting', SettingController::class);
        Route::post('/setting', [SettingController::class, 'editLogo']);

        // Untuk Pelanggan
        Route::resource('pelanggan', PelangganController::class);
        Route::get('/pelanggan', [PelangganController::class, 'index']);
        Route::get('tambah-pelanggan', [PelangganController::class, 'tambahPelanggan']);
        Route::post('tambah-pelanggan', [PelangganController::class, 'store'])->name('tambah.pelanggan');

        // Untuk Rekening
        Route::resource('rekening', RekeningController::class);

        // Log Transaksi
        Route::get('/aktifitas', [LogTranasksiController::class, 'index']);

        // Piutang Penjualan
        Route::get('/piutang', [PiutangController::class, 'index']);
        Route::get('print-piutang', [PiutangController::class, 'printPiutang'])->name('print.piutang');
        Route::get('/piutang-cari', [PiutangController::class, 'cariPiutang'])->name('piutang.cari');


        // Rincian Pendapatan
        // Belum ada

        // Kas
        Route::get('/kas', [KasController::class, 'index']);
        Route::post('/kas', [KasController::class, 'tambahKas'])->name('kas.tambahKas');
        Route::delete('/kas/{no_reff}', [KasController::class, 'hapusKasKecil'])->name('kas.hapusKasKecil');

        // JenisPengeluran
        Route::resource('jenis-pengeluaran', JenisPengeluaranController::class);
        Route::post('tambah-jenis', [JenisPengeluaranController::class, 'store'])->name('tambah.jenis');
        Route::put('jenis-pengeluaran/{id}', [JenisPengeluaranController::class, 'update'])->name('jenis-pengeluaran.update');
        Route::post('jenis-pengeluaran', [JenisPengeluaranController::class, 'limitJumlah'])->name('jenis-pengeluaran.limit');

        // Jenis Bahan
        Route::resource('bahan', JenisBahanController::class);
        Route::post('/bahan', [JenisBahanController::class, 'limit'])->name('bahan.limit');
        Route::post('tambahbahan', [JenisBahanController::class, 'store'])->name('tambah.bahan');
        // Kategori
        Route::resource('kategori', KategoriBahanController::class);
        Route::get('/kategori', [KategoriBahanController::class, 'index']);
        Route::post('kategorilimit', [KategoriBahanController::class, 'limit'])->name('kategori.limit');
        Route::get('kategori/cari', [KategoriBahanController::class, 'cariData'])->name('kategori.caridata');
        Route::put('kategori/{id}', [KategoriBahanController::class, 'update'])->name('kategori.update');
        // Produkk
        Route::resource('produk', ProdukController::class);
        Route::get('/produk', [ProdukController::class, 'index']);

        // Omset 
        Route::get('/omset', [OrderanController::class, 'omset'])->name('omset');
        Route::post('omset/cari', [OrderanController::class, 'omset'])->name('omset.cari');

        // Untuk KasBon
        Route::resource('kasbon', KasbonController::class)->except(['show']);
        Route::get('kasbon/print', [KasbonController::class, 'printKasBon'])->name('kasbon.print');

        // Untuk Pengguna
        Route::resource('pengguna', PenggunaController::class);
        Route::get('/admin-baru', [PenggunaController::class, 'tambahPengguna']);

        // Untuk Satuan
        Route::resource('satuan', SatuanController::class);
        Route::post('satuan/tambah', [SatuanController::class, 'store'])->name('satuan.tambah');
        Route::post('satuan', [SatuanController::class, 'limit'])->name('satuan.limit');

        // Untuk Supplier
        Route::resource('supplier', SupplierController::class);
        Route::post('supplier', [SupplierController::class, 'limit'])->name('supplier.limit');
        Route::post('tambahsupplier', [SupplierController::class, 'store'])->name('supplier.tambah');
        Route::put('supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');

        // Untuk Data Stok
        // Route::resource('stok', StokMasukController::class);
        Route::get('datastok', [StokMasukController::class, 'dataStok'])->name('data.stok');

        Route::get('/dashboard-keuangan', [DashboardKeuanganController::class, 'index']);
    });

    // End Route Super Admin-----------------------------------------------------------------------------------------------------------------------------

    // Akses Untuk Owner
    Route::group(['middleware' => ['auth', 'CekUserLogin:2']], function () {
        // Untuk Dashboard
        Route::get('/home', [DashboardController::class, 'index']);
        Route::resource('pengguna', PenggunaController::class);
        Route::get('/admin-baru', [PenggunaController::class, 'tambahPengguna']);
    });

    Route::group(['middleware' => ['auth', 'CekUserLogin:3']], function () {
        // Untuk Orderan
        Route::resource('orderan', OrderanController::class);
        Route::get('/orderan', [OrderanController::class, 'index']);
        Route::get('/orderan/{id}', [OrderanController::class, 'index']);
        Route::get('/orderan-baru', [OrderanController::class, 'tambahOrderan']);
        Route::post('/orderan.pelunasan', [OrderanController::class, 'pelunasan'])->name('orderan.pelunasan');
        Route::post('/orderan/tambahPelanggan', [OrderanController::class, 'tambahPelanggan'])->name('orderan.tambahPelanggan');

        // Untuk Dashboard
        Route::get('/home', [DashboardController::class, 'index']);

        // Untuk Pembelian
        Route::resource('/pembelian', PembelianController::class);
        Route::get('/pembelianbaru', [PembelianController::class, 'tambahPembelian']);

        // Untuk Pelanggan
        Route::resource('pelanggan', PelangganController::class);
        Route::get('/pelanggan', [PelangganController::class, 'index']);
        Route::get('tambah-pelanggan', [PelangganController::class, 'tambahPelanggan']);
        Route::post('/pelanggan', [PelangganController::class, 'limit'])->name('pelanggan.limit');
        // Route::post('/pelanggan', [PelangganController::class, 'cariData'])->name('pelanggan.cariData');

        // Untuk Pengeluaran
        Route::resource('pengeluaran', PengeluaranController::class)->except(['show']);
    });
});

Route::get('orderan/print_invoice/{notrx}', [OrderanController::class, 'printInvoice'])->name('orderan.print_invoice');
Route::get('orderan/print_invoice58/{notrx}', [OrderanController::class, 'printInvoice58'])->name('orderan.print_invoice58');
Route::get('pengeluaran/print_laporan/{id_pengeluaran}', [PengeluaranController::class, 'printInvoice'])
    ->name('cetak.print_invoice');

Route::get('pembelian/print_faktur/{id_pembelian}', [PembelianController::class, 'printFaktur'])->name('pembelian.print_faktur');
// Route::get('/laporan/cetak-laporan', [LaporanController::class, 'cetakLaporan'])->name('laporan.cetakLaporan');
// Route::post('/laporan/cetak-laporan', [LaporanController::class, 'cetakLaporan']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



Route::get('/tescode', function () {
    return view('tescode');
});

Route::get('tescode2', [WarnaTemaController::class, 'index']);

Route::get('/cek', [OrderanController::class, 'cek']);

// 404
Route::get('{any}', function () {
    return view('errors.404');
});
