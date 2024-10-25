<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Almacen\Ingreso\Temporal2Model;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\EncargadosModel;
use App\Models\File;
use App\Models\Transporte\SoluconsumoModel;
use App\Models\Transporte\Temporal5Model;

use App\Models\TemporalModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;


class SoluconsumoController extends Controller
{
    public function index(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {


        $soluconsumos = DB::table('soluconsumo as s')

        ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
        ->join('areas as a', 'a.idarea', '=', 's.idarea')



        ->where('s.estado1',2)

        ->select('s.estadosoluconsumo','s.idsoluconsumo','s.cominterna','s.referencia', 's.oficina',

                            'a.nombrearea',
                            'lo.nombrelocalidad'
                            )

                        ->orderBy('s.cominterna', 'desc');


                        return Datatables::of($soluconsumos)
                        ->addIndexColumn()
                         ->addColumn('btn', 'transportes.pedido.btn')
                         ->addColumn('btn2', 'transportes.pedido.btn2')

                        // ->rawColumns(['btn','btn2'])
                         ->rawColumns(['btn','btn2'])
                        ->make(true);

                    }
                    $personal = User::find(Auth::user()->id);
                    $id = $personal->id;
                    $userdate = User::find($id)->usuariosempleados;
                    $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

       return view('transportes.pedido.index', ['idd' => $personalArea]);
    }

    public function index2(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {


            $soluconsumos = DB::table('soluconsumo as s')

            ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
            ->join('areas as a', 'a.idarea', '=', 's.idarea')



            ->where('s.estado2',2)

            ->select('s.estadosoluconsumo','s.idsoluconsumo','s.cominterna',
            's.referencia', 's.oficina',

                                'a.nombrearea',
                                'lo.nombrelocalidad'
                                )

                        ->orderBy('s.cominterna', 'asc');


                        return Datatables::of($soluconsumos)
                        ->addIndexColumn()
                         ->addColumn('btn', 'transportes.pedido.btn')
                         ->addColumn('btn3', 'transportes.pedido.btn3')

                        // ->rawColumns(['btn','btn2'])
                         ->rawColumns(['btn','btn3'])
                        ->make(true);

                    }
                    $personal = User::find(Auth::user()->id);
                    $id = $personal->id;
                    $userdate = User::find($id)->usuariosempleados;
                    $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

       return view('transportes.pedido.index2', ['idd' => $personalArea]);
    }

    public function index3(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {
        $soluconsumos = DB::table('soluconsumo as s')
        ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
        ->join('areas as a', 'a.idarea', '=', 's.idarea')

        ->select(['s.estadosoluconsumo','s.idsoluconsumo','s.cominterna','s.fechasol',
        's.referencia', 's.oficina',

                            'a.nombrearea',
                            'lo.nombrelocalidad']
                            )
                        ->orderBy('s.idsoluconsumo', 'desc');

                        $soluconsumos = $soluconsumos->get();
                        return DataTables::of($soluconsumos)
                        ->addIndexColumn()
                        ->addColumn('fechasol', function ($soluconsumos) {
                            return $soluconsumos->fechasol;
                        })
                        ->addColumn('referencia', function ($soluconsumos) {
                            return $soluconsumos->referencia;
                        })
                        ->addColumn('nombrearea', function ($soluconsumos) {
                            return $soluconsumos->nombrearea;
                        })
                        ->addColumn('oficina', function ($soluconsumos) {
                            return $soluconsumos->oficina;
                        })
                        ->addColumn('cominterna', function ($soluconsumos) {
                            return $soluconsumos->cominterna;
                        })

                        ->addColumn('nombrelocalidad', function ($soluconsumos) {
                            return $soluconsumos->nombrelocalidad;
                        })

                        ->addColumn('estadosoluconsumo', function ($soluconsumos) {

                            if ($soluconsumos->estadosoluconsumo == '1') {
                                //'<b style="color: green">Sin repuesta</b>';
                                 return  '<b style="color: green">Pendiente</b>';


                            } else {
                                if ($soluconsumos->estadosoluconsumo == '2') {
                                    return  '<b style="color: blue">Aprovada</b>';

                            } else {
                                if ($soluconsumos->estadosoluconsumo == '5') {
                                    return  '<b style="color: purple">Almacen</b>';
                            }  else {

                                if ($soluconsumos->estadosoluconsumo == '10') {
                                    return  '<b style="color: red">Rechazado</b>';
                                }  else {
                    } }}}
                }
                        )
                        ->addColumn('actions', function ($soluconsumos) {

                            return '<a class="tts:left tts-slideIn tts-custom" aria-label=" boton uno" href="' . route('transportes.pedido.editar', $soluconsumos->idsoluconsumo) . '">
                            <button class="btn btn-sm btn-primary font-verdana" type="button">
                                <i class="fa fa-pencil fa-fw"></i>
                            </button>
                        </a>';
            })


                        ->rawColumns(['actions', 'estadosoluconsumo'])
                        ->make(true);

                    }
                    $personal = User::find(Auth::user()->id);
                    $id = $personal->id;
                    $userdate = User::find($id)->usuariosempleados;
                    $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

       return view('transportes.pedido.index3', ['idd' => $personalArea]);
    }

