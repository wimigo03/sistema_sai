<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Compra\ProveedorModel;
use App\Models\Compra\DocProveedoresModel;


use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Support\Facades\Auth;


class ProveedorController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('combustibles.proveedor.index', ['idd' => $personalArea]);
    }



    public function list()
    {
        $data = DB::table('proveedor')
            ->where('idproveedor', '!=', 1)
            ->where('estadoproveedor', '=', 1)
            ->orderBy('idproveedor', 'desc');
      
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'combustibles.proveedor.btn')
            ->addColumn('btn2', 'combustibles.proveedor.btn2')
            ->rawColumns(['btn','btn2'])
            ->make(true);
    }

    public function create()
    {

        return view('combustibles.proveedor.create');
    }
    public function store(Request $request)
    {
        $proveedores = new ProveedorModel();
        $proveedores->nombreproveedor = $request->input('nombre');
        $proveedores->representanteproveedor = $request->input('representante');
        $proveedores->cedulaproveedor = $request->input('cedula');
        $proveedores->validezciproveedor = $request->input('Ciexpiracion');
        $proveedores->nitciproveedor = $request->input('nitci');
        $proveedores->telefonoproveedor = $request->input('telefono');

        $proveedores->estadoproveedor = 1;


        if ($proveedores->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('proveedor.index');
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

    public function editar($idproveedor)
    {
        $proveedores = ProveedorModel::find($idproveedor);

        return view('combustibles/proveedor/edit')->with('proveedores', $proveedores);
    }

    public function update(Request $request, $idproveedor)
    {

        $proveedores = ProveedorModel::find($idproveedor);
        $proveedores->nombreproveedor = $request->input('nombre');
        $proveedores->representanteproveedor = $request->input('representante');
        $proveedores->cedulaproveedor = $request->input('cedula');
        $proveedores->validezciproveedor = $request->input('Ciexpiracion');
        $proveedores->nitciproveedor = $request->input('nitci');
        $proveedores->telefonoproveedor = $request->input('telefono');
        //$medida->update();
        if ($proveedores->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('proveedor.index');
    }


    public function editardoc($idproveedor)
    {
        //obtener las categorias
        $docproveedor = DB::table('docproveedores as d')
            ->join('proveedor as p', 'p.idproveedor', '=', 'd.idproveedor')
            ->select('d.nombredocumento', 'd.iddocproveedores', 'd.documento')
            ->orderBy('d.iddocproveedores', 'desc')
            ->where('d.idproveedor', '=', $idproveedor)->get();
            
        // dd($docproveedor);
        return view('combustibles.proveedor.docproveedor', ["docproveedor" => $docproveedor, "idproveedor" => $idproveedor]);
    }
  
    public function createdoc($idproveedor)
    {
       
        return view('combustibles.proveedor.createdocproveedor', ["idproveedor" => $idproveedor]);
    }

    public function insertar(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
           ini_set('max_execution_time','-1');

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
     
        $idproveedor = $request->input('proveedor');
      
        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/Documentos/" . $personalArea->nombrearea . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
             return back()->with(["error" => "File not available!"]);
            }
   
        }

        $docproveedor = new DocProveedoresModel();
        $docproveedor->nombredocumento = $request->input('nombredocumento');
        $docproveedor->documento = $personalArea->nombrearea . '/' . $nombre;
        $docproveedor->idproveedor = $idproveedor;
        $docproveedor->estadodocproveedores = 1;
        $docproveedor->save();
        return redirect()->route('proveedor.editardoc', [$idproveedor]);
    } catch (\Throwable $th){
        return '[ERROR_500]';
       }finally{
       ini_restore('memory_limit');
       ini_restore('max_execution_time');
        }
   }
     
    public function respuesta2(Request $request)    {
        $ot_antigua=$_POST['ot_antigua'];
            $data = "hola";
            $data2 = "holaSSSS";
            $validarci = DB::table('proveedor as s')
            ->select('s.cedulaproveedor')
           ->where('s.cedulaproveedor', $ot_antigua)
            ->get();
               if($validarci->count()>0){
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }

  
    public function editararchivo($iddocproveedores)
    {
        $docproveedor = DocProveedoresModel::find($iddocproveedores);
       
        return view('combustibles.proveedor.editardocproveedor', ["docproveedor" => $docproveedor]);
    
        
    }
    public function updatearchivoproveedor(Request $request, $iddocproveedores)
    {



        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $docproveedor = DocProveedoresModel::find($iddocproveedores);
        $idproveedor =  $docproveedor->idproveedor;
        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = "pdf_" . time() . "." . $file->guessExtension();

                $ruta = public_path("/Documentos/" . $personalArea->nombrearea . '/' . $nombre);

                if ($file->guessExtension() == "pdf") {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }
            $docproveedor->nombredocumento = $request->input('nombredocumento');
            $docproveedor->documento = $personalArea->nombrearea . '/' . $nombre;
            $docproveedor->save();

        } else {
            $docproveedor->nombredocumento = $request->input('nombredocumento');
            $docproveedor->save();
        }
        return redirect()->route('proveedor.editardoc', [$idproveedor]);
    }


 }


