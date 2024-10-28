<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\UsuariosExcel;
use App\Models\Role;
use App\Models\User;
use App\Models\Empleado;
use App\Models\UserRolesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPhotoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Canasta\Dea;
use App\Models\Area;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;


class UserController extends Controller
{
    private function completar_areas()
    {
        $users = User::get();
        foreach($users as $user){
            $user = User::find($user->id);
            $empleado = DB::table('empleados')->where('idemp',$user->idemp)->first();
            if($empleado != null){
                $user->update([
                    'idarea' => $empleado->idarea
                ]);
            }
        }
        dd("Finalizado...");
    }

    public function index()
    {
        //$this->completar_areas();
        $roles = Role::query()
                        ->byDea(Auth::user()->dea->id)
                        ->orderBy('title')
                        ->pluck('title','id');
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('roles','users'));
    }

    public function search(Request $request){
        $roles = Role::query()
                        ->byDea(Auth::user()->dea->id)
                        ->orderBy('title')
                        ->pluck('title','id');

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
        return view('admin.users.index', compact('roles','users'));
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
        return view('admin.users.create', compact('deas','roles'));
    }

    public function _create($empleado_id){
        $dea = Dea::find(Auth::user()->dea->id);
        $empleado = Empleado::find($empleado_id);
        $roles = Role::all()->pluck('title','id');
        return view('admin.users._create', compact('dea','empleado','roles'));
    }

    public function getAreas(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $areas = Area::where('dea_id',$id)->where('estadoarea','1')->orderBy('idarea','asc')->get()->toJson();
            if($areas){
                return response()->json([
                    'areas' => $areas
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getEmpleados(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $empleados = Empleado::select(DB::raw("concat(nombres,' ',ap_pat,' ',ap_mat) as nombre_completo"),'idemp as id')->where('idarea',$id)->orderBy('id','asc')->get()->toJson();
            if($empleados){
                return response()->json([
                    'empleados' => $empleados
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'dea' => 'required',
            'area_id' => 'required',
            'empleado_id' => 'required|unique:users,idemp,null,id,dea_id,' . $request->dea,
            'name' => 'required|unique:users,name,null,id,dea_id,' . $request->dea,
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array|min:1'
        ]);
        try{
            $user = User::create([
                'idarea' => $request->area_id,
                'dea_id' => $request->dea,
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'idemp' => $request->empleado_id,
                'estadouser' => 1,
                '_email' => $request->_email
            ]);
            $user->roles()->sync($request->roles);

            if(isset($request->_form)){
                return redirect()->route('empleado.index')->with('success_message', 'Se agrego un usuario al registro.');
            }else{
                return redirect()->route('users.index')->with('success_message', 'Se agrego un usuario al registro.');
            }
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
        $roles = Role::all()->pluck('title','id');
        return view('admin.users.editar', compact('user','roles'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name,' . $request->user_id,
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array|min:1'
        ]);
        try{
            $user = User::find($request->user_id);
            $datos = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->password != null) {
                $datos['password'] = $request->password;
                $datos['_email'] = $request->_email;
            }
            $user->update($datos);
            $user->roles()->sync($request->roles);
            return redirect()->route('users.index')->with('success_message', 'Se modifico un usuario en el registro.');
        } catch (ValidationException $e) {
            return redirect()->route('users.edit')
                ->withErrors($e->validator->errors())
                ->withInput();
        }
    }

    public function update_password_mi_perfil(Request $request)
    {
        $request->validate([
            'password' => 'nullable|min:6|confirmed'
        ]);
        if($request->_email == null){
            return redirect()->back()->with('error_message','[ERROR]. DATOS INSUFICIENTES')->withInput();
        }
        try{
            $user = User::find($request->user_id);
            $user->update([
                'password' => $request->password,
                '_email' => $request->_email
            ]);

            Auth::logout();
            return redirect('/login');
        } catch (ValidationException $e) {
            return redirect()->route('empleado.mi.perfil')
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
        $users = User::find($id);
        $users->estadouser = 0;
        $users->save();
        return redirect()->route('users.index');
    }

    public function alta($id){
        $users = User::find($id);
        $empleado = Empleado::select('estado')->where('idemp',$users->idemp)->first();
        if($empleado != null){
            if($empleado->estado == '1'){
                $users->estadouser = 1;
                $users->save();
                return redirect()->route('users.index')->with('info_message', 'Usuario habilitado correctamente...');
            }else{
                return redirect()->route('users.index')->with('info_message', 'El usuario no puede ser habilitado ya que no es un personal activo...');
            }
        }else{
            return redirect()->route('users.index')->with('info_message', 'El usuario no puede ser habilitado ya que no es un personal activo...');
        }
    }
}
