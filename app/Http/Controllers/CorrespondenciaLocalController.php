<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use DataTables;

use App\Models\User;
use App\Models\Empleado;
use App\Models\RecepcionModel;
use App\Models\Recepcion2Model;
use App\Models\TipoCorresp2Model;
use App\Models\RemitenteModel;
use App\Models\Remitente2Model;
use App\Models\UnidadModel;
use App\Models\ArchivoCorrespModel;
use App\Models\DerivCorrespModel;
use App\Models\InstruccionvModel;
use App\Models\AnioModel;
use App\Exportar\RecepcionVentanillaExcel;

class CorrespondenciaLocalController extends Controller
{
    private function generar_qr_general()
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $correspondencias = ArchivoCorrespModel::where('id_archivo','>=',5001)->where('id_archivo','<=',10000)->orderBy('id_archivo','asc')->get();
            dd($correspondencias);
            foreach($correspondencias as $datos){
                $correspondencia = ArchivoCorrespModel::select('id_recepcion')->where('id_archivo',$datos->id_archivo)->first();

                $url = 'https://sistemas.granchaco.gob.bo/correspondencia-local/urlfile/' . $correspondencia->id_recepcion;
                $qr = QrCode::format('png')->margin(0)->size(300)->generate($url, public_path() . '/documentos_correspondencia/qr/' . $correspondencia->id_recepcion . '.png');
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


        return view('correspondencia-local.index');
    }

