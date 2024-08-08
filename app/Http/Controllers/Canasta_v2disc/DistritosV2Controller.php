<?php

namespace App\Http\Controllers\Canasta_v2disc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use App\Models\CanastaDisc\Distrito;
use App\Models\CanastaDisc\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\DistritosExcel;
use App\Models\User;
use DB;
use PDF;

class DistritosV2Controller extends Controller
{
    private function copiardistritos()
    {
         $distritos = DB::connection('mysql_canasta')->table("barrios")->get();
        foreach ($distritos as $data){
            $datos = ([
                'nombre'=>$data->distrito,
                'user_id'=>16,
                'dea_id'=>1,
                'estado'=>1
                ]);

            $distrito=Distrito::CREATE($datos);
        }
    }

    public function index()
    {
        //$this->copiardistritos();
        $dea_id = Auth::user()->dea->id;
        $estados = Distrito::ESTADOS;
        $distritos = Distrito::query()
                                ->byDea($dea_id)
                                ->orderBy('id', 'desc')
                                ->paginate(10);
        return view('canasta_v2.distrito.index', compact('estados','distritos'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $estados = Distrito::ESTADOS;
        $distritos = Distrito::query()
                                ->byDea($dea_id)
                                ->byCodigo($request->codigo)
                                ->byNombre($request->nombre)
                                ->byUsuario($request->usuario)
                                ->byEstado($request->estado)
                                ->orderBy('id', 'desc')
                                ->paginate(10);
        return view('canasta_v2.distrito.index', compact('estados','distritos'));
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $dea_id = Auth::user()->dea->id;
            $distritos = Distrito::query()
                                ->byDea($dea_id)
                                ->byCodigo($request->codigo)
                                ->byNombre($request->nombre)
                                ->byUsuario($request->usuario)
                                ->byEstado($request->estado)
                                ->orderBy('id', 'desc')
                                ->get();
            return Excel::download(new DistritosExcel($distritos),'distritos.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function create()
    {
        return view('canasta_v2.distrito.create');
    }

    public function store(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('distritos', 'nombre')->where(function ($query) use ($dea_id) {
                    return $query->where('dea_id', $dea_id);
                }),
            ]
        ]);
        try{
            $distrito = Distrito::create([
                'nombre' => $request->nombre,
                'user_id' => Auth::user()->id,
                'dea_id' => $dea_id,
                'estado' => 1
            ]);
            return redirect()->route('distritos.index')->with('success_message', 'Se agrego un distrito al registro.');
        } catch (ValidationException $e) {
            return redirect()->route('distritos.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id)
    {
        $distrito = Distrito::find($id);
        return view('canasta_v2.distrito.editar', compact('distrito'));
    }

    public function update(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('distritos', 'nombre')->where(function ($query) use ($request,$dea_id) {
                    return $query->where('dea_id', $dea_id)
                                ->where('id','!=',$request->distrito_id);;
                }),
            ]
        ], [
            'nombre.unique' => 'El nombre ya existe para el dea proporcionada.',
        ]);
        try{
            $distrito = Distrito::find($request->distrito_id);
            $distrito->update([
                'nombre' => $request->nombre,
                'user_id' => Auth::user()->id,
                'dea_id' => $dea_id
            ]);
            return redirect()->route('distritos.index')->with('success_message', 'Se modifico un registro de distrito.');
        } catch (ValidationException $e) {
            return redirect()->route('distritos.editar')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function deshabilitar($id){
        $distrito = Distrito::find($id);
        $distrito->update([
            'estado' => 2
        ]);
        return redirect()->route('distritos.index')->with('info_message', 'Se deshabilito el distrito seleccionado.');
    }

    public function habilitar($id){
        $distrito = Distrito::find($id);
        $distrito->update([
            'estado' => 1
        ]);
        return redirect()->route('distritos.index')->with('info_message', 'Se habilito el distrito seleccionado.');
    }
}
