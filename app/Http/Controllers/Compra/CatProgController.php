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
     
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $catprogs = new CatProgModel();
        $catprogs ->codcatprogramatica = $request->input('codigo');
        $catprogs ->nombrecatprogramatica = $request->input('nombre');
    
        $catprogs -> estadocatprogramatica = 1;
        $catprogs -> idusuario =$id;
        $catprogs -> idarea =$personalArea->idarea;
      
        if($catprogs->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        }else{
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

