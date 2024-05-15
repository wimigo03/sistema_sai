<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Activos\Formulario;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\EntidadesModel;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Requests\SaveFormularioRequest;

class FormularioController extends Controller
{
    public function index()
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $formularios = Formulario::orderBy('id', 'desc')
        ->with(['empleado','empleado.empleadosareas','empleado.file'])
            ->paginate(10);

        return view('activo.formulario.index', compact('unidad', 'formularios'));
    }

  public function search(Request $request)
  {
      $unidad = UnidadadminModel::where('estadouni', 1)->first();
      $formularios = Formulario::query()
          ->with('empleado','empleado.file','empleado.empleadosareas')
          ->byCi($request->ci)
          ->byNombre(strtoupper($request->nombre))
          ->byApPaterno(strtoupper($request->ap_pat))
          ->byApMaterno(strtoupper($request->ap_mat))
          ->byOficina(strtoupper($request->oficina))
          ->byCargo(strtoupper($request->cargo))
          ->orderBy('id', 'desc')
          ->paginate(10);

          $formularios->appends($request->except('page'));
      return view('activo.formulario.index', compact('formularios', 'unidad'));
  }


  public function getEmleadoByCi(Request $request)
  {
      $empleado = Empleado::with(['file','empleadosareas'])
          ->where('ci', $request->input('ci'))
          ->first();
      return response()->json([
          'response' => $empleado,
      ]);
  }

  public function create()
  {
      $entidad = EntidadesModel::where('entidad', 4601)->first();
      $unidad = UnidadadminModel::where('estadouni', 1)->first();
      return view('activo.formulario.create', compact('entidad', 'unidad'));
  }

  public function store(SaveFormularioRequest $request)
  {
      $formulario = Formulario::create($request->validated());
      return redirect()->route('activo.formulario.edit', $formulario->id);
  }

  public function editar($id)
  {
      $entidad = EntidadesModel::where('entidad', 4601)->first();
      $unidad = UnidadadminModel::where('estadouni', 1)->first();
      $formulario = Formulario::find($id);
      return view('activo.formulario.edit', compact('entidad', 'unidad','formulario'));
  }

  public function update(SaveFormularioRequest $request, $id)
  {
      $adeudo = Formulario::find($id);
      $adeudo->update($request->validated());
      return redirect()->route('activo.formulario.index');
  }

}
