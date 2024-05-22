<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\ProveedoresModel;
use App\Models\DocProveedorModel;
use App\Models\TipoAreaModel;
use App\Models\Archivo;
use App\Models\TiposModel;
use App\Models\AnioModel;
use App\Models\Area;


class ArchivosController extends Controller
{
    private function generar_qr_general()
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            //$archivos = Archivo::where('idarchivo','>=',35001)->where('idarchivo','<=',40000)->orderBy('idarchivo','asc')->get();
            //dd($archivos);
            foreach($archivos as $datos){
                $archivo = Archivo::select('idarchivo')->where('idarchivo',$datos->idarchivo)->first();
                $url = 'https://sistemas.granchaco.gob.bo/archivos/documentacion/' . $archivo->idarchivo;
                $qr = QrCode::format('png')->margin(0)->size(300)->generate($url, public_path() . '/documentos/qr/' . $archivo->idarchivo . '.png');
            }
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
        dd("Generar Qr Finalizado...");
    }

    public function index(Request $request)
    {
        //if(Auth::user()->id == 102){
            //$this->generar_qr_general();
        //}
        $dea_id = Auth::user()->dea->id;
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp);
        if ($request->ajax()) {
            $data = DB::table('archivos as a')
                            ->join('areas as ar', 'ar.idarea', 'a.idarea')
                            ->join('tipoarchivo as t', 'a.idtipo', 't.idtipo')
                            ->select(
                                'a.idarchivo',
                                'a.referencia',
                                'a.fecha',
                                'a.gestion',
                                'a.nombrearchivo',
                                'a.documento',
                                'ar.idarea',
                                't.nombretipo'
                            )
                            ->where('ar.idarea', $personalArea->idarea)
                            ->where('a.dea_id',$dea_id)
                            ->orderBy('a.fecha', 'desc');

            return Datatables::of($data)
                                ->addIndexColumn()
                                /*->editColumn('fecha', function($row) {
                                    return date('d-m-Y', strtotime($row->fecha));
                                })*/
                                ->addColumn('btn', 'archivos.btn')
                                ->rawColumns(['btn'])
                                /*->filterColumn('fecha', function($query, $keyword) {
                                    $query->whereRaw("DATE_FORMAT(fecha, '%d-%m-%Y') like ?", ["%{$keyword}%"]);
                                })*/
                                ->make(true);
        }

        return view('archivos.index', ['idd' => $personalArea]);
    }

    public function index_full(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
        return view('archivos.index-full', ['idd' => $personalArea]);
    }

    public function index_ajax(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
        $data = DB::table('archivos as a')
                    ->join('areas as ar', 'ar.idarea', 'a.idarea')
                    ->join('tipoarchivo as t', 'a.idtipo', 't.idtipo')
                    ->select(
                        'a.idarchivo',
                        'a.referencia',
                        'a.fecha',
                        'a.gestion',
                        'a.created_at',
                        'a.nombrearchivo',
                        'a.documento',
                        'ar.nombrearea',
                        'ar.idarea',
                        't.nombretipo'
                    )
                    ->where('a.dea_id',$dea_id)
                    ->orderBy('a.gestion', 'desc');

        return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('btn', 'archivos.btn')
                        ->rawColumns(['btn'])
                        ->make(true);
    }

    public function create()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp);

        $tipoarea = DB::table('tipoarea as tt')
                        ->join('areas as ar', 'ar.idarea', 'tt.idarea')
                        ->join('tipoarchivo as t', 't.idtipo', 'tt.idtipo')
                        ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
                        ->where('tt.idarea', $personalArea->idarea)
                        ->orderBy('tt.idtipoarea', 'desc')
                        ->get();
        $date = Carbon::now();
        $date = $date->format('Y');
        $anio = DB::table('anio')->get();

        return view('archivos.create', ["tipos" => $tipoarea, "date" => $date, "anio" => $anio]);
    }

    public function store(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $dea_id = Auth::user()->dea->id;
                $personal = User::find(Auth::user()->id);
                $id = $personal->id;
                $userdate = User::find($id)->usuariosempleados;
                $personalArea = Empleado::find($userdate->idemp);
                $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
                $fecha_gestion = substr($request->fecha, 6, 4);
                if ($request->hasFile("documento")) {
                    $file = $request->file("documento");
                    $file_name = $file->getClientOriginalName();
                    $nombre = "pdf_" . time() . "." . $file->guessExtension();

                    $ruta = public_path("/documentos/" . $personalArea->area->nombrearea . '/' . $nombre);

                    if ($file->guessExtension() == "pdf") {
                        copy($file, $ruta);
                    } else {
                        return back()->with(["error" => "File not available!"]);
                    }
                }

                $archivos = new Archivo();
                $archivos->nombrearchivo = $request->input('nombredocumento');
                $archivos->referencia = $request->input('referencia');
                $archivos->gestion = $fecha_gestion;
                $archivos->documento = $personalArea->area->nombrearea . '/' . $nombre;
                $archivos->idarea = $personalArea->idarea;
                $archivos->estado1 = 1;
                $archivos->idtipo = $request->input('tipodocumento');
                $archivos->id = $personal->id;
                $archivos->fecha = $fecha_recepcion;
                $archivos->dea_id = $dea_id;
                $archivos->save();

                $url = 'https://sistemas.granchaco.gob.bo/archivos/documentacion/' . $archivos->idarchivo;
                $qr = QrCode::format('png')->margin(0)->size(300)->generate($url, public_path() . '/documentos/qr/' . $archivos->idarchivo . '.png');

                //return redirect()->route('archivos2.index', ['idd' => $personalArea])->with('success_message', 'Archivo cargado correctamente...');

        } catch (\Throwable $th){
            return '[ERROR_500]';
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function editar($idarchivo)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp);

        $tipoarea = DB::table('tipoarea as tt')
                        ->join('areas as ar', 'ar.idarea', 'tt.idarea')
                        ->join('tipoarchivo as t', 't.idtipo', 'tt.idtipo')
                        ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
                        ->where('tt.idarea', $personalArea->idarea)
                        ->orderBy('tt.idtipoarea', 'desc')
                        ->get();

        $archivos = Archivo::find($idarchivo);
        $date = Carbon::now();
        $date = $date->format('Y');
        $date22 = $archivos->fecha;
        $date2 = Carbon::createFromFormat('Y-m-d', $date22)->format('d/m/Y');
        $anio = DB::table('anio')->get();

        return view('archivos.editar', ["date2" => $date2, "tipos" => $tipoarea, "archivos" => $archivos, "date" => $date, "anio" => $anio]);
    }

    public function update(Request $request)
    {
        $idarchivo = $request->archivo_id;
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp);
        $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
        $fecha_gestion = substr($request->fecha, 6, 4);
        $archivos = Archivo::find($idarchivo);
        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = "pdf_" . time() . "." . $file->guessExtension();
                $ruta = public_path("/documentos/" . $personalArea->area->nombrearea . '/' . $nombre);
                if ($file->guessExtension() == "pdf") {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }

            $archivos->nombrearchivo = $request->input('nombredocumento');
            $archivos->referencia = $request->input('referencia');
            $archivos->documento = $personalArea->area->nombrearea . '/' . $nombre;
            $archivos->idarea = $personalArea->idarea;
            $archivos->estado1 = 1;
            $archivos->gestion = $fecha_gestion;
            $archivos->fecha = $fecha_recepcion;
            $archivos->idtipo = $request->input('tipodocumento');
            $archivos->save();

            $url = 'https://sistemas.granchaco.gob.bo/archivos/documentacion/' . $archivos->idarchivo;
            $qr = QrCode::format('png')->margin(0)->size(300)->generate($url, public_path() . '/documentos/qr/' . $archivos->idarchivo . '.png');
        } else {
            $archivos->nombrearchivo = $request->input('nombredocumento');
            $archivos->referencia = $request->input('referencia');
            $archivos->idarea = $personalArea->idarea;
            $archivos->estado1 = 1;
            $archivos->gestion = $fecha_gestion;
            $archivos->fecha = $fecha_recepcion;
            $archivos->idtipo = $request->input('tipodocumento');
            $archivos->save();
        }

        //return redirect()->route('archivos2.index', ['idd' => $personalArea]);
    }

    public function documentacion($archivo_id)
    {
        $archivo = Archivo::find($archivo_id);
        $array = explode("/", $archivo->documento);
        $area = str_replace(" ", "%20", $array[0]);
        $documento = $array[1];
        $url = 'documentos/' . $area . '/' . $documento;
        return redirect()->to(url($url));
    }

    public function generar_qr($archivo_id)
    {
        $url = 'documentos/qr/' . $archivo_id . '.png';
        return redirect()->to(url($url));
    }
}
