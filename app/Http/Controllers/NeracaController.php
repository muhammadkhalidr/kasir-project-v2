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
        $total_aset_tetap = Jurnal::where('tipe', 'debit')->sum('nominal');
        $total_pendapatan_aset = Jurnal::where('tipe', 'kredit')->sum('nominal');

        foreach ($aktiva_lancar as $lancar) {
            $lancar->kas = Jurnal::where('no_reff', $lancar->id_akun)->sum('nominal');
        }

        foreach ($aktiva_pendapatan as $pendapatan) {
            $pendapatan->kas = Jurnal::where('no_reff', $pendapatan->id_akun)->sum('nominal');
        }

        $total_aset_tetap = 0; // Inisialisasi total aset tetap
        foreach ($aktiva_tetap as $tetap) {
            $tetap->kas = Jurnal::where('no_reff', $tetap->id_akun)->sum('nominal');
            $total_aset_tetap += $tetap->kas; // Menambahkan nilai $tetap->kas ke total
        }

        $total_pendapatan_aset = 0; // Inisialisasi total aset tetap
        foreach ($aktiva_pendapatan as $pendapatan) {
            $pendapatan->kas = Jurnal::where('no_reff', $pendapatan->id_akun)->sum('nominal');
            $total_pendapatan_aset += $pendapatan->kas; // Menambahkan nilai $tetap->kas ke total
        }

        // Pasiva
        $pasiva_lancar = Akun::where('pasiva', 1)->get();
        $total_pasiva_lancar = 0;
        foreach ($pasiva_lancar as $lancar) {
            $lancar->kas = Jurnal::where('no_reff', $lancar->id_akun)->sum('nominal');
            $total_pasiva_lancar += $lancar->kas;
        }

        // Beban
        $beban_lancar  = Akun::where('beban', 1)->get();
        $total_beban_lancar = 0;
        foreach ($beban_lancar as $lancar) {
            $lancar->kas = Jurnal::where('no_reff', $lancar->id_akun)->sum('nominal');
            $total_beban_lancar += $lancar->kas;
        }

        return view('pembukuan.neraca', [
            'title' => 'Neraca',
            'breadcrumb' => 'Neraca',
            'name_user' => $user->name,
            'aktiva_lancar' => $aktiva_lancar,
            'aktiva_tetap' => $aktiva_tetap,
            'pendapatan' => $aktiva_pendapatan,
            'tetap' => $aktiva_tetap,
            'pasiva_lancar' => $pasiva_lancar,
            'beban_lancar' => $beban_lancar,
            'total_aset' => $total_aset,
            'total_aset_tetap' => $total_aset_tetap,
            'total_pendapatan_aset' => $total_pendapatan_aset,
            'total_pasiva_lancar' => $total_pasiva_lancar,
            'total_beban_lancar' => $total_beban_lancar,
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
