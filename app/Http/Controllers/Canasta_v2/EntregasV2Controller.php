<?php

namespace App\Http\Controllers\Canasta_v2;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Entrega;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\Ocupaciones;
use App\Models\Canasta\Paquetes;
use App\Models\Canasta\BarrioEntrega;
use App\Models\Canasta\Periodos;
use App\Models\Canasta\PaquetePeriodo;
use App\Models\Canasta\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BarriosExcel;
use DB;
use PDF;
use Carbon\Carbon;

use App\Models\User;
use App\Models\EmpleadosModel;

class EntregasV2Controller extends Controller
{
    public function index()
    {
        return view('canasta_v2.entregas.index')->with(['paquetes'=> Paquetes::where('dea_id',Auth::user()->dea->id)
                                                ->orderBy('id', 'desc')
                                                ->paginate(10),'deas'=>Dea::where('id',Auth::user()
                                                ->dea->id)->pluck('nombre','id')]);
    }

    public function search(Request $request)
    {
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');
        $estados = Barrio::ESTADOS;

        return view('canasta_v2.entregas.index')->with(['paquetes'=>Paquetes::query()
                                                ->byCodigo($request->codigo)
                                                ->byGestion($request->gestion)
                                                ->byPeriodo($request->periodo)
                                                ->byDea($request->dea_id)
                                                ->byUsuario($request->usuario)
                                                ->byEstado($request->estado)
                                                ->byEstado($request->estado)
                                                ->where('dea_id',Auth::user()->dea->id)
                                                ->orderBy('id', 'desc')
                                                ->paginate(10),
                                                'deas'=>Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id')]);
    }
    public function create_paquete()
    {
        $deas = Dea::pluck('nombre','id');
        return view('canasta_v2.entregas.create', compact('deas'));
    }

    public function store_paquete(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id_usuario = $personal->id;
        $dea_id = $personal->dea_id;
        $paquetes = new Paquetes();
        $paquetes->gestion = $request->gestion;
        $paquetes->items = $request->items;
        $paquetes->numero = $request->numero;
        $paquetes->user_id = $id_usuario;
        $paquetes->dea_id = $dea_id;
        $paquetes->estado = 1;
        $paquetes->save();
        return redirect()->route('entregas.index')->with($request->session()->flash('message', 'Registro Procesado'));

    }

    public function edit_paquete($idPaquete)
    {
        $paquetes = Paquetes::find($idPaquete);
        return view('canasta_v2.entregas.editar', compact('paquetes'));
    }

    public function update_paquete(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id_usuario = $personal->id;
        $dea_id = $personal->dea_id;
        $paquetes = Paquetes::find($request->id_paquete);
        $paquetes->gestion = $request->gestion;
        $paquetes->items = $request->items;
        $paquetes->numero = $request->numero;
        $paquetes->user_id = $id_usuario;
        $paquetes->dea_id = $dea_id;
        $paquetes->estado = 1;
        $paquetes->save();
        return redirect()->route('entregas.index')->with($request->session()->flash('message', 'Registro Procesado'));
    }

    public function entrega_index($idpaquete)
    {
        $estados = Entrega::ESTADOS;
        $deas = Dea::where('id',Auth::user()->dea->id)->get();
        $barrioEntrega = BarrioEntrega::select('idBarrio')->where('idPaquete','=',$idpaquete)->pluck('idBarrio','idBarrio');
        $barrioEntregaSel = BarrioEntrega::All()->where('idPaquete','=',$idpaquete);

        $botonImprimir = 0;

        if ($barrioEntrega->isEmpty()) {
            $barrios3 = DB::table('barrios')->select('id', 'nombre')->get();
        } else {
            $botonImprimir = 1;
            $barrios3 = DB::table('barrios')->whereIn('id', $barrioEntregaSel->pluck('idBarrio'))
                                            ->select('id', 'nombre')
                                            ->get();
        }

        if ($barrioEntrega->isEmpty()) {
            $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        } else {
            $barrios = DB::table('barrios')
                            ->whereNotIn('id', $barrioEntregaSel->pluck('idBarrio'))
                            ->select('id', 'nombre')
                            ->get();
        }

        if ($barrioEntrega->isEmpty()) {
            $barrios2 = DB::table('barrios')->select('nombre', 'nombre')->get();
        } else {
            $barrios2 = DB::table('barrios')->whereIn('id', $barrioEntregaSel->pluck('idBarrio'))
                                            ->select('nombre', 'nombre')
                                            ->get();
        }

        $beneficiarioControl = 0;
        $entregas = Entrega::where('dea_id',Auth::user()->dea->id)
                            ->where('id_paquete',$idpaquete)
                            ->orderBy('id', 'desc')
                            ->paginate(10);

        $entregados = Entrega::where('dea_id',Auth::user()->dea->id)
                            ->where('id_paquete',$idpaquete)
                            ->where('estado','=',3)
                             ->count();

        $sin_entrega_imp = Entrega::where('dea_id',Auth::user()->dea->id)
                            ->where('id_paquete',$idpaquete)
                            ->where('estado','=',2)
                             ->count();

        $sin_entrega_sinImp = Entrega::where('dea_id',Auth::user()->dea->id)
                             ->where('id_paquete',$idpaquete)
                             ->where('estado','=',1)
                              ->count();

        $sin_entrega=$sin_entrega_imp + $sin_entrega_sinImp;


        $total = Entrega::where('dea_id',Auth::user()->dea->id)
                             ->where('id_paquete',$idpaquete)
                             //->where('estado','=',1)
                              ->count();

        return view('canasta_v2.entregas.entrega_index', ["sin_entrega" => $sin_entrega,"total" => $total,"entregados" => $entregados,"estados" => $estados,"botonImprimir" => $botonImprimir,"barrios3" => $barrios3,"barrios2" => $barrios2,"barrios" => $barrios,"beneficiarioControl" => $beneficiarioControl,"entrega" => $entregas,"idpaquete" => $idpaquete]);
    }

    public function search_entrega(Request $request,$idpaquete)

    {
                                                 $estados = Entrega::ESTADOS;
                                                $deas = Dea::where('id',Auth::user()->dea->id)->get();
                                                $barrioEntrega = BarrioEntrega::select('idBarrio')->where('idPaquete','=',$idpaquete)->pluck('idBarrio','idBarrio');
                                                $barrioEntregaSel = BarrioEntrega::All()->where('idPaquete','=',$idpaquete);

                                                //dd($barrioEntrega);
                                            // $barrios2 = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','nombre');
                                                $botonImprimir=0;

                                                if ($barrioEntrega->isEmpty()) {
                                                        $barrios3 = DB::table('barrios')
                                                        ->select('id', 'nombre')
                                                        ->get();

                                                } else {
                                                        $botonImprimir=1;
                                                        $barrios3 = DB::table('barrios')
                                                        ->whereIn('id', $barrioEntregaSel->pluck('idBarrio'))
                                                        ->select('id', 'nombre')
                                                        ->get();
                                                }

                                                if ($barrioEntrega->isEmpty()) {
                                                        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)
                                                        ->get();
                                                } else {

                                                        $barrios = DB::table('barrios')
                                                        ->whereNotIn('id', DB::table('barriosEntrega')->pluck('idBarrio'))
                                                        ->select('id', 'nombre')
                                                        ->get();
                                                }



                                                if ($barrioEntrega->isEmpty()) {
                                                    $barrios2 = DB::table('barrios')
                                                    ->select('nombre', 'nombre')
                                                    ->get();

                                            } else {
                                                // $botonImprimir=1;
                                                    $barrios2 = DB::table('barrios')
                                                    ->whereIn('id', $barrioEntregaSel->pluck('idBarrio'))
                                                    ->select('nombre', 'nombre')
                                                    ->get();
                                            }
                                        $beneficiarioControl =0;

                                        if ($request->barrio != null || $request->estado != null) {
                                            $entregas = Entrega::query()
                                            ->byNombre($request->nombres)
                                            ->byAp($request->ap)
                                            ->byAm($request->am)
                                            ->byCi($request->ci)
                                            ->byBarrio($request->barrio)
                                            ->byEstado($request->estado)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);

                                            $entregados = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->where('estado','=',3)
                                            ->count();

                                            $sin_entrega_imp = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->where('estado','=',2)
                                            //->where('estado','=',1)
                                            ->count();

                                            $sin_entrega_sinImp = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->where('estado','=',1)
                                            //->where('estado','=',1)
                                            ->count();

                                            $sin_entrega=$sin_entrega_imp + $sin_entrega_sinImp;

                                            $total = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->count();

                                    } else {

                                        $entregas = Entrega::query()
                                        ->byNombre($request->nombres)
                                        ->byAp($request->ap)
                                        ->byAm($request->am)
                                        ->byCi($request->ci)
                                        ->byBarrio($request->barrio)
                                        ->byEstado($request->estado)
                                        ->where('dea_id',Auth::user()->dea->id)
                                        ->where('id_paquete','=',$idpaquete)
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

                                        $entregados = 0;

                                        $sin_entrega_imp = 0;
                                        $sin_entrega_sinImp = 0;
                                        $sin_entrega=$sin_entrega_imp + $sin_entrega_sinImp;

                                         $total =0;
                                    }




     return view('canasta_v2.entregas.entrega_index', ["sin_entrega" => $sin_entrega,"entregados" => $entregados,"total" => $total,"estados" => $estados,"barrios3" => $barrios3,"botonImprimir" => $botonImprimir,"barrios2" => $barrios2,"barrios" => $barrios,"beneficiarioControl" => $beneficiarioControl,"entrega" => $entregas,"idpaquete" => $idpaquete]);
}


