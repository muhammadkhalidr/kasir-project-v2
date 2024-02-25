<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardKeuanganController extends Controller
{
    public function index()
    {
        return view('layout.dashboard_keuangan', [
            'title' => 'Dashboard Keuangan',
            'name_user' => Auth::user()->name
        ]);
    }
}
