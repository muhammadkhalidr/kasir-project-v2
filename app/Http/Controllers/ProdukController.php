<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\JenisBahan;
use App\Models\KategoriBahan;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Produk::with(['kategories', 'bahans'])->paginate(12);
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
        $data->jumlah = $request->jumlah;
        $data->id_kategori = $request->kategori;
        $data->id_bahan = $request->bahan;
        $data->ukuran = $request->ukuran;
        $data->public = $request->public;
        $data->harga_jual = str_replace('.', '', $request->hargajual);
        $data->harga_beli = str_replace('.', '', $request->hargabeli);

        // dd($data);

        $data->save();
        return redirect()->back()->with('success', 'Produk Berhasil di Tambahkan!');
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
    public function update(UpdateProdukRequest $request, $id)
    {

        $data = Produk::findOrFail($id);

        $data->judul = $request->produk;
        $data->barcode = $request->barcode;
        $data->jumlah = $request->jumlah;
        $data->id_kategori = $request->kategori;
        $data->id_bahan = $request->bahan;
        $data->ukuran = $request->ukuran;
        $data->public = $request->public;
        $data->harga_jual = str_replace('.', '', $request->hargajual);
        $data->harga_beli = str_replace('.', '', $request->hargabeli);

        // dd($data);

        $data->save();
        return redirect()->back()->with('success', 'Produk Berhasil di Update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Produk::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'data berhasil di hapus');
    }
}
