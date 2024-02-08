<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('dataOptions', 10);

        $query = Supplier::query();
        $sup = $query->get();

        if ($request->has('q')) {
            $query->where('nama', 'like', '%' . $request->input('q') . '%')
                ->orWhere('pemilik', 'like', '%' . $request->input('q') . '%')
                ->orWhere('nohp', 'like', '%' . $request->input('q') . '%')
                ->orWhere('email', 'like', '%' . $request->input('q') . '%');
        }

        $supplier = $query->paginate($perPage);
        return view('supplier.data', [
            'title' => 'Data Supplier',
            'name_user' => $user->name,
            'datas' => $supplier,
            'perPageOptions' => [10, 15, 25, 100],
        ]);
    }

    public function limit(Request $request)
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
    public function update(UpdateSupplierRequest $request, $id)
    {
        $data = Supplier::findOrFail($id);

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

        return redirect()->back()->with(['success' => 'Data Berhasil Di Update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Supplier::findOrFail($id);
        $data->delete();
        return redirect()->back()->with(['success' => 'Data Berhasil Di Hapus']);
    }
}
