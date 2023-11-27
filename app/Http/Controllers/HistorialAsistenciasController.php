<?php

namespace App\Http\Controllers;

use App\Models\HistorialAsistenciasCambios;
use App\Models\LectorDactilarModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;

class HistorialAsistenciasController extends Controller
{

    
    

    public function index(Request $request)
    {
       if ($request->ajax()) {

            $historial = HistorialAsistenciasCambios::all();
            $historial->transform(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');

                $item->datos_anteriores = json_decode(html_entity_decode($item->datos_anteriores), true);
                return $item;
            });
    
          return datatables()->of($historial)->toJson();
 
      }

       return view('asistencias.regularizar.historial');
    }

    public function verHistorial($id)
    {
        $historial = HistorialAsistenciasCambios::where('registro_asistencia_id', $id)->get();

        // Puedes pasar los datos del historial a una vista
        return view('historial.ver', compact('historial'));
    }

    public function dtalles(Request $request)
    {
       if ($request->ajax()) {

            $historial = HistorialAsistenciasCambios::all();
            $historial->transform(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->format('Y-m-d H:i:s');

                $item->datos_anteriores = json_decode(html_entity_decode($item->datos_anteriores), true);
                return $item;
            });
    
          return datatables()->of($historial)->toJson();
 
      }

       return view('asistencias.regularizar.historial');
    }


}
