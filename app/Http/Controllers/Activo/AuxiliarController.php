<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Activos\CodcontModel;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\ActualModel;
use App\Models\Model_Activos\AuxiliarModel;
use App\Models\Model_Activos\EntidadesModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class AuxiliarController extends Controller
{
    public function index($id)
    {
        $this->listado($id);
        return view('activo.auxiliar.index', compact('id'));
    }

    public function listado($id)
    {
        $data = DB::table('auxiliar')
            ->where('entidad', 4601)
            ->where('unidad', 'A')
            ->where('codcont', $id)
            ->orderBy('codaux','asc')
            ->get();

        return DataTables::of($data)
            ->addColumn('btn', 'activo.auxiliar.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create($id)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('unidad', 'A')->first();
        $codconts = CodcontModel::where('codcont', $id)->first();

        $auxiliar = AuxiliarModel::where('entidad', 4601)
            ->where('unidad', 'A')
            ->where('codcont', $id)
            ->orderBy('idauxiliar','DESC')
            ->first();
        if ($auxiliar) {
            $codaux = $auxiliar->codaux;
            $newauxiliar = $codaux + 1;
        } else {
            $newauxiliar =  1;
        }
        $usuar = Auth::user()->name;


        return view('activo.auxiliar.create', compact('usuar', 'newauxiliar', 'codconts', 'unidad', 'entidad'));
    }

    public function store(Request $request)
    {
        $auxiliar = new AuxiliarModel();
        $this->fillAuxiliarModel($auxiliar, $request);
        $auxiliar->estadoauxiliar = 1;

        if ($auxiliar->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.codcont.index');
    }

    public function editar($idauxiliar)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('unidad', 'A')->first();
        
       
        // Obtener el objeto actual con las relaciones de unidadadmin, codcont y auxiliar
        $auxiliar = AuxiliarModel::with('codcont')->find($idauxiliar);

        $codigo = CodcontModel::where('codcont',$auxiliar->codcont)->first();
        

        return view('activo.auxiliar.edit', compact('unidad','entidad','auxiliar', 'codigo', ));
    }


    public function update(Request $request, $idauxiliar)
    {
        $auxiliar = AuxiliarModel::find($idauxiliar);
        $this->fillAuxiliarModel($auxiliar, $request);
        $auxiliar->estadoauxiliar = 1;

        if ($auxiliar->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('activo.auxiliar.index',$auxiliar->codcont)->with('auxiliar', $auxiliar);
    }

    public function destroy($id)
    {
        // Implementa la lógica para eliminar un registro de la base de datos
    }

    private function fillAuxiliarModel(AuxiliarModel $auxiliar, Request $request)
    {
        $auxiliar->entidad = $request->input('entidad');
        $auxiliar->unidad = $request->input('unidad');
        $auxiliar->codcont = $request->input('codcont');
        $auxiliar->codaux = $request->input('codaux');
        $auxiliar->nomaux = $request->input('nomaux');
        $auxiliar->observ = $request->input('observ');
        $auxiliar->feult = $request->input('feult');
        $auxiliar->usuar = Auth::user()->name;
    }
}
