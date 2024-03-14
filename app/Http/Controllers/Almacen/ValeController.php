<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Models\Almacen\LocalidadModel;
use Illuminate\Http\Request;


use App\Models\User;

use App\Models\FileModel;
use App\Models\EmpleadosModel;

use App\Models\Almacen\ValeModel;
use App\Models\Almacen\Temporal2Model;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\Transporte\UnidaddConsumoModel;
use Carbon\Carbon;
use App\Models\Canasta\Dea;
class ValeController extends Controller
{
    public function index(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {

        $vales = DB::table('vale as v')

        ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
        ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

                        ->join('areas as a', 'a.idarea', '=', 'v.idarea')
                        ->select('v.estadovale','v.idvale','v.detallesouconsumo',

                        'v.usuarionombre','v.usuariocargo',
                        
                        'v.nombrelocalidad','v.marcaconsumo','v.placaconsumo','v.fechasolicitud',
                        'v.estado2',
                      
                        'a.nombrearea',
                        'u.nombreuconsumo',
                        // 'u.kilometrajeinicialconsumo',
                        // 'u.kilometrajefinalconsumo',
                        'lo.nombrelocalidad')

                        ->orderBy('v.idvale', 'desc');
                     
                        $vales = $vales->get();
                        return Datatables::of($vales)
                        ->addIndexColumn()
                        ->addColumn('fechasolicitud', function ($vales) {
                            return $vales->fechasolicitud;
                        })
                        ->addColumn('idvale', function ($vales) {
                            return $vales->idvale;
                        })
                        ->addColumn('nombrearea', function ($vales) {
                            return $vales->nombrearea;
                        })
                        ->addColumn('usuarionombre', function ($vales) {
                            return $vales->usuarionombre;
                        })
                        ->addColumn('usuariocargo', function ($vales) {
                            return $vales->usuariocargo;
                        })
                        ->addColumn('nombreuconsumo', function ($vales) {                                
                        return $vales->nombreuconsumo;  

                        })
                        ->addColumn('placaconsumo', function ($vales) {
                            return $vales->placaconsumo;
                        })
                        ->addColumn('nombrelocalidad', function ($vales) {
                            return $vales->nombrelocalidad;
                        })

                        ->addColumn('estadovale', function ($vales) {

                            switch ($vales->estadovale ) {
                                case '1':
                                    return '<b style="color: green">Pendiente</b>';
                                case '2':
                                    return '<b style="color: blue">Aprobada</b>';
                                case '3':
                                    return '<b style="color: purple">Almacen</b>';
                                default:
                                
                                    break;
                }   }                  
                        )

                            ->addColumn('actions', function ($vales) {
                                // $buttonHtml = '';
                                if ($vales->estadovale == 1) {
                                    $buttonHtml = '<form action="' . route('apedido.edit', $vales->idvale) . '" method="GET" style="display: inline">' .
                                    csrf_field() .
                                    method_field('GET') .
                                    '<button class="tts:left tts-slideIn tts-custom"  aria-label="Estado 1 pendiente" style="border: none;">
                                    <span class="text-primary" >
                                    <i class="fa-solid fa-1xl fa-list" ></i>
                                    
                                        </span>
                                        </button>
                                        </form>';


                                } else {
                                    if ($vales->estadovale == 2) {
                                        $buttonHtml = '<form action="' . route('apedido.editable', $vales->idvale) . '" method="GET" style="display: inline">' .
                                        csrf_field() .
                                        method_field('GET') .
                                        '<button class="btn btn-sm btn-success font-verdana" type="submit" aria-label="Estado 2 aprobado">
                                            
                                            </button>
                                            </form>';
                                } else {
                                    if ($vales->estadovale == 3) {
            
                                        $buttonHtml = '<form action="' . route('apedido.edit', $vales->idvale) . '" method="GET" style="display: inline">' .
                                        csrf_field() .
                                        method_field('GET') .
                                        '<button class="tts:left tts-slideIn tts-custom"  aria-label="Estado 3 pendiente" style="border: none;">
                                        <span class="text-primary" >
                                        <i class="fa-solid fa-1xl fa-list" ></i>
                                        
                                            </span>
                                            </button>
                                            </form>';
                                }
                             
                                 
                                }}
                                return
                        

                                '<a class="tts:left tts-slideIn tts-custom" aria-label=" Editar"  href="' . route('apedido.editar', $vales->idvale) . '">
                                <button class="tts:left tts-slideIn tts-custom" type="button" style="border: none;">
                                <span class="text-warning" >
                                <i class="fa-solid fa-2xl fa-square-pen" ></i>
                                    </span>
                                </button>
                                </a>' . ' '.$buttonHtml;
                            
                            
                            }   )

                        

                                ->rawColumns(['actions', 'estadovale'])
                                ->make(true);
                        

                     

                    }
                    $personal = User::find(Auth::user()->id);
                    $id = $personal->id;
                    $userdate = User::find($id)->usuariosempleados;
                    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
            
       return view('almacenes.pedido.index', ['idd' => $personalArea]);
    }



