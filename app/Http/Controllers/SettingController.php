<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Requests\StoresettingRequest;
use App\Http\Requests\UpdatesettingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $datas = Setting::all();

        return view('settings.index', [
            'title' => env('APP_NAME') . ' | ' . 'Settings',
            'name_user' => $user->name,
            'data' => $datas,
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
    public function store(StoresettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editLogo(Request $request)
    {
        $data = Setting::first();
        $logoUpdated = false;
        $faviconUpdated = false;
        $logoLoginUpdated = false;
        $logoLunasUpdated = false;
        $logoBlunasUpdated = false;
        $qrcodeUpdated = false;

        if ($request->hasFile('logo')) {
            $foto_file = $request->file('logo');
            $logo_name = $foto_file->hashName();
            $foto_file->move(public_path('assets/images/settings'), $logo_name);

            $data->logo = $logo_name;
            $logoUpdated = true;
        }

        if ($request->hasFile('favicon')) {
            $favicon_file = $request->file('favicon');
            $favicon_name = $favicon_file->hashName();
            $favicon_file->move(public_path('assets/images/settings'), $favicon_name);

            $data->favicon = $favicon_name;
            $faviconUpdated = true;
        }

        if ($request->hasFile('logo_login')) {
            $logo_login = $request->file('logo_login');
            $logo_login_name = $logo_login->hashName();
            $logo_login->move(public_path('assets/images/settings'), $logo_login_name);

            $data->login_logo = $logo_login_name;
            $logoLoginUpdated = true;
        }

        if ($request->hasFile('lunas')) {
            $lunas = $request->file('lunas');
            $lunas_name = $lunas->hashName();
            $lunas->move(public_path('assets/images/settings'), $lunas_name);

            $data->logo_lunas = $lunas_name; // Update the field to 'lunas_logo'
            $logoLunasUpdated = true;
        }

        if ($request->hasFile('blunas')) {
            $blunas = $request->file('blunas');
            $blunas_name = $blunas->hashName();
            $blunas->move(public_path('assets/images/settings'), $blunas_name);

            $data->logo_blunas = $blunas_name; // Update the field to 'blunas_logo'
            $logoBlunasUpdated = true;
        }
        if ($request->hasFile('qrcode')) {
            $qrcode = $request->file('qrcode');
            $qrcode_name = $qrcode->hashName();
            $qrcode->move(public_path('assets/images/qrcode'), $qrcode_name);

            $data->qrcode = $qrcode_name; // Update the field to 'blunas_logo'
            $qrcodeUpdated = true;
        }

        if ($logoUpdated || $faviconUpdated || $logoLoginUpdated || $logoLunasUpdated || $logoBlunasUpdated || $qrcodeUpdated) {
            $data->save();

            if ($logoUpdated) {
                return redirect('setting')->with('success', 'Logo Berhasil Diperbarui!');
            } elseif ($faviconUpdated) {
                return redirect('setting')->with('success', 'Favicon Berhasil Diperbarui!');
            } elseif ($logoLoginUpdated) {
                return redirect('setting')->with('success', 'Logo Login Berhasil Diperbarui!');
            } elseif ($logoLunasUpdated) {
                return redirect('setting')->with('success', 'Logo Lunas Berhasil Diperbarui!');
            } elseif ($logoBlunasUpdated) {
                return redirect('setting')->with('success', 'Logo Blunas Berhasil Diperbarui!');
            } elseif ($qrcodeUpdated) {
                return redirect('setting')->with('success', 'QR Code Berhasil Diperbarui!');
            }
        }

        return redirect('setting')->with('error', 'Tidak ada file yang dipilih.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_setting)
    {



        $data = Setting::findOrFail($id_setting);

        $data->perusahaan = $request->nama_perusahaan;
        $data->email = $request->email;
        $data->alamat = $request->alamat;
        $data->phone = $request->phone;
        $data->instagram = $request->ig;

        // Memeriksa apakah data darijam dan sampaijam diubah atau tidak
        if ($request->darijam && $request->sampaijam) {
            // Jika diubah, gunakan data dari form
            $data->darijam = $request->darijam;
            $data->sampaijam = $request->sampaijam;
        } else {
            // Jika tidak diubah, gunakan data dari database
            $data->darijam = $data->darijam;
            $data->sampaijam = $data->sampaijam;
        }

        $data->pesan = $request->footer_invoice;
        $data->warnatema = $request->warnatema;
        $data->demo = $request->mode;
        $data->save();

        return redirect('setting')->with('success', 'Data Berhasil Di-perbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(setting $setting)
    {
        //
    }
}
