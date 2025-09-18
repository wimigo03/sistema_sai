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
use App\Models\Recinto;

class EleccionesController extends Controller
{
    public function index(Request $request)
    {
        $tiposGobernantes = [
            '1' => 'Presidenciales',
            '2' => 'Diputados'
        ];

        $zonas = [
            '3' => 'Urbana y Rural',
            '1' => 'Urbana',
            '2' => 'Rural',
        ];

        // Se obtiene una lista de recintos electorales para el filtro
        $recintosElectorales = Recinto::pluck('nombre', 'id');

        // Se añade la opción "Todos" al inicio del array de recintos
        $recintosElectorales->prepend('Todos los Recintos Electorales', 'all');

        $tipoSeleccionado = $request->input('tipo', '1');
        $zonaSeleccionada = $request->input('zona', '3');
        $recintoSeleccionado = $request->input('recinto', 'all'); // Nueva variable para el recinto seleccionado

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
            // Nuevo filtro para recintos electorales
            ->when($recintoSeleccionado !== 'all', function ($query) use ($recintoSeleccionado) {
                return $query->where('c.id', $recintoSeleccionado);
            })
            ->groupBy('d.alias')
            ->orderBy('total_votos', 'desc')
            ->get();

        $totalVotosGeneral = $conteoVotaciones->sum('total_votos');

        return view('elecciones.index', compact(
            'tiposGobernantes',
            'zonas',
            'recintosElectorales',
            'conteoVotaciones',
            'totalVotosGeneral',
            'tipoSeleccionado',
            'zonaSeleccionada',
            'recintoSeleccionado'
        ));
    }
}
