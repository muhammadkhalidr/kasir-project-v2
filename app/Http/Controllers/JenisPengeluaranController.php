<?php

namespace App\Http\Controllers;

use App\Models\JenisPengeluaran;
use App\Http\Requests\StoreJenisPengeluaranRequest;
use App\Http\Requests\UpdateJenisPengeluaranRequest;
use App\Models\JenisBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $idJenis = JenisPengeluaran::latest('id_jenis')->first();
        $perPage = $request->input('dataOptions', 10);

        $query = JenisPengeluaran::query();
        $jenis = $query->get();

        // Terapkan filter pencarian jika ada
        if ($request->has('q')) {
            $query->where('nama_jenis', 'like', '%' . $request->input('q') . '%');
        }

        // Ambil data dengan filter pencarian yang telah diterapkan
        $jenispengeluarans = $query->paginate($perPage);

        return view('jenispengeluaran.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Jenis Pengeluaran',
            'breadcrumb' => 'Jenis Pengeluaran',
            'name_user' => $user->name,
            'datas' => $jenispengeluarans,
            'idJenis' => $idJenis->id_jenis + 1,
            'perPageOptions' => [10, 15, 25, 100],
        ]);
    }


    public function limitJumlah(Request $request)
    {
        return $this->index($request);
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
    public function store(StoreJenisPengeluaranRequest $request)
    {
        $jenis = new JenisPengeluaran;

        $jenis->id_jenis = $request->id_jenis;
        $jenis->nama_jenis = $request->jenis;
        $jenis->aktif = $request->status;
        $jenis->save();

        return redirect('jenis-pengeluaran')->with('success', 'Data Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPengeluaran $jenisPengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPengeluaran $jenisPengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenisPengeluaranRequest $request, $id)
    {
        $data = JenisPengeluaran::findOrFail($id);

        $data->id_jenis = $request->id_jenis;
        $data->nama_jenis = $request->jenis;
        $data->aktif = $request->status;
        $data->save();

        return redirect('jenis-pengeluaran')->with('success', 'Data Berhasil Di-update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = JenisPengeluaran::findOrFail($id);

        // dd($data);
        $data->delete();
        return redirect('/jenis-pengeluaran')->with('success', 'Data Berhasil di Hapus');
    }
}
