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
// use App\Models\Almacen\Comprobante\DetalleComingresoModel;

use App\Models\Almacen\Comprobante\ComegresoModel;
use App\Models\Almacen\Comprobante\DetallecomegresoModel;
use App\Models\Almacen\Comprobante\DetallecomingresoModel;
use App\Models\Almacen\ValeModel;
use App\Models\Almacen\DetalleValeModel;
use Carbon\Carbon;
use App\Models\Compra\ProdCombModel;

class ComegresoController extends Controller
{
    public function index(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {

            $egresos = DB::table('comegreso as ing')

                ->join('areas as ar', 'ar.idarea', '=', 'ing.idarea')
                ->join('tipocomingreso as tipo', 'tipo.idtipocomin', '=', 'ing.idtipocomin')

                ->join('comingreso as cig', 'cig.idcomingreso', '=', 'ing.idcomingreso')
                ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'cig.idcatprogramaticacomb')

                ->select([
                    'ing.idcomegreso', 'ing.estadoegreso', 'ing.fechaegreso', 'ing.numvale',
                    'tipo.nombrecoming', 'cat.codcatprogramatica',
                    'ar.nombrearea'
                ])
                ->orderBy('ing.idcomegreso', 'desc');
            $egresos = $egresos->get();
            return DataTables::of($egresos)
                ->addIndexColumn()
                ->addColumn('idcomegreso', function ($egresos) {
                    return $egresos->idcomegreso;
                })
                ->addColumn('fechaegreso', function ($egresos) {
                    return $egresos->fechaegreso;
                })
                ->addColumn('nombrecoming', function ($egresos) {
                    return $egresos->nombrecoming;
                })
                ->addColumn('numvale', function ($egresos) {
                    return $egresos->numvale;
                })
                ->addColumn('codcatprogramatica', function ($egresos) {

                    return $egresos->codcatprogramatica;
                })
                ->addColumn('nombrearea', function ($egresos) {
                    return $egresos->nombrearea;
                })

                ->addColumn(
                    'estadoegreso',
                    function ($egresos) {

                        switch ($egresos->estadoegreso) {
                            case '1':
                                return '<b style="color: green">Pendiente</b>';
                            case '2':
                                return '<b style="color: blue">Aprobada</b>';
                            case '5':
                                return '<b style="color: purple">Ingreso</b>';
                            case '6':
                                return '<b style="color: purple">Ingreso seis</b>';
                                case '7':
                                    return '<b style="color: purple">Ingreso siete</b>';
                            default:

                                break;
                        }
                    }
                )
                ->addColumn('actions', function ($egresos) {
                    // $buttonHtml = '';
                    if ($egresos->estadoegreso == 1) {
                        $buttonHtml = '<form action="' . route('comegreso.editardoc', $egresos->idcomegreso) . '" method="GET" style="display: inline">' .
                            csrf_field() .
                            method_field('GET') .
                            '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle estado uno" style="border: none;">
                                        <span class="text-primary" >
                                        <i class="fa-solid fa-2xl fa-list" ></i>
                                            </span>
                                            </button>
                                            </form>';
                    } else {
                        if ($egresos->estadoegreso == 2) {
                            $buttonHtml = '<form action="' . route('comegreso.editardetalle', $egresos->idcomegreso) . '" method="GET" style="display: inline">' .
                                csrf_field() .
                                method_field('GET') .
                                '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle estado dos" style="border: none;">
                                        <span class="text-primary" >
                                        <i class="fa-solid fa-2xl fa-list" ></i>
                                            </span>
                                            </button>
                                            </form>';
                        } else {
                            if ($egresos->estadoegreso == 5) {

                                $buttonHtml = '<form action="' . route('comegreso.editardoccinco', $egresos->idcomegreso) . '" method="GET" style="display: inline">' .
                                    csrf_field() .
                                    method_field('GET') .
                                    '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle estado cinco" style="border: none;">
                                        <span class="text-primary" >
                                        <i class="fa-solid fa-2xl fa-list" ></i>
                                            </span>
                                            </button>
                                           </form>';
                            } else {
                                if ($egresos->estadoegreso == 6) {
                                    $buttonHtml = '<form action="' . route('comegreso.editardocseis', $egresos->idcomegreso) . '" method="get" style="display: inline">' .
                                        csrf_field() .
                                        method_field('get') .
                                        '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle estado seis" style="border: none;">
                                        <span class="text-primary" >
                                        <i class="fa-solid fa-2xl fa-list" ></i>
                                            </span>
                                            </button>
                                            </form>';
                                } else {
                         
                                    if ($egresos->estadoegreso == 7) {
                                        $buttonHtml = '<form action="' . route('comegreso.editardocsiete', $egresos->idcomegreso) . '" method="GET" style="display: inline">' .
                                            csrf_field() .
                                            method_field('GET') .
                                            '<button class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle estado siete" style="border: none;">
                                            <span class="text-primary" >
                                            <i class="fa-solid fa-2xl fa-list" ></i>
                                                </span>
                                                </button>
                                                </form>';
                                    } else {

                                    
                                } }
                            }
                        }
                    }
                    return


                        '<a class="tts:left tts-slideIn tts-custom" aria-label=" Editar segun estado" href="' . route('comegreso.editar', $egresos->idcomegreso) . '">
                                <span class="text-primary" >
                                <i class="fa fa-pencil fa-fw"></i>
                            </span>
                                     </a>' . ' ' . $buttonHtml;
                })
                ->rawColumns(['actions', 'estadoegreso'])
                ->make(true);
        }
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('almacenes.comegreso.index', ['idd' => $personalArea]);
    }
    public function create()
    {
        $date = Carbon::now();


        $partidas = DB::table('partidacomb')
            ->where('estadopartida', 1)
            ->select(DB::raw("concat(' Codigo: ',codigopartida,' ',' // Nombre: ',nombrepartida)
        as cominee"), 'idpartidacomb')
            ->pluck('cominee', 'idpartidacomb');

        $comingresos = DB::table('comingreso as comin')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
            ->where('comin.idcomingreso', '!=', 0)
            ->where('comin.estadoingreso',2)
            ->orderBy('comin.idcomingreso', 'asc')
            ->select(DB::raw("concat(' Codigo: ',cat.codcatprogramatica,' ',' // Nombre: ',cat.nombrecatprogramatica)
       as comin"), 'comin.idcomingreso')
            ->pluck('comin', 'comin.idcomingreso');



        $empleados = DB::table('empleados as emp')
            ->join('areas as a', 'a.idarea', '=', 'emp.idarea')
            ->join('file as fi', 'fi.idfile', '=', 'emp.idfile')
            ->select(DB::raw("concat(' Codigo: ',emp.idemp ,' ',emp.nombres ,' ', emp.ap_pat,' ',emp.ap_mat,' ',
                       ' // Cargo: ',fi.nombrecargo,' ',' // Area: ',a.nombrearea
                       ) as emplead"), 'emp.idemp')
            ->where('fi.cargo', "CHOFER")

            ->pluck('emplead', 'emp.idemp');


        return view('almacenes.comegreso.create',
            compact('date', 'partidas', 'comingresos', 'empleados')
        );
    }

    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id4 = $personalArea->idarea;
        $id3 = $personal->idprogramacomb;

        $comingreso = new ComegresoModel();

        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $hora = $fechasolACT->toTimeString();
        $comingreso->fechaegreso = $fechasolACT;
        $comingreso->horaegreso = $hora;
        $comingreso->gestionegreso = $gesti;

        $comingreso->idtipocomin = 2; // id 2 ingreso
        $comingreso->idcomingreso = $request->input('idcomingreso');
        $comingreso->idpartidacomb = $request->input('idpartida');
        $comingreso->detallecomegreso = $request->input('detalle');
        $comingreso->idusuario = $request->input('idusuario');

        $comingreso->idprogramacomb = $id3;
        $comingreso->idarea = $id4;
        $comingreso->idproveedor = 1;
        $comingreso->estadoegreso = 5;
        $comingreso->save();
        return redirect()->route('comegreso.index');
    }

    public function editar($idcomegreso)
    {
        $comegresos = ComegresoModel::find($idcomegreso);

        $id2 = $comegresos->idcomegreso;
        $id4 = $comegresos->idprogramacomb;
        $id5 = $comegresos->idarea;
        $id6 = $comegresos->idpartidacomb;
        $id7 = $comegresos->idcomingreso;
        $id8 = $comegresos->idusuario;
        $id9 = $comegresos->idtipocomin;
        $id10 = $comegresos->fechaegreso;
        $Fechaaretra = $comegresos->fechaegreso;
        $Horaartra = $comegresos->horaegreso;
        $Idvale = $comegresos->idvale;
        $estadoegreso = $comegresos->estadoegreso;


        $fechagrtra = substr($Fechaaretra, 8, 2);
        $fechamrtra = substr($Fechaaretra, 5, 2);
        $fechadrtra = substr($Fechaaretra, 0, 4);
        $Fechayhorartra = $fechagrtra . "-" .  $fechamrtra . "-" .  $fechadrtra . " " .  $Horaartra;

        $Fechaaprob = $comegresos->fechaaprob;
        $Horaartraaprob = $comegresos->horaaprob;
        $fechagrtraaprob = substr($Fechaaprob, 8, 2);
        $fechamrtraaprob = substr($Fechaaprob, 5, 2);
        $fechadrtraaprob = substr($Fechaaprob, 0, 4);
        $Fechayhorartraaprob = $fechagrtraaprob . "-" .  $fechamrtraaprob . "-" .  $fechadrtraaprob . " " .  $Horaartraaprob;

        $programados = DB::table('programacomb')
            ->where('idprogramacomb', $id4)
            ->select('codigoprogr', 'nombreprograma', 'idprogramacomb')
            ->get();

        $programacinco = DB::table('programacomb')
            ->where('estadoprograma', 1)
            ->select('codigoprogr', 'nombreprograma', 'idprogramacomb', 'estadoprograma')
            ->get();

        $areados = DB::table('areas')
            ->where('idarea', $id5)
            ->get();

        $areacinco = DB::table('areas')
            ->where('estadoarea', 1)

            ->get();

        $partidados = DB::table('partidacomb')
            ->select('codigopartida', 'nombrepartida', 'idpartidacomb')
            ->where('idpartidacomb', $id6)
            ->get();

        $partidacinco = DB::table('partidacomb')
            ->select('codigopartida', 'nombrepartida', 'idpartidacomb', 'estadopartida')
            ->where('estadopartida', 1)
            ->get();

        $tipos = DB::table('tipocomingreso')
            ->select('idtipocomin', 'nombrecoming')
            ->where('idtipocomin', '!=', 1)
            ->where('idtipocomin', '!=', 4)
            ->where('idtipocomin', $id9)
            ->get();

        $comingresotres = DB::table('comingreso as comin')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
            ->select('comin.estadoingreso', 'comin.idcomingreso', 'cat.codcatprogramatica', 'cat.nombrecatprogramatica')
            ->orderBy('comin.idcomingreso', 'asc')
            ->where('comin.idcomingreso', $id7)
            ->get();

        $comingresocinco = DB::table('comingreso as comin')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
            ->select('comin.estadoingreso', 'comin.idcomingreso', 'cat.codcatprogramatica', 'cat.nombrecatprogramatica')
            ->orderBy('comin.idcomingreso', 'asc')
            ->where('comin.estadoingreso', 2)
            ->get();

        $empleados = DB::table('empleados as emp')
            ->join('areas as a', 'a.idarea', '=', 'emp.idarea')
            ->join('file as fi', 'fi.idfile', '=', 'emp.idfile')
            ->select(
                'emp.estadoemp1',
                'emp.idemp',
                'emp.nombres',
                'emp.ap_pat',
                'emp.ap_mat',
                'fi.nombrecargo',
                'a.nombrearea'
            )
            ->where('fi.cargo', "CHOFER")
            ->where(function ($query) use ($id8) {
                $query->where('emp.estadoemp1', '=', 1)
                    ->orWhere(function ($subquery) use ($id8) {
                        $subquery->where('emp.idemp', '=', $id8)
                            ->where('emp.estadoemp1', '!=', 1);
                    });
            })
            ->get();

        $empleadocinco = DB::table('empleados as emp')
            ->join('areas as a', 'a.idarea', '=', 'emp.idarea')
            ->join('file as fi', 'fi.idfile', '=', 'emp.idfile')
            ->select(
                'emp.estadoemp1',
                'emp.idemp',
                'emp.nombres',
                'emp.ap_pat',
                'emp.ap_mat',
                'fi.nombrecargo',
                'a.nombrearea'
            )
            ->where('fi.cargo', "CHOFER")
            ->get();

        $proveedores = DB::table('proveedor')
            ->where('idproveedor', '!=', 1)
            ->get();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        if ($estadoegreso == 1) {
            return view('almacenes.comegreso.editar', compact(
                'id',
                'comegresos',
                'tipos',
                'programados',
                'areados',
                'Fechayhorartra',
                'Fechayhorartraaprob',
                'id2',
                'Idvale',
                'comingresotres',
                'partidados',
                'empleados',
                'proveedores'
            ));
        } else {
            if ($estadoegreso == 2) {
                return view('almacenes.comegreso.editar', compact(
                    'id',
                    'comegresos',
                    'tipos',
                    'programados',
                    'areados',
                    'Fechayhorartra',
                    'Fechayhorartraaprob',
                    'id2',
                    'Idvale',
                    'comingresotres',
                    'partidados',
                    'empleados',
                    'proveedores'
                ));
            } else {
                if ($estadoegreso == 5) {
                    return view('almacenes.comegreso.editarcinco', compact(
                        'id',
                        'id10',
                        'comegresos',
                        'tipos',
                        'programacinco',
                        'areacinco',
                        'Fechayhorartra',
                        'Fechayhorartraaprob',
                        'id2',
                        'Idvale',
                        'comingresocinco',
                        'partidacinco',
                        'empleadocinco',
                        'proveedores'
                    ));
                } else {
                    if ($estadoegreso == 6) {
                        return view('almacenes.comegreso.editarseis', compact(
                            'id',
                            'id10',
                            'comegresos',
                            'tipos',
                            'programados',
                            'areados',
                            'Fechayhorartra',
                            'Fechayhorartraaprob',
                            'id2',
                            'Idvale',
                            'comingresotres',
                            'partidados',
                            'empleados',
                            'proveedores'
                        ));

                    } else {
                        if ($estadoegreso == 7) {
                            return view('almacenes.comegreso.editarsiete', compact(
                                'id',
                                'comegresos',
                                'tipos',
                                'programados',
                                'areados',
                                'Fechayhorartra',
                                'Fechayhorartraaprob',
                                'id2',
                                'Idvale',
                                'comingresotres',
                                'partidados',
                                'empleados',
                                'proveedores'
                            ));
                    }}
                }
            }
        }
    }

    public function update(Request $request)
    {
        // $personal = User::find(Auth::user()->id);
        // $id = $personal->id;

        $comingreso = ComegresoModel::find($request->idcomegreso);
        $comingreso->idtipocomin = $request->input('tipo');
        $comingreso->detallecomegreso = $request->input('detalle');
        $comingreso->idprogramacomb = $request->input('idprograma');
        $comingreso->idcomingreso = $request->input('idcomingreso');
        $comingreso->idarea = $request->input('idarea');
        $comingreso->idpartidacomb = $request->input('idpartida');
        $comingreso->idusuario = $request->input('idempleado');
        $comingreso->idproveedor = $request->input('idproveedor');
        if ($comingreso->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('comegreso.index');
    }
    public function updatedos(Request $request)
    {
        // $personal = User::find(Auth::user()->id);
        // $id = $personal->id;
        $id10fech = $request->input('id10');
        $gestionant = substr($id10fech, 0, 4);
        $mesant = substr($id10fech, 5, 2);
        $diaant = substr($id10fech, 8, 2);
        $Fechaanter = $diaant . '-' . $mesant . '-' . $gestionant;

        $fechasol = $request->get('fechaegreso');
        $gestion = substr($fechasol, 6, 4);
        $mes = substr($fechasol, 3, 2);
        $dia = substr($fechasol, 0, 2);
        $Fechaactual = $dia . '-' . $mes . '-' . $gestion;



        $comingreso = ComegresoModel::find($request->idcomegreso);
        $comingreso->idtipocomin = $request->input('tipo');
        $comingreso->detallecomegreso = $request->input('detalle');
        $comingreso->idprogramacomb = $request->input('idprograma');
        $comingreso->idcomingreso = $request->input('idcomingreso');
        $comingreso->idarea = $request->input('idarea');
        $comingreso->idpartidacomb = $request->input('idpartida');
        $comingreso->idusuario = $request->input('idempleado');
        $comingreso->idproveedor = $request->input('idproveedor');
        $fechasolACT = Carbon::now();
        $hora = $fechasolACT->toTimeString();

        if ($Fechaanter == $Fechaactual) {
            $comingreso->fechaegreso = $request->get('fechaegreso');
        } else {
            $comingreso->fechaegreso = $request->get('fechaegreso');
            $comingreso->horaegreso = $hora;
            $comingreso->gestionegreso = $gestion;  
        }

        if ($comingreso->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('comegreso.index');
    }

    public function editardoc($idcomegreso)
    {
        $detallecomegresos = DB::table('detallecomegreso as n')
            ->join('comegreso as ing', 'ing.idcomegreso', '=', 'n.idcomegreso')
            ->join('detallecomingreso as de', 'de.iddetallecomingreso', '=', 'n.iddetallecomingreso')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')

            ->select(
                'n.iddetallecomegreso',
                'n.idcomegreso',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'u.nombremedida',
                'n.cantidadegreso',
                'de.precio',
                'n.subtotalegreso'
            )

            ->where('n.idcomegreso', $idcomegreso)->get();

        $valor_total = $detallecomegresos->sum('subtotalegreso');
        $valor_total2 = $detallecomegresos->sum('cantidadegreso');
        $CalAdosDecim = number_format($valor_total, 2, '.', '');
        $CalAdosDecimdos = number_format($valor_total2, 2, '.', '');

        $comegresos = DB::table('comegreso as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->join('partidacomb as pa', 'pa.idpartidacomb', '=', 'c.idpartidacomb')
            ->where('c.idcomegreso', $idcomegreso)
            ->select(
                'c.idcomegreso',
                'c.estadoegreso',
                'c.idpartidacomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();
        //  retorna la vista o el index
        return view(
            'almacenes.comegreso.docuconsumo',
            [
                "detallecomegresos" => $detallecomegresos,
                "CalAdosDecim" => $CalAdosDecim,
                "CalAdosDecimdos" => $CalAdosDecimdos,
                "comegresos" => $comegresos,
                "idcomegreso" => $idcomegreso
            ]
        );
    }

    public function editardoccinco($idcomegreso)
    {

        $detallecomegresos = DB::table('detallecomegreso as n')
            ->join('comegreso as ing', 'ing.idcomegreso', '=', 'n.idcomegreso')
            ->join('detallecomingreso as de', 'de.iddetallecomingreso', '=', 'n.iddetallecomingreso')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')

            ->select(
                'n.iddetallecomegreso',
                'n.idcomegreso',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'u.nombremedida',
                'n.cantidadegreso',
                'de.precio',
                'n.subtotalegreso'
            )

            ->where('n.idcomegreso', $idcomegreso)->get();

        $valor_total = $detallecomegresos->sum('subtotalegreso');
        $CalAdosDecim = number_format($valor_total, 2, '.', '');

        $comegresos = DB::table('comegreso as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->join('partidacomb as pa', 'pa.idpartidacomb', '=', 'c.idpartidacomb')
            ->where('c.idcomegreso', $idcomegreso)
            ->select(
                'c.idcomegreso',
                'c.estadoegreso',
                'c.idpartidacomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();

        $comegresose = ComegresoModel::find($idcomegreso);

        $id7 = $comegresose->idpartidacomb;
        $id8 = $comegresose->idcomingreso;
        $detallecomingresos = DB::table('detallecomingreso as deta')
            ->join('prodcomb as pro', 'pro.idprodcomb', '=', 'deta.idproducto')
            ->join('partidacomb as pa', 'pa.idpartidacomb', '=', 'pro.idpartidacomb')
            ->join('comingreso as comin', 'comin.idcomingreso', '=', 'deta.idcomingreso')
            ->where('deta.idcomingreso', $id8)
            ->where('pro.idpartidacomb', $id7)
            ->select(DB::raw("concat(
                            ' Codigo : ',pro.detalleprodcomb,
                            ' // Nombre : ',pro.nombreprodcomb,
                            ' // Cantidad : ',deta.difcantidad
                        
                        ) as detalleingreso"), 'iddetallecomingreso')
            ->pluck('detalleingreso', 'iddetallecomingreso');

        //  retorna la vista o el index
        return view('almacenes.comegreso.docuconsumocinco',
            [
                "detallecomegresos" => $detallecomegresos,
                "comegresos" => $comegresos,
                "detallecomingresos" => $detallecomingresos,
                "CalAdosDecim" => $CalAdosDecim,
                "idcomegreso" => $idcomegreso
            ]
        );
    }

    public function editardocseis($idcomegreso)
    {
       
        $detallecomegresos = DB::table('detallecomegreso as n')
            ->join('comegreso as ing', 'ing.idcomegreso', '=', 'n.idcomegreso')
            ->join('detallecomingreso as de', 'de.iddetallecomingreso', '=', 'n.iddetallecomingreso')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')

            ->select(
                'n.iddetallecomegreso',
                'n.idcomegreso',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'u.nombremedida',
                'n.cantidadegreso',
                'de.precio',
                'n.subtotalegreso'
            )

            ->where('ing.idcomegreso','=', $idcomegreso)->get();

        $valor_total = $detallecomegresos->sum('subtotalegreso');
        $CalAdosDecim = number_format($valor_total, 2, '.', '');

        $comegresos = DB::table('comegreso as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->join('partidacomb as pa', 'pa.idpartidacomb', '=', 'c.idpartidacomb')
            ->where('c.idcomegreso','=', $idcomegreso)
            ->select(
                'c.idcomegreso',
                'c.estadoegreso',
                'c.idpartidacomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();

        //  retorna la vista o el index
        return view('almacenes.comegreso.docuconsumoseis',
            [
                "detallecomegresos" => $detallecomegresos,
                "comegresos" => $comegresos,
             
                "CalAdosDecim" => $CalAdosDecim,
                "idcomegreso" => $idcomegreso
            ]
        );
    }

    public function editardocsiete($idcomegreso)
    {
       
        $detallecomegresos = DB::table('detallecomegreso as n')
            ->join('comegreso as ing', 'ing.idcomegreso', '=', 'n.idcomegreso')
            ->join('detallecomingreso as de', 'de.iddetallecomingreso', '=', 'n.iddetallecomingreso')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')

            ->select(
                'n.iddetallecomegreso',
                'n.idcomegreso',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'u.nombremedida',
                'n.cantidadegreso',
                'de.precio',
                'n.subtotalegreso'
            )

            ->where('ing.idcomegreso','=', $idcomegreso)->get();

        $valor_total = $detallecomegresos->sum('subtotalegreso');
        $CalAdosDecim = number_format($valor_total, 2, '.', '');

        $comegresos = DB::table('comegreso as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->join('partidacomb as pa', 'pa.idpartidacomb', '=', 'c.idpartidacomb')
            ->where('c.idcomegreso','=', $idcomegreso)
            ->select(
                'c.idcomegreso',
                'c.estadoegreso',
                'c.idpartidacomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();

        //  retorna la vista o el index
        return view('almacenes.comegreso.docuconsumosiete',
            [
                "detallecomegresos" => $detallecomegresos,
                "comegresos" => $comegresos,
             
                "CalAdosDecim" => $CalAdosDecim,
                "idcomegreso" => $idcomegreso
            ]
        );
    }


    public function insertar(Request $request)
    {
        $idcomegreso = $request->input('idcomegreso');
        $comingresos = ComegresoModel::find($idcomegreso);
        $idcoming = $comingresos->idcomingreso;

        $prod = $request->get('producto');
        $producto = ProdCombModel::find($prod);
        //del id del producto crea una variable precio para sacar el precio del producto
        $precio = $producto->precioprodcomb;

        //requiere la cantidad para detalle compra
        $cantidad = $request->get('cantidad');

        $SubTotalsol = $cantidad * $precio;
        $SubTotalsolresu = number_format($SubTotalsol, 10, '.', '');

        $detalleingreso = new DetalleComingresoModel;
        $detalleingreso->cantidad = $cantidad;
        $detalleingreso->precio = $precio;
        $detalleingreso->subtotal = $SubTotalsolresu;

        $detalleingreso->cantidadsalida = $cantidad;
        $detalleingreso->subtotalsalida = $SubTotalsolresu;

        $detalleingreso->subtotalentrada = 0;
        $detalleingreso->cantidadentrada = 0;

        $detalleingreso->difcantidad = $cantidad;
        $detalleingreso->subtdifcantidad = $SubTotalsolresu;

        $detalleingreso->idproducto = $prod;
        $detalleingreso->idcomingreso = $idcoming;

        $detalleingreso->estado2 = 1;
        $detalleingreso->estado1 = 1;

        $detallito = DB::table('detallecomingreso as d')

            ->join('prodcomb as ps', 'ps.idprodcomb', 'd.idproducto')
            ->join('comingreso as c', 'c.idcomingreso', 'd.idcomingreso')

            ->select(
                'd.iddetallecomingreso',
                'd.cantidad',
                'd.subtotal',
                'd.precio',
                'c.idcomingreso',
                'ps.nombreprodcomb'
            )
            ->orwhere('d.idproducto', $prod)
            ->where('d.idcomingreso', $idcoming)->get();

        if ($detallito->isEmpty()) {
            $detalleingreso->save();
            $Iddetal = $detalleingreso->iddetallecomingreso;
            $IDprod = $detalleingreso->idproducto;
            $cant = $detalleingreso->cantidad;
            $subto = $detalleingreso->subtotal;

            $detalleegreso = new DetalleComegresoModel;

            $detalleegreso->idcomegreso = $idcomegreso;
            $detalleegreso->iddetallecomingreso = $Iddetal;
            $detalleegreso->estadoegreso = 1;
            $detalleegreso->cantidadegreso = $cant;
            $detalleegreso->subtotalegreso = $subto;
            $detalleegreso->cantidadingreso = $cant;
            $detalleegreso->subtotalingreso = $subto;
            $detalleegreso->save();

            $comprasss = ProdCombModel::find($IDprod);
            $CanTidaddd = $comprasss->cantidadproducto;
            $Stotalproducto = $comprasss->subtotalproducto;

            $CanTidaddde = $CanTidaddd + $cant;
            $Stotalproductodos = $Stotalproducto + $subto;
            $comprasss->cantidadproducto = $CanTidaddde;
            $comprasss->subtotalproducto = $Stotalproductodos;
            $comprasss->save();

            $request->session()->flash('message', 'Registro Agregado');
        } else {

            $detallecomingresos = DB::table('detallecomingreso as n')

                ->join('comingreso as ing', 'ing.idcomingreso', '=', 'n.idcomingreso')
                ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'n.idproducto')
                ->select('n.iddetallecomingreso', 'n.cantidad', 'n.precio', 'n.subtotal')
                ->where('ing.idcomingreso', '=', $idcoming)->get();
            $Iddetale = $detallecomingresos->iddetallecomingreso;

            $detalleingreso = DetalleComingresoModel::find($Iddetale);
            $detalleingreso->cantidad = $cantidad;
            $detalleingreso->precio = $precio;
            $detalleingreso->subtotal = $SubTotalsolresu;

            $detalleingreso->cantidadsalida = $cantidad;
            $detalleingreso->subtotalsalida = $SubTotalsolresu;

            $detalleingreso->subtotalentrada = 0;
            $detalleingreso->cantidadentrada = 0;

            $detalleingreso->difcantidad = $cantidad;
            $detalleingreso->subtdifcantidad = $SubTotalsolresu;

            $detalleingreso->idproducto = $prod;
            $detalleingreso->idcomingreso = $idcoming;

            $detalleingreso->estado2 = 1;
            $detalleingreso->estado1 = 1;
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('comegreso.editardoc', [$idcomegreso]);
    }

    public function insertarcinco(Request $request)
    {
        $idcomegreso = $request->input('idcomegreso');
        $comingresos = ComegresoModel::find($idcomegreso);
        $idcomegreso = $comingresos->idcomegreso;

        $prod = $request->get('producto');

        $ingresoss = DetalleComingresoModel::find($prod);
        //del id del producto crea una variable precio para sacar el precio del producto

        $precio = $ingresoss->precio;

        //requiere la cantidad para detalle compra
        $cantidad = $request->get('cantidad');

        $SubTotalsol = $cantidad * $precio;
        $SubTotalsolresu = number_format($SubTotalsol, 10, '.', '');

        $detalleegreso = new DetallecomegresoModel();
        $detalleegreso->iddetallecomingreso = $prod;
        $detalleegreso->idcomegreso = $idcomegreso;

        $detalleegreso->cantidadegreso = $cantidad;
        $detalleegreso->subtotalegreso = $SubTotalsolresu;

        $detalleegreso->cantidadingreso = $cantidad;
        $detalleegreso->subtotalingreso = $SubTotalsolresu;
        $detalleegreso->estadoegreso = 2;

        if ($detalleegreso->save()) {
            $Iddetaldos = $detalleegreso->idcomegreso;
            $Iddetal = $detalleegreso->iddetallecomingreso;
            $cant = $detalleegreso->cantidadegreso;
            $subto = $detalleegreso->subtotalegreso;
            $ingresossdos = ComegresoModel::find($Iddetaldos);
            $ingresossdos->estadoegreso = 6;
            $ingresossdos->save();
            $ingresoss = DetalleComingresoModel::find($Iddetal);
            //del id del producto crea una variable precio para sacar el precio del producto
            $Cantidaduno = $ingresoss->cantidad;                      //aqui va la cantidad que se va ingresando de a poco
            $sudtotaluno = $ingresoss->subtotal;                      //aqui va el subtotal que va ingresando de a poco
            $IDprods = $ingresoss->idproducto;
            $var1 = $Cantidaduno + $cant;
            $var2 = $sudtotaluno + $subto;

            $var11 = number_format($var1, 10, '.', '');
            $var22 = number_format($var2, 10, '.', '');

            $Cantidadseis = $ingresoss->cantidadsalida;                      //aqui va la cantidad inicial
            $sudtotalseis = $ingresoss->subtotalsalida;                      //aqui va el subtotal inicial

            $Cantidaddos = $ingresoss->cantidadentrada;                      //aqui va la cantidad que se va sumando
            $sudtotaldos = $ingresoss->subtotalentrada;                      //aqui va el subtotal que se va sumando
            $var3 = $var11 - $Cantidaddos;
            $var4 = $var22 - $sudtotaldos;
            $var33 = number_format($var3, 10, '.', '');
            $var44 = number_format($var4, 10, '.', '');

            $Cantidadtres = $ingresoss->difcantidad;                         //aqui va la resta cantidad - cantidadentrada
            $sudtotaltres = $ingresoss->subtdifcantidad;                      //aqui van la resta de subtotal - subtotalentrada

            $Cantidadcuatro = $ingresoss->cantidadingreso;                    //aqui van la suma de los ingresos que se va haciendo
            $sudtotadcuatro = $ingresoss->subtotalcantidadingreso;             //aqui van la suma de los subtotal de ingresos
            $var7 = $Cantidadcuatro + $cant;
            $var8 = $sudtotadcuatro + $subto;
            $var77 = number_format($var7, 10, '.', '');
            $var88 = number_format($var8, 10, '.', '');

            $Cantidadcinco = $ingresoss->difcantidadingreso;                  //aqui van el resultado de cantidadsalida+cantidadingreso el resultado - difcantidad
            $sudtotalcinco = $ingresoss->subdifcantidadingreso;               //aqui va lo mismo pero del precio

            $var51 = $Cantidadseis + $var77;
            $var5 = $var51 - $Cantidaddos;
           

            $var61 = $sudtotalseis + $var88;
            $var6 = $var61 - $sudtotaldos;
       
            $var55 = number_format($var5, 10, '.', '');
            $var66 = number_format($var6, 10, '.', '');



            $detalleingreso =  DetalleComingresoModel::find($Iddetal);
            $detalleingreso->cantidad = $var11;
            $detalleingreso->subtotal = $var22;

            $detalleingreso->difcantidad = $var33;
            $detalleingreso->subtdifcantidad = $var44;

            $detalleingreso->cantidadingreso = $var77;
            $detalleingreso->subtotalcantidadingreso = $var88;

            $detalleingreso->difcantidadingreso = $var55;
            $detalleingreso->subdifcantidadingreso = $var66;
            $detalleingreso->save();

            $comprasss = ProdCombModel::find($IDprods);
            $CanTidaddd = $comprasss->cantidadproducto;
            $Stotalproducto = $comprasss->subtotalproducto;

            $CanTidaddde = $CanTidaddd + $cant;
            $Stotalproductodos = $Stotalproducto + $subto;
            $comprasss->cantidadproducto = $CanTidaddde;
            $comprasss->subtotalproducto = $Stotalproductodos;
            $comprasss->save();

            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }
        return redirect()->route('comegreso.editardocseis', [$idcomegreso]);
    }

    public function aprovar($id)
    {
        $compras = ComegresoModel::find($id);
        $compras->estadoegreso = 2;

        $fechasolACT = Carbon::now();
        $hora = $fechasolACT->toTimeString();

        $compras->fechaaprob = $fechasolACT;
        $compras->horaaprob = $hora;
        $compras->save();

        return redirect()->route('comegreso.index');
    }

    public function aprovardos($id)
    {
        $compras = ComegresoModel::find($id);
        $compras->estadoegreso = 2;

        $fechasolACT = Carbon::now();
        $hora = $fechasolACT->toTimeString();

        $compras->fechaaprob = $fechasolACT;
        $compras->horaaprob = $hora;
        $compras->save();

        return redirect()->route('comegreso.index');
    }
    
    public function aprovarseis($id)
    {
        $compras = ComegresoModel::find($id);
        $compras->estadoegreso = 7;

        $fechasolACT = Carbon::now();
        $hora = $fechasolACT->toTimeString();

        $compras->fechaaprob = $fechasolACT;
        $compras->horaaprob = $hora;
        $compras->save();

        return redirect()->route('comegreso.index');
    }
    public function solicituddos($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');
            $detalle = DetalleValeModel::find($id);
            $detalle = DB::table('detallevale as d')
                ->select(


                    'd.idvale',
                    'd.iddetallecomingreso', //de forma automatica del que tiene acceso

                    'd.cantidadsol',  //de forma automatica del que tiene acceso
                    'd.preciosol',  //el lugar de ida

                    //via
                    'd.subtotalsol',
                    'd.cantidadresta'
                )
                ->where('d.iddetallevale', $id)

                ->first();

            $Idvale = $detalle->idvale;

            $Idingreso = $detalle->iddetallecomingreso;
            $cantidadsolici = $detalle->cantidadsol;
            $Cantidaddev = number_format($cantidadsolici, 2, '.', '');
            $vales = DB::table('vale as v')
                ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
                ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')
                ->join('comingreso as comin', 'comin.idcomingreso', '=', 'v.idcomingreso')
                ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
                ->join('areas as a', 'a.idarea', '=', 'v.idarea')
                ->select(
                    'v.idvale',
                    'v.marcaconsumo',
                    'v.placaconsumo',
                    'v.kilometrajeactualconsumo',
                    'v.kiloanterior',
                    'v.detallesouconsumo',
                    'a.nombrearea',
                    'v.usuarionombre',
                    'cat.codcatprogramatica',
                    'cat.nombrecatprogramatica'
                )
                ->where('v.idvale', '=', $Idvale)
                ->first();

            $detallecomingresos = DB::table('detallecomingreso as det')
                ->select(
                    'det.iddetallecomingreso',
                    'det.difcantidad'
                    // 'ing.kilometrajeactualconsumo','ing.kiloanterior',
                    // 'ing.detallesouconsumo','ing.nombrearea'

                )
                ->where('det.iddetallecomingreso', '=', $Idingreso)
                ->first();

            $cantidadsolicidos = $detallecomingresos->difcantidad;
            $Cantidaddevdos = number_format($cantidadsolicidos, 2, '.', '');

            // $ingresos = DB::table('ingreso as ing')
            // ->select('ing.idingreso','ing.nombreprograma',
            // 'ing.codigocatprogramai'


            // )
            // ->where('ing.idingreso', '=', $Idingreso)
            // ->first();


            $pdf = PDF::loadView(
                'almacenes.detalle.pdf-solicitud',
                compact(['detalle', 'vales', 'detallecomingresos', 'Cantidaddev', 'Cantidaddevdos'])
            );

            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('adetalle.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function editardetalle($idcomegreso)
    {
        $detallecomegresos = DB::table('detallecomegreso as n')
            ->join('comegreso as ing', 'ing.idcomegreso', '=', 'n.idcomegreso')
            ->join('detallecomingreso as de', 'de.iddetallecomingreso', '=', 'n.iddetallecomingreso')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')

            ->select(
                'n.iddetallecomegreso',
                'n.idcomegreso',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'u.nombremedida',
                'n.cantidadegreso',
                'de.precio',
                'n.subtotalegreso'
            )

            ->where('n.idcomegreso', $idcomegreso)->get();

        $valor_total = $detallecomegresos->sum('subtotalegreso');
        $CalAdosDecim = number_format($valor_total, 2, '.', '');

        $comegresos = DB::table('comegreso as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->where('c.idcomegreso', $idcomegreso)
            ->select(
                'c.idcomegreso',
                'c.estadoegreso',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();

        //  retorna la vista o el index
        return view(
            'almacenes.comegreso.docuconsumodos',
            [
                "detallecomegresos" => $detallecomegresos,
                "comegresos" => $comegresos,
                "CalAdosDecim" => $CalAdosDecim,
                "idcomegreso" => $idcomegreso
            ]
        );
    }

    public function editararchivo($iddetallecomegreso)
    {
        $docproveedor = DetalleComegresoModel::find($iddetallecomegreso);
        //id2 es para el producto que lo tiene detalle de ingreso
        $id2 = $docproveedor->iddetallecomingreso;
        $id3 = $docproveedor->idcomegreso;
        $id4 = $docproveedor->iddetallevale;

        $id5 = $docproveedor->cantidadegreso;
        $id6 = $docproveedor->subtotalegreso;


        $detallecoming = DB::table('detallecomingreso as de')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')
            ->select('de.iddetallecomingreso', 'ps.detalleprodcomb', 'ps.nombreprodcomb', 'u.nombremedida', 'de.precio', 'de.difcantidad')
            ->where('de.iddetallecomingreso', $id2)
            ->get();

        return view(
            'almacenes.comegreso.editarnota',
            [
                "docproveedor" => $docproveedor,
                "id2" => $id2,
                "id3" => $id3,
                "id4" => $id4,
                "id5" => $id5,
                "id6" => $id6,
                "detallecoming" => $detallecoming
            ]
        );
    }

    public function updatearchivonota(Request $request, $iddetallecomegreso)
    {

        $id2detcoming = $request->input('id2');
        $idcomegreso = $request->input('id3');
        $id4detvale = $request->input('id4');

        $id5ctegr = $request->input('id5');
        $id6subtegr = $request->input('id6');


        $cantidad = $request->get('cantidad');   //bajar 

        $productos = DetallecomingresoModel::find($id2detcoming);

        $Cantidaddif = $productos->cantidad;
        $sudtotaldif = $productos->subtotal;

        $Cantidadentrada = $productos->cantidadentrada;
        $sudtotalentrada = $productos->subtotalentrada;
        $det = $productos->precio;

        $cantentraresta = $Cantidadentrada - $id5ctegr;
        $subtotalentraresta = $sudtotalentrada - $id6subtegr;

        $ctre1 = number_format($cantentraresta, 10, '.', '');
        $sbtre1 = number_format($subtotalentraresta, 10, '.', '');


        $subtotal1 = $det * $cantidad;
        $subtotal = number_format($subtotal1, 10, '.', '');

        $cantentrasuma = $ctre1 + $cantidad;
        $subtotalentrasuma = $sbtre1 + $subtotal;

        $ctre2 = number_format($cantentrasuma, 10, '.', '');
        $sbtre2 = number_format($subtotalentrasuma, 10, '.', '');

        $difcantentrare = $Cantidaddif - $ctre2;
        $difsubtotalentrare = $sudtotaldif - $sbtre2;


        $cdifctre3 = number_format($difcantentrare, 10, '.', '');
        $sdifbtre3 = number_format($difsubtotalentrare, 10, '.', '');

        $detalleingreso = DetallecomingresoModel::find($id2detcoming);
        $detalleingreso->cantidadentrada = $ctre2;
        $detalleingreso->subtotalentrada = $sbtre2;
        $detalleingreso->difcantidad = $cdifctre3;
        $detalleingreso->subtdifcantidad = $sdifbtre3;

        $detallevales = DetalleValeModel::find($id4detvale);
        $detallevales->cantidadsol = $cantidad;
        $detallevales->subtotalsol = $subtotal;


        $docproveedor = DetallecomegresoModel::find($iddetallecomegreso);
        $docproveedor->cantidadingreso = $request->get('cantidad');
        $docproveedor->subtotalingreso  = $subtotal;
        $docproveedor->cantidadegreso = $cantidad;
        $docproveedor->subtotalegreso  = $subtotal;
        $docproveedor->idcomegreso = $idcomegreso;
        $docproveedor->iddetallecomingreso  = $id2detcoming;
        if ($docproveedor->save()) {
            $detalleingreso->save();
            $detallevales->save();
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('comegreso.editardoc', [$idcomegreso]);
    }

    public function editararchivoseis($iddetallecomegreso)
    {
        $docproveedor = DetalleComegresoModel::find($iddetallecomegreso);
        //id2 es para el producto que lo tiene detalle de ingreso
        $id2 = $docproveedor->iddetallecomingreso;
        $id3 = $docproveedor->idcomegreso;
        $id5 = $docproveedor->cantidadegreso;
        $id6 = $docproveedor->subtotalegreso;


        $detallecoming = DB::table('detallecomingreso as de')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')
            ->select('de.iddetallecomingreso', 'ps.detalleprodcomb', 'ps.nombreprodcomb', 'u.nombremedida', 'de.precio', 'de.difcantidad')
            ->where('de.iddetallecomingreso', $id2)
            ->get();

        return view('almacenes.comegreso.editarnotaseis',
            [
                "docproveedor" => $docproveedor,
                "id2" => $id2,
                "id3" => $id3,

                "id5" => $id5,
                "id6" => $id6,
                "detallecoming" => $detallecoming
            ]
        );
    }

    public function updatearchivonotaseis(Request $request, $iddetallecomegreso)
    {

        $id2detcoming = $request->input('id2');
        $idcomegreso = $request->input('id3');

        $id5ctegr = $request->input('id5');
        $id6subtegr = $request->input('id6');


        $cantidad = $request->get('cantidad');   //bajar 

        $productos = DetallecomingresoModel::find($id2detcoming);

        $Cantidaddif = $productos->cantidad;
        $sudtotaldif = $productos->subtotal;

        $vars1 = $productos->cantidadsalida;
        $vars2 = $productos->subtotalsalida;

        $vars3 = $productos->cantidadentrada;
        $vars4 = $productos->subtotalentrada;

        $Cantidadentrada = $productos->cantidadingreso;
        $sudtotalentrada = $productos->subtotalcantidadingreso;

        $vars5 = $productos->difcantidadingreso;
        $vars6 = $productos->subdifcantidadingreso;

        $det = $productos->precio;

        $cantentraresta = $Cantidadentrada - $id5ctegr;
        $subtotalentraresta = $sudtotalentrada - $id6subtegr;

        $ctre1 = number_format($cantentraresta, 10, '.', '');
        $sbtre1 = number_format($subtotalentraresta, 10, '.', '');

        $var1 = $Cantidaddif - $id5ctegr;
        $var2 = $sudtotaldif - $id6subtegr;

        $var11 = number_format($var1, 10, '.', '');      //la nueva cantidad aplicando la resta
        $var22 = number_format($var2, 10, '.', '');      //la nueva cantidad aplicando la resta

        $subtotal1 = $det * $cantidad;
        $subtotal = number_format($subtotal1, 10, '.', '');

        $cantentrasuma = $ctre1 + $cantidad;
        $subtotalentrasuma = $sbtre1 + $subtotal;

        $ctre2 = number_format($cantentrasuma, 10, '.', '');       //la suma de ingreso
        $sbtre2 = number_format($subtotalentrasuma, 10, '.', '');       //la suma de ingreso

        $var3 = $var11 + $cantidad;
        $var4 = $var22 + $subtotal;
        $var33 = number_format($var3, 10, '.', '');      //la nueva cantidad
        $var44 = number_format($var4, 10, '.', '');      //la nueva cantidad


        $difcantentrare = $var33 - $vars3;
        $difsubtotalentrare = $var44 - $vars4;
        $cdifctre3 = number_format($difcantentrare, 10, '.', '');      //para la diferencia dift
        $sdifbtre3 = number_format($difsubtotalentrare, 10, '.', '');      //para la diferencia dift

        $var51 = $vars1 + $ctre2;
        $var5 = $var51 - $vars3;
     

        $var61 = $vars2 + $sbtre2;
        $var6 = $var61 - $vars4;
   
        $var55 = number_format($var5, 10, '.', '');
        $var66 = number_format($var6, 10, '.', '');

        $detalleingreso = DetallecomingresoModel::find($id2detcoming);

        $detalleingreso->cantidad = $var33;
        $detalleingreso->subtotal = $var44;

        $detalleingreso->cantidadingreso = $ctre2;
        $detalleingreso->subtotalcantidadingreso = $sbtre2;

        $detalleingreso->difcantidad = $cdifctre3;
        $detalleingreso->subtdifcantidad = $sdifbtre3;

        $detalleingreso->difcantidadingreso = $var55;
        $detalleingreso->subdifcantidadingreso = $var66;


        $docproveedor = DetallecomegresoModel::find($iddetallecomegreso);
        $docproveedor->cantidadingreso = $request->get('cantidad');
        $docproveedor->subtotalingreso  = $subtotal;
        $docproveedor->cantidadegreso = $cantidad;
        $docproveedor->subtotalegreso  = $subtotal;
        $docproveedor->idcomegreso = $idcomegreso;
        $docproveedor->iddetallecomingreso  = $id2detcoming;
        if ($docproveedor->save()) {
            $detalleingreso->save();


            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('comegreso.editardocseis', [$idcomegreso]);
    }


    public function createdoc($idingreso)
    {

        return view(
            'almacenes.ingreso.createdocuconsumo',
            ["idingreso" => $idingreso]
        );
    }






    public function solicitud($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $comegreso = ComegresoModel::find($id);
            $comegreso = DB::table('comegreso as ce')
                ->select(
                    'ce.idcomegreso',
                    'ce.idcomingreso',
                    'ce.idvale',
                    'ce.detallecomegreso',
                    'ce.fechaaprob',
                    'ce.horaaprob'
                )
                ->where('ce.idcomegreso', $id)
                ->first();
            $Idvale = $comegreso->idvale;
            $Idcomingreso = $comegreso->idcomingreso;

            $Fechaaprob = $comegreso->fechaaprob;
            $Horaartraaprob = $comegreso->horaaprob;
            $fechagrtraaprob = substr($Fechaaprob, 8, 2);
            $fechamrtraaprob = substr($Fechaaprob, 5, 2);
            $fechadrtraaprob = substr($Fechaaprob, 0, 4);
            $Fechayhorartraaprob = $fechagrtraaprob . "-" .  $fechamrtraaprob . "-" .  $fechadrtraaprob . " " .  $Horaartraaprob;



            $comingreso = DB::table('vale as va')
                ->join('comingreso as cig', 'cig.idcomingreso', '=', 'va.idcomingreso')
                ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'cig.idcatprogramaticacomb')
                ->select('cat.codcatprogramatica', 'cat.nombrecatprogramatica', 'va.idvale')
                ->where('va.idvale', $Idvale)
                ->first();

            $detallecomegresos = DB::table('detallecomegreso as n')
                ->join('comegreso as ing', 'ing.idcomegreso', '=', 'n.idcomegreso')
                ->join('detallecomingreso as de', 'de.iddetallecomingreso', '=', 'n.iddetallecomingreso')
                ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
                ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')
                ->select(
                    'n.iddetallecomegreso',
                    'n.idcomegreso',
                    'ps.detalleprodcomb',
                    'ps.nombreprodcomb',
                    'u.nombremedida',
                    'n.cantidadegreso',
                    'de.precio',
                    'n.subtotalegreso'
                )
                ->where('n.idcomegreso', $id)->first();


            $cantidadsolicidos = $detallecomegresos->cantidadegreso;
            $subtotalsolicidos = $detallecomegresos->subtotalegreso;
            $preciosol = $detallecomegresos->precio;

            $Varuno = number_format($cantidadsolicidos, 2, '.', '');
            $Vardos = number_format($subtotalsolicidos, 2, '.', '');

            $parte_entera = floor($Vardos);
            $parte_decimal = ($Vardos - $parte_entera) * 100;

            $parte_entera_en_letras = NumerosEnLetras::convertir($parte_entera, 'Bolivianos', false);
            $parte_decimal_en_letras = NumerosEnLetras::convertir($parte_decimal, 'Centavos', false);

            $valor_total5 = $parte_entera_en_letras . ' con ' . $parte_decimal_en_letras;


            $pdf = PDF::loadView(
                'almacenes.comegreso.pdf-solicitud',
                compact(['comegreso', 'comingreso', 'detallecomegresos', 'Varuno', 'Vardos', 'valor_total5', 'Fechayhorartraaprob'])
            );

            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('comegreso.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function solicitudseis($idcomegreso)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $comegreso = ComegresoModel::find($idcomegreso);
            $comegreso = DB::table('comegreso as ce')
                ->select(
                    'ce.idcomegreso',
                    'ce.idcomingreso',
              
                    'ce.detallecomegreso',
                    'ce.fechaegreso',
                    'ce.gestionegreso',
                    'ce.horaegreso'
                )
                ->where('ce.idcomegreso', $idcomegreso)
                ->first();
         
            $Idcomingreso = $comegreso->idcomingreso;

            $Fechaaprob = $comegreso->fechaegreso;
            $Horaartraaprob = $comegreso->horaegreso;
            $fechagrtraaprob = substr($Fechaaprob, 8, 2);
            $fechamrtraaprob = substr($Fechaaprob, 5, 2);
            $fechadrtraaprob = substr($Fechaaprob, 0, 4);
            $Fechayhorartraaprob = $fechagrtraaprob . "-" .  $fechamrtraaprob . "-" .  $fechadrtraaprob . " " .  $Horaartraaprob;



            $comingreso = DB::table('comegreso as va')
                ->join('comingreso as cig', 'cig.idcomingreso', '=', 'va.idcomingreso')
                ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'cig.idcatprogramaticacomb')
                ->select('cat.codcatprogramatica', 'cat.nombrecatprogramatica', 'va.idcomingreso','va.idcomegreso')
                ->where('cig.idcomingreso', $Idcomingreso)
                ->where('va.idcomegreso', $idcomegreso)
                ->first();

            $detallecomegresos = DB::table('detallecomegreso as n')
                ->join('comegreso as ing', 'ing.idcomegreso', '=', 'n.idcomegreso')
                ->join('detallecomingreso as de', 'de.iddetallecomingreso', '=', 'n.iddetallecomingreso')
                ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'de.idproducto')
                ->join('umedidacomb as u', 'u.idmedida', '=', 'ps.idmedidacomb')
                ->select(
                    'n.iddetallecomegreso',
                    'n.idcomegreso',
                    'ps.detalleprodcomb',
                    'ps.nombreprodcomb',
                    'u.nombremedida',
                    'n.cantidadegreso',
                    'de.precio',
                    'n.subtotalegreso'
                )
                ->where('n.idcomegreso', $idcomegreso)->first();


            $cantidadsolicidos = $detallecomegresos->cantidadegreso;
            $subtotalsolicidos = $detallecomegresos->subtotalegreso;
            $preciosol = $detallecomegresos->precio;

            $Varuno = number_format($cantidadsolicidos, 2, '.', '');
            $Vardos = number_format($subtotalsolicidos, 2, '.', '');

            $parte_entera = floor($Vardos);
            $parte_decimal = ($Vardos - $parte_entera) * 100;

            $parte_entera_en_letras = NumerosEnLetras::convertir($parte_entera, 'Bolivianos', false);
            $parte_decimal_en_letras = NumerosEnLetras::convertir($parte_decimal, 'Centavos', false);

            $valor_total5 = $parte_entera_en_letras . ' con ' . $parte_decimal_en_letras;


            $pdf = PDF::loadView(
                'almacenes.comegreso.pdf-solicitudseis',
                compact(['comegreso', 'comingreso', 'detallecomegresos', 'Varuno', 'Vardos', 'valor_total5', 'Fechayhorartraaprob'])
            );

            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('comegreso.index')->with('message', $ex->getMessage());
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
