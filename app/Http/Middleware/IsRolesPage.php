<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class IsRolesPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth()->user();
        $permission = Permission::all()->where('nameEn','=','RolesPage');
        if($permission->count() == 1) {
            $permission_id = $permission->first()->id;
            if ($user->permissionsUsers->where('permission_id','=',$permission_id)->count() == 1) {
                return $next($request);
            }
        }
        return redirect()->back()->with('error','لا تمتلك صلاحية الدخول إلى الصفحة.');
    }
}
