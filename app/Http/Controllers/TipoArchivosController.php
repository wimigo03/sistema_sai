<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\ProveedoresModel;
use App\Models\DocProveedorModel;
use App\Models\TipoArea;
use App\Models\Archivo;
use App\Models\TipoArchivo;
use App\Models\EmpleadoContrato;
use App\Models\Area;
use App\Models\AnioModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use DataTables;


class TipoArchivosController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea2 = Empleado::find($userdate->idemp);
        $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',$userdate->idemp)->orderBy('id','desc')->take(1)->first();

        $personalArea = Area::find($contratos->idarea_asignada);

        $tipoarea = DB::table('tipoarea as tt')
                        ->join('areas as ar', 'ar.idarea', 'tt.idarea')
                        ->join('tipoarchivo as t', 't.idtipo', 'tt.idtipo')
                        ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo', 't.codigo', 't.subtipo', 't.estado', 't.idtipo')
                        ->where('tt.idarea', $personalArea->idarea)
                        ->orderBy('tt.idtipoarea', 'desc')
                        ->get();

        $tipos = DB::table('tipoarchivo')->get();
        return view('archivos.tipos.index', ["tipos" => $tipos,"tipoareas" => $tipoarea,"personal" => $personalArea]);
    }

    public function store(request $request)
    {
        $newestUser = TipoArchivo::orderBy('idtipo', 'desc')->first();
        $maxId = $newestUser->idtipo;
        $tipos2 = new TipoArchivo();
        $tipos2->idtipo = $maxId + 1;
        $tipos2->nombretipo = $request->input('nombretipo');
        $tipos2->save();
        return redirect()->route('tipos.archivos.index')->with('success_message', 'Registro agregado correctamente.');
    }

    public function storeCargar(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea2 = Empleado::find($userdate->idemp);
        $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',$userdate->idemp)->orderBy('id','desc')->take(1)->first();

       $personalArea = Area::find($contratos->idarea_asignada);
        $tipoarea = new TipoArea;
        $tipoarea->idarea = $personalArea->idarea;
        $tipoarea->idtipo = $request->input('tipo');
        $detallito = DB::table('tipoarea as tt')
                        ->join('areas as ar', 'ar.idarea', 'tt.idarea')
                        ->join('tipoarchivo as t', 't.idtipo', 'tt.idtipo')
                        ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
                        ->where('tt.idarea', $personalArea->idarea)
                        ->where('tt.idtipo', $request->input('tipo'))
                        ->get();

        if ($detallito->isEmpty()) {
            $tipoarea->save();
            return redirect()->route('tipos.archivos.index')->with('success_message', 'Registro agregado correctamente.');
        } else {
            return redirect()->route('tipos.archivos.index')->with('error_message', 'El item ya existe en la listado.');
        }
    }

    public function delete($idtipoarea)
    {
        $tipoarea =TipoArea::find($idtipoarea);
        $tipoarea->delete();
        return redirect()->route('tipos.archivos.index');
    }

    public function create()
    {
        return view('archivos.tipos.create');
    }

    public function editar($id)
    {
        $tipo = TipoArchivo::find($id);
        $estados = TipoArchivo::ESTADOS;
        $subtipos = TipoArchivo::SUBTIPOS;
        return view('archivos.tipos.editar', compact('tipo','estados','subtipos'));
    }

    public function update(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $tipo_archivo = TipoArchivo::find($request->tipo_id);
                $tipo_archivo->update([
                    'nombretipo' => $request->nombretipo,
                    'codigo' => $request->codigo,
                    'subtipo' => $request->subtipo,
                    'estado' => $request->estado
                ]);

                return redirect()->route('tipos.archivos.index')->with('success_message', 'Proceso realizado exitosamente.');
        } catch (\Throwable $th){
            return '[ERROR_500]';
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
