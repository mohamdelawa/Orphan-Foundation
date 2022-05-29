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
    public function store(Request $request){
         $validator = \Validator::make($request->all(),[
             'name'=>'required|unique:roles',
         ],
         [
           'name.required'=> 'اسم المنصب مطلوب.',
           'name.unique'=>'اسم المنصب موجود مسبقا.'
         ]);

         if(!$validator->passes()){
              return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية اضافة منصب جديد.']);
         }else{
             $role = new Role();
             $role->name = $request->name;
             $query = $role->save();

             if(!$query){
                 return response()->json(['code'=>0, 'msg'=>'فشلت عملية اضافة منصب جديد.']);
             }else{
                 return response()->json(['code'=>1,'msg'=>'تم إضافة رتبة بنجاح']);
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
                                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editRoleBtn" style="margin: 5px">تعديل</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteRoleBtn" style="margin: 5px">حذف</button>
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
    public function update(Request $request){
        $role_id = $request->id;

        $validator = \Validator::make($request->all(),[
            'name'=>'required|unique:roles,name,'.$role_id,
        ],
         [
            'name.required'=> 'اسم المنصب مطلوب.',
            'name.unique'=>'اسم المنصب موجود مسبقا.'
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray() , 'msg'=>'فشلت عملية تحديث منصب .']);
        }else{

            $role = Role::find($role_id);
            $role->name = $request->name;
            $query = $role->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'تم تحديث بيانات المنصب بنجاح']);
            }else{
                return response()->json(['code'=>0,  'msg'=>'فشلت عملية تحديث منصب .']);
            }
        }
    }

    // DELETE Role RECORD
    public function deleteRole(Request $request){
        $role_id = $request->role_id;
        $query = Role::find($role_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف الرتبة بنجاح']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'هناك خطأ ما']);
        }
    }


    public function deleteSelectedRoles(Request $request){
       $role_ids = $request->role_ids;
       Role::whereIn('id', $role_ids)->delete();
       return response()->json(['code'=>1, 'msg'=>'تم حذف الرتب بنجاح']);
    }


}
