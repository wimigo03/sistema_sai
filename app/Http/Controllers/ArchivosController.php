<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use PDF;
use Carbon\Carbon;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\ProveedoresModel;
use App\Models\DocProveedorModel;
use App\Models\EmpleadoContrato;
use App\Models\TipoArea;
use App\Models\Archivo;
use App\Models\TipoArchivo;
use App\Models\AnioModel;
use App\Models\Area;
use App\Exportar\ArchivosExcel;


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

    public function index()
    {
        //if(Auth::user()->id == 102){
            //$this->generar_qr_general();
        //}
        $dea_id = Auth::user()->dea->id;
        $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',Auth::user()->idemp)->orderBy('id','desc')->take(1)->first();
        $personal = Area::find($contratos->idarea_asignada);

        $tipos = DB::table('tipoarea as a')
                    ->join('tipoarchivo as b','b.idtipo','a.idtipo')
                    ->select('b.nombretipo as tipo','b.idtipo as id')
                    ->where('a.idarea',Auth::user()->area_asignada_id)
                    ->where('a.dea_id',Auth::user()->dea->id)
                    ->pluck('tipo','id');

        return view('archivos.index', compact('personal','tipos'));
    }

    public function indexAjax(Request $request)
    {
        $contratos = EmpleadoContrato::select('idarea_asignada')
                    ->where('idemp',Auth::user()->idemp)
                    ->orderBy('id','desc')
                    ->take(1)
                    ->first();

        $query = DB::table('archivos as a')
                    ->join('areas as ar', 'ar.idarea', 'a.idarea')
                    ->join('tipoarchivo as t', 'a.idtipo', 't.idtipo')
                    ->where('ar.idarea', $contratos->idarea_asignada)
                    ->where('a.dea_id',Auth::user()->dea->id);

        $query = !is_null($request->gestion) ? $query->where('a.gestion',$request->gestion) : $query;
        if(!is_null($request->fecha)){
            $formattedKeyword =  Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');
            $query = $query->whereDate('a.fecha',$formattedKeyword);
        }
        $query = !is_null($request->nro_documento) ? $query->where('a.nombrearchivo',$request->nro_documento) : $query;
        $query = !is_null($request->referencia) ? $query->where('a.referencia', 'like','%' . $request->referencia . '%') : $query;
        $query = !is_null($request->tipo_id) ? $query->where('a.idtipo',$request->tipo_id) : $query;


        $query->select(
                        'a.idarchivo',
                        'a.referencia',
                        'a.fecha',
                        DB::raw("TO_CHAR(a.fecha, 'dd/mm/yyyy') as fecha_c"),
                        'a.gestion',
                        'a.nombrearchivo',
                        'a.documento',
                        'ar.idarea',
                        't.nombretipo'
        );

        return datatables()
            ->query($query)
            ->filterColumn('a.fecha', function($query, $keyword) {
                $sql = "TO_CHAR(a.fecha, 'dd/mm/yyyy') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('btn','archivos.btn')
            ->rawColumns(['btn'])
            ->toJson();
    }

    /* public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',Auth::user()->idemp)->orderBy('id','desc')->take(1)->first();
        $personal = Area::find($contratos->idarea_asignada);

        $tipos = DB::TABLE('tipoarea as a')
                    ->join('tipoarchivo as b','b.idtipo','a.idtipo')
                    ->select('b.nombretipo as tipo','b.idtipo as id')
                    ->where('a.idarea',Auth::user()->area_asignada_id)
                    ->where('a.dea_id',Auth::user()->dea->id)
                    ->pluck('tipo','id');

        $archivos = Archivo::query()
                            ->byDea(Auth::user()->dea->id)
                            ->byArea(Auth::user()->area_asignada_id)
                            ->byGestion($request->gestion)
                            ->byFecha($request->fecha)
                            ->byNumero($request->nro_documento)
                            ->byReferencia($request->referencia)
                            ->byTipo($request->tipo_id)
                            ->orderBy('fecha','desc')
                            ->orderBy('nombrearchivo')
                            ->paginate(10);

        $cont = 1;

        return view('archivos.index', compact('archivos','personal','tipos','cont'));
    } */

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $archivos = Archivo::query()
                                ->byDea(Auth::user()->dea->id)
                                ->byArea(Auth::user()->area_asignada_id)
                                ->byGestion($request->gestion)
                                ->byFecha($request->fecha)
                                ->byNumero($request->nro_documento)
                                ->byReferencia($request->referencia)
                                ->byTipo($request->tipo_id)
                                ->orderBy('fecha','desc')
                                ->orderBy('nombrearchivo')
                                ->get();

                $cont = 1;

                return Excel::download(new ArchivosExcel($archivos, $cont),'archivos_locales.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function pdf(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $archivos = Archivo::query()
                                ->byDea(Auth::user()->dea->id)
                                ->byArea(Auth::user()->area_asignada_id)
                                ->byGestion($request->gestion)
                                ->byFecha($request->fecha)
                                ->byNumero($request->nro_documento)
                                ->byReferencia($request->referencia)
                                ->byTipo($request->tipo_id)
                                ->orderBy('fecha','desc')
                                ->orderBy('nombrearchivo','asc')
                                ->orderBy('idtipo','asc')
                                ->get();

                $cont = 1;
                $username = User::find(Auth::user()->id);
                $area = Area::find($username->area_asignada_id);
                $username = $username != null ? $username->nombre_completo : $username->name;
                $pdf = PDF::loadView('archivos.pdf',compact('archivos','cont','username','area'));
                $pdf->setPaper('LETTER', 'portrait');
                return $pdf->stream();

        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function index_full(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
        return view('archivos.index-full', ['idd' => $personalArea]);
    }

    public function create()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea2 = Empleado::find($userdate->idemp);
        $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',$userdate->idemp)->orderBy('id','desc')->take(1)->first();

        $personalArea = Area::find($contratos->idarea_asignada);
        //dd($personalArea);

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
                $personalArea2 = Empleado::find($userdate->idemp);
                $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',$userdate->idemp)->orderBy('id','desc')->take(1)->first();

                $personalArea = Area::find($contratos->idarea_asignada);
                //dd($personalArea);
                $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
                $fecha_gestion = substr($request->fecha, 6, 4);
                if ($request->hasFile("documento")) {
                    $file = $request->file("documento");
                    $file_name = $file->getClientOriginalName();
                    $nombre = "pdf_" . time() . "." . $file->guessExtension();

                    $ruta = public_path("/documentos/" . $personalArea->nombrearea . '/' . $nombre);

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
                $archivos->documento = $personalArea->nombrearea . '/' . $nombre;
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
        $personalArea2 = Empleado::find($userdate->idemp);
        $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',$userdate->idemp)->orderBy('id','desc')->take(1)->first();

        $personalArea = Area::find($contratos->idarea_asignada);
//dd($personalArea->nombrearea);

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
        $personalArea2 = Empleado::find($userdate->idemp);

        $contratos = EmpleadoContrato::select('idarea_asignada')->where('idemp',$userdate->idemp)->orderBy('id','desc')->take(1)->first();

        $personalArea = Area::find($contratos->idarea_asignada);
//dd($personalArea->nombrearea);
        $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
        $fecha_gestion = substr($request->fecha, 6, 4);
        $archivos = Archivo::find($idarchivo);
        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = "pdf_" . time() . "." . $file->guessExtension();
                $ruta = public_path("/documentos/" . $personalArea->nombrearea . '/' . $nombre);
                if ($file->guessExtension() == "pdf") {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }

            $archivos->nombrearchivo = $request->input('nombredocumento');
            $archivos->referencia = $request->input('referencia');
            $archivos->documento = $personalArea->nombrearea . '/' . $nombre;
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
