<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
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
                                        return '<a class="tts:left tts-slideIn tts-custom" aria-label=" Ir a detalle" href="' . route('almacenes.pedido.edit', $vales->idvale) . '">
                                        <button class="tts:left tts-slideIn tts-custom" aria-label="Detalle" style="border: none;">
                                        <span class="text-warning" >
                                        <i class="fa-solid fa-2xl fa-square-pen" ></i>
                                            </span>
                                            </button>
                                        </a>';
                                } else {
                                    if ($vales->estadovale == 2) {
                                        return '<a class="tts:left tts-slideIn tts-custom" aria-label=" Ir a detalle" href="' . route('almacenes.pedido.editable', $vales->idvale) . '">
                                        <button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="border: none;">
                                        <span class="text-primary" >
                                        <i class="fa-solid fa-2xl fa-list" ></i>
                                            </span>
                                            </button>
                                    </a>';
                                } else {
                                    if ($vales->estadovale == 3) {
            
                                        return '<a class="tts:left tts-slideIn tts-custom" aria-label=" boton uno" href="' . route('almacenes.pedido.editabletres', $vales->idvale) . '">
                                        <button class="tts:left tts-slideIn tts-custom" aria-label="Detalle" style="border: none;">
                                        <span class="text-primary" >
                                        <i class="fa-solid fa-2xl fa-square-pen" ></i>
                                            </span>
                                            </button>
                                    </a>';
                                }
                             
                                 
                                }}}   )

                        

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
        $consumos = DB::table('unidadconsumo')
        ->select(DB::raw("concat(codconsumo,' : ',placaconsumo,' : ',marcaconsumo)
         as unidadcon"),'idunidadconsumo')
        ->where('estadoconsumo',1)
        ->pluck('unidadcon','idunidadconsumo');

        $localidades = DB::table('localidad')
        ->select(DB::raw("concat(codlocalidad,' : ',nombrelocalidad)
        as localida"),'idlocalidad')
        ->where('estadolocalidad',1)
        ->pluck('localida','idlocalidad');

        $areas = DB::table('areas')->where('estadoarea',1)
        ->pluck('nombrearea','idarea');

        return view('almacenes.pedido.create',
        compact('consumos','localidades','areas'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $vales = new ValeModel();
        $vales->objeto = $request->input('objeto');
        $vales->motivosoli = $request->input('motivosoli');
        $vales->controlinterno = $request->input('controlinterno');

        $vales->idlocalidad = $request->input('idlocalidad');
        $vales->idunidadconsumo = $request->input('idunidadconsumo');
        $vales->idarea = $request->input('idarea');

        $vales->idusuario =$id;
        $vales->estadovale = 1;
        $vales->estado1 = 1;
        $vales->estado2 = 1;
        

        if($vales->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('almacenes.pedido.index');
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
          return redirect()->route('almacenes.detalle.index');
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
          return redirect()->route('almacenes.detalle.index2');
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
          return redirect()->route('almacenes.detalle.index3');
     }
     
    public function editar($idvale){

        $vales = ValeModel::find($idvale);

        $areas = DB::table('areas')->get();

        $localidades = DB::table('localidad')->get();
        $consumos = DB::table('unidadconsumo')->get();
        $empleados = DB::table('empleados')->get();
        $personal = User::find(Auth::user()->id);

        $id = $personal->id;

        return view('almacenes.pedido.editar',
        compact('id','vales','localidades','areas','consumos','empleados'));
    }


    public function update(Request $request){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
    

       // dirigido a
    $prod = $request->get('idusuario');
    $producto = EmpleadosModel::find($prod);
    $Nombredir = $producto->nombres;
    $Apellidopadir = $producto->ap_pat;
    $Apellidomadir = $producto->ap_mat;
    $Nombrecompdir= $Nombredir . " " .  $Apellidopadir. " " .$Apellidomadir ;

    $IdFile = $producto->idfile;
    $productodos = FileModel::find($IdFile);
    $Nombredircargo = $productodos->nombrecargo;

        

        $vales = ValeModel::find($request->idvale);


        $vales->objeto = $request->input('objeto');
        $vales->motivosoli = $request->input('motivosoli');
        $vales->controlinterno = $request->input('controlinterno');

        $vales->idusuario = $request->get('idusuario'); 
        $vales->usuarionombre = $Nombrecompdir;
        $vales->usuariocargo = $Nombredircargo;


        $vales->idlocalidad = $request->input('idlocalidad');


        $vales->idunidad = $request->input('idunidad');


        $vales->idarea = $request->input('idarea');



        $vales->idusuariodos =$id;



        if($vales->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('almacenes.pedido.index');
    }

    public function destroy($id){

    }
}

