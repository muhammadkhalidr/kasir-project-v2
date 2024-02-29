<?php

namespace App\Http\Controllers;

use App\Models\DetailOrderan;
use App\Models\Orderan;
use App\Models\Pengeluaran;
use App\Models\KasMasuk;
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
            'orderanHariIni' => $orderanHariIni,
            'pengeluaranData' => $pengeluaranData,
            'konsumen' => $konsumen,
            'orderan' => $orderan,
        ]);
    }
}
