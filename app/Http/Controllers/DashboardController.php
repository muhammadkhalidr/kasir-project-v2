<?php

namespace App\Http\Controllers;

use App\Models\DetailOrderan;
use App\Models\Orderan;
use App\Models\Pengeluaran;
use App\Models\KasMasuk;
use App\Models\OmsetPenjualan;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $orderan = DetailOrderan::orderBy('created_at', 'desc')->paginate(8);
        $piutang = DetailOrderan::where('status', 'Belum Lunas')
            ->orderBy('subtotal', 'desc')
            ->paginate(8);

        // Mengambil notrx dengan subtotal paling tertinggi
        $piutangTerbesar = $piutang->first()->notrx ?? 0;

        // Mengambil data penjualan
        $penjualanTerbesar = OmsetPenjualan::select(
            'id_produk',
            DB::raw('SUM(jumlah) as total_jumlah'),
            DB::raw('SUM(total) as total_penjualan'),
            DB::raw('YEAR(created_at) as year')
        )
            ->groupBy('id_produk', 'year')
            ->with('produks')
            ->paginate(5);

        // Mengambil tahun unik dari hasil query
        $tahunUnik = $penjualanTerbesar->pluck('year')->unique();

        $pendapatanBulanan = KasMasuk::where('bank', '!=', 'kaskecil')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(pemasukan) as total'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $pengeluaranBulanan = Pengeluaran::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as total'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $pendapatanData = [];
        $pengeluaranData = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendapatanData[] = $pendapatanBulanan->get($i)->total ?? 0;
            $pengeluaranData[] = $pengeluaranBulanan->get($i)->total ?? 0;
        }

        $totalOrderan = DetailOrderan::distinct('notrx')->count('notrx');
        $orderanHariIni = DetailOrderan::whereDate('created_at', Carbon::today())
            ->distinct('notrx')
            ->count('notrx');

        $konsumen = Pelanggan::all()->count();
        return view('layout.home', [
            'title' => 'Dashboard | Home',
            'totalOrderan' => $totalOrderan,
            'name_user' => $user->name,
            'pendapatanData' => $pendapatanData,
            'pengeluaranData' => $pengeluaranData,
            'orderanHariIni' => $orderanHariIni,
            'konsumen' => $konsumen,
            'orderan' => $orderan,
            'piutang' => $piutang,
            'penjualanTerbesar' => $penjualanTerbesar,
            'tahunUnik' => $tahunUnik,
        ]);
    }

    public function filterByYear($tahun)
    {

        $user = Auth::user();

        $orderan = DetailOrderan::orderBy('created_at', 'desc')->paginate(8);
        $piutang = DetailOrderan::where('status', 'Belum Lunas')
            ->orderBy('subtotal', 'desc')
            ->paginate(8);

        // Mengambil notrx dengan subtotal paling tertinggi
        $piutangTerbesar = $piutang->first()->notrx;

        $pendapatanBulanan = KasMasuk::where('bank', '!=', 'kaskecil')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(pemasukan) as total'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $pengeluaranBulanan = Pengeluaran::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as total'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $pendapatanData = [];
        $pengeluaranData = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendapatanData[] = $pendapatanBulanan->get($i)->total ?? 0;
            $pengeluaranData[] = $pengeluaranBulanan->get($i)->total ?? 0;
        }

        $totalOrderan = DetailOrderan::distinct('notrx')->count('notrx');
        $orderanHariIni = DetailOrderan::whereDate('created_at', Carbon::today())
            ->distinct('notrx')
            ->count('notrx');

        $konsumen = Pelanggan::all()->count();

        $penjualanTerbesar = OmsetPenjualan::select(
            'id_produk',
            DB::raw('SUM(jumlah) as total_jumlah'),
            DB::raw('SUM(total) as total_penjualan'),
            DB::raw('YEAR(created_at) as year')
        )
            ->whereYear('created_at', $tahun)
            ->groupBy('id_produk', 'year')
            ->with('produks')
            ->paginate(5);

        $tahunUnik = OmsetPenjualan::select(DB::raw('YEAR(created_at) as year'))
            ->groupBy('year')
            ->get()
            ->pluck('year');

        return view('layout.home', [
            'title' => 'Dashboard | Home',
            'totalOrderan' => $totalOrderan,
            'name_user' => $user->name,
            'pendapatanData' => $pendapatanData,
            'pengeluaranData' => $pengeluaranData,
            'orderanHariIni' => $orderanHariIni,
            'konsumen' => $konsumen,
            'orderan' => $orderan,
            'piutang' => $piutang,
            'penjualanTerbesar' => $penjualanTerbesar,
            'tahunUnik' => $tahunUnik,
        ]);
    }

    public function filterByMonth($tahun, $bulan)
    {

        $user = Auth::user();

        $orderan = DetailOrderan::orderBy('created_at', 'desc')->paginate(8);
        $piutang = DetailOrderan::where('status', 'Belum Lunas')
            ->orderBy('subtotal', 'desc')
            ->paginate(8);

        // Mengambil notrx dengan subtotal paling tertinggi
        $piutangTerbesar = $piutang->first()->notrx ?? 0;

        $pendapatanBulanan = KasMasuk::where('bank', '!=', 'kaskecil')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(pemasukan) as total'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $pengeluaranBulanan = Pengeluaran::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as total'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $pendapatanData = [];
        $pengeluaranData = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendapatanData[] = $pendapatanBulanan->get($i)->total ?? 0;
            $pengeluaranData[] = $pengeluaranBulanan->get($i)->total ?? 0;
        }

        $totalOrderan = DetailOrderan::distinct('notrx')->count('notrx');
        $orderanHariIni = DetailOrderan::whereDate('created_at', Carbon::today())
            ->distinct('notrx')
            ->count('notrx');

        $konsumen = Pelanggan::all()->count();

        $penjualanTerbesar = OmsetPenjualan::select(
            'id_produk',
            DB::raw('SUM(jumlah) as total_jumlah'),
            DB::raw('SUM(total) as total_penjualan'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month')
        )
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->groupBy('id_produk', 'year', 'month')
            ->with('produks')
            ->paginate(5);

        $tahunUnik = OmsetPenjualan::select(DB::raw('YEAR(created_at) as year'))
            ->groupBy('year')
            ->get()
            ->pluck('year');

        return view('layout.home', [
            'title' => 'Dashboard | Home',
            'totalOrderan' => $totalOrderan,
            'name_user' => $user->name,
            'pendapatanData' => $pendapatanData,
            'pengeluaranData' => $pengeluaranData,
            'orderanHariIni' => $orderanHariIni,
            'konsumen' => $konsumen,
            'orderan' => $orderan,
            'piutang' => $piutang,
            'penjualanTerbesar' => $penjualanTerbesar,
            'tahunUnik' => $tahunUnik,
        ]);
    }
}
