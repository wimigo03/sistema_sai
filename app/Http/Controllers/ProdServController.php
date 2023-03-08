<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartidaModel;
use App\Models\ProdServModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;

class ProdServController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('compras.productos.index');
    }

  public function list(Request $request)
    {

           // $data = DB::table('prodserv')->get();
           if ($request->ajax()) {
           $data = DB::table('prodserv as p')
           ->join('partida as pt', 'pt.idpartida', '=', 'p.partida_idpartida')
           ->join('umedida as u', 'u.idumedida', '=', 'p.umedida_idumedida')
           ->select('p.idprodserv','p.nombreprodserv','p.detalleprodserv','p.precioprodserv', 'pt.codigopartida','u.nombreumedida')
           ->orderBy('p.nombreprodserv', 'asc');

        return Datatables::of($data)
       ->addIndexColumn()
       ->addColumn('btn', 'compras.productos.btn')

       ->rawColumns(['btn'])
       ->make(true);
    }
        //dd($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partidas = DB::table('partida')->get();
        $medidas = DB::table('umedida')->get();
        return view('compras.productos.create', ["partidas" => $partidas,"medidas" => $medidas]);
       // return view("compras.productos.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        for ($i = 1; $i <= 3000; $i++) {
        $productos = new ProdservModel();
        $productos -> nombreprodserv = $request->input('nombre');
            $productos -> detalleprodserv = $request->input('detalle');
            $productos -> precioprodserv = $request->input('precio');
            $productos -> umedida_idumedida =$request->input('idmedida');
            $productos -> partida_idpartida = $request->input('idpartida');

        $productos -> estadoprodserv = 1;


        if($productos->save()){
            $request->session()->flash('message', 'Registro Procesado');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
            //echo 'Houve um erro ao salvar';
        }

    }
        return redirect()->route('productos.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($idprod){
        $productos = ProdservModel::find($idprod);
        $partidas = DB::table('partida')->get();
        $medidas = DB::table('umedida')->get();
        //dd($medidas);
        return view('compras.productos.edit', ["productos" => $productos,"partidas" => $partidas,"medidas" => $medidas]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idproductos){

        //$medidas = MedidaModel::find($idmedida);
        //$partidas = PartidaModel::find($idpartida);
        $productos = ProdservModel::find($idproductos);
        $productos -> nombreprodserv = $request->input('nombre');
        $productos -> detalleprodserv = $request->input('detalle');
        $productos -> precioprodserv = $request->input('precio');
        $productos -> umedida_idumedida =$request->input('idmedida');
        $productos -> partida_idpartida = $request->input('idpartida');

        //$medida->update();
        if($productos->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
        return redirect('compras/productos/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
