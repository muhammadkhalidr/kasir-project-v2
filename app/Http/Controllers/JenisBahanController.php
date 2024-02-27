<?php

namespace App\Http\Controllers;

use App\Models\JenisBahan;
use App\Http\Requests\StoreJenisBahanRequest;
use App\Http\Requests\UpdateJenisBahanRequest;
use App\Models\KategoriBahan;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisBahanController extends Controller
{

    protected $demoMode;

    public function __construct()
    {
        $this->demoMode = setting::where('demo', 'Y')->exists();
    }
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
        $search = $request->input('q');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('bahan', 'like', '%' . $search . '%')
                    ->orWhereHas('kategories', function ($subQuery) use ($search) {
                        $subQuery->where('kategori', 'like', '%' . $search . '%');
                    });
            });
        }
        $data = $query->paginate($perPage);
        return view('jbahan.data', [
            'title' => 'Jenis Bahan',
            'name_user' => $user->name,
            'datas' => $data,
            'kategori' => $kategori,
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
    public function store(StoreJenisBahanRequest $request)
    {
        $data = new JenisBahan;

        $data->bahan = $request->bahan;
        $data->id_kategori = $request->kategori;
        $data->stok = $request->stok;
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

        if ($this->demoMode) {
            return redirect()->back()->with('error', 'Dalam Mode Demo Tidak Bisa Edit Data');
        }

        $data = JenisBahan::findOrFail($id);

        $data->bahan = $request->bahan;
        $data->status = $request->status;
        $data->stok = $request->stok;
        $data->id_kategori = $request->kategori;
        $data->save();

        return redirect('bahan')->with('success', 'Data berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->demoMode) {
            return redirect()->back()->with('error', 'Dalam Mode Demo Tidak Bisa Hapus Data');
        }
        $data = JenisBahan::findOrFail($id);
        $data->delete();

        return redirect('bahan')->with('success', 'Data berhasil dihapus.');
    }
}
