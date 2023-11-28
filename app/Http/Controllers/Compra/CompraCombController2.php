<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\TemporalModel;


use App\Models\Compra\CompraCombModel;



use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use DataTables;


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
                        ->join('programacomb as prog', 'prog.idprogramacomb', '=', 'c.idprogramacomb')
                        ->join('areas as a', 'a.idarea', '=', 'c.idarea')

                       
                        
                        ->select('c.idcompracomb','c.estado1','c.controlinterno','a.nombrearea',
                        'c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo',
                        'c.numcompra','cat.codcatprogramatica','prog.nombreprograma')
                        ->where('a.idarea',$personalArea->idarea)
                        ->where('c.estadocompracomb',1)
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

                       
                        
                        ->select('c.idcompracomb','c.estado1','c.controlinterno','a.nombrearea',
                        'c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo',
                        'c.numcompra','cat.codcatprogramatica','prog.nombreprograma')
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

        $proveedores = DB::table('proveedor')->where('estadoproveedor',1)
        ->pluck('nombreproveedor','idproveedor');

        $areas = DB::table('areas')->where('estadoarea',1)
        ->pluck('nombrearea','idarea');

        $catprogramaticas = DB::table('catprogramaticacomb')
        ->select(DB::raw("concat(codcatprogramatica,' : ',nombrecatprogramatica) 
        as programatica"),'idcatprogramaticacomb')
        ->where('estadocatprogramatica',1)
        ->pluck('programatica','idcatprogramaticacomb');

        $programas = DB::table('programacomb')->where('estadoprograma',1)
        ->pluck('nombreprograma','idprogramacomb');

        return view('combustibles.pedidoparcial.create',
        compact('proveedores','areas','catprogramaticas','programas','personalArea'));
    }

    public function store(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $compras = new CompraCombModel();
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->preventivo = 0;
        $compras->tipo = $request->input('tipo');
        $compras->numcompra =0;
        $compras->controlinterno = $request->input('controlinterno');
        $compras->idproveedor = 1;
        $compras->idarea = $personalArea->idarea;
        $compras->idcatprogramaticacomb = $request->input('idcatprogramatica');
        $compras->idprogramacomb = $request->input('idprograma');
        $compras->idproveedor = 1;
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
        return redirect()->route('combustibles.pedidoparcial.index');
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
       return redirect()->route('combustibles.detalleparcial.index');
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
       return redirect()->route('combustibles.detalleparcial.index2');
    }

    public function editar($idcompracomb){
        $compras = CompraCombModel::find($idcompracomb);

        $proveedores = DB::table('proveedor')->get();
        $areas = DB::table('areas')->get();
        $catprogramaticas = DB::table('catprogramaticacomb')->get();
        $programas = DB::table('programacomb')->get();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        return view('combustibles.pedidoparcial.editar',

        compact('id','compras','proveedores','areas',
        'catprogramaticas','programas'));
    }

    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $compras = CompraCombModel::find($request->idcompracomb);
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');

        
        $compras->tipo = $request->input('tipo');
        
        $compras->idproveedor = $request->input('idproveedor');
        $compras->numcompra =$request->input('numcompra');
        $compras->preventivo = $request->input('preventivo');

        $compras->controlinterno = $request->input('controlinterno');
        $compras->idarea = $request->input('idarea');
        $compras->idcatprogramaticacomb = $request->input('idcatprogramatica');
        $compras->idprogramacomb = $request->input('idprograma');
        $compras->idusuario = $id;
        if($compras->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('combustibles.pedidoparcial.index');
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

