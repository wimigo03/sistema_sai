<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Compra\ProdCombModel;
use App\Models\Compra\PartidaCombModel;
use App\Models\Compra\MedidaCombModel;


use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
class ProdCombController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('combustibles.producto.index', ['idd' => $personalArea]);
    }

  public function list(Request $request)
    {

           if ($request->ajax()) {
           $data = DB::table('prodcomb as p')
           ->join('partidacomb as pt', 'pt.idpartidacomb', '=', 'p.idpartidacomb')
           ->join('umedidacomb as me', 'me.idmedida', '=', 'p.idmedidacomb')
           ->select('p.idprodcomb','p.nombreprodcomb','p.detalleprodcomb','p.precioprodcomb','p.cantidadproducto','p.cantidadminima','p.subtotalproducto','p.cantidadmaxima', 'pt.codigopartida', 'me.nombremedida')
           ->orderBy('p.idprodcomb', 'desc');

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
        $medidas = DB::table('umedidacomb')->get();
        $date = Carbon::now();
        return view('combustibles.producto.create', ["partidas" => $partidas,"medidas" => $medidas,"date" => $date]);
    }

   
    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $proddoss = $request->get('idpartidacomb');
        $productoocho = PartidaCombModel::find($proddoss);
        $Codpartida = $productoocho->codigopartida;
        $guionmedio ="-"; 
        $codigoComb = $request->get('codigoprodcomb');
        $NomdetallE= $Codpartida . "" .  $guionmedio. "" .  $codigoComb;

        $productos = new ProdcombModel();
        $productos -> codigoprodcomb = $request->get('codigoprodcomb');
        $productos -> nombreprodcomb = $request->input('nombre');
            $productos -> detalleprodcomb = $NomdetallE;
            $productos -> precioprodcomb = $request->input('precio');
            $productos -> cantidadminima = $request->input('minimo');
            $productos -> cantidadmaxima = $request->input('maxima');
            $productos -> idpartidacomb = $request->get('idpartidacomb');
            $productos -> idmedidacomb = $request->input('idmedidacomb');
            $productos -> cantidadproducto = 0;
        $productos -> estadoprodcomb = 1;
        $productos ->idusuario =$id;
        $productos ->idarea =$personalArea->idarea;

        $fechasolACT = Carbon::now();
        $productos->fechaprod = $fechasolACT;

        $hora = $fechasolACT->toTimeString();

        $productos->horaprod = $hora;

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
        $FEchasol= $productos->fechaprod;
        $horasol= $productos->horaprod;
        $fechag = substr($FEchasol, 8, 2);
        $fecham = substr($FEchasol, 5, 2);
        $fechad = substr($FEchasol, 0, 4);

        $Fechayhora= $fechag . "-" .  $fecham. "-" .  $fechad. " " .  $horasol;

        $partidas = DB::table('partidacomb')->get();
        $medidas = DB::table('umedidacomb')->get();

        return view('combustibles.producto.edit', 
        ["productos" => $productos,
        "partidas" => $partidas,
        "medidas" => $medidas,
        "Fechayhora" => $Fechayhora
    ]);
    }


    public function update(Request $request, $idproductos){

        $proddoss = $request->get('idpartidacomb');
$productoocho = PartidaCombModel::find($proddoss);
$Codpartida = $productoocho->codigopartida;
$guionmedio ="-"; 
$codigoComb = $request->get('codigoprodcomb');
$NomdetallE= $Codpartida . "" .  $guionmedio. "" .  $codigoComb;

        $productos = ProdcombModel::find($idproductos);

        $productos -> codigoprodcomb = $request->get('codigoprodcomb');
        $productos -> nombreprodcomb = $request->input('nombre');
            $productos -> detalleprodcomb = $NomdetallE;
            $productos -> precioprodcomb = $request->input('precio');
            $productos -> cantidadminima = $request->input('minimo');
            $productos -> cantidadmaxima = $request->input('maxima');
            $productos -> idpartidacomb = $request->get('idpartidacomb');
            $productos -> idmedidacomb = $request->input('idmedidacomb');

        if($productos->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return redirect()->route('producto.index');
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
