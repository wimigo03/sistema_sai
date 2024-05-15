<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Compra\ProdCombModel;
use App\Models\Compra\PartidaCombModel;


use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Support\Facades\Auth;


class ProdCombController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        return view('combustibles.producto.index', ['idd' => $personalArea]);
    }

  public function list(Request $request)
    {

           if ($request->ajax()) {
           $data = DB::table('prodcomb as p')
           ->join('partidacomb as pt', 'pt.idpartidacomb', '=', 'p.idpartidacomb')
           ->select('p.idprodcomb','p.codigoprodcomb','p.nombreprodcomb','p.detalleprodcomb','p.precioprodcomb', 'pt.codigopartida')
           ->orderBy('p.nombreprodcomb', 'asc');

        return Datatables::of($data)
       ->addIndexColumn()
       ->addColumn('btn', 'combustibles.producto.btn')

       ->rawColumns(['btn'])
       ->make(true);
    }
    }

   
    public function create()
    {
        $partidas = DB::table('partidacomb')->get();

        return view('combustibles.producto.create', ["partidas" => $partidas]);
    }

   
    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $productos = new ProdcombModel();
        $productos -> codigoprodcomb = $request->input('codigoprodcomb');
        $productos -> nombreprodcomb = $request->input('nombre');
            $productos -> detalleprodcomb = $request->input('detalle');
            $productos -> precioprodcomb = $request->input('precio');
            $productos -> idpartidacomb = $request->input('idpartidacomb');

        $productos -> estadoprodcomb = 1;
        $productos ->idusuario =$id;
        $productos ->idarea =$personalArea->idarea;

        if($productos->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

    
        return redirect()->route('producto.index');

    }

    public function show($id)
    {
        //
    }

    
    public function editar($idprod){
        $productos = ProdcombModel::find($idprod);
        $partidas = DB::table('partidacomb')->get();
        return view('combustibles.producto.edit', ["productos" => $productos,"partidas" => $partidas]);
    }


    public function update(Request $request, $idproductos){

        
        $productos = ProdcombModel::find($idproductos);

        $productos -> codigoprodcomb = $request->input('codigoprodcomb');
        $productos -> nombreprodcomb = $request->input('nombre');
            $productos -> detalleprodcomb = $request->input('detalle');
            $productos -> precioprodcomb = $request->input('precio');
            $productos -> idpartidacomb = $request->input('idpartidacomb');

        if($productos->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
        return redirect('combustibles/producto/index');
    }
    public function respuesta3(Request $request)    {
        $ot_antigua=$_POST['ot_antigua'];
            $data = "hola";
            $data2 = "holaSSSS";
            $validarci = DB::table('prodcomb as s')
            ->select('s.codigoprodcomb')
           ->where('s.codigoprodcomb', $ot_antigua)
            ->get();
               if($validarci->count()>0){
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }
}
