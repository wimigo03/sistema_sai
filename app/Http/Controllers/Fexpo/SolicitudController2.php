<?php

namespace App\Http\Controllers\Fexpo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\RubroModel;
use App\Models\Fexpo\CredencialModel;
use DB;
use App\Models\Fexpo\SolicitudModel;
use Carbon\Carbon;
use DataTables;

use NumerosEnLetras;
use PDF;

use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\TipoAreaModel;
use App\Models\AnioModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use RealRashid\SweetAlert\Facades\Alert;


class SolicitudController2 extends Controller
{

    public function index()
    {
       // return view('admin.employee')->with(['employees'=> Employee::paginate(15), 'schedules'=>Schedule::paginate(15)]);

        return view('expochaco3.index')->with(['solicitud'=> SolicitudModel::paginate(15), 'rubros'=>RubroModel::paginate(15)]);
    }


    public function update(Request $request,  $idsolicitud)
    {
        $solicitud = SolicitudModel::find($idsolicitud);

        $solicitud->nombresolicitud = $request->nombre;
        $solicitud->idrubro = $request->rubros;
        $solicitud->save();



       // session()->flash('message', 'Post successfully updated.');
        return redirect()->route('expochaco3.index')->with('success','Registro Procesado!');
    }


    public function borrar($idsolicitud)
    {

        $solicitud = SolicitudModel::find($idsolicitud);
        $solicitud->delete();
        return redirect()->route('expochaco3.index')->with('success','Registro Eliminado!');

    }

}
