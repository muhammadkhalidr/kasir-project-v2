<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\DetailPembelian;
use App\Models\JenisBahan;
use App\Models\JenisPengeluaran;
use App\Models\KasMasuk;
use App\Models\Rekening;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $Pembelian = DetailPembelian::with(['bahans', 'suppliers', 'jenisP'])
            ->orderBy('id', 'desc');
        $bank = Rekening::select('id', 'no_rekening', 'atas_nama', 'bank')->get();

        // Apply date filter
        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = Carbon::parse($request->query('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->query('end_date'))->endOfDay();

            $Pembelian->whereBetween('created_at', [$start_date, $end_date]);
        }

        $Pembelian = $Pembelian->paginate($perPage);
        // dd($Pembelian);
        $groupedPembelian = $Pembelian->sortByDesc('id')->groupBy('id_pembelian_generate');

        $subtotals = $groupedPembelian->map(function ($group) {
            return $group->sum('subtotal');
        });

        $latestExpense = DetailPembelian::orderBy('id', 'desc')->first();
        $nomorPembelian = $latestExpense ? sprintf('%03d', intval($latestExpense->id) + 1) : '001';

        $formattedPengeluarans = $Pembelian->map(function ($pembelian) {
            $pembelian->formatted_date = Carbon::parse($pembelian->created_at)->isoFormat('dddd, DD/MM/YYYY');
            return $pembelian;
        });


        $pembelianTerakhir = DetailPembelian::where('id', $request->id)->latest('id')->first();

        if ($pembelianTerakhir) {
            $idGeneratePembelian = $pembelianTerakhir->id_generate;
        } else {
            $lastIdGenerate = DetailPembelian::latest('id_generate')->first();

            if ($lastIdGenerate) {
                $lastIdNumber = substr($lastIdGenerate->id_generate, 2);
                $newIdNumber = str_pad((int)$lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
                $idGeneratePembelian = 'P-' . $newIdNumber;
            } else {
                $idGeneratePembelian = 'P-001';
            }
        }

        return view('pembelian.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Pembelian',
            'breadcrumb' => 'Pembelian',
            'name_user' => $user->name,
            'id_user' => $user->id,
            'groupedPembelians' => $groupedPembelian,
            'datas' => $Pembelian,
            'subtotals' => $subtotals,
            'nomorPembelian' => $nomorPembelian,
            'idgenerate' => $idGeneratePembelian,
            'bank' => $bank
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

    // public function cariBahanAjax()
    // {
    //     $bahan = JenisBahan::select('id', 'bahan', 'id_kategori')->where("status", "Y")->get();
    //     $data = [];

    //     foreach ($bahan as $item) {
    //         $data[] = $item->bahan;
    //     }

    //     if (empty($data)) {
    //         $data[] = "Tidak Ada Data Bahan";
    //     }

    //     return $data;
    // }

    public function cariBahanAjax()
    {
        $bahan = JenisBahan::select('id', 'bahan', 'id_kategori')->where("status", "Y")->get();
        $data = [];

        foreach ($bahan as $item) {
            $data[] = [
                'id' => $item->id,
                'label' => $item->bahan,
                'id_bahan' => $item->id, // Tambahkan id_bahan
            ];
        }

        if (empty($data)) {
            $data[] = [
                'id' => null,
                'label' => "Tidak Ada Data Bahan",
                'id_bahan' => null,
            ];
        }

        return $data;
    }

    public function cariJenisPengeluaranAjax()
    {
        $jenisPengeluaran = JenisPengeluaran::select('id', 'nama_jenis')->where("aktif", "1")->get();
        $data = [];

        foreach ($jenisPengeluaran as $item) {
            $data[] = [
                'id' => $item->id,
                'label' => $item->nama_jenis,
                'id_jenis_pengeluaran' => $item->id,
            ];
        }

        if (empty($data)) {
            $data[] = [
                'id' => null,
                'label' => "Tidak Ada Data Jenis Pengeluaran",
                'id_jenis_pengeluaran' => null,
            ];
        }

        return $data;
    }
    public function cariSupplier()
    {
        $supplier = Supplier::select('id', 'nama')->where("status", "Y")->get();
        $data = [];

        foreach ($supplier as $item) {
            $data[] = [
                'id' => $item->id,
                'label' => $item->nama,
                'id_supplier' => $item->id,
            ];
        }

        if (empty($data)) {
            $data[] = [
                'id' => null,
                'label' => "Tidak Ada Data Supplier",
                'id_supplier' => null,
            ];
        }

        return $data;
    }



    public function getDataBahan(Request $request)
    {
        try {
            $judul = $request->input('judul');
            $jenisPengeluaran = JenisPengeluaran::where("nama_jenis", $judul)->first();

            return response()->json($jenisPengeluaran);
        } catch (\Exception $e) {
            Log::error('Error in Data Bahan: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getDataJenisPengeluaran(Request $request)
    {
        try {
            $judul = $request->input('judul');
            $jenisPengeluaran = JenisPengeluaran::where("nama_jenis", $judul)->first();

            return response()->json($jenisPengeluaran);
        } catch (\Exception $e) {
            Log::error('Error in Data Bahan: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getSupplier(Request $request)
    {
        try {
            $judul = $request->input('judul');
            $supplier = Supplier::where("nama", $judul)->first();

            return response()->json($supplier);
        } catch (\Exception $e) {
            Log::error('Error in Data Supplier: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getSaldo($id)
    {
        // $saldo = DB::table('kas_masuk')->where('id', $id)->first()->saldo;
        $saldo = KasMasuk::where('bank', $id)->first()->pemasukan;
        return response()->json(['saldo' => $saldo]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePembelianRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $errors = [];
        $processIdGenerate = [];

        foreach ($data['nopembelian'] as $key => $value) {

            // Cek saldo kas masuk
            $saldoBank = KasMasuk::where('bank', '1')->sum('pemasukan') - KasMasuk::where('bank', '1')->sum('pengeluaran');
            $saldoTunai = KasMasuk::where('bank', '888')->sum('pemasukan') - KasMasuk::where('bank', '888')->sum('pengeluaran');

            $subtotal = str_replace('.', '', $data['totalpembelian'][$key]);

            if ($saldoBank <= 0 || $saldoBank < $subtotal) {
                $errors[] = 'Saldo Kas Bank Tidak Cukup!';
            } else if ($saldoTunai <= 0 || $saldoTunai < $subtotal) {
                $errors[] = 'Saldo Kas Tunai Tidak Cukup!';
            } else {
                $detailPembelian = new DetailPembelian;
                $detailPembelian->id_pembelian_generate = $data['nopembelian'][$key];
                $detailPembelian->id_generate = $data['id_generate'][$key];
                $detailPembelian->id_supplier = $data['id_supplier'][$key];
                $detailPembelian->id_jenis = $data['id_jenis'][$key];
                $detailPembelian->id_bahan = $data['id_bahan'][$key];
                $detailPembelian->keterangan = $data['keterangan'][$key];
                $detailPembelian->jumlah = $data['jumlah'][$key];
                $detailPembelian->satuan = $data['satuan'][$key];
                $detailPembelian->total = str_replace('.', '', $data['nominal'][$key]);
                $detailPembelian->subtotal = $subtotal;
                $detailPembelian->id_user = $user->id;
                $detailPembelian->save();

                $kasMasuk = new KasMasuk;
                $kasMasuk->id_generate = $data['id_generate'][$key];
                $kasMasuk->keterangan = "Pengeluaran Dari - No #" . $value . ($data['metode'] === 'tunai' ? ' (Tunai) ' : ' - Metode Bank ');
                $kasMasuk->name_kasir = $user->name;
                $kasMasuk->pengeluaran = str_replace('.', '', $data['totalpembelian']);
                $kasMasuk->bank = $data['metode'];
                $kasMasuk->save();
            }

            $processIdGenerate[] = ['id_generate' => $data['id_generate'][$key], 'nopembelian' => $value];
        }

        if (!empty($errors)) {
            // Redirect with errors
            return redirect('pembelian')->with('error', implode($errors));
        }

        // Redirect with success message
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
    public function update(UpdatePembelianRequest $request)
    {
        // 
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pembelian_generate)
    {
        $datas = DetailPembelian::where('id_pembelian_generate', $id_pembelian_generate)->get();

        foreach ($datas as $data) {
            $kasMasuk = KasMasuk::where('id_generate', $data->id_generate)->get();
            $data->delete();

            foreach ($kasMasuk as $kas) {
                $kas->delete();
            }
        }

        return redirect('pembelian')->with('success', 'Data Berhasil Di-hapus!');
    }


    public function printFaktur($id_pembelian)
    {
        $pembelian = Pembelian::findOrFail($id_pembelian);

        // $print = PDF::loadView('pembelian.print_faktur');
        $print = PDF::loadView('pembelian.print_faktur', compact('pembelian'));

        return $print->download($pembelian->id_pembelian . '' . 'faktur-pembelian.pdf');
    }
}
