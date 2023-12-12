<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\UsuariosExcel;
use App\Models\Role;
use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPhotoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;


class UserController extends Controller
{
    public function index(){
        //abort_if(Gate::denies('users_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function search(Request $request){
        //abort_if(Gate::denies('users_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $users = User::query()
                        ->byNombre(strtoupper($request->nombre))
                        ->byApPaterno(strtoupper($request->ap_pat))
                        ->byApMaterno(strtoupper($request->ap_mat))
                        ->byUsername($request->username)
                        ->byEmail($request->email)
                        ->byRole($request->role)
                        ->byEstado($request->estado)
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function excel(Request $request){
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $users = User::query()
                        ->byNombre(strtoupper($request->nombre))
                        ->byApPaterno(strtoupper($request->ap_pat))
                        ->byApMaterno(strtoupper($request->ap_mat))
                        ->byUsername($request->username)
                        ->byEmail($request->email)
                        ->byRole($request->role)
                        ->byEstado($request->estado)
                        ->orderBy('id', 'desc')
                        ->get();
                return Excel::download(new UsuariosExcel($users),'usuarios.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function create(){
        //abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $roles = Role::pluck('title','id');
        $empleados = EmpleadosModel::select(DB::raw("concat(nombres,' ',ap_pat,' ',ap_mat) as nombre_completo"),'idemp as id')->pluck('nombre_completo','id');
        return view('admin.users.create', compact('roles', 'empleados'));
    }

    public function store(StoreUserRequest $request){
        //dd($request->all());
        User::create($request->validated());
        return redirect()->route('admin.users.index')->with(['status-success' => "Usuario registrado con exito."]);
    }

    public function show(User $user){
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, 'Forbidden');

        return view('admin.users.show', compact('user'));
    }

    public function edit($iduser){
        $user = User::find($iduser);
        $roles = DB::table('roles')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user){
        $user->update(array_filter($request->validated()));
        return redirect()->route('admin.users.index')->with(['status-success' => "User Updated"]);
    }

    public function destroy(User $user){
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $user->delete();
        return redirect()->back()->with(['status-success' => "User Deleted"]);
    }

    public function altaUser(User $user){
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $user->delete();
        return redirect()->back()->with(['status-success' => "User Deleted"]);
    }

    public function bajaUser(User $user){
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $user->delete();
        return redirect()->back()->with(['status-success' => "User Deleted"]);
    }

    public function baja($id){
        $Users = User::find($id);
        $Users->estadouser = 0;
        $Users->save();
        return redirect()->route('admin.users.index');
    }

    public function alta($id){
        $Users = User::find($id);
        $Users->estadouser = 1;
        $Users->save();
        return redirect()->route('admin.users.index');
    }
}
