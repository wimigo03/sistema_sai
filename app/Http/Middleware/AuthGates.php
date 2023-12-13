<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use DB;
class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth()->check()){

            $user_id  = Auth()->user()->id;
           // dd($user_id);

            $role = Role::with('permissions')->where('id', 1)->first();
           // dd($role);

            $permissions2 = DB::table('user_roles  as uu')
            ->join('users as u', 'u.id', '=', 'uu.id_user')
            ->join('roles as r', 'r.id', '=', 'uu.id_role')
            ->join('role_permissions as rp', 'rp.role_id', '=', 'r.id')
            ->join('permissions as p', 'p.id', '=', 'rp.permission_id')
            ->select('p.name')
            ->where('u.id', '=', $user_id)
            //->where('r.id_recepcion', '=', $request->input('idrecepcion'))
            //->orderBy('d.idderivacion', 'desc')
            ->get();

            if(!$role){
                abort(403);
            }


            $permissions = $permissions2->pluck('name');
           //dd($permissions);
            foreach($permissions as $permission){
                Gate::define($permission, function(){
                    return true;
                });
            }

        }


        return $next($request);
    }
}
