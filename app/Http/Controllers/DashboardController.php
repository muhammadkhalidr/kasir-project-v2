<?php

namespace App\Http\Controllers;

use App\Models\DetailOrderan;
use App\Models\Orderan;
use App\Models\Pengeluaran;
use App\Models\KasMasuk;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

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

        $datas = DetailOrderan::all();
        $pengeluaran = Pengeluaran::all();
        $pembelian = Pembelian::all();

        $pendapatan = KasMasuk::where('bank', '!=', 'kaskecil')
            ->sum('pemasukan');

        $kasKeluar = $pengeluaran->sum('total') + $pembelian->sum('total');

        return view('layout.home', [
            'totalOrderan' => $datas->count(),
            'totalPengeluaran' => $kasKeluar,
            'title' => 'Dashboard | Home',
            'name_user' => $user->name,
            'totalPendapatan' => $pendapatan,
            'pendapatanData' => $pendapatanData,
            'pengeluaranData' => $pengeluaranData,
        ]);
    }
}