    public function createEntrega(Request $request)
        {

                                     $personal = User::find(Auth::user()->id);
                                      $id_usuario = $personal->id;
                                     $dea_id = $personal->dea_id;
                                        $date = Carbon::now();

                                        $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');

                                        $beneficiarioControl =0;
                                        $entregas = Entrega::where('dea_id',Auth::user()->dea->id)
                                                ->orderBy('id', 'desc')
                                                ->paginate(10);

                                        $entrega = new Entrega();
                                        $entrega->fecha = $date;
                                        $entrega->id_paquete = $request->idpaquete;
                                        $entrega->id_beneficiario = $request->idbeneficiario;

                                        $entrega->user_id = $id_usuario;
                                        $entrega->dea_id = $dea_id;
                                        $entrega->estado = 1;

                                        $entregas2 = Entrega::where('dea_id',Auth::user()->dea->id)
                                                ->where('id_beneficiario','=',$request->idbeneficiario)
                                                ->where('id_paquete','=',$request->idpaquete)
                                                ->orderBy('id', 'desc')
                                                ->paginate(10);

                                    if ($entregas2->isEmpty()) {
                                        $entrega->save();
                                        $request->session()->flash('message', 'Registro Agregado');
                                    } else {
                                        $request->session()->flash('message', 'El Item Ya existe en la Planilla');
                                    }

        return redirect()->route('entregas.entrega_index',$request->idpaquete);
    }


