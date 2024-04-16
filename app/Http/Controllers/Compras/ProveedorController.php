<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\Proveedor;
use DB;

class ProveedorController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $proveedores = Proveedor::query()
                                ->ByDea($dea_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Proveedor::ESTADOS;
        return view('compras.proveedor.index',compact('dea_id','proveedores','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $proveedores = Proveedor::query()
                                ->ByDea($dea_id)
                                ->ByNro($request->nro)
                                ->ByNombre($request->nombre)
                                ->ByRepresentante($request->representante)
                                ->ByNroCi($request->nro_ci)
                                ->ByNit($request->nit)
                                ->ByTelefono($request->telefono)
                                ->ByFechaRegistro($request->fecha_registro)
                                ->ByEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Proveedor::ESTADOS;
        return view('compras.proveedor.index',compact('dea_id','proveedores','estados'));
    }

    public function create($dea_id)
    {
        return view('compras.proveedor.create',compact('dea_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'nro_carnet' => 'required|unique:proveedor,nro_ci,null,id,dea_id,' . $request->dea_id,
            'representante' => 'required',
            'nit' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'dea_id' => $request->dea_id,
                    'user_id' => Auth::user()->id,
                    'nombre' => $request->nombre,
                    'representante' => $request->representante,
                    'nro_ci' => $request->nro_carnet,
                    'nit' => $request->nit,
                    'telefono' => $request->telefono,
                    'fecha_registro' => date('Y-m-d'),
                    'estado' => '1'
                ];

                $proveedor = Proveedor::create($datos);

                return $proveedor;
            });
            Log::channel('proveedores')->info(
                "Proveedor: Creado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('proveedor.index')->with('success_message', '[El proveedor fue creado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('proveedores')->info(
                "Error al crear proveedor: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el proveedor.]')->withInput();
        }
    }

    public function habilitar($proveedor_id)
    {
        try{
            $function = DB::transaction(function () use ($proveedor_id) {
                $datos = [
                    'estado' => '1'
                ];

                $proveedor = Proveedor::find($proveedor_id);
                $proveedor->update($datos);

                return $proveedor;
            });
            Log::channel('proveedores')->info(
                "Proveedor: " . $function->nombre . " fue habilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('proveedor.index')->with('success_message', '[El proveedor ' . $function->nombre . ' fue habilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('proveedores')->info(
                "Error al habilitar proveedor: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar el proveedor.]')->withInput();
        }
    }

    public function deshabilitar($proveedor_id)
    {
        try{
            $function = DB::transaction(function () use ($proveedor_id) {
                $datos = [
                    'estado' => '2'
                ];

                $proveedor = Proveedor::find($proveedor_id);
                $proveedor->update($datos);

                return $proveedor;
            });
            Log::channel('proveedores')->info(
                "Proveedor: " . $function->nombre . " fue deshabilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('proveedor.index')->with('success_message', '[El proveedor ' . $function->nombre . ' fue deshabilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('proveedores')->info(
                "Error al deshabilitar proveedor: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar el proveedor.]')->withInput();
        }
    }

    public function editar($proveedor_id)
    {
        $proveedor = Proveedor::find($proveedor_id);
        return view('compras.proveedor.editar',compact('proveedor'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'nro_carnet' => 'required|unique:proveedor,nro_ci,' . $request->proveedor_id . ',id,dea_id,' . $request->dea_id,
            'representante' => 'required',
            'nit' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'nombre' => $request->nombre,
                    'representante' => $request->representante,
                    'nro_ci' => $request->nro_carnet,
                    'nit' => $request->nit,
                    'telefono' => $request->telefono
                ];

                $proveedor = Proveedor::find($request->proveedor_id);
                $proveedor->update($datos);

                return $proveedor;
            });
            Log::channel('proveedores')->info(
                "Proveedor: Modificado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('proveedor.index')->with('success_message', '[El proveedor fue modificado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('proveedores')->info(
                "Error al modificar proveedor: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el proveedor.]')->withInput();
        }
    }
}
