<?php

namespace App\Http\Controllers\Personerias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personerias\PersoneriasModel;
use App\Models\Personerias\ArchivoPersoneriaModel;


class PersoneriasController extends Controller
{
    public function index()
    {
       // return view('admin.employee')->with(['employees'=> Employee::paginate(15), 'schedules'=>Schedule::paginate(15)]);

        //return view('personerias.index')->with(['personerias'=> PersoneriasModel::paginate(15), 'archivopersoneria'=>ArchivoPersoneriaModel::paginate(15)]);
        return view('personerias.index')->with(['personerias'=> PersoneriasModel::where('tipo', '=', 1)->paginate(15), 'archivopersoneria'=>ArchivoPersoneriaModel::paginate(15)]);

    }

    public function indexAntiguo()
    {

        return view('personerias.index2')->with(['personerias'=> PersoneriasModel::where('tipo', '=', 2)->paginate(15), 'archivopersoneria'=>ArchivoPersoneriaModel::paginate(15)]);
    }

    public function indexActualizada()
    {

        return view('personerias.index3')->with(['personerias'=> PersoneriasModel::where('tipo', '=', 3)->paginate(15), 'archivopersoneria'=>ArchivoPersoneriaModel::paginate(15)]);
    }

    public function update2(Request $request,  $idpersoneria)
    {
        $personerias = PersoneriasModel::find($idpersoneria);

        $personerias->resoladmin = $request->resolucion;
        $personerias->solicitante = $request->solicitante;
        $personerias->tipo = $request->tipo;
        $personerias->estado = 1;
        $personerias->save();



       // session()->flash('message', 'Post successfully updated.');
       return redirect()->route('personerias.index')->with($request->session()->flash('message', 'Registro Procesado'));

        //return redirect()->route('personerias.index')->with('success','Registro Procesado!');
    }


    public function update(Request $request,  $idpersoneria)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $personerias = PersoneriasModel::find($idpersoneria);
            if ($request->file("documento") != null) {
           if ($request->hasFile("documento")) {
               $file = $request->file("documento");
               $file_name = $file->getClientOriginalName();
               $nombre = "pdf_" . time() . "." . $file->guessExtension();

               $ruta = public_path("personerias/" . $nombre);

               if ($file->guessExtension() == "pdf") {
                   copy($file, $ruta);
               } else {
                   return back()->with(["error" => "File not available!"]);
               }
           }
           $archivopersoneria = new ArchivoPersoneriaModel();
           //$archivopersoneria->idpersoneria = $personerias->idpersoneria;
           $archivopersoneria->nombrearchivo = 'personerias/' . $nombre;
            $archivopersoneria->save();

           //$personerias = new PersoneriasModel();
           $personerias->resoladmin = $request->resolucion;
           $personerias->solicitante = $request->solicitante;
           $personerias->idarchivopers = $archivopersoneria->idarchivopers;
           $personerias->tipo = $request->tipo;
           $personerias->estado = 1;
           $personerias->save();
           //dd($personerias->idpersoneria);
           return redirect()->route('personerias.index')->with($request->session()->flash('message', 'Registro Procesado'));


           }

           else {
            $personerias->resoladmin = $request->resolucion;
            $personerias->solicitante = $request->solicitante;
            //$personerias->idarchivopers = $archivopersoneria->idarchivopers;
            $personerias->tipo = $request->tipo;
            $personerias->estado = 1;
            $personerias->save();
            return redirect()->route('personerias.index')->with($request->session()->flash('message', 'Registro Procesado'));


           }
        }
           catch (\Throwable $th){
            return '[ERROR_500]';
           }finally{
           ini_restore('memory_limit');
           ini_restore('max_execution_time');
            }


        //return redirect()->route('personerias.index')->with('success','Registro Procesado!');
        //return redirect()->route('personerias.index')->with($request->session()->flash('message', 'Registro Procesado'));

    }

    public function create(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');


           if ($request->hasFile("documento")) {
               $file = $request->file("documento");
               $file_name = $file->getClientOriginalName();
               $nombre = "pdf_" . time() . "." . $file->guessExtension();

               $ruta = public_path("personerias/" . $nombre);

               if ($file->guessExtension() == "pdf") {
                   copy($file, $ruta);
               } else {
                   return back()->with(["error" => "File not available!"]);
               }
           }
           $archivopersoneria = new ArchivoPersoneriaModel();
           //$archivopersoneria->idpersoneria = $personerias->idpersoneria;
           $archivopersoneria->nombrearchivo = 'personerias/' . $nombre;
            $archivopersoneria->save();

           $personerias = new PersoneriasModel();
           $personerias->resoladmin = $request->resolucion;
           $personerias->solicitante = $request->solicitante;
           $personerias->idarchivopers = $archivopersoneria->idarchivopers;
           $personerias->tipo = $request->tipo;
           $personerias->estado = 1;
           $personerias->save();
           //dd($personerias->idpersoneria);


           } catch (\Throwable $th){
            return '[ERROR_500]';
           }finally{
           ini_restore('memory_limit');
           ini_restore('max_execution_time');
            }

        //return redirect()->route('personerias.index')->with('success','Registro Procesado!');
        return redirect()->route('personerias.index')->with($request->session()->flash('message', 'Registro Procesado'));

    }


    public function create2(Request $request,  $idpersoneria)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');


           if ($request->hasFile("documento")) {
               $file = $request->file("documento");
               $file_name = $file->getClientOriginalName();
               $nombre = "pdf_" . time() . "." . $file->guessExtension();

               $ruta = public_path("personerias/" . $nombre);

               if ($file->guessExtension() == "pdf") {
                   copy($file, $ruta);
               } else {
                   return back()->with(["error" => "File not available!"]);
               }
           }
           $archivopersoneria = new ArchivoPersoneriaModel();
           //$archivopersoneria->idpersoneria = $personerias->idpersoneria;
           $archivopersoneria->nombrearchivo = 'personerias/' . $nombre;
            $archivopersoneria->save();

           $personerias = new PersoneriasModel();
           $personerias->resoladmin = $request->resolucion;
           $personerias->solicitante = $request->solicitante;
           $personerias->idarchivopers = $archivopersoneria->idarchivopers;
           $personerias->tipo = $request->tipo;
           $personerias->estado = 1;
           $personerias->observacion = 'Actualizada de:'.$request->resolucionAntigua;
           $personerias->save();
           //dd($personerias->idpersoneria);
           $personeriaAntigua = PersoneriasModel::find($idpersoneria);
           $personeriaAntigua->observacion = 'Actualizada a:'.$request->resolucion;
           $personeriaAntigua->save();
           } catch (\Throwable $th){
            return '[ERROR_500]';
           }finally{
           ini_restore('memory_limit');
           ini_restore('max_execution_time');
            }

        //return redirect()->route('personerias.index')->with('success','Registro Procesado!');
        return redirect()->route('personerias.index')->with($request->session()->flash('message', 'Registro Procesado'));

    }



    public function borrar($idpersoneria)
    {

        $solicitud = PersoneriasModel::find($idpersoneria);
        $solicitud->delete();
       // return redirect()->route('personerias.index')->with('success','Registro Eliminado!');
        return redirect()->route('personerias.index')->with($request->session()->flash('message', 'Registro Procesado'));

    }


}
