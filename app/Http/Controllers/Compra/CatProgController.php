<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Compra\CatProgModel;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;
class CatProgController extends Controller
{
    public function index()
    {
             
     return view('combustibles.catprog.index');

    }

    public function listado()
    {
        $data = DB::table('catprogramaticacomb') 
        -> where('estadocatprogramatica','=', 1);

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','combustibles.catprog.btn')
                ->rawColumns(['btn'])
                ->make(true);
  
    }

    public function create()
    {
        return view('combustibles.catprog.create');
    }
  
    public function store(Request $request)
    {
        $catprogs = new CatProgModel();
        $catprogs ->codcatprogramatica = $request->input('codigo');
        $catprogs ->nombrecatprogramatica = $request->input('nombre');
        $catprogs -> estadocatprogramatica = 1;
      
      
        if($catprogs->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
        }
        return view('combustibles.catprog.index');
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
        $catprogs = CatProgModel::find($idcatprogamaticacomb);
        $catprogs -> nombrecatprogramatica = $request->input('nombre');
        $catprogs -> codcatprogramatica = $request->input('codigo');
        
        if($catprogs->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
        return redirect('combustibles/catprog/index');
    }

  
    public function destroy($id)
    {
        
    }
}

