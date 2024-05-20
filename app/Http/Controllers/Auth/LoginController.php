<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->estadouser == 1) {
                return redirect()->route('home.index');
            }
        }
        Auth::logout();
        return redirect()->route('login')->with('error_message','[Credenciales inválidas. Por favor comunicarse con Recursos Humanos[2]]');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    /*public function username()
    {
        return 'name';
    }*/

    /*protected function credentials(Request $request){
        $request['estadouser'] = 1;
        return $request->only($this->username(), 'password', 'estadouser');
    }*/
}
