<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Compra\CatProgModel;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class CatProgController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('combustibles.catprog.index', ['idd' => $personalArea]);
    }

    public function listado(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('catprogramaticacomb as cat')
                ->select(['cat.estadocatprogramatica', 'cat.idcatprogramaticacomb', 'cat.codcatprogramatica',
                        'cat.nombrecatprogramatica','cat.fechacat', 'cat.gestioncat'])
                ->where('cat.idcatprogramaticacomb', '!=', 1)
                ->orderBy('cat.idcatprogramaticacomb', 'asc');
            $data = $data->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('fechacat', function ($data) {
                    return $data->fechacat;
                })
                ->addColumn('gestioncat', function ($data) {
                    return $data->gestioncat;
                })
                ->addColumn('idcatprogramaticacomb', function ($data) {
                    return $data->idcatprogramaticacomb;
                })
                ->addColumn('codcatprogramatica', function ($data) {
                    return $data->codcatprogramatica;
                })
                ->addColumn('nombrecatprogramatica', function ($data) {
                    return $data->nombrecatprogramatica;
                })
                ->addColumn(
                    'estadocatprogramatica',
                    function ($data) {

                        switch ($data->estadocatprogramatica) {


                            case '1':
                                return '<b style="color: green">ACTIVO</b>';

                            case '2':
                                return '<b style="color: red">INACTIVO</b>';
                            default:

                                break;
                        }
                    }
                )

                ->addColumn('actions', function ($data) {

                    return '<a class="tts:left tts-slideIn tts-custom" aria-label=" Editar" href="' . route('catprogcomb.edit', $data->idcatprogramaticacomb) . '">
                    <button class="btn btn-sm btn-primary font-verdana" type="button">
                        <i class="fa fa-pencil fa-fw"></i>
                    </button>
                </a>';
                })


                ->rawColumns(['estadocatprogramatica', 'actions'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('combustibles.catprog.create');
    }

    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $catprogs = new CatProgModel();

        $catprogs->codcatprogramatica = $request->input('codigo');
        $catprogs->nombrecatprogramatica = $request->input('nombre');

        $catprogs->estadocatprogramatica = 1;
        $catprogs->idusuario = $id;
        $catprogs->idarea = $personalArea->idarea;

        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $hora = $fechasolACT->toTimeString();

        $catprogs->fechacat = $fechasolACT;
        $catprogs->horacat = $hora;
        $catprogs->gestioncat = $gesti;

        if ($catprogs->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }
        return redirect()->route('catprogcomb.index');
    }

    public function show($id)
    {
    }


    public function editar($idcatprog)
    {
        $catprogs = CatProgModel::find($idcatprog);
       

        return view('combustibles/catprog/edit')->with('catprogs', $catprogs);
    }


    public function update(Request $request, $idcatprogamaticacomb)
    {
        $id6fech = $request->input('id4');
        $gestionant = substr($id6fech, 0, 4);
        $mesant = substr($id6fech, 5, 2);
        $diaant = substr($id6fech, 8, 2);
        $Fechaanter = $diaant . "-" . $mesant . "-" . $gestionant;

        $fechasol = $request->get('fechasoli');
        $gestion = substr($fechasol, 6, 4);
        $mes = substr($fechasol, 3, 2);
        $dia = substr($fechasol, 0, 2);
        $Fechaactual = $dia . "-" . $mes . "-" . $gestion;

        $catprogs = CatProgModel::find($idcatprogamaticacomb);
        $catprogs->nombrecatprogramatica = $request->input('nombre');
        $catprogs->codcatprogramatica = $request->input('codigo');
        $catprogs->estadocatprogramatica = $request->input('estado');
        $fechasolACTe = Carbon::now();
        $hora = $fechasolACTe->toTimeString();

        if ($Fechaanter == $Fechaactual) {
            $catprogs->fechacat = $request->get('fechasoli');
        } else {
            $catprogs->fechacat = $request->get('fechasoli');
            $catprogs->horacat = $hora;
            $catprogs->gestioncat = $gestion;
        }

        if ($catprogs->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('catprogcomb.index');
    }


    public function destroy($id)
    {
    }
    public function respuesta8(Request $request)
    {
        $ot_antigua = $_POST['ot_antigua'];
        $data = "hola";
        $data2 = "holaSSSS";
        $validarci = DB::table('catprogramaticacomb as s')
            ->select('s.codcatprogramatica')
            ->where('s.codcatprogramatica', $ot_antigua)
            ->get();
        if ($validarci->count() > 0) {
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }
}