     public function index2(Request $request)
     {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        
         if ($request->ajax()) {
            $vales = DB::table('vale as v')

            ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
            ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')
    
            ->join('areas as a', 'a.idarea', '=', 'v.idarea')
            ->where('v.estado1',2)
                            ->select('v.estadovale','v.idvale','v.detallesouconsumo',
    
                            'v.usuarionombre','v.usuariocargo','v.codigoconsumo',
                            
                            'v.nombrelocalidad','v.marcaconsumo','v.placaconsumo',
                            'v.estado1',
                          
                            'a.nombrearea',
                            'u.codigoconsumo',
                            'lo.nombrelocalidad')
                         
                            ->orderBy('v.idvale', 'asc');
                            
    
                            return DataTables::of($vales)
                            ->addIndexColumn()
                            ->addColumn('btn', 'almacenes.pedido.btn')
                            ->addColumn('btn3', 'almacenes.pedido.btn3')
                      
                            ->rawColumns(['btn','btn3'])
                            ->make(true);
    
                        }
           return view('almacenes.pedido.index2', ['idd' => $personalArea]);
        }
    
        public function index3(Request $request)
        {
            $personal = User::find(Auth::user()->id);
            $id = $personal->id;
            $userdate = User::find($id)->usuariosempleados;
            $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
            if ($request->ajax()) {
               $vales = DB::table('vale as v')
   
               ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
               ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')
       
               ->join('areas as a', 'a.idarea', '=', 'v.idarea')
               ->where('v.estado2',2)
                               ->select('v.estadovale','v.idvale','v.detallesouconsumo',
       
                               'v.usuarionombre','v.usuariocargo','v.codigoconsumo',
                               
                               'v.nombrelocalidad','v.marcaconsumo','v.placaconsumo',
                               'v.estado1',
                             
                               'a.nombrearea',
                               'u.codigoconsumo',
                               'lo.nombrelocalidad')
                            
                               ->orderBy('v.idvale', 'asc');
                               
       
                               return Datatables::of($vales)
                               ->addIndexColumn()
                             
                               ->addColumn('btn4', 'almacenes.pedido.btn4')
                         
                               ->rawColumns(['btn4'])
                               ->make(true);
       
                           }
              return view('almacenes.pedido.index3', ['idd' => $personalArea]);
           }
       
