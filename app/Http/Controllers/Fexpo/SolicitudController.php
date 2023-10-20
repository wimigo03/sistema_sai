<?php

namespace App\Http\Controllers\Fexpo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Fexpo\RubroModel;
use DB;
use App\Models\Fexpo\SolicitudModel;
use Carbon\Carbon;
use DataTables;
class SolicitudController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {

        $solicitud = DB::table('solicitud as s')

                        // ->join('rubros as r', 'r.idrubro', '=', 's.idrubro')


                        ->where('s.estadosolicitud',1)

                        ->select('s.idsolicitud','s.nombresolicitud','s.asociacionsol',
                        's.telefonosol',
                        's.correosol'

                        )->orderBy('s.idsolicitud', 'asc');

                        return Datatables::of($solicitud)
                        ->addIndexColumn()
                        ->addColumn('btn', 'expochaco.btn')
                        ->addColumn('btn2', 'expochaco.btn2')
                        ->addColumn('btn3', 'expochaco.btn3')
                        ->rawColumns(['btn','btn2','btn3'])
                        ->make(true);

                    }

            return view('expochaco.index');
    }

    public function create(){
        $rubros = DB::table('rubro as r')
            //->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
            // ->join('areas as a', 'a.idarea', '=', 'd.idarea')
            ->select('r.idrubro', 'r.nombrerubro')
            //->where('d.idarea', $personalArea->idarea)
            //->where('d.estadoderiv1', 1)

            ->get();


        return view('expochaco.create', ["rubros" => $rubros]);

       // return view('expochaco.create');
    }

    public function store(Request $request){

        $solicitud = new SolicitudModel();

        $solicitud->nombresolicitud = $request->input('nombresolicitud');
        $solicitud->asociacionsol = $request->input('asociacionsol');
        $date = Carbon::now();
        $solicitud->ci = $request->input('ci');

        $solicitud->direccionsol = $request->input('direccionsol');
        $solicitud->telefonosol = $request->input('telefonosol');
        $solicitud->correosol = $request->input('correosol');
        $solicitud->idrubro = $request->input('idrubro');
        $solicitud->correosol = $request->input('correosol');
        $solicitud->fechasolicitud = $date;
        $solicitud->pabellon = $request->input('pabellon');
        $solicitud->superficie = $request->input('superficie');
        $solicitud->precio = $request->input('precio');
        $solicitud->representante = $request->input('representante');
        $solicitud->stand = $request->input('cantidad');
        $solicitud->total = $request->input('cantidad') * $request->input('precio');
        $solicitud->unidsep = $request->input('unidsep');
        $solicitud->representante = $request->input('representante');
        $solicitud->cirepresentante = $request->input('cirepresentante');

        $solicitud->estadosolicitud = 1;

        if($solicitud->save()){
            $request->flash('message', 'Registro Procesado');
            return view('expochaco.fin');
        }else{
            $request->flash('message', 'Error al Procesar Registro');
        }

    }


    public function editar($idsolicitud){
        $solicitud = SolicitudModel::find($idsolicitud);


        return view('expochaco.editar',

        compact('solicitud'));
    }

    public function update(Request $request){



        $solicitud = SolicitudModel::find($request->idsolicitud);

         $solicitud->nombresolicitud = $request->input('nombresolicitud');
        $solicitud->asociacionsol = $request->input('asociacionsol');

        $solicitud->ci = $request->input('ci');

        $solicitud->direccionsol = $request->input('direccionsol');
        $solicitud->telefonosol = $request->input('telefonosol');
        $solicitud->correosol = $request->input('correosol');
        $solicitud->idrubro = $request->input('idrubro');


        if($solicitud->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('expochaco.index');
    }


    public function delete($id)
    {
        $solicitud = SolicitudModel::find($id);
        $solicitud->delete();

        return redirect()->route('expochaco.index');
    }

    public function aprovar($id)
    {


        $solicitud = SolicitudModel::find($id);
        $solicitud->estadosolicitud = 2;
        $solicitud->save();



        return redirect()->route('expochaco.index');


    }





}

