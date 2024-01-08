<?php

namespace App\Http\Controllers;

use App\Models\JenisBahan;
use App\Http\Requests\StoreJenisBahanRequest;
use App\Http\Requests\UpdateJenisBahanRequest;
use App\Models\KategoriBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisBahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $data = JenisBahan::with('kategories');
        $kategori = KategoriBahan::where('status', 'Y')->get();
        $perPage = $request->input('dataOptions', 10);
        $query = JenisBahan::query();

        // Search Data
        $search = $request->input('searchdata');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        $data = $query->paginate($perPage);

        // dd($data);

        return view('jbahan.data', [
            'title' => 'Jenis Bahan',
            'name_user' => $user->name,
            'datas' => $data,
            'kategori' => $kategori,
            'perPageOptions' => [10, 15, 25, 100],

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
    public function store(StoreJenisBahanRequest $request)
    {
        $data = new JenisBahan;

        $data->bahan = $request->bahan;
        $data->id_kategori = $request->kategori;
        $data->status = $request->status;

        $data->save();

        return redirect('bahan')->with('success', 'Data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisBahan $jenisBahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisBahan $jenisBahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenisBahanRequest $request, $id)
    {

        $data = JenisBahan::findOrFail($id);

        $data->bahan = $request->bahan;
        $data->status = $request->status;
        $data->id_kategori = $request->kategori;
        $data->save();

        return redirect('bahan')->with('success', 'Data berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = JenisBahan::findOrFail($id);
        $data->delete();

        return redirect('bahan')->with('success', 'Data berhasil dihapus.');
    }
}