    public function index4(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {


        $soluconsumos = DB::table('soluconsumo as s')

        ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
        ->join('areas as a', 'a.idarea', '=', 's.idarea')



        ->where('s.estado1',2)

        ->select('s.estadosoluconsumo','s.idsoluconsumo','s.cominterna','s.referencia', 's.oficina',

                            'a.nombrearea',
                            'lo.nombrelocalidad'
                            )

                        ->orderBy('s.idsoluconsumo', 'asc');


                        return Datatables::of($soluconsumos)
                        ->addIndexColumn()
                         ->addColumn('btn', 'transportes.pedido.btn')


                        // ->rawColumns(['btn','btn2'])
                         ->rawColumns(['btn'])
                        ->make(true);
                    }
                    $personal = User::find(Auth::user()->id);
                    $id = $personal->id;
                    $userdate = User::find($id)->usuariosempleados;
                    $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

       return view('transportes.pedido.index4', ['idd' => $personalArea]);
    }


     public function editar($idsoluconsumo){
        $soluconsumos = SoluconsumoModel::find($idsoluconsumo);

        $areas = DB::table('areas')->get();
        $localidades = DB::table('localidad')->get();
        $empleados = DB::table('empleados')->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        return view('transportes.pedido.editar',

        compact('id','soluconsumos','areas',
        'empleados','localidades'));
    }

