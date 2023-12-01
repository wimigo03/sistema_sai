<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\ActualModel;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
class ActivoFijosController extends Controller
{
    public function index()
    {

        return view('activo.gestionactivo.index');
    }

  public function listado()
    {

        $data = DB::table('actual')
        -> where('estadoactual','=', 1);
       // -> get();

        return datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','activo.gestionactivo.btn')
                ->rawColumns(['btn'])
                ->make(true);
  ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activo.gestionactivo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $actual = new ActualModel();
        $actual ->unidad = $request->input('unidad');
        $actual ->entidad = $request->input('entidad');
        $actual ->codigo= $request->input('codigo');
        $actual ->codcont = $request->input('codcont');
        $actual ->codaux = $request->input('codaux');
        $actual ->vidautil = $request->input('vidautil');
        $actual ->descrip= $request->input('descrip');
        $actual ->costo = $request->input('costo');
        $actual ->depacu = $request->input('depacu');
        $actual ->mes = $request->input('mes');
        $actual ->ano= $request->input('ano');
        $actual ->b_rev = $request->input('b_rev');
        $actual ->dia = $request->input('dia');
        $actual ->codofic = $request->input('codofic');
        $actual ->codresp= $request->input('codresp');
        $actual ->dia_ant = $request->input('dia_ant');
        $actual ->mes_ant = $request->input('mes_ant');
        $actual ->ano_ant = $request->input('ano_ant');
        $actual ->vut_ant= $request->input('vul_ant');
        $actual ->costo_ant = $request->input('costo_ant');
        $actual ->band_ufv = $request->input('band_ufv');
        $actual ->codestado = $request->input('codestado');
        $actual ->cod_rube= $request->input('cod_rube');
        $actual ->nro_conv = $request->input('nro_conv');
        $actual ->org_fin = $request->input('org_fin');
        $actual ->feul = $request->input('feul');
        $actual ->usuar= $request->input('usuar');
        $actual ->apiestado = $request->input('apiestado');
        $actual ->codigosec = $request->input('codigosec');
        $actual ->banderas = $request->input('banderas');
        
       
        $actual -> estadoactual = 1;

        if($actual->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('actual.index');
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
    public function editar($id)
    {
        $actual = ActualModel::find($id);
  
        return view('activo/gestionactivo/edit')->with('actual', $id);
    }
  


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $actual = ActualModel::find($id);
        $actual ->unidad = $request->input('unidad');
        $actual ->entidad = $request->input('entidad');
        $actual ->codigo= $request->input('codigo');
        $actual ->codcont = $request->input('codcont');
        $actual ->codaux = $request->input('codaux');
        $actual ->vidautil = $request->input('vidautil');
        $actual ->descrip= $request->input('descrip');
        $actual ->costo = $request->input('costo');
        $actual ->depacu = $request->input('depacu');
        $actual ->mes = $request->input('mes');
        $actual ->ano= $request->input('ano');
        $actual ->b_rev = $request->input('b_rev');
        $actual ->dia = $request->input('dia');
        $actual ->codofic = $request->input('codofic');
        $actual ->codresp= $request->input('codresp');
        $actual ->dia_ant = $request->input('dia_ant');
        $actual ->mes_ant = $request->input('mes_ant');
        $actual ->ano_ant = $request->input('ano_ant');
        $actual ->vut_ant= $request->input('vul_ant');
        $actual ->costo_ant = $request->input('costo_ant');
        $actual ->band_ufv = $request->input('band_ufv');
        $actual ->codestado = $request->input('codestado');
        $actual ->cod_rube= $request->input('cod_rube');
        $actual ->nro_conv = $request->input('nro_conv');
        $actual ->org_fin = $request->input('org_fin');
        $actual ->feul = $request->input('feul');
        $actual ->usuar= $request->input('usuar');
        $actual ->apiestado = $request->input('apiestado');
        $actual ->codigosec = $request->input('codigosec');
        $actual ->banderas = $request->input('banderas');
       
      
        $actual -> estadoactual = 1;


        if($actual->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return view('activo/gestionactivo/index')->with('actual', $actual);
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
