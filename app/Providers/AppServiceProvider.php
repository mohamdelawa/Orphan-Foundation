<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->nameEn,function ($user) use ($permission) {
                $user = Auth()->user();
                $permission = Permission::all()->where('nameEn','=',$permission->nameEn);
                if ($permission->count() == 1) {
                    $permission_id = $permission->first()->id;
                    if ($user->permissionsUsers->where('permission_id','=',$permission_id)->count() == 1) {
                        return true;
                    }
                }
                return false;
            });
        }
    }
}
