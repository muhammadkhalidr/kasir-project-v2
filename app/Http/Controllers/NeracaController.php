<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NeracaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Aktiva
        $aktiva_lancar = Akun::where('aktiva', 1)->get();
        $aktiva_tetap = Akun::where('aktiva', 2)->get();
        $aktiva_pendapatan = Akun::where('aktiva', 3)->get();
        $total_aset = Jurnal::where('tipe', 'debit')->sum('nominal');

        // dd($total_aset);
        // Pasiva
        $pasiva_lancar = Akun::where('pasiva', 1)->get();

        foreach ($aktiva_lancar as $lancar) {
            $lancar->kas = Jurnal::where('no_reff', $lancar->id_akun)->sum('nominal');
        }
        foreach ($aktiva_pendapatan as $pendapatan) {
            $pendapatan->kas = Jurnal::where('no_reff', $pendapatan->id_akun)->sum('nominal');
        }
        return view('pembukuan.neraca', [
            'title' => 'Neraca',
            'breadcrumb' => 'Neraca',
            'name_user' => $user->name,
            'aktiva_lancar' => $aktiva_lancar,
            'aktiva_tetap' => $aktiva_tetap,
            'pendapatan' => $aktiva_pendapatan,
            'pasiva_lancar' => $pasiva_lancar,
            'total_aset' => $total_aset
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
