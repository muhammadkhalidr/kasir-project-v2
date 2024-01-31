<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\DetailPembelian;
use App\Models\KasMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PDF;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = 10;
        $Pembelian = DetailPembelian::with(['jenisp', 'kasMasuk', 'karyawans', 'rekening'])
            ->orderBy('id_pengeluaran', 'desc');

        // Apply date filter
        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = Carbon::parse($request->query('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->query('end_date'))->endOfDay();

            $Pembelian->whereBetween('created_at', [$start_date, $end_date]);
        }

        $Pembelian = $Pembelian->paginate($perPage);

        $groupedPembelian = $Pembelian->sortByDesc('id_pengeluaran')->groupBy('id_pengeluaran');

        $totals = $groupedPembelian->map(function ($group) {
            return $group->sum('total');
        });

        $latestExpense = DetailPembelian::orderBy('id', 'desc')->first();
        $nomorPembelian = $latestExpense ? sprintf('%03d', intval($latestExpense->id_pengeluaran) + 1) : '001';

        return view('pembelian.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Pembelian',
            'breadcrumb' => 'Pembelian',
            'name_user' => $user->name,
            'groupedPembelians' => $groupedPembelian,
            'datas' => $Pembelian,
            'totals' => $totals,
            'nomorPembelian' => $nomorPembelian
        ]);
    }

    public function tambahPembelian()
    {
        $user = Auth::user();
        return view('pembelian.tambah', [
            'title' => 'Pembelian',
            'breadcrumb' => 'Pembelian',
            'name_user' => $user->name,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePembelianRequest $request)
    {
        $user = Auth::user();
        $pembelianTerakhir = DetailPembelian::where('id', $request->id)->latest('id')->first();

        if ($pembelianTerakhir) {
            $idBaru = $pembelianTerakhir->id_generate;
        } else {
            $lastIdGenerate = DetailPembelian::latest('id_generate')->first();

            if ($lastIdGenerate) {
                $lastIdNumber = substr($lastIdGenerate->id_generate, 2);
                $newIdNumber = str_pad((int)$lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
                $idBaru = 'PB-' . $newIdNumber;
            } else {
                $idBaru = 'PB-001';
            }
        }

        $data = $request->all();
        dd($request->all());
        foreach ($data['nopembelian'] as $key => $value) {

            // Cek saldo kas masuk
            $saldoBank = KasMasuk::where('bank', '1')->sum('pemasukan') - KasMasuk::where('bank', '1')->sum('pengeluaran');
            $saldoTunai = KasMasuk::where('bank', '888')->sum('pemasukan') - KasMasuk::where('bank', '888')->sum('pengeluaran');

            if ($saldoBank && $saldoBank < str_replace('.', '', $data['total'][$key])) {
                return redirect('pengeluaran')->with('error', 'Saldo Kas Bank Tidak Cukup!');
            } else if ($saldoTunai && $saldoTunai < str_replace('.', '', $data['total'][$key])) {
                return redirect('pengeluaran')->with('error', 'Saldo Kas Tunai Tidak Cukup!');
            }

            DetailPembelian::create([
                'id_pembelian_generate' => $value,
                'id_generate' => $idBaru,
                'id_supplier' => $data['supplier'][$key],
                'id_jenis' => $data['jenis'][$key],
                'id_bahan' => $data['bahan'][$key],
                'id_bank' => $data['metode'],
                'keterangan' => $data['keterangan'][$key],
                'jumlah' => $data['jumlah'][$key],
                'satuan' => $data['satuan'][$key],
                'total' => str_replace('.', '', $data['nominal'][$key]),
            ]);
        }

        // Buat data kas masuk
        $kasMasuk = new KasMasuk;
        $kasMasuk->id_generate = $idBaru;
        $kasMasuk->keterangan = "Pengeluaran Dari - No #" . $value . ($data['metode'] === 'tunai' ? ' (Tunai) ' : ' - Metode Bank ');
        $kasMasuk->name_kasir = $user->name;
        $kasMasuk->pengeluaran = str_replace('.', '', $data['nominal'][$key]);
        $kasMasuk->bank = $data['metode'];
        $kasMasuk->save();
        return redirect('pembelian')->with('success', 'Data Berhasil Ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id_pembelian)
    {
        $user = Auth::user();
        $pembelian = Pembelian::findOrFail($id_pembelian);

        return view('pembelian.edit', [
            'title' => 'Edit Pembelian',
            'breadcrumb' => 'Pembelian',
            'name_user' => $user->name,
        ])->with([
            'txtid' => $id_pembelian,
            'txtbahan' => $pembelian->bahan,
            'txtjenis' => $pembelian->jenis,
            'txtsatuan' => $pembelian->satuan,
            'txtjumlah' => $pembelian->jumlah,
            'txttotal' => $pembelian->total,
            'txtdp' => $pembelian->uang_muka,
            'txtsisa' => $pembelian->sisa_pembayaran,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePembelianRequest $request, $id_pembelian)
    {
        $data = Pembelian::findOrFail($id_pembelian);
        $data->id_pembelian = $request->txtid;
        $data->bahan = $request->txtbahan;
        $data->jenis = $request->txtjenis;
        $data->jumlah = $request->txtjumlah;
        $data->satuan = $request->txtsatuan;
        $data->total = $request->txttotal;
        $data->uang_muka = $request->txtdp;
        $data->sisa_pembayaran = $request->txtsisa;
        $data->save();

        $kasMasuk = KasMasuk::where('id_generate', $data->id_generate)->first();
        if ($kasMasuk) {
            $kasMasuk->update([
                'pengeluaran' => $data->total,
                'keterangan' => $data->bahan,
            ]);
        }

        return redirect('pembelian')->with('msg', 'Data Berhasil Di-update!');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_generate)
    {
        $datas = Pembelian::findOrFail($id_generate);
        $kasMasuk = KasMasuk::where('id_generate', $datas->id_generate)->get();
        $datas->delete();

        foreach ($kasMasuk as $kas) {
            $kas->delete();
        }
        return redirect('pembelian')->with('msg', 'Data Berhasil Di-hapus!');
    }


    public function printFaktur($id_pembelian)
    {
        $pembelian = Pembelian::findOrFail($id_pembelian);

        // $print = PDF::loadView('pembelian.print_faktur');
        $print = PDF::loadView('pembelian.print_faktur', compact('pembelian'));

        return $print->download($pembelian->id_pembelian . '' . 'faktur-pembelian.pdf');
    }
}