    public function agregarporbarrio(Request $request,$idpaquete)
    {
                                            $personal = User::find(Auth::user()->id);
                                            $id_usuario = $personal->id;
                                        $dea_id = $personal->dea_id;
                                        $beneficiarios= Beneficiario::where('dea_id',Auth::user()->dea->id)
                                                        ->Where('idBarrio','=',$request->barrio)
                                                        ->Where('estado','=','A')
                                                        ->get();

                                        $date = Carbon::now();
                                        foreach ($beneficiarios as $data){

                                        $datos=([

                                            'fecha'=>$date,
                                            'id_paquete'=>$idpaquete,
                                            'id_beneficiario'=>$data->id,
                                            'idBarrio'=>$data->idBarrio,
                                            'user_id'=>$id_usuario,
                                            'dea_id'=>$dea_id,
                                            'estado'=>1
                                                ]

                                                );
                                        $entrega=Entrega::CREATE($datos);
                                        }

                                        $barrioEntrega = new BarrioEntrega;
                                        $barrioEntrega->idBarrio = $request->barrio;
                                        $barrioEntrega->idPaquete = $idpaquete;
                                        $barrioEntrega->save();

    return redirect()->route('entregas.entrega_index',$idpaquete);

    }


    public function generarboleta(Request $request)
    {
                                         $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                         'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                                        $fecha_actual=$meses[date('n')] . '-' . date('Y');
                                        $personal = User::find(Auth::user()->id);
                                        $id = $personal->id;
                                        $userdate = User::find($id)->usuariosempleados;
                                        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

                                        $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                                            ->get();

                                        $entregas = Entrega::join('beneficiarios as b', 'b.id', '=', 'entrega.id_beneficiario')
                                        ->where('entrega.dea_id',Auth::user()->dea->id)
                                        ->where('entrega.id_paquete',$request->idpaquete)
                                        ->where('entrega.idBarrio',$request->barrio3)
                                        ->orderBy('b.nombres', 'asc')
                                        ->get();

                                          //  $entregas = DB::table('entrega as e')
                                            //->join('paquete as p', 'p.id', '=', 'e.id_paquete')
                                            //->join('barrios as b', 'b.id', '=', 'e.idBarrio')
                                            //->join('beneficiarios as be', 'be.id', '=', 'e.id_beneficiario')
                                            //->select('e.id','p.periodo','p.items','p.gestion','b.nombre','be.dirFoto', 'be.ci', 'be.nombres', 'be.ap', 'be.am','be.firma', 'be.fechaNac', 'be.created_att')
                                            //->where('e.id_paquete',$request->idpaquete)
                                            //->where('e.idBarrio',$request->barrio3)
                                            //->orderBy('be.nombres', 'asc')
                                            //->get();

                                            $entregas2 = Entrega::where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete',$request->idpaquete)
                                            ->where('idBarrio',$request->barrio3)
                                            //->take(2)
                                            ->get();

                                            foreach ($entregas2 as $data){
                                                $entrega3 = Entrega::find($data->id);


                                                $entrega3->estado = 2;


                                                $entrega3->save();
                                                }


                                        //dd($entregas);

                                            // $pdf = PDF::loadView('canasta_v2/entregas/generarboleta', compact(['entregas']));
                                            //$pdf->setPaper('LETTER', 'portrait'); //landscape
                                           //return $pdf->stream();

                                        return view('canasta_v2/entregas/generarboleta', ["fecha_actual" => $fecha_actual,"entregas" => $entregas,"userdate" => $userdate,"personalArea" => $personalArea]);


                }



