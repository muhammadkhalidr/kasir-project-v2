<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Http\Requests\StoreAkunRequest;
use App\Http\Requests\UpdateAkunRequest;
use App\Models\setting;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{

    protected $demoMode;

    public function __construct()
    {
        $this->demoMode = setting::where('demo', 'Y')->exists();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Akun::where('aktif', 'Y');

        return view('pembukuan.akun', [
            'title' => 'Jenis Akun',
            'name_user' => $user->name,
            'breadcrumb' => 'Jenis Akun',
            'datas' => $data->get(),
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
    public function store(StoreAkunRequest $request)
    {
        // $user = Auth::user();
        $data = new Akun;

        $data->no_reff = $request->no_reff;
        $data->id_user = $request->user()->id;
        $data->nama_reff = $request->akun;
        $data->keterangan = $request->ket;
        $data->aktif = $request->aktif;
        $data->save();

        return redirect()->back()->with('success', 'Data Berhasil di Tambahkan.!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Akun $akun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akun $akun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAkunRequest $request, $id)
    {

        // if ($this->demoMode) {
        //     return redirect()->back()->with('warning', 'Tidak bisa Update Data Dalam Mode Demo');
        // }

        $data = Akun::findOrFail($id);

        $data->no_reff = $request->no_reff;
        $data->id_user = $request->user()->id;
        $data->nama_reff = $request->akun;
        $data->keterangan = $request->ket;
        $data->aktif = $request->aktif;
        $data->save();

        return redirect()->back()->with('success', 'Data Berhasil di Update.!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        // if ($this->demoMode) {
        //     return redirect()->back()->with('warning', 'Tidak bisa Hapus Data Dalam Mode Demo');
        // }

        $data = Akun::findOrFail($id);
        if ($data) {
            $data->delete();
        }

        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }
}
