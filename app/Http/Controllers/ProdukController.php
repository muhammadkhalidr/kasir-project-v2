<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\JenisBahan;
use App\Models\KategoriBahan;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Produk::with(['kategories', 'bahans'])->paginate(10);
        $kategori = KategoriBahan::where('status', 'Y')->get();
        $bahan = JenisBahan::all();

        // dd($data);

        return view('produk.data', [
            'title' => 'Produk',
            'name_user' => $user->name,
            'datas' => $data,
            'kategori' => $kategori,
            'bahan' => $bahan,
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
    public function store(StoreProdukRequest $request)
    {
        $data = new Produk;

        $data->judul = $request->produk;
        $data->barcode = $request->barcode;
        $data->barcode = $request->barcode;
        $data->id_kategori = $request->kategori;
        $data->id_bahan = $request->bahan;
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }
}