   public function generarboleta2($id_entrega)
                                        {

                                            $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                        $fecha_actual=$meses[date('n')] . '-' . date('Y');

                        $personal = User::find(Auth::user()->id);
                        $id = $personal->id;
                        $userdate = User::find($id)->usuariosempleados;
                        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

                        $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                        ->get();

                         $entrega = Entrega::where('dea_id',Auth::user()->dea->id)
                        ->where('id','=',$id_entrega)
                         //->where('idBarrio',$request->barrio3)
                         //->take(2)
                         ->first();
                        //dd($entregas);
                        $entrega2 = Entrega::find($id_entrega);

                        $entrega2->estado = 2;
                        $entrega2->save();





                         // $pdf = PDF::loadView('canasta_v2/entregas/generarboleta', compact(['entregas']));
                        //$pdf->setPaper('LETTER', 'portrait'); //landscape
                        //return $pdf->stream();
                        //dd($entregas);
                                        //return view('canasta_v2/entregas/generarboleta2', ["entrega" => $entregas,"userdate" => $userdate,"personalArea" => $personalArea]);

                                        return view('canasta_v2.entregas/generarboleta2', compact('fecha_actual','entrega','userdate','personalArea'));

                                    }



    public function paquete_periodo($idPaquete)
    {

                                        $paquetes = Paquetes::find($idPaquete);
                                        $PaquetesPeriodos2 = PaquetePeriodo::select('id_periodo')->pluck('id_periodo','id_periodo');

                                    if ($PaquetesPeriodos2->isEmpty()) {
                                        $periodos= Periodos::all();
                                    } else {

                                        $periodos = DB::table('periodos')
                                                    ->whereNotIn('id', DB::table('paquete_periodo')
                                                    ->where('gestion','=',$paquetes->gestion)
                                                    ->pluck('id_periodo'))
                                                    ->select('id', 'mes')
                                                    ->get();
                                    }
                                        $PaquetesPeriodos= PaquetePeriodo::where('id_paquete','=',$idPaquete)->get();

        return view('canasta_v2/entregas/paquete_periodo', ["idPaquete" => $idPaquete,"PaquetesPeriodos" => $PaquetesPeriodos, "periodos" => $periodos]);

    }


