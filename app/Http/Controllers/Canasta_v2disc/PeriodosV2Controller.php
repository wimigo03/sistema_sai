<?php

namespace App\Http\Controllers\Canasta_v2disc;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\CanastaDisc\Paquetes;
use App\Models\CanastaDisc\Periodos;
use App\Models\CanastaDisc\PaquetePeriodo;
use App\Models\CanastaDisc\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use PDF;
use Carbon\Carbon;

class PeriodosV2Controller extends Controller
{
    public function index($id_paquete)
    {
        $paquetes = Paquetes::find($id_paquete);
        $PaquetesPeriodos2 = PaquetePeriodo::select('id_periodo')->pluck('id_periodo','id_periodo');
        if ($PaquetesPeriodos2->isEmpty()) {
            $periodos= Periodos::all();
        } else {
            $periodos = DB::table('periodos')
                            ->whereNotIn('id', DB::table('paquete_periodo')
                            ->where('gestion',$paquetes->gestion)
                            ->pluck('id_periodo'))
                            ->select('id','mes')
                            ->get();
        }

        $PaquetesPeriodos = PaquetePeriodo::where('id_paquete',$id_paquete)->get();

        return view('canasta_v2.periodos.index', ["id_paquete" => $id_paquete,"PaquetesPeriodos" => $PaquetesPeriodos, "periodos" => $periodos]);

    }

    public function store(Request $request)
    {
        $id_paquete = $request->id_paquete;
        $paquetes = Paquetes::find($id_paquete);
        $paquetesPeriodo3 = new PaquetePeriodo;
        $paquetesPeriodo3->id_periodo = $request->periodo;
        $paquetesPeriodo3->id_paquete = $id_paquete;
        $paquetesPeriodo3->gestion = $paquetes->gestion;
        $paquetesPeriodo3->save();

        $paquetesPeriodo2 = PaquetePeriodo::select('id_periodo')->pluck('id_periodo','id_periodo');

        if ($paquetesPeriodo2->isEmpty()) {
            $periodos= Periodos::all();
        } else {
            $periodos = DB::table('periodos')
                    ->whereNotIn('id', DB::table('paquete_periodo')
                    ->where('gestion',$paquetes->gestion)
                    ->pluck('id_periodo'))
                    ->select('id', 'mes')
                    ->get();
        }

        $PaquetesPeriodos= PaquetePeriodo::where('id_paquete',$id_paquete)->get();

        return back();
    }

    public function finalizar($id_paquete)
    {
        $PaquetesPeriodos = DB::table('paquete_periodo as p')
                                ->join('periodos as pe', 'pe.id', 'p.id_periodo')
                                ->where('p.id_paquete', $id_paquete)
                                ->select('pe.mes')
                                ->get();

        $alex = '';

        if ($PaquetesPeriodos->isEmpty()) {

        } else {
            foreach ($PaquetesPeriodos as $data){
                $alex = $alex . "-" . $data->mes;
            }
            $paquetes = Paquetes::find($id_paquete);
            $paquetes->periodo = $alex;
            $paquetes->save();
        }

        return redirect()->route('paquetes.index')->with('info_message', 'Proceso finalizado.');
    }

    public function eliminar($id)
    {
        $PaquetesPeriodos= PaquetePeriodo::find($id);
        $PaquetesPeriodos->delete();
        return back();
    }
}
