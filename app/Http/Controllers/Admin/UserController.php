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
        $roles = Role::pluck('title','id');
        $empleados = EmpleadosModel::select(DB::raw("concat(nombres,' ',ap_pat,' ',ap_mat) as nombre_completo"),'idemp as id')->pluck('nombre_completo','id');
        return view('admin.users.create', compact('roles', 'empleados'));
    }

    public function store(Request $request){


       // dd($request->input('roles'));
        $user = new User();
        $user->idemp = $request->input('idemp');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->dea_id = $request->input('dea');
        $user->estadouser = 1;
        //$user->estado_unidad = 1;
        $user->save();
        //dd($request);
        //User::create($request->validated());

        if ( $request->has('roles') ) {
            foreach ( $request->get('roles') as $peso ) {
                UserRolesModel::create([
                    'id_user' => $user->id ,
                    'id_role' => $peso
                ]);
            }
        }

        return redirect()->route('users.index')->with(['status-success' => "Usuario registrado con exito."]);
    }

    public function show(User $user){
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, 'Forbidden');

        return view('admin.users.show', compact('user'));
    }

    public function edit($iduser){
        $user = User::find($iduser);
        //PersoneriasModel::where('tipo', '=', 1)->paginate(15)

        $roleuser=UserRolesModel::where('id_user','=',$iduser)->pluck('id_user', 'id_role');

        $roles = DB::table('roles')->get();
        $roles2 = User::all()->pluck('name', 'email');
        //dd($roleuser);
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user){
        $user->update(array_filter($request->validated()));
        return redirect()->route('users.index')->with(['status-success' => "User Updated"]);
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
