<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\UsuariosExcel;
use App\Models\Role;
use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\UserRolesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPhotoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Canasta\Dea;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;


class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function search(Request $request){
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
        $deas = Dea::pluck('descripcion','id');
        $roles = Role::all()->pluck('title','id');
        $empleados = EmpleadosModel::select(DB::raw("concat(nombres,' ',ap_pat,' ',ap_mat) as nombre_completo"),'idemp as id')->pluck('nombre_completo','id');
        return view('admin.users.create', compact('deas','roles', 'empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idemp' => 'required',
            'name' => 'required|unique:users,name',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'dea' => 'required',
            'roles' => 'required|array|min:1'
        ]);
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'idemp' => $request->idemp,
                'estadouser' => 1,
                'dea_id' => $request->dea
            ]);
            $user->roles()->sync($request->roles);
            return redirect()->route('users.index')->with('success_message', 'Se agrego un usuario al registro.');
        } catch (ValidationException $e) {
            return redirect()->route('users.create')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function show(User $user){
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, 'Forbidden');

        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $deas = Dea::select('descripcion','id')->get();
        $roles = Role::all()->pluck('title','id');
        $empleados = EmpleadosModel::select(DB::raw("concat(nombres,' ',ap_pat,' ',ap_mat) as nombre_completo"),'idemp as id')->get();
        return view('admin.users.editar', compact('user','deas','roles', 'empleados'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'idemp' => 'required',
            'name' => 'required|unique:users,name,' . $request->user_id,
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed',
            'dea' => 'required',
            'roles' => 'required|array|min:1'
        ]);
        try{
            $user = User::find($request->user_id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'idemp' => $request->idemp,
                'dea_id' => $request->dea
            ]);
            $user->roles()->sync($request->roles);
            return redirect()->route('users.index')->with('success_message', 'Se modifico un usuario en el registro.');
        } catch (ValidationException $e) {
            return redirect()->route('users.edit')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->back()->with(['status-success' => "User Deleted"]);
    }

    public function altaUser(User $user){
        $user->delete();
        return redirect()->back()->with(['status-success' => "User Deleted"]);
    }

    public function bajaUser(User $user){
        $user->delete();
        return redirect()->back()->with(['status-success' => "User Deleted"]);
    }

    public function baja($id){
        $Users = User::find($id);
        $Users->estadouser = 0;
        $Users->save();
        return redirect()->route('users.index');
    }

    public function alta($id){
        $Users = User::find($id);
        $Users->estadouser = 1;
        $Users->save();
        return redirect()->route('users.index');
    }
}