    public function paquete_periodo_agregar(Request $request,$idPaquete)
            {
                                        $paquetes = Paquetes::find($idPaquete);
                                        $PaquetesPeriodos3 = new PaquetePeriodo;
                                        $PaquetesPeriodos3->id_periodo = $request->periodo;
                                        $PaquetesPeriodos3->id_paquete = $idPaquete;
                                        $PaquetesPeriodos3->gestion = $paquetes->gestion;
                                        $PaquetesPeriodos3->save();

                                        $PaquetesPeriodos2 = PaquetePeriodo::select('id_periodo')->pluck('id_periodo','id_periodo');

                                        if ($PaquetesPeriodos2->isEmpty()) {
                                            $periodos= Periodos::all();
                                        } else {

                                        $periodos = DB::table('periodos')
                                                ->whereNotIn('id', DB::table('paquete_periodo')
                                                ->where('gestion','=',$paquetes->gestion)
                                                ->pluck('id_periodo'))
                                                ->select('id', 'mes')
                                                ->get();

                                        }
                                        $PaquetesPeriodos= PaquetePeriodo::where('id_paquete','=',$idPaquete)->get();

        return back();
    }


    public function finalizar($idPaquete)
    {
                                    $PaquetesPeriodos = DB::table('paquete_periodo as p')
                                                ->join('periodos as pe', 'pe.id', '=', 'p.id_periodo')
                                                ->where('p.id_paquete', $idPaquete)
                                                ->select('pe.mes')->get();

                                    $alex='';

                                            if ($PaquetesPeriodos->isEmpty()) {

                                            }

                                            else {

                                                foreach ($PaquetesPeriodos as $data)

                                                {
                                                $alex=$alex."-".$data->mes;
                                                }

                                                $paquetes = Paquetes::find($idPaquete);
                                                $paquetes->periodo = $alex;
                                                //$PaquetesPeriodos3->id_paquete = $idPaquete;
                                                $paquetes->save();
                                            }

        return view('canasta_v2.entregas.index')->with(['paquetes'=> Paquetes::where('dea_id',Auth::user()->dea->id)
                                            ->orderBy('id', 'desc')
                                            ->paginate(10),'deas'=>Dea::where('id',Auth::user()
                                            ->dea->id)->pluck('nombre','id')]);
    }



    public function eliminar_periodo($id)
    {
                                                $PaquetesPeriodos= PaquetePeriodo::find($id);
                                                $PaquetesPeriodos->delete();

        return back();
    }

    public function detalleBarrio(Request $request)
    {
                                         $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                         'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                                        $fecha_actual=$meses[date('n')] . '-' . date('Y');
                                        $personal = User::find(Auth::user()->id);
                                        $id = $personal->id;
                                        $userdate = User::find($id)->usuariosempleados;
                                        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

                                        $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                                            ->get();

                                            $entregas = DB::table('entrega as e')
                                            ->join('paquete as p', 'p.id', '=', 'e.id_paquete')
                                            ->join('barrios as b', 'b.id', '=', 'e.idBarrio')
                                            ->join('beneficiarios as be', 'be.id', '=', 'e.id_beneficiario')
                                            ->select('be.dirFoto', 'be.ci', 'be.nombres', 'be.ap', 'be.am', 'be.fechaNac')
                                            ->where('e.id_paquete',$request->idpaquete)
                                            ->where('e.idBarrio',$request->barrio4)
                                            ->orderBy('be.nombres', 'asc')
                                            ->get();

                                            //$entregass = Entrega::where('dea_id',Auth::user()->dea->id)
                                            //->where('id_paquete',$request->idpaquete)
                                            //->where('idBarrio',$request->barrio4)
                                            //->take(2)
                                            // ->get();

                                            $entrega_barrio = Entrega::where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete',$request->idpaquete)
                                            ->where('idBarrio',$request->barrio4)
                                            //->take(2)
                                             ->first();

                                        //dd($entregas);

                                            // $pdf = PDF::loadView('canasta_v2/entregas/generarboleta', compact(['entregas']));
                                            //$pdf->setPaper('LETTER', 'portrait'); //landscape
                                           //return $pdf->stream();

                                        return view('canasta_v2/entregas/impDetallebarrio', ["entrega_barrio" => $entrega_barrio, "fecha_actual" => $fecha_actual,"entregas" => $entregas,"userdate" => $userdate,"personalArea" => $personalArea]);


                }



