<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Compra\CompraCombModel;
use App\Models\Compra\ProveedorModel;
use App\Models\User;
use App\Models\TemporalModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\EmpleadosModel;


class CompraCombController extends Controller
{
    public function index(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {
        $compras = DB::table('compracomb as c')
                        ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
                        ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'c.idcatprogramaticacomb')
                        ->join('programacomb as prog', 'prog.idprogramacomb', '=', 'c.idprogramacomb')
                        ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                        ->where('c.estadocompracomb', '!=', 0)
                        // ->where('c.estadocompracomb',1)

                        ->select(['c.estadocompracomb','c.idcompracomb','c.estado1','c.estado2','c.estado3',
                        'c.objeto', 'c.justificacion','c.preventivo','c.numcompra','c.fechasoli','c.controlinterno',
                        
                        'p.nombreproveedor','a.nombrearea','cat.codcatprogramatica','prog.nombreprograma'])

                         ->orderBy('c.idcompracomb', 'desc');
                        
                        $compras = $compras->get();

                        return DataTables::of($compras)
                        ->addIndexColumn()
                        ->addColumn('idcompracomb', function ($compras) {
                            return $compras->idcompracomb;
                        })
                        ->addColumn('fechasoli', function ($compras) {
                            return $compras->fechasoli;
                        })
                        ->addColumn('controlinterno', function ($compras) {
                            return $compras->controlinterno;
                        })
                        ->addColumn('objeto', function ($compras) {
                            return $compras->objeto;
                        })
                        ->addColumn('nombrearea', function ($compras) {
                            return $compras->nombrearea;
                        })
                        ->addColumn('nombreproveedor', function ($compras) {    
                                    return $compras->nombreproveedor;  
                        })
                        ->addColumn('preventivo', function ($compras) {
                            return $compras->preventivo;
                        })
                                         
                        ->addColumn('estadocompracomb', function ($compras) {

                            if ($compras->estadocompracomb == '1') {
                                //'<b style="color: green">Sin repuesta</b>';
                                 return  '<b style="color: green">Pendiente</b>';

                                
                            } else {
                                if ($compras->estadocompracomb == '2') {
                                    return  '<b style="color: blue">Aprobado</b>';

                            } else {
                                if ($compras->estadocompracomb == '5') {
                                    return  '<b style="color: purple">Almacen</b>';
                            }  else {

                                if ($compras->estadocompracomb == '10') {
                                    return  '<b style="color: red">Rechazado</b>';
                                }  else {
                    } }}}}
                      
                        )

                     
                ->addColumn('actions', function ($compras) {
                    // $buttonHtml = '';
                    if ($compras->estadocompracomb == 1) {
                         $buttonHtml = '<form action="' . route('pedidocomb.edit', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="border: none;">
                            <span class="text-primary" >
                            <i class="fa-solid fa-2xl fa-list" ></i>
                                </span>
                                </button>
                                </form>';
                    } else {
                        if ($compras->estadocompracomb == 2) {
                         $buttonHtml = '<form action="' . route('pedidocomb.editabledos', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="border: none;">
                            <span class="text-primary" >
                            <i class="fa-solid fa-2xl fa-list" ></i>
                                </span>
                                </button>
                                </form>';
                    } else {
                        if ($compras->estadocompracomb == 5) {

                         $buttonHtml = '<form action="' . route('pedidocomb.editabledos', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="border: none;">
                            <span class="text-primary" >
                            <i class="fa-solid fa-2xl fa-list" ></i>
                                </span>
                                </button>
                               </form>';
                    }else {
                        if ($compras->estadocompracomb == 10) {
                            $buttonHtml = '<form action="' . route('pedidocomb.editabletres', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="border: none;">
                            <span class="text-primary" >
                            <i class="fa-solid fa-2xl fa-list" ></i>
                                </span>
                                </button>
                                </form>';
                    }else {
                    } }}}   
                    return
                        

                    '<a class="tts:left tts-slideIn tts-custom" aria-label=" Editar" href="' . route('pedidocomb.ver', $compras->idcompracomb) . '">
                    <span class="text-primary" >
                    <i class="fa fa-pencil fa-fw"></i>
                </span>
                         </a>'. ' ' .$buttonHtml;

                })
                ->rawColumns(['actions', 'estadocompracomb'])
                ->make(true);
        }
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
   
       return view('combustibles.pedido.index',['idd' => $personalArea]);
    }



    public function index2(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {
        $compras = DB::table('compracomb as c')
                        ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
                        ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'c.idcatprogramaticacomb')
                        ->join('programacomb as prog', 'prog.idprogramacomb', '=', 'c.idprogramacomb')
                        ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                      
                        ->select('c.estadocompracomb','c.idcompracomb','c.controlinterno','c.fechasoli','c.estado1','c.estado2','c.estado3','a.nombrearea','c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo','c.numcompra','cat.codcatprogramatica','prog.nombreprograma')
                        ->orderBy('c.idcompracomb', 'desc')
                        ->where('c.estadocompracomb', '!=', 0)
                        ->where('c.estadocompracomb', '!=', 1)
                        ->where('c.estadocompracomb', '!=', 10);
                        //->get();
                        $compras = $compras->get();
                        return Datatables::of($compras)
                        ->addIndexColumn()
                        ->addColumn('idcompracomb', function ($compras) {
                            return $compras->idcompracomb;
                        })
                         ->addColumn('fechasoli', function ($compras) {
                             return $compras->fechasoli;
                         })
                         ->addColumn('controlinterno', function ($compras) {
                             return $compras->controlinterno;
                         })
                        ->addColumn('objeto', function ($compras) {
                            return $compras->objeto;
                        })
                        ->addColumn('nombrearea', function ($compras) {
                            return $compras->nombrearea;
                        })
                        ->addColumn('nombreproveedor', function ($compras) {                                
                        return $compras->nombreproveedor;  

                        })
                        ->addColumn('preventivo', function ($compras) {
                            return $compras->preventivo;
                        })
                    

                        ->addColumn('estadocompracomb', function ($compras) {

                            switch ($compras->estadocompracomb ) {
                               
                                    case '2':
                                    return '<b style="color: green">Pendiente</b>';
                                case '5':
                                    return '<b style="color: blue">Almacen</b>';
                                // case '10':
                                //     return '<b style="color: red">Rechazado</b>';
                                default:
                                
                                    break;
                }   }                  
                        )
                        ->addColumn('actions', function ($compras) {

                        
                               if ($compras->estadocompracomb == 2) {
                                $buttonHtml = '<form action="' . route('pedidocomb.editable', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                                   csrf_field() .
                                   method_field('GET') .
                                   '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="border: none;">
                                   <span class="text-primary" >
                                   <i class="fa-solid fa-2xl fa-list" ></i>
                                       </span>
                                       </button>
                                       </form>';
                           } else {
                               if ($compras->estadocompracomb == 5) {
       
                                $buttonHtml = '<form action="' . route('pedidocomb.editable', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                                   csrf_field() .
                                   method_field('GET') .
                                   '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="border: none;">
                                   <span class="text-primary" >
                                   <i class="fa-solid fa-2xl fa-list" ></i>
                                       </span>
                                       </button>
                                      </form>';
                           }else {
                              
                           } } 
                           return
                    
                           
                    '<a class="tts:left tts-slideIn tts-custom" aria-label=" Editar" href="' . route('pedidocomb.verr', $compras->idcompracomb) . '">
                    <span class="text-primary" >
                    <i class="fa fa-pencil fa-fw"></i>
                </span>
                         </a>'. ' ' .$buttonHtml;

                })

                          
                        ->rawColumns(['actions', 'estadocompracomb'])
                        ->make(true);

                    }
                    $personal = User::find(Auth::user()->id);
                    $id = $personal->id;
                    $userdate = User::find($id)->usuariosempleados;
                    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
            
       return view('combustibles.pedido.index2', ['idd' => $personalArea]);
    }




    public function create(){
        $proveedores = DB::table('proveedor')->where('estadoproveedor',1)->pluck('nombreproveedor','idproveedor');
        $areas = DB::table('areas')->where('estadoarea',1)->pluck('nombrearea','idarea');
        $catprogramaticas = DB::table('catprogramaticacomb')
                                ->select(DB::raw("concat(codcatprogramatica,' : ',nombrecatprogramatica) as programatica"),'idcatprogramatica')
                                ->where('estadocatprogramatica',1)
                                ->pluck('programatica','idcatprogramaticacomb');
        $programas = DB::table('programacomb')->where('estadoprograma',1)->pluck('nombreprograma','idprogramacomb');
        return view('combustibles.pedido.create',compact('proveedores','areas','catprogramaticas','programas'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $compras = new CompraCombModel();
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->preventivo = $request->input('preventivo');
        $compras->tipo = $request->input('tipo');
        $compras->numcompra =$request->input('numcompra');
        $compras->controlinterno = $request->input('controlinterno');
        $compras->idproveedor = $request->input('idproveedor');
        $compras->idarea = $request->input('idarea');
        $compras->idcatprogramaticacomb = $request->input('idcatprogramatica');
        $compras->idprogramacomb = $request->input('idprograma');
        $compras->idproveedor = $request->input('idproveedor');
        $compras->idusuario =$id;
        $compras->estadocompracomb = 1;
        $compras->estado1 = 1;
        $compras->estado2 = 1;
        $compras->estado3 = 1;
        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('combustibles.pedido.index');
    }

    public function show($id){

    }

    public function edit($idcompracomb){//dd($idcomp);
        
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
       return redirect()->route('detalle.index');
    }

    public function editable($idcompracomb){//dd($idcomp);
        
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
       return redirect()->route('detalle.index2');
    }
    public function editabledos($idcompracomb){//dd($idcomp);
        
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
       return redirect()->route('detalle.index5');
    }

    public function editabletres($idcompracomb){//dd($idcomp);
        
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
       return redirect()->route('detalle.index3');
    }

    public function editablecuatro($idcompracomb){//dd($idcomp);
        
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
       return redirect()->route('combustibles.detalle.index4');
    }


    public function editar($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);
        $proveedores = DB::table('proveedor')->get();
        $areas = DB::table('areas')->get();
        $catprogramaticas = DB::table('catprogramaticacomb')->get();
        $programas = DB::table('programacomb')->get();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        return view('combustibles.pedidocomb.editar',compact('id','compras','proveedores','areas','catprogramaticas','programas'));
    }

    public function ver($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);
        $idco =$compras ->idcompracomb;
        $id2 = $compras->iddirigidoa;
        $id3 = $compras->idviaa;
        $id4 = $compras->iddepartede;
        $id5 = $compras->idarea;
        $id6 = $compras->idprogramacomb;
        $id7 = $compras->idcatprogramaticacomb;
        $id8 = $compras->idproveedor;

        $Fechaa =$compras ->fechasoli;
        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);
        $Horaa =$compras ->horasoli;
         $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $Horaa;

         $Fechaados =$compras ->fechaaprob;
         $fechagdos = substr($Fechaados, 8, 2);
         $fechamdos = substr($Fechaados, 5, 2);
         $fechaddos = substr($Fechaados, 0, 4);
         $Horaados =$compras ->horaaprob;
          $Fechayhorados= $fechagdos . "-" .  $fechamdos. "-" .  $fechaddos. " " .  $Horaados;


        $proveedores = DB::table('proveedor')
        ->where('idproveedor', '!=', 1)
        ->where('estadoproveedor',1)
        ->get();

        $proveedordos = DB::table('proveedor')
        ->where('idproveedor', '!=', 1)
        ->where('idproveedor',$id8)
        ->get();


        $areas = DB::table('areas')
        ->where('idarea',$id5)
        ->get();
        $catprogramaticas = DB::table('catprogramaticacomb')
        ->where('idcatprogramaticacomb',$id7)
        ->get();
        $programas = DB::table('programacomb')
        ->where('idprogramacomb',$id6)
        ->get();
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $comprasestado = CompraCombModel::find($idcompracomb);
        $EstadoCOM = $comprasestado->estadocompracomb;
        $Estadoun = $EstadoCOM;
        // $Proveedor = CompraCombModel::find($compras->idcompracomb);
        // $Proveedordd = $Proveedor->idproveedor;
        // $Proveedor=$compras->idproveedor;
        $encargado = DB::table('encargados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc', $id3)
        ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','e.cargo','a.nombrearea')
        ->get();
       
       $encargadodos = DB::table('encargados as e')
       ->join('areas as a', 'a.idarea', '=', 'e.idarea')
       ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
       -> where('e.idenc',$id2)
       ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','e.cargo','a.nombrearea')
       ->get();

       $departede = DB::table('empleados as e')
       ->join('areas as a', 'a.idarea', '=', 'e.idarea')
       ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
        -> where('e.idemp', $id4)
       ->select('e.nombres','e.ap_pat','e.ap_mat','fi.cargo','fi.nombrecargo','a.nombrearea','e.idemp')
       ->get();

        if ($Estadoun==1) {
            return view('combustibles.pedido.editar',compact('idco','departede','encargadodos','encargado','id','compras','proveedores','areas','catprogramaticas','programas','Fechayhora'));

        } else {
            if ($Estadoun==2) {    
        return view('combustibles.pedido.ver',compact('Fechayhorados','idco','departede','encargadodos','encargado','id','compras','proveedordos','areas','catprogramaticas','programas','Fechayhora'));
    } else {
        if ($Estadoun==5) { 
        return view('combustibles.pedido.verdos',compact('Fechayhorados','idco','departede','encargadodos','encargado','id','compras','proveedordos','areas','catprogramaticas','programas','Fechayhora'));
  } else {
    if ($Estadoun==10) { 
        return view('combustibles.pedido.veruno',compact('Fechayhorados','idco','departede','encargadodos','encargado','id','compras','proveedordos','areas','catprogramaticas','programas','Fechayhora'));      
    } else {
        return view('combustibles.pedido.ver',compact('Fechayhorados','idco','departede','encargadodos','encargado','id','compras','proveedordos','areas','catprogramaticas','programas','Fechayhora'));

        }    
        } 
    } } 
    }

    public function verr($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);
        $idco =$compras ->idcompracomb;
        $id2 = $compras->iddirigidoa;
        $id3 = $compras->idviaa;
        $id4 = $compras->iddepartede;
        $id5 = $compras->idarea;
        $id6 = $compras->idprogramacomb;
        $id7 = $compras->idcatprogramaticacomb;
        $id8 = $compras->idproveedor;

        $Fechaa =$compras ->fechasoli;
        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);
        $Horaa =$compras ->horasoli;
         $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $Horaa;

         $Fechaados =$compras ->fechaaprob;
         $fechagdos = substr($Fechaados, 8, 2);
         $fechamdos = substr($Fechaados, 5, 2);
         $fechaddos = substr($Fechaados, 0, 4);
         $Horaados =$compras ->horaaprob;
          $Fechayhorados= $fechagdos . "-" .  $fechamdos. "-" .  $fechaddos. " " .  $Horaados;

          $Fechaatres =$compras ->fechaalmacen;
          $fechagtres = substr($Fechaatres, 8, 2);
          $fechamtres = substr($Fechaatres, 5, 2);
          $fechadtres = substr($Fechaatres, 0, 4);
          $Horaatres =$compras ->horaalmacen;
           $Fechayhoratres= $fechagtres . "-" .  $fechamtres. "-" .  $fechadtres. " " .  $Horaatres;



        $proveedores = DB::table('proveedor')
        ->where('idproveedor', '!=', 1)
        ->get();

        $proveedordos = DB::table('proveedor')
        ->where('idproveedor', '!=', 1)
        ->where('idproveedor',$id8)
        ->get();


        $areas = DB::table('areas')
        ->where('idarea',$id5)
        ->get();
        $catprogramaticas = DB::table('catprogramaticacomb')
        ->where('idcatprogramaticacomb',$id7)
        ->get();
        $programas = DB::table('programacomb')
        ->where('idprogramacomb',$id6)
        ->get();
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $comprasestado = CompraCombModel::find($idcompracomb);
        $EstadoCOM = $comprasestado->estadocompracomb;
        $Estadoun = $EstadoCOM;
        // $Proveedor = CompraCombModel::find($compras->idcompracomb);
        // $Proveedordd = $Proveedor->idproveedor;
        // $Proveedor=$compras->idproveedor;
        $encargado = DB::table('encargados as e')
        ->join('areas as a', 'a.idarea', '=', 'e.idarea')
        ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
         -> where('e.idenc', $id3)
        ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','e.cargo','a.nombrearea')
        ->get();
       
       $encargadodos = DB::table('encargados as e')
       ->join('areas as a', 'a.idarea', '=', 'e.idarea')
       ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
       -> where('e.idenc',$id2)
       ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev','e.idenc','e.cargo','a.nombrearea')
       ->get();

       $departede = DB::table('empleados as e')
       ->join('areas as a', 'a.idarea', '=', 'e.idarea')
       ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
        -> where('e.idemp', $id4)
       ->select('e.nombres','e.ap_pat','e.ap_mat','fi.cargo','fi.nombrecargo','a.nombrearea','e.idemp')
       ->get();

        if ($Estadoun==2) {
            return view('combustibles.pedido.vertres',compact('Fechayhorados','idco','departede','encargadodos','encargado','id','compras','proveedordos','areas','catprogramaticas','programas','Fechayhora'));

        } else {
            if ($Estadoun==5) {    
                return view('combustibles.pedido.vercinco',compact('Fechayhoratres','Fechayhorados','idco','departede','encargadodos','encargado','id','compras','proveedordos','areas','catprogramaticas','programas','Fechayhora'));
            } else {
       
        return view('combustibles.pedido.verdos',compact('Fechayhorados','idco','departede','encargadodos','encargado','id','compras','proveedordos','areas','catprogramaticas','programas','Fechayhora'));
          
    } } 
    }

    
    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $compras = CompraCombModel::find($request->idcompracomb);
        // $compras->oficinade = $request->input('oficinade');
        // $compras->objeto = $request->input('objeto');
        // $compras->justificacion = $request->input('justificacion');
        // $compras->controlinterno = $request->input('controlinterno');
        //$compras->tipo = $request->input('tipo');
        //$compras->iddirigidoa = $request->input('iddirigidoa');
        //$compras->idviaa = $request->input('idviaa');
        //$compras->iddepartede = $request->input('iddepartede');

        $compras->preventivo = $request->input('preventivo');
        $compras->numcompra =$request->input('numcompra');
        $compras->idproveedor = $request->input('idproveedor');
        //  $compras->idarea = $request->input('idarea');
        //$compras->idcatprogramaticacomb = $request->input('idcatprogramatica');
        //$compras->idprogramacomb = $request->input('idprograma');
        $compras->iduseredit = $id;
        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('pedidocomb.index');
    }

    public function destroy($id){

    }

    public function respuesta5(Request $request)    {
        $ot_antigua=$_POST['ot_antigua'];
            $data = "hola";
            $data2 = "holaSSSS";
            $validarci = DB::table('compracomb as s')
            ->select('s.preventivo')
           ->where('s.preventivo', $ot_antigua)
            ->get();
               if($validarci->count()>0){
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }


    public function respuesta6(Request $request)    {
        $ot_antigua=$_POST['ot_antigua'];
            $data = "hola";
            $data2 = "holaSSSS";
            $validarci = DB::table('compracomb as s')
            ->select('s.numcompra')
           ->where('s.numcompra', $ot_antigua)
            ->get();
               if($validarci->count()>0){
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }
}

