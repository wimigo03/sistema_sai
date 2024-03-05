<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Requests\StoreRoleRequest;
//use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Canasta\Dea;
use DB;

class RoleController extends Controller
{

    public function index()
    {
        $unidades = Dea::pluck('descripcion','id');
        $estados = Role::ESTADOS;
        $roles = Role::orderBy('id','desc')->paginate(10);
        return view('admin.roles.index',compact('unidades','estados','roles'));
    }

    public function search(Request $request)
    {
        $unidades = Dea::pluck('descripcion','id');
        $estados = Role::ESTADOS;
        $roles = Role::query()
                        ->byCodigoId($request->codigo_id)
                        ->byDea($request->dea_id)
                        ->byTitulo($request->titulo)
                        ->byCodigo($request->codigo)
                        ->byEstado($request->estado)
                        ->orderBy('id','desc')
                        ->paginate(10);
        return view('admin.roles.index',compact('unidades','estados','roles'));
    }

    public function deshabilitar($id)
    {
        $role = Role::find($id);
        $role->update([
            'estado' => 2
        ]);
        return redirect()->route('roles.index')->with('info_message', 'Se deshabilito el Rol seleccionado.');
    }

    public function habilitar($id)
    {
        $role = Role::find($id);
        $role->update([
            'estado' => 1
        ]);
        return redirect()->route('roles.index')->with('info_message', 'Se habilito el Rol seleccionado.');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $permissions = DB::table('role_permissions as a')
                            ->join('permissions as b','a.permission_id','b.id')
                            ->where('a.role_id',$id)
                            ->select('b.id as permission_id','b.name as permission','b.descripcion','b.estado')
                            ->get();
        return view('admin.roles.show',compact('role','permissions'));
    }

    public function create()
    {
        $deas = Dea::pluck('descripcion','id');
        $permissions = Permission::all()->pluck('name', 'id');
        return view('admin.roles.create', compact('deas','permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dea_id' => 'required',
            'titulo' => 'required|unique:roles,title',
            'permissions' => 'required|array|min:1'
        ]);
        try{
            $role = Role::create([
                'title' => $request->titulo,
                'short_code' => $request->codigo,
                'estado' => 1,
                'dea_id' => $request->dea_id
            ]);
            $role->permissions()->sync($request->permissions);
            return redirect()->route('roles.index')->with('success_message', 'Se agrego un rol al registro.');
        } catch (ValidationException $e) {
            return redirect()->route('roles.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function edit($id)
    {
        //dd('hola');
        $role = Role::find($id);
        $deas = Dea::select('descripcion','id')->get();
        $permissions = Permission::all()->pluck('name', 'id');

        //dd($role);
        return view('admin.roles.edit', compact('role','deas','permissions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'dea_id' => 'required',
            'titulo' => 'required|unique:roles,title,' . $request->role_id,
            'permissions' => 'required|array|min:1'
        ]);
        try{
            $role = Role::find($request->role_id);
            $role->update([
                'title' => $request->titulo,
                'short_code' => $request->codigo,
                'dea_id' => $request->dea_id
            ]);
            $role->permissions()->sync($request->permissions);
            return redirect()->route('roles.index')->with('success_message', 'Se modifico un registro de rol.');
        } catch (ValidationException $e) {
            return redirect()->route('roles.editar')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }
}
