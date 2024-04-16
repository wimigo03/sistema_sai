<?php

namespace App\Http\Controllers\Almacen\Comprobante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;

use App\Models\EmpleadosModel;
use App\Models\AreasModel;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use PDF;
use NumerosEnLetras;
use App\Models\Almacen\Ingreso\DetalleValeModel;

//use App\Models\Almacen\Ingreso\IngresoModel;
use App\Models\IngresoModel;
use App\Models\Almacen\Temporal4Model;

use App\Models\DetalleCompraModel;

//use App\Models\Almacen\Ingreso\NotaIngresoModel;


use App\Models\Almacen\Ingreso\Temporal6Model;
use App\Models\Almacen\Ingreso\NotaIngresoModel;
use Hamcrest\TypeSafeDiagnosingMatcher;

use App\Models\Almacen\Temporal2Model;

use App\Models\Almacen\Comprobante\ComingresoModel;
use App\Models\Almacen\Comprobante\TipocomingresoModel;

use App\Models\Almacen\Comprobante\DetalleComingresoModel;
use App\Models\Compra\ProdCombModel;
use App\Models\Compra\CatProgModel;
use Carbon\Carbon;

class ComingresoController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $ingresos = DB::table('comingreso as ing')

            ->join('proveedor as p', 'p.idproveedor', '=', 'ing.idproveedor')
            ->join('areas as ar', 'ar.idarea', '=', 'ing.idarea')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'ing.idcatprogramaticacomb')
            ->join('programacomb as pro', 'pro.idprogramacomb', '=', 'ing.idprogramacomb')
            // ->where('ing.estadoingreso',1)

            ->select(
                'ing.idcomingreso',
                'ing.fechaingreso',
                'ing.gestion',
                'ing.estadoingreso',
                'ing.numsolicitud',
                'ing.numcompra',
                'p.nombreproveedor',
                'ar.nombrearea',
                'cat.codcatprogramatica'
            )
            ->orderBy('ing.idcomingreso', 'asc')
            ->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('almacenes.comingreso.index', ['idd' => $personalArea, 'ingresos' => $ingresos]);
    }
    public function create()
    {

        $date = Carbon::now();
        $catprogramaticas = DB::table('catprogramaticacomb')
            ->where('estadon', 1)
            ->where('idcatprogramaticacomb', '!=', 1)
            ->select(DB::raw("concat(' Codigo: ',codcatprogramatica,' ','// Nombre: ',nombrecatprogramatica)
        as comineee"), 'idcatprogramaticacomb')
            ->pluck('comineee', 'idcatprogramaticacomb');

        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->orderBy('e.idenc', 'asc')
            ->select(DB::raw("concat(' Codigo: ',e.idenc,' //Nombres: ',e.abrev,' ',nombres,' ',ap_pat,' ',ap_mat,' ',' //Area: ',a.nombrearea,' ',' //Cargo: ',e.cargo)
            as comineeeuno"), 'idenc')
            ->pluck('comineeeuno', 'idenc');

        $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->orderBy('e.idenc', 'asc')
            ->select(DB::raw("concat(' Codigo: ',e.idenc,' //Nombres: ',e.abrev,' ',nombres,' ',ap_pat,' ',ap_mat,' ',' //Area: ',a.nombrearea,' ',' //Cargo: ',e.cargo)
            as comineeedos"), 'idenc')
            ->pluck('comineeedos', 'idenc');

        $proveedores = DB::table('proveedor')
            ->where('estadoproveedor', 1)
            ->where('idproveedor', '!=', 1)
            ->select(DB::raw("concat(' Codigo: ',idproveedor,' ',' //Nombre: ',nombreproveedor,' ',' //Representante: ',representanteproveedor,' ',' //Dirección: ',direccionproveedor,' ',' //Telefono: ',telefonoproveedor)
            as comineeetres"), 'idproveedor')
            ->pluck('comineeetres', 'idproveedor');

        $areas = DB::table('areas')
            ->where('estadoarea', 1)
            ->select(DB::raw("concat(' Codigo: ',idarea,' ',' //Nombre: ',nombrearea)
            as cominecuatro"), 'idarea')
            ->pluck('cominecuatro', 'idarea');


        return view('almacenes.comingreso.create',
            compact('date', 'catprogramaticas', 'encargado', 'encargadodos', 'proveedores', 'areas')
        );
    }

    public function store(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $id3 = $personal->idprogramacomb;
        $id5 = $personal->idemp;

        $idar = $request->get('idarea');
        $idcomp = $request->get('numcompra');
        $Areanm = AreasModel::find($idar);
        $NmBr = $Areanm->nombrearea;
        $oFICI = "OFICINA DE";
        $NomFci = $oFICI . " " .  $NmBr;

        $comingreso = new ComingresoModel();
        $comingreso->objeto = $request->input('objeto');
        $comingreso->numcompra = $request->get('numcompra');
        $comingreso->numsolicitud = $request->input('numsolicitud');
        $comingreso->detallecomingreso = $request->input('detalle');
        $comingreso->numpreventivo = $request->input('numpreventivo');
        $comingreso->numfactura = $request->input('factura');

        $comingreso->iddirigidoa = $request->input('iddirigidoa');
        $comingreso->idviaa = $request->input('idvia');
        $comingreso->iddepartede = $id5;

        $comingreso->idproveedor = $request->input('idproveedor');
        $comingreso->idcatprogramaticacomb = $request->input('idcategoria');


        $comingreso->idarea = $request->get('idarea');
        $comingreso->idprogramacomb = $id3;

        $comingreso->idtipocomin = 1;  //id1 balance inicial id2 ingreso id3 egreso  id4 balance final

        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $hora = $fechasolACT->toTimeString();

        $comingreso->fechaingreso = $fechasolACT;
        $comingreso->horaingreso = $hora;
        $comingreso->gestion = $gesti;
        //modificar fecha de solicitud
        $comingreso->fechasolicitud = $fechasolACT;
        $comingreso->horasolicitud = $hora;
        $comingreso->gestionsolicitud = $gesti;

        $comingreso->estadoingreso = 1;
        $comingreso->estado1 = 1;
        $comingreso->estado2 = 1;

        $comingreso->oficinade = $NomFci;
        $comingreso->tipo = "PRODUCTO";

        $comingreso->idcompracomb = $idcomp;
        if ($comingreso->save()) {

            $Idprod = $comingreso->idcatprogramaticacomb;
          
            $comprasss = CatProgModel::find($Idprod);
            $comprasss->estadon = 2;
            $comprasss->save();
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }
        return redirect()->route('comingreso.index');
    }

    public function editar($idcomingreso)
    {

        $comingresos = ComingresoModel::find($idcomingreso);
        $idco = $comingresos->idcomingreso;
        $id5 = $comingresos->idarea;
        $id8 = $comingresos->idproveedor;

        $id2 = $comingresos->iddirigidoa;
        $id3 = $comingresos->idviaa;
        $id4 = $comingresos->iddepartede;
        $id6 = $comingresos->idprogramacomb;
        $id7 = $comingresos->idcatprogramaticacomb;

        $Fechaa = $comingresos->fechaingreso;
        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);
        $Horaa = $comingresos->horaingreso;
        $Fechayhora = $fechag . "-" .  $fecham . "-" .  $fechad . " " .  $Horaa;

        $areas = DB::table('areas')
            ->where('idarea', $id5)
            ->get();

        $catprogramaticas = DB::table('catprogramaticacomb')
            ->where('idcatprogramaticacomb', $id7)
            ->get();
        $proveedores = DB::table('proveedor')
            ->where('idproveedor', '!=', 1)
            ->where('idproveedor', $id8)
            ->get();
        $programas = DB::table('programacomb')
            ->where('idprogramacomb', $id6)
            ->get();

        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $id3)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'e.cargo', 'a.nombrearea')
            ->get();

        $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $id2)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'e.cargo', 'a.nombrearea')
            ->get();

        $departede = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
            ->where('e.idemp', $id4)
            ->select('e.nombres', 'e.ap_pat', 'e.ap_mat', 'fi.cargo', 'fi.nombrecargo', 'a.nombrearea', 'e.idemp')
            ->get();

        return view(
            'almacenes.comingreso.editar',
            compact('encargado', 'encargadodos', 'departede', 'idco', 'comingresos', 'proveedores', 'areas', 'catprogramaticas', 'Fechayhora', 'programas')
        );
    }
    public function editarn($idcomingreso)
    {

        $comingresos = ComingresoModel::find($idcomingreso);
        $idco = $comingresos->idcomingreso;
        $id4 = $comingresos->fechaingreso;
        $id5 = $comingresos->idcatprogramaticacomb;
        $id6 = $comingresos->idcatprogramaticacomb;
        $Fechaa = $comingresos->fechaingreso;
        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);
        $Horaa = $comingresos->horaingreso;
        $Fechayhora = $fechag . "-" .  $fecham . "-" .  $fechad . " " .  $Horaa;

        $areas = DB::table('areas')
            ->where('estadoarea', 1)
            ->get();

        $catprogramaticas = DB::table('catprogramaticacomb')
        ->select(
            'idcatprogramaticacomb',
            'estadon',
            'codcatprogramatica',
            'nombrecatprogramatica'
        )
        ->where('idcatprogramaticacomb', '!=', 1)
        ->where(function ($query) use ($id5) {
            $query->where('estadon', '=', 1)
                ->orWhere(function ($subquery) use ($id5) {
                    $subquery->where('idcatprogramaticacomb', '=', $id5)
                        ->where('estadon', '!=', 1);
                });
        })
        ->get();

        $proveedores = DB::table('proveedor')
            ->where('idproveedor', '!=', 1)
            ->where('estadoproveedor', 1)
            ->get();
        $programas = DB::table('programacomb')
            ->where('estadoprograma', 1)
            ->get();

        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('emp.estadoemp1', 1)
            ->orderBy('e.idenc', 'asc')
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'e.cargo', 'a.nombrearea')
            ->get();

        $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('emp.estadoemp1', 1)
            ->orderBy('e.idenc', 'asc')
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'e.cargo', 'a.nombrearea')
            ->get();

        $departede = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('file as fi', 'fi.idfile', '=', 'e.idfile')
            ->where('e.estadoemp1', 1)
            ->orderBy('e.idemp', 'asc')
            ->select('e.nombres', 'e.ap_pat', 'e.ap_mat', 'fi.cargo', 'fi.nombrecargo', 'a.nombrearea', 'e.idemp')
            ->get();

        return view('almacenes.comingreso.editarn',
            compact('id4','id6', 'encargado', 'encargadodos', 'departede', 'idco', 'comingresos', 'proveedores', 'areas', 'catprogramaticas', 'Fechayhora', 'programas')
        );
    }
    public function updaten(Request $request)
    {

        $id6fech = $request->input('id4');
        $idcatprog = $request->input('id6');
        $gestionant = substr($id6fech, 0, 4);
        $mesant = substr($id6fech, 5, 2);
        $diaant = substr($id6fech, 8, 2);
        $Fechaanter = $diaant . "-" . $mesant . "-" . $gestionant;

        $fechasol = $request->get('fechaingreso');
        $gestion = substr($fechasol, 6, 4);
        $mes = substr($fechasol, 3, 2);
        $dia = substr($fechasol, 0, 2);
        $Fechaactual = $dia . "-" . $mes . "-" . $gestion;

        $idar = $request->get('idarea');
        $idcomp = $request->get('numcompra');
        $Areanm = AreasModel::find($idar);
        $NmBr = $Areanm->nombrearea;
        $oFICI = "OFICINA DE";
        $NomFci = $oFICI . " " .  $NmBr;

        $comingreso = ComingresoModel::find($request->idcomingreso);

        $comingreso->objeto = $request->input('objeto');
        $comingreso->numcompra = $request->input('numcompra');
        $comingreso->numsolicitud = $request->input('numsolicitud');
        $comingreso->detallecomingreso = $request->input('detalle');
        $comingreso->numpreventivo = $request->input('numpreventivo');
        $comingreso->numfactura = $request->input('factura');

        $comingreso->iddirigidoa = $request->input('iddirigidoa');
        $comingreso->idviaa = $request->input('idviaa');
        $comingreso->iddepartede = $request->input('iddepartede');

        $comingreso->idproveedor = $request->input('idproveedor');
        $comingreso->idcatprogramaticacomb = $request->input('idcategoria');
        $comingreso->idarea = $request->get('idarea');
        $comingreso->idprogramacomb = $request->input('idprograma');

        $fechasolACTe = Carbon::now();
        $hora = $fechasolACTe->toTimeString();
        if ($Fechaanter == $Fechaactual) {
            $comingreso->fechaingreso = $request->get('fechaingreso');
        } else {
            $comingreso->fechaingreso = $request->get('fechaingreso');
            $comingreso->horaingreso = $hora;
            $comingreso->gestion = $gestion;
        }

        $comingreso->oficinade = $NomFci;
        $comingreso->idcompracomb = $idcomp;
        if ($comingreso->save()) {

            
            $Idprod = $comingreso->idcatprogramaticacomb;
            if ($idcatprog == $Idprod) {
               
            } else {
                $comprasss = CatProgModel::find($Idprod);
                $comprasss->estadon = 2;
                $comprasss->save();

                $comprasssd = CatProgModel::find($idcatprog);
                $comprasssd->estadon = 1;
                $comprasssd->save();  
            }


            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('comingreso.index');
    }


    public function update(Request $request)
    {


        $comingreso = ComingresoModel::find($request->idcomingreso);
        $comingreso->numcompra = $request->input('numcompra');
        $comingreso->numsolicitud = $request->input('numsolicitud');
        $comingreso->numpreventivo = $request->input('numpreventivo');
        $comingreso->numfactura = $request->input('factura');
        $comingreso->detallecomingreso = $request->input('detalle');


        $comingreso->idarea = $request->input('area');
        $comingreso->idcatprogramaticacomb = $request->input('idcategoria');
        $comingreso->idproveedor = $request->input('proveedor');
        $comingreso->idprogramacomb = $request->input('idprograma');

        if ($comingreso->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('comingreso.index');
    }

  //TODO: Detalle index estado 1
    public function editardoc($idcomingreso)
    {

        // crea un nuevo modelo y selecciona las relaciones y tablas
        // $docuconsumo = DB::table('docuconsumo as d')
        $detallecomingresos = DB::table('detallecomingreso as n')

            ->join('comingreso as ing', 'ing.idcomingreso', '=', 'n.idcomingreso')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'n.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')

            ->select(
                'n.iddetallecomingreso',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'u.nombremedida',
                'n.cantidadsalida',
                'n.precio',
                'n.subtotalsalida',
                'n.difcantidad',
                'n.subtdifcantidad'
            )
            // ya le da el id de unidadconsumo a docunidadconsumo con el where
            ->where('ing.idcomingreso', '=', $idcomingreso)->get();
        $valor_total = $detallecomingresos->sum('subtotalsalida');
        $valor_total2 = $detallecomingresos->sum('subtdifcantidad');
        $CalAdosDecim = number_format($valor_total, 2, '.', '');
        $CalAdosDecimdos = number_format($valor_total2, 2, '.', '');

        $valor_total3 = $detallecomingresos->sum('cantidadsalida');
        $valor_total4 = $detallecomingresos->sum('difcantidad');
        $CalAdosDecimuno = number_format($valor_total3, 2, '.', '');
        $CalAdosDecitres = number_format($valor_total4, 2, '.', '');

        $productos = DB::table('prodcomb')
            ->where('estadoprodcomb', 1)
            ->select(DB::raw("concat(' ID: ',idprodcomb,' //COD: ',detalleprodcomb,' //NOMBRE: ',nombreprodcomb,' 
                        //PRECIO BS. ',precioprodcomb) as prodservicio"), 'idprodcomb')
            ->orderBy('idprodcomb', 'asc')
            ->pluck('prodservicio', 'idprodcomb');

        $compras = DB::table('comingreso as c')

            ->where('c.idcomingreso', $idcomingreso)
            ->select(
                'c.idcomingreso',
                'c.estadoingreso',
                'c.estado1'
            )
            ->first();


        //  retorna la vista o el index
        return view('almacenes.comingreso.docuconsumo',
            //  manda la variable docuconsumo que es el nuevo modelo y el id de unidadconsumo
            [
                "detallecomingresos" => $detallecomingresos,
                "CalAdosDecim" => $CalAdosDecim,
                "CalAdosDecimdos" => $CalAdosDecimdos,
                "CalAdosDecimuno" => $CalAdosDecimuno,
                "CalAdosDecitres" => $CalAdosDecitres,
                "productos" => $productos,
                "compras" => $compras,
                "idcomingreso" => $idcomingreso
            ]
        );
    }


    //TODO: 1 Detalle index estado 2
    public function editardocn($idcomingreso)
    {

        // crea un nuevo modelo y selecciona las relaciones y tablas
        // $docuconsumo = DB::table('docuconsumo as d')
        $detallecomingresos = DB::table('detallecomingreso as n')

            ->join('comingreso as ing', 'ing.idcomingreso', '=', 'n.idcomingreso')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'n.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')

            ->select(
                'n.iddetallecomingreso',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'u.nombremedida',
                'n.cantidadsalida',
                'n.precio',
                'n.subtotalsalida',
                'n.difcantidad',
                'n.subtdifcantidad'
            )
            // ya le da el id de unidadconsumo a docunidadconsumo con el where
            ->where('ing.idcomingreso', '=', $idcomingreso)->get();
        $valor_total = $detallecomingresos->sum('subtotalsalida');
        $valor_total2 = $detallecomingresos->sum('subtdifcantidad');
        $CalAdosDecim = number_format($valor_total, 2, '.', '');
        $CalAdosDecimdos = number_format($valor_total2, 2, '.', '');

        $valor_total3 = $detallecomingresos->sum('cantidadsalida');
        $valor_total4 = $detallecomingresos->sum('difcantidad');
        $CalAdosDecimuno = number_format($valor_total3, 2, '.', '');
        $CalAdosDecitres = number_format($valor_total4, 2, '.', '');

        $productos = DB::table('prodcomb')
            ->where('estadoprodcomb', 1)
            ->select(DB::raw("concat(' ID: ',idprodcomb,' //COD: ',detalleprodcomb,' //NOMBRE: ',nombreprodcomb,' 
                        //PRECIO BS. ',precioprodcomb) as prodservicio"), 'idprodcomb')
            ->orderBy('idprodcomb', 'asc')
            ->pluck('prodservicio', 'idprodcomb');

        $compras = DB::table('comingreso as c')

            ->where('c.idcomingreso', $idcomingreso)
            ->select(
                'c.idcomingreso',
                'c.estadoingreso',
                'c.estado1'
            )
            ->first();

 
        //  retorna la vista o el index
        return view('almacenes.comingreso.docuconsumon',
            //  manda la variable docuconsumo que es el nuevo modelo y el id de unidadconsumo
            [
                "detallecomingresos" => $detallecomingresos,
                "CalAdosDecim" => $CalAdosDecim,
                "CalAdosDecimdos" => $CalAdosDecimdos,
                "CalAdosDecimuno" => $CalAdosDecimuno,
                "CalAdosDecitres" => $CalAdosDecitres,
                "productos" => $productos,
                "compras" => $compras,
                "idcomingreso" => $idcomingreso
            ]
        );
    }


    //  createdoc es el boton para crear un nuevo documento
    public function createdoc($idcomingreso)
    {
        return view('almacenes.comingreso.createdocuconsumo',
            ["idcomingreso" => $idcomingreso]
        );
    }

    public function insertar(Request $request)
    {
        $idcomingreso = $request->input('idcomingreso');
        $prod = $request->get('producto');
        $producto = ProdCombModel::find($prod);
        //del id del producto crea una variable precio para sacar el precio del producto
        $precio = $producto->precioprodcomb;

        //requiere la cantidad para detalle compra
        $cantidad = $request->get('cantidad');
        $cantidaddos = number_format($cantidad, 10, '.', '');
        $SubTotalsol = $cantidad * $precio;
        $SubTotalsolresu = number_format($SubTotalsol, 10, '.', '');

        $detalleingreso = new DetalleComingresoModel;
        $detalleingreso->cantidad = $cantidaddos;
        $detalleingreso->subtotal = $SubTotalsolresu;
        $detalleingreso->precio = $precio;

        $detalleingreso->cantidadsalida = $cantidaddos;
        $detalleingreso->subtotalsalida = $SubTotalsolresu;

        $detalleingreso->cantidadentrada = 0;
        $detalleingreso->subtotalentrada = 0;

        $detalleingreso->difcantidad = $cantidaddos;
        $detalleingreso->subtdifcantidad = $SubTotalsolresu;


        $detalleingreso->cantidadingreso = 0;
        $detalleingreso->subtotalcantidadingreso = 0;

        $detalleingreso->difcantidadingreso = $cantidaddos;
        $detalleingreso->subdifcantidadingreso = $SubTotalsolresu;

        $detalleingreso->idproducto = $prod;
        $detalleingreso->idcomingreso = $idcomingreso;

        $detalleingreso->estado1 = 1;
        $detalleingreso->estado2 = 1;
        $detallito = DB::table('detallecomingreso as d')

            ->join('prodcomb as ps', 'ps.idprodcomb', 'd.idproducto')
            ->join('comingreso as c', 'c.idcomingreso', 'd.idcomingreso')

            ->select(
                'd.iddetallecomingreso',
                'c.idcomingreso',
                'ps.nombreprodcomb',
                'd.cantidad',
                'd.subtotal',
                'd.precio'
            )
            ->orwhere('d.idproducto', $prod)
            ->where('d.idcomingreso', $idcomingreso)->get();

        if ($detallito->isEmpty()) {
            $detalleingreso->save();

            $Idprod = $detalleingreso->idproducto;
            $idcomingresod = $detalleingreso->idcomingreso;
            $cant = $detalleingreso->cantidad;
            $subto = $detalleingreso->subtotal;

            $comprasssd = ProdCombModel::find($Idprod);
            $CanTidaddd = $comprasssd->cantidadproducto;
            $Stotalproducto = $comprasssd->subtotalproducto;

            $CanTidadddef = $CanTidaddd + $cant;
            $Stotalproductodosf = $Stotalproducto + $subto;

            $CanTidaddde = number_format($CanTidadddef, 10, '.', '');
            $Stotalproductodos = number_format($Stotalproductodosf, 10, '.', '');

            $comprasss = ProdCombModel::find($Idprod);
            $comprasss->cantidadproducto = $CanTidaddde;
            $comprasss->subtotalproducto = $Stotalproductodos;
            $comprasss->save();

            $comingress = ComingresoModel::find($idcomingresod);
            $comingress->estado1 = 2;
            $comingress->save();

            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('comingreso.editardoc', [$idcomingreso]);
    }

    // return redirect()->action('ingreso.editardoc',[$idingreso]);


    public function editararchivo($iddetallecomingreso)
    {
        $docproveedor = DetalleComingresoModel::find($iddetallecomingreso);
        $prodcomb = $docproveedor->idproducto;

        $id3 = $docproveedor->idproducto;
        $id4 = $docproveedor->idcomingreso;

        $id5 = $docproveedor->cantidadsalida;
        $id6 = $docproveedor->subtotalsalida;
        $productos = DB::table('prodcomb')
            ->where('idprodcomb', $prodcomb)
            ->get();

        return view('almacenes.comingreso.editarnota',[
                "docproveedor" => $docproveedor,
                "id3" => $id3,
                "id4" => $id4,
                "id5" => $id5,
                "id6" => $id6,
                "productos" => $productos
            ]
        );
    }
    public function updatearchivonota(Request $request, $iddetallecomingreso)
    {
        $id3prod = $request->input('id3');
        $id4comi = $request->input('id4');

        $id5csal = $request->input('id5');
        $id6subcsal = $request->input('id6');
        $idcomingreso = $id4comi;
        $cantidad = $request->get('cantidad');
        $cantidaddos = number_format($cantidad, 10, '.', '');
        $productos = DetalleComingresoModel::find($iddetallecomingreso);

        $Cantidaddif = $productos->cantidad;
        $sudtotaldif = $productos->subtotal;

        $Cantidadsalid = $productos->cantidadsalida;
        $sudtotalsalid = $productos->subtotalsalida;

        $Cantidadentrada = $productos->cantidadentrada;
        $sudtotalentrada = $productos->subtotalentrada;

        $Cantidadingreso = $productos->cantidadingreso;
        $sudtotalingreso = $productos->subtotalcantidadingreso;

        $det = $productos->precio;

        $varcuno = $Cantidaddif - $id5csal;
        $varstuno = $sudtotaldif - $id6subcsal;
        $varruno = number_format($varcuno, 10, '.', '');
        $varstruno = number_format($varstuno, 10, '.', '');

        $cantentraresta = $Cantidadsalid - $id5csal;
        $subtotalentraresta = $sudtotalsalid - $id6subcsal;
        $ctre1 = number_format($cantentraresta, 10, '.', '');
        $sbtre1 = number_format($subtotalentraresta, 10, '.', '');

        $subtotal1 = $det * $cantidaddos;
        $subtotal = number_format($subtotal1, 10, '.', '');

        $varcdos = $varruno + $cantidaddos;
        $varstdos = $varstruno + $subtotal;
        $varrdos = number_format($varcdos, 10, '.', '');      //nuevo cantidad inicial
        $varstrdos = number_format($varstdos, 10, '.', '');  //nuevo cantidad inicial


        $varctres = $ctre1 + $cantidaddos;
        $varsttres = $sbtre1 + $subtotal;
        $varrtres = number_format($varctres, 10, '.', '');      //nuevo cantidad salida
        $varstrtres = number_format($varsttres, 10, '.', '');  //nuevo cantidad salida

        $varccuatro = $varrdos - $Cantidadentrada;
        $varstcuatro = $varstrdos - $sudtotalentrada;
        $varrcuatro = number_format($varccuatro, 10, '.', '');      //nuevo difcantidad
        $varstrcuatro = number_format($varstcuatro, 10, '.', '');  //nuevo subtdifcantidad

        $varccincou = $varrtres + $Cantidadingreso;
        $varccinco = $varccincou - $Cantidadentrada;

        $varstcincou = $varstrtres + $sudtotalingreso;
        $varstcinco = $varstcincou - $sudtotalentrada;
        $varrcinco = number_format($varccinco, 10, '.', '');      //nuevo difcantidadingreso
        $varstrcinco = number_format($varstcinco, 10, '.', '');  //nuevo subdifcantidadingreso

        $docproveedor = DetalleComingresoModel::find($iddetallecomingreso);

        $docproveedor->cantidad = $varrdos;
        $docproveedor->subtotal  = $varstrdos;

        $docproveedor->cantidadsalida = $varrtres;
        $docproveedor->subtotalsalida  = $varstrtres;

        $docproveedor->difcantidad = $varrcuatro;
        $docproveedor->subtdifcantidad  = $varstrcuatro;

        $docproveedor->difcantidadingreso = $varrcinco;
        $docproveedor->subdifcantidadingreso  = $varstrcinco;

        $docproveedor->idproducto = $id3prod;
        $docproveedor->idcomingreso  = $id4comi;

        if ($docproveedor->save()) {
         
            $Idprod = $docproveedor->idproducto;
           
            $cant = $docproveedor->cantidadsalida;
            $subto = $docproveedor->subtotalsalida;


        $productosprod = ProdCombModel::find($Idprod);
        $varuno = $productosprod->cantidadproducto;
        $vardos = $productosprod->subtotalproducto;

        $vartres = $varuno - $id5csal;
        $varcuatro = $vardos - $id6subcsal;

        $varcincod = $vartres + $cant;
        $varseisf = $varcuatro + $subto;

        $varcinco = number_format($varcincod, 10, '.', '');
        $varseis = number_format($varseisf, 10, '.', '');

        $productosprode = ProdCombModel::find($Idprod);
        $productosprode->cantidadproducto = $varcinco;
        $productosprode->subtotalproducto = $varseis;
        $productosprode->save();


        $request->session()->flash('message', 'Registro Guardado');
     } else {
        $request->session()->flash('message', 'El Item Ya existe en la Planilla');
    } 

    return redirect()->route('comingreso.editardoc', [$idcomingreso]);
}
   
      //TODO: 2 
      //TODO: Detalle index estado 2 BOTON REPORTE vista REPORTE INDEX

    public function editararchivon($iddetallecomingreso)
    {
        $docproveedor = DetalleComingresoModel::find($iddetallecomingreso);
        $prodcomb = $docproveedor->idproducto;
        $idcomingr = $docproveedor->idcomingreso;

        $id2 = $docproveedor->idcomingreso;
        $id3 = $docproveedor->fechaini;
        $id4 = $docproveedor->fechafin;
        $id5 = $docproveedor->iddetallecomingreso;
        $id6 = $docproveedor->iddetallecomingreso;
        $productos = DB::table('prodcomb')
            ->where('idprodcomb', $prodcomb)
            ->get(); 

        $comingres = DB::table('comingreso as comin')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
            ->select('comin.estadoingreso', 'comin.idcomingreso', 'cat.codcatprogramatica', 'cat.nombrecatprogramatica')
            ->orderBy('comin.idcomingreso', 'asc')
            ->where('comin.idcomingreso', $idcomingr)
            ->get();

        $detalle = DB::table('detallecomegreso as d')
            ->join('detallecomingreso as det', 'det.iddetallecomingreso', '=', 'd.iddetallecomingreso') 
            ->join('comegreso as eg', 'eg.idcomegreso', '=', 'd.idcomegreso') 

             ->join('comingreso as ing', 'ing.idcomingreso', '=', 'eg.idcomingreso') 
             ->join('prodcomb as prod', 'prod.idprodcomb', '=', 'det.idproducto') 
             ->join('areas as ar', 'ar.idarea', '=', 'eg.idarea') 

             ->join('empleados as emp', 'emp.idemp', '=', 'eg.idusuario') 

             ->select('eg.fechaegreso','eg.idvale','ar.nombrearea','d.cantidadegreso','d.subtotalegreso',
             'det.cantidadsalida','det.subtotalsalida','det.precio','emp.nombres','eg.idcomegreso') 
             ->where('eg.idcomingreso', '=', $idcomingr)
             ->where('det.idproducto', '=', $prodcomb)
             ->whereBetween('eg.fechaegreso',[$id3, $id4])
             ->orderBy('eg.fechaegreso', 'asc')
             ->get();

             $ingresos = DB::table('detallecomingreso as ing')
             ->select(
                 'ing.cantidad',
                 'ing.subtotal'
             )
             ->where('ing.iddetallecomingreso', '=', $id5)->first();

        return view('almacenes.comingreso.editarnotan',[
                "docproveedor" => $docproveedor,
                "comingres" => $comingres,
                "id2" => $id2,
                "id3" => $id3,
                "id4" => $id4,
                "id6" => $id6,
                "detalle" => $detalle,
                "ingresos" => $ingresos,
                "productos" => $productos
            ]
        );
    }

     //TODO: 3 
      //TODO: Detalle index estado 2 BOTON GUARDAR Upadate  reporte index

    public function updatearchivonotan(Request $request, $iddetallecomingreso)
    {
        $id2comingre = $request->input('id2');
        $id3fechaini = $request->input('id3');
        $id4fechafin = $request->input('id4');
        $idcomingreso = $id2comingre;

        $cantidad = $request->get('cantidad');
        $cantidaddos = number_format($cantidad, 10, '.', '');

        $fechasol = $request->get('fechainicio');      
        $gestion = substr($fechasol, 6, 4);
        $mes = substr($fechasol, 3, 2);
        $dia = substr($fechasol, 0, 2);
        $Fechaactual= $dia."-".$mes."-".$gestion;

        $docproveedor = DetalleComingresoModel::find($iddetallecomingreso);

        $docproveedor->fechaini  =  $request->get('fechainicio');
        $docproveedor->fechafin  =  $request->get('fechafin');

        $fechauno = Carbon::parse($Fechaactual);
        $fechados = $fechauno->subDay();
        $fechatres = $fechados->format('Y-m-d');
   
        $docproveedor->fechainidos = $fechatres;
        $docproveedor->save();

        return redirect()->route('comingreso.editararchivon', [$iddetallecomingreso]);
    }
    public function almacendos($idcomingreso)
    {


        $detalle = ComingresoModel::find($idcomingreso);
        $detalle->estadoingreso = 2;
        $detalle->save();
        return redirect()->route('comingreso.editardocn', [$idcomingreso]);
    }
    public function grafico()
    {

        $ingresos = DB::table('ingreso as ing')


            ->where('ing.estadocompracomb', 2)
            ->get();

        return view('almacenes/ingreso/grafico', compact('ingresos'));
    }
    public function detalle($idingreso)
    {

        $id = $idingreso;
        $ingresos = DB::table('ingreso as ing')
            ->select(
                'ing.cantidad',
                'ing.subtotal',

                'ing.cantidadsalida',
                'ing.subtotalsalida',

                'ing.codigocatprogramai',
                'ing.nombrecatprogmai'
            )
            ->where('ing.idingreso', '=', $id)->first();

        $ingreso = IngresoModel::find($id);
        $Subtotalsalida = $ingreso->subtotalsalida;
        $SPrecio = $ingreso->precio;


        $detalle = DB::table('detallevale as d')

            ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso')
            ->join('vale as v', 'v.idvale', '=', 'd.idvale')

            ->join('areas as a', 'a.idarea', '=', 'v.idarea')

            ->select(
                'd.idvale',
                'd.cantidadsol',
                'd.preciosol',
                'd.subtotalsol',
                'd.cantidadresta',

                'v.usuarionombre',
                'v.usuariocargo',
                'v.estadovale',
                'v.fechaaprob',

                'a.nombrearea',

                'ing.precio',
                'ing.subtotalsalida'
            )

            ->where('d.idingreso', '=', $id)->get();

        $valor_total = $detalle->sum('cantidadsol');
        $valor_total2 = $valor_total * $SPrecio;

        //modificacion para la parte decimal
        $parte_entera = floor($Subtotalsalida);
        $parte_decimal = ($Subtotalsalida - $parte_entera) * 100;

        $parte_entera_en_letras = NumerosEnLetras::convertir($parte_entera, 'Bolivianos', false);
        $parte_decimal_en_letras = NumerosEnLetras::convertir($parte_decimal, 'Centavos', false);

        $valor_total5 = $parte_entera_en_letras . ' con ' . $parte_decimal_en_letras;


        $parte_entera_formateada = number_format($Subtotalsalida, 0, '', '.');

        $parte_decimaldos = floor($parte_decimal);
        $valor_total6 = $parte_entera_formateada . ',' . $parte_decimaldos;



        $valor_total3 = NumerosEnLetras::convertir($valor_total2, 'Bolivianos', true);


        return view(
            'almacenes/ingreso/detalle',
            [
                'valor_total' => $valor_total,
                'valor_total2' => $valor_total2,
                'valor_total3' => $valor_total3,
                'valor_total5' => $valor_total5,
                'valor_total6' => $valor_total6,

                'parte_entera' => $parte_entera,
                'parte_decimal' => $parte_decimal,
                'Subtotalsalida' => $Subtotalsalida,
                'parte_entera_formateada' => $parte_entera_formateada,

                'ingresos' => $ingresos,
                'detalle' => $detalle,

                'idingreso' => $id
            ]
        );
    }

    public function solicitud($id6)
    {
        $id = $id6;
        $docproveedor = DetalleComingresoModel::find($id);
        $id1 = $docproveedor->idproducto;
        $id2 = $docproveedor->idcomingreso;
        $id3 = $docproveedor->fechaini;
        $id33 = $docproveedor->fechainidos;
        $id4 = $docproveedor->fechafin;
        $id5 = $docproveedor->iddetallecomingreso;

        $id7 = $docproveedor->cantidadsalida;
        $id8 = $docproveedor->subtotalsalida;
        $id9 = $docproveedor->precio;

        $id10 = $docproveedor->difcantidad;
        $id11 = $docproveedor->subtdifcantidad;
       
        $vardiff1 = number_format($id7, 2, '.', '');
        $vardiff2 = number_format($id8, 2, '.', '');

        $vardif1 = number_format($id10, 2, '.', '');
        $vardif2 = number_format($id11, 2, '.', '');


        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');


       

             $comingres = DB::table('comingreso as comin')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
            ->select('comin.estadoingreso', 'comin.idcomingreso', 'cat.codcatprogramatica', 'cat.nombrecatprogramatica')
            ->where('comin.idcomingreso', '=', $id2)
            ->first();

           
            $comingresd = ComingresoModel::find($id2);
            $var1 = $comingresd->fechaingreso;
            $varti1 = $comingresd->idtipocomin;

    
            $tipocom = TipocomingresoModel::find($varti1);
          
            $varti2 = $tipocom->codcoming;
           

        
                
        $detalle = DB::table('detallecomegreso as d')
        ->join('detallecomingreso as det', 'det.iddetallecomingreso', '=', 'd.iddetallecomingreso') 
        ->join('comegreso as eg', 'eg.idcomegreso', '=', 'd.idcomegreso') 

         ->join('comingreso as ing', 'ing.idcomingreso', '=', 'eg.idcomingreso') 
         ->join('prodcomb as prod', 'prod.idprodcomb', '=', 'det.idproducto') 
         ->join('areas as ar', 'ar.idarea', '=', 'eg.idarea') 

         ->join('empleados as emp', 'emp.idemp', '=', 'eg.idusuario') 
         ->join('tipocomingreso as tip', 'tip.idtipocomin', '=', 'eg.idtipocomin') 

         ->select('tip.codcoming','eg.fechaegreso','eg.idvale','ar.nombrearea','d.cantidadegreso','d.subtotalegreso',
         'det.cantidadsalida','det.subtotalsalida','det.precio','emp.nombres','emp.ap_pat','emp.ap_mat','eg.idcomegreso','eg.numvale') 
         ->where('eg.idcomingreso', '=', $id2)
         ->where('det.idproducto', '=', $id1)
         ->whereBetween('eg.fechaegreso',[$id3, $id4])
         ->orderBy('eg.fechaegreso', 'asc')
         ->get();



            $avar1 = $detalle->sum('cantidadegreso');
            $avar2 = $detalle->sum('subtotalegreso');
            $avardet1 = number_format($avar1, 2, '.', '');
            $avardet2 = number_format($avar2, 2, '.', '');

    
            $detalledos = DB::table('detallecomegreso as d')
            ->join('detallecomingreso as det', 'det.iddetallecomingreso', '=', 'd.iddetallecomingreso') 
            ->join('comegreso as eg', 'eg.idcomegreso', '=', 'd.idcomegreso') 
    
             ->join('comingreso as ing', 'ing.idcomingreso', '=', 'eg.idcomingreso') 
             ->join('prodcomb as prod', 'prod.idprodcomb', '=', 'det.idproducto') 
             ->join('areas as ar', 'ar.idarea', '=', 'eg.idarea') 
    
             ->join('empleados as emp', 'emp.idemp', '=', 'eg.idusuario') 
             ->join('tipocomingreso as tip', 'tip.idtipocomin', '=', 'eg.idtipocomin') 
    
             ->select('tip.codcoming','eg.fechaegreso','eg.idvale','ar.nombrearea','d.cantidadegreso','d.subtotalegreso',
             'det.cantidadsalida','det.subtotalsalida','det.precio','emp.nombres','emp.ap_pat','emp.ap_mat','eg.idcomegreso','eg.numvale') 
             ->where('eg.idcomingreso', '=', $id2)
             ->where('det.idproducto', '=', $id1)
             ->whereBetween('eg.fechaegreso',[$var1, $id33])
             ->orderBy('eg.fechaegreso', 'asc')
             ->get();


            return view('almacenes.comingreso.pdf-solicitud', [
                'comingres' => $comingres,
                'var1' => $var1,
                'id9' => $id9,
                'vardiff1' => $vardiff1,
                'vardiff2' => $vardiff2,

                'avardet1' => $avardet1,
                'avardet2' => $avardet2,
 
                'vardif1' => $vardif1,
                'vardif2' => $vardif2,
                'varti2' => $varti2,
                'detalledos' => $detalledos,
                'detalle' => $detalle
            ]);
        } catch (Exception $ex) {
            \Log::error("Orden Error: {$ex->getMessage()}");
            return redirect()->route('comingreso.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }


    public function reporte()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $detalle = Temporal6Model::find($id);
        $id2 = $detalle->idingreso;
        $id3 = $detalle->idarea;
        $ingresos = DB::table('ingreso')
            ->where('estadocompracomb', 2)
            ->select(DB::raw("concat(nombreproducto,
       
                           ' // PROGRA. ',nombreprograma,
                           ' // PROVEE. ',nombreproveedor,
                           ' // CAT PROG. ',nombrecatprogmai
                           ) as prodservicio"), 'idingreso')
            ->pluck('prodservicio', 'idingreso');

        $areas = DB::table('areas')
            ->where('estadoarea', 1)
            ->select(DB::raw("concat(nombrearea,
       
                           ' // IDa. ',idarea
                           ) as prodservicio"), 'idarea')
            ->pluck('prodservicio', 'idarea');


        return view(
            'almacenes.ingreso.reporte',
            [
                'ingresos' => $ingresos,
                'areas' => $areas
            ]
        );
    }

    public function store2(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal6Model::find($id);


        $prod = $request->get('ingreso');
        $almacen = IngresoModel::find($prod);
        $Idingres = $almacen->idingreso;

        $prod2 = $request->get('area');
        $almacen2 = AreasModel::find($prod2);
        $Idare = $almacen2->idarea;

        if (is_null($detalle)) {

            $detalle = new Temporal6Model;
            $detalle->idtemporal6 = $id;
            $detalle->idusuario = $id;
            $detalle->idingreso = $request->get('ingreso');
            $detalle->idarea = $request->get('area');
            $detalle->save();
        } else {
        }
        return redirect()->route('ingreso.reporte');
    }


    public function delete($idval)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);

        if (is_null($detalle)) {
            $detalle = new Temporal2Model;
            $detalle->idtemporal2 = $id;
            $detalle->idusuario = $id;
            $detalle->idvale = $idval;
            $detalle->save();
        } else {
            $detalle->idtemporal2 = $id;
            $detalle->idusuario = $id;
            $detalle->idvale = $idval;
            $detalle->update();
        }
        return redirect()->route('detalle.index2');
    }

    public function deletedos($idval)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);

        if (is_null($detalle)) {
            $detalle = new Temporal2Model;
            $detalle->idtemporal2 = $id;
            $detalle->idusuario = $id;
            $detalle->idvale = $idval;
            $detalle->save();
        } else {
            $detalle->idtemporal2 = $id;
            $detalle->idusuario = $id;
            $detalle->idvale = $idval;
            $detalle->update();
        }
        return redirect()->route('detalle.index3');
    }
}
