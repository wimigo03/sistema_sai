<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Afiliado;
use App\Models\Entrega;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;

class CanastaEntregaController extends Controller
{
    public function index()
    {
        $entregas = Entrega::paginate(10);
        return view('discapacidad.index', compact('entregas'));
    }

    public function search(Request $request)
    {
        $entregas = Entrega::query()
            ->byNroCarnet($request->nro_carnet)
            ->byNombres($request->nombres)
            ->byApellidos($request->apellidos)
            ->byEdad($request->edad)
            ->byBarrio($request->barrio)
            ->byCarnetDiscapacitado($request->carnet_disc)
            ->byFechas($request->fecha_desde, $request->fecha_hasta)
            ->orderBy('codigo', 'desc')
            ->paginate(10);
        return view('discapacidad.index', compact('entregas'));
    }
}
