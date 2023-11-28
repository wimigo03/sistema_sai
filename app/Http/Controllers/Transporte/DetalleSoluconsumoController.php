<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Transporte\Temporal5Model;

use App\Models\Transporte\UnidaddConsumoModel;
use App\Models\Transporte\DetalleSoluconsumoModel;

use App\Models\Transporte\SoluconsumoModel;


use App\Models\Almacen\ValeModel;


use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use NumerosEnLetras;
use PDF;

use App\Models\EmpleadosModel;
use App\Models\FileModel;
use App\Models\AreasModel;


class DetalleSoluconsumoController extends Controller
{
    public function index(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal5Model::find($id);

        $id2 = $detalle->idsoluconsumo;

        $prodserv = DB::table('detallesoluconsumo as d')

                        ->join('unidadconsumo as uni', 'uni.idunidadconsumo', '=', 'd.idunidadconsumo')
                        ->join('soluconsumo as sol', 'sol.idsoluconsumo', '=', 'd.idsoluconsumo')

                        ->select('d.iddetallesoluconsumo','uni.nombreuconsumo','d.codigoconsumo',
                        'd.marcaconsumo','d.placaconsum','d.kilometrajeactual','d.chofernombre',
                         'uni.idunidadconsumo','uni.marcaconsumo','uni.placaconsumo',
                        'uni.kilometrajefinalconsumo')

                        ->where('d.idsoluconsumo', $id2)
                        ->orderBy('d.iddetallesoluconsumo', 'desc')
                        ->get();

        $productos = DB::table('unidadconsumo')
                        ->where('estadoconsumo',1)
                        ->select(DB::raw("concat(codigoconsumo,' // ',nombreuconsumo,' // ',placaconsumo,
                        ' // klm anter. ',kilometrajefinalconsumo) as prodservicio"),'idunidadconsumo')
                        ->pluck('prodservicio','idunidadconsumo');

        $empleados = DB::table('empleados as emp')
                       ->join('areas as a', 'a.idarea', '=', 'emp.idarea')
                       ->join('file as fi', 'fi.idfile', '=', 'emp.idfile')
                        ->select(DB::raw("concat(emp.nombres ,' ', emp.ap_pat,' ',emp.ap_mat,' ',
                                    ' // AREA: ',a.nombrearea,' ',' // Cargo: ',fi.nombrecargo
                                    ) as emplead"),'emp.idemp')

                                    ->where('emp.estadoemp1',1)
                                    ->pluck('emplead','emp.idemp');      
                                    
                                    $consumos = DB::table('soluconsumo as s')
                     
                                    ->where('s.idsoluconsumo', $id2)
                                    ->select('s.idsoluconsumo','s.estado3')
                                    ->first();
                                                          


        return view('transportes.detalle.index',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'empleados'=>$empleados,
        'consumos'=>$consumos,
        'idsoluconsumo'=>$id2]);
    }

    public function index2(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal5Model::find($id);

        $id2 = $detalle->idsoluconsumo;

        $prodserv = DB::table('detallesoluconsumo as d')

                        ->join('unidadconsumo as uni', 'uni.idunidadconsumo', '=', 'd.idunidadconsumo')
                        ->join('soluconsumo as sol', 'sol.idsoluconsumo', '=', 'd.idsoluconsumo')

                        ->select('d.iddetallesoluconsumo','d.codigoconsumo','d.marcaconsumo','d.estadodetalle','d.placaconsum','d.kilometrajeactual',
                         'uni.idunidadconsumo','uni.marcaconsumo','uni.placaconsumo',
                        'uni.kilometrajefinalconsumo')

                        ->where('d.idsoluconsumo', $id2)
                        ->orderBy('d.iddetallesoluconsumo', 'desc')
                        ->get();

        $productos = DB::table('unidadconsumo')
                        ->where('estadoconsumo',1)
                        ->select(DB::raw("concat(nombreuconsumo,' // ',placaconsumo,
                        ' // klm anter. ',kilometrajefinalconsumo) as prodservicio"),'idunidadconsumo')
                        ->pluck('prodservicio','idunidadconsumo');

                     


        return view('transportes.detalle.index2',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        
        'idsoluconsumo'=>$id2]);
    }


    public function store (Request $request){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $detalle = Temporal5Model::find($id);
        
        $id2 = $detalle->idsoluconsumo;
//accede a la tabla producto servicio

        $prod = $request->get('producto');
        $producto = UnidaddConsumoModel::find($prod);

        $Codigoconsumo = $producto->codigoconsumo;
        $Marcaconsumo = $producto->marcaconsumo;
        $Placaconsumo = $producto->placaconsumo;
     
        $Klmactual = $producto->kilometrajefinalconsumo;
        $Gaxklm = $producto->gasporklm;

        $Tipouni = $producto->idtipomovilidad;
           

//requiere el kilometraje actual

$proddos = $request->get('chofer');
$productotres = EmpleadosModel::find($proddos);
$Nombrevia = $productotres->nombres;
$Apellidopavia = $productotres->ap_pat;
$Apellidomavia = $productotres->ap_mat;
$Nombrecompvia= $Nombrevia . " " .  $Apellidopavia. " " .$Apellidomavia ;

$IdFiledos = $productotres->idfile;
$productocuatro = FileModel::find($IdFiledos);
$Nombreviacargo = $productocuatro->nombrecargo;
      


        $detalle = new DetalleSoluconsumoModel;



        $detalle->idunidadconsumo = $request->get('producto');
        $detalle->idsoluconsumo = $id2;
        $detalle->kilometrajeactual = $request->get('cantidad');

        $detalle->codigoconsumo = $Codigoconsumo;
        $detalle->marcaconsumo = $Marcaconsumo;
        $detalle->placaconsum = $Placaconsumo;

        $detalle->klmanterior = $Klmactual;
    
        $detalle->gasporklm = $Gaxklm;
    
        $detalle->idtipomovilidad = $Tipouni;

        // aumentando chofer

        
        $detalle->idchofer = $request->get('chofer');  //via 
        $detalle->chofernombre = $Nombrecompvia;
        $detalle->chofercargo = $Nombreviacargo;
        $detalle->estadodetalle = 2;
        $detallito = DB::table('detallesoluconsumo as d')

        ->join('unidadconsumo as uni', 'uni.idunidadconsumo',  'd.idunidadconsumo')
        ->join('soluconsumo as sol', 'sol.idsoluconsumo',  'd.idsoluconsumo')

        ->select('d.iddetallesoluconsumo', 'uni.idunidadconsumo','uni.marcaconsumo','uni.placaconsumo',
                        'uni.kilometrajefinalconsumo')
                        -> orwhere('d.idunidadconsumo', $prod)

                        ->where('d.idsoluconsumo', $id2)->get();
                        

        if($detallito->isEmpty()){
            $detalle->save();          
            $idDetalle=$detalle->idsoluconsumo;
            
            $progrmi = SoluconsumoModel::find($idDetalle);
            $progrmi -> estado3=2;
            $progrmi->save();  
            
            $request->session()->flash('message', 'Registro Agregado');
        }else{
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('transportes.detalle.index');
    }

    public function delete($id){
        $detalle = DetalleSoluconsumoModel::find($id);
        $detalle->delete();

        return redirect()->route('transportes.detalle.index');
    }

    public function aprovar($id)
    {
        $detalle = DetalleSoluconsumoModel::find($id);

        $Idunidad = $detalle->idunidadconsumo;
        $Idsoluconsumo = $detalle->idsoluconsumo;

 
          // para vale
          $Codigoconsumo = $detalle->codigoconsumo;
          $Marcaconsumo = $detalle->marcaconsumo;
          $Placaconsumo = $detalle->placaconsum;

          $Kilometrajeactualconsumo = $detalle->kilometrajeactual;
          $Kiloanterior = $detalle->klmanterior;
          $Gasporklm = $detalle->gasporklm;

         //sacar id de chofer nombre y cargo
          $IdChoF = $detalle->idchofer;
          $NombreChof = $detalle->chofernombre;
          $CargoChof = $detalle->chofercargo;
         // para vale

         //para sacar cuanto de combustible nececita
         $CalAproxrest = $Kilometrajeactualconsumo-$Kiloanterior;
         $CalAprox = $CalAproxrest/$Gasporklm;
         
         //convertir a 2 decimales
         $CalAproxdos = number_format($CalAprox, 2);

        $productoS  = SoluconsumoModel::find($Idsoluconsumo);
        $Fechasalida = $productoS->fechasalida;
        $Fecharetorno = $productoS->fecharetorno;

        // para vale
        $Idarea = $productoS->idarea;

        // $Idusuario = $productoS->idusuario;
        // $Usuariocargo = $productoS->usuariocargo;
        // $Usuarionombre = $productoS->usuarionombre;

        $Idlocalidad = $productoS->idlocalidad;
        $Codlocalidad = $productoS->codlocalidad;
       $Nombrelocalidad = $productoS->nombrelocalidad;
        $Distancialocalidad = $productoS->distancialocalidad;


        $Detallesouconsumo = $productoS->detallesouconsumo;

         // para vale

        $producto = UnidaddConsumoModel::find($Idunidad);
        $producto->estadoconsumo = 2;
        $producto->fechasalida = $Fechasalida;
        $producto->fecharetorno = $Fecharetorno;
//actualizando los kilometrajes
        $producto->kilometrajeinicialconsumo = $Kiloanterior;
        $producto->kilometrajefinalconsumo = $Kilometrajeactualconsumo;

        $producto->save();


        
        $soluconsumo = SoluconsumoModel::find($Idsoluconsumo);
        $soluconsumo->estadosoluconsumo = 2;
        $soluconsumo->save();

     
        
        $vales = new ValeModel();

        $vales->idarea = $Idarea;

        $vales->idusuario = $IdChoF;
        $vales->usuariocargo = $CargoChof;
        $vales->usuarionombre = $NombreChof;

        $vales->idunidad = $Idunidad;
        $vales->codigoconsumo = $Codigoconsumo;
        $vales->marcaconsumo = $Marcaconsumo;
        $vales->placaconsumo = $Placaconsumo;
        $vales->kilometrajeactualconsumo = $Kilometrajeactualconsumo;
        $vales->kiloanterior = $Kiloanterior;
        $vales->gasporklm = $Gasporklm;


        $vales->idlocalidad = $Idlocalidad;
        $vales->codlocalidad = $Codlocalidad;
        $vales->nombrelocalidad = $Nombrelocalidad;
        $vales->distancialocalidad = $Distancialocalidad;


        $vales->aproxgas = $CalAproxdos;



        $vales->detallesouconsumo = $Detallesouconsumo;
      
        $vales->estadovale = 1;
        $vales->estado1 = 1;
        $vales->estado2 = 1;
        $vales->save();

        return redirect()->route('transportes.detalle.index2');

    }
}

