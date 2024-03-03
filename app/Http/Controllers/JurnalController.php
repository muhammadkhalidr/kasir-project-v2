<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Http\Requests\StoreJurnalRequest;
use App\Http\Requests\UpdateJurnalRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Jurnal::all();

        $formatTgl = $data->map(function ($data) {
            $data->formatted_date = Carbon::parse($data->tgl_transaksi)->isoFormat('h:mm:ss a');
            return $data;
        });

        return view('pembukuan.jurnalumum', [
            'title' => 'Jurnal Umum',
            'name_user' => $user->name,
            'datas' => $data,
            'tgl' => $formatTgl,
            'breadcrumb' => 'Jurnal Umum'
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
    public function store(StoreJurnalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurnal $jurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJurnalRequest $request, Jurnal $jurnal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }
}
