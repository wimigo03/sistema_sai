<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RecepcionModel;
use Illuminate\Http\Request;
use App\Models\ProveedoresModel;
use App\Models\DocProveedorModel;
use App\Models\RemitenteModel;
use App\Models\LugarModel;
use App\Models\ArchivosModel;
use App\Models\AnioModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use DataTables;

class CorrespondenciaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::connection('pgsql_correspondencia')
                        ->table("recepcion as r")
                        ->join('empleados as e', 'e.id_emp', 'r.id_emp')
                        ->join('unidad as u', 'u.id_unidad', 'e.id_unidad')
                        ->select('r.id_recepcion',
                                    'r.asunto',
                                    'r.fecha_recepcion',
                                    'r.n_oficio',
                                    'r.observaciones',
                                    'e.nombres',
                                    'e.ap_pat',
                                    'e.ap_mat',
                                    'u.nombre_unidad')
                        ->orderBy('r.id_recepcion', 'desc');

            return Datatables::of($data)->addIndexColumn()
                                        ->addColumn('btn', 'correspondencia.btn')
                                        ->rawColumns(['btn'])
                                        ->make(true);
        }

        return view('correspondencia.index');
    }

    public function create()
    {
        $date = Carbon::now();
        $date = $date->format('Y');
        $tipos = DB::table('tipoarchivo')->get();
        $anio = DB::table('anio')->get();
        return view('correspondencia.createRecepcion', ["tipos" => $tipos, "date" => $date, "anio" => $anio]);
    }


    public function indexUnidad(Request $request)
    {
        if ($request->ajax()) {
            $unidad = DB::connection('pgsql_correspondencia')
                            ->table("unidad as u")
                            ->select('u.nombre_unidad');

            return Datatables::of($unidad)->addIndexColumn()->make(true);
        }

        return view('correspondencia.indexUnidad');
    }

    public function indexRemitente(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::connection('pgsql_correspondencia')
                        ->table("empleados as e")
                        ->join('unidad as u', 'u.id_unidad', 'e.id_unidad')
                        ->select('e.nombres', 'e.ap_pat', 'e.ap_mat', 'e.ci', 'u.nombre_unidad');

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('correspondencia.indexRemitente');
    }

    public function createLugar()
    {
        return view('correspondencia.createUnidad');
    }

    public function storeLugar(request $request)
    {
        $newestUser = LugarModel::orderBy('id_unidad', 'desc')->first();
        $maxId = $newestUser->id_unidad;
        $lugar = new LugarModel();
        $lugar->id_unidad = $maxId + 1;
        $lugar->nombre_unidad = $request->input('nombre');
        $lugar->estado_unidad = 1;
        $lugar->save();

        return redirect()->route('correspondencia.unidadIndex');
    }

    public function createRemitente()
    {
        $unidades = DB::connection('pgsql_correspondencia')->table("unidad")->get();
        return view('correspondencia.createRemitente', ["unidades" => $unidades]);
    }

    public function storeRemitente(request $request)
    {
        $newestUser = RemitenteModel::orderBy('id_emp', 'desc')->first();
        $maxId = $newestUser->id_emp;
        $remitente = new RemitenteModel();
        $remitente->id_emp = $maxId + 1;
        $remitente->nombres = $request->input('nombres');
        $remitente->ap_pat = $request->input('apPat');
        $remitente->ap_mat = $request->input('apMat');
        //$remitente->ci = $request->input('ci');
        $remitente->id_unidad = $request->input('lugar');
        $remitente->estado = 1;
        $remitente->estado_envio = 0;
        $remitente->estado_u = 0;
        $remitente->save();

        return redirect()->route('correspondencia.remitenteIndex');
    }


    public function createRecepcion()
    {
        $empleados = DB::connection('pgsql_correspondencia')
                        ->table("empleados as e")
                        ->join('unidad as u', 'u.id_unidad', '=', 'e.id_unidad')
                        ->select('e.nombres', 'e.id_emp', 'e.ap_pat', 'e.ap_mat', 'u.nombre_unidad')
                        ->get();

        $tipos = DB::connection('pgsql_correspondencia')->table("tipo_correspondencia")->get();

        return view('correspondencia.createRecepcion', ["empleados" => $empleados, "tipos" => $tipos]);
    }

    public function storeRecepcion(request $request)
    {
        $newestUser = RecepcionModel::orderBy('id_recepcion', 'desc')->first();
        $maxId = $newestUser->id_recepcion;
        $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
        $recepcion = new RecepcionModel();
        $recepcion->id_recepcion = $maxId + 1;
        $recepcion->asunto = $request->input('asunto');
        $recepcion->n_oficio = $request->input('codigo');
        $recepcion->observaciones = $request->input('oficio');
        //$remitente->ci = $request->input('ci');
        $recepcion->fecha_recepcion = $fecha_recepcion;
        $recepcion->id_us = 3;
        $recepcion->id_emp = $request->input('emp');
        $recepcion->id_tipo_corresp = $request->input('tipo');
        $recepcion->confidencialidad = 1;
        $recepcion->estado_correspon = 1;
        $recepcion->estado_derivacion = 1;
        $recepcion->save();

        return redirect()->route('correspondencia.index');
    }

    public function editarCodigo($idrecepcion)
    {
        $recepcion = RecepcionModel::find($idrecepcion);
        return view('correspondencia/edit')->with('recepcion', $recepcion);
    }

    public function updateCodigo(Request $request, $idRecepcion)
    {
        $recepcion = RecepcionModel::find($idRecepcion);
        $recepcion->n_oficio = $request->input('codigo');
        if ($recepcion->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('correspondencia.index');
    }
}
