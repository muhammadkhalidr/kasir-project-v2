<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Http\Requests\StoreSatuanRequest;
use App\Http\Requests\UpdateSatuanRequest;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Satuan::paginate(10);
        return view('satuan.data', [
            'title' => 'Data Satuan',
            'name_user' => $user->name,
            'datas' => $data
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
    public function store(StoreSatuanRequest $request)
    {
        $validation = $request->validated();

        $data = new Satuan;
        $data->satuan = $request->satuan;
        $data->save();

        return redirect('satuan')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSatuanRequest $request, $id)
    {
        $data = Satuan::findOrFail($id);
        $data->satuan = $request->satuan;
        $data->save();

        return redirect('satuan')->with('success', 'Data Berhasil Di-update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Satuan::findOrFail($id);
        $data->delete();
        return redirect('satuan')->with('success', 'Data Berhasil Dihapus!');
    }
}
