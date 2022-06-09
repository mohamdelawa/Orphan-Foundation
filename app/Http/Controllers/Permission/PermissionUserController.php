<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class PermissionUserController extends Controller
{
    // GET Permissions User
    public function getPermissionsUserList(Request $request){
        $permissions = PermissionUser::all()->where('user_id','=',auth()->user()->id);
        $userId = $request->user_id;
        return DataTables::of($permissions)
            ->addIndexColumn()
            ->addColumn('name', function($row){
                $name = $row->permission->name;
                return  $name ;
            })
            ->addColumn('user_name', function($row){
                $user_name = $row->userAdd->name;
                return  $user_name ;
            })
            ->addColumn('checkbox', function($row) use ($userId){
                $permissions = PermissionUser::all()->where('user_id','=',$userId)->where('permission_id','=',$row['permission_id']);
                if($permissions->count() == 1){
                    return '<input type="checkbox" name="permission_user_checkbox" checked data-id="'.$row['permission_id'].'"><label></label>';
                }
                return '<input type="checkbox" name="permission_user_checkbox"  data-id="'.$row['permission_id'].'"><label></label>';
            })
            ->rawColumns(['name','user_name','actions','checkbox'])
            ->make(true);
    }
    public function addPermissionsUser(Request $request){
        $checkedPermissionsUser = $request->checked_permissions_user;
        $uncheckedPermissionsUser = $request->unchecked_permissions_user;
        if($uncheckedPermissionsUser){
            PermissionUser::where('user_id','=',$request->user_id)->whereIn('permission_id', $uncheckedPermissionsUser)->delete();
        }
        if($checkedPermissionsUser) {
            if (Permission::whereIn('id',$checkedPermissionsUser)->count() == sizeof($checkedPermissionsUser)) {
                foreach ($checkedPermissionsUser as $permission) {
                    if (PermissionUser::all()->where('user_id','=',$request->user_id)->where('permission_id','=',$permission)->count() == 0) {
                        $permissionUser = new PermissionUser();
                        $permissionUser->permission_id = $permission;
                        $permissionUser->user_id = $request->user_id;
                        $permissionUser->add_user_id = auth()->user()->id;
                        $permissionUser->save();
                    }

                }
            }
        }
        return response()->json(['code'=>1, 'msg'=>'تمت إعطاء الصلاحيات بنجاح']);
    }

}
