<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use App\Models\EmpleadosModel;
use App\Models\MovimientosPtModel;


class NotifcacionController extends Controller
{
    /**


     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentDate = now();

        $personasmes = EmpleadosModel::whereDay('natalicio', $currentDate->day)
        ->whereMonth('natalicio', $currentDate->month)
        ->where('tipo',1)
        ->get(['nombres', 'ap_pat','ap_mat','natalicio']);

        $personashoy = EmpleadosModel::whereDay('natalicio', $currentDate->day)
        ->whereMonth('natalicio', $currentDate->month)
        ->where('tipo',1)
        ->get(['nombres', 'ap_pat','ap_mat','natalicio']);

        $cumplenAniosmes = count($personasmes);
        $cumplenAnioshoy = count($personashoy);

        
        //return view('cumpleanios.index', compact('cumplenAnios'));
        return view('asistencias.notificacion.index', compact('personashoy','cumplenAnioshoy','personasmes','cumplenAniosmes'));
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
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function show(Notificacion $notificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificacion $notificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacion $notificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }
}
