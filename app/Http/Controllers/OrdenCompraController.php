<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
/*use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Models\CompraModel;
use App\Models\DetalleCompraModel;
use App\Models\Canasta\Dea;
use App\Models\ProveedoresModel;*/
/*use App\Models\User;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\TemporalModel;
use App\Models\EncargadosModel;
use App\Models\CatProgModel;
use App\Models\ProgramaModel;
use App\Models\ProdServModel;
*/
use DB;

class OrdenCompraController extends Controller
{
    public function index()
    {dd("okoko");
        $empleado = Empleado::find(Auth::user()->idemp);
        $estados = CompraModel::ESTADOS_COMPRA;
        $areas = Area::pluck('nombrearea','idarea');
        $programas = ProgramaModel::pluck('nombreprograma','idprograma');
        $programaticas = CatProgModel::select(DB::raw("concat(codcatprogramatica,'_',nombrecatprogramatica) as categoria_programatica"),'idcatprogramatica')->pluck('categoria_programatica','idcatprogramatica');
        $compras = CompraModel::query()
                                    ->byDea(Auth::user()->dea->id)
                                    ->where('idarea',$empleado->idarea)
                                    ->orderBy('idcompra', 'desc')
                                    ->paginate(10);
        return view('compras.pedidoparcial.index', compact('estados','compras','areas','programas','programaticas'));
    }

    public function search(Request $request)
    {dd($request->all());

    }

    public function create($solicitud_id)
    {
        $dea = Dea::where('id',Auth::user()->dea_id)->first();
        $solicitud = CompraModel::find($solicitud_id);
        $solicitud_detalle = DetalleCompraModel::where('idcompra',$solicitud_id)->where('estado',1)->get();
        $subtotal = $solicitud_detalle->sum('subtotal');
        $proveedores = ProveedoresModel::pluck('nombreproveedor','idproveedor');
        return view('orden-compras.create', compact('dea','solicitud','solicitud_detalle','subtotal','proveedores'));
    }
}
