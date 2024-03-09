<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\JenisBahan;
use App\Models\KategoriBahan;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    protected $demoMode;

    public function __construct()
    {
        $this->demoMode = Setting::where('demo', 'Y')->exists();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Produk::with(['kategories', 'bahans'])->paginate(12);
        $kategori = KategoriBahan::where('status', 'Y')->get();
        $bahan = JenisBahan::all();

        return view('produk.data', [
            'title' => 'Produk',
            'name_user' => $user->name,
            'datas' => $data,
            'kategori' => $kategori,
            'bahan' => $bahan,
        ]);
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

        $data->save();
        return redirect()->back()->with('success', 'Produk Berhasil di Tambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, $id)
    {
        if ($this->demoMode) {
            // Jika mode demo adalah 'Y', tampilkan pesan dan tidak izinkan pembaruan data
            return redirect()->back()->with('error', 'Dalam Mode Demo Tidak Bisa Edit Data');
        }

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

        $data->save();
        return redirect()->back()->with('success', 'Produk Berhasil di Update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->demoMode) {
            // Jika mode demo adalah 'Y', tampilkan pesan dan tidak izinkan pembaruan data
            return redirect()->back()->with('error', 'Dalam Mode Demo Tidak Bisa Hapus Data');
        }

        $data = Produk::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'data berhasil di hapus');
    }
}
