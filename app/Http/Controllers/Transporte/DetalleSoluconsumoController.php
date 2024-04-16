<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Transporte\Temporal5Model;

use App\Models\Transporte\UnidaddConsumoModel;
use App\Models\Transporte\DetalleSoluconsumoModel;

use App\Models\Transporte\SoluconsumoModel;


use App\Models\Almacen\ValeModel;


use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use NumerosEnLetras;
use PDF;

use App\Models\EmpleadosModel;
use App\Models\FileModel;
use App\Models\AreasModel;


class DetalleSoluconsumoController extends Controller
{
    public function index()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal5Model::find($id);

        $id2 = $detalle->idsoluconsumo;
        $date = Carbon::now();
        $prodserv = DB::table('detallesoluconsumo as d')

            ->join('unidadconsumo as uni', 'uni.idunidadconsumo', '=', 'd.idunidadconsumo')
            ->join('soluconsumo as sol', 'sol.idsoluconsumo', '=', 'd.idsoluconsumo')
            ->join('marcamovilidad as ma', 'ma.idmarcamovilidad', '=', 'uni.idmarcamovilidad')
            ->select(
                'd.iddetallesoluconsumo',
                'uni.nombreuconsumo',
                'd.codigoconsumo',
                'd.marcaconsumo',
                'd.placaconsum',
                'd.kilometrajeactual',
                'd.chofernombre',
                'uni.idunidadconsumo',
                'uni.marcaconsumo',
                'uni.placaconsumo',
                'ma.nombremarca',
                'uni.kilometrajefinalconsumo'
            )

            ->where('d.idsoluconsumo', $id2)
            ->orderBy('d.iddetallesoluconsumo', 'desc')
            ->get();

