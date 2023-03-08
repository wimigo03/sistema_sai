<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\CompraModel;
use App\Models\TemporalModel;
use App\Models\EncargadosModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class CompraController2 extends Controller
{
    public function index(){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $compras = DB::table('compra as c')
                        ->join('proveedores as p', 'p.idproveedor', '=', 'c.idproveedor')
                        ->join('catprogramatica as cat', 'cat.idcatprogramatica', '=', 'c.idcatprogramatica')
                        ->join('programa as prog', 'prog.idprograma', '=', 'c.idprograma')
                        ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                        ->where('a.idarea',$personalArea->idarea)
                        ->select('c.idcompra','c.estado1','c.controlinterno','a.nombrearea','c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo','c.numcompra','cat.codcatprogramatica','prog.nombreprograma')
                        ->get();


        // $user = User::first($id);
        // $phone->usuariosempleados;

        //$phone = \App\Models\User::find($id)->usuariosempleados;
        //$usuario = User::find($id);
        // $phone=$usuario->usuariosEmpleados;
        // $image = $id->usuariosempleados->first();
//////////////////////encontrar usuario y area/////////////
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        //$phone = User::has('usuariosempleados')->get();
        //$phone = User::with('usuariosempleados')->first();
        //$phone = $usuario->usuariosempleados;
        //dd($phone2->nombrearea);

        return view('compras.pedidoparcial.index',['compras'=>$compras,'idd'=>$personalArea]);
    }

    public function create(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $proveedores = DB::table('proveedores')->where('estadoproveedor',1)->pluck('nombreproveedor','idproveedor');
        $areas = DB::table('areas')->where('estadoarea',1)->pluck('nombrearea','idarea');
        $catprogramaticas = DB::table('catprogramatica')
                                ->select(DB::raw("concat(codcatprogramatica,' : ',nombrecatprogramatica) as programatica"),'idcatprogramatica')
                                ->where('estadocatprogramatica',1)
                                ->pluck('programatica','idcatprogramatica');
        $programas = DB::table('programa')->where('estadoprograma',1)->pluck('nombreprograma','idprograma');
        return view('compras.pedidoparcial.create',compact('proveedores','areas','catprogramaticas','programas','personalArea'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $compras = new CompraModel();
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->preventivo = 0;
        $compras->tipo = $request->input('tipo');
        $compras->numcompra =0;
        $compras->controlinterno = $request->input('controlinterno');
        $compras->idproveedor = 1;
        $compras->idarea = $personalArea->idarea;
        $compras->idcatprogramatica = $request->input('idcatprogramatica');
        $compras->idprograma = $request->input('idprograma');
        $compras->idproveedor = 1;
        $compras->idusuario =$id;
        $compras->estadocompra = 1;
        $compras->estado1 = 1;
        $compras->estado2 = 1;
        $compras->estado3 = 1;
        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('compras.pedidoparcial.index');
    }

    public function show($id){

    }

    public function edit($idcomp){//dd($idcomp);
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        if(is_null($detalle)){
            $detalle = new TemporalModel;
            $detalle->idtemporal=$id;
            $detalle->idusuario=$id;
            $detalle->idcompra=$idcomp;
            $detalle->save();
        }else{
            $detalle->idtemporal = $id;
            $detalle->idusuario = $id;
            $detalle->idcompra = $idcomp;
            $detalle->update();
        }
       //return Redirect::to('compras/detalle');
       return redirect()->route('compras.detalleparcial.index');
    }

    public function editar($idcompra){
        $compras = CompraModel::find($idcompra);
        $proveedores = DB::table('proveedores')->get();
        $areas = DB::table('areas')->get();
        $catprogramaticas = DB::table('catprogramatica')->get();
        $programas = DB::table('programa')->get();
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        return view('compras.pedidoparcial.editar',compact('id','compras','proveedores','areas','catprogramaticas','programas'));
    }

    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $compras = CompraModel::find($request->idcompra);
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->preventivo = $request->input('preventivo');
        $compras->tipo = $request->input('tipo');
        $compras->numcompra =$request->input('numcompra');
        $compras->controlinterno = $request->input('controlinterno');
        $compras->idarea = $request->input('idarea');
        $compras->idcatprogramatica = $request->input('idcatprogramatica');
        $compras->idprograma = $request->input('idprograma');
        $compras->idproveedor = $request->input('idproveedor');
        $compras->idusuario = $id;
        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('compras.pedidoparcial.index');
    }

    public function destroy($id){

    }

////////////////////////////////////ENCARGADOS/////////////////////////////////////////////////////
public function listadoResponsables(){
    $personal = User::find(Auth::user()->id);
    $id = $personal->id;
    $userdate = User::find($id)->usuariosempleados;
    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

    $encargados = DB::table('encargados as en')
                    ->join('empleados as e', 'en.idemp', '=', 'e.idemp')
                    ->join('areas as a', 'a.idarea', '=', 'en.idarea')
                    ->where('a.idarea',$personalArea->idarea)
                    //->where('a.idarea',$personalArea->idarea)
                    ->select('e.nombres','e.ap_pat','e.ap_mat','en.abrev','en.idenc','en.cargo','a.nombrearea')
                    ->get();
//dd($encargados);
//////////////////////encontrar usuario y area/////////////
$estado=1;

if ($encargados->isEmpty()) {
    $estado=0;}

    return view('compras.pedidoparcial.responsable',['encargados'=>$encargados,'estado'=>$estado]);
}

public function crearEncargado(){

    $personal = User::find(Auth::user()->id);
    $id = $personal->id;
    $userdate = User::find($id)->usuariosempleados;
    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
    //dd($personalArea->nombrearea);

    $empleados = DB::table('empleados as e')
    ->select('e.idemp','e.nombres','e.ap_pat','e.ap_mat')
   // -> where('ps.estadoprodserv','=', 1)
    //-> orderBy('u.id', 'asc')
    -> get();
    return view('compras.pedidoparcial.responsableCreate',compact('personalArea','empleados'));
}



public function storeEncargado(Request $request){


    $personal = User::find(Auth::user()->id);
    $id = $personal->id;
    $userdate = User::find($id)->usuariosempleados;
    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


    $responsable = new EncargadosModel();
    $responsable->abrev = $request->input('abrev');
    $responsable->idemp = $request->input('idempleado');
    $responsable->idarea = $personalArea->idarea;
    $responsable->cargo = $request->input('cargo');

    if($responsable->save()){
        $request->session()->flash('message', 'Registro Procesado');
    }else{
        $request->session()->flash('message', 'Error al Procesar Registro');
    }
    return redirect()->action('App\Http\Controllers\CompraController2@listadoResponsables');
    return redirect()->route('compras.pedidoparcial.responsable');
}



public function responsableEdit($idresp)
{
    $responsable = EncargadosModel::find($idresp);

    $personal = User::find(Auth::user()->id);
    $id = $personal->id;
    $userdate = User::find($id)->usuariosempleados;
    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


    $empleados = DB::table('empleados as e')
    ->select('e.idemp','e.nombres','e.ap_pat','e.ap_mat')
       -> get();

    return view('compras.pedidoparcial.responsableEdit',compact('responsable','empleados','personalArea'));
}

public function UpdateResponsable(Request $request){


    $personal = User::find(Auth::user()->id);
    $id = $personal->id;
    $userdate = User::find($id)->usuariosempleados;
    $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

    $responsable = EncargadosModel::find($request->input('idenc'));
    //$responsable = new EncargadosModel();
    $responsable->abrev = $request->input('abrev');
    $responsable->idemp = $request->input('idempleado');
    $responsable->idarea = $personalArea->idarea;
    $responsable->cargo = $request->input('cargo');

    if($responsable->save()){
        $request->session()->flash('message', 'Registro Procesado');
    }else{
        $request->session()->flash('message', 'Error al Procesar Registro');
    }
    return redirect()->action('App\Http\Controllers\CompraController2@listadoResponsables');
    return redirect()->route('compras.pedidoparcial.responsable');
}

}
