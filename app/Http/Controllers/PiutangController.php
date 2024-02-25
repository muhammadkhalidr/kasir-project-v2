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

    public function cariPiutang(Request $request)
    {
        $user = Auth::user();
        $data = DetailOrderan::with(['pelanggans', 'pelunasans']);
        $rekening = Rekening::all();
        $keterangan = DetailOrderan::select('keterangan', 'notrx')->get();

        // Jika ada parameter 'q' yang dikirim melalui request
        if ($request->has('q')) {
            $searchTerm = str_replace('-', '', $request->input('q'));
            $data->where(function ($query) use ($searchTerm) {
                $query->whereRaw("REPLACE(notrx, '-', '') LIKE ?", ['%' . $searchTerm . '%'])
                    ->orWhereHas('pelanggans', function ($query) use ($searchTerm) {
                        $query->where('nama', 'like', '%' . $searchTerm . '%');
                    });
            });
        }


        $data = $data->paginate(10);

        return view('piutang.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Piutang',
            'breadcrumb' => 'Piutang',
            'name_user' => $user->name,
            'data' => $data,
            'rekening' => $rekening,
            'ket' => $keterangan,
        ]);
    }


    public function printPiutang(Request $request)
    {
        $user = Auth::user();

        // Fetch data grouped by 'notrx'
        $datasGrouped = DetailOrderan::where('status', 'Belum Lunas')->with(['pelanggans', 'pelunasans'])->orderBy('notrx');

        // Jika ada parameter 'q' yang dikirim melalui request
        if ($request->has('q')) {
            $searchTerm = str_replace('-', '', $request->input('q'));
            $datasGrouped->where(function ($query) use ($searchTerm) {
                $query->whereRaw("REPLACE(notrx, '-', '') LIKE ?", ['%' . $searchTerm . '%'])
                    ->orWhereHas('pelanggans', function ($query) use ($searchTerm) {
                        $query->where('nama', 'like', '%' . $searchTerm . '%');
                    });
            });
        }


        $datasGrouped = $datasGrouped->get()->groupBy('notrx');

        // Initialize an array to store the first item for each 'notrx'
        $datas = [];
        foreach ($datasGrouped as $notrx => $items) {
            $datas[] = $items->first();
        }

        // Calculate total for unique 'notrx'
        $total = 0;
        foreach ($datas as $data) {
            $total += $data->sisa;
        }

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

            return $pdf->download('Rincian_piutang .pdf');
        }
    }
}
