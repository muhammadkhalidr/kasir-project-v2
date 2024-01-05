<?php

namespace App\Http\Controllers;

use App\Models\DetailOrderan;
use App\Models\KasMasuk;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class KasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kasKecils = KasMasuk::where('bank', 'kaskecil')->get();
        $pemasukanTunai = KasMasuk::where('bank', '888')->sum('pemasukan') - KasMasuk::where('bank', '888')->sum('pengeluaran');

        $rekenings = Rekening::with('kasMasuk')->get();
        $pemasukanBank = 0;

        foreach ($rekenings as $rekening) {
            $pemasukanBank += KasMasuk::where('bank', $rekening->id)
                ->sum('pemasukan') - KasMasuk::where('bank', $rekening->id)
                ->sum('pengeluaran');
        }


        // Retrieve distinct bank names
        $dataBank = Rekening::pluck('id')->unique()->toArray();

        // Initialize an array to store bank details
        $bankDetails = [];

        // Loop through each bank and calculate the sum of pemasukan
        foreach ($dataBank as $bankId) {
            $saldo = KasMasuk::where('bank', $bankId)->sum('pemasukan') - KasMasuk::where('bank', $bankId)->sum('pengeluaran');
            $bankDetails[] = [
                'bank' => Rekening::find($bankId)->bank, // Mengambil nama bank dari tabel Rekening
                'saldo' => $saldo,
            ];
        }


        $kasKecil = KasMasuk::where('bank', 'kaskecil')->sum('pemasukan') - KasMasuk::where('bank', 'kaskecil')->sum('pengeluaran');

        return view('kas.data', [
            'title' => env('APP_NAME') . ' | ' . 'Kas',
            'name_user' => $user->name,
            'tunai' => $pemasukanTunai,
            'bank' => $pemasukanBank,
            'bankDetails' => $bankDetails,
            'kasKecil' => $kasKecil,
            'kasKecils' => $kasKecils
        ]);
    }

    public function tambahKas(Request $request)
    {
        $data = $request->all();

        // Get the latest id_generate value from the database
        $idBaru = KasMasuk::max('id_generate');

        // Extract the numeric part from the latest id_generate value
        $nomorKas = intval(substr($idBaru, strlen('KasKecil-')));

        // Increment the numeric part by 1
        $noBaru = $nomorKas + 1;

        // Generate the new id_generate value
        $idGenerateKasKecil = 'KasKecil-' . $noBaru;

        $kasKecil = new KasMasuk;

        $kasKecil->id_generate = $idGenerateKasKecil;
        $kasKecil->no_reff = $data['noreff'];
        $kasKecil->bank = $data['kaskecil'];
        $kasKecil->pemasukan = $data['nominal'];
        $kasKecil->keterangan = 'Kas Kecil ' . $data['keterangan'];
        $kasKecil->name_kasir = $data['kasir'];
        $kasKecil->save();

        return redirect()->back()->with('success', 'Kas kecil ditambahkan');
    }

    public function hapusKasKecil($no_reff)
    {
        KasMasuk::where('no_reff', $no_reff)->delete();
        return redirect()->back()->with('success', 'Kas kecil dihapus');
    }
}
