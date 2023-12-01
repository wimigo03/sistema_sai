<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Activos\ActualModel;
use App\Models\Model_Activos\Tranferencia;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class TransferenciaController extends Controller
{
    public function index()
    {
        return view('activo.tranferencia.index');
    }

    public function listado()
    {
        // Obtener los datos de la tabla actual filtrados por estadoactual
        $data = DB::table('actual');

        // Configurar DataTables con los datos y columnas necesarias
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.tranferencia.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }
    public function create()
    {
        
      
        return view('activo.gestionactivo.create');

    }
    public function store(Request $request)
    {
        // Crear una nueva instancia de
        $actual = new Tranferencia();
        
        // Llenar el modelo con los datos del formulario
        $this->fillTranfeModel($actual, $request);
        
        // Asignar el estadoactual
        $tranfe->estadotranfererencia = 1;

        if ($franfe->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.tranferencia.index');
    }
    public function editar($id)
    {
        // Obtener el objeto actual con las relaciones de unidadadmin, codcont y auxiliar
      
        return view('activo.gestionactivo.edit');
    }


}