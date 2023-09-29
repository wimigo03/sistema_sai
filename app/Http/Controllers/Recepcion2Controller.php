<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\RecepcionModel;
use App\Models\Recepcion2Model;
use App\Models\TipoCorresp2Model;
use App\Models\RemitenteModel;
use App\Models\Remitente2Model;
use App\Models\UnidadModel;
use App\Models\ArchivoCorrespModel;
use App\Models\DerivCorrespModel;

use App\Models\AnioModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use DataTables;

class Recepcion2Controller extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            // $data = DB::connection('pgsql_correspondencia')->table("recepcion as r")
            $data = DB::table('recepcion as r')
                ->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
                ->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
                ->select('r.estado_corresp', 'r.id_recepcion', 'r.asunto', 'r.fecha_recepcion', 'r.n_oficio', 'r.observaciones', 're.nombres_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
                ->orderBy('r.id_recepcion', 'desc');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn', 'correspondencia2.btn')
                ->addColumn('btn3', function ($data) {

                    if ($data->estado_corresp == 0) {
                        return view('correspondencia2.btn4', compact('data'));
                    }
                    if ($data->estado_corresp == 1) {
                        return view('correspondencia2.btn3', compact('data'));
                    }
                })

                ->rawColumns(['btn'])
                ->make(true);

            //dd($data);
        }

        return view('correspondencia2.index');
    }


    public function create()

    {



        $date = Carbon::now();

        $date = $date->format('Y');


        $tipos = DB::table('tipoarchivo')->get();
        $anio = DB::table('anio')->get();
        return view('correspondencia2.createRecepcion', ["tipos" => $tipos, "date" => $date, "anio" => $anio]);
    }


    /////////// LISTA UNIDAD ///////////

    public function indexUnidad(Request $request)
    {

        if ($request->ajax()) {

            $unidad = DB::table("unidad as u")

                ->select('u.nombre_unidad');

            return Datatables::of($unidad)
                ->addIndexColumn()
                ->make(true);
        }

        return view('correspondencia2.indexUnidad');
    }


    //////////// LISTA REMITENTE //////////

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

        return view('correspondencia2.indexRemitente');
    }


    ////////////////CREAR AREA //////////////

    public function createLugar()
    {
        return view('correspondencia2.createUnidad');
    }

    public function storeLugar(request $request)
    {

        //$newestUser = UnidadModel::orderBy('id_unidad', 'desc')->first();
        // $maxId = $newestUser->id_unidad;

        $lugar = new UnidadModel();
        //$lugar->id_unidad = $maxId + 1;
        $lugar->nombre_unidad = $request->input('nombre');
        $lugar->estado_unidad = 1;
        $lugar->save();

        return redirect()->route('crear2.remitente');
    }


    ////////////////CREAR TIPO CORRESPONDENCIA //////////////

    public function createTipo()
    {
        return view('correspondencia2.createTipo');
    }

    public function storeTipo(request $request)
    {

        //$newestUser = UnidadModel::orderBy('id_unidad', 'desc')->first();
        // $maxId = $newestUser->id_unidad;

        $tipo = new TipoCorresp2Model();
        //$lugar->id_unidad = $maxId + 1;
        $tipo->nombre_tipo = $request->input('nombre');
        $tipo->estado_tipo = 1;
        $tipo->save();

        return redirect()->route('crear2.recepcion');
    }

    ////////////////// CREAR REMITENTE ////////////

    public function createRemitente()
    {

        $unidades = DB::table("unidad")->get();
        return view('correspondencia2.createRemitente', ["unidades" => $unidades]);
    }

    public function storeRemitente(request $request)
    {

        //$newestUser = Remitente2Model::orderBy('id_remitente', 'desc')->first();
        //$maxId = $newestUser->id_remitente;

        $remitente = new Remitente2Model();
        //
        //  $remitente->id_remitente = $maxId + 1;
        $remitente->nombres_remitente = $request->input('nombres');
        $remitente->apellidos_remitente = $request->input('apellidos');
        //$remitente->ap_mat = $request->input('apMat');
        $remitente->ci_remitente = $request->input('ci');
        $remitente->id_unidad = $request->input('lugar');
        $remitente->estado_remitente = 1;
        //$remitente->estado_envio = 0;
        //$remitente->estado_u = 0;
        $remitente->save();

        return redirect()->route('crear2.recepcion');
    }



    ///////////// CREAR RECEPCION ////////////////

    public function createRecepcion()
    {
        $fechaActual = date('d/m/Y');

        $newestUser = Recepcion2Model::orderBy('n_oficio', 'desc')->first();
        $maxId = $newestUser->n_oficio;
        $maxId2 = $maxId + 1;
        $hojaderuta = 0;
        //dd($maxId2);
        $remitentes = DB::table("remitente as re")

            // ->join('empleados as e', 'e.id_emp', '=', 'r.id_emp')
            ->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
            ->select('re.nombres_remitente', 're.id_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
            //->limit(5)
            ->get();

        $tipos = DB::table("tipocorresp")->get();


        //$empleados = DB::connection('pgsql_correspondencia')->table("empleados")->get();
        return view('correspondencia2.createRecepcion', ["remitentes" => $remitentes, "tipos" => $tipos, "maxId2" => $maxId2, "hojaderuta" => $hojaderuta, "fechaActual" => $fechaActual]);
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

        return redirect()->route('recepcion2.index');
    }

    public function storeRecepcion(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        // $userdate = User::find($id)->usuariosempleados;
        // $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        //$fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

        $fecha_gestion = substr($request->fecha, 6, 4);

        //$archivos = ArchivosModel::find($idarchivo);
        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = "pdf_" . time() . "." . $file->guessExtension();

                $ruta = public_path("/Documentos_Correspondencia/" . '/' . $nombre);

                if ($file->guessExtension() == "pdf") {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }


            $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
            $recepcion = new Recepcion2Model();
            // $recepcion->id_recepcion = $maxId + 1;
            $recepcion->asunto = $request->input('asunto');
            $recepcion->n_oficio = $request->input('codigo');
            $recepcion->observaciones = $request->input('oficio');
            //$remitente->ci = $request->input('ci');
            $recepcion->fecha_recepcion = $fecha_recepcion;
            $recepcion->id_us = $id;
            $recepcion->id_remitente = $request->input('emp');
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
        } else {
            $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
            $recepcion = new Recepcion2Model();
            // $recepcion->id_recepcion = $maxId + 1;
            $recepcion->asunto = $request->input('asunto');
            $recepcion->n_oficio = $request->input('codigo');
            $recepcion->observaciones = $request->input('oficio');
            //$remitente->ci = $request->input('ci');
            $recepcion->fecha_recepcion = $fecha_recepcion;
            $recepcion->id_us = $id;
            $recepcion->id_remitente = $request->input('emp');
            $recepcion->idtipo_corresp = $request->input('tipo');
            $recepcion->confidencialidad = 0;
            $recepcion->estado_corresp = 0;
            $recepcion->estado_derivacion = 0;
            $recepcion->save();
        }

        return redirect()->route('recepcion2.index');
    }

    ///////////////// EDITAR CODIGO ///////////////////////////////////

    public function editarCodigo($idrecepcion)
    {
        $recepcion = Recepcion2Model::find($idrecepcion);
        $remitentes = DB::table("remitente as re")

            // ->join('empleados as e', 'e.id_emp', '=', 'r.id_emp')
            ->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
            ->select('re.nombres_remitente', 're.id_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
            //->limit(5)
            ->get();
        // $fechaActual = date('d/m/Y');
        // $date = str_replace('/', '-', $request->stockupdate);
        $fecha_d_m_y = date("d/m/Y", strtotime($recepcion->fecha_recepcion));

        $tipos = DB::table("tipocorresp")->get();
        //dd($recepcion);
        //return view('correspondencia2/edit')->with('recepcion', $recepcion);
        return view('correspondencia2/edit', ["recepcion" => $recepcion, "tipos" => $tipos, "remitentes" => $remitentes, "fecha_d_m_y" => $fecha_d_m_y]);
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
        //return redirect()->route('recepcion2.index');
        return redirect()->route('correspondencia2.gestionar', $idRecepcion);
    }



    ///////////////// GESTIONAR CORRESPONDENCIA ///////////////

    public function gestionarCorrespondencia($idrecepcion)
    {
        $recepcion = Recepcion2Model::find($idrecepcion);

        $data = DB::table('recepcion as r')
            ->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
            ->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
            ->select('r.estado_corresp', 'r.id_recepcion', 'r.asunto', 'r.fecha_recepcion', 'r.n_oficio', 'r.observaciones', 're.nombres_remitente', 're.apellidos_remitente', 'u.nombre_unidad')
            ->where('r.id_recepcion', $recepcion->id_recepcion)
            ->first();

        //dd($data->id_recepcion);
        //return view('correspondencia2/gestionarCorrespondencia')->with('data', $data);
        return view('correspondencia2.gestionarCorrespondencia', ["data" => $data]);
    }



    public function cargarpdf($idrecepcion)

    {

        return view('correspondencia2.cargarpdf', ["idrecepcion" => $idrecepcion]);
    }


    public function storepdf(Request $request)
    {


        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/Documentos_Correspondencia/" . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }

        $archivos = new ArchivoCorrespModel();
        $archivos->id_recepcion = $request->input('idrecepcion');
        $archivos->documento = $nombre;
        $archivos->estado_envio = 1;
        $archivos->save();

        $recepcion = Recepcion2Model::find($request->input('idrecepcion'));
        $recepcion->estado_corresp = 1;
        $recepcion->save();
        return redirect()->route('correspondencia2.gestionar', $request->input('idrecepcion'));
    }

    public function actualizarpdf($idrecepcion)

    {
        return view('correspondencia2.updatepdf', ["idrecepcion" => $idrecepcion]);
    }

    public function notificacion()

    {
        return view('correspondencia2.notificacion');
    }



    public function updatepdf(Request $request)
    {


        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/Documentos_Correspondencia/" . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }

        $data = DB::table('recepcion as r')
            ->join('archivocorresp as a', 'a.id_recepcion', '=', 'r.id_recepcion')
            //->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
            ->select('a.id_archivo', 'r.id_recepcion')
            ->where('r.id_recepcion', $request->input('idrecepcion'))
            ->first();

        $archivos = ArchivoCorrespModel::find($data->id_archivo);
        // $archivos = new ArchivoCorrespModel();
        $archivos->id_recepcion = $request->input('idrecepcion');
        $archivos->documento = $nombre;
        $archivos->estado_envio = 1;
        $archivos->save();

        $recepcion = Recepcion2Model::find($request->input('idrecepcion'));
        $recepcion->estado_corresp = 1;
        $recepcion->save();
        return redirect()->route('correspondencia2.gestionar', $request->input('idrecepcion'));
    }



    public function derivar($idrecepcion)

    {
        $area = DB::table('areas  as a')
            // ->join('areas as ar', 'ar.idarea', '=', 'tt.idarea')
            // ->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
            ->select('a.idarea', 'a.nombrearea')
            //  ->where('tt.idarea','=', $personalArea->idarea)
            ->orderBy('a.idarea', 'desc')
            ->get();

        $derivacionCorresp = DB::table('derivCorresp  as d')
            ->join('areas as ar', 'ar.idarea', '=', 'd.idarea')
            ->join('recepcion as r', 'r.id_recepcion', '=', 'd.id_recepcion')
            ->select('r.id_recepcion', 'd.idderivacion', 'ar.nombrearea')
            ->where('d.id_recepcion', '=', $idrecepcion)
            // ->orderBy('d.idderivacion', 'desc')
            ->get();

        //dd($dervacionCorresp);
        return view('correspondencia2.derivar', ["idrecepcion" => $idrecepcion, "area" => $area, "derivacionCorresp" => $derivacionCorresp]);
    }

    public function guardarderivacion(request $request)
    {

        $fechaActual = date('d/m/Y');
        // $newestUser = TiposModel::orderBy('idtipo', 'desc')->first();
        //$maxId = $newestUser->idtipo;
        // for ($i = 1; $i <= 10000; $i++) {
        $deriv = new DerivCorrespModel();
        $deriv->fechaderivacion = $fechaActual;
        $deriv->idarea = $request->input('tipo');
        $deriv->id_recepcion = $request->input('idrecepcion');
        $deriv->estadoderiv1 = 1;
        $deriv->estadoderiv2 = 1;

        $detallito = DB::table('derivCorresp  as d')
            ->join('areas as ar', 'ar.idarea', '=', 'd.idarea')
            ->join('recepcion as r', 'r.id_recepcion', '=', 'd.id_recepcion')
            ->select('r.id_recepcion', 'd.idderivacion', 'ar.nombrearea')
            ->where('ar.idarea', '=', $request->input('tipo'))
            ->where('r.id_recepcion', '=', $request->input('id_recepcion'))
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




        return redirect()->route('correspondencia2.derivar', $request->input('idrecepcion'));
    }


    public function delete($idderivacion)
    {
        $derivacion = DerivCorrespModel::find($idderivacion);
        $idrecepcion = $derivacion->id_recepcion;
        $derivacion->delete();

        return redirect()->route('correspondencia2.derivar', $idrecepcion);
    }


    public function urlfile($recepcion_id)
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

        $redirect = '../public/Documentos_Correspondencia/';
        // return Redirect::to($redirect);
        //return Redirect::to($redirect)->with('_blank');
        return redirect()->to($redirect . $data->documento);
    }





    public function indexderivacion()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
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
                ->where('r.id_recepcion', $derivacion->idderivacion)
                ->first();

            //dd($data->id_recepcion);
            //return view('correspondencia2/gestionarCorrespondencia')->with('data', $data);
            return view('derivacion.gestionarCorrespondencia');
        }

}
