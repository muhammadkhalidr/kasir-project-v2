<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Http\Requests\StoreSatuanRequest;
use App\Http\Requests\UpdateSatuanRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class SatuanController extends Controller
{

    protected $demoMode;

    public function __construct()
    {
        $this->demoMode = Setting::where('demo', 'Y')->exists();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('dataOptions', 10);
        $query = Satuan::query();
        $jenis = $query->get();

        // Terapkan filter pencarian jika ada
        if ($request->has('q')) {
            $query->where('satuan', 'like', '%' . $request->input('q') . '%');
        }

        // Ambil data dengan filter pencarian yang telah diterapkan
        $data = $query->paginate($perPage);
        return view('satuan.data', [
            'title' => 'Data Satuan',
            'name_user' => $user->name,
            'datas' => $data,
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

        if ($this->demoMode) {
            return redirect('satuan')->with('error', 'Dalam Mode Demo Tidak Bisa Edit Data');
        }
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

        if ($this->demoMode) {
            return redirect('satuan')->with('error', 'Dalam Mode Demo Tidak Bisa Hapus Data');
        }
        $data = Satuan::findOrFail($id);
        $data->delete();
        return redirect('satuan')->with('success', 'Data Berhasil Dihapus!');
    }
}
