<?php

namespace App\Http\Controllers\Almacen\Ingreso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Empleado;
use App\Models\Area;

use App\Models\Almacen\Ingreso\IngresoModel;
use App\Models\Almacen\Ingreso\ReporteAreaModel;

use App\Models\Almacen\DetalleValeModel;

use App\Models\Almacen\Ingreso\Temporal6Model;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ReporteAreasController extends Controller
{
    public function index()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal6Model::find($id);

        $id2 = $detalle->idingreso;
        $id3 = $detalle->idarea;


       // $prodserv = DB::table('reportarea as rr')


        $prodserv = DB::table('detallevale as d')

        ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso')
        ->join('vale as va', 'va.idvale', '=', 'd.idvale')

        ->join('areas as a', 'a.idarea', '=', 'va.idarea')



        // ->select('rr.idreportarea',
        ->select(
         'ing.nombreprograma', 'ing.nombreproducto',
          'd.cantidadsol', 'd.preciosol', 'd.subtotalsol',
          'va.idarea')
        //->where('ing.estadocompra', 2)

        ->orwhere('va.idarea', $id3 )
        // ->orwhere('va.idarea', $id3 )
        ->where('d.idingreso', $id2)

        ->get();



    $ingresos = DB::table('ingreso')
        ->where('estadocompracomb', 2)
        ->select(DB::raw("concat(idingreso,' // ',nombreproducto,' // ',nombreprograma,' // salida LTRS. ',cantidadsalida) as prodservicio"), 'idingreso')
        ->pluck('prodservicio', 'idingreso');


    $areas = DB::table('areas')

    ->where('estadoarea', 1)
    ->select(DB::raw("concat(nombrearea,' // ',idarea) as prodservicios"), 'idarea')
    ->pluck('prodservicios', 'idarea');

    return view('almacenes.reporte.index',
    ['prodserv' => $prodserv,
    'ingresos' => $ingresos,
    'areas' => $areas]);
}

public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal6Model::find($id);

        $prod = $request->get('ingreso');
        $proddos = $request->get('area');



        $detallereport = new ReporteAreaModel();
        $detallereport->idingreso = $request->get('ingreso');
        $detallereport->idarea = $request->get('area');

        $detallereport->save();

        if(is_null($detalle)){
            $detalle = new Temporal6Model;
            $detalle->idtemporal6=$id;
            $detalle->idusuario=$id;
            $detalle->idingreso=$prod;
            $detalle->idarea=$proddos;
            $detalle->save();
            $detallereport->save();
        }else{
            $detalle->idtemporal6 = $id;
            $detalle->idusuario = $id;
           $detalle->idingreso = $prod;
           $detalle->idarea=$proddos;
            $detalle->update();
        }

        return redirect()->route('almacenes.reporte.index');
    }


    public function guardartipoarea(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $tipoarea = new TipoArea;
        $tipoarea->idarea = $personalArea->idarea;
        $tipoarea->idtipo = $request->input('tipo');


        $detallito = DB::table('tipoarea as tt')
        ->join('areas as ar', 'ar.idarea', '=', 'tt.idarea')
         ->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
         ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
         ->where('tt.idarea','=', $personalArea->idarea)
         ->where('tt.idtipo', $request->input('tipo'))
         ->get();

//dd($detallito);

        if ($detallito->isEmpty()) {
            $tipoarea->save();
            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('archivos2.tipo');
    }


    public function delete($idtipoarea)
    {
        $tipoarea =TipoArea::find($idtipoarea);

        $tipoarea->delete();

        return redirect()->route('archivos2.tipo');
    }


}

