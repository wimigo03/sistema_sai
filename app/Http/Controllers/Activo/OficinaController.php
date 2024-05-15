<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\EntidadesModel;
use App\Models\Empleado;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\FileModel;

class OficinaController extends Controller
{
    public function index()
    {
        return view('activo.oficina.index');
    }

    // public function create($id)
    // {
    //     $entidad = EntidadesModel::where('entidad', 4601)->first();
    //     $unidad = UnidadadminModel::where('unidad', 'A')->first();
    //     $idarea = Area::where('idarea', $id)->with('empleados')->with('file')->get();
    //     $idarea = DB::table('areas')
    //         ->where('idarea', $id)
    //         ->get();

    //     if ($idarea->count() > 0) {
    //         $area = $idarea->first();

    //         $responsables = DB::table('empleados')
    //             ->where('idarea', $area->idarea)
    //             ->get();

    //         $file = DB::table('file')
    //             ->where('idfile', $area->idarea)
    //             ->get();

    //         // Now you can work with $firstArea, $employees, and $file data as needed
    //     }
    //     return view('activo.oficina.create', compact('area', 'file', 'entidad', 'unidad', 'responsables'));
    // }

    // public function create($id)
    // {
    //     $entidad = EntidadesModel::where('entidad', 4601)->first();
    //     $unidad = UnidadadminModel::where('unidad', 'A')->first();
    //     $idarea = DB::table('areas')
    //         ->select('areas.*', 'empleados.*', 'file.*')
    //         ->where('areas.idarea', $id)
    //         ->leftJoin('empleados', 'areas.idarea', '=', 'empleados.idarea')
    //         ->leftJoin('file', 'areas.idarea', '=', 'file.idarea')
    //         ->get();

    //     if ($idarea->count() > 0) {
    //         $areas = $idarea->first();

    //         // Accessing the area data
    //         $area = [
    //             'idarea' => $areas->idarea,
    //             // Add other area fields as needed
    //         ];

    //         // Accessing the employees data
    //         $responsables = [];
    //         foreach ($idarea as $row) {
    //             $responsable = [
    //                 'idemp' => $row->idemp,
    //                 // Add other employee fields as needed
    //             ];
    //             $responsables[] = $responsable;
    //         }

    //         // Accessing the file data
    //         $file = [
    //             'file' => $areas->idfile,
    //             // Add other file fields as needed
    //         ];

    //         // Now you can work with $areaData, $employeesData, and $fileData as needed

    //     }
    //     return view('activo.oficina.create', compact('area', 'file', 'entidad', 'unidad', 'responsables'));
    // }





    public function list()
    {
        $customers = Area::select(['idarea', 'nombrearea', 'estadoarea', 'idnivel']);
        return Datatables::of($customers)
            ->addColumn('url', function ($customer) {
                return route('detalle', $customer->idarea);
            })
            ->addColumn('btn2', function ($row) {
                $btn2 ='<a href="' . route('activo.responsable.index', $row->idarea) . '" class="tts:left tts-slideIn tts-custom" aria-label="Ir a Responsables">
                            <i class="fa-solid fa-2xl fa-right-to-bracket"></i>
                        </a>';
                return $btn2;
            })
            ->rawColumns(['btn2'])
            ->make(true);
    }

    ///////////////////////////////////////////////////////

    public function detalle($id)
    {
        $purchases = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', 'e.idarea')
            ->select('e.nombres', 'e.ap_pat', 'e.ap_mat', 'e.ci', 'e.fechingreso')
            ->where('e.tipo', 1)
            ->where('e.idarea', $id)
            ->get();

        return Datatables::of($purchases)->make(true);
    }

    ///////////////////////////////////////////////////////






    /////////////////////////////////////////////////////

    public function edit($id)
    {

        return view('activo.oficina.edit');
    }


    /////////////////////////////////////////////////

    // public function contratonuevo($id)
    // {

    //     $area = Area::where('estadoarea', '=', 1)->with('iPais_all')->get();
    //     $niveles = DB::table('niveles')->get();

    //     return view('rechumanos.contrato.create', ["niveles" => $niveles, "area" => $area, "idarea" => $id]);
    // }

    ////////////////////////////////////////////////

    public function lista($idarea)
    {
        $empleados = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('file as f', 'f.idfile', '=', 'e.idfile')
            ->select(
                DB::raw("CONCAT(e.nombres, ' ', e.ap_pat, ' ', e.ap_mat) AS nombre_completo"),
                'f.cargo',
                'e.ci',
                'e.exppoai',
                'e.estadoemp1'
            )
            ->where('e.tipo', '=', 2)
            ->where('e.idarea', '=', $idarea)
            ->get();

        $areas = Area::find($idarea);
        $nombrearea = $areas->nombrearea;

        return view('activo.oficina.lista', ["empleados" => $empleados, "idarea" => $idarea, "nombrearea" => $nombrearea]);
    }
}
