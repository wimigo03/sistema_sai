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
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\HistorialMod;
use App\Models\Canasta\HistorialBaja;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BarriosExcel;
use App\Models\Canasta\Ocupaciones;
use App\Models\User;
use DB;
use PDF;


class BarriosV2Controller extends Controller
{

    private function copiarBarrios()
    {
        $barrios = DB::connection('mysql_canasta')
                                ->table("barrios")
                                ->where('distrito','!=',null)
                                //->where('estado','=','A')
                                //->where('tipo','=','Comunidad')
                                ->get();
        foreach ($barrios as $data){
            $tipo = 0;
            if($data->tipo == 'Barrio'){
                $tipo = 1;
           }elseif($data->tipo == 'Comunidad'){
            $tipo = 2;
           }

            $datos=([
                'id' => $data->id_barrio,
                'tipo' => $tipo,
                'nombre' => $data->barrio,
                'distrito_id' => $data->distrito,
                'user_id' => 16,
                'dea_id' => 1,
                'estado' => 1
            ]);
            $barrio=Barrio::CREATE($datos);
        }
    }

    private function copiarOcupacion()
    {
         $ocupaciones = DB::connection('mysql_canasta')
                            ->table("ocupaciones")
                            //->where('distrito','!=',null)
                            //->where('estado','=','A')
                            //->where('tipo','=','Comunidad')
                            ->get();

        foreach ($ocupaciones as $data){
            $datos = ([
                'id' => $data->id_ocupacion,
                'ocupacion' => $data->ocupacion,
                'estado' => 1
            ]);
            $ocupacionff = Ocupaciones::CREATE($datos);
        }
    }

    private function copiarhistorialMod()
    {
         $historialM = DB::connection('mysql_canasta')
                            ->table("historialMod")
                            //->where('distrito','!=',null)
                            //->where('estado','=','A')
                            //->where('tipo','=','Comunidad')
                            ->where('idHistorialMod','>',9486)
                            //->where('idHistorialMod','<',3000)
                            ->get();

         foreach ($historialM as $data){
            $datos = ([
                'id' => $data->idHistorialMod,
                'observacion' => $data->observacion,
                'id_beneficiario' => $data->idUsuario,
                'dea_id' => 1,
                'user_id' => 29,
                'created_at' => $data->fecha
            ]);
            $historialMod=HistorialMod::CREATE($datos);
        }
    }

    private function copiarhistorialBaja()
    {
        $historialB = DB::connection('mysql_canasta')
                            ->table("historialbaja")
                            //->where('distrito','!=',null)
                            //->where('estado','=','A')
                            //->where('tipo','=','Comunidad')
                            ->where('idHistorialBaja','<',3400)
                            ->get();

        foreach ($historialB as $data){
            $datos = ([
                'id' => $data->idHistorialBaja,
                'observacion' => $data->obs,
                'id_beneficiario' => $data->idUsuario,
                'dea_id' => 1,
                'user_id' => 29,
                'created_at' => $data->fecha
            ]);
            $historialBaja=HistorialBaja::CREATE($datos);
        }
    }

