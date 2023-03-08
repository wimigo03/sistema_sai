<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedidaModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;

class MedidaController extends Controller
{
  public function index()
  {
    return view('compras.medidas.index');
  }

  public function listado()
  {
    $data = DB::table('umedida');
    return Datatables::of($data)->addIndexColumn()
      ->addColumn('btn', 'compras.medidas.btn')
      ->rawColumns(['btn'])
      ->make(true);
  }

  public function editar($idmedida)
  {
    $medida = MedidaModel::find($idmedida);
    return view('compras/medidas/edit')->with('medida', $medida);
  }

  public function update(Request $request, $idumedida)
  {
    $medida = MedidaModel::find($idumedida);
    $medida->nombreumedida = $request->input('nombre');
    if ($medida->save()) {
      $request->session()->flash('message', 'Registro Procesado');
    } else {
      $request->session()->flash('message', 'Error al Procesar Registro');
    }
    return redirect('compras/medidas/index');
  }

  public function create()
  {
    return view('compras.medidas.create');
  }

  public function store(request $request)
  {

     for ($i = 1; $i <= 10000; $i++) {
    $medida = new MedidaModel();
    $medida->nombreumedida = $request->input('nombre');
    $medida->estadoumedida = 1;
    $medida->save();
}
    return redirect()->route('medidas.index');
  }

  public function destroy($id)
  {
    $medidas = MedidaModel::find($id);
    $medidas->estadoumedida = 0;
    $medidas->update();
    return redirect()->route('medidas.index');
  }
}
