<?php

namespace App\Http\Controllers\Canasta_v2disc;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
//use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Redirect;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
//use App\Models\Canasta\Barrio;
use App\Models\CanastaDisc\Entrega;
//use App\Models\Canasta\Distrito;
//use App\Models\Canasta\Beneficiario;
//use App\Models\Canasta\Ocupaciones;
//use App\Models\Canasta\Paquetes;
//use App\Models\Canasta\BarrioEntrega;
//use App\Models\Canasta\Periodos;
//use App\Models\Canasta\PaquetePeriodo;
//use App\Models\Canasta\Dea;
//use App\Http\Requests;
//use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
//use App\Models\Canasta\PaqueteBarrio;
//use App\Models\User;
use PDF;
use DB;

class EntregaBeneficiarioV2Controller extends Controller
{
    public function index()
    {
        return view('canasta_v2.entrega-beneficiario.index');
    }

    public function search(Request $request)
    {
        $entrega = Entrega::query()
                            ->byDea(Auth::user()->dea->id)
                            ->byCodigo($request->codigo)
                            ->first();

        return view('canasta_v2.entrega-beneficiario.index', compact('entrega'));
    }
}
