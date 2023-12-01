<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\ArchivoAdjuntoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
class ArchivoAdjuntoController extends Controller
{
    public function index()
    {

        return view('activo.archivoadjunto.index');
    }

  public function listado()
    {

        $data = DB::table('archivosadjuntos')
        -> where('estadoarchivosadjuntos','=', 1);
       // -> get();

        return datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','activo.archivoadjunto.btn')
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
        return view('activo.archivoadjunto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $archivosadjuntos = new ArchivoAdjuntoModel();
        $archivosadjuntos ->nombrearchivo = $request->input('nombrearchivo');
        $archivosadjuntos ->ruta= $request->input('ruta');
        $archivosadjuntos -> estadoarchivosadjuntos = 1;
      
      
        if($archivosadjuntos->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('archivoadjunto.index');
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
    public function editar($idarchivosadjuntos)
    {
        $archivosadjuntos = ArchivoAdjuntoModel::find($idarchivosadjuntos);
  
        return view('activo/archivoadjunto/edit')->with('archivosadjuntos', $archivosadjuntos);
    }
  


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idarchivosadjuntos)
    {

        $archivosadjuntos = ArchivoAdjuntoModel::find($idarchivosadjuntos);
        $archivosadjuntos ->nombrearchivo = $request->input('nombrearchivo');
        $archivosadjuntos ->ruta= $request->input('ruta');
        $archivosadjuntos -> estadoarchivosadjuntos = 1;

        
        if($archivosadjuntos->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return view('activo/archivoadjunto/index')->with('archivosadjuntos', $archivosadjuntos);
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
