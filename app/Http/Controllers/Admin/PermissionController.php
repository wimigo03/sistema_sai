<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\Canasta\Dea;
use DB;

class PermissionController extends Controller
{
    private function completar_datos()
    {
        $permissions = Permission::get();
        foreach($permissions as $datos){
            $permission = Permission::find($datos->id);
            if (strpos($datos->name, ".") !== false) {
                $title = explode(".", $datos->name);
            } else {
                $title[0] = 'pendiente';
            }
            $permission->update([
                'title' => $title[0],
                'descripcion' => $datos->name
            ]);
        }

        dd("completar_datos finalizado...");
    }

    public function index()
    {
        //$this->completar_datos();
        $dea_id = Auth::user()->dea->id;
        $titulos = Permission::select('title')
                                    ->where('dea_id',$dea_id)
                                    ->groupBy('title')
                                    ->get();
        $permissions = Permission::query()
                                    ->ByDea($dea_id)
                                    ->orderBy('id','desc')
                                    ->paginate(10);
        return view('admin.permissions.index',compact('titulos','dea_id','permissions'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $titulos = Permission::select('title')
                                    ->where('dea_id',$dea_id)
                                    ->groupBy('title')
                                    ->get();
        $permissions = Permission::query()
                                    ->ByDea($dea_id)
                                    ->byTitulo($request->titulo)
                                    ->ByNombre($request->nombre)
                                    ->orderBy('id','desc')
                                    ->paginate(10);

        return view('admin.permissions.index',compact('titulos','dea_id','permissions'));
    }

    public function create($dea_id)
    {
        return view('admin.permissions.create',compact('dea_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dea_id' => 'required',
            'name' => 'required|unique:permissions,name,null,id,dea_id,' . $request->dea_id
        ]);

        if (strpos($request->name, ".") !== false) {
            $title = explode(".", $request->name);
        } else {
            return redirect()->back()->with('info_message', '[El formato que ha introducido no es el correcto...]')->withInput();
        }

        $permission = Permission::create([
            'title' => $title[0],
            'name' => $request->name,
            'dea_id' => $request->dea_id
        ]);

        return redirect()->route('permissions.index')->with('success_message','Se creo un registro en la tabla de permisos');
    }

    public function edit($permission_id)
    {
        $permission = Permission::find($permission_id);
        return view('admin.permissions.edit',compact('permission'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'dea_id' => 'required',
            'name' => 'required|unique:permissions,name,' . $request->permission_id . ',id,dea_id,' . $request->dea_id
        ]);

        if (strpos($request->name, ".") !== false) {
            $title = explode(".", $request->name);
        } else {
            return redirect()->back()->with('info_message', '[El formato que ha introducido no es el correcto...]')->withInput();
        }

        $permission = Permission::find($request->permission_id);
        $permission->update([
            'title' => $title[0],
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')->with('info_message','Se actualizo un registro en la tabla de permisos');
    }

    public function show($permission_id)
    {
        $permission = Permission::find($permission_id);
        $roles_permissions = DB::table('role_permissions as a')
                                    ->join('roles as b','b.id','a.role_id')
                                    ->where('a.permission_id',$permission_id)
                                    ->select('a.role_id','a.permission_id','b.title')
                                    ->get();
        return view('admin.permissions.show',compact('permission','roles_permissions'));
    }

    public function delete($role_id, $permission_id)
    {
        $role_permission = DB::table('role_permissions')->where('role_id',$role_id)->where('permission_id',$permission_id)->delete();
        return redirect()->route('permissions.show',$permission_id)->with('info_message','Permiso eliminado...');
    }
}
