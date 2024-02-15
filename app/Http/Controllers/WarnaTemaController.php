<?php

namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarnaTemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warnaTema = Setting::value('warnatema'); // Sesuaikan dengan nama kolom di tabel
        dd($warnaTema);
        // Mengirim data warna tema ke view
        return view(
            'partials.header',
            [
                'data' => $warnaTema,
                'title' => 'warna',
                'name_user' => Auth::user()->name
            ]
        );
    }
}
