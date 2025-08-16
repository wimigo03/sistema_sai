<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EleccionesController extends Controller
{
    public function index(Request $request)
    {
        $tiposGobernantes = [
            '4' => 'Presindenciales',
            '3' => 'Senadores',
            '2' => 'Diputados',
            '1' => 'Supraestatales',
        ];

        $zonas = [
            '1' => 'Urbana',
            '2' => 'Rural',
            '3' => 'Urbana y Rural',
        ];

        $tipoSeleccionado = $request->input('tipo', '4');
        $zonaSeleccionada = $request->input('zona', '3');

        $conteoVotaciones = DB::table('votos_por_mesa as a')
            ->select(
                'd.alias AS sigla',
                DB::raw('SUM(a.cantidad) as total_votos')
            )
            ->join('mesas as b', 'b.id', '=', 'a.mesa_id')
            ->join('recintos as c', 'c.id', '=', 'b.recinto_id')
            ->join('partidos_y_especiales as d', 'd.id', '=', 'a.partido_id')
            ->join('tipos_votacion as e', 'e.id', '=', 'a.tipo_votacion_id')
            ->where('a.estado', 1)
            ->where('b.estado', 1)
            ->where('c.estado', 1)
            ->where('d.estado', 1)
            ->where('e.id', $tipoSeleccionado)
            ->when($zonaSeleccionada !== '3', function ($query) use ($zonaSeleccionada) {
                return $query->where('c.zona', $zonaSeleccionada);
            })
            ->groupBy('d.alias')
            ->get();

        $totalVotosGeneral = $conteoVotaciones->sum('total_votos');

        return view('elecciones.index', compact('tiposGobernantes', 'zonas', 'conteoVotaciones', 'totalVotosGeneral', 'tipoSeleccionado', 'zonaSeleccionada'));
    }
}
