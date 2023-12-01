<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\FileModel;

use App\Models\Almacen\LocalidadModel;

use App\Models\Transporte\SoluconsumoModel;



use Carbon\Carbon;
use NumerosEnLetras;

use App\Models\TemporalModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use DataTables;
use PDF;
use App\Http\Requests;


class SoluconsumoController2 extends Controller
{
    public function index(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


         $soluconsumos = DB::table('soluconsumo as s')

                        ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
                        ->join('areas as a', 'a.idarea', '=', 's.idarea')
                      
                        

                        ->where('a.idarea',$personalArea->idarea)
                        ->where('s.estadosoluconsumo',1)
                        ->select('s.idsoluconsumo','s.estado1','s.cominterna', 's.referencia',
                        
                        'a.nombrearea',
                        'lo.nombrelocalidad')
                        ->get();

                    
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        

  

        return view('transportes.pedidoparcial.index',
        ['soluconsumos'=>$soluconsumos,'idd'=>$personalArea]);
    }

    public function index2(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


         $soluconsumos = DB::table('soluconsumo as s')

                        ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
                        ->join('areas as a', 'a.idarea', '=', 's.idarea')
                      
                        

                        ->where('a.idarea',$personalArea->idarea)
                        ->where('s.estado1',2)
                        ->select('s.idsoluconsumo','s.estado1','s.cominterna', 's.referencia',
                        
                        'a.nombrearea',
                        'lo.nombrelocalidad')
                        ->get();

                    
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        

  

        return view('transportes.pedidoparcial.index2',
        ['soluconsumos'=>$soluconsumos,'idd'=>$personalArea]);
    }

    public function index3(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


         $soluconsumos = DB::table('soluconsumo as s')

                        ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
                        ->join('areas as a', 'a.idarea', '=', 's.idarea')
                      
                        

                        ->where('a.idarea',$personalArea->idarea)
                        ->where('s.estado2',2)
                        ->select('s.idsoluconsumo','s.estado1','s.cominterna', 's.referencia',
                        
                        'a.nombrearea',
                        'lo.nombrelocalidad')
                        ->get();

                    
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        

  

        return view('transportes.pedidoparcial.index3',
        ['soluconsumos'=>$soluconsumos,'idd'=>$personalArea]);
    }


