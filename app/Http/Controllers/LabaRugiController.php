<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurnal;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PDF;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedDate = $request->input('filterTgl', \Carbon\Carbon::now()->toDateString());

        // Konversi created_at filter ke format yang sesuai
        $selectedDateFormatted = \Carbon\Carbon::parse($selectedDate)->format('Y-m');

        $aktiva_pendapatan = Akun::where('aktiva', 3)->get();

        // Hitung Total Pendapatan dan Total Biaya Langsung
        $total_pendapatan = 0;
        $total_biaya_langsung = 0;

        foreach ($aktiva_pendapatan as $lancar) {
            // Hitung Total Pendapatan dari Jurnal
            $lancar->kas = Jurnal::where('no_reff', $lancar->id_akun)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_pendapatan += $lancar->kas;

            // Tambahkan Kolom Biaya Langsung di Tabel Akun
            $lancar->biaya_langsung = 0; // nilai biaya langsung yang sesuai dari database

            // Hitung Total Biaya Langsung
            $total_biaya_langsung += $lancar->biaya_langsung;
        }

        // Hitung Laba Kotor
        $laba_kotor = $total_pendapatan - $total_biaya_langsung;

        // Hitung Total Beban
        $beban = Akun::where('beban', 1)->get();
        $total_beban = 0;
        foreach ($beban as $b) {
            $b->kas = Jurnal::where('no_reff', $b->id_akun)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_beban += $b->kas;
        }

        // Hitung Total Biaya
        $biayas = Akun::where('aktiva', 1)->where('id_akun', 310)->get();
        $total_biayas = 0;
        foreach ($biayas as $biaya) {
            $biaya->kas = Jurnal::where('no_reff', 310)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_biayas += $biaya->kas;
        }

        // Hitung Prive
        $prive = Akun::where('kewajiban', 1)->where('id_akun', 480)->get();
        $total_prive = 0;
        foreach ($prive as $p) {
            $p->kas = Jurnal::where('no_reff', 480)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_prive += $p->kas;
        }

        // Hitung Laba Bersih
        $laba_bersih = $laba_kotor - $total_beban - $total_biayas - $total_prive;

        $dataPersediaan = Jurnal::with('jenisP')
            ->where('no_reff', 310)
            ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
            ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
            ->get();

        return view(
            'pembukuan.laba-rugi',
            [
                'title' => 'Laba Rugi',
                'name_user' => $user->name,
                'breadcrumb' => 'Laba Rugi',
                'aktiva_pendapatan' => $aktiva_pendapatan,
                'laba_kotor' => $laba_kotor,
                'beban' => $beban,
                'biayas' => $biayas,
                'prive' => $prive,
                'dataPersediaan' => $dataPersediaan,
                'total_beban' => $total_beban,
                'total_biayas' => $total_biayas,
                'laba_bersih' => $laba_bersih,
                'selectedDate' => $selectedDateFormatted,
            ]
        );
    }

    public function cetakLabaRugi(Request $request)
    {

        $info = Setting::all();
        $user = Auth::user();

        $selectedDate = $request->input('filterTgl', \Carbon\Carbon::now()->toDateString());

        // Konversi created_at filter ke format yang sesuai
        $selectedDateFormatted = \Carbon\Carbon::parse($selectedDate)->format('Y-m');

        $aktiva_pendapatan = Akun::where('aktiva', 3)->get();

        // Hitung Total Pendapatan dan Total Biaya Langsung
        $total_pendapatan = 0;
        $total_biaya_langsung = 0;

        foreach ($aktiva_pendapatan as $lancar) {
            // Hitung Total Pendapatan dari Jurnal
            $lancar->kas = Jurnal::where('no_reff', $lancar->id_akun)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_pendapatan += $lancar->kas;

            // Tambahkan Kolom Biaya Langsung di Tabel Akun
            $lancar->biaya_langsung = 0; // nilai biaya langsung yang sesuai dari database

            // Hitung Total Biaya Langsung
            $total_biaya_langsung += $lancar->biaya_langsung;
        }

        // Hitung Laba Kotor
        $laba_kotor = $total_pendapatan - $total_biaya_langsung;

        // Hitung Total Beban
        $beban = Akun::where('beban', 1)->get();
        $total_beban = 0;
        foreach ($beban as $b) {
            $b->kas = Jurnal::where('no_reff', $b->id_akun)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_beban += $b->kas;
        }

        // Hitung Total Biaya
        $biayas = Akun::where('aktiva', 1)->where('id_akun', 310)->get();
        $total_biayas = 0;
        foreach ($biayas as $biaya) {
            $biaya->kas = Jurnal::where('no_reff', 310)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_biayas += $biaya->kas;
        }

        // Hitung Prive
        $prive = Akun::where('kewajiban', 1)->where('id_akun', 480)->get();
        $total_prive = 0;
        foreach ($prive as $p) {
            $p->kas = Jurnal::where('no_reff', 480)
                ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
                ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
                ->sum('nominal');
            $total_prive += $p->kas;
        }

        // Hitung Laba Bersih
        $laba_bersih = $laba_kotor - $total_beban - $total_biayas - $total_prive;

        $dataPersediaan = Jurnal::with('jenisP')
            ->where('no_reff', 310)
            ->whereYear('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->year)
            ->whereMonth('created_at', '=', \Carbon\Carbon::parse($selectedDateFormatted)->month)
            ->get();

        // return view(
        //     'pembukuan.cetak.laba-rugi',
        //     [
        //         'aktiva_pendapatan' => $aktiva_pendapatan,
        //         'laba_kotor' => $laba_kotor,
        //         'beban' => $beban,
        //         'biayas' => $biayas,
        //         'prive' => $prive,
        //         'dataPersediaan' => $dataPersediaan,
        //         'total_beban' => $total_beban,
        //         'total_biayas' => $total_biayas,
        //         'laba_bersih' => $laba_bersih,
        //         'selectedDate' => $selectedDateFormatted,
        //         'info' => $info,
        //         'name_user' => $user->name
        //     ]
        // );

        // Generate PDF
        $pdf = PDF::loadView('pembukuan.cetak.laba-rugi', [
            'aktiva_pendapatan' => $aktiva_pendapatan,
            'laba_kotor' => $laba_kotor,
            'beban' => $beban,
            'biayas' => $biayas,
            'prive' => $prive,
            'dataPersediaan' => $dataPersediaan,
            'total_beban' => $total_beban,
            'total_biayas' => $total_biayas,
            'laba_bersih' => $laba_bersih,
            'selectedDate' => $selectedDateFormatted,
            'info' => $info,
            'name_user' => $user->name
        ]);

        // Download PDF
        return $pdf->download('laporan-laba-rugi-' . $selectedDateFormatted . '.pdf');
    }
}
