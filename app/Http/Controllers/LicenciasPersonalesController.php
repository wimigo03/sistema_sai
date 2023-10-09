<?php

namespace App\Http\Controllers;

use App\Models\LicenciasRipModel;
use Illuminate\Http\Request;

class LicenciasPersonalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permisos.licencias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LicenciasRipModel  $licenciasPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function show(LicenciasRipModel $licenciasPersonalesModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LicenciasRipModel  $licenciassPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function edit(LicenciasRipModel $licenciassPersonalesModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LicenciasRipModel  $licenciassPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LicenciasRipModel $licenciassPersonalesModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LicenciasRipModel  $licenciassPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(LicenciasRipModel $licenciassPersonalesModel)
    {
        //
    }
}