        $productos = DB::table('unidadconsumo')
            ->where('estadoconsumo', 1)
            ->where('idunidadconsumo', '!=', 43)
            ->select(DB::raw("concat(' CODIGO: ',codigoconsumo,' //NOMBRE ',nombreuconsumo,' //PLACA: ',placaconsumo,
                        ' // klm anter. ',kilometrajefinalconsumo) as prodservicio"), 'idunidadconsumo')
            ->orderBy('idunidadconsumo', 'asc')
            ->pluck('prodservicio', 'idunidadconsumo');
        $empleados = DB::table('empleados as emp')
            ->join('areas as a', 'a.idarea', '=', 'emp.idarea')
            ->join('file as fi', 'fi.idfile', '=', 'emp.idfile')
            ->select(DB::raw("concat(' CODIGO: ',idemp,' //NOMBRE ',emp.nombres ,' ', emp.ap_pat,' ',emp.ap_mat,' ',
                                    ' //AREA: ',a.nombrearea,' ',' //Cargo: ',fi.nombrecargo
                                    ) as emplead"), 'emp.idemp')
            ->where('fi.cargo', "CHOFER")
            ->where('emp.estadoemp1', 1)
            ->orderBy('emp.idemp', 'asc')
            ->pluck('emplead', 'emp.idemp');

        $consumos = DB::table('soluconsumo as s')

            ->where('s.idsoluconsumo', $id2)
            ->select('s.idsoluconsumo', 's.estado3', 's.fechaprotrans', 's.horaprobtrans')
            ->first();



        return view(
            'transportes.detalle.index',
            [
                'prodserv' => $prodserv,
                'productos' => $productos,
                'empleados' => $empleados,
                'consumos' => $consumos,
                'idsoluconsumo' => $id2,
                'date' => $date
            ]
        );
    }

    public function index2()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal5Model::find($id);

        $id2 = $detalle->idsoluconsumo;

        $prodserv = DB::table('detallesoluconsumo as d')

            ->join('unidadconsumo as uni', 'uni.idunidadconsumo', '=', 'd.idunidadconsumo')
            ->join('soluconsumo as sol', 'sol.idsoluconsumo', '=', 'd.idsoluconsumo')
            ->join('marcamovilidad as ma', 'ma.idmarcamovilidad', '=', 'uni.idmarcamovilidad')
            ->select(
                'd.iddetallesoluconsumo',
                'uni.nombreuconsumo',
                'd.codigoconsumo',
                'd.marcaconsumo',
                'd.placaconsum',
                'd.kilometrajeactual',
                'd.chofernombre',
                'uni.idunidadconsumo',
                'uni.marcaconsumo',
                'uni.placaconsumo',
                'ma.nombremarca',
                'uni.kilometrajefinalconsumo'
            )

            ->where('d.idsoluconsumo', $id2)
            ->orderBy('d.iddetallesoluconsumo', 'desc')
            ->get();

        $productos = DB::table('unidadconsumo')
            ->where('estadoconsumo', 1)
            ->select(DB::raw("concat(nombreuconsumo,' // ',placaconsumo,
                        ' // klm anter. ',kilometrajefinalconsumo) as prodservicio"), 'idunidadconsumo')
            ->pluck('prodservicio', 'idunidadconsumo');




        return view(
            'transportes.detalle.index2',
            [
                'prodserv' => $prodserv,
                'productos' => $productos,

                'idsoluconsumo' => $id2
            ]
        );
    }


    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $detalle = Temporal5Model::find($id);

        $id2 = $detalle->idsoluconsumo;
        //accede a la tabla producto servicio

        $prod = $request->get('producto');
        $producto = UnidaddConsumoModel::find($prod);

        $Codigoconsumo = $producto->codigoconsumo;
        $Marcaconsumo = $producto->marcaconsumo;
        $Placaconsumo = $producto->placaconsumo;
        //todo klm anterior 
        $Klmactual = $producto->kilometrajefinalconsumo;
        $Gaxklm = $producto->gasporklm;

        $Tipouni = $producto->idtipomovilidad;

        //todo guardar la unidad

        //requiere el kilometraje actual
        //todo guardar empleado
        $proddos = $request->get('chofer');



        $productotres = EmpleadosModel::find($proddos);
        $Nombrevia = $productotres->nombres;
        $Apellidopavia = $productotres->ap_pat;
        $Apellidomavia = $productotres->ap_mat;
        $Nombrecompvia = $Nombrevia . " " .  $Apellidopavia . " " . $Apellidomavia;

        $IdFiledos = $productotres->idfile;
        $productocuatro = FileModel::find($IdFiledos);
        $Nombreviacargo = $productocuatro->nombrecargo;

        //todo klm actual 
        $KLMactual = $request->get('cantidad');

        $detalle = new DetalleSoluconsumoModel;
        $detalle->idunidadconsumo = $request->get('producto');
        $detalle->idsoluconsumo = $id2;
        $detalle->kilometrajeactual = $request->get('cantidad');

        $detalle->codigoconsumo = $Codigoconsumo;
        $detalle->marcaconsumo = $Marcaconsumo;
        $detalle->placaconsum = $Placaconsumo;

        $detalle->klmanterior = $Klmactual;

        $detalle->gasporklm = $Gaxklm;

        $detalle->idtipomovilidad = $Tipouni;

        // aumentando chofer


        $detalle->idchofer = $request->get('chofer');  //via 
        $detalle->chofernombre = $Nombrecompvia;
        $detalle->chofercargo = $Nombreviacargo;
        $detalle->estadodetalle = 2;
        $fechasolACT = Carbon::now();
        $detalle->fecharesp = $fechasolACT;
        $hora = $fechasolACT->toTimeString();
        $detalle->horaresp = $hora;
        $detallito = DB::table('detallesoluconsumo as d')

            ->join('unidadconsumo as uni', 'uni.idunidadconsumo',  'd.idunidadconsumo')
            ->join('soluconsumo as sol', 'sol.idsoluconsumo',  'd.idsoluconsumo')

            ->select(
                'd.iddetallesoluconsumo',
                'uni.idunidadconsumo',
                'uni.marcaconsumo',
                'uni.placaconsumo',
                'uni.kilometrajefinalconsumo'
            )
            ->orwhere('d.idunidadconsumo', $prod)

            ->where('d.idsoluconsumo', $id2)->get();


        if ($detallito->isEmpty()) {

            if ($KLMactual > $Klmactual) {
                $detalle->save();
                $prodd = $detalle->idunidadconsumo;
                $prodde = $detalle->idchofer;
                $idDetalle = $detalle->idsoluconsumo;

                $progrmi = SoluconsumoModel::find($idDetalle);
                $progrmi->estado3 = 2;
                $progrmi->save();

                $progrmid = SoluconsumoModel::find($idDetalle);
                $fechasalidas = $progrmid->fechasalida;
                $fecharetornod = $progrmid->fecharetorno;
              

              
                $Estadoemp = EmpleadosModel::find($prodde);
                $Estadoemp->estadoemp1 = 2;
                $Estadoemp->save();

                $productos = UnidaddConsumoModel::find($prodd);
                $productos->estadoconsumo = 2;
                $productos->estado1 = 2;
                $productos->fechasalida = $fechasalidas;
                $productos->fecharetorno = $fecharetornod;
                $productos->idchofer = $prodde;
               
                $productos->save();


                $request->session()->flash('message', 'Registro Agregado',);
            } else {
                $request->session()->flash('message', 'El kilometraje esta mal');
            }
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('udetalle.index');
    }
    public function delete($id)
    {

        $detalles = DetalleSoluconsumoModel::find($id);
        $IDdetal = $detalles->idsoluconsumo;
        $IDcho = $detalles->idchofer;
        $IDunidad = $detalles->idunidadconsumo;

        $Estadoemp = EmpleadosModel::find($IDcho);
        $Estadoemp->estadoemp1 = 1;
        $Estadoemp->save();

        $producto = UnidaddConsumoModel::find($IDunidad);
        $producto->estadoconsumo = 1;
        $producto->estado1 = 1;
        $producto->save();

        $progrmi = SoluconsumoModel::find($IDdetal);
        $progrmi->estado3 = 1;
        $progrmi->save();

        $detalle = DetalleSoluconsumoModel::find($id);
        $detalle->delete();
        return redirect()->route('udetalle.index');
    }

    public function aprovar($id)
    {
        $detalle = DetalleSoluconsumoModel::find($id);

        $Idunidad = $detalle->idunidadconsumo;
        $Idsoluconsumo = $detalle->idsoluconsumo;

        // para vale
        $Codigoconsumo = $detalle->codigoconsumo;
        $Marcaconsumo = $detalle->marcaconsumo;
        $Placaconsumo = $detalle->placaconsum;

        $Kilometrajeactualconsumo = $detalle->kilometrajeactual;
        $Kiloanterior = $detalle->klmanterior;
        $Gasporklm = $detalle->gasporklm;

        //sacar id de chofer nombre y cargo
        $IdChoF = $detalle->idchofer;
        $NombreChof = $detalle->chofernombre;
        $CargoChof = $detalle->chofercargo;
        // para vale

        //para sacar cuanto de combustible nececita
        $CalAproxrest = $Kilometrajeactualconsumo - $Kiloanterior;
        $CalAprox = $CalAproxrest / $Gasporklm;

        //convertir a 2 decimales
        $CalAproxdos = number_format($CalAprox, 2);

        $productoS  = SoluconsumoModel::find($Idsoluconsumo);
        $Fechasalida = $productoS->fechasalida;
        $Fecharetorno = $productoS->fecharetorno;
        $Horasalida = $productoS->tsalidahr;
        $Horaretorno = $productoS->tllegadahr;

        // para vale
        $Idarea = $productoS->idarea;
        $Idprogram = $productoS->idprogramacomb;
        // $Idusuario = $productoS->idusuario;
        // $Usuariocargo = $productoS->usuariocargo;
        // $Usuarionombre = $productoS->usuarionombre;

        $Idlocalidad = $productoS->idlocalidad;
        $Codlocalidad = $productoS->codlocalidad;
        $Nombrelocalidad = $productoS->nombrelocalidad;
        $Distancialocalidad = $productoS->distancialocalidad;


        $Detallesouconsumo = $productoS->detallesouconsumo;

        // para vale

        $producto = UnidaddConsumoModel::find($Idunidad);
        $producto->estadoconsumo = 2;
        $producto->estado1 = 2;
        $producto->fechasalida = $Fechasalida;
        $producto->fecharetorno = $Fecharetorno;
        $producto->horasalida = $Horasalida;
        $producto->horaretorno = $Horaretorno;

        $producto->idchofer = $IdChoF;
        $producto->save();



        $soluconsumo = SoluconsumoModel::find($Idsoluconsumo);
        $soluconsumo->estadosoluconsumo = 3;

        $fechasolACT = Carbon::now();
        $soluconsumo->fechaprotrans = $fechasolACT;
        $hora = $fechasolACT->toTimeString();
        $soluconsumo->horaprobtrans = $hora;
        $soluconsumo->save();

        $soluconsumodoss = SoluconsumoModel::find($Idsoluconsumo);
        $FecHAsol = $soluconsumodoss->fechasol;
        $horasol = $soluconsumodoss->horasol;
        $numprev = $soluconsumodoss->cominterna;
        $Estadoemp = EmpleadosModel::find($IdChoF);
        $Estadoemp->estadoemp1 = 2;
        $Estadoemp->save();

        $vales = new ValeModel();
        //todo id  area
        $vales->idarea = $Idarea;
        //todo id vehiculo
        $vales->idunidad = $Idunidad;
        $vales->codigoconsumo = $Codigoconsumo;
        $vales->marcaconsumo = $Marcaconsumo;
        $vales->placaconsumo = $Placaconsumo;
        $vales->kilometrajeactualconsumo = $Kilometrajeactualconsumo;
        $vales->kiloanterior = $Kiloanterior;
        $vales->gasporklm = $Gasporklm;
        //todo id chofer
        $vales->idusuario = $IdChoF;
        $vales->usuariocargo = $CargoChof;
        $vales->usuarionombre = $NombreChof;


        //todo id localidad
        $vales->idlocalidad = $Idlocalidad;
        $vales->codlocalidad = $Codlocalidad;
        $vales->nombrelocalidad = $Nombrelocalidad;
        $vales->distancialocalidad = $Distancialocalidad;

        $vales->aproxgas = $CalAproxdos;
        $vales->detallesouconsumo = $Detallesouconsumo;

        $vales->fechasolicitud = $FecHAsol;
        $vales->horasoli = $horasol;
        $vales->estadovale = 1;
        $vales->estado1 = 1;
        $vales->estado2 = 1;
        $vales->estado3 = 1;
        $vales->estadotemp = 1;
        //todo id soluconsumo
        $vales->idsoluconsumo = $Idsoluconsumo;
        //todo id comingreso
        $vales->idcomingreso = 0;
        //todo id programa
        $vales->idprogramacomb = $Idprogram;
        $vales->idpartidacomb = 1;
        //todo numero preventivo
        $vales->numpreventivo = $numprev;
        
        $vales->save();

        return redirect()->route('udetalle.index2');
    }
}
