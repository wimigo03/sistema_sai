<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\User;
use App\Models\Empleado;

class HomeController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function index()
    {
        if(count(Auth::user()->roles) == 1){
            foreach(Auth::user()->roles as $role){
                if($role->id == 29){
                    return redirect()->route('beneficiarios.index');
                }
            }
        }
        $user = User::find(Auth::user()->id);
        $empleado = Empleado::find($user->idemp);
        return view('admin.home',compact('user','empleado'));
    }
}
