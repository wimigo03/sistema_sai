<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehiculoRequest;
use App\Models\Ambiente;
use App\Models\AreasModel;
use App\Models\Model_Activos\ArchivoVehiculo;
use App\Models\Model_Activos\CodcontModel;
use App\Models\Model_Activos\EntidadesModel;
use App\Models\Model_Activos\OrganismofinModel;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VehiculoController extends Controller
{
  public function index()
  {
      $unidad = UnidadadminModel::where('estadouni', 1)->first();
      $vehiculos = Vehiculo::orderBy('id', 'desc')
          ->with([
              'actual.empleados',
              'actual.empleados.file'
          ])
          ->paginate(10);

      return view('activo.vehiculo.index', compact('unidad', 'vehiculos'));
  }

  public function search(Request $request)
  {
      $unidad = UnidadadminModel::where('estadouni', 1)->first();
      $vehiculos = Vehiculo::query()
          ->with([
              'actual.empleados',
              'actual.empleados.file'
          ])
          ->byCodigo($request->codigo)
          ->byNombre(strtoupper($request->nombre))
          ->byApPaterno(strtoupper($request->ap_pat))
          ->byApMaterno(strtoupper($request->ap_mat))
          ->byOficina(strtoupper($request->oficina))
          ->orderBy('id', 'desc')
          ->paginate(10);

          $vehiculos->appends($request->except('page'));
      return view('activo.vehiculo.index', compact('vehiculos', 'unidad'));
  }

    public function listado()
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $data = Vehiculo::query()
            ->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.vehiculo.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function getCodigo(Request $request)
    {
        $codigo = $request->input('codigo');
        return response()->json([
            'response' => DB::table('actual')->where('codigo', $codigo)->first()
        ]);
    }

    public function create()
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        return view('activo.vehiculo.create', compact('entidad', 'unidad'));
    }

    public function store(StoreVehiculoRequest $request)
    {
        DB::beginTransaction();
        try {
            $vehiculo = (new Vehiculo)->fill($request->all());
            $vehiculo->documento = $this->guardarDocumento($request, 'documento', 'public/documentos');
            $vehiculo->documento_ruat = $this->guardarDocumento($request, 'documento_ruat', 'public/documentos');
            $vehiculo->imagen = $this->guardarDocumento($request, 'imagen', 'public/images');
            $vehiculo->save();
            foreach ($request->file('documentos') as $index => $file) {
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('public/documentos'), $filename);
                ArchivoVehiculo::create([
                    'vehiculo_id' => $vehiculo->id,
                    'descripcion' => 'documento-' . $index,
                    'ruta' => $filename
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Hubo un error al guardar el vehículo.');
        }

        return redirect()->route('activo.vehiculo.index');
    }

    public function editar($id)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();

        return view('activo.vehiculo.edit', compact('entidad', 'unidad'));
    }

    public function show($id)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $vehiculo = Vehiculo::find($id);
        
        return view('activo.vehiculo.show', compact('entidad', 'unidad','vehiculo'));
    }

    public function guardarDocumento($request, $nombreCampo, $ruta)
    {
        $file = $request->file($nombreCampo);
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path($ruta), $filename);
        return $filename;
    }
}
