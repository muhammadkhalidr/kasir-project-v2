<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $supplier = Supplier::paginate(10);
        return view('supplier.data', [
            'title' => 'Data Supplier',
            'name_user' => $user->name,
            'datas' => $supplier
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
    public function store(StoreSupplierRequest $request)
    {

        $validated = $request->validated();

        $data = new Supplier;
        $data->nama = $request->perusahaan;
        $data->jenis_usaha = $request->jenisusaha;
        $data->pemilik = $request->nama;
        $data->jabatan = $request->jabatan;
        $data->alamat = $request->alamat;
        $data->nohp = $request->nohp;
        $data->email = $request->email;
        $data->norek = $request->norek;
        $data->status = $request->status;
        $data->save();
        // dd($data);

        return redirect()->back()->with(['success' => 'Data Berhasil Ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