    public function indexAjax(Request $request)
    {
        $query = DB::table('recepcion as r')
                    ->join('remitente as re', 're.id_remitente', 'r.id_remitente')
                    ->join('unidad as u', 'u.id_unidad', 're.id_unidad');

        $query = !is_null($request->nombre_completo) ? $query->whereRaw("CONCAT(re.nombres_remitente, ' ', re.apellidos_remitente) LIKE ?", ["%{$request->nombre_completo}%"]) : $query;
        $query = !is_null($request->unidad) ? $query->where('u.nombre_unidad', 'like','%' . $request->unidad . '%') : $query;
        $query = !is_null($request->asunto) ? $query->where('r.asunto', 'like','%' . $request->asunto . '%') : $query;
        if(!is_null($request->fecha_i)){
            $formattedKeyword =  Carbon::createFromFormat('d/m/Y', $request->fecha_i)->format('Y-m-d');
            $query = $query->whereDate('r.fecha_recepcion', '>=', $formattedKeyword);
        }
        if(!is_null($request->fecha_f)){
            $formattedKeyword =  Carbon::createFromFormat('d/m/Y', $request->fecha_f)->format('Y-m-d');
            $query = $query->whereDate('r.fecha_recepcion', '<=', $formattedKeyword);
        }
        $query = !is_null($request->codigo) ? $query->where('r.n_oficio','like',$request->codigo . '%') : $query;

        $query->select(
            'r.estado_corresp',
            'r.id_recepcion',
            'r.asunto',
            'r.fecha_recepcion',
            DB::raw("TO_CHAR(r.fecha_recepcion, 'dd/mm/yyyy') as _fecha_recepcion"),
            'r.n_oficio',
            'r.observaciones',
            DB::raw("CONCAT(re.nombres_remitente, ' ', re.apellidos_remitente) AS remitente_completo"),
            'u.nombre_unidad'
        );

        return datatables()
            ->query($query)
            ->filterColumn('r.fecha_recepcion', function($query, $keyword) {
                $sql = "TO_CHAR(r.fecha_recepcion, 'dd/mm/yyyy') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('remitente_completo', function($query, $keyword) {
                $sql = "UPPER(CONCAT(re.nombres_remitente, ' ', re.apellidos_remitente)) like UPPER(?)";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('btn','correspondencia-local.btn')
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $recepciones = Recepcion2Model::query()
                                //->byDea(Auth::user()->dea->id)
                                ->byNombreCompleto($request->nombre_completo)
                                ->byUnidad($request->unidad)
                                ->byAsunto($request->asunto)
                                ->byEntreFechas($request->fecha_i, $request->fecha_f)
                                ->byCodigo($request->codigo)
                                ->orderBy('fecha_recepcion','desc')
                                ->orderBy('n_oficio','asc')
                                ->get();

                return Excel::download(new RecepcionVentanillaExcel($recepciones),'RecepcionVentanilla.xlsx');
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

                $recepciones = Recepcion2Model::query()
                                //->byDea(Auth::user()->dea->id)
                                ->byNombreCompleto($request->nombre_completo)
                                ->byUnidad($request->unidad)
                                ->byAsunto($request->asunto)
                                ->byEntreFechas($request->fecha_i, $request->fecha_f)
                                ->byCodigo($request->codigo)
                                ->orderBy('fecha_recepcion','desc')
                                ->orderBy('n_oficio','asc')
                                ->get();
                $cont = 1;
                $username = User::find(Auth::user()->id);
                $username = $username != null ? $username->nombre_completo : $username->name;
                $pdf = PDF::loadView('correspondencia-local.pdf',compact('recepciones','cont','username'));
                $pdf->setPaper('LETTER', 'portrait');
                return $pdf->stream();
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function create()
    {
        $date = Carbon::now();
        $date = $date->format('Y');
        $tipos = DB::table('tipoarchivo')->get();
        $anio = DB::table('anio')->get();
        return view('correspondencia-local.createRecepcion', ["tipos" => $tipos, "date" => $date, "anio" => $anio]);
    }

    public function indexUnidad(Request $request)
    {
        if ($request->ajax()) {
            $unidad = DB::table("unidad as u")->select('u.nombre_unidad');
            return Datatables::of($unidad)
                                ->addIndexColumn()
                                ->make(true);
        }

        return view('correspondencia-local.indexUnidad');
    }

    public function indexRemitente(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table("remitente as re")
                        ->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
                        ->select('re.id_remitente', 're.nombres_remitente', 're.apellidos_remitente', 're.ci_remitente', 'u.nombre_unidad');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('correspondencia-local.indexRemitente');
    }

    public function createLugar()
    {
        return view('correspondencia-local.createUnidad');
    }

    public function storeLugar(request $request)
    {
        $lugar = new UnidadModel();
        $lugar->nombre_unidad = $request->input('nombre');
        $lugar->estado_unidad = 1;
        $lugar->save();

        return redirect()->route('correspondencia.local.remitente.crear');
    }

    public function createTipo()
    {
        return view('correspondencia-local.createTipo');
    }

    public function storeTipo(request $request)
    {
        $tipo = new TipoCorresp2Model();
        $tipo->nombre_tipo = $request->input('nombre');
        $tipo->estado_tipo = 1;
        $tipo->save();

        return redirect()->route('correspondencia.local.crear');
    }

    public function createRemitente()
    {
        $unidades = DB::table("unidad")->get();
        return view('correspondencia-local.createRemitente', ["unidades" => $unidades]);
    }

    public function storeRemitente(request $request)
    {
        $remitente = new Remitente2Model();
        $remitente->nombres_remitente = $request->input('nombres');
        $remitente->apellidos_remitente = $request->input('apellidos');
        $remitente->ci_remitente = $request->input('ci');
        $remitente->id_unidad = $request->input('lugar');
        $remitente->estado_remitente = 1;
        $remitente->save();

        return redirect()->route('correspondencia.local.crear');
    }

    public function createRecepcion()
    {
        $fechaActual = date('d/m/Y');
        $newestUser = Recepcion2Model::orderBy('n_oficio', 'desc')->first();
        $maxId = $newestUser->n_oficio;
        $maxId2 = $maxId + 1;
        $hojaderuta = 0;
        $remitentes = DB::table("remitente as re")
                        ->join('unidad as u', 'u.id_unidad', 're.id_unidad')
                        ->select('re.nombres_remitente', 're.id_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
                        ->get();

        $tipos = DB::table("tipocorresp")->get();
        return view('correspondencia-local.createRecepcion', ["remitentes" => $remitentes, "tipos" => $tipos, "maxId2" => $maxId2, "hojaderuta" => $hojaderuta, "fechaActual" => $fechaActual]);
    }

    public function buscarRemitentes(Request $request)
    {
        $term = $request->get('term');
        $querys = DB::table('remitente as a')
                        ->join('unidad as b','b.id_unidad','a.id_unidad')
                        ->where('a.nombres_remitente', 'like', '%' . $term . '%')
                        ->orWhere('a.apellidos_remitente', 'like', '%' . $term . '%')
                        ->orWhere('b.nombre_unidad', 'like', '%' . $term . '%')
                        ->get();
        $data = [];
        foreach($querys as $query){
            $data[] = [
                'label' => '(' . $query->id_remitente . ') ' . $query->nombre_unidad . ' / ' . $query->nombres_remitente . ' ' . $query->apellidos_remitente
            ];
        }
        return $data;
    }

    public function storeRecepcion2(request $request)
    {

        // $newestUser = Recepcion2Model::orderBy('id_recepcion', 'desc')->first();
        // $maxId = $newestUser->id_recepcion;
        $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
        $recepcion = new Recepcion2Model();
        // $recepcion->id_recepcion = $maxId + 1;
        $recepcion->asunto = $request->input('asunto');
        $recepcion->n_oficio = $request->input('codigo');
        $recepcion->observaciones = $request->input('oficio');
        //$remitente->ci = $request->input('ci');
        $recepcion->fecha_recepcion = $fecha_recepcion;
        $recepcion->id_us = 13;
        $recepcion->id_remitente = $request->input('emp');
        $recepcion->idtipo_corresp = $request->input('tipo');
        $recepcion->confidencialidad = 0;
        $recepcion->estado_corresp = 0;
        $recepcion->estado_derivacion = 0;
        $recepcion->save();

        $archivo = new ArchivoCorrespModel();
        $archivo->id_recepcion = $recepcion->id_recepcion;
        $archivo->documento = $recepcion->id_recepcion;
        $archivo->save();

        return redirect()->route('correspondencia.local.index');
    }

    public function storeRecepcion(Request $request)
    {
        $cadena = $request->emp;
        if (preg_match('/\((\d+)\)/', $cadena, $matches)) {
            $emp = $matches[1];
        } else {
            return redirect()->back()->with('error_message','[Ocurrio un Error en el registro.]')->withInput();
        }

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $fecha_gestion = substr($request->fecha, 6, 4);
        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = "pdf_" . time() . "." . $file->guessExtension();
                $ruta = public_path("/documentos_correspondencia/" . '/' . $nombre);
                if ($file->guessExtension() == "pdf") {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }

            $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
            $recepcion = new Recepcion2Model();
            $recepcion->asunto = $request->input('asunto');
            $recepcion->n_oficio = $request->input('codigo');
            $recepcion->observaciones = $request->input('oficio');
            $recepcion->fecha_recepcion = $fecha_recepcion;
            $recepcion->id_us = $id;
            $recepcion->id_remitente = $emp;
            $recepcion->idtipo_corresp = $request->input('tipo');
            $recepcion->confidencialidad = 0;
            $recepcion->estado_corresp = 1;
            $recepcion->estado_derivacion = 0;
            $recepcion->save();

            $archivo = new ArchivoCorrespModel();
            $archivo->id_recepcion = $recepcion->id_recepcion;
            $archivo->documento = $nombre;
            $archivo->estado_envio = 1;
            $archivo->save();

            $url = 'https://sistemas.granchaco.gob.bo/correspondencia-local/urlfile/' . $recepcion->id_recepcion;
            $qr = QrCode::format('png')->margin(0)->size(300)->generate($url, public_path() . '/documentos_correspondencia/qr/' . $recepcion->id_recepcion . '.png');
        } else {
            $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
            $recepcion = new Recepcion2Model();
            $recepcion->asunto = $request->input('asunto');
            $recepcion->n_oficio = $request->input('codigo');
            $recepcion->observaciones = $request->input('oficio');
            $recepcion->fecha_recepcion = $fecha_recepcion;
            $recepcion->id_us = $id;
            $recepcion->id_remitente = $emp;
            $recepcion->idtipo_corresp = $request->input('tipo');
            $recepcion->confidencialidad = 0;
            $recepcion->estado_corresp = 0;
            $recepcion->estado_derivacion = 0;
            $recepcion->save();
        }

        return redirect()->route('correspondencia.local.index')->with('success_message', '[Registro creado correctamente...]');
    }

    public function editarCodigo($idrecepcion)
    {
        $recepcion = Recepcion2Model::find($idrecepcion);
        $remitentes = DB::table("remitente as re")
                        ->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
                        ->select('re.nombres_remitente', 're.id_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
                        ->get();
        $fecha_d_m_y = date("d/m/Y", strtotime($recepcion->fecha_recepcion));
        $tipos = DB::table("tipocorresp")->get();;
        return view('correspondencia-local.edit', ["recepcion" => $recepcion, "tipos" => $tipos, "remitentes" => $remitentes, "fecha_d_m_y" => $fecha_d_m_y]);
    }



    public function updateCodigo(Request $request, $idRecepcion)
    {

        $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

        $recepcion = Recepcion2Model::find($idRecepcion);
        $recepcion->n_oficio = $request->input('codigo');
        $recepcion->observaciones = $request->input('hojaruta');
        $recepcion->fecha_recepcion = $fecha_recepcion;
        $recepcion->id_remitente = $request->input('emp');
        $recepcion->asunto = $request->input('asunto');

        if ($recepcion->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        //return redirect()->route('correspondencia.local.index');
        return redirect()->route('correspondencia.local.gestionar', $idRecepcion);
    }

    public function gestionarCorrespondencia($idrecepcion)
    {
        $recepcion = Recepcion2Model::find($idrecepcion);
        $data = DB::table('recepcion as r')
                    ->join('remitente as re', 're.id_remitente', 'r.id_remitente')
                    ->join('unidad as u', 'u.id_unidad', 're.id_unidad')
                    ->select('r.estado_corresp', 'r.id_recepcion', 'r.asunto', 'r.fecha_recepcion', 'r.n_oficio', 'r.observaciones', 're.nombres_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
                    ->where('r.id_recepcion', $recepcion->id_recepcion)
                    ->first();

        return view('correspondencia-local.gestionarCorrespondencia', ["data" => $data]);
    }



    public function cargarpdf($idrecepcion)

    {

        return view('correspondencia-local.cargarpdf', ["idrecepcion" => $idrecepcion]);
    }


    public function storepdf(Request $request)
    {
        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/documentos_correspondencia/" . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }
       // dd($request->input('idrecepcion'));
        $archivos = new ArchivoCorrespModel();
        $archivos->id_recepcion = $request->input('idrecepcion');
        $archivos->documento = $nombre;
        $archivos->estado_envio = 1;
        $archivos->save();

        $recepcion = Recepcion2Model::find($request->input('idrecepcion'));
        $recepcion->estado_corresp = 1;
        $recepcion->save();
        return redirect()->route('correspondencia.local.gestionar', $request->input('idrecepcion'));
    }

    public function actualizarpdf($idrecepcion)
    {
        return view('correspondencia-local.updatepdf', ["idrecepcion" => $idrecepcion]);
    }

    public function notificacion()

    {
        return view('correspondencia-local.notificacion');
    }



    public function updatepdf(Request $request)
    {
        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/documentos_correspondencia/" . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }

        $data = DB::table('recepcion as r')
                    ->join('archivocorresp as a', 'a.id_recepcion', '=', 'r.id_recepcion')
                    ->select('a.id_archivo', 'r.id_recepcion')
                    ->where('r.id_recepcion', $request->input('idrecepcion'))
                    ->first();

        $archivos = ArchivoCorrespModel::find($data->id_archivo);
        $archivos->id_recepcion = $request->input('idrecepcion');
        $archivos->documento = $nombre;
        $archivos->estado_envio = 1;
        $archivos->save();

        $recepcion = Recepcion2Model::find($request->input('idrecepcion'));
        $recepcion->estado_corresp = 1;
        $recepcion->save();
        return redirect()->route('correspondencia.local.gestionar', $request->input('idrecepcion'));
    }



    public function derivar($idrecepcion)
    {
        $area = DB::table('areas  as a')
                    ->select('a.idarea', 'a.nombrearea')
                    ->orderBy('a.idarea', 'desc')
                    ->get();



        $derivacionCorresp = DB::table('deriv_corresp  as d')
                                ->join('areas as ar', 'ar.idarea', 'd.idarea')
                                ->join('instruccion as i', 'i.idinstruccion', 'd.idinstruccion')
                                ->join('recepcion as r', 'r.id_recepcion', 'd.id_recepcion')
                                ->select('r.id_recepcion', 'd.idderivacion', 'd.created_at', 'd.fechaderivacion', 'ar.nombrearea','i.nombreinstruccion')
                                ->where('d.id_recepcion', '=', $idrecepcion)
                                ->get();

        $instruccion = DB::table('instruccion  as i')
                            ->select('i.idinstruccion', 'i.nombreinstruccion')
                            ->get();

        return view('correspondencia-local.derivar', ["instruccion" => $instruccion,"idrecepcion" => $idrecepcion, "area" => $area, "derivacionCorresp" => $derivacionCorresp]);
    }

    public function guardarderivacion(request $request)
    {

        $fechaActual = date('d/m/Y');
        // $newestUser = TipoArchivo::orderBy('idtipo', 'desc')->first();
        //$maxId = $newestUser->idtipo;
        // for ($i = 1; $i <= 10000; $i++) {
        $deriv = new DerivCorrespModel();
        $deriv->fechaderivacion = $fechaActual;
        $deriv->idarea = $request->input('tipo');
        $deriv->idinstruccion = $request->input('tipo2');
        $deriv->id_recepcion = $request->input('idrecepcion');
        $deriv->estadoderiv1 = 1;
        $deriv->estadoderiv2 = 1;

        $detallito = DB::table('deriv_corresp  as d')
            ->join('areas as ar', 'ar.idarea', '=', 'd.idarea')
            ->join('recepcion as r', 'r.id_recepcion', '=', 'd.id_recepcion')
            ->select('r.id_recepcion', 'd.idderivacion', 'ar.nombrearea')
            ->where('ar.idarea', '=', $request->input('tipo'))
            ->where('r.id_recepcion', '=', $request->input('idrecepcion'))
            ->orderBy('d.idderivacion', 'desc')
            ->get();
        //dd($detallito);

        if ($detallito->isEmpty()) {
            $deriv->save();
            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }

        //$tipos->estadoumedida = 1;

        // }
        // return redirect()->route('archivos2.tipo');




        return redirect()->route('correspondencia.local.derivar', $request->input('idrecepcion'));
    }


    public function delete($idderivacion)
    {
        $derivacion = DerivCorrespModel::find($idderivacion);
        $idrecepcion = $derivacion->id_recepcion;
        $derivacion->delete();

        return redirect()->route('correspondencia.local.derivar', $idrecepcion);
    }


    public function urlfile($recepcion_id)
    {
        $data = DB::table('archivocorresp as a')
                        ->join('recepcion as r', 'r.id_recepcion', 'a.id_recepcion')
                        ->select('r.id_recepcion', 'a.documento')
                        ->where('r.id_recepcion', $recepcion_id)
                        ->first();

        $url = 'documentos_correspondencia/' . $data->documento;

        return redirect()->to(url($url));
    }

    public function generar_qr($recepcion_id)
    {
        $url = 'documentos_correspondencia/qr/' . $recepcion_id . '.png';
        return redirect()->to(url($url));
    }

    public function indexderivacion()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
//dd($personalArea ->idarea);
      $data = DerivCorrespModel::query()
     ->where('idarea', $personalArea->idarea)
      ->orderBy('idderivacion', 'desc')
      ->paginate(10);
      //$data2=1000;
      return view('derivacion.index', compact('data'));

    }

        ///////////////// GESTIONAR CORRESPONDENCIA 2 ///////////////

        public function gestionarCorrespondencia2($idderivacion)
        {
            $derivacion = DerivCorrespModel::find($idderivacion);

            $data = DB::table('recepcion as r')
                ->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
                ->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
                ->select('r.estado_corresp', 'r.id_recepcion', 'r.asunto', 'r.fecha_recepcion', 'r.n_oficio', 'r.observaciones', 're.nombres_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
                ->where('r.id_recepcion', $derivacion->id_recepcion)
                ->first();

       // dd($data);
            //return view('correspondencia2/gestionarCorrespondencia')->with('data', $data);
           // return view('derivacion.gestionarCorrespondencia');
           return view('derivacion.gestionarCorrespondencia', ["data" => $data]);
        }


        public function urlfilederivacion($recepcion_id)
        {
            // $file = ThesisFile::where('thesis_id',$thesis_id)->where('state',1)->first();
            // return response()->json(['response' => [
            // 'url' => $file->url,
            // 'name' => $file->name,
            // ]
            // ], 201);

            $data = DB::table('archivocorresp as a')
                ->join('recepcion as r', 'r.id_recepcion', '=', 'a.id_recepcion')
                //->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
                ->select('r.id_recepcion', 'a.documento')
                ->where('r.id_recepcion', $recepcion_id)
                ->first();

            //dd($data->documento);

            $redirect = '../public/documentos_correspondencia/';
            // return Redirect::to($redirect);
            //return Redirect::to($redirect)->with('_blank');
            return redirect()->to($redirect . $data->documento);
        }

        public function pregunta()
        {
            //$personal = User::find(Auth::user()->id);
            //$id = $personal->id;
            //$userdate = User::find($id)->usuariosempleados;
           // $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

            //$dataderivacion = DB::table('derivCorresp as d')
            //->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
            //->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
            //->select('d.idarea','d.idderivacion','d.estadoderiv1')
          //->where('d.idarea', $personalArea->idarea)
          // ->where('d.estadoderiv1', 1)

          //  ;

       // dd($personalArea->idarea);

           // if ($request->ajax()) {

              //  $noti = 1;

                //return response()->json($noti);
              // return response()->json(['dataderivacion' => $dataderivacion]);
           // }


          // $proyecto = Proyecto::where('empresa_id',$id)->pluck('name','id');
          // if($dataderivacion->count()>0){
             //  return $dataderivacion;
          // }

           //else return response()->json(['error'=>'Algo Salio Mal']);

          // $user = User::find($id);
          $a=1;
           if($id === 1) {
                   //$user->delete();
                   return response(json)->response([
                    'success'=>"Record deleted."
                   ]);
           }
           else{
            return response(json)->response([
                'error' => "You can not delete this"
            ], 400); // 400 means bad request
        }

        }

        public function nombreDelMetodo2(Request $request)
        {
            // Procesa los datos recibidos
            // ...

            // Devuelve una respuesta
            return response()->json(['mensajes' => 'Petición procesada']);
        }

        public function respuesta(Request $request)
        {

            if ($request->ajax()) {
                $personal = User::find(Auth::user()->id);
                $id = $personal->id;
                $userdate = User::find($id)->usuariosempleados;
                $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

                $dataderivacion = DB::table('deriv_corresp as d')
                //->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
                ->join('areas as a', 'a.idarea', '=', 'd.idarea')
                ->select('d.idarea','d.idderivacion','d.estadoderiv1')
               ->where('d.idarea', $personalArea->idarea)
              ->where('d.estadoderiv1', 1)

                ->get();


                $data = "hola";
                $data2 = "holaSSSS";
               // return ['success' => true, 'data' => $data];

                if($dataderivacion->count()>0){
                    return ['success' => true, 'data' => $data];
                } else  return ['success' => false, 'data' => $data2];


        }
    }
}
