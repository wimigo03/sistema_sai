<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\File;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Exportar\FilesExcel;
use DB;
use PDF;

class FileController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $cargos = File::select('cargo')->where('dea_id',$dea_id)->groupBy('cargo')->pluck('cargo','cargo');
        $categorias = File::select('categoria')->where('dea_id',$dea_id)->groupBy('categoria')->pluck('categoria','categoria');
        $tipos = File::TIPOS;
        $estados = File::ESTADOS;
        $files = File::query()
                        ->ByDea($dea_id)
                        ->orderBy('idfile','desc')
                        ->paginate(10);
        return view('files.index', compact('dea_id','areas','cargos','categorias','tipos','estados','files'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $cargos = File::select('cargo')->where('dea_id',$dea_id)->groupBy('cargo')->pluck('cargo','cargo');
        $categorias = File::select('categoria')->where('dea_id',$dea_id)->groupBy('categoria')->pluck('categoria','categoria');
        $tipos = File::TIPOS;
        $estados = File::ESTADOS;
        $files = File::query()
                        ->ByDea($dea_id)
                        ->ByNroFile($request->nro_file)
                        ->ByArea($request->area_id)
                        ->ByCargo($request->cargo)
                        ->ByHaberBasico($request->haber_basico)
                        ->ByCategoria($request->categoria)
                        ->ByNivelAdministrativo($request->n_adm)
                        ->ByClase($request->clase)
                        ->ByNivelSalarial($request->n_salarial)
                        ->ByTipo($request->tipo)
                        ->ByEstado($request->estado)
                        ->orderBy('idfile','desc')
                        ->paginate(10);
        return view('files.index', compact('dea_id','areas','cargos','categorias','tipos','estados','files'));
    }

    public function create($dea_id)
    {
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $tipos = File::TIPOS;
        return view('files.create', compact('dea_id','areas','tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nro_file' => 'required|unique:file,numfile,null,idfile,dea_id,' . $request->dea_id
        ]);
        try{
            $file = DB::transaction(function () use ($request) {
                $file = File::create([
                    'numfile' => $request->nro_file,
                    'cargo' => $request->cargo,
                    'nombrecargo' => $request->cargo_detalle,
                    'habbasico' => floatval(str_replace(",", "", $request->haber_basico)),
                    'categoria' => $request->categoria,
                    'niveladm' => $request->nivel_administrativo,
                    'clase' => $request->clase,
                    'nivelsal' => $request->nivel_salarial,
                    'tipofile' => $request->tipo,
                    'estadofile' => '2',
                    'idarea' => $request->area_id,
                    'dea_id' => $request->dea_id
                ]);

                return $file;
            });

            Log::channel('recursos_humanos')->info(
                "\n" .
                "Item: " . $file->idfile . " registrado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('file.index')->with('success_message', 'Se agregó un registro de item correctamente.');
        } catch (\Exception $e) {
            Log::channel('recursos_humanos')->info(
                "\n" .
                "Error al registrar item: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el registro]')->withInput();
        }
    }

    public function editar($file_id)
    {
        $file = File::find($file_id);
        $dea_id = $file->dea_id;
        $areas = Area::where('dea_id',$dea_id)->get();
        $tipos = File::TIPOS;
        return view('files.editar', compact('file','dea_id','areas','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nro_file' => 'required|unique:file,numfile,' . $request->file_id . ',idfile,dea_id,' . $request->dea_id
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $file = File::find($request->file_id);
                $file->update([
                    'numfile' => $request->nro_file,
                    'cargo' => $request->cargo,
                    'nombrecargo' => $request->cargo_detalle,
                    'habbasico' => floatval(str_replace(",", "", $request->haber_basico)),
                    'categoria' => $request->categoria,
                    'niveladm' => $request->nivel_administrativo,
                    'clase' => $request->clase,
                    'nivelsal' => $request->nivel_salarial,
                    'tipofile' => $request->tipo,
                    'idarea' => $request->area_id,
                    'estadofile' => isset($request->estado) ? $request->estado : '1'
                ]);

                return $file;
            });

            Log::channel('recursos_humanos')->info(
                "\n" .
                "Item: " . $function->idfile . " actualizado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('file.index')->with('info_message', 'Se actualizo un registro de item correctamente.');
        } catch (\Exception $e) {
            Log::channel('recursos_humanos')->info(
                "\n" .
                "Error al actualizar item: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al actualizar el registro]')->withInput();
        }
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $dea_id = $request->dea_id;
                $files = File::query()
                        ->ByDea($dea_id)
                        ->ByNroFile($request->nro_file)
                        ->ByArea($request->area_id)
                        ->ByCargo($request->cargo)
                        ->ByHaberBasico($request->haber_basico)
                        ->ByCategoria($request->categoria)
                        ->ByNivelAdministrativo($request->n_adm)
                        ->ByClase($request->clase)
                        ->ByNivelSalarial($request->n_salarial)
                        ->ByTipo($request->tipo)
                        ->ByEstado($request->estado)
                        ->orderBy('idfile','desc')
                        ->get();
                return Excel::download(new FilesExcel($files),'files.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
