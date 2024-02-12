<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\DetailPembelian;
use App\Models\JenisBahan;
use App\Models\JenisPengeluaran;
use App\Models\KasMasuk;
use App\Models\Pengeluaran;
use App\Models\Rekening;
use App\Models\Satuan;
use App\Models\setting;
use App\Models\StokMasuk;
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
        $Pembelian = DetailPembelian::with(['bahans', 'suppliers', 'jenisP', 'users'])
            ->orderBy('id', 'desc');
        $bank = Rekening::select('id', 'no_rekening', 'atas_nama', 'bank')->get();
        $satuan = Satuan::all();

        // Apply date filter
        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = Carbon::parse($request->query('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->query('end_date'))->endOfDay();

            $Pembelian->whereBetween('created_at', [$start_date, $end_date]);
        }

        // Apply type (Jenis) filter
        if ($request->has('jenis')) {
            $Pembelian->whereHas('jenisP', function ($query) use ($request) {
                $query->where('id_jenis', $request->input('jenis'));
            });
        }

        // Apply user (pencatat) filter
        if ($request->has('pencatat')) {
            $Pembelian->whereHas('users', function ($query) use ($request) {
                $query->where('id', $request->input('pencatat'));
            });
        }

        // Apply search filter
        if ($request->has('search')) {
            $Pembelian->where('keterangan', 'like', '%' . $request->input('search') . '%');
        }


        $Pembelian = $Pembelian->paginate($perPage);

        $groupedPembelian = $Pembelian->sortByDesc('id')->groupBy('id_pembelian_generate');

        $subtotals = $groupedPembelian->map(function ($group) {
            return $group->sum('total');
        });

        $totalPembelian = $groupedPembelian->map(function ($group) {
            return $group->sum('subtotal');
        });



        $latestExpense = DetailPembelian::orderBy('id', 'desc')->first();
        $nomorPembelian = $latestExpense ? sprintf('%03d', intval($latestExpense->id) + 1) : '001';

        $formattedPengeluarans = $Pembelian->map(function ($pembelian) {
            $pembelian->formatted_date = Carbon::parse($pembelian->created_at)->isoFormat('dddd, DD/MM/YYYY');
            return $pembelian;
        });
        // dd($groupedPembelian);


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
            'bank' => $bank,
            'satuan' => $satuan,
            'totalPembelian' => $totalPembelian,
            'perPageOptions' => [10, 15, 25, 100],
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

    public function limit(Request $request)
    {
        return $this->index($request);
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
            // Melakukan pengecekan stok pada tabel jenisbahan
            $jenisBahan = JenisBahan::find($data['id_bahan'][$key]);

            if ($jenisBahan && $jenisBahan->stok === 'Y') {
                // Stok tersedia, proses pembelian
                // Cek saldo kas masuk
                $id_bank = $request->input('id_bank');
                $caraBayar = $request->input('caraBayar');

                if ($caraBayar === 'tunai') {
                    $saldoTunai = KasMasuk::where('bank', '888')->sum('pemasukan') - KasMasuk::where('bank', '888')->sum('pengeluaran');
                    $saldo = $saldoTunai;
                    $namaMetode = 'Kas Penjualan';
                } elseif ($caraBayar === 'transfer') {
                    $saldoBank = KasMasuk::where('bank', $id_bank[0])->sum('pemasukan') - KasMasuk::where('bank', $id_bank[0])->sum('pengeluaran');
                    $saldo = $saldoBank;
                    $namaMetode = 'Kas Bank';
                } else {
                    // Metode pembayaran tidak dikenali
                    $saldo = 0;
                    $namaMetode = 'Metode Pembayaran Tidak Dikenali';
                }

                $subtotal = str_replace('.', '', $data['totalpembelian'][$key]);

                if ($saldo <= 0 || $saldo < $subtotal) {
                    $errors[] = 'Saldo ' . $namaMetode . ' Tidak Cukup!';
                } else {
                    // Cari stok masuk dengan id_bahan dan id_generate yang sama
                    $existingStokMasuk = StokMasuk::where('id_bahan', $data['id_bahan'][$key])
                        ->first();

                    if ($existingStokMasuk) {
                        // Update jumlah jika stok masuk dengan id_bahan dan id_generate yang sama sudah ada
                        $existingStokMasuk->jumlah += $data['jumlah'][$key];
                        $existingStokMasuk->save();
                    } else {
                        // Buat stok masuk baru
                        $stokMasuk = new StokMasuk;
                        $stokMasuk->id_generate = $data['id_generate'][$key];
                        $stokMasuk->id_bahan = $data['id_bahan'][$key];
                        $stokMasuk->jumlah = $data['jumlah'][$key];
                        $stokMasuk->keterangan = $data['keterangan'][$key];
                        $stokMasuk->save();
                    }

                    // Menambahkan data ke tabel kasmasuk
                    $kasMasuk = new KasMasuk;
                    $kasMasuk->id_generate = $data['id_generate'][$key];
                    $kasMasuk->keterangan = "Pengeluaran Dari - No #" . $value . ($caraBayar === 'tunai' ? ' (Tunai) ' : ' - Metode Bank');
                    $kasMasuk->name_kasir = $user->name;
                    $kasMasuk->pengeluaran = str_replace('.', '', $data['totalpembelian']);
                    $kasMasuk->bank = $id_bank[0];
                    $kasMasuk->save();

                    // Menambahkan data ke tabel detailpembelian
                    $detailPembelian = new DetailPembelian;
                    $detailPembelian->id_pembelian_generate = $data['nopembelian'][$key];
                    $detailPembelian->id_generate = $data['id_generate'][$key];
                    $detailPembelian->id_supplier = $data['id_supplier'][$key];
                    $detailPembelian->id_jenis = $data['id_jenis'][$key];
                    $detailPembelian->id_bank = $id_bank[0];
                    $detailPembelian->id_bahan = $data['id_bahan'][$key];
                    $detailPembelian->keterangan = $data['keterangan'][$key];
                    $detailPembelian->jumlah = $data['jumlah'][$key];
                    $detailPembelian->satuan = $data['satuan'][$key];
                    $detailPembelian->total = str_replace('.', '', $data['nominal'][$key]);
                    $detailPembelian->subtotal = str_replace('.', '', $data['totalpembelian']);
                    $detailPembelian->id_user = $user->id;
                    $detailPembelian->save();
                }
            } else {
                // Stok tidak aktif, proses tidak dilanjutkan
                $errors[] = 'Bahan ini tidak tersedia untuk di stok';
            }

            $processIdGenerate[] = ['id_generate' => $data['id_generate'][$key], 'nopembelian' => $value];
        }

        if (!empty($errors)) {
            // Redirect dengan pesan kesalahan
            return redirect('pembelian')->with('error', implode($errors));
        }

        // Redirect dengan pesan sukses
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

        foreach ($datas as $kas) {
            $kasMasuk = KasMasuk::where('id_generate', $kas->id_generate)->get();
            $kas->delete();

            foreach ($kasMasuk as $kas) {
                $kas->delete();
            }
        }
        foreach ($datas as $s) {
            $stok = StokMasuk::where('id_generate', $s->id_generate)->get();
            $s->delete();

            foreach ($stok as $s) {
                $s->delete();
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



    public function printPembelian(Request $request)
    {
        $pembelianQuery = DetailPembelian::with(['bahans', 'suppliers', 'jenisP', 'users'])
            ->orderBy('id', 'desc');

        // Initialize start_date and end_date
        $start_date = null;
        $end_date = null;

        // Apply date filter
        if ($request->filled('daterange')) {
            [$start_date, $end_date] = explode(' - ', $request->input('daterange'));

            $start_date = Carbon::createFromFormat('m/d/Y', $start_date)->startOfDay();
            $end_date = Carbon::createFromFormat('m/d/Y', $end_date)->endOfDay();

            $pembelianQuery->whereBetween('created_at', [$start_date, $end_date]);
        }

        // Apply type (Jenis) filter
        if ($request->filled('jenis')) {
            $pembelianQuery->whereHas('jenisP', function ($query) use ($request) {
                $query->where('id_jenis', $request->input('jenis'));
            });
        }

        // Apply user (pencatat) filter
        if ($request->filled('pencatat')) {
            $pembelianQuery->whereHas('users', function ($query) use ($request) {
                $query->where('id', $request->input('pencatat'));
            });
        }

        // Apply search filter
        if ($request->filled('search')) {
            $pembelianQuery->where('keterangan', 'like', '%' . $request->input('search') . '%');
        }

        $pembelian = $pembelianQuery->get();
        $user = Auth::user();
        $total = DetailPembelian::select('subtotal')->sum('subtotal');
        $setting = Setting::first();

        return view('pembelian.print', [
            'pembelian' => $pembelian,
            'total' => $total,
            'info' => $setting,
            'name_user' => $user->name,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}
