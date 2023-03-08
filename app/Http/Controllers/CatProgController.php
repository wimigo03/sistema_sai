<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatProgModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;


class CatProgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //index
    public function index()
    {
             
     return view('compras.catprog.index');

    }

    public function listado()
    {
        $data = DB::table('catprogramatica') 
        -> where('estadocatprogramatica','=', 1);
       // -> get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','compras.catprog.btn')
                ->rawColumns(['btn'])
                ->make(true);
  ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compras.catprog.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $catprogs = new CatProgModel();
        $catprogs ->codcatprogramatica = $request->input('nombre');
        $catprogs ->nombrecatprogramatica = $request->input('codigo');
       
        
        $catprogs -> estadocatprogramatica = 1;
      
      
        if($catprogs->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('catprog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($idcatprog)
    {
        $catprogs = CatProgModel::find($idcatprog);
    
        return view('compras/catprog/edit')->with('catprogs', $catprogs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idcatprogamatica)
    {
        $catprogs = CatProgModel::find($idcatprogamatica);
        $catprogs -> nombrecatprogramatica = $request->input('nombre');
        $catprogs -> codcatprogramatica = $request->input('codigo');
        
        //$medida->update();
        if($catprogs->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
        return redirect('compras/catprog/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
