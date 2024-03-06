<?php

namespace App\Http\Controllers;

use App\Models\Orderan;
use App\Http\Requests\UpdateOrderanRequest;
use App\Models\DetailOrderan;
use App\Models\JenisBahan;
use App\Models\Jurnal;
use App\Models\KasMasuk;
use App\Models\OmsetPenjualan;
use App\Models\Pelanggan;
use App\Models\PelunasanOrderan;
use App\Models\Produk;
use App\Models\Rekening;
use App\Models\Satuan;
use App\Models\setting;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $dataOrderan = DetailOrderan::with(['pelanggans', 'produks', 'bahans']);
        $kode_pelanggan = "";
        $dataPelanggan = Pelanggan::select('kode_pelanggan', 'nama')->get();
        $pelanggans = Pelanggan::all();
        $rekening = Rekening::all();
        $noTrx = DetailOrderan::latest('id')->first();

        $dataKasir = DetailOrderan::select('name_kasir')->where('notrx', $noTrx)->get();
        $dataPelunasan = PelunasanOrderan::all();
        $jamTransaksi = Setting::select('darijam', 'sampaijam')->first();
        $satuan = Satuan::latest()->get();

        // Apply date filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->input('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->input('end_date'))->endOfDay();

            $dataOrderan->whereBetween('created_at', [$start_date, $end_date]);
        }

        // Search Data
        $search = $request->input('searchdata');
        if ($search) {
            $dataOrderan->where(function ($query) use ($search) {
                $query->where('notrx', 'like', '%' . $search . '%')
                    ->orWhereHas('pelanggans', function ($subQuery) use ($search) {
                        $subQuery->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        $perPage = $request->input('dataOptions', 10);

        $dataOrderan = $dataOrderan
            ->select('id_transaksi', 'namabarang', 'keterangan', 'ukuran', 'bahan', 'satuan', 'subtotal', 'sisa', 'status', 'name_kasir', 'id_pelunasan', 'notrx', 'id_pelanggan', 'id_produk', 'id_bahan', 'jumlah', 'harga', 'total', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);


        if ($noTrx) {
            $idLama = $noTrx->notrx;
            $idNumber = (int)substr($idLama, 4);
            $idNumber++;
            $idBaru = 'TRX-' . str_pad($idNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $idBaru = 'TRX-001';
        }

        // AJAX
        $query = $request->get('query');
        if ($request->ajax()) {
            $data = Pelanggan::where('nama', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<ul class="list-group">';
                foreach ($data as $row) {
                    $output .= '<li class="list-group-item" style="cursor:pointer;" data-id="' . $row->id . '">' . $row->nama . '</li>';
                }
                $output .= '</ul>';
            } else {
                $output .= '<li class="list-group-item">' . 'Tidak ada data dengan nama ' . $query . '' . '</li>';
            }
            return $output;
        }

        $pelanggan = Pelanggan::where('nama', 'LIKE', '%' . $query . '%')
            ->simplePaginate(10);


        $dataBahan = JenisBahan::where('status', 'Y')->get();

        return view('orderan.data', [
            'title' => env('APP_NAME') . ' | ' . 'Data Orderan',
            'breadcrumb' => 'Data Orderan',
            'name_user' => $user->name,
            'dataOrderan' => $dataOrderan,
            'dataPelanggan' => $dataPelanggan,
            'kode_pelanggan' => $kode_pelanggan,
            'pelanggans' => $pelanggans,
            'rekening' => $rekening,
            'pelanggan' => $pelanggan,
            'notrx' => $idBaru,
            'pelunasan' => $dataPelunasan,
            'dataKasir' => $dataKasir,
            'jamTransaksi' => $jamTransaksi,
            'dataBahan' => $dataBahan,
            'satuan' => $satuan,
            'perPageOptions' => [10, 15, 25, 100, 500],

        ]);
    }

    public function searchProduct(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');

            $products = Produk::with('bahans')->where('judul', 'LIKE', '%' . $query . '%')->limit(10)->get();
            $id_products = Produk::with('bahans')->where('id', 'LIKE', '%' . $query . '%')->limit(10)->get();
            $id_bahan = Produk::with('bahans')->where('id_bahan', 'LIKE', '%' . $query . '%')->limit(10)->get();
            $bahans = Produk::with('bahans')->whereHas('bahans', function ($q) use ($query) {
                $q->where('bahan', 'LIKE', '%' . $query . '%');
            })->limit(10)->get();

            return view('partials.product_list', [
                'products' => $products,
                'id_products' => $id_products,
                'id_bahan' => $id_bahan,
                'bahans' => $bahans
            ])->render();
        }
    }


    public function getBahanByCategory($id_kategori)
    {
        $dataBahan = JenisBahan::with(['stokkeluars', 'stoks'])->where('id_kategori', $id_kategori)->get();

        return response()->json($dataBahan);
    }

    public function cariProdukAjax()
    {
        $produk = Produk::select('id', 'id_bahan', 'judul', 'harga_jual', 'ukuran', 'jumlah')->where("status", "Y")->get();
        $data = [];

        foreach ($produk as $item) {
            $data[] = $item->judul;
        }

        if (empty($data)) {
            $data[] = "Tidak Ada Data Produk";
        }

        return $data;
    }

    public function getDataProduk(Request $request)
    {
        try {
            $judul = $request->input('judul');
            $produk = Produk::with('bahans')->where("judul", $judul)->first();

            // Check if product exists
            if (!$produk) {
                return response()->json(['error' => 'Produk tidak ditemukan']);
            }

            // Check if bahan status is active
            if ($produk->bahans->stok === "Y") {
                // Check stok bahan
                $idBahan = $produk->id_bahan;
                $stokMasuk = StokMasuk::where('id_bahan', $idBahan)->sum('jumlah');
                $stokKeluar = StokKeluar::where('id_bahan', $idBahan)->sum('jumlah');
                $totalStok = $stokMasuk - $stokKeluar;

                if ($totalStok <= 0) {
                    return response()->json(['error' => 'Stok kosong']);
                }
            }

            return response()->json($produk);
        } catch (\Exception $e) {
            Log::error('Error in getDataProduk: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function cariData(Request $request)
    {
        return $this->index($request);
    }

    public function tambahOrderan()
    {
        $user = Auth::user();
        return view('orderan.tambah', [
            'title' => 'Tambah Orderan',
            'breadcrumb' => 'Orderan',
            'name_user' => $user->name,
        ]);
    }

    public function filterJumlah(Request $request)
    {
        return $this->index($request);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $errors = [];
        // Ambil nomor transaksi terbaru dari DetailOrderan
        $latestOrder = DetailOrderan::latest('id')->first();
        $latestTransactionId = ($latestOrder) ? $latestOrder->id_transaksi + 1 : 1;

        // Proses setiap item dalam pesanan
        foreach ($data['idpelanggan'] as $key => $value) {
            $status = ($data['sisa'] == 0) ? 'Lunas' : 'Belum Lunas';

            $idStokMasuk = StokMasuk::with(['bahans', 'stokkeluars'])
                ->whereHas('bahans', function ($query) use ($data, $key) {
                    $query->where('id', $data['idbahan'][$key]);
                })
                ->latest('id')
                ->first();

            // Tentukan nilai uang muka
            $uangMuka = !empty($data['uangmuka']) ? str_replace('.', '', $data['uangmuka']) : 0;

            // Tentukan nilai id pelanggan
            $idPelanggan = !empty($value) ? $value : 0;

            // Buat dan simpan objek DetailOrderan
            $detailOrder = DetailOrderan::create([
                'id_transaksi' => $latestTransactionId,
                'notrx' => $data['notrx'][$key],
                'id_pelanggan' => $idPelanggan,
                'namabarang' => $data['produk'][$key],
                'id_produk' => $data['idproduk'][$key],
                'id_bahan' => $data['idbahan'][$key],
                'keterangan' => $data['keterangan'][$key],
                'bahan' => $data['bahan'][$key],
                'satuan' => $data['satuan'][$key],
                'jumlah' => $data['jumlah'][$key],
                'ukuran' => $data['ukuran'][$key],
                'harga' => str_replace('.', '', $data['harga'][$key]),
                'total' => str_replace('.', '', $data['total'][$key]),
                'uangmuka' => $uangMuka,
                'subtotal' => str_replace('.', '', $data['subtotal']),
                'sisa' => str_replace('.', '', $data['sisa']),
                'status' => $status,
                'name_kasir' => $data['namakasir']
            ]);

            OmsetPenjualan::create([
                'notrx' => $data['notrx'][$key],
                'id_produk' => $data['idproduk'][$key],
                'produk' => $data['produk'][$key],
                'jumlah' => $data['jumlah'][$key],
                'total' => str_replace('.', '', $data['total'][$key]),

                PelunasanOrderan::create([
                    'notrx' => $data['notrx'][$key],
                    'total_bayar' => str_replace('.', '', $data['uangmuka']),
                    'bank' => $data['bayarDp'],
                    'via' => $data['bayarDp'],
                    'id_bayar' => $data['idpelanggan'][$key],
                ])
            ]);

            // Jika stok Y, tambahkan data ke tabel StokKeluar
            $jenisBahan = JenisBahan::find($data['idbahan'][$key]);
            if ($jenisBahan && $jenisBahan->stok === 'Y') {
                StokKeluar::create([
                    'id_stok_masuk' => $idStokMasuk->id,
                    'id_bahan' => $data['idbahan'][$key],
                    'notrx' => $data['notrx'][$key],
                    'jumlah' => $data['jumlah'][$key],
                ]);
            }

            // Tambahkan notrx ke dalam array processedNotrx
            $processedNotrx[] = $data['notrx'][$key];
        }

        // Buat dan simpan objek KasMasuk jika notrx belum ada dalam processedNotrx
        foreach ($processedNotrx as $notrx) {
            if (!KasMasuk::where('id_generate', $notrx)->exists()) {
                $kasMasuk = new KasMasuk;
                $kasMasuk->id_generate = $notrx;
                $kasMasuk->keterangan = "Pemasukan dari invoice# " . $notrx;
                $kasMasuk->name_kasir = $user->name;
                $kasMasuk->bank = $data['bayarDp'];

                // Tentukan nilai pemasukan berdasarkan kondisi
                if ($data['sisa'] == 0) {
                    $kasMasuk->pemasukan = str_replace('.', '', $data['subtotal']);
                } else {
                    $uangMuka = !empty($data['uangmuka']) ? str_replace('.', '', $data['uangmuka']) : 0;
                    $kasMasuk->pemasukan = $uangMuka;
                }

                $kasMasuk->save();
            }
        }

        // Buat dan simpan objek Jurnal 
        $jurnal = new Jurnal;
        $jurnal->no_reff = '110';
        $jurnal->id_user = $user->id;
        $jurnal->tipe = 'debit';
        $jurnal->nominal = str_replace('.', '', $data['subtotal']);
        $jurnal->keterangan = 'Kas Penjualan dari invoice# ' . $data['notrx'][0];
        $jurnal->save();

        $jurnal2 = new Jurnal;
        $jurnal2->no_reff = '451';
        $jurnal2->id_user = $user->id;
        $jurnal2->tipe = 'kredit';
        $jurnal2->nominal = str_replace('.', '', $data['subtotal']);
        $jurnal2->keterangan = 'Pendapatan dari invoice# ' . $data['notrx'][0];
        $jurnal2->save();

        // Redirect ke halaman orderan
        return redirect('orderan')->with('success', 'Data Berhasil Ditambahkan!');
    }


    public function omset(Request $request)
    {

        $user = Auth::user();

        // $subtotalPerProduk = DetailOrderan::join('produks', 'detail_orderans.id_produk', '=', 'produks.id')
        //     ->groupBy('detail_orderans.id_produk', 'produks.judul')
        //     ->select('detail_orderans.id_produk', 'produks.judul', DB::raw('SUM(subtotal) as subtotal'))
        //     ->get();

        $dataOmset = OmsetPenjualan::groupBy('id_produk', 'produk')
            ->select('id_produk', 'produk', DB::raw('SUM(total) as total'), DB::raw('SUM(jumlah) as jumlah'))
            ->paginate(10);


        // Apply date filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->input('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->input('end_date'))->endOfDay();

            $dataOmset->whereBetween('created_at', [$start_date, $end_date]);
        }

        return view('omset.data', [
            'title' => 'Omset Penjualan',
            'name_user' => $user->name,
            'omset' => $dataOmset
        ]);
    }

    public function tambahPelanggan(Request $request)
    {

        $pelanggan =  new Pelanggan;
        $pelanggan->kode_pelanggan = $request->kode;
        $pelanggan->nama = $request->nama;
        $pelanggan->nohp = $request->nohp;
        $pelanggan->alamat = $request->alamat;

        $pelanggan->save();

        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function pelunasan(Request $request)
    {

        $latestPelunasan = PelunasanOrderan::latest('id')->first();

        if ($latestPelunasan) {
            $id_pelunasan = $latestPelunasan->toArray();
            $id = $id_pelunasan['id'] + 1;
        } else {
            $id = 1;
        }


        // Ambil data dari form
        $via = $request->input('via');
        $jumlahBayar = str_replace('.', '', $request->input('jumlahBayar'));
        $totalBayar = str_replace('.', '', $request->input('totalBayar'));
        $caraBayar = $request->input('caraBayar');
        $buktiTransfer = $request->file('buktiTransfer');

        $bank = $caraBayar === '888' ? '888' : $via;

        // Simpan data pelunasan ke dalam tabel pelunasan_orderans
        $pelunasan = PelunasanOrderan::create([
            'notrx' => $request->input('notrx'),
            'total_bayar' => $jumlahBayar,
            'keterangan' => $request->input('note'),
            'bank' => $caraBayar === '888' ? '888' : $via,
            'via' => $via,
            'id_bayar' => auth()->user()->id,
        ]);

        $buktiTransfer = $request->file('buktiTransfer');

        if ($buktiTransfer && $buktiTransfer->isValid()) {
            $buktiFile = $request->file('buktiTransfer');
            $buktiName = $buktiFile->hashName();
            $buktiFile->move(public_path('assets/images/bukti_tf'), $buktiName);

            $pelunasan->bukti_transfer = $buktiName;
            $pelunasan->save();
        }

        // Update data di tabel detail_orderans
        DetailOrderan::where('notrx', $request->input('notrx'))
            ->update([
                'sisa' => max(0, floatval($totalBayar) - floatval($jumlahBayar)),
                'status' => $totalBayar == $jumlahBayar ? 'Lunas' : 'Belum Lunas',
                'id_pelunasan' => $id,
            ]);

        // Cek apakah pembayaran menggunakan tunai
        if ($caraBayar === 'tunai') {
            // Update data di tabel kas_masuk untuk DP (jika menggunakan tunai)
            KasMasuk::create([
                'id_generate' => $request->input('notrx'),
                'keterangan' => 'Pelunasan - No #' . $request->input('notrx'),
                'pemasukan' => $jumlahBayar,
                'name_kasir' => auth()->user()->name,
                'bank' => $caraBayar,
            ]);
        } else {
            // Update data di tabel kas_masuk untuk pelunasan
            KasMasuk::create([
                'id_generate' => $request->input('notrx'),
                'keterangan' => 'Pelunasan - No #' . $request->input('notrx'),
                'pemasukan' => $jumlahBayar,
                'name_kasir' => auth()->user()->name,
                'bank' => $bank,
            ]);
        }

        return redirect()->back()->with('success', 'Pelunasan berhasil.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id_keuangan)
    {
        $user = Auth::user();
        $orderan = Orderan::findOrFail($id_keuangan);

        return view('orderan.edit', data: [
            'title' => 'Edit Orderan',
            'breadcrumb' => 'Data Orderan',
            'user' => $user,
        ])->with([
            'txtid' => $id_keuangan,
            'txtnama' => $orderan->nama_pemesan,
            'txtbarang' => $orderan->nama_barang,
            'txtharga' => $orderan->harga_barang,
            'txtjumlah' => $orderan->jumlah_barang,
            'txttotal' => $orderan->jumlah_total,
            'txtket' => $orderan->keterangan,
            'txtdp' => $orderan->uang_muka,
            'txtsisa' => $orderan->sisa_pembayaran,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderanRequest $request, $id_keuangan)
    {
        $data = Orderan::findOrFail($id_keuangan);

        $data->nama_pemesan = $request->txtnama;
        $data->nama_barang = $request->txtbarang;
        $data->harga_barang = $request->txtharga;
        $data->jumlah_barang = $request->txtjumlah;
        $data->jumlah_total = $request->txttotal;
        $data->keterangan = $request->txtket;
        $data->uang_muka = $request->txtdp;
        $data->sisa_pembayaran = $request->txtsisa;
        $data->save();

        $kasMasuk = KasMasuk::where('keterangan', $data->nama_barang)->first();

        if ($kasMasuk) {
            if ($data->keterangan === 'BL') {
                $kasMasuk->pemasukan = $request->txtdp;
            } elseif ($data->keterangan === 'L') {
                $kasMasuk->pemasukan = $request->txttotal;
            }
            $kasMasuk->save();
        }

        return redirect('orderan')->with('success', 'Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($notrx)
    {

        $demoMode = setting::where('demo', 'Y')->first();

        if ($demoMode) {
            // Jika mode demo adalah 'Y', tampilkan pesan dan tidak izinkan pembaruan data
            return redirect()->url('orderan')->with('error', 'Pembaruan data tidak diizinkan dalam mode demo');
        }
        // Delete data dari DetailOrderan tabel
        $orderan = DetailOrderan::where('notrx', $notrx);

        if (!$orderan) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $orderan->delete();

        // Delete data dari KasMasuk tabel
        $kasMasuk = KasMasuk::where('id_generate', $notrx);
        if ($kasMasuk) {
            $kasMasuk->delete();
        }

        // Delete data dari PelunasanOrderan tabel
        $pelunasan = PelunasanOrderan::where('notrx', $notrx);
        if ($pelunasan) {
            $pelunasan->delete();
        }

        // Delete data dari OmsetPenjualan tabel
        $omset = OmsetPenjualan::where('notrx', $notrx);
        if ($omset) {
            $omset->delete();
        }
        // Delete data dari Stok Keluar tabel
        $stokkeluar = StokKeluar::where('notrx', $notrx);
        if ($stokkeluar) {
            $stokkeluar->delete();
        }

        return redirect('orderan')->with('success', 'Data Berhasil Dihapus!');
    }


    public function printInvoice($notrx)
    {
        $user = Auth::user();
        $orderans = DetailOrderan::where('notrx', $notrx)->select('*', 'created_at')->get()->groupBy('notrx');
        $data = DetailOrderan::all();
        $setting = setting::all();
        $via = PelunasanOrderan::with('rekenings')->where('notrx', $notrx)->get();
        $dataOrderan = DetailOrderan::with('pelanggans')->select('status', 'sisa')->where('notrx', $notrx)->get();
        foreach ($dataOrderan as $datas) {
            if ($datas->status == 'Lunas') {
                $stamp = 'assets/images/settings/' . $setting->first()->logo_lunas;
                $alt = 'LUNAS';
            } elseif ($datas->status == 'Belum Lunas') {
                $stamp = 'assets/images/settings/' . $setting->first()->logo_blunas;
                $alt = 'BELUM LUNAS';
            }
        }

        // dd($via);
        $logo = setting::all();
        $rekening = Rekening::all();

        $formatTgl = $orderans->map(function ($orderanGroup) {
            $orderanGroup->formatted_date = Carbon::parse($orderanGroup->first()->created_at)->isoFormat('dddd, DD/MM/YYYY');
            return $orderanGroup;
        });

        return view('orderan.print_invoice', [
            'orderans' => $orderans,
            'data' => $data,
            'notrx' => $notrx,
            'settings' => $setting,
            'via' =>  $via,
            'logo' => $logo,
            'rekening' => $rekening,
            'user' => $user,
            'formatTgl' => $formatTgl,
            'stamp' => $stamp,
            'alt' => $alt
        ]);

        // dd($logo);
        // $pdf = PDF::loadView('orderan.print_invoice', [
        //     'orderans' => $orderans,
        //     'data' => $data,
        //     'notrx' => $notrx,
        //     'settings' => $setting,
        //     'via' =>  $via,
        //     'logo' => $logo
        // ]);

        // return $pdf->download($notrx . '_invoice.pdf');
    }
    public function printInvoice58($notrx)
    {
        $user = Auth::user();
        $orderans = DetailOrderan::with('pelanggans')->where('notrx', $notrx)->select('*', 'created_at')->get()->groupBy('notrx');
        $setting = setting::all();
        $via = PelunasanOrderan::select('bank', 'via')->where('notrx', $notrx)->get();
        $logo = setting::all();
        $rekening = Rekening::all();
        $dataOrderan = DetailOrderan::with('pelanggans')->select('status', 'sisa')->where('notrx', $notrx)->get();

        $formatTgl = $orderans->map(function ($orderanGroup) {
            $orderanGroup->formatted_date = Carbon::parse($orderanGroup->first()->created_at)->isoFormat('dddd, DD/MM/YYYY');
            return $orderanGroup;
        });

        // cek orderan pada tabel detail_orderan, jika status lunas dan tidak lunas maka buatkan src ke stamp lunas
        foreach ($dataOrderan as $datas) {
            if ($datas->status == 'Lunas') {
                $stamp = 'assets/images/settings/' . $setting->first()->logo_lunas;
                $alt = 'LUNAS';
            } elseif ($datas->status == 'Belum Lunas') {
                $stamp = 'assets/images/settings/' . $setting->first()->logo_blunas;
                $alt = 'BELUM LUNAS';
            }
            // dd($dataOrderan);
        }

        return view('orderan.print_invoice58', [
            'orderans' => $orderans,
            'notrx' => $notrx,
            'settings' => $setting,
            'via' =>  $via,
            'logo' => $logo,
            'rekening' => $rekening,
            'user' => $user,
            'formatTgl' => $formatTgl,
            'stamp' => $stamp,
            'alt' => $alt,
        ]);
    }
}
