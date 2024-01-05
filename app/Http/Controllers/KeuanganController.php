<?php

namespace App\Http\Controllers;

use App\Models\GajiKaryawan;
use App\Models\KasMasuk;
use App\Models\Orderan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Mendapatkan nilai bulan dan tahun dari request
        $selectedMonthYear = $request->input('filterTgl', Carbon::now()->format('Y-m'));

        $pengeluaran = Pengeluaran::all();
        $gajiKaryawan = GajiKaryawan::all();
        $kas = KasMasuk::all();

        // Hitung kas masuk
        $kasMasuk = $kas->where('bank', '!=', 'kaskecil')->sum('pemasukan') - $kas->sum('pengeluaran');

        // Filter data pengeluaran berdasarkan bulan dan tahun
        $pengeluarans = $pengeluaran->filter(function ($item) use ($selectedMonthYear) {
            return Carbon::parse($item->created_at)->format('Y-m') === $selectedMonthYear;
        })->sum('jumlah');

        // Filter data pemasukan berdasarkan bulan dan tahun
        $pemasukans = $kas->filter(function ($item) use ($selectedMonthYear) {
            return Carbon::parse($item->created_at)->format('Y-m') === $selectedMonthYear;
        })->sum('pemasukan');

        // Filter data kas masuk berdasarkan bulan dan tahun
        $kasMasuk = $kas->filter(function ($item) use ($selectedMonthYear) {
            return Carbon::parse($item->created_at)->format('Y-m') === $selectedMonthYear && $item->bank != 'kaskecil';
        })->sum('pemasukan') - $kas->filter(function ($item) use ($selectedMonthYear) {
            return Carbon::parse($item->created_at)->format('Y-m') === $selectedMonthYear;
        })->sum('pengeluaran');

        // Filter data gaji karyawan berdasarkan bulan dan tahun
        $gajiKaryawans = $gajiKaryawan->filter(function ($item) use ($selectedMonthYear) {
            return Carbon::parse($item->created_at)->format('Y-m') === $selectedMonthYear;
        })->sum('jumlah_gaji');

        // Filter data pengeluaran berdasarkan bulan dan tahun
        $kaskeluar = $kas->filter(function ($item) use ($selectedMonthYear) {
            return Carbon::parse($item->created_at)->format('Y-m') === $selectedMonthYear;
        })->sum('pengeluaran');

        return view('keuangan.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Keuangan',
            'breadcrumb' => 'Data Keuangan',
            'name_user' => $user->name,
            'pengeluarans' => $pengeluarans,
            'pemasukans' => $pemasukans,
            'gajiKaryawans' => $gajiKaryawans,
            'kasmasuk' => $kasMasuk,
            'kaskeluar' => $kaskeluar,
            'selectedMonthYear' => $selectedMonthYear,
        ]);
    }
}
