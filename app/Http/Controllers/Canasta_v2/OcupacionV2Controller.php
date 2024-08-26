<?php

namespace App\Http\Controllers\Canasta_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;

use App\Models\Canasta\Dea;
use App\Models\Canasta\Ocupaciones;
use App\Models\User;
use DB;
use PDF;


class OcupacionV2Controller extends Controller
{
    public function index()
    {
        $tipos = Ocupaciones::TIPOS;
        $estados = Ocupaciones::ESTADOS;
        //$ocupaciones = Ocupaciones::orderBy('id', 'desc')->paginate(10);
        return view('canasta_v2.ocupacion.index', compact('tipos','estados'));
    }

    public function indexAjax(Request $request)
    {
        $query = DB::table('ocupaciones as a');
        $query = !is_null($request->ocupacion) ? $query->where('a.ocupacion',$request->ocupacion) : $query;
        $query = !is_null($request->tipo) ? $query->where('a.tipo',$request->tipo) : $query;
        $query = !is_null($request->estado) ? $query->where('a.estado',$request->estado) : $query;
        $query->select(
                        'a.id as ocupacion_id',
                        'a.ocupacion',
                        DB::raw("CASE WHEN a.tipo = '1' THEN 'PROFESION' ELSE 'OCUPACION' END as tipos"),
                        DB::raw("CASE WHEN a.estado = '1' THEN 'HABILITADO' ELSE 'NO HABILITADO' END as status")
        )
        ->groupby('a.id')
        ->orderBy('a.id','desc');

        return datatables()
            ->query($query)
            ->filterColumn('tipos', function($query, $keyword) {
                $query->whereRaw("CASE WHEN a.tipo = '1' THEN 'PROFESION' ELSE 'OCUPACION' END like UPPER(?)", ["%{$keyword}%"]);
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw("CASE WHEN a.estado = '1' THEN 'HABILITADO' ELSE 'NO HABILITADO' END like UPPER(?)", ["%{$keyword}%"]);
            })
            ->addColumn('btnActions','canasta_v2.ocupacion.partials.actions')
            ->rawColumns(['btnActions'])
            ->toJson();
    }

    public function search(Request $request)
    {
        $tipos = Ocupaciones::TIPOS;
        $estados = Ocupaciones::ESTADOS;
        $ocupaciones = Ocupaciones::query()
                                ->byOcupacion($request->ocupacion)
                                ->byTipo($request->tipo)
                                ->byEstado($request->estado)
                                ->orderBy('id', 'desc')
                                ->paginate(10);
        return view('canasta_v2.ocupacion.index', compact('tipos','estados','ocupaciones'));
    }

    public function create()
    {
        $tipos = Ocupaciones::TIPOS;
        return view('canasta_v2.ocupacion.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => ['required'],
            'detalle' => [
                'required',
                Rule::unique('ocupaciones', 'ocupacion')->where(function ($query) use ($request) {
                    return $query->where('tipo', $request->tipo);
                }),
            ]
        ], [
            'detalle.unique' => 'La Profesion / Ocupacion ya existe tipo seleccionado.',
        ]);
        try{
            $ocupacion = Ocupaciones::create([
                'tipo' => $request->tipo,
                'ocupacion' => $request->detalle,
                'estado' => '1'
            ]);
            return redirect()->route('ocupacion.index')->with('success_message', 'Se agrego una profesion / ocupacion al registro.');
        } catch (ValidationException $e) {
            return redirect()->route('ocupacion.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id)
    {
        $ocupacion = Ocupaciones::find($id);
        $tipos = Ocupaciones::TIPOS;
        return view('canasta_v2.ocupacion.editar', compact('ocupacion','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tipo' => ['required'],
            'detalle' => [
                'required',
                Rule::unique('ocupaciones', 'ocupacion')->where(function ($query) use ($request) {
                    return $query->where('tipo', $request->tipo)
                                ->where('id','!=',$request->ocupacion_id);
                }),
            ]
        ], [
            'detalle.unique' => 'La Profesion / Ocupacion ya existe tipo seleccionado.',
        ]);
        try{
            $ocupacion = Ocupaciones::find($request->ocupacion_id);
            $ocupacion->update([
                'tipo' => $request->tipo,
                'ocupacion' => $request->detalle
            ]);
            return redirect()->route('ocupacion.index')->with('info_message', 'Se modifico una profesion / ocupacion en el registro.');
        } catch (ValidationException $e) {
            return redirect()->route('ocupacion.editar')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
