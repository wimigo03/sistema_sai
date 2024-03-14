<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\TemporalModel;

use App\Models\Compra\CompraCombModel;
use App\Models\Compra\ProgramaCombModel;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\Canasta\Dea;
class CompraCombController2 extends Controller
{
    public function index(){
        
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $compras = DB::table('compracomb as c')
                        ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
                        ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'c.idcatprogramaticacomb')
                     
                        ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                        ->join('deas as da', 'da.id', '=', 'c.iddea')

                        ->select('c.idcompracomb','c.estado1','c.controlinterno','c.estadocompracomb','c.fechasoli'
                        ,'c.fechaaprob','a.nombrearea',
                        'c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo','c.tipo',
                        'c.numcompra','cat.codcatprogramatica','da.descripcion')
                        //añadir despues para que solo puedan ver sus areas
                        // ->where('a.idarea',$personalArea->idarea)
                        ->orderBy('c.idcompracomb', 'desc')
                        ->get();
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('combustibles.pedidoparcial.index',
        ['compras'=>$compras,'idd'=>$personalArea]);
    }

    public function index2(){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $compras = DB::table('compracomb as c')
                        ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
                        ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'c.idcatprogramaticacomb')
                        ->join('programacomb as prog', 'prog.idprogramacomb', '=', 'c.idprogramacomb')
                        ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                        ->join('deas as da', 'da.id', '=', 'c.iddea')
                       
                        
                        ->select('c.idcompracomb','c.estado1','c.controlinterno','a.nombrearea',
                        'c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo',
                        'c.numcompra','c.estadocompracomb','cat.codcatprogramatica','da.descripcion')
                        ->where('a.idarea',$personalArea->idarea)
                        ->where('c.estadocompracomb',2)
                        ->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

     

        return view('combustibles.pedidoparcial.index2',
        ['compras'=>$compras,'idd'=>$personalArea]);
    }




    public function create(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $IdProg=$personal->idprogramacomb;
        $id3 = $personalArea->idarea;

        $Areanm = AreasModel::find($id3);
        $NmBr =$Areanm ->nombrearea;
        $oFICI="OFICINA DE";
        $NomFci= $oFICI . " " .  $NmBr;


        $proveedores = DB::table('proveedor')->where('estadoproveedor',1)
        ->pluck('nombreproveedor','idproveedor');

        $areas = DB::table('areas')->where('estadoarea',1)
        ->pluck('nombrearea','idarea');

        $catprogramaticas = DB::table('catprogramaticacomb')
        ->select(DB::raw("concat('CODIGO: ',codcatprogramatica,' //NOMBRE: ',nombrecatprogramatica) 
        as programatica"),'idcatprogramaticacomb')
        ->where('estadocatprogramatica',1)
        ->where('idcatprogramaticacomb', '!=', 1)
        ->orderBy('idcatprogramaticacomb', 'asc')
        ->pluck('programatica','idcatprogramaticacomb');

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

        $date = Carbon::now();

        return view('combustibles.pedidoparcial.create',
        compact('proveedores','areas','catprogramaticas',
        'personalArea','date','encargado','encargadodos','NomFci'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
     
        $Iddea=$personal->dea_id;

        $id3 = $personalArea->idarea;
        $id4 = $personal->idemp;
        $Areanm = AreasModel::find($id3);
        $NmBr =$Areanm ->nombrearea;
        $oFICI="OFICINA DE";
        $NomFci= $oFICI . " " .  $NmBr;


        $produc ="PRODUCTO";
        $Tipos=$produc;

        // encargado de unidad
        $encargado = DB::table('encargados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
        -> where('a.idarea', $id3)
        ->select('e.idenc')
        ->first();

        $prod = $encargado->idenc;

        // via dir admin:
        $id5=11;
        $encargadodos = DB::table('encargados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
        -> where('a.idarea',$id5)
        ->select('e.idenc')
        ->first();
        $proddos = $encargadodos->idenc;


       

        $compras = new CompraCombModel();
        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $hora = $fechasolACT->toTimeString();

        $compras->fechasoli = $fechasolACT;
        $compras->horasoli = $hora;
        $compras->gestionsoli = $gesti;

        $compras->oficinade = $NomFci;

        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->controlinterno = $request->input('controlinterno');
        $compras->idcatprogramaticacomb = $request->input('idcatprogramatica');

        $compras->iddirigidoa = $proddos;
        $compras->idviaa = $prod;
        $compras->iddepartede = $id4;

        $compras->preventivo = 0;
        $compras->tipo =$Tipos;
        $compras->numcompra =0;
        $compras->idproveedor = 1;
        $compras->idarea = $personalArea->idarea;
        $compras->iddea = $Iddea;
        $compras->idusuario =$id;
        // $compras->estadocompracomb = 1;
        $compras->estadocompracomb = 0;
        $compras->estado1 = 1;
        $compras->estado2 = 1;
        $compras->estado3 = 0;

        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('pedidoparcialcomb.index');
    }

    public function editaruno($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);
        $id4 = $compras->fechasoli;
        $id5 = $compras->idcompracomb;

        $Fechaa =$compras ->fechasoli;
        $Horaa =$compras ->horasoli;
         $fechag = substr($Fechaa, 8, 2);
         $fecham = substr($Fechaa, 5, 2);
         $fechad = substr($Fechaa, 0, 4);
          $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $Horaa;


        $areas = DB::table('areas')
        ->where('estadoarea',1)
        ->orderBy('idarea', 'asc')
        ->get();


        $catprogramaticas = DB::table('catprogramaticacomb')
        ->where('idcatprogramaticacomb', '!=', 1)
         ->where('estadocatprogramatica',1)
         ->orderBy('idcatprogramaticacomb', 'asc')
        ->get();

        $programas = DB::table('programacomb')
         ->where('estadoprograma',1)
         ->orderBy('idprogramacomb', 'asc')
        ->get();

        $deas = DB::table('deas')
        ->where('estado',1)
        ->orderBy('id', 'asc')
       ->get();


        $proveedores = DB::table('proveedor')->get();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $IdProg=$personal->idprogramacomb;
     
        $id3 = $personalArea->idarea;

         $encargado = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('a.idarea', $id3)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
        
        $encargadodos = DB::table('encargados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
        ->orderBy('e.idenc', 'asc')
        // -> where('a.idarea',11)  el idarea 11 es unidad administrativa
        ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
        ->get();

        $departede = DB::table('empleados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
         -> where('a.idarea', $id3)
         ->orderBy('e.idemp', 'asc')
        ->select('e.nombres','e.ap_pat','e.ap_mat','fi.cargo','fi.nombrecargo','a.nombrearea','e.idemp')
        ->get();


        return view('combustibles.pedidoparcial.editaruno',

        compact('id','id4','id5','compras','proveedores','areas',
        'catprogramaticas','programas','encargadodos','encargado','departede','Fechayhora','deas'));
    }
    public function editar($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);
        $id4 = $compras->fechasoli;
        $id5 = $compras->idcompracomb;
        $id2 = $compras->iddirigidoa;
        $id3 = $compras->idviaa;
        $id8 = $compras->iddepartede;
        $id9 = $compras->idarea;
        $id6 = $compras->iddea;
        $id7 = $compras->idcatprogramaticacomb;

        $Fechaa =$compras ->fechasoli;
        $Horaa =$compras ->horasoli;
         $fechag = substr($Fechaa, 8, 2);
         $fecham = substr($Fechaa, 5, 2);
         $fechad = substr($Fechaa, 0, 4);
          $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $Horaa;


        $proveedores = DB::table('proveedor')->get();

        $areas = DB::table('areas')
        ->where('idarea',$id9)
        ->get();
        $catprogramaticas = DB::table('catprogramaticacomb')
        ->where('idcatprogramaticacomb',$id7)
        ->get();
        $programas = DB::table('deas')
        ->where('id',$id6)
        ->get();

       
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $IdProg=$personal->idprogramacomb;
     
        $id3 = $personalArea->idarea;

         $encargado = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc', $id3)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
        
        $encargadodos = DB::table('encargados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
        -> where('e.idenc',$id2)
        ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
        ->get();

        $departede = DB::table('empleados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
        -> where('e.idemp', $id8)
        ->select('e.nombres','e.ap_pat','e.ap_mat','fi.cargo','fi.nombrecargo','a.nombrearea','e.idemp')
        ->get();


        return view('combustibles.pedidoparcial.editar',

        compact('id','id4','id5','compras','proveedores','areas',
        'catprogramaticas','programas','encargadodos','encargado','departede','Fechayhora'));
    }
    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
      
        $id6fech = $request->input('id4');
        $gestionant = substr($id6fech, 0, 4);
        $mesant = substr($id6fech, 5, 2);
        $diaant = substr($id6fech, 8, 2);
        $Fechaanter= $diaant."-".$mesant."-".$gestionant;

        $fechasol = $request->get('fechasoli');
        $gestion = substr($fechasol, 6, 4);
        $mes = substr($fechasol, 3, 2);
        $dia = substr($fechasol, 0, 2);
        $Fechaactual= $dia."-".$mes."-".$gestion;

        $compras = CompraCombModel::find($request->idcompracomb);
        $compras->oficinade = $request->input('oficinade');
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->controlinterno = $request->input('controlinterno');
        $compras->tipo = $request->input('tipo');
        $compras->iddirigidoa = $request->input('iddirigidoa');
        $compras->idviaa = $request->input('idviaa');
        $compras->iddepartede = $request->input('iddepartede');
       
        $fechasolACTe = Carbon::now();
        $hora = $fechasolACTe->toTimeString();
       
         if ($Fechaanter==$Fechaactual) {
             $compras->fechasoli = $request->get('fechasoli');
         } else {
             $compras->fechasoli = $request->get('fechasoli');
             $compras->horasoli = $hora;
             $compras->gestionsoli = $gestion;
         }
        $compras->idarea = $request->input('idarea');
        $compras->iddea = $request->input('idprograma');
        $compras->idcatprogramaticacomb = $request->input('idcatprogramatica');

        $compras->idproveedor = $request->input('idproveedor');
        $compras->numcompra =$request->input('numcompra');
        $compras->preventivo = $request->input('preventivo');

        $compras->idusuario = $id;
        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('pedidoparcialcomb.index');
    }

  
    public function show($id){

    }

    public function edit($idcompracomb){//dd($idcomp); estado 1
        
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);

        if(is_null($detalle)){
            $detalle = new TemporalModel;
            $detalle->idtemporal=$id;
            $detalle->idusuario=$id;
            $detalle->idcompra=$idcompracomb;
            $detalle->save();
        }else{
            $detalle->idtemporal = $id;
            $detalle->idusuario = $id;
            $detalle->idcompra = $idcompracomb;
            $detalle->update();
        }
       //return Redirect::to('compras/detalle');
       return redirect()->route('detalleparcial.index');
    }

    public function editable($idcompracomb){//dd($idcomp); estado 2
        
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);

        if(is_null($detalle)){
            $detalle = new TemporalModel;
            $detalle->idtemporal=$id;
            $detalle->idusuario=$id;
            $detalle->idcompra=$idcompracomb;
            $detalle->save();
        }else{
            $detalle->idtemporal = $id;
            $detalle->idusuario = $id;
            $detalle->idcompra = $idcompracomb;
            $detalle->update();
        }
       //return Redirect::to('compras/detalle');
       return redirect()->route('detalleparcial.index2');
    }

    public function editalma($idcompracomb){//dd($idcomp); estado 5
        
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);

        if(is_null($detalle)){
            $detalle = new TemporalModel;
            $detalle->idtemporal=$id;
            $detalle->idusuario=$id;
            $detalle->idcompra=$idcompracomb;
            $detalle->save();
        }else{
            $detalle->idtemporal = $id;
            $detalle->idusuario = $id;
            $detalle->idcompra = $idcompracomb;
            $detalle->update();
        }
       //return Redirect::to('compras/detalle');
       return redirect()->route('detalleparcial.index4');
    }
    public function editrecha($idcompracomb){//dd($idcomp); estado 10
        
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);

        if(is_null($detalle)){
            $detalle = new TemporalModel;
            $detalle->idtemporal=$id;
            $detalle->idusuario=$id;
            $detalle->idcompra=$idcompracomb;
            $detalle->save();
        }else{
            $detalle->idtemporal = $id;
            $detalle->idusuario = $id;
            $detalle->idcompra = $idcompracomb;
            $detalle->update();
        }
       //return Redirect::to('compras/detalle');
       return redirect()->route('detalleparcial.index3');
    }


    
    public function ver($idcompracomb){

        $compras = CompraCombModel::find($idcompracomb);

        $idco =$compras ->idcompracomb;
        $id2 = $compras->iddirigidoa;
        $id3 = $compras->idviaa;
        $id4 = $compras->iddepartede;
        $id5 = $compras->idarea;
        $id6 = $compras->iddea;
        $id7 = $compras->idcatprogramaticacomb;


   $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
     
        // $IdProg=$personal->idprogramacomb;
        // $id3 = $personalArea->idarea;

       $Fechaa =$compras ->fechasoli;
       $Horaa =$compras ->horasoli;
        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);
         $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $Horaa;

         $Fechaados =$compras ->fechaaprob;
         $Horaados =$compras ->horaaprob;
          $fechagdos = substr($Fechaados, 8, 2);
          $fechamdos = substr($Fechaados, 5, 2);
          $fechaddos = substr($Fechaados, 0, 4);
           $Fechayhorados= $fechagdos . "-" .  $fechamdos. "-" .  $fechaddos. " " .  $Horaados;


        $proveedores = DB::table('proveedor')->get();


       $areas = DB::table('areas')
        ->where('idarea',$id5)
        ->get();
        $catprogramaticas = DB::table('catprogramaticacomb')
        ->where('idcatprogramaticacomb',$id7)
        ->get();
        $programas = DB::table('deas')
        ->where('id',$id6)
        ->get();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
  $encargado = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc', $id3)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
         $encargadodos = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc',$id2)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
 
         $departede = DB::table('empleados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
         -> where('e.idemp', $id4)
         ->select('e.nombres','e.ap_pat','e.ap_mat','fi.cargo','fi.nombrecargo','a.nombrearea','e.idemp')
         ->get();

        return view('combustibles.pedidoparcial.ver',

        compact('idco','id','compras','proveedores','areas',
        'catprogramaticas','programas','Fechayhorados','Fechayhora','encargadodos','encargado','departede'));
    }

    public function verdiez($idcompracomb){

        $compras = CompraCombModel::find($idcompracomb);

        $idco =$compras ->idcompracomb;
        $id2 = $compras->iddirigidoa;
        $id3 = $compras->idviaa;
        $id4 = $compras->iddepartede;
        $id5 = $compras->idarea;
        $id6 = $compras->iddea;
        $id7 = $compras->idcatprogramaticacomb;


   $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
     
        // $IdProg=$personal->idprogramacomb;
        // $id3 = $personalArea->idarea;

       $Fechaa =$compras ->fechasoli;
       $Horaa =$compras ->horasoli;
        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);
         $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $Horaa;

         $Fechaados =$compras ->fechaaprob;
         $Horaados =$compras ->horaaprob;
          $fechagdos = substr($Fechaados, 8, 2);
          $fechamdos = substr($Fechaados, 5, 2);
          $fechaddos = substr($Fechaados, 0, 4);
           $Fechayhorados= $fechagdos . "-" .  $fechamdos. "-" .  $fechaddos. " " .  $Horaados;


        $proveedores = DB::table('proveedor')->get();


       $areas = DB::table('areas')
        ->where('idarea',$id5)
        ->get();
        $catprogramaticas = DB::table('catprogramaticacomb')
        ->where('idcatprogramaticacomb',$id7)
        ->get();
        $programas = DB::table('deas')
        ->where('id',$id6)
        ->get();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
  $encargado = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc', $id3)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
         $encargadodos = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc',$id2)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
 
         $departede = DB::table('empleados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
         -> where('e.idemp', $id4)
         ->select('e.nombres','e.ap_pat','e.ap_mat','fi.cargo','fi.nombrecargo','a.nombrearea','e.idemp')
         ->get();

        return view('combustibles.pedidoparcial.verdiez',

        compact('idco','id','compras','proveedores','areas',
        'catprogramaticas','programas','Fechayhorados','Fechayhora','encargadodos','encargado','departede'));
    }

    public function vercinco($idcompracomb){

        $compras = CompraCombModel::find($idcompracomb);

        $idco =$compras ->idcompracomb;
        $id2 = $compras->iddirigidoa;
        $id3 = $compras->idviaa;
        $id4 = $compras->iddepartede;
        $id5 = $compras->idarea;
        $id6 = $compras->iddea;
        $id7 = $compras->idcatprogramaticacomb;


   $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
     
        // $IdProg=$personal->idprogramacomb;
        // $id3 = $personalArea->idarea;

       $Fechaa =$compras ->fechasoli;
       $Horaa =$compras ->horasoli;
        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);
         $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $Horaa;

         $Fechaados =$compras ->fechaaprob;
         $Horaados =$compras ->horaaprob;
          $fechagdos = substr($Fechaados, 8, 2);
          $fechamdos = substr($Fechaados, 5, 2);
          $fechaddos = substr($Fechaados, 0, 4);
           $Fechayhorados= $fechagdos . "-" .  $fechamdos. "-" .  $fechaddos. " " .  $Horaados;


        $proveedores = DB::table('proveedor')->get();


       $areas = DB::table('areas')
        ->where('idarea',$id5)
        ->get();
        $catprogramaticas = DB::table('catprogramaticacomb')
        ->where('idcatprogramaticacomb',$id7)
        ->get();
        $programas = DB::table('deas')
        ->where('id',$id6)
        ->get();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
  $encargado = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc', $id3)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
         $encargadodos = DB::table('encargados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc',$id2)
         ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','a.nombrearea','e.cargo')
         ->get();
 
         $departede = DB::table('empleados as e')
         ->join('areas as a', 'a.idarea', '=', 'e.idarea')
         ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
         -> where('e.idemp', $id4)
         ->select('e.nombres','e.ap_pat','e.ap_mat','fi.cargo','fi.nombrecargo','a.nombrearea','e.idemp')
         ->get();

        return view('combustibles.pedidoparcial.vercinco',

        compact('idco','id','compras','proveedores','areas',
        'catprogramaticas','programas','Fechayhorados','Fechayhora','encargadodos','encargado','departede'));
    }


    
    

    
    public function destroy($id){

    }
    public function respuesta4(Request $request)    {
        $ot_antigua=$_POST['ot_antigua'];
            $data = "hola";
            $data2 = "holaSSSS";
            $validarci = DB::table('compracomb as s')
            ->select('s.controlinterno')
           ->where('s.controlinterno', $ot_antigua)
            ->get();
               if($validarci->count()>0){
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }
}

