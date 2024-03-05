<?php

namespace App\Http\Controllers\Fexpo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\RubroModel;
use App\Models\Fexpo\CredencialModel;
use DB;
use App\Models\Fexpo\SolicitudModel;
use Carbon\Carbon;
use DataTables;

use NumerosEnLetras;
use PDF;

use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\TipoAreaModel;
use App\Models\AnioModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class SolicitudController extends Controller
{

    public function index(Request $request){

       //
        if ($request->ajax()) {

        $solicitud = DB::table('solicitud as s')

                        // ->join('rubros as r', 'r.idrubro', '=', 's.idrubro')


                        ->where('s.estadosolicitud',1)

                        ->select('s.idsolicitud','s.fechasolicitud','s.ci','s.nombresolicitud','s.asociacionsol','s.telefonosol','s.correosol')
                        ->orderBy('s.fechasolicitud', 'desc');

                        return Datatables::of($solicitud)
                        ->addIndexColumn()
                        ->addColumn('btn', 'expochaco.btn')
                        ->addColumn('btn2', 'expochaco.btn2')
                        ->addColumn('btn3', 'expochaco.btn3')
                        ->rawColumns(['btn','btn2','btn3'])
                        ->make(true);

                    }

            return view('expochaco.index');
    }



    public function index2(Request $request){
        if ($request->ajax()) {

        $solicitud = DB::table('solicitud as s')

                        // ->join('rubros as r', 'r.idrubro', '=', 's.idrubro')


                        ->where('s.estadosolicitud',2)

                        ->select('s.idsolicitud','s.ci','s.nombresolicitud','s.asociacionsol','s.telefonosol','s.correosol','s.ciudad')
                        ->orderBy('s.idsolicitud', 'asc');

                        return Datatables::of($solicitud)
                        ->addIndexColumn()
                        ->addColumn('btn', 'expochaco.btn')
                        //->addColumn('btn2', 'expochaco.btn2')
                        ->addColumn('btn4', 'expochaco.btn4')
                        ->addColumn('btn5', 'expochaco.btn5')
                        ->rawColumns(['btn','btn4','btn5'])
                        ->make(true);
                    }

            return view('expochaco.index2');
    }

    public function create(){
        $rubros = DB::table('rubro as r')
            //->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
            // ->join('areas as a', 'a.idarea', '=', 'd.idarea')
            ->select('r.idrubro', 'r.nombrerubro')
            //->where('d.idarea', $personalArea->idarea)
            //->where('d.estadoderiv1', 1)

            ->get();


        return view('expochaco.create', ["rubros" => $rubros]);

       // return view('expochaco.create');
    }


    public function store(Request $request){

        $solicitud = new SolicitudModel();

        $solicitud->nombresolicitud = $request->input('nombresolicitud');
        $solicitud->asociacionsol = $request->input('asociacionsol');
        $date = Carbon::now();
        $solicitud->ci = $request->input('ci');

        $solicitud->direccionsol = $request->input('direccionsol');
        $solicitud->telefonosol = $request->input('telefonosol');
        $solicitud->correosol = $request->input('correosol');
        $solicitud->idrubro = $request->input('idrubro');
        $solicitud->correosol = $request->input('correosol');
        $solicitud->fechasolicitud = $date;
        $solicitud->pabellon = $request->input('pabellon');
        $solicitud->superficie = $request->input('superficie');
        $solicitud->precio = $request->input('precio');
        $solicitud->representante = $request->input('representante');
        $solicitud->stand = $request->input('cantidad');
        $solicitud->total = $request->input('cantidad') * $request->input('precio');
        $solicitud->unidsep = $request->input('unidsep');
        $solicitud->representante = $request->input('representante');
        $solicitud->cirepresentante = $request->input('cirepresentante');
        $solicitud->asociacionotros = $request->input('otros');
        $solicitud->ciudad = $request->input('ciudad');

        $solicitud->estadosolicitud = 1;

        if($solicitud->save()){
            $request->flash('message', 'Registro Procesado');
            return view('expochaco.fin');
        }else{
            $request->flash('message', 'Error al Procesar Registro');
        }

    }


    public function editar($idsolicitud){
        $solicitud = SolicitudModel::find($idsolicitud);
        $rubros = DB::table('rubro as r')
        ->select('r.idrubro', 'r.nombrerubro')

        ->get();


        return view('expochaco.editar', ['solicitud' => $solicitud, 'rubros' => $rubros]);
       // return view('expochaco.editar',compact('solicitud,rubros'));
    }

    public function update(Request $request){



        $solicitud = SolicitudModel::find($request->idsolicitud);

        //////////////

        $solicitud->nombresolicitud = $request->input('nombresolicitud');
        $solicitud->asociacionsol = $request->input('asociacionsol');
        $date = Carbon::now();
        $solicitud->ci = $request->input('ci');

        $solicitud->direccionsol = $request->input('direccionsol');
        $solicitud->telefonosol = $request->input('telefonosol');
        $solicitud->correosol = $request->input('correosol');
        $solicitud->idrubro = $request->input('idrubro');
        $solicitud->correosol = $request->input('correosol');
        $solicitud->fechasolicitud = $date;
        $solicitud->pabellon = $request->input('pabellon');
        $solicitud->superficie = $request->input('superficie');
        $solicitud->precio = $request->input('precio');
        $solicitud->representante = $request->input('representante');
        $solicitud->stand = $request->input('cantidad');
        $solicitud->total = $request->input('cantidad') * $request->input('precio');
        $solicitud->unidsep = $request->input('unidsep');
        $solicitud->representante = $request->input('representante');
        $solicitud->cirepresentante = $request->input('cirepresentante');
        $solicitud->asociacionotros = $request->input('otros');
        $solicitud->nstand = $request->input('nstand');
        $solicitud->recibonombre = $request->input('nombrerecibo');
        $solicitud->reciboci = $request->input('cirecibo');
        $solicitud->ciudad = $request->input('ciudad');

        //$solicitud->estadosolicitud = 1;
        ///////


        if($solicitud->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('expochaco.index');
    }


    public function delete($id)
    {
        $solicitud = SolicitudModel::find($id);
        $solicitud->delete();

        return redirect()->route('expochaco.index');
    }

    public function aprovar($id)
    {


        $solicitud = SolicitudModel::find($id);
        $solicitud->estadosolicitud = 2;
        $solicitud->save();



        return redirect()->route('expochaco.index');


    }

    public function respuesta2(Request $request)
    {


        $ot_antigua=$_POST['ot_antigua'];

            $data = "hola";
            $data2 = "holaSSSS";

            $validarci = DB::table('solicitud as s')
            //->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
            //->join('areas as a', 'a.idarea', '=', 'd.idarea')
            ->select('s.ci')
           ->where('s.ci', $ot_antigua)
          //->where('d.estadoderiv1', 1)

            ->get();
           // return ['success' => true, 'data' => $data];

               if($validarci->count()>0){
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];


    }


    public function imprimirboleta($idsolicitud)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $solicitud = DB::table('solicitud as s')
            ->join('rubro as r', 'r.idrubro', '=', 's.idrubro')
            ->where('s.estadosolicitud',2)
            ->where('s.idsolicitud',$idsolicitud)
            ->select('s.idsolicitud','s.ci','s.nombresolicitud','s.asociacionsol','s.telefonosol','s.correosol',
            's.direccionsol','s.representante','s.pabellon','s.stand','s.superficie',
            's.precio','s.total','s.recibonombre','s.reciboci','s.cirepresentante','s.nstand','s.ciudad','r.nombrerubro')
            ->orderBy('s.idsolicitud', 'asc')
            ->first();

//dd($solicitud);

            $pdf = PDF::loadView('expochaco.pdf-expo', compact(['solicitud']));
            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('compras.detalle.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }

        // return view('compras.detalle.invitacion',['ordencompra'=>$ordencompra,'ordendoc'=>$ordendoc,'responsables'=>$responsables,'fechaInvitacion'=>$fechaInvitacion,'fechaAceptacion'=>$fechaAceptacion]);
    }


    ////credenciales///

    public function credencial($idsolicitud){
       // $solicitud = SolicitudModel::find($idsolicitud)->first();

        $solicitud = SolicitudModel::where('idsolicitud',$idsolicitud)->firstOrFail();

        $credenciales = DB::table('credenciales as c')
        ->join('solicitud as s', 's.idsolicitud', '=', 'c.idsolicitud')
        // ->join('areas as a', 'a.idarea', '=', 'd.idarea')
        ->select('c.idcredencial','c.nombres', 'c.ci', 'c.stand', 'c.foto')
        ->where('s.idsolicitud', $idsolicitud)
        //->where('d.estadoderiv1', 1)

        ->paginate(10);

//dd($credenciales);
       return view('expochaco.credencial', ["credenciales" => $credenciales,"idsolicitud" => $idsolicitud,"solicitud" => $solicitud]);


       // return view('expochaco.create');
    }


    public function createcredencial($idsolicitud){



        return view('expochaco.createcredencial', ["idsolicitud" => $idsolicitud]);

       // return view('expochaco.create');
    }


    public function insertarcredencial(Request $request)
    {
        try{
         ini_set('memory_limit','-1');
        ini_set('max_execution_time','-1');

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

        $fecha_gestion = substr($request->fecha, 6, 4);


        $solicitud = SolicitudModel::find($request->idsolicitud);

        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "jpg_" . time() . "." . $file->guessExtension();

            $ruta = public_path("credenciales/" . $nombre);

            if ($file->guessExtension() == "jpg") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }

        //for ($i = 1; $i <= 3000; $i++) {


        //$nombre2='hola';
        $credenciales = new CredencialModel();
        $credenciales->nombres = $request->input('nombres');
        $credenciales->ci = $request->input('ci');
        $credenciales->stand = $request->input('stand');
        $credenciales->foto = 'credenciales/' . $nombre;
        $credenciales->idsolicitud = $request->input('idsolicitud');
        $credenciales->estado = 1;

        $credenciales->save();
        // }

        //return to_route('expochaco.credencial', [$idsolicitud]);
        //return redirect()->route('expochaco.credencial', $idsolicitud);
       // return redirect()->action('App\Http\Controllers\ArchivosController2@index');
               // return redirect()->action('App\Http\Controllers\Fexpo\SolicitudController@credencial', [$idsolicitud]);
                //return view('expochaco.create');
                return redirect()->action('\App\Http\Controllers\Fexpo\SolicitudController@credencial', [$request->idsolicitud]);
        } catch (\Throwable $th){
         return '[ERROR_500]';
        }finally{
        ini_restore('memory_limit');
        ini_restore('max_execution_time');
        //return redirect()->action('App\Http\Controllers\Fexpo\SolicitudController@credencial', [$idsolicitud]);
         }
    }

    public function codigoqr($idcredencial){


       // $credencial = CredencialModel::where('idcredencial',$idcredencial)->firstOrFail();

        $credencial = CredencialModel::take(10)->get();

       // $credencial = DB::table('credenciales as c')
            //->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
            // ->join('areas as a', 'a.idarea', '=', 'd.idarea')
          //  ->select('c.idcredencial', 'c.nombres', 'c.ci', 'c.stand', 'c.foto')
           // ->where('c.idsolicitud', $idsolicitud)
            //->where('d.estadoderiv1', 1)

           /// ->first();
          // $ruta='https://ybasai.com/expochaco/generarqr/'.$credencial->idcredencial;
          //dd( $credencial);
      //  return view('expochaco.generarqr', ["credencial" => $credencial,"ruta" => $ruta]);

        $pdf = PDF::loadView('expochaco.generarqr', compact(['credencial']));
       // $pdf->setPaper('LEGAL', 'portrait'); //landscape
        return $pdf->stream();

       // return view('expochaco.create');
    }



    public function reporte()
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $credenciales = DB::table('credenciales as c')
                ->select('c.nombres','c.ci','c.stand')
                ->get();
//dd($credenciales);
            $pdf = PDF::loadView('expochaco.pdf-reporte', compact(['credenciales']));
            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('expochaco.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }

    }


}
