<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Http\Requests\StorePengeluaranRequest;
use App\Http\Requests\UpdatePengeluaranRequest;
use App\Models\DetailPengeluaran;
use App\Models\GajiKaryawanV2;
use App\Models\JenisPengeluaran;
use App\Models\Jurnal;
use App\Models\Karyawan;
use App\Models\Kasbon;
use App\Models\KasMasuk;
use App\Models\Pengguna;
use App\Models\Rekening;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;


class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = 10;
        $pengeluarans = Pengeluaran::with(['jenisp', 'kasMasuk', 'karyawans', 'rekening'])
            ->orderBy('id_pengeluaran', 'desc');

        // Apply date filter
        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = Carbon::parse($request->query('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->query('end_date'))->endOfDay();

            $pengeluarans->whereBetween('created_at', [$start_date, $end_date]);
        }

        $pengeluarans = $pengeluarans->paginate($perPage);

        $groupedPengeluarans = $pengeluarans->sortByDesc('id_pengeluaran')->groupBy('id_pengeluaran');

        $totals = $groupedPengeluarans->map(function ($group) {
            return $group->sum('total');
        });

        $formattedPengeluarans = $pengeluarans->map(function ($pengeluaran) {
            $pengeluaran->formatted_date = Carbon::parse($pengeluaran->created_at)->isoFormat('dddd, DD/MM/YYYY');
            return $pengeluaran;
        });

        $latestExpense = Pengeluaran::orderBy('id_pengeluaran', 'desc')->first();
        $nomorP = $latestExpense ? sprintf('%03d', intval($latestExpense->id_pengeluaran) + 1) : '001';

        $bank = Rekening::all();
        $dataJenis = JenisPengeluaran::where('aktif', 1)->get();
        $dataKaryawan = Karyawan::all();


        return view('pengeluaran.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Pengeluaran',
            'breadcrumb' => 'Pengeluaran',
            'name_user' => $user->name,
            'groupedPengeluarans' => $groupedPengeluarans,
            'totals' => $totals,
            'formattedPengeluarans' => $formattedPengeluarans,
            'bank' => $bank,
            'dataJenis' => $dataJenis,
            'dataKaryawan' => $dataKaryawan,
            'datas' => $pengeluarans,
            'nomorP' => $nomorP,
        ]);
    }

    public function cariData(Request $request)
    {
        return $this->index($request);
    }

    public function tambahPengeluaran()
    {
        $user = Auth::user();
        $idSebelumnya = DB::table('pengeluarans')->max('id_pengeluaran');
        $nomorSelanjutnya = $idSebelumnya + 1;
        return view('pengeluaran.tambah', [
            'title' => 'Pengeluaran',
            'breadcrumb' => 'Pengeluaran',
            'name_user' => $user->name,
            'nomorSelanjutnya' => $nomorSelanjutnya,
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
    public function store(StorePengeluaranRequest $request)
    {
        // $validate = $request->validated();
        $user = Auth::user();
        $pengeluaranTerakhir = Pengeluaran::where('id_pengeluaran', $request->txtid)->latest('id_pengeluaran')->first();

        if ($pengeluaranTerakhir) {
            $idBaru = $pengeluaranTerakhir->id_generate;
        } else {
            $lastIdGenerate = Pengeluaran::latest('id_generate')->first();

            if ($lastIdGenerate) {
                $lastIdNumber = substr($lastIdGenerate->id_generate, 2);
                $newIdNumber = str_pad((int)$lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
                $idBaru = 'K-' . $newIdNumber;
            } else {
                $idBaru = 'K-001';
            }
        }

        $data = $request->all();
        // dd($data);
        foreach ($data['nopengeluaran'] as $key => $value) {

            $karyawanId = isset($data['karyawan'][$key]) ? $data['karyawan'][$key] : null;

            $metodePembayaran = $data['metode'];

            // Pisah id_akun dan id_jenis
            $jenisPengeluaran = $data['jenispengeluaran'][$key];
            list($id_akun, $id_jenis) = explode(" || ", $jenisPengeluaran);

            // Cek saldo kas masuk
            if ($metodePembayaran == '1') {
                $saldo = KasMasuk::where('bank', '1')->sum('pemasukan') - KasMasuk::where('bank', '1')->sum('pengeluaran');
                $namaMetode = 'Kas Bank';
            } else if ($metodePembayaran == '2') {
                $saldo = KasMasuk::where('bank', '2')->sum('pemasukan') - KasMasuk::where('bank', '2')->sum('pengeluaran');
                $namaMetode = 'Kas Bank';
            } else if ($metodePembayaran == '3') {
                $saldo = KasMasuk::where('bank', '3')->sum('pemasukan') - KasMasuk::where('bank', '3')->sum('pengeluaran');
                $namaMetode = 'Kas Bank';
            } elseif ($metodePembayaran == '888') {
                $saldo = KasMasuk::where('bank', '888')->sum('pemasukan') - KasMasuk::where('bank', '888')->sum('pengeluaran');
                $namaMetode = 'Kas Penjualan';
            } else {
                $saldo = 0;
                $namaMetode = 'Metode Tidak Dikenali';
            }

            if ($saldo < str_replace('.', '', $data['total'][$key])) {
                return redirect('pengeluaran')->with('error', 'Saldo ' . $namaMetode . ' Tidak Cukup!');
            }

            Pengeluaran::create([
                'id_pengeluaran' => $value,
                'id_generate' => $idBaru,
                'keterangan' => $data['keterangan'][$key],
                'jumlah' => $data['jumlah'][$key],
                'harga' => str_replace('.', '', $data['harga'][$key]),
                'total' => str_replace('.', '', $data['total'][$key]),
                'subtotal' => str_replace('.', '', $data['subtotal']),
                'id_jenis' => $id_jenis,
                'id_karyawan' => $karyawanId,
                'id_bank' => $data['metode'],
            ]);


            // Buat data kas bon
            $kasBon = new Kasbon;

            $karyawanId = isset($data['karyawan'][$key]) ? $data['karyawan'][$key] : null;
            $nominal = str_replace('.', '', $data['total'][$key]) ? str_replace('.', '', $data['total'][$key]) : 0;
            if ($karyawanId !== null && $nominal !== null) {
                $kasBon->id_karyawan = $karyawanId;
                $kasBon->nominal = $nominal;
                $kasBon->id_pengeluaran = $value;
                $kasBon->save();
            }
        }

        // Buat data kas masuk
        $kasMasuk = new KasMasuk;
        $kasMasuk->id_generate = $idBaru;
        $kasMasuk->keterangan = "Pengeluaran Dari - No #" . $value . ($data['metode'] === 'tunai' ? ' (Tunai) ' : ' - Metode Bank ');
        $kasMasuk->name_kasir = $user->name;
        $kasMasuk->pengeluaran = str_replace('.', '', $data['subtotal']);
        $kasMasuk->bank = $data['metode'];
        $kasMasuk->save();

        // Buat Data Jurnal
        $jurnal1 = new Jurnal;
        $jurnal1->no_reff = $id_akun;
        $jurnal1->id_user = $user->id;
        $jurnal1->tipe = 'debit';
        $jurnal1->nominal = str_replace('.', '', $data['subtotal']);
        $jurnal1->keterangan = 'Pengeluaran dari No# ' . $value;
        $jurnal1->save();


        $jurnal2 = new Jurnal;
        if ($data['metode'] === '888') {
            $jurnal2->no_reff = '110'; // ID Akun untuk kas
        } else {
            $jurnal2->no_reff = '111'; // ID Akun untuk bank
        }
        $jurnal2->id_user = $user->id;
        $jurnal2->tipe = 'kredit';
        $jurnal2->nominal = str_replace('.', '', $data['subtotal']);
        $jurnal2->keterangan = 'Pengeluaran dari No# ' . $value;
        $jurnal2->save();

        return redirect('pengeluaran')->with('success', 'Data Berhasil Ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePengeluaranRequest $request, Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $kasMasuk = KasMasuk::where('id_generate', $pengeluaran->id_generate)->get();
        $kasBon = Kasbon::where('id_pengeluaran', $pengeluaran->id_pengeluaran)->get();
        $pengeluaran->delete();

        foreach ($kasMasuk as $kas) {
            $kas->delete();
        }
        foreach ($kasBon as $bon) {
            $bon->delete();
        }

        return redirect('pengeluaran')->with('success', 'Data Berhasil Dihapus!');
    }

    public function printInvoice($id_pengeluaran)
    {
        $cetaks = Pengeluaran::findOrFail($id_pengeluaran);

        $pengeluarans = Pengeluaran::where('id_pengeluaran', $id_pengeluaran)
            ->with(['jenisp', 'kasMasuk', 'karyawans', 'rekening'])
            ->orderBy('id_pengeluaran', 'desc')
            ->get();

        $groupedPengeluarans = $pengeluarans->sortByDesc('id_pengeluaran')->groupBy('id_pengeluaran');

        $totals = $groupedPengeluarans->map(function ($group) {
            return $group->sum('total');
        });

        // dd($groupedPengeluarans);

        // return view('pengeluaran.cetak', [
        //     'cetaks' => $cetaks,
        //     'groupedPengeluarans' => $groupedPengeluarans,
        //     'totals' => $totals,
        // ]);


        $pdf = PDF::loadView('pengeluaran.cetak', [
            'cetaks' => $cetaks,
            'groupedPengeluarans' => $groupedPengeluarans,
            'totals' => $totals,
        ]);

        return $pdf->download($cetaks->id_pengeluaran . ' laporanPengeluaran.pdf');
    }


    public function printPengeluaran()
    {
        $user = Auth::user();
        $datas = Pengeluaran::with(['jenisp', 'kasMasuk', 'karyawans', 'rekening'])
            ->get();
        $total = Pengeluaran::select('total')->sum('total');
        $setting = Setting::all()->first();

        if ($datas->isEmpty()) {
            return redirect()->back()->with('error', 'Data Tidak Ditemukan!');
        } else {
            return view('pengeluaran.print', [
                'title' => 'Cetak Pengeluaran',
                'datas' => $datas,
                'name_user' => $user->name,
                'breadcrumb' => 'Pengeluaran',
                'total' => $total,
                'info' => $setting
            ]);
        }
        // dd($datas);

        // $pdf = PDF::loadView('pengeluaran.print', [
        //     'title' => 'Cetak Pengeluaran',
        //     'datas' => $datas,
        //     'name_user' => $user->name,
        //     'breadcrumb' => 'Pengeluaran',
        //     'total' => $total,
        //     'info' => $setting

        // ]);

        // return $pdf->download('Rekap_Pengeluaran.pdf');

        return view('pengeluaran.print', [
            'title' => 'Cetak Pengeluaran',
            'datas' => $datas,
            'name_user' => $user->name,
            'breadcrumb' => 'Pengeluaran',
            'total' => $total,
            'info' => $setting
        ]);
    }
}
