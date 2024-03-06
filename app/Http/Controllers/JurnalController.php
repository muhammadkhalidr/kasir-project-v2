<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Http\Requests\StoreJurnalRequest;
use App\Http\Requests\UpdateJurnalRequest;
use App\Models\Akun;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $datas = Jurnal::with('akuns')->get(); // Fetch all data
        $akuns = Akun::where('aktif', 'Y')->get();

        $groupedData = $datas->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        })->map(function ($group, $key) {
            return [
                'formatted_date' => Carbon::parse($key)->isoFormat('MMMM YYYY'),
                'items' => $group
            ];
        })->values();

        return view('pembukuan.jurnalumum', [
            'title' => 'Jurnal Umum',
            'name_user' => $user->name,
            'datas' => $groupedData,
            'breadcrumb' => 'Jurnal Umum',
            'akuns' => $akuns

        ]);
    }


    public function showByMonth($month)
    {
        $user = Auth::user();
        $akuns = Akun::where('aktif', 'Y')->get();

        // Convert Indonesian month name to English
        $englishMonths = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $englishMonth = $englishMonths[explode(' ', $month)[0]];

        // Parse the formatted date back into a Carbon instance
        $date = Carbon::createFromFormat('F Y', $englishMonth . ' ' . explode(' ', $month)[1]);

        // Get the data for the selected month
        $datas = Jurnal::with('akuns')->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->get();

        // dd($datas);

        return view('pembukuan.jurnalumum_detail', [
            'title' => 'Detail Jurnal Umum',
            'name_user' => $user->name,
            'datas' => $datas,
            'breadcrumb' => 'Detail Jurnal Umum',
            'akuns' => $akuns

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
    public function store(StoreJurnalRequest $request)
    {
        $data = new Jurnal;
        $data->no_reff = $request->akun;
        $data->nominal = str_replace('.', '', $request->saldo);
        $data->tipe = $request->jsaldo;
        $data->created_at = $request->tgl;
        $data->save();

        return redirect()->back()->with('success', 'Berhasil Tambah Jurnal');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurnal $jurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_transaksi)
    {
        $data = Jurnal::findOrFail($id_transaksi);
        $data->no_reff = $request->akun;
        $data->nominal = str_replace('.', '', $request->saldo);
        $data->tipe = $request->jsaldo;
        $data->created_at = $request->tgl;
        $data->save();

        return redirect()->back()->with('success', 'Berhasil Edit Data');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_transaksi)
    {
        $data = Jurnal::findOrFail($id_transaksi);
        $data->delete();
        return redirect()->back()->with('success', 'Berhasil Hapus Data');
    }
}
