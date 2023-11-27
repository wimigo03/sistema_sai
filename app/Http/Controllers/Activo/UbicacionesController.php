<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\ActualModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UbicacionesController extends Controller
{
    public function index($id)
    {
        $this->listado($id);
        $activo = ActualModel::find($id);
        return view('activo.responsableUbicacion.index', compact('activo', 'id'));
    }

    public function listado($id)
    {
        $data = DB::table('ubicacion_activos')
            ->join('users', 'ubicacion_activos.user_id', '=', 'users.id')
            ->where('activo_id', $id)
            ->select('ubicacion_activos.*', 'users.name as user_name'); // Seleccionamos el nombre del usuario

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
