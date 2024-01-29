<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('dataOptions', 10);
        $query = Pelanggan::query();

        // Search Data
        $search = $request->input('searchdata');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        $datas = $query->paginate($perPage);

        return view('pelanggan.data', [
            'name_user' => $user->name,
            'title' => env('APP_NAME') . ' | ' . 'Pelanggan',
            'breadcrumb' => 'Pelanggan',
            'data' => $datas,
            'perPageOptions' => [10, 15, 25, 100],
        ]);
    }




    public function tambahPelanggan()
    {
        $user = Auth::user();

        return view('pelanggan.tambah', [
            'name_user' => $user->name,
            'title' => 'Pelanggan',
            'breadcrumb' => 'Pelanggan',
        ]);
    }


    public function limit(Request $request)
    {
        return $this->index($request);
    }
    public function cariData(Request $request)
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
    public function store(StorePelangganRequest $request)
    {
        $user = Auth::user();

        $pelanggan = new Pelanggan;

        $pelanggan->kode_pelanggan = $request->kodepelanggan;
        $pelanggan->nama = $request->namapelanggan;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->nohp = $request->nohp;
        $pelanggan->save();


        return redirect('pelanggan')->with('success', 'Data Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $pelanggan = Pelanggan::find($id);

        return view('pelanggan.edit', [
            'title' => 'Edit Pelanggan',
            'name_user' => $user->name,
        ])->with([
            'id' => $id,
            'nama' => $pelanggan->nama,
            'alamat' => $pelanggan->alamat,
            'nohp' => $pelanggan->nohp,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, $id)
    {
        $data = Pelanggan::find($id);

        if (!$data) {
            return redirect('karyawan')->with('error', 'Data not found.');
        }

        // $data->id = $request->txtid;
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->nohp = $request->nohp;
        $data->save();

        return redirect('pelanggan')->with('success', 'Data Berhasil Di-update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->delete();

        return redirect('pelanggan')->with('msg', 'Data Berhasil Di-hapus!');
    }
}
