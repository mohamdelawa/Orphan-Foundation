<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    //Type Permissions LIST
    public function index(){
        return view('permission.index');
    }
    //ADD NEW Permission
    public function store(Request $request){
        $validator = \Validator::make($request->all(),[
            'name'=>'required|unique:permissions',
            'nameEn'=>'required|unique:permissions',
            'group'=> 'required'
        ],
            [
                'name.required'=> 'الصلاحية مطلوبة.',
                'name.unique'=>'الصلاحية موجود مسبقا.',
                'nameEn.required'=> 'الصلاحية مطلوبة.',
                'nameEn.unique'=>'الصلاحية موجود مسبقا.',
                'group.required'=>'لمجموعة مطلوبة'
            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية اضافة صلاحية جديدة.']);
        }else{
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->nameEn = $request->nameEn;
            $permission->group = $request->group;
            $permission->user_id = auth()->user()->id;
            $query = $permission->save();

            if(!$query){
                return response()->json(['code'=>0, 'msg'=>'فشلت عملية اضافة صلاحية جديدة.']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تم إضافة صلاحية جديدة بنجاح.']);
            }
        }
    }
    // GET ALL Permissions
    public function getPermissionsList(Request $request){
        $permission = Permission::all();
        return DataTables::of($permission)
            ->addIndexColumn()
            ->addColumn('user_name', function($row){
                return $row->user->name;
            })
            ->addColumn('actions', function($row){
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editPermissionBtn" style="margin: 5px">تعديل <i class="nav-icon fas fa-edit" style="margin: 3px"></i></button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deletePermissionBtn" style="margin: 5px">حذف <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>
                                          </div>';
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="permission_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['actions','checkbox','user_name'])
            ->make(true);
    }
    //GET Permission DETAILS
    public function getPermissionDetails(Request $request){
        $permission_id = $request->permission_id;
        $PermissionDetails = Permission::find($permission_id);
        return response()->json(['details'=>$PermissionDetails]);
    }
    //UPDATE Permission DETAILS
    public function update(Request $request){
        $permission_id = $request->id;

        $validator = \Validator::make($request->all(),[
            'name'=>'required|unique:permissions,name,'.$permission_id,
            'nameEn'=>'required|unique:permissions,nameEn,'.$permission_id,
            'group' => 'required',
        ],
            [
                'name.required'=> ' الصلاحية مطلوبة.',
                'name.unique'=>' الصلاحيةموجودة مسبقا.',
                'nameEn.required'=> ' الصلاحية مطلوبة.',
                'nameEn.unique'=>' الصلاحيةموجودة مسبقا.',
                'group.required' => 'المجموعة مطلوبة.'
            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray() , 'msg'=>'فشلت عملية تحديث الصلاحية .']);
        }else{

            $permission = Permission::find($permission_id);
            $permission->name = $request->name;
            $permission->nameEn = $request->nameEn;
            $permission->group = $request->group;
            $permission->user_id = auth()->user()->id;
            $query = $permission->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'تم تحديث بيانات الصلاحية بنجاح']);
            }else{
                return response()->json(['code'=>0,  'msg'=>'فشلت عملية تحديث الصلاحية.']);
            }
        }
    }
    // DELETE Permission RECORD
    public function deletePermission(Request $request){
        $permission_id = $request->permission_id;
        $query = Permission::find($permission_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف الصلاحية بنجاح.']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'فشلت عملية حذف الصلاحية .']);
        }
    }
    public function deleteSelectedPermissions(Request $request){
        $permission_ids = $request->permission_ids;
        Permission::whereIn('id', $permission_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف الصلاحيات بنجاح']);
    }

}