    public function create(){
        $date = Carbon::now();
        $areas = DB::table('areas')->where('estadoarea',1)
       
        ->select(DB::raw("concat(' Codigo: ',idarea,' ',' // Nombre: ',nombrearea)
        as comineaa"),'idarea')
        ->pluck('comineaa','idarea'); 

        // $programas = DB::table('programacomb')
        // ->where('estadoprograma',1)
        // ->select(DB::raw("concat(' Codigo: ',codigoprogr,' ',' // Nombre: ',nombreprograma)
        // as comine"),'idprogramacomb')
        // ->pluck('comine','idprogramacomb');

        $partidas = DB::table('partidacomb')
        ->where('estadopartida',1)
        ->select(DB::raw("concat(' Codigo: ',codigopartida,' ',' // Nombre: ',nombrepartida)
        as cominee"),'idpartidacomb')
        ->pluck('cominee','idpartidacomb'); 
       
        $comingresos = DB::table('comingreso as comin')
       ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
       ->where('comin.idcomingreso','!=', 0)
       ->where('comin.estadoingreso',2)
       ->orderBy('comin.idcomingreso', 'asc')
       ->select(DB::raw("concat(' Cpbte: ',comin.idcomingreso,' //Codigo: ',cat.codcatprogramatica,' ',' // Nombre: ',cat.nombrecatprogramatica)
       as comin"),'comin.idcomingreso')
       ->pluck('comin','comin.idcomingreso');  

       $localidades = DB::table('localidad')
       ->select(DB::raw("concat(' Cod: ',idlocalidad,' Nom: ',nombrelocalidad,' Dist: ',distancialocalidad,' Distri: ',distrito)
       as localida"),'idlocalidad')
       ->where('estadolocalidad',1)
       ->orderBy('idlocalidad', 'asc')
       ->pluck('localida','idlocalidad');

         $consumos = DB::table('unidadconsumo')
         ->select(DB::raw("concat(' Codigo: ',codigoconsumo,'//Nombre: ',nombreuconsumo,' //Placa: ',placaconsumo,' //klm Ant.: ',kilometrajefinalconsumo)
          as unidadcon"),'idunidadconsumo')
         ->where('estadoconsumo',1)
         ->orderBy('idunidadconsumo', 'asc')
         ->pluck('unidadcon','idunidadconsumo');

         $empleados = DB::table('empleados as emp')
         ->join('areas as a', 'a.idarea', '=', 'emp.idarea')
         ->join('file as fi', 'fi.idfile', '=', 'emp.idfile')
          ->select(DB::raw("concat(' Codigo: ',emp.idemp ,' ',emp.nombres ,' ', emp.ap_pat,' ',emp.ap_mat,' ',
                      ' // Cargo: ',fi.nombrecargo,' ',' // Area: ',a.nombrearea
                      ) as emplead"),'emp.idemp')
                      ->where('fi.cargo',"CHOFER")
                      ->where('emp.estadoemp1', 1)
                      ->orderBy('emp.idemp', 'asc')
                      ->pluck('emplead','emp.idemp');  


        return view('almacenes.pedido.create',
        compact('date','localidades','areas','comingresos','consumos','empleados','partidas'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $id3 = $personal->idprogramacomb;

        $prodlocalidad = $request->get('idlocalidad');
        $prodlocaliad = LocalidadModel::find($prodlocalidad);
        $Codigolocalidad = $prodlocaliad->codlocalidad;
        $nombrelocalidad = $prodlocaliad->nombrelocalidad;
        $distancia = $prodlocaliad->distancialocalidad;



        $prod = $request->get('idunidadconsumo');
        $producto = UnidaddConsumoModel::find($prod);
        $Codigoconsumo = $producto->codigoconsumo;
        $Placaconsumo = $producto->placaconsumo;
     //todo klm anterior 
     $Klmfinal = $producto->kilometrajefinalconsumo;
     $Klminicial = $producto->kilometrajeinicialconsumo;
     $Gaxklm = $producto->gasporklm;
    //  $Tipouni = $producto->idtipomovilidad;


  //todo guardar la unidad
  $productos = UnidaddConsumoModel::find($prod);
  $productos->estadoconsumo = 2;
  
//requiere el kilometraje actual
  //todo guardar empleado
  $proddos = $request->get('idusuario');
  $Estadoemp = EmpleadosModel::find($proddos);
  $Estadoemp->estadoemp1=2;


  $productotres = EmpleadosModel::find($proddos);
  $Nombrevia = $productotres->nombres;
  $Apellidopavia = $productotres->ap_pat;
  $Apellidomavia = $productotres->ap_mat;
  $Nombrecompvia= $Nombrevia . " " .  $Apellidopavia. " " .$Apellidomavia ;
  
  $IdFiledos = $productotres->idfile;
  $productocuatro = FileModel::find($IdFiledos);
  $Nombreviacargo = $productocuatro->nombrecargo;
        
  //todo klm actual 
  $KLMactual = $request->get('cantidad');

//para sacar cuanto de combustible nececita
//el siguiente calculo se resta el klm actual menos el anterior 
// ejm CalA = 280 - 200 = 80
$CalAproxrest = $KLMactual-$Klmfinal;
//luego eso divido con lo que gasta el vehiculo 00003 gxkl 5.89
// ejm Cal=80 / 5.89  = 13.58234295
$CalAprox = $CalAproxrest/$Gaxklm;
//convertir a 2 decimales
$CalAproxdos = number_format($CalAprox, 2);
// res=13.58

        $vales = new ValeModel();
        $vales->idunidad = $request->get('idunidadconsumo');
        $vales->codigoconsumo = $Codigoconsumo;
        $vales->placaconsumo = $Placaconsumo;
        
        $vales->kilometrajeactualconsumo = $request->get('cantidad');
        $vales->kiloanterior = $Klmfinal;
        $vales->aproxgas = $CalAproxdos;
        $vales->gasporklm = $Gaxklm;

        $vales->idusuariodos = $id;

        $vales->idusuario = $request->get('idusuario');
        $vales->usuarionombre = $Nombrecompvia;
        $vales->usuariocargo = $Nombreviacargo;

        $vales->idarea = $request->input('idarea');
        $vales->idprogramacomb =$id3;
        $vales->idcomingreso = $request->input('idcomingreso');
        $vales->idpartidacomb = $request->input('idpartida');

        $vales->idlocalidad = $request->get('idlocalidad');
        $vales->codlocalidad = $Codigolocalidad;
        $vales->nombrelocalidad = $nombrelocalidad;
        $vales->distancialocalidad =$distancia;

        $vales->estadovale = 1;
        $vales->estadotemp = 1;
        $vales->estado1 = 1;
        $vales->estado2 = 1;
        $vales->estado3 = 1;

        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $hora = $fechasolACT->toTimeString();
        $vales->fechasolicitud = $fechasolACT;
        $vales->horasoli = $hora;
        $vales->gestionvale = $gesti;

        $fechasoldiamas = Carbon::now();
        $fechadiamas = $fechasoldiamas->addDay();
        $vales->fechasolicitudmasuno = $fechadiamas;

        $vales->detallesouconsumo = $request->input('detalle');
        $vales->numpreventivo = $request->input('preventivo');
        if ($KLMactual > $Klmfinal) {
            $vales->save();  

            // $KlmfinalE = $vales->kilometrajeactualconsumo;
            // $KlminicialE = $vales->kiloanterior;
            $fechasa = $vales->fechasolicitud;
            $fechadiamas = $vales->fechasolicitudmasuno;
            $horasa = $vales->horasoli;

            $Idu = $vales->idunidad;
            $Idus = $vales->idusuario;


            // $fechadia = substr($fechasa, 8, 2);
            // $fecham = substr($fechasa, 5, 2);
            // $fechaaño = substr($fechasa, 0, 4);
            // $Fechayhora= $fechadia . "/" .  $fecham. "/" .  $fechaaño;
         
            $productosuni = UnidaddConsumoModel::find($Idu);
            $productosuni->estadoconsumo = 2;
            $productosuni->fechasalida = $fechasa;
            $productosuni->horasalida = $horasa;

            $productosuni->idchofer = $Idus;
            $productosuni->fecharetorno =$fechadiamas;
            $productosuni->horaretorno = $horasa;
            $productosuni->save();


            $Estadoempe = EmpleadosModel::find($Idus);
            $Estadoempe->estadoemp1=2;
            $Estadoempe->save();

            $request->session()->flash('message', 'Registro Procesado');
        }else{
           // $request->session()->flash('message', 'El klm actual debe ser mayor que: '.$Klmfinal.' klm'  );
             $request->session()->flash('message', 'Error al Procesar Registro. El klm actual debe ser mayor que el klm anterior.');

             return redirect()->route('apedido.create');
           
        }
        return redirect()->route('apedido.index');
    }

    public function show($id){

    }

    public function edit($idval){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        
        if(is_null($detalle)){
            $detalle = new Temporal2Model;
            $detalle->idtemporal2=$id;
            $detalle->idusuario=$id;
            $detalle->idvale=$idval;
            $detalle->save();
        }else{
            $detalle->idtemporal2 = $id;
            $detalle->idusuario = $id;
           $detalle->idvale = $idval;
            $detalle->update();
        }
          return redirect()->route('adetalle.index');
     }

     public function editable($idval){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        
        if(is_null($detalle)){
            $detalle = new Temporal2Model;
            $detalle->idtemporal2=$id;
            $detalle->idusuario=$id;
            $detalle->idvale=$idval;
            $detalle->save();
        }else{
            $detalle->idtemporal2 = $id;
            $detalle->idusuario = $id;
           $detalle->idvale = $idval;
            $detalle->update();
        }
          return redirect()->route('adetalle.index2');
     }

     public function editabletres($idval){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        
        if(is_null($detalle)){
            $detalle = new Temporal2Model;
            $detalle->idtemporal2=$id;
            $detalle->idusuario=$id;
            $detalle->idvale=$idval;
            $detalle->save();
        }else{
            $detalle->idtemporal2 = $id;
            $detalle->idusuario = $id;
           $detalle->idvale = $idval;
            $detalle->update();
        }
          return redirect()->route('adetalle.index3');
     }
     
    public function editar($idvale){

        $vales = ValeModel::find($idvale);
        $id3 = $vales->idvale;
        $id2 = $vales->idcomingreso;
        $id4 = $vales->idunidad;
        $id5 = $vales->idusuario;
        $id6 = $vales->fechasolicitud;
        $id7 = $vales->iddea;
        $id8 = $vales->idarea;
        $id9 = $vales->idpartidacomb;
        $id10 = $vales->idlocalidad;

        $Estado = $vales->estadovale;
        $Estadouno = $Estado;
        $programas = DB::table('deas')
        ->where('estado',1)
        ->orderBy('id', 'asc')

        ->get();
        
        $areas = DB::table('areas')->get();

        $partidas = DB::table('partidacomb')
        ->where('estadopartida',1)
        ->select('codigopartida','nombrepartida','idpartidacomb')
        ->get();

        $comingresos = DB::table('comingreso as comin')
        ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
        ->select('comin.estadoingreso','comin.idcomingreso','cat.codcatprogramatica','cat.nombrecatprogramatica')
        ->orderBy('comin.idcomingreso', 'asc')
        ->where('comin.estadoingreso',2)       
        ->get();

        $localidades = DB::table('localidad')->get();

        $consumos = DB::table('unidadconsumo')
        ->select('estadoconsumo','idunidadconsumo','codigoconsumo','nombreuconsumo','placaconsumo','kilometrajeinicialconsumo','kilometrajefinalconsumo')
        ->orderBy('idunidadconsumo', 'asc')
        ->where(function ($query) use ($id4) {
            $query->where('estadoconsumo', '=', 1)
        ->orWhere(function ($subquery) use ($id4) {
            $subquery->where('idunidadconsumo', '=', $id4)
                     ->where('estadoconsumo', '!=', 1);
                    });
                })     
        ->get();

        $empleados = DB::table('empleados as emp')
        ->join('areas as a', 'a.idarea', '=', 'emp.idarea')
        ->join('file as fi', 'fi.idfile', '=', 'emp.idfile')
         ->select('emp.estadoemp1','emp.idemp','emp.nombres','emp.ap_pat','emp.ap_mat',
         'fi.nombrecargo','a.nombrearea')
         ->where('fi.cargo',"CHOFER")
         ->where(function ($query) use ($id5) {
            $query->where('emp.estadoemp1', '=', 1)
        ->orWhere(function ($subquery) use ($id5) {
            $subquery->where('emp.idemp', '=', $id5)
                     ->where('emp.estadoemp1', '!=', 1);
                    });
                })     
        ->get();

        $programados = DB::table('deas')
        ->where('id',$id7)
      
        ->get();

        $areados = DB::table('areas')
        ->where('idarea',$id8)
        ->get();

        
        $partidados = DB::table('partidacomb')
        ->select('codigopartida','nombrepartida','idpartidacomb')
        ->where('idpartidacomb',$id9)
        ->get();

        $localidadedos = DB::table('localidad')
        ->where('idlocalidad',$id10)
        ->get();

        $comingresotres = DB::table('comingreso as comin')
        ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
        ->select('comin.estadoingreso','comin.idcomingreso','cat.codcatprogramatica','cat.nombrecatprogramatica')
        ->orderBy('comin.idcomingreso', 'asc')
        ->where('comin.idcomingreso',$id2)
           ->get();

        $personal = User::find(Auth::user()->id);

        $id = $personal->id;


        if ($Estadouno==1) {

        return view('almacenes.pedido.editar',
        compact('id','id6','id2','id5','id4','id3','vales','localidades','areas','consumos','empleados','comingresos','programas','partidas'));
    } else {
        if ($Estadouno==2) {
        return view('almacenes.pedido.editardos',
        compact('id','id6','id2','id5','id4','id3','vales','localidadedos','areados','consumos','empleados','comingresotres','programados','partidados'));
    } else {
        if ($Estadouno==3) {
            return view('almacenes.pedido.editartres',
            compact('id','id6','id2','id5','id4','id3','vales','localidades','areas','consumos','empleados','comingresotres','programas','partidados'));
        }  else {
    }
    }  }  }


    public function update(Request $request){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
    
        $id3 = $request->input('id3');

        $id4 = $request->input('id4');
        $id4unidad =$id4;
        $id5 = $request->input('id5');
        $id5empleado =$id5;
        $id6fech = $request->input('id6');

        $gestionant = substr($id6fech, 0, 4);
        $mesant = substr($id6fech, 5, 2);
        $diaant = substr($id6fech, 8, 2);
        $Fechaanter= $diaant."-".$mesant."-".$gestionant;

        $fechasol = $request->get('fechasolicitud');
        // $fechasoldos =$fechasol;
        // $fechamd = Carbon::parse($fechasoldos);
        // $fechamdde = $fechamd->addMonth();
        // $fechamdd = $fechamdde->format('Y-d-m');

        $gestion = substr($fechasol, 6, 4);
        $mes = substr($fechasol, 3, 2);
        $dia = substr($fechasol, 0, 2);
        $Fechaactual= $dia."-".$mes."-".$gestion;
        // $fechamdd = $fechamd->addDay();
        // $fechamdd = $fechamd->addMonth();
        $prodlocalidad = $request->get('idlocalidad');
        $prodlocaliad = LocalidadModel::find($prodlocalidad);
        $Codigolocalidad = $prodlocaliad->codlocalidad;
        $nombrelocalidad = $prodlocaliad->nombrelocalidad;
        $distancia = $prodlocaliad->distancialocalidad;


        $prod = $request->get('idunidadconsumo');

        $producto = UnidaddConsumoModel::find($prod);
        $Codigoconsumo = $producto->codigoconsumo;
        $Placaconsumo = $producto->placaconsumo;
        //todo klm anterior 
        $Klmfinal = $producto->kilometrajefinalconsumo;
        $Klminicial = $producto->kilometrajeinicialconsumo;
        $Gaxklm = $producto->gasporklm;

        $id10 = $producto->idunidadconsumo;

        $proddos = $request->get('idusuario');
        $productotres = EmpleadosModel::find($proddos);
        $Nombrevia = $productotres->nombres;
        $Apellidopavia = $productotres->ap_pat;
        $Apellidomavia = $productotres->ap_mat;
        $Nombrecompvia = $Nombrevia . " " .  $Apellidopavia . " " . $Apellidomavia;
        $id11 = $productotres->idemp;
        $IdFiledos = $productotres->idfile;
        $productocuatro = FileModel::find($IdFiledos);
        $Nombreviacargo = $productocuatro->nombrecargo;


        $KLMactual = $request->get('cantidad');
        $CalAproxrest = $KLMactual - $Klmfinal;
        //luego eso divido con lo que gasta el vehiculo 00003 gxkl 3.48
        // ejm Cal=80 / 5.89  = 13.58234295
        $CalAprox = $CalAproxrest / $Gaxklm;
        //convertir a 2 decimales
        $CalAproxdos = number_format($CalAprox, 2);

        $vales = ValeModel::find($request->idvale);

        $vales->idunidad = $request->get('idunidadconsumo');
        $vales->codigoconsumo = $Codigoconsumo;
        $vales->placaconsumo = $Placaconsumo;

        $vales->kilometrajeactualconsumo = $request->get('cantidad');
        $vales->kiloanterior = $Klmfinal;
        $vales->aproxgas = $CalAproxdos;
        $vales->gasporklm = $Gaxklm;

        $vales->idusuariodos = $id;

        $vales->idusuario = $request->get('idusuario');
        $vales->usuarionombre = $Nombrecompvia;
        $vales->usuariocargo = $Nombreviacargo;

        $vales->idarea = $request->input('idarea');
        $vales->iddea =$request->input('idprograma');
        $vales->idcomingreso = $request->input('idcomingreso');
        $vales->idpartidacomb = $request->input('idpartida');

        $vales->idlocalidad = $request->get('idlocalidad');
        $vales->codlocalidad = $Codigolocalidad;
        $vales->nombrelocalidad = $nombrelocalidad;
        $vales->distancialocalidad = $distancia;

        $fechasolACT = Carbon::now();
        $hora = $fechasolACT->toTimeString();
       
        if ($Fechaanter==$Fechaactual) {
            $vales->fechasolicitud = $request->get('fechasolicitud');
          
        } else {
            $vales->fechasolicitud = $request->get('fechasolicitud');
            $vales->horasoli = $hora;
            $vales->gestionvale = $gestion;

            $fechauno = Carbon::parse($Fechaactual);
            $fechados = $fechauno->addDay();
            $fechatres = $fechados->format('Y-m-d');
       
            $vales->fechasolicitudmasuno = $fechatres;

        }

        $vales->detallesouconsumo = $request->input('detalle');
        $vales->numpreventivo = $request->input('preventivo');
        if ($KLMactual > $Klmfinal) {
            $vales->save();

            // $fechaunodos = Carbon::now();

            // dd/mm/aaaa
            //dd/mm/yyyy
            $fechauno = $vales->fechasolicitud;
            $fechacinco = $vales->fechasolicitudmasuno;
       
            // $fechados = Carbon::now($vales->fechasolicitud);
          
            // $fechatres = $fechados->addDay();

            // $fechacinco = $fechatres->format('Y-m-d');


            // $fechasadd = $vales->fechasolicitudmasuno;
            $horasa = $vales->horasoli;

            $Idu = $vales->idunidad;
            $Idus = $vales->idusuario;


            // $fechadia = substr($fechasa, 8, 2);
            // $fecham = substr($fechasa, 5, 2);
            // $fechaaño = substr($fechasa, 0, 4);
            // $Fechayhora= $fechadia . "/" .  $fecham. "/" .  $fechaaño;
            // $fechasolACTa = Carbon::now();
            // $fechares = $fechasolACTa->addDay();

            if($id4unidad == $id10){
            $productosuni = UnidaddConsumoModel::find($id10);
            $productosuni->estadoconsumo = 2;
            $productosuni->fechasalida = $fechauno;
            $productosuni->horasalida = $horasa;

            $productosuni->idchofer = $Idus;
            $productosuni->fecharetorno = $fechacinco;
            $productosuni->horaretorno = $horasa;

            $productosuni->save();

        }else{
            $productosuni = UnidaddConsumoModel::find($id10);
            $productosuni->estadoconsumo = 2;
            $productosuni->fechasalida = $fechauno;
            $productosuni->horasalida = $horasa;

            $productosuni->idchofer = $Idus;
            $productosuni->fecharetorno = $fechacinco;
            $productosuni->horaretorno = $horasa;
            $productosuni->save();

            $productosunia = UnidaddConsumoModel::find($id4unidad);
            $productosunia->estadoconsumo = 1;
            $productosunia->save();

        }

        if($id5empleado == $id11){

            $Estadoempe = EmpleadosModel::find($id11);
            $Estadoempe->estadoemp1 = 2;
            $Estadoempe->save();
             }else{
                $Estadoempe = EmpleadosModel::find($id11);
                $Estadoempe->estadoemp1 = 2;
                $Estadoempe->save();

                $Estadoempea = EmpleadosModel::find($id5empleado);
                $Estadoempea->estadoemp1 = 1;
                $Estadoempea->save();
            }
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            //$request->session()->flash('message', 'El klm actual debe ser mayor que: '.$Klmfinal.' klm'  );

            $request->session()->flash('message', 'Error al Procesar Registro. El klm actual debe ser mayor que el klm anterior.');

            return redirect()->route('apedido.editar', [$id3]);
           
        }
        return redirect()->route('apedido.index');
    }
    public function editardos($idvale){

        $vales = ValeModel::find($idvale);
        $id3 = $vales->idvale;
     

        $comingresos = DB::table('comingreso as comin')
        ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
       
        ->select('comin.idcomingreso','cat.codcatprogramatica','cat.nombrecatprogramatica')
        ->get();


        $areas = DB::table('areas')->get();
       
        $localidades = DB::table('localidad')->get();
        $consumos = DB::table('unidadconsumo')->get();
        $empleados = DB::table('empleados')->get();
        $personal = User::find(Auth::user()->id);

        $id = $personal->id;

        return view('almacenes.pedido.editar',
        compact('id','id3','vales','localidades','areas','consumos','empleados','comingresos'));
    }


    public function destroy($id){

    }
}

