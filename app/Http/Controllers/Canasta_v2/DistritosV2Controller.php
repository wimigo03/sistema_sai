<?php

namespace App\Http\Controllers\Canasta_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Dea;
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

            $datos=([

                'nombre'=>$data->distrito,
                'user_id'=>16,
                'dea_id'=>1,
                'estado'=>1
                      ]


                     );
              $distrito=Distrito::CREATE($datos);
    }
       // dd($distritos);

    }

    public function index()
    {

        //$this->copiardistritos();
        $deas = Dea::pluck('nombre','id');
        $estados = Distrito::ESTADOS;
        $distritos = Distrito::orderBy('id', 'desc')->paginate(10);
        return view('canasta_v2.distrito.index', compact('deas','estados','distritos'));
    }

    public function search(Request $request)
    {
        $deas = Dea::pluck('nombre','id');
        $estados = Distrito::ESTADOS;
        $distritos = Distrito::query()
                                ->byCodigo($request->codigo)
                                ->byNombre($request->nombre)
                                ->byUsuario($request->usuario)
                                ->byDea($request->dea_id)
                                ->byEstado($request->estado)
                                ->orderBy('id', 'desc')
                                ->paginate(10);
        return view('canasta_v2.distrito.index', compact('deas','estados','distritos'));
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $distritos = Distrito::query()
                                ->byCodigo($request->codigo)
                                ->byNombre($request->nombre)
                                ->byUsuario($request->usuario)
                                ->byDea($request->dea_id)
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
        $deas = Dea::pluck('nombre','id');
        return view('canasta_v2.distrito.create', compact('deas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dea' => ['required'],
            'nombre' => [
                'required',
                Rule::unique('distritos', 'nombre')->where(function ($query) use ($request) {
                    return $query->where('dea_id', $request->dea);
                }),
            ]
        ]);
        try{
            $distrito = Distrito::create([
                'nombre' => $request->nombre,
                'user_id' => Auth::user()->id,
                'dea_id' => $request->dea,
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
        $deas = Dea::select('nombre','id')->get();
        return view('canasta_v2.distrito.editar', compact('distrito','deas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'dea' => ['required'],
            'nombre' => [
                'required',
                Rule::unique('distritos', 'nombre')->where(function ($query) use ($request) {
                    return $query->where('dea_id', $request->dea);
                }),
            ]
        ]);
        try{
            $distrito = Distrito::find($request->distrito_id);
            $distrito->update([
                'nombre' => $request->nombre,
                'user_id' => Auth::user()->id,
                'dea_id' => $request->dea
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
