<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GajiKaryawanV2Controller extends Controller
{
    public function index()
    {

        $user = Auth::user();
        return view('gajiv2.data', [
            'title' => 'Gaji Karyawan',
            'user' => $user,
            'breadcrumb' => 'Gaji V2'

        ]);
    }
}
