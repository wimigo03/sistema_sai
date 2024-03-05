<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\CompraModel;
use App\Models\DetalleCompraModel;
use App\Models\TemporalModel;
use App\Models\EncargadosModel;
use App\Models\CatProgModel;
use App\Models\ProgramaModel;
use App\Models\ProdServModel;
use App\Models\Canasta\Dea;
use DB;

class CompraController2 extends Controller
{
    public function index()
    {
        $empleado = EmpleadosModel::find(Auth::user()->idemp);
        $estados = CompraModel::ESTADOS_COMPRA;
        $areas = AreasModel::pluck('nombrearea','idarea');
        $programas = ProgramaModel::pluck('nombreprograma','idprograma');
        $programaticas = CatProgModel::select(DB::raw("concat(codcatprogramatica,'_',nombrecatprogramatica) as categoria_programatica"),'idcatprogramatica')->pluck('categoria_programatica','idcatprogramatica');
        $compras = CompraModel::query()
                                    ->byDea(Auth::user()->dea->id)
                                    ->where('idarea',$empleado->idarea)
                                    ->orderBy('idcompra', 'desc')
                                    ->paginate(10);
        return view('compras.pedidoparcial.index', compact('estados','compras','areas','programas','programaticas'));
    }

    public function search(Request $request)
    {
        $empleado = EmpleadosModel::find(Auth::user()->idemp);
        $estados = CompraModel::ESTADOS_COMPRA;
        $areas = AreasModel::pluck('nombrearea','idarea');
        $programas = ProgramaModel::pluck('nombreprograma','idprograma');
        $programaticas = CatProgModel::select(DB::raw("concat(codcatprogramatica,'_',nombrecatprogramatica) as categoria_programatica"),'idcatprogramatica')->pluck('categoria_programatica','idcatprogramatica');
        $compras = CompraModel::query()
                                    ->byDea(Auth::user()->dea->id)
                                    ->byCodigoId($request->codigo_id)
                                    ->byControlInterno($request->control_interno)
                                    ->byPreventivo($request->nro_preventivo)
                                    ->byFechaPreventivo($request->fecha)
                                    ->byArea($request->area_id)
                                    ->byPrograma($request->programa_id)
                                    ->byCategoriaProgramatica($request->programatica_id)
                                    ->byEstado($request->estado)
                                    ->where('idarea',$empleado->idarea)
                                    ->orderBy('idcompra', 'desc')
                                    ->paginate(10);
        return view('compras.pedidoparcial.index', compact('estados','compras','areas','programas','programaticas'));
    }
    public function create()
    {
        $dea = Dea::where('id',Auth::user()->dea_id)->first();
        $empleado = EmpleadosModel::find(Auth::user()->idemp);
        $catprogramaticas = CatProgModel::select(DB::raw("concat(codcatprogramatica,' : ',nombrecatprogramatica) as programatica"), 'idcatprogramatica')
                                            ->where('estadocatprogramatica', 1)
                                            ->pluck('programatica', 'idcatprogramatica');
        $programas = ProgramaModel::where('estadoprograma', 1)->pluck('nombreprograma', 'idprograma');
        $productos = ProdServModel::join('umedida','prodserv.umedida_idumedida','umedida.idumedida')
                                    ->where('prodserv.estadoprodserv', 1)
                                    ->select(DB::raw("concat(prodserv.idprodserv,'_',prodserv.nombreprodserv,'_(',umedida.nombreumedida,')','_(BS. ',prodserv.precioprodserv,')') as prodservicio"), 'idprodserv')
                                    ->pluck('prodserv.prodservicio', 'prodserv.idprodserv');
        return view('compras.pedidoparcial.create', compact('dea','empleado','catprogramaticas','programas','productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'controlinterno' => 'required|unique:compra,controlinterno',
            'tipo' => 'required',
            'idprograma' => 'required',
            'idcatprogramatica' => 'required',
            'objeto' => 'required',
            'justificacion' => 'required',
            'producto_id' => 'required|array|min:1',
            'cantidad' => 'required|array|min:1',
            'precio' => 'required|array|min:1'
        ]);
        if($request->fecha_preventivo != null){
            $fecha_preventivo = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_preventivo)));
        }
        try{
            $compras = CompraModel::create([
                'objeto' => $request->objeto,
                'justificacion' => $request->justificacion,
                'preventivo' => $request->preventivo,
                'fecha_preventivo' => isset($fecha_preventivo) ? $fecha_preventivo : null,
                'tipo' => $request->tipo,
                'numcompra' => 0,
                'controlinterno' => $request->controlinterno,
                'idproveedor' => 1,
                'idarea' => $request->idarea,
                'idcatprogramatica' => $request->idcatprogramatica,
                'idprograma' => $request->idprograma,
                'idusuario' => Auth::user()->id,
                'estadocompra' => 1,
                'dea_id' => 1
                ]);
                
            $cont = 0;
            while($cont < count($request->producto_id)){
                $detalle = DetalleCompraModel::create([
                    'cantidad' => $request->cantidad[$cont],
                    'subtotal' => $request->subtotal[$cont],
                    'precio' => $request->precio[$cont],
                    'idprodserv' => $request->producto_id[$cont],
                    'idcompra' => $compras->idcompra,
                ]);
                $cont++;
            }
            return redirect()->route('compras.pedidoparcial.index')->with('success_message', 'Se agrego un registro de Solicitud de compra.');
        } catch (ValidationException $e) {
            return redirect()->route('compras.pedidoparcial.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function show($id)
    {
        $compra = CompraModel::find($id);
        $compra_detalle = DetalleCompraModel::where('idcompra',$id)->where('estado',1)->get();
        $total_compra = $compra_detalle->sum('subtotal');
        return view('compras.pedidoparcial.show', compact('compra','compra_detalle','total_compra'));
    }

    public function aprobar($id)
    {
        $compra = CompraModel::find($id);
        $compra->update([
            'estadocompra' => 2 
        ]);
        return redirect()->route('compras.pedidoparcial.show',$id)->with('success_message', 'Orden de Compra Aprobada.')->with('scroll_to', 'seccion-especifica');
    }

    public function rechazar($id)
    {dd($id);

    }

    public function editar($id)
    {
        $compra = CompraModel::find($id);
        $dea = Dea::where('id',Auth::user()->dea_id)->first();
        $empleado = EmpleadosModel::find(Auth::user()->idemp);
        $catprogramaticas = CatProgModel::select(DB::raw("concat(codcatprogramatica,' : ',nombrecatprogramatica) as programatica"), 'idcatprogramatica')
                                            ->where('estadocatprogramatica', 1)
                                            ->get();
        $programas = ProgramaModel::where('estadoprograma', 1)->get();
        $productos = ProdServModel::join('umedida','prodserv.umedida_idumedida','umedida.idumedida')
                                    ->where('prodserv.estadoprodserv', 1)
                                    ->select(DB::raw("concat(prodserv.idprodserv,'_',prodserv.nombreprodserv,'_(',umedida.nombreumedida,')','_(BS. ',prodserv.precioprodserv,')') as prodservicio"), 'idprodserv')
                                    ->pluck('prodserv.prodservicio', 'prodserv.idprodserv');
        $compra_detalle = DetalleCompraModel::where('idcompra',$id)->where('estado',1)->get();
        $total_compra = $compra_detalle->sum('subtotal');
        return view('compras.pedidoparcial.editar', compact('compra','dea','empleado','catprogramaticas','programas','productos','compra_detalle','total_compra'));
    }

    public function eliminar($id)
    {
        $compra_detalle = DetalleCompraModel::find($id);
        $compra_detalle->update([
            'estado' => 2
        ]);
        return redirect()->route('compras.pedidoparcial.editar',$compra_detalle->idcompra)->with('info_message', 'Se actualizo el registro de Solicitud de Compra.')->with('scroll_to', 'seccion-especifica');
    }

    public function update(Request $request)
    {
        $request->validate([
            'controlinterno' => 'required|unique:compra,controlinterno,' . $request->compra_id . ',idcompra',
            'tipo' => 'required',
            'idprograma' => 'required',
            'idcatprogramatica' => 'required',
            'objeto' => 'required',
            'justificacion' => 'required'
        ]);
        if($request->fecha_preventivo != null){
            $fecha_preventivo = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_preventivo)));
        }
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $compra = CompraModel::find($request->compra_id);
                $compra->update([
                    'objeto' => $request->objeto,
                    'justificacion' => $request->justificacion,
                    'preventivo' => $request->preventivo,
                    'fecha_preventivo' => isset($fecha_preventivo) ? $fecha_preventivo : null,
                    'tipo' => $request->tipo,
                    'controlinterno' => $request->controlinterno,
                    'idarea' => $request->idarea,
                    'idcatprogramatica' => $request->idcatprogramatica,
                    'idprograma' => $request->idprograma,
                    'idusuario' => Auth::user()->id,
                    'dea_id' => 1
                ]);
                
                if($request->producto_id != null){
                    $cont = 0;
                    while($cont < count($request->producto_id)){
                        $detalle = DetalleCompraModel::create([
                            'cantidad' => $request->cantidad[$cont],
                            'subtotal' => $request->subtotal[$cont],
                            'precio' => $request->precio[$cont],
                            'idprodserv' => $request->producto_id[$cont],
                            'idcompra' => $compra->idcompra,
                        ]);
                        $cont++;
                    }
                }
            return redirect()->route('compras.pedidoparcial.index')->with('success_message', 'Se actualizo el registro de Solicitud de Compra.');
        } catch (ValidationException $e) {
            return redirect()->route('compras.pedidoparcial.editar')
                ->withErrors($e->validator->errors())
                ->withInput();
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function destroy($id)
    {
    }

    ////////////////////////////////////ENCARGADOS/////////////////////////////////////////////////////
    public function listadoResponsables()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $encargados = DB::table('encargados as en')
            ->join('empleados as e', 'en.idemp', '=', 'e.idemp')
            ->join('areas as a', 'a.idarea', '=', 'en.idarea')
            ->where('a.idarea', $personalArea->idarea)
            //->where('a.idarea',$personalArea->idarea)
            ->select('e.nombres', 'e.ap_pat', 'e.ap_mat', 'en.abrev', 'en.idenc', 'en.cargo', 'a.nombrearea')
            ->get();
        //dd($encargados);
        //////////////////////encontrar usuario y area/////////////
        $estado = 1;

        if ($encargados->isEmpty()) {
            $estado = 0;
        }

        return view('compras.pedidoparcial.responsable', ['encargados' => $encargados, 'estado' => $estado]);
    }

    public function crearEncargado()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        //dd($personalArea->nombrearea);

        $empleados = DB::table('empleados as e')
            ->select('e.idemp', 'e.nombres', 'e.ap_pat', 'e.ap_mat')
            // -> where('ps.estadoprodserv','=', 1)
            //-> orderBy('u.id', 'asc')
            ->get();
        return view('compras.pedidoparcial.responsableCreate', compact('personalArea', 'empleados'));
    }



    public function storeEncargado(Request $request)
    {


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $responsable = new EncargadosModel();
        $responsable->abrev = $request->input('abrev');
        $responsable->idemp = $request->input('idempleado');
        $responsable->idarea = $personalArea->idarea;
        $responsable->cargo = $request->input('cargo');

        if ($responsable->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->action('App\Http\Controllers\CompraController2@listadoResponsables');
        return redirect()->route('compras.pedidoparcial.responsable');
    }



    public function responsableEdit($idresp)
    {
        $responsable = EncargadosModel::find($idresp);

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $empleados = DB::table('empleados as e')
            ->select('e.idemp', 'e.nombres', 'e.ap_pat', 'e.ap_mat')
            ->get();

        return view('compras.pedidoparcial.responsableEdit', compact('responsable', 'empleados', 'personalArea'));
    }

    public function UpdateResponsable(Request $request)
    {


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $responsable = EncargadosModel::find($request->input('idenc'));
        //$responsable = new EncargadosModel();
        $responsable->abrev = $request->input('abrev');
        $responsable->idemp = $request->input('idempleado');
        $responsable->idarea = $personalArea->idarea;
        $responsable->cargo = $request->input('cargo');

        if ($responsable->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->action('App\Http\Controllers\CompraController2@listadoResponsables');
        return redirect()->route('compras.pedidoparcial.responsable');
    }
}