    public function create(){

        $personal = User::find(Auth::user()->id); // auth quien esta logeado,yo soy el id=16
        
        $id = $personal->id; // guarda el id en id

        $userdate = User::find($id)->usuariosempleados; 

        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        
        $areas = DB::table('areas')->where('estadoarea',1)
        ->pluck('nombrearea','idarea');


        $localidades = DB::table('localidad')->where('estadolocalidad',1)
        ->pluck('nombrelocalidad','idlocalidad');


       
        $empleados = DB::table('empleados')->where('estadoemp1',1)
        ->select(DB::raw("concat(nombres ,' ', ap_pat,' ',ap_mat,' ',
                    ' // AREA. ',idarea
                    
                    
                    ) as emplead"),'idemp')
                    ->pluck('emplead','idemp');

        
    

        return view('transportes.pedidoparcial.create',
        compact('areas','localidades','empleados','personalArea'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


// de parte de


$productocinco = EmpleadosModel::find($userdate->idemp);
$Nombreusuario = $productocinco->nombres;
$Apellidopausuario = $productocinco->ap_pat;
$Apellidomausuario = $productocinco->ap_mat;
$Nombrecompusuario= $Nombreusuario . " " .  $Apellidopausuario. " " .$Apellidomausuario ;

$IdFiletres = $productocinco->idfile;
$productoseis = FileModel::find($IdFiletres);
$Nombreusuariocargo = $productoseis->nombrecargo;



// dirigido a
        $prod = $request->get('dirigidoa');
        $producto = EmpleadosModel::find($prod);
        $Nombredir = $producto->nombres;
        $Apellidopadir = $producto->ap_pat;
        $Apellidomadir = $producto->ap_mat;
        $Nombrecompdir= $Nombredir . " " .  $Apellidopadir. " " .$Apellidomadir ;

        $IdFile = $producto->idfile;
        $productodos = FileModel::find($IdFile);
        $Nombredircargo = $productodos->nombrecargo;


// via uno

$proddos = $request->get('viauno');
$productotres = EmpleadosModel::find($proddos);
$Nombrevia = $productotres->nombres;
$Apellidopavia = $productotres->ap_pat;
$Apellidomavia = $productotres->ap_mat;
$Nombrecompvia= $Nombrevia . " " .  $Apellidopavia. " " .$Apellidomavia ;

$IdFiledos = $productotres->idfile;
$productocuatro = FileModel::find($IdFiledos);
$Nombreviacargo = $productocuatro->nombrecargo;



$proddoss = $request->get('idlocalidad');
$productoocho = LocalidadModel::find($proddoss);
$Codlocalidad = $productoocho->codlocalidad;
$Nombrelocalid = $productoocho->nombrelocalidad;
$Distancialocalid = $productoocho->distancialocalidad;

        $soluconsumos = new SoluconsumoModel();

        $soluconsumos->oficina = $request->input('oficina');
        $soluconsumos->cominterna = $request->get('cominterna');

        
        $soluconsumos->dirigidoa = $request->get('dirigidoa');  //dirigido a
        $soluconsumos->dirnombre = $Nombrecompdir;
        $soluconsumos->diracargo = $Nombredircargo;


        $soluconsumos->viauno = $request->get('viauno');  //via 
        $soluconsumos->viaunonombre = $Nombrecompvia;
        $soluconsumos->viaunocargo = $Nombreviacargo;

        $soluconsumos->idlocalidad = $request->get('idlocalidad');
        $soluconsumos->codlocalidad = $Codlocalidad;
        $soluconsumos->nombrelocalidad = $Nombrelocalid;
        $soluconsumos->distancialocalidad = $Distancialocalid;
      

        $soluconsumos->idarea = $personalArea->idarea;  //de , nombre, cargo oficina
     

        $soluconsumos->idusuario =$id;
        $soluconsumos->usuarionombre = $Nombrecompusuario;
        $soluconsumos->usuariocargo = $Nombreusuariocargo;


        $soluconsumos->referencia = $request->input('referencia');
        $soluconsumos->fechasol = $request->input('fechasol');
        $soluconsumos->detallesouconsumo = $request->input('detallesouconsumo');

        $soluconsumos->fechasalida = $request->input('fechasalida');
        $soluconsumos->fecharetorno = $request->input('fecharetorno');

    
        $soluconsumos->tsalida = $request->input('tsalida');
        $soluconsumos->tllegada = $request->input('tllegada');


        $soluconsumos->estadosoluconsumo = 1;
        $soluconsumos->estado1 = 1;
        $soluconsumos->estado2 = 1;
        $soluconsumos->estado3 = 1;

        if($soluconsumos->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('transportes.pedidoparcial.index');
    }

    public function show($id){

    }

   

    public function editar($idsoluconsumo){
        $soluconsumos = SoluconsumoModel::find($idsoluconsumo);

        $areas = DB::table('areas')->get();
        $localidades = DB::table('localidad')->get();
        $empleados = DB::table('empleados')->get();
   

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        return view('transportes.pedidoparcial.editar',

        compact('id','soluconsumos','areas',
        'empleados','localidades'));
    }

    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


// de parte de


$productocinco = EmpleadosModel::find($userdate->idemp);
$Nombreusuario = $productocinco->nombres;
$Apellidopausuario = $productocinco->ap_pat;
$Apellidomausuario = $productocinco->ap_mat;
$Nombrecompusuario= $Nombreusuario . " " .  $Apellidopausuario. " " .$Apellidomausuario ;

$IdFiletres = $productocinco->idfile;
$productoseis = FileModel::find($IdFiletres);
$Nombreusuariocargo = $productoseis->nombrecargo;



// dirigido a
        $prod = $request->get('dirigidoa');
        $producto = EmpleadosModel::find($prod);
        $Nombredir = $producto->nombres;
        $Apellidopadir = $producto->ap_pat;
        $Apellidomadir = $producto->ap_mat;
        $Nombrecompdir= $Nombredir . " " .  $Apellidopadir. " " .$Apellidomadir ;

        $IdFile = $producto->idfile;
        $productodos = FileModel::find($IdFile);
        $Nombredircargo = $productodos->nombrecargo;


// via uno

$proddos = $request->get('viauno');
$productotres = EmpleadosModel::find($proddos);
$Nombrevia = $productotres->nombres;
$Apellidopavia = $productotres->ap_pat;
$Apellidomavia = $productotres->ap_mat;
$Nombrecompvia= $Nombrevia . " " .  $Apellidopavia. " " .$Apellidomavia ;

$IdFiledos = $productotres->idfile;
$productocuatro = FileModel::find($IdFiledos);
$Nombreviacargo = $productocuatro->nombrecargo;


$proddoss = $request->get('idlocalidad');
$productoocho = LocalidadModel::find($proddoss);
$Codlocalidad = $productoocho->codlocalidad;
$Nombrelocalid = $productoocho->nombrelocalidad;
$Distancialocalid = $productoocho->distancialocalidad;

        $soluconsumos = SoluconsumoModel::find($request->idsoluconsumo);

        
        $soluconsumos->oficina = $request->input('oficina');
        $soluconsumos->cominterna = $request->get('cominterna');

        
        $soluconsumos->dirigidoa = $request->get('dirigidoa');  //dirigido a
        $soluconsumos->dirnombre = $Nombrecompdir;
        $soluconsumos->diracargo = $Nombredircargo;


        $soluconsumos->viauno = $request->get('viauno');  //via 
        $soluconsumos->viaunonombre = $Nombrecompvia;
        $soluconsumos->viaunocargo = $Nombreviacargo;


        $soluconsumos->idarea = $personalArea->idarea;  //de , nombre, cargo oficina
     

        $soluconsumos->idusuario =$id;
        $soluconsumos->usuarionombre = $Nombrecompusuario;
        $soluconsumos->usuariocargo = $Nombreusuariocargo;


        $soluconsumos->referencia = $request->input('referencia');
        $soluconsumos->fechasol = $request->input('fechasol');
        $soluconsumos->detallesouconsumo = $request->input('detallesouconsumo');

        $soluconsumos->fechasalida = $request->input('fechasalida');
        $soluconsumos->fecharetorno = $request->input('fecharetorno');

        $soluconsumos->idlocalidad = $request->get('idlocalidad');
        $soluconsumos->codlocalidad = $Codlocalidad;
        $soluconsumos->nombrelocalidad = $Nombrelocalid;
        $soluconsumos->distancialocalidad = $Distancialocalid;  //lugar

        $soluconsumos->tsalida = $request->input('tsalida');
        $soluconsumos->tllegada = $request->input('tllegada');

        if($soluconsumos->save()){

            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('transportes.pedidoparcial.index');
    }


    public function pdf()
{
    $soluconsumos  = DB::table('soluconsumo')->get();
   $pdf = PDF::loadView('transportes.pedidoparcial.pdf',compact('soluconsumos'));
  return $pdf->stream();
}

public function solicitud($id)    
{        
    try {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
            $soluconsumos = SoluconsumoModel::find($id);
            $soluconsumos = DB::table('soluconsumo as s')
            ->select(


    's.cominterna',
    's.idarea' , //de forma automatica del que tiene acceso
    's.idusuario' ,  //de forma automatica del que tiene acceso
    's.idlocalidad' ,  //el lugar de ida

      //via
    's.dirnombre',    //via
    's.diracargo',    //via
    
    
    //departe de 
    's.viaunonombre', //departe de 
    's.viaunocargo', //departe de 
    
    's.usuarionombre' ,  //de forma automatica del que tiene acceso
    's.usuariocargo' ,  //de forma automatica del que tiene acceso

    's.oficina', //nombre de la oficina
    's.referencia' ,
    's.fechasol',
    's.detallesouconsumo',
    's.fechasalida',
    's.fecharetorno' ,
    's.tipo' ,
    's.tsalida' ,
    's.tllegada'
                    )
                    ->where('s.idsoluconsumo', $id)
            
            ->first();

        
        $fechaSol = $soluconsumos->fechasol;
        $fechaSol = Carbon::parse($fechaSol)->isoFormat('D \d\e MMMM \d\e\l Y');

        $fechaSalida = $soluconsumos->fechasalida;
        $fechaSalida = Carbon::parse($fechaSalida)->isoFormat('D \d\e MMMM \d\e\l Y');

      
        $diaSemana = $soluconsumos->fechasalida;
        $diaSemana = Carbon::parse($diaSemana);
        $diaSemana = $diaSemana->isoFormat('dddd');

        
        // $diaSemana = $soluconsumos->fechasalida;
        // $diaSemana = Carbon::parse($diaSemana);
        // $diaSemana = $diaSemana->format('l');


        $fechaRetorno = $soluconsumos->fecharetorno;
        $fechaRetorno = Carbon::parse($fechaRetorno)->isoFormat('D \d\e MMMM \d\e\l Y');


        $localidades = DB::table('localidad')->first();
       
                 

        $pdf = PDF::loadView('transportes.pedidoparcial.pdf-solicitud', 
        compact(['soluconsumos', 'localidades', 
        'fechaSol', 'fechaRetorno',
         'fechaSalida','diaSemana']));

        $pdf->setPaper('LETTER', 'portrait'); //landscape
        return $pdf->stream();

    } catch (Exception $ex) {
        \Log::error("Cotizacion Error: {$ex->getMessage()}");
        return redirect()->route('transportes.pedidoparcial.index')->with('message', $ex->getMessage());
    } finally {
        ini_restore('memory_limit');
        ini_restore('max_execution_time');
    }

  
}

public function respuesta7(Request $request)    {
    $ot_antigua=$_POST['ot_antigua'];
        $data = "hola";
        $data2 = "holaSSSS";
        $validarci = DB::table('soluconsumo as s')
        ->select('s.cominterna')
       ->where('s.cominterna', $ot_antigua)
        ->get();
           if($validarci->count()>0){
        return ['success' => true, 'data' => $data];
    } else  return ['success' => false, 'data' => $data2];
}
}

