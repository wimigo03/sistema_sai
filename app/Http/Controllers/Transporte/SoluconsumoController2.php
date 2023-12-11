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
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
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
                        ->where('s.estadosoluconsumo', '!=',2)
                        ->select('s.idsoluconsumo','s.estadosoluconsumo','s.fechasol','s.estado1','s.cominterna', 's.referencia',
                        
                        'a.nombrearea',
                        'lo.nombrelocalidad')
                        ->orderBy('s.idsoluconsumo','asc')
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
                        ->select('s.idsoluconsumo','s.estado2','s.estado1','s.cominterna', 's.referencia',
                        
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
        $id3 = $personalArea->idarea;
        
        $areas = DB::table('areas')->where('estadoarea',1)
        ->pluck('nombrearea','idarea');

        $localidades = DB::table('localidad')->where('estadolocalidad',1)
        ->pluck('nombrelocalidad','idlocalidad');

        $empleados = DB::table('empleados')->where('estadoemp1',1)
        ->select(DB::raw("concat(nombres ,' ', ap_pat,' ',ap_mat,' ',
                    ' // AREA. ',idarea   
                    ) as emplead"),'idemp')
                    ->pluck('emplead','idemp');

        
        $date = Carbon::now();

    $encargado = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea', $id3)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();

$encargadodos = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea',11)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();

$encargadotres = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea',19)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();

$Areanm = AreasModel::find($id3);
$NmBr =$Areanm ->nombrearea;
$oFICI="OFICINA DE";
$NomFci= $oFICI . " " .  $NmBr;

        return view('transportes.pedidoparcial.create',
        compact('areas','localidades','empleados','personalArea','date','encargado','encargadodos','encargadotres','NomFci'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;


        $Areanm = AreasModel::find($id3);
        $NmBr =$Areanm ->nombrearea;
        $oFICI="OFICINA DE";
        $NomFci= $oFICI . " " .  $NmBr;


$productocinco = EmpleadosModel::find($userdate->idemp);
$Nombreusuario = $productocinco->nombres;
$Apellidopausuario = $productocinco->ap_pat;
$Apellidomausuario = $productocinco->ap_mat;
$Nombrecompusuario= $Nombreusuario . " " .  $Apellidopausuario. " " .$Apellidomausuario ;

$IdFiletres = $productocinco->idfile;
$productoseis = FileModel::find($IdFiletres);
$Nombreusuariocargo = $productoseis->nombrecargo;



// dirigido a
$encargado = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea', $id3)
->select('emp.nombres','emp.idemp','emp.ap_pat','emp.ap_mat','e.abrev','e.cargo')
->first();


        $prod = 1435;
        $producto = EmpleadosModel::find($prod);
        $Nombredir = $producto->nombres;
        $Apellidopadir = $producto->ap_pat;
        $Apellidomadir = $producto->ap_mat;
        $Nombrecompdir= $Nombredir . " " .  $Apellidopadir. " " .$Apellidomadir ;

        $IdFile = $producto->idfile;
        $productodos = FileModel::find($IdFile);
        $Nombredircargo = $productodos->nombrecargo;


// via uno

$proddos = 1438;
$productotres = EmpleadosModel::find($proddos);
$Nombrevia = $productotres->nombres;
$Apellidopavia = $productotres->ap_pat;
$Apellidomavia = $productotres->ap_mat;
$Nombrecompvia= $Nombrevia . " " .  $Apellidopavia. " " .$Apellidomavia ;

$IdFiledos = $productotres->idfile;
$productocuatro = FileModel::find($IdFiledos);
$Nombreviacargo = $productocuatro->nombrecargo;



$IdEmp = $encargado->idemp;
$CarGoviatress = $encargado->abrev;
$Nombreviatress = $encargado->nombres;
$Apellidopaviatress = $encargado->ap_pat;
$Apellidomaviatress = $encargado->ap_mat;
$Nombrecompviatress= $CarGoviatress . " " .  $Nombreviatress . " " .  $Apellidopaviatress. " " .$Apellidomaviatress ;

$Nombreviacargotress = $encargado->cargo;





$proddoss = $request->get('idlocalidad');
$productoocho = LocalidadModel::find($proddoss);
$Codlocalidad = $productoocho->codlocalidad;
$Nombrelocalid = $productoocho->nombrelocalidad;
$Distancialocalid = $productoocho->distancialocalidad;



// $flechasol = substr($request->fechasol, 6, 4) . '-' . substr($request->fechasol, 3, 2) . '-' . substr($request->fechasol, 0, 2);

        $soluconsumos = new SoluconsumoModel();

        $soluconsumos->oficina = $NomFci;
        $soluconsumos->cominterna = $request->get('cominterna');

        
        $soluconsumos->dirigidoa = $prod;  //dirigido a
        $soluconsumos->dirnombre = $Nombrecompdir;
        $soluconsumos->diracargo = $Nombredircargo;


        $soluconsumos->viauno = $proddos;  //via 
        $soluconsumos->viaunonombre = $Nombrecompvia;
        $soluconsumos->viaunocargo = $Nombreviacargo;

        $soluconsumos->viados = $IdEmp;  //via 
        $soluconsumos->viadosnombre = $Nombrecompviatress;
        $soluconsumos->viadoscargo = $Nombreviacargotress;


        $soluconsumos->idlocalidad = $request->get('idlocalidad');
        $soluconsumos->codlocalidad = $Codlocalidad;
        $soluconsumos->nombrelocalidad = $Nombrelocalid;
        $soluconsumos->distancialocalidad = $Distancialocalid;
      

        $soluconsumos->idarea = $personalArea->idarea;  //de , nombre, cargo oficina
     

        $soluconsumos->idusuario =$id;
        $soluconsumos->usuarionombre = $Nombrecompusuario;
        $soluconsumos->usuariocargo = $Nombreusuariocargo;


        $soluconsumos->referencia = $request->input('referencia');
        $soluconsumos->fechasol = Carbon::now();

        $soluconsumos->detallesouconsumo = $request->input('detallesouconsumo');

        $soluconsumos->fechasalida = $request->input('fechasalida');
        $soluconsumos->fecharetorno = $request->input('fecharetorno');

    
        $soluconsumos->tsalida = $request->input('tsalida');
        $soluconsumos->tllegada = $request->input('tllegada');


        $soluconsumos->estadosoluconsumo = 1;
        $soluconsumos->tipo = "producto";
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
        $FEchasol= $soluconsumos->fechasol;
        $areas = DB::table('areas')->get();
        $localidades = DB::table('localidad')->get();
        $empleados = DB::table('empleados')->get();
   

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados; 
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;

        $date = Carbon::now();
$encargado = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea', $id3)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();

$encargadodos = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea',11)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();

$encargadotres = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea',19)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();


$Areanm = AreasModel::find($id3);
$NmBr =$Areanm ->nombrearea;
$oFICI="OFICINA DE";
$NomFci= $oFICI . " " .  $NmBr;

        return view('transportes.pedidoparcial.editar',

        compact('id','soluconsumos','areas',
        'empleados','localidades','personalArea',
        'encargado','encargadodos','encargadotres','NomFci','FEchasol'));
    }

    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;

// de parte de
$Areanm = AreasModel::find($id3);
$NmBr =$Areanm ->nombrearea;
$oFICI="OFICINA DE";
$NomFci= $oFICI . " " .  $NmBr;

$productocinco = EmpleadosModel::find($userdate->idemp);
$Nombreusuario = $productocinco->nombres;
$Apellidopausuario = $productocinco->ap_pat;
$Apellidomausuario = $productocinco->ap_mat;
$Nombrecompusuario= $Nombreusuario . " " .  $Apellidopausuario. " " .$Apellidomausuario ;

$IdFiletres = $productocinco->idfile;
$productoseis = FileModel::find($IdFiletres);
$Nombreusuariocargo = $productoseis->nombrecargo;


// dirigido a
$encargado = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea', $id3)
->select('emp.nombres','emp.idemp','emp.ap_pat','emp.ap_mat','e.abrev','e.cargo')
->first();
// dirigido a

$prod = 1435;
        $producto = EmpleadosModel::find($prod);
        $Nombredir = $producto->nombres;
        $Apellidopadir = $producto->ap_pat;
        $Apellidomadir = $producto->ap_mat;
        $Nombrecompdir= $Nombredir . " " .  $Apellidopadir. " " .$Apellidomadir ;

        $IdFile = $producto->idfile;
        $productodos = FileModel::find($IdFile);
        $Nombredircargo = $productodos->nombrecargo;


// via uno

$proddos = 1438;
$productotres = EmpleadosModel::find($proddos);
$Nombrevia = $productotres->nombres;
$Apellidopavia = $productotres->ap_pat;
$Apellidomavia = $productotres->ap_mat;
$Nombrecompvia= $Nombrevia . " " .  $Apellidopavia. " " .$Apellidomavia ;

$IdFiledos = $productotres->idfile;
$productocuatro = FileModel::find($IdFiledos);
$Nombreviacargo = $productocuatro->nombrecargo;



$IdEmp = $encargado->idemp;
$CarGoviatress = $encargado->abrev;
$Nombreviatress = $encargado->nombres;
$Apellidopaviatress = $encargado->ap_pat;
$Apellidomaviatress = $encargado->ap_mat;
$Nombrecompviatress= $CarGoviatress . " " .  $Nombreviatress . " " .  $Apellidopaviatress. " " .$Apellidomaviatress ;

$Nombreviacargotress = $encargado->cargo;







$proddoss = $request->get('idlocalidad');
$productoocho = LocalidadModel::find($proddoss);
$Codlocalidad = $productoocho->codlocalidad;
$Nombrelocalid = $productoocho->nombrelocalidad;
$Distancialocalid = $productoocho->distancialocalidad;

        $soluconsumos = SoluconsumoModel::find($request->idsoluconsumo);

        
        $soluconsumos->oficina = $NomFci;
        $soluconsumos->cominterna = $request->get('cominterna');

        
        $soluconsumos->dirigidoa = $prod;  //dirigido a
        $soluconsumos->dirnombre = $Nombrecompdir;
        $soluconsumos->diracargo = $Nombredircargo;


        $soluconsumos->viauno = $proddos;  //via 
        $soluconsumos->viaunonombre = $Nombrecompvia;
        $soluconsumos->viaunocargo = $Nombreviacargo;

        $soluconsumos->viados = $IdEmp;  //via 
        $soluconsumos->viadosnombre = $Nombrecompviatress;
        $soluconsumos->viadoscargo = $Nombreviacargotress;


        $soluconsumos->idarea = $personalArea->idarea;  //de , nombre, cargo oficina
     

        $soluconsumos->idusuario =$id;
        $soluconsumos->usuarionombre = $Nombrecompusuario;
        $soluconsumos->usuariocargo = $Nombreusuariocargo;


        $soluconsumos->referencia = $request->input('referencia');
        $soluconsumos->fechasol = Carbon::now();
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

    public function editrechazado($idsoluconsumo){


        $soluconsumos = SoluconsumoModel::find($idsoluconsumo);

        $areas = DB::table('areas')->get();
        $localidades = DB::table('localidad')->get();
        $empleados = DB::table('empleados')->get();
   

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados; 
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;

        $date = Carbon::now();
$encargado = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea', $id3)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();

$encargadodos = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea',11)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();

$encargadotres = DB::table('encargados as e')
->join('areas as a', 'a.idarea', '=', 'e.idarea')
->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
-> where('a.idarea',19)
->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
->first();


$Areanm = AreasModel::find($id3);
$NmBr =$Areanm ->nombrearea;
$oFICI="OFICINA DE";
$NomFci= $oFICI . " " .  $NmBr;

        return view('transportes.pedidoparcial.editrechazado',

        compact('id','soluconsumos','areas',
        'empleados','localidades','personalArea','date',
        'encargado','encargadodos','encargadotres','NomFci'));
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

    's.viadosnombre', //departe de 
    's.viadoscargo', //departe de 
    
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

