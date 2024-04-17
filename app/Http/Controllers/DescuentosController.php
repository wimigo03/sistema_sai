<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfigDescuentoRequest;
use App\Http\Requests\UpdateConfigDescuentoRequest;
use App\Models\ConfigHorario;
use App\Models\DescuentoModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class DescuentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $descuentos = DescuentoModel::select(['id', 'descripcion', 'retraso_max', 'cantidad_dia']);
        $HorarioConfig = ConfigHorario::first();

//dd( $HorarioConfig);
         if ($request->ajax()) {
            $descuentos  = $descuentos->get();
            return DataTables::of($descuentos)

                ->addColumn('descripcion', function ($descuento) {
                    return $descuento->descripcion ?: '-';
                })
                ->addColumn('tiempo', function ($descuento) {
                    return $descuento->retraso_max ?: '-';
                })
                ->addColumn('cantidad', function ($descuento) {
                    return $descuento->cantidad_dia;
                })
                ->addColumn('actions', function ($descuento) {
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar" href="' . route('descuentos.edit', $descuento->id) . '">
                    <i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
                </a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('asistencias.descuentos.index', compact('HorarioConfig'));
    }

    public function detalleEmpleado(Request $request)
    {
        //

    }

    public function config(StoreConfigDescuentoRequest $request)
    {
        $request->validated();

        $nuevoRegistro = new ConfigHorario(); // Reemplaza 'TuModelo' con el nombre de tu modelo
        $nuevoRegistro->jornadamax = $request->maxima;

        $nuevoRegistro->jornadamin = $request->minima;
        $nuevoRegistro->iniciomax = $request->inicio;
        $nuevoRegistro->marcadomax = $request->marcado;

        // Guardar el registro en la base de datos
        $nuevoRegistro->save();
        return redirect()->back()->with('success', 'Configuracion Creada exitosamente.');

    }
    public function configUpdate(UpdateConfigDescuentoRequest $request,ConfigHorario $id)
    {
        $request->validated(); // Validar los datos del request
        // Encontrar el registro existente en la base de datos
    
        $id->update([
            'jornadamax' => $request->maxima,
            'jornadamin' => $request->minima,
            'iniciomax' => $request->inicio,
            'marcadomax' => $request->marcado,
        ]);
    
        // Redirigir de vuelta a la página anterior con un mensaje de éxito
        return redirect()->back()->with('success', 'Configuración actualizada exitosamente.');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('asistencias.descuentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tiempo_min' => 'required',
            'descripcion' => 'required',
            'dia' => 'required',
        ]);

        $descuento = new DescuentoModel();
        $descuento->retraso_max = $request->input('tiempo_min');
        $descuento->descripcion = $request->input('descripcion');
        $descuento->cantidad_dia = $request->input('dia');



        $descuento->save();
        return redirect()->route('descuentos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $descuento = DescuentoModel::findOrFail($id);
        return view('asistencias.descuentos.show', compact('descuento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DescuentoModel $descuento)
    {
        return view('asistencias.descuentos.edit', compact('descuento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DescuentoModel $descuento)
    {
        //
        $request->validate([
            'tiempo_min' => 'required',
            'descripcion' => 'required',
            'dia' => 'required',
        ]);


        $descuento->retraso_max = $request->input('tiempo_min');
        $descuento->descripcion = $request->input('descripcion');
        $descuento->cantidad_dia = $request->input('dia');

        $descuento->save();
        return redirect()->route('descuentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
