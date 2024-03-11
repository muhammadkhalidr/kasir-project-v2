<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RincianPendapatanController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $data = KasMasuk::with('orderans')->get();
        // dd($data);
        return view(
            'pendapatan.index',
            [
                'title' => 'Rincian Pendapatan',
                'name_user' => $user->name,
                'breadcrumb' => 'Rincian Pendapatan',
                'datas' => $data
            ]
        );
    }
}
