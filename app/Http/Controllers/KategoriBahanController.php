<?php

namespace App\Http\Controllers;

use App\Models\KategoriBahan;
use App\Http\Requests\StoreKategoriBahanRequest;
use App\Http\Requests\UpdateKategoriBahanRequest;
use App\Models\JenisPengeluaran;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\IFTTTHandler;

class KategoriBahanController extends Controller
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
        $query = KategoriBahan::query();
        $perPage = $request->input('dataOptions', 10);

        // Search Data
        $search = $request->input('searchdata');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('kategori', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $data = $query->paginate($perPage);

        return view('kategori.data', [
            'title' => 'Kategori',
            'name_user' => $user->name,
            'datas' => $data,
            'perPageOptions' => [10, 15, 25, 100],

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
    public function store(StoreKategoriBahanRequest $request)
    {
        $kategori  = new KategoriBahan;

        $kategori->kategori = $request->kategori;
        $kategori->status = $request->status;
        $kategori->save();


        return redirect()->back()->with('success', 'Data  Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriBahan $kategoriBahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriBahan $kategoriBahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriBahanRequest $request, $id)
    {

        if ($this->demoMode) {
            return redirect()->back()->with('error', 'Dalam Mode Demo Tidak Bisa Edit Data');
        }

        $kategori = KategoriBahan::findOrFail($id);
        $kategori->kategori = $request->kategori;
        $kategori->status = $request->status;
        $kategori->save();
        return redirect()->back()->with('success', 'Data  Berhasil Di-Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->demoMode) {
            return redirect()->back()->with('error', 'Dalam Mode Demo Tidak Bisa Hapus Data');
        }
        $data = KategoriBahan::findOrFail($id);
        $data->delete();

        return redirect('kategori')->with('success', 'Data Berhasil Dihapus!');
    }
}
