<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NeracaSaldoController extends Controller
{
    public function index()
    {
        return view('pembukuan.neraca-saldo', [
            'title' => 'Neraca Saldo',
        ]);
    }
}
