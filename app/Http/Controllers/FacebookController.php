<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Facebook;
use App\Models\FacebookDetalle;
use App\Models\NivelModel;
use App\Models\PersonalFace;
use DB;
use PDF;
use App\Models\Area;

class FacebookController extends Controller
{

    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $publicaciones = Facebook::query()
                                ->ByDea($dea_id)
                                ->where('estado','!=','3')
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Facebook::ESTADOS;
        return view('facebook.index', compact('dea_id','publicaciones','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $publicaciones = Facebook::query()
                                ->ByDea($dea_id)
                                ->ByFecha($request->fecha)
                                ->ByTitulo($request->titulo)
                                ->ByEstado($request->estado)
                                ->where('estado','!=','3')
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Facebook::ESTADOS;
        return view('facebook.index', compact('dea_id','publicaciones','estados'));
    }

    public function cargar_datos($id)
    {
        $facebook = Facebook::find($id);
        $facebook_detalles = FacebookDetalle::where('facebook_id',$id)->orderBy('id','asc')->get();
        $cont = 1;
        return view('facebook.cargar-datos', compact('facebook','facebook_detalles','cont'));
    }

    public function actualizar_datos(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                if(isset($request->share)){
                    $shares = FacebookDetalle::whereIn('id',$request->share)->get();
                    foreach($shares as $share){
                        $share_detalle = FacebookDetalle::find($share->id);
                        $share_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_share' => '1'
                        ]);
                    }
                    $no_shares = FacebookDetalle::whereNotIn('id',$request->share)->get();
                    foreach($no_shares as $share){
                        $share_detalle = FacebookDetalle::find($share->id);
                        $share_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_share' => '2'
                        ]);
                    }
                }else{
                    $shares = FacebookDetalle::where('facebook_id',$request->facebook_id)->get();
                    foreach($shares as $share){
                        $share_detalle = FacebookDetalle::find($share->id);
                        $share_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_share' => '2'
                        ]);
                    }
                }

                if(isset($request->like)){
                    $likes = FacebookDetalle::whereIn('id',$request->like)->get();
                    foreach($likes as $like){
                        $like_detalle = FacebookDetalle::find($like->id);
                        $like_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_like' => '1'
                        ]);
                    }
                    $no_likes = FacebookDetalle::whereNotIn('id',$request->like)->get();
                    foreach($no_likes as $like){
                        $like_detalle = FacebookDetalle::find($like->id);
                        $like_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_like' => '2'
                        ]);
                    }
                }else{
                    $likes = FacebookDetalle::where('facebook_id',$request->facebook_id)->get();
                    foreach($likes as $like){
                        $like_detalle = FacebookDetalle::find($like->id);
                        $like_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_like' => '2'
                        ]);
                    }
                }

                if(isset($request->comment)){
                    $comments = FacebookDetalle::whereIn('id',$request->comment)->get();
                    foreach($comments as $comment){
                        $comment_detalle = FacebookDetalle::find($comment->id);
                        $comment_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_comment' => '1'
                        ]);
                    }
                    $no_comments = FacebookDetalle::whereNotIn('id',$request->comment)->get();
                    foreach($no_comments as $comment){
                        $comment_detalle = FacebookDetalle::find($comment->id);
                        $comment_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_comment' => '2'
                        ]);
                    }
                }else{
                    $comments = FacebookDetalle::where('facebook_id',$request->facebook_id)->get();
                    foreach($comments as $comment){
                        $comment_detalle = FacebookDetalle::find($comment->id);
                        $comment_detalle->update([
                            'user_id' => Auth::user()->id,
                            '_comment' => '2'
                        ]);
                    }
                }

                return redirect()->route('facebook.cargar.datos',$request->facebook_id)->with('success_message', 'Se actualizaron los datos correctamente...');
        } finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function create($dea_id)
    {
        return view('facebook.create', compact('dea_id'));
    }

    public function store(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $datos = Facebook::create([
                    'dea_id' => $request->dea_id,
                    'titulo' => $request->nombre,
                    'fecha' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha))),
                    'publicacion' => $request->enlace,
                    'estado' => '1'
                ]);

                $empleados = Empleado::where('estado','1')->get();
                foreach($empleados as $empleado){
                    $datos_detalle = FacebookDetalle::create([
                        'facebook_id' => $datos->id,
                        'dea_id' => $empleado->dea_id,
                        'idemp' => $empleado->idemp,
                        'idarea' => $empleado->idarea,
                        '_share' => '2',
                        '_like' => '2',
                        '_comment' => '2',
                        'estado' => '1'
                    ]);
                }

                return redirect()->route('facebook.index')->with('success_message', 'Operacion realizada correctamente..');
        } finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function habilitar($facebook_id)
    {
        $facebook = Facebook::find($facebook_id);
        $facebook->update([
            'estado' => '1'
        ]);

        return redirect()->route('facebook.index')->with('success_message', 'Operacion realizada correctamente..');
    }

    public function deshabilitar($facebook_id)
    {
        $facebook = Facebook::find($facebook_id);
        $facebook->update([
            'estado' => '2'
        ]);

        return redirect()->route('facebook.index')->with('success_message', 'Operacion realizada correctamente..');
    }

    public function eliminar($facebook_id)
    {
        $facebook = Facebook::find($facebook_id);
        $facebook->update([
            'estado' => '3'
        ]);

        return redirect()->route('facebook.index')->with('success_message', 'Operacion realizada correctamente..');
    }
}
