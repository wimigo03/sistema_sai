<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProveedoresModel;
use App\Models\DocProveedorModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


   //index
   public function index()
    {

     return view('compras.proveedores.index');

    }



    public function list()
    {
          //obtener las categorias
          $data = DB::table('proveedores')
          -> where('idproveedor','!=', 1)
          -> where('estadoproveedor','=', 1);
          //-> get();
           //return view('compras.proveedores.index', ["proveedores" => $proveedores]);
           return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','compras.proveedores.btn')
                ->rawColumns(['btn'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proveedores = new ProveedoresModel();
        $proveedores -> nombreproveedor = $request->input('nombre');
        $proveedores -> representante = $request->input('representante');
        $proveedores -> cedula = $request->input('cedula');
        $proveedores -> validezci = $request->input('Ciexpiracion');
        $proveedores -> nitci = $request->input('nitci');
        $proveedores -> telefonoproveedor = $request->input('telefono');

        $proveedores -> estadoproveedor = 1;


        if($proveedores->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('proveedores.index');
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
    public function edit($idproveedor){
        $proveedores = ProveedoresModel::find($idproveedor);

         return view('compras/proveedores/edit')->with('proveedores', $proveedores);

      }

      public function editardoc($idproveedor){
        //obtener las categorias
        $docproveedor = DB::table('docproveedor as d')
        ->join('proveedores as p', 'p.idproveedor', '=', 'd.idproveedor')
        ->select('d.nombredocumento','d.iddocproveedor','d.documento')
        -> where('d.idproveedor','=', $idproveedor)-> get();
       // dd($docproveedor);
         return view('compras.proveedores.docproveedor', ["docproveedor" => $docproveedor,"idproveedor" => $idproveedor]);


      }



      /**llamar a la vista create.. */
public function create()
{

    return view('compras.proveedores.create');
   // return view("compras.productos.create");
}

public function createdoc($idproveedor)
{
   // dd($idproveedor);
    //return redirect('compras/proveedores/createdocproveedor');
    return view('compras.proveedores.createdocproveedor', ["idproveedor" => $idproveedor]);
}


public function insertar(Request $request)
{

   // return view('compras.proveedores.docproveedor');
   // return view("compras.productos.create");
   //return redirect('compras/proveedores/docproveedor');
   //return ('compras/proveedores/docproveedor');
   $idproveedor=$request->input('proveedor');
  // dd($idproveedor);
   //return redirect()->action('App\Http\Controllers\ProveedoresController@editardoc', ['idproveedor' => $idproveedor]);
   //return view('admin.users.edit', compact('idproveedor',  $idproveedor));

   if($request->hasFile("documento")){
    $file=$request->file("documento");
    $file_name = $file->getClientOriginalName();
    $nombre = "pdf_".time().".".$file->guessExtension();

    $ruta = public_path("/Archivos/".$nombre);

    if($file->guessExtension()=="pdf"){
        copy($file, $ruta);
    }else{
        return back()->with(["error"=>"File not available!"]);
    }



}


//$nombre2='hola';
   $docproveedor = new DocProveedorModel();
   $docproveedor -> nombredocumento = $request->input('nombredocumento');
   $docproveedor -> documento = $nombre;
   $docproveedor -> idproveedor =$idproveedor;
   $docproveedor -> estadodocproveedor = 1;


   $docproveedor->save();


   return redirect()->action('App\Http\Controllers\ProveedoresController@editardoc', [$idproveedor]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idproveedor)
    {

    $proveedores = ProveedoresModel::find($idproveedor);
    $proveedores -> nombreproveedor = $request->input('nombre');
    $proveedores -> representante = $request->input('representante');
    $proveedores -> cedula = $request->input('cedula');
    $proveedores -> validezci = $request->input('Ciexpiracion');
    $proveedores -> nitci = $request->input('nitci');
    $proveedores -> telefonoproveedor = $request->input('telefono');
    //$medida->update();
    if($proveedores->save()){
      $request->session()->flash('message', 'Registro Procesado');
  }else{
      $request->session()->flash('message', 'Error al Procesar Registro');
  }
    return redirect('compras/proveedores/index');
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
