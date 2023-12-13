<?php

namespace App\Http\Controllers;

use App\Models\EmpleadosModel;
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
            $historial = HistorialAsistenciasCambios::orderBy('created_at', 'desc')->get();


            $historial->transform(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->diffForHumans();
                $item->datos_anteriores = json_decode(html_entity_decode($item->datos_anteriores), true);
                // Agregar el botón con el ID
                $item->enlace_html = '<a href="' . route('restaurar-datos.restore', ['id' => $item->id]) . '"> <i class="fa-solid fa-2x fa-trash-can-arrow-up"></i></a>';
                
                $empleado = EmpleadosModel::where('idemp',$item->empleado_id)->select('nombres','ap_pat','ap_mat')->first();
                $item->nombre_empleado = $empleado ? $empleado->nombres : 'Desconocido';
                $item->apellidos_empleado = $empleado ? $empleado->ap_pat : '';
                $item->apellidos_empleado2 = $empleado ? $empleado->ap_mat : '';

                return $item;
            });
            return Datatables::of($historial)
                ->addColumn('boton_html', function ($row) {
                    return $row->enlace_html;
                })
                ->addColumn('nombre_empleado', function ($row) {
                    return $row->nombre_empleado . ' ' . $row->apellidos_empleado. ' ' . $row->apellidos_empleado2;
                })
                ->rawColumns(['boton_html'])
                ->toJson();
      }


        return view('asistencias.regularizar.historial');
    }

    public function verHistorial($id)
    {
        $historial = HistorialAsistenciasCambios::where('registro_asistencia_id', $id)->get();

        // Puedes pasar los datos del historial a una vista
        return view('historial.ver', compact('historial'));
    }

  

    public function restore($id)
    {
        // Obtén el historial por su ID
        $historial = HistorialAsistenciasCambios::find($id);

        if (!$historial) {
            return response()->json(['error' => 'Historial no encontrado'], 404);
        }

        // Obtén los datos anteriores almacenados en formato JSON y decódificarlos
        $datosAnterioresJson = $historial->datos_anteriores;
        $datosAnterioresArray = json_decode($datosAnterioresJson, true);

        // Ahora, $datosAnterioresArray contiene los valores originales como un array asociativo
        // Puedes utilizar estos valores según tus necesidades
      
        // Por ejemplo, podrías restaurar los datos en el modelo original
        // Supongamos que el modelo original es Usuario y el ID del usuario está en $datosAnterioresArray['usuario_id']
        RegistroAsistencia::find($datosAnterioresArray['id'])->update($datosAnterioresArray);
        // Elimina el historial restaurado
        $historial->empleado_id;
        $empleado = EmpleadosModel::where('idemp',$historial->empleado_id)->select('idemp','nombres','ap_pat','ap_mat')->first();

        $historial->delete();
       //  return view('asistencias.registros.fechas', compact('vistaselectedMonth', 'empleado'));
       $vistaselectedMonth = Carbon::now()->format('Y-m');
       return view('asistencias.registros.fechas',compact('vistaselectedMonth', 'empleado'))->with('success', 'Se restauro con éxito el Regitro del personal :'.$empleado->nombres.' '.$empleado->ap_pat.' '.$empleado->ap_pat);



    }
}
