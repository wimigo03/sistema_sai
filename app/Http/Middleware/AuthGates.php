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
            $role = Role::with('permissions')->where('id', 1)->first();
            $permissions_two = DB::table('user_roles  as uu')
                                    ->join('users as u', 'u.id', 'uu.id_user')
                                    ->join('roles as r', 'r.id', 'uu.id_role')
                                    ->join('role_permissions as rp', 'rp.role_id', 'r.id')
                                    ->join('permissions as p', 'p.id', 'rp.permission_id')
                                    ->select('p.name')
                                    ->where('u.id', $user_id)
                                    ->get();

            if(!$role){
                abort(403);
            }

            $permissions = $permissions_two->pluck('name');

            foreach($permissions as $permission){
                Gate::define($permission, function(){
                    return true;
                });
            }

        }


        return $next($request);
    }
}
