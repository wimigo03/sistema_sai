<?php

namespace App\Http\Controllers\Canasta_v2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Canasta\Entrega;
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