    public function index()
    {
        //if(Auth::user()->id == 102){
            //$this->copiarhistorialBaja();
        //}
        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $distritos2 = Distrito::where('dea_id',$dea_id)->get();
        $deas = Dea::where('id',$dea_id)->get('nombre','id');
        $beneficiariosA = Beneficiario::where('dea_id',$dea_id)->where('estado','A')->count();
        $beneficiariosB = Beneficiario::where('dea_id',$dea_id)->where('estado','B')->count();
        $beneficiariosF = Beneficiario::where('dea_id',$dea_id)->where('estado','F')->count();
        $beneficiariosX = Beneficiario::where('dea_id',$dea_id)->where('estado','X')->count();

        $estados = Barrio::ESTADOS;
        $barrios = Barrio::where('dea_id',$dea_id)
                            ->orderBy('id', 'desc')
                            ->paginate(10);
        return view('canasta_v2.barrio.index', compact('dea_id','tipos','distritos','distritos2','deas','estados','barrios','beneficiariosA','beneficiariosB','beneficiariosF','beneficiariosX'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $deas = Dea::where('id',$dea_id)->pluck('nombre','id');
        $distritos2 = Distrito::where('dea_id',$dea_id)->get();
        $estados = Barrio::ESTADOS;
        $beneficiariosA = Beneficiario::where('dea_id',$dea_id)->where('estado','A')->count();
        $beneficiariosB = Beneficiario::where('dea_id',$dea_id)->where('estado','B')->count();
        $beneficiariosF = Beneficiario::where('dea_id',$dea_id)->where('estado','F')->count();
        $beneficiariosX = Beneficiario::where('dea_id',$dea_id)->where('estado','X')->count();

        $barrios = Barrio::query()
                            ->byCodigo($request->codigo)
                            ->byTipo($request->tipo)
                            ->byNombre($request->nombre)
                            ->byDea($dea_id)
                            ->byDistrito($request->distrito_id)
                            ->byEstado($request->estado)
                            ->orderBy('id', 'desc')
                            ->paginate(10);
                            return view('canasta_v2.barrio.index', compact('dea_id','tipos','distritos','distritos2','deas','estados','barrios','beneficiariosA','beneficiariosB','beneficiariosF','beneficiariosX'));
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $dea_id = Auth::user()->dea->id;
            $barrios = Barrio::query()
                            ->byCodigo($request->codigo)
                            ->byTipo($request->tipo)
                            ->byNombre($request->nombre)
                            ->byDea($dea_id)
                            ->byDistrito($request->distrito_id)
                            ->byEstado($request->estado)
                            ->orderBy('id', 'desc')
                            ->get();
            return Excel::download(new BarriosExcel($barrios),'barrios.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $tipos = Barrio::TIPOS;
        return view('canasta_v2.barrio.create', compact('dea_id','distritos','tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => ['required'],
            'nombre' => [
                'required',
                Rule::unique('barrios', 'nombre')->where(function ($query) use ($request) {
                    return $query->where('distrito_id', $request->distrito)
                                ->where('tipo', $request->tipo)
                                ->where('dea_id', $request->dea_id);
                }),
            ],
            'distrito' => ['required']
        ], [
            'nombre.unique' => 'El nombre ya existe para el dea y tipo proporcionados.',
        ]);
        try{
            $distrito = Distrito::select('dea_id')->where('id',$request->distrito)->first();
            $barrio = Barrio::create([
                'tipo' => $request->tipo,
                'nombre' => $request->nombre,
                'distrito_id' => $request->distrito,
                'user_id' => Auth::user()->id,
                'dea_id' => $distrito->dea_id,
                'estado' => 1
            ]);
            return redirect()->route('barrios.index')->with('success_message', 'Se agrego un barrio al registro.');
        } catch (ValidationException $e) {
            return redirect()->route('barrios.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function editar($id)
    {
        $dea_id = Auth::user()->dea->id;
        $barrio = Barrio::find($id);
        $distritos = Distrito::select('nombre','id')->where('dea_id',$dea_id)->get();
        $tipos = Barrio::TIPOS;
        return view('canasta_v2.barrio.editar', compact('dea_id','barrio','distritos','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tipo' => ['required'],
            'distrito' => ['required'],
            'nombre' => [
                'required',
                Rule::unique('barrios', 'nombre')->where(function ($query) use ($request) {
                    return $query->where('distrito_id', $request->distrito)
                                    ->where('tipo', $request->tipo)
                                    ->where('dea_id', $request->dea_id)
                                    ->where('id','!=',$request->barrio_id);
                }),
            ]
        ], [
            'nombre.unique' => 'El nombre ya existe para el dea y tipo proporcionados.',
        ]);
        try{
            $barrio = Barrio::find($request->barrio_id);
            $distrito = Distrito::select('dea_id')->where('id',$request->distrito)->first();
            $barrio->update([
                'tipo' => $request->tipo,
                'nombre' => $request->nombre,
                'distrito_id' => $request->distrito,
                'user_id' => Auth::user()->id,
                'dea_id' => $distrito->dea_id
            ]);
            return redirect()->route('barrios.index')->with('success_message', 'Se modifico un registro de barrio.');
        } catch (ValidationException $e) {
            return redirect()->route('barrios.editar')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function deshabilitar($id){
        $barrio = Barrio::find($id);
        $barrio->update([
            'estado' => 2
        ]);
        return redirect()->route('barrios.index')->with('info_message', 'Se deshabilito el barrio seleccionado.');
    }

    public function habilitar($id){
        $barrio = Barrio::find($id);
        $barrio->update([
            'estado' => 1
        ]);
        return redirect()->route('barrios.index')->with('info_message', 'Se habilito el barrio seleccionado.');
    }
}