    public function update(Request $request){
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;


// de parte de
$productocinco = Empleado::find($userdate->idemp);
$Nombreusuario = $productocinco->nombres;
$Apellidopausuario = $productocinco->ap_pat;
$Apellidomausuario = $productocinco->ap_mat;
$Nombrecompusuario= $Nombreusuario . " " .  $Apellidopausuario. " " .$Apellidomausuario ;

$IdFiletres = $productocinco->idfile;
$productoseis = File::find($IdFiletres);
$Nombreusuariocargo = $productoseis->nombrecargo;



// dirigido a
        $prod = $request->get('dirigidoa');
        $producto = Empleado::find($prod);
        $Nombredir = $producto->nombres;
        $Apellidopadir = $producto->ap_pat;
        $Apellidomadir = $producto->ap_mat;
        $Nombrecompdir= $Nombredir . " " .  $Apellidopadir. " " .$Apellidomadir ;

        $IdFile = $producto->idfile;
        $productodos = File::find($IdFile);
        $Nombredircargo = $productodos->nombrecargo;


// via uno

$proddos = $request->get('viauno');
$productotres = Empleado::find($proddos);
$Nombrevia = $productotres->nombres;
$Apellidopavia = $productotres->ap_pat;
$Apellidomavia = $productotres->ap_mat;
$Nombrecompvia= $Nombrevia . " " .  $Apellidopavia. " " .$Apellidomavia ;

$IdFiledos = $productotres->idfile;
$productocuatro = File::find($IdFiledos);
$Nombreviacargo = $productocuatro->nombrecargo;


        $soluconsumos = SoluconsumoModel::find($request->idsoluconsumo);


        $soluconsumos->oficina = $request->input('oficina');
        $soluconsumos->cominterna = $request->input('cominterna');


        $soluconsumos->dirigidoa = $request->get('dirigidoa');  //dirigido a
        $soluconsumos->dirnombre = $Nombrecompdir;
        $soluconsumos->diracargo = $Nombredircargo;


        $soluconsumos->viauno = $request->get('viauno');  //via
        $soluconsumos->viaunonombre = $Nombrecompvia;
        $soluconsumos->viaunocargo = $Nombreviacargo;


        $soluconsumos->idarea = $personalArea->idarea;  //de , nombre, cargo oficina


        $soluconsumos->idusuario =$id;
        $soluconsumos->usuarionombre = $Nombrecompusuario;
        $soluconsumos->usuariocargo = $Nombreusuariocargo;


        $soluconsumos->referencia = $request->input('referencia');
        $soluconsumos->fechasol = $request->input('fechasol');
        $soluconsumos->detallesouconsumo = $request->input('detallesouconsumo');

        $soluconsumos->fechasalida = $request->input('fechasalida');
        $soluconsumos->fecharetorno = $request->input('fecharetorno');

        $soluconsumos->idlocalidad = $request->input('idlocalidad');  //lugar

        $soluconsumos->tsalida = $request->input('tsalida');
        $soluconsumos->tllegada = $request->input('tllegada');

        if($soluconsumos->save()){

            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('transportes.pedido.index');
    }

    public function edit($idsoluconsumo){//dd($idcomp);
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $detalle = Temporal5Model::find($id);

        if(is_null($detalle)){
            $detalle = new Temporal5Model;
            $detalle->idtemporal5=$id;
            $detalle->idusuario=$id;
            $detalle->idsoluconsumo=$idsoluconsumo;
            $detalle->save();
        }else{
            $detalle->idtemporal5 = $id;
            $detalle->idusuario = $id;
            $detalle->idsoluconsumo = $idsoluconsumo;
            $detalle->update();
        }

       return redirect()->route('transportes.detalle.index');
    }

    public function editable($idsoluconsumo){//dd($idcomp);
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $detalle = Temporal5Model::find($id);

        if(is_null($detalle)){
            $detalle = new Temporal5Model;
            $detalle->idtemporal5=$id;
            $detalle->idusuario=$id;
            $detalle->idsoluconsumo=$idsoluconsumo;
            $detalle->save();
        }else{
            $detalle->idtemporal5 = $id;
            $detalle->idusuario = $id;
            $detalle->idsoluconsumo = $idsoluconsumo;
            $detalle->update();
        }

       return redirect()->route('transportes.detalle.index2');
    }


    public function pdf()
    {


       $localidads = DB::table('localidad')->get();
       $pdf = PDF::loadView('combustibles.localidad.pdf',compact('localidads'));
      return $pdf->stream();
    }

    public function aprovar($idsoluconsumo)
    {
        $detalle = SoluconsumoModel::find($idsoluconsumo);
        $detalle->estadosoluconsumo =2;

        if($detalle->save()){
            session()->flash('message', 'Registro Procesado');
        }else{
            session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('transportes.pedido.index3');

    }

    public function rechazar($idsoluconsumo)
    {
        $detalle = SoluconsumoModel::find($idsoluconsumo);
        $detalle->estadosoluconsumo =10;

        if($detalle->save()){
            session()->flash('message', 'Registro Procesado');
        }else{
            session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('transportes.pedido.index3');

    }

    public function rechazartr($idsoluconsumo)
    {
        $detalle = SoluconsumoModel::find($idsoluconsumo);
        $detalle->estadosoluconsumo =5;
        $detalle->estado1 =5;
        if($detalle->save()){
            session()->flash('message', 'Registro Procesado');
        }else{
            session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('transportes.pedido.index3');

    }
}

