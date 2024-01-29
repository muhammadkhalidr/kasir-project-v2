<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailOrderan;
use App\Models\Rekening;
use App\Models\setting;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class PiutangController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $data = DetailOrderan::with(['pelanggans', 'pelunasans'])->paginate(20);
        $rekening = Rekening::all();
        $keterangan = DetailOrderan::select('keterangan', 'notrx')->get();

        return view('piutang.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Piutang',
            'breadcrumb' => 'Piutang',
            'name_user' => $user->name,
            'data' => $data,
            'rekening' => $rekening,
            'ket' => $keterangan,
        ]);
    }

    public function printPiutang()
    {
        $user = Auth::user();

        // Fetch data grouped by 'notrx'
        $datasGrouped = DetailOrderan::where('status', 'Belum Lunas')->with(['pelanggans', 'pelunasans'])->orderBy('notrx')->get()->groupBy('notrx');

        // dd($datasGrouped);

        // Initialize an array to store the first item for each 'notrx'
        $datas = [];
        foreach ($datasGrouped as $notrx => $items) {
            $datas[] = $items->first();
        }

        $total = DetailOrderan::where('status', 'Belum Lunas')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('detail_orderans')
                    ->where('status', 'Belum Lunas')
                    ->groupBy('notrx');
            })
            ->sum('sisa');

        $setting = Setting::all()->first();

        if (empty($datas)) {
            return redirect()->back()->with('error', 'Data Tidak Ditemukan!');
        } else {
            // return view('piutang.cetakpiutang', [
            //     'title' => 'Cetak Pengeluaran',
            //     'datas' => $datas,
            //     'datasGrouped' => $datasGrouped,
            //     'name_user' => $user->name,
            //     'breadcrumb' => 'Piutang',
            //     'total' => $total,
            //     'info' => $setting
            // ]);


            $pdf = PDF::loadView('piutang.cetakpiutang', [
                'title' => 'Cetak Pengeluaran',
                'datas' => $datas,
                'datasGrouped' => $datasGrouped,
                'name_user' => $user->name,
                'breadcrumb' => 'Piutang',
                'total' => $total,
                'info' => $setting
            ]);

            return $pdf->download('rincian_pitaung.pdf');
        }
    }
}
