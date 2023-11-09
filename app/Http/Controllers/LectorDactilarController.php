<?php

namespace App\Http\Controllers;

use App\Models\LectorDactilarModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;

class LectorDactilarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = LectorDactilarModel::where('estado', 1);
            $data = $data->get();

            return DataTables::of($data)

               
                ->addColumn('opciones', function ($row) {
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Ausencia" href="#" data-toggle="modal" data-target="#miModal" data-id="' . $row->id . '">
                                <i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
                            </a>';
                })
                
                
                ->rawColumns(['opciones'])

                ->make(true);
        }

        return view('asistencias.lector.index');
    }
}
