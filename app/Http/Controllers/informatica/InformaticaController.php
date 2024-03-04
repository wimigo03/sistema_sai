<?php

namespace App\Http\Controllers\informatica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\informatica\InformeModel;
use App\Models\sereges\UserAlbergueModel;
use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\sereges\SeregesModel;
use App\Models\sereges\FotoRegistroModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\Canasta\Dea;
use Carbon\Carbon;

class InformaticaController extends Controller
{
    public function index()
    {


        return view('informatica.registro_index')->with(['informe'=> InformeModel::where('estado', '=', 1)->paginate(15)]);

    }
}
