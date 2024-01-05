<?php

namespace App\Http\Controllers;

use App\Models\GajiKaryawanV2;
use App\Http\Requests\StoreGajiKaryawanV2Request;
use App\Http\Requests\UpdateGajiKaryawanV2Request;
use App\Models\Karyawan;
use App\Models\Kasbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GajiKaryawanV2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = GajiKaryawanV2::with(['karyawans', 'jenisp', 'pengeluarans', 'kasbons']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->input('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->input('end_date'))->endOfDay();

            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $search = $request->input('searchdata');
        if ($search) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('id_karyawan', 'like', '%' . $search . '%')
                    ->orWhereHas('karyawans', function ($subQuery) use ($search) {
                        $subQuery->where('nama_karyawan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kasbons', function ($subQuery) use ($search) {
                        $subQuery->where('id_karyawan', 'like', '%' . $search . '%');
                    });
            });
        }
        $perPage = $request->input('dataOptions', 10);
        $dataGaji = $query->paginate($perPage);

        $dataKasBon = Kasbon::select('id_karyawan', DB::raw('SUM(nominal) as total_nominal'))
            ->with(['karyawans', 'gajikaryawanv2'])
            ->groupBy('id_karyawan')
            ->get();

        foreach ($dataGaji as $gaji) {
            $idKaryawan = $gaji->karyawans->id_karyawan;
            $totalKasbon = $dataKasBon->where('id_karyawan', $idKaryawan)->first();
            $gaji->sisa_gaji = $gaji->jumlah_gaji - ($totalKasbon ? $totalKasbon->total_nominal : 0);
        }

        return view('gajiv2.data', [
            'name_user' => $user->name,
            'title' => 'Gaji V2',
            'breadcrumb' => 'Gaji V2',
            'datas' => $dataGaji,
            'totalKasBon' => $dataKasBon,
            'perPageOptions' => [10, 15, 25, 100],
        ]);
    }

    public function cariData(Request $request)
    {
        return $this->index($request);
    }

    public function cariKasbon(Request $request)
    {
        return $this->index($request);
    }
    public function filterJumlah(Request $request)
    {
        return $this->index($request);
    }


    public function tambahGajiv2()
    {
        $user = Auth::user();
        $gajikaryawansV2 = GajiKaryawanv2::with('kasbons', 'karyawans')->get();
        $karyawans = Karyawan::all();

        return view('gajiv2.tambah', [
            'title' => 'Tambah Gaji Karyawan',
            'breadcrumb' => 'Gaji Karyawan',
            'name_user' => $user->name,
            'gajikaryawans' => $gajikaryawansV2,
            'karyawans' => $karyawans,
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
    public function store(StoreGajiKaryawanV2Request $request)
    {
        $v2 = new GajiKaryawanV2;

        $v2->id_karyawan = $request->txtidkaryawan;
        $v2->jumlah_gaji = str_replace('.', '', $request->txtjumlahgaji);
        $v2->persen_bonus = $request->txtpersen;
        $v2->bonus = str_replace('.', '', $request->txtbonus);
        $v2->save();
        return redirect('/gaji-karyawanv2')->with('success', 'Gaji Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(GajiKaryawanV2 $gajiKaryawanV2)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GajiKaryawanV2 $gajiKaryawanV2)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGajiKaryawanV2Request $request, GajiKaryawanV2 $gajiKaryawanV2)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GajiKaryawanV2 $gajiKaryawanV2)
    {
        //
    }
}
