<?php

namespace App\Http\Controllers;

use App\Models\Kasbon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

// use Barryvdh\DomPDF\PDF;
use PDF;

class KasbonController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $datas = Kasbon::with('pengeluarans')->paginate(10);
        // dd($datas);
        return view('kasbon.data', [
            'title' => 'KasBon',
            'name_user' => $user->name,
            'breadcrumb' => 'Kasbon',
            'datas' => $datas
        ]);
    }

    public function printKasBon()
    {
        $user = Auth::user();
        $datas = Kasbon::with(['pengeluarans', 'jenis'])->paginate(10);

        $total = Kasbon::select('nominal')->sum('nominal');

        $pdf = PDF::loadView('kasbon.print', [
            'title' => 'Cetak Kasbon',
            'datas' => $datas,
            'total' => $total,
            'name_user' => $user->name,
            'breadcrumb' => 'Kasbon',
        ]);

        return $pdf->download('Rekapan Kasbon.pdf');

        // return view('kasbon.print', [
        //     'title' => 'Cetak Kasbon',
        //     'datas' => $datas,
        //     'total' => $total,
        //     'name_user' => $user->name,
        //     'breadcrumb' => 'Kasbon',
        // ]);
    }
}
