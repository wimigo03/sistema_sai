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

                        // ->where('c.estadocompracomb',1)

                        ->select(['c.estadocompracomb','c.idcompracomb','c.estado1','c.estado2','c.estado3',
                        'c.objeto', 'c.justificacion','c.preventivo','c.numcompra',
                        
                        'p.nombreproveedor','a.nombrearea','cat.codcatprogramatica','prog.nombreprograma']);

                        // ->orderBy('c.idcompracomb', 'asc');
                        
                        $compras = $compras->get();

                        return DataTables::of($compras)
                        ->addIndexColumn()
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
                        ->addColumn('numcompra', function ($compras) {
                            return $compras->numcompra;
                        })
                     
                        ->addColumn('estadocompracomb', function ($compras) {

                            if ($compras->estadocompracomb == '1') {
                                //'<b style="color: green">Sin repuesta</b>';
                                 return  '<b style="color: green">Pendiente</b>';

                                
                            } else {
                                if ($compras->estadocompracomb == '2') {
                                    return  '<b style="color: blue">Aprovada</b>';

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
                         $buttonHtml = '<form action="' . route('combustibles.pedido.edit', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="btn btn-sm btn-success font-verdana" type="submit" aria-label="Activar/Desactivar Horario">
                                Detalle
                                </button>
                                </form>';
                    } else {
                        if ($compras->estadocompracomb == 2) {
                         $buttonHtml = '<form action="' . route('combustibles.pedido.editable', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="btn btn-sm btn-primary font-verdana" type="submit" aria-label="Activar/Desactivar Horario">
                                Aprovado
                                </button>
                                </form>';
                    } else {
                        if ($compras->estadocompracomb == 5) {

                         $buttonHtml = '<form action="' . route('combustibles.pedido.editable', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="btn btn-sm btn-secondary font-verdana" type="submit" aria-label="Activar/Desactivar Horario">
                                Almacen
                                </button>
                                </form>';
                    }else {
                        if ($compras->estadocompracomb == 10) {
                            $buttonHtml = '<form action="' . route('combustibles.pedido.editable', $compras->idcompracomb) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="btn btn-sm btn-danger font-verdana" type="submit" aria-label="Activar/Desactivar Horario">
                                Rechazado
                                </button>
                                </form>';
                    }else {
                    } }}}   
                    return
                        

                    '<a class="tts:left tts-slideIn tts-custom" aria-label=" boton uno" href="' . route('combustibles.pedido.ver', $compras->idcompracomb) . '">
                    <button class="btn btn-sm btn-primary font-verdana" type="button">
                    <i class="fa fa-pencil fa-fw"></i>
                    </button>
                    </a>' . ' '.$buttonHtml;
                    
                    '<a class="tts:left tts-slideIn tts-custom" aria-label=" boton dos" href="' . route('combustibles.pedido.editar', $compras->idcompracomb) . '">
                    <button class="btn btn-sm btn-primary font-verdana" type="button">
                    <i class="fa fa-pencil fa-fw"></i>
                    </button>
                    </a>' . ' '.$buttonHtml;

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
                        ->where('c.estadocompracomb',2)
                        ->select('c.estadocompracomb','c.idcompracomb','c.estado1','c.estado2','c.estado3','a.nombrearea','c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo','c.numcompra','cat.codcatprogramatica','prog.nombreprograma')
                        ->orderBy('c.idcompracomb', 'asc');
                        //->get();

                        return Datatables::of($compras)
                        ->addIndexColumn()
                        ->addColumn('btn3', 'combustibles.pedido.btn3')
                        ->rawColumns(['btn3'])
                        // ->rawColumns(['btn'])

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
       return redirect()->route('combustibles.detalle.index');
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
       return redirect()->route('combustibles.detalle.index2');
    }

    public function editar($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);
        $proveedores = DB::table('proveedor')->get();
        $areas = DB::table('areas')->get();
        $catprogramaticas = DB::table('catprogramaticacomb')->get();
        $programas = DB::table('programacomb')->get();
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        return view('combustibles.pedido.editar',compact('id','compras','proveedores','areas','catprogramaticas','programas'));
    }

    public function ver($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);
        $proveedores = DB::table('proveedor')->get();
        $areas = DB::table('areas')->get();
        $catprogramaticas = DB::table('catprogramaticacomb')->get();
        $programas = DB::table('programacomb')->get();
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $comprasestado = CompraCombModel::find($idcompracomb);
        $EstadoCOM = $comprasestado->estadocompracomb;
        $Estadoun = $EstadoCOM;
        // $Proveedor = CompraCombModel::find($compras->idcompracomb);
        // $Proveedordd = $Proveedor->idproveedor;
        // $Proveedor=$compras->idproveedor;

        if ($Estadoun==1) {
            return view('combustibles.pedido.editar',compact('id','compras','proveedores','areas','catprogramaticas','programas'));

        } else {
        return view('combustibles.pedido.ver',compact('id','compras','proveedores','areas','catprogramaticas','programas'));

        }
        
    }

    
    
    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $compras = CompraCombModel::find($request->idcompracomb);
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
        $compras->idusuario = $id;
        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('combustibles.pedido.index');
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

