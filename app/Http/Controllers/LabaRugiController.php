<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabaRugiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $aktiva_pendapatan = Akun::where('aktiva', 3)->get();

        // Hitung Total Pendapatan dan Total Biaya Langsung
        $total_pendapatan = 0;
        $total_biaya_langsung = 0;

        foreach ($aktiva_pendapatan as $lancar) {
            // Hitung Total Pendapatan dari Jurnal
            $lancar->kas = Jurnal::where('no_reff', $lancar->id_akun)->sum('nominal');
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
            $b->kas = Jurnal::where('no_reff', $b->id_akun)->sum('nominal');
            $total_beban += $b->kas;
        }

        // Hitung Laba Bersih
        $laba_bersih = $laba_kotor - $total_beban;

        $dataPersediaan = Jurnal::with('jenisP')->where('no_reff', 310)->get();

        return view(
            'pembukuan.laba-rugi',
            [
                'title' => 'Laba Rugi',
                'name_user' => $user->name,
                'breadcrumb' => 'Laba Rugi',
                'aktiva_pendapatan' => $aktiva_pendapatan,
                'laba_kotor' => $laba_kotor,
                'beban' => $beban,
                'dataPersediaan' => $dataPersediaan,
                'total_beban' => $total_beban,
                'laba_bersih' => $laba_bersih
            ]
        );
    }
}
