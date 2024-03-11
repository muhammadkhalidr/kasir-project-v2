<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Http\Requests\StoreAkunRequest;
use App\Http\Requests\UpdateAkunRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
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
        $data = Akun::where('aktif', 'Y');

        return view('pembukuan.akun', [
            'title' => 'Jenis Akun',
            'name_user' => $user->name,
            'breadcrumb' => 'Jenis Akun',
            'datas' => $data->paginate(10),
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
        $data = new Akun;

        $data->id_akun = $request->no_reff;
        $data->id_user = $request->user()->id;
        $data->nama_reff = $request->akun;
        $data->keterangan = $request->ket;
        $data->aktif = $request->aktif;

        // Mendapatkan nilai jenis yang dipilih dari form
        $jenis = $request->jenis;

        // Menentukan kolom berdasarkan nilai jenis yang dipilih
        switch ($jenis) {
            case 1:
                $data->aktiva = 1;
                break;
            case 2:
                $data->pasiva = 1;
                break;
            case 3:
                $data->kewajiban = 1;
                break;
            case 4:
                $data->pasiva = 1;
                break;
            case 5:
                $data->beban = 1;
                break;
            default:

                break;
        }

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

        $data->id_akun = $request->no_reff;
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