                public function detalleBarrio2(Request $request)
                {
                                                     $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                                     'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                                                    $fecha_actual=$meses[date('n')] . '-' . date('Y');
                                                    $personal = User::find(Auth::user()->id);
                                                    $id = $personal->id;
                                                    $userdate = User::find($id)->usuariosempleados;
                                                    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

                                                    $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                                                        ->get();

                                                        $entregas = DB::table('entrega as e')
                                                        ->join('paquete as p', 'p.id', '=', 'e.id_paquete')
                                                        ->join('barrios as b', 'b.id', '=', 'e.idBarrio')
                                                        ->join('beneficiarios as be', 'be.id', '=', 'e.id_beneficiario')
                                                        ->select('be.dirFoto', 'be.ci', 'be.nombres', 'be.ap', 'be.am', 'be.fechaNac', 'be.created_att')
                                                        ->where('e.id_paquete',$request->idpaquete)
                                                        ->where('e.idBarrio',$request->barrio5)
                                                        ->orderBy('be.nombres', 'asc')
                                                        ->get();

                                                        //$entregass = Entrega::where('dea_id',Auth::user()->dea->id)
                                                        //->where('id_paquete',$request->idpaquete)
                                                        //->where('idBarrio',$request->barrio4)
                                                        //->take(2)
                                                        // ->get();

                                                        $entrega_barrio = Entrega::where('dea_id',Auth::user()->dea->id)
                                                        ->where('id_paquete',$request->idpaquete)
                                                        ->where('idBarrio',$request->barrio5)
                                                        //->take(2)
                                                         ->first();

                                                    //dd($entregas);

                                                        // $pdf = PDF::loadView('canasta_v2/entregas/generarboleta', compact(['entregas']));
                                                        //$pdf->setPaper('LETTER', 'portrait'); //landscape
                                                       //return $pdf->stream();

                                                    return view('canasta_v2/entregas/impDetallebarrio2', ["entrega_barrio" => $entrega_barrio, "fecha_actual" => $fecha_actual,"entregas" => $entregas,"userdate" => $userdate,"personalArea" => $personalArea]);


                            }


        public function deshabilitar($id,$idpaquete){

           // dd($id);
                                $entrega = Entrega::find($id);
                                $entrega->update([
                                    'estado' => 2
                                ]);
                                return redirect()->route('entregas.entrega_index',$idpaquete)->with('info_message', 'Se quitado el paquete seleccionado.');
                            }

        public function habilitar($id,$idpaquete){
           // dd($id);
                                $entrega = Entrega::find($id);
                                $entrega->update([
                                    'estado' => 3
                                ]);
                                return redirect()->route('entregas.entrega_index',$idpaquete)->with('info_message', 'Se ha entregado el paquete seleccionado.');
                            }

            public function confirmar_entrega(Request $request)
                            {
                                    $personal = User::find(Auth::user()->id);
                                    $id = $personal->id;
                                    $userdate = User::find($id)->usuariosempleados;
                                    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;





                                    $entregas2 = Entrega::where('dea_id',Auth::user()->dea->id)
                                    ->where('id_paquete',$request->idpaquete)
                                    ->where('idBarrio',$request->barrio6)
                                    ->get();

                                    foreach ($entregas2 as $data){
                                    $entrega3 = Entrega::find($data->id);
                                    $entrega3->estado = 3;
                                     $entrega3->save();
                                     }


                                    //dd($entregas);

                                    // $pdf = PDF::loadView('canasta_v2/entregas/generarboleta', compact(['entregas']));
                                    //$pdf->setPaper('LETTER', 'portrait'); //landscape
                                     //return $pdf->stream();

                                     return redirect()->route('entregas.entrega_index',$request->idpaquete)->with('info_message', 'Se ha registrado la entrega del barrio seleccionado.');

                                        }




}
