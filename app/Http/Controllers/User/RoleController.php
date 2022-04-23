<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use DataTables;

class RoleController extends Controller
{
    //RoleS LIST

    public function index(){
        return view('role/index');
    }

    //ADD NEW Role
    public function addRole(Request $request){
         $validator = \Validator::make($request->all(),[
             'name'=>'required|unique:roles',
         ]);

         if(!$validator->passes()){
              return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
         }else{
             $role = new Role();
             $role->name = $request->name;
             $query = $role->save();

             if(!$query){
                 return response()->json(['code'=>0,'msg'=>'Something went wrong']);
             }else{
                 return response()->json(['code'=>1,'msg'=>'New Role has been successfully saved']);
             }
         }
    }

    // GET ALL Roles
    public function getRolesList(Request $request){
          $roles = Role::all();
          return DataTables::of($roles)
                              ->addIndexColumn()
                              ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editRoleBtn">Update</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteRoleBtn">Delete</button>
                                          </div>';
                              })
                              ->addColumn('checkbox', function($row){
                                  return '<input type="checkbox" name="role_checkbox" data-id="'.$row['id'].'"><label></label>';
                              })

                              ->rawColumns(['actions','checkbox'])
                              ->make(true);
    }

    //GET Role DETAILS
    public function getRoleDetails(Request $request){
        $role_id = $request->role_id;
        $roleDetails = Role::find($role_id);
        return response()->json(['details'=>$roleDetails]);
    }

    //UPDATE Role DETAILS
    public function updateRoleDetails(Request $request){
        $role_id = $request->id;

        $validator = \Validator::make($request->all(),[
            'name'=>'required|unique:roles,name,'.$role_id,
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

            $role = Role::find($role_id);
            $role->name = $request->name;
            $query = $role->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'Role Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }

    // DELETE Role RECORD
    public function deleteRole(Request $request){
        $role_id = $request->role_id;
        $query = Role::find($role_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'role has been deleted from database']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
        }
    }


    public function deleteSelectedRoles(Request $request){
       $role_ids = $request->role_ids;
       Role::whereIn('id', $role_ids)->delete();
       return response()->json(['code'=>1, 'msg'=>'Roles have been deleted from database']);
    }


}
