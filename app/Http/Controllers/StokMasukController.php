<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Http\Requests\StoreStokMasukRequest;
use App\Http\Requests\UpdateStokMasukRequest;
use App\Models\StokKeluar;
use Illuminate\Support\Facades\Auth;

class StokMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    public function dataStok()
    {
        $user = Auth::user();
        $stokMasuk = StokMasuk::with('bahans')->paginate(10);
        $stokKeluar = StokKeluar::with('bahans')->paginate(10);

        return view('stokmasuk.datastok', [
            'title' => 'Data Stok',
            'name_user' => $user->name,
            'stokMasuk' => $stokMasuk, // Mengubah 'datas' menjadi 'stokMasuk' untuk konsistensi
            'stokKeluar' => $stokKeluar,
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
    public function store(StoreStokMasukRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StokMasuk $stokMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StokMasuk $stokMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStokMasukRequest $request, StokMasuk $stokMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StokMasuk $stokMasuk)
    {
        //
    }
}