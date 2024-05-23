<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\File;
use App\Models\EscalaSalarial;
use App\Models\User;
use App\Exportar\FilesExcel;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use PDF;

class FileController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $cargos = File::where('dea_id',$dea_id)->pluck('nombrecargo','idfile');
        $tipos = File::TIPOS;
        $estados = File::ESTADOS;
        $escalas_salariales = EscalaSalarial::where('dea_id',$dea_id)->pluck('nombre','id');
        $files = File::query()
                        ->ByDea($dea_id)
                        ->orderBy('idfile','desc')
                        ->orderBy('numfile','desc')
                        ->paginate(10);
        return view('files.index', compact('dea_id','areas','cargos','tipos','estados','escalas_salariales','files'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $cargos = File::where('dea_id',$dea_id)->pluck('nombrecargo','idfile');
        $tipos = File::TIPOS;
        $estados = File::ESTADOS;
        $escalas_salariales = EscalaSalarial::where('dea_id',$dea_id)->pluck('nombre','id');
        $files = File::query()
                        ->ByDea($dea_id)
                        ->ByNroFile($request->nro_file)
                        ->ByArea($request->area_id)
                        ->ByCargo($request->cargo_id)
                        ->ByEscalaSalarial($request->escala_salarial_id)
                        ->ByTipo($request->tipo)
                        ->ByEstado($request->estado)
                        ->orderBy('idfile','desc')
                        ->orderBy('numfile','desc')
                        ->paginate(10);
        return view('files.index', compact('dea_id','areas','cargos','tipos','estados','escalas_salariales','files'));
    }

    public function create($dea_id)
    {
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $tipos = File::TIPOS;
        $escalas_salariales = EscalaSalarial::where('dea_id',$dea_id)->pluck('nombre','id');
        return view('files.create', compact('dea_id','areas','tipos','escalas_salariales'));
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
                    'nombrecargo' => $request->cargo,
                    'tipofile' => $request->tipo,
                    'estadofile' => '2',
                    'idarea' => $request->area_id,
                    'dea_id' => $request->dea_id,
                    'escala_salarial_id' => $request->escala_salarial_id
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
        $escalas_salariales = EscalaSalarial::where('dea_id',$dea_id)->get();
        return view('files.editar', compact('file','dea_id','areas','tipos','escalas_salariales'));
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
                    'nombrecargo' => $request->cargo,
                    'tipofile' => $request->tipo,
                    'idarea' => $request->area_id,
                    'estadofile' => isset($request->estado) ? $request->estado : '1',
                    'escala_salarial_id' => $request->escala_salarial_id
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
                        ->ByCargo($request->cargo_id)
                        ->ByEscalaSalarial($request->escala_salarial_id)
                        ->ByTipo($request->tipo)
                        ->ByEstado($request->estado)
                        ->orderBy('idfile','desc')
                        ->orderBy('numfile','desc')
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
