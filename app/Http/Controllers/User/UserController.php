<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Users LIST

    public function index(){
        $roles = Role::all();
        return view('user/index',compact(['roles']));
    }

    //ADD NEW User
    public function addUser(Request $request){
        $validator = \Validator::make($request->all(),[
            'user_name'=>'required|unique:users',
            'name'=>'required',
            'phone_number'=>'required|unique:users',
            'password'=>'required',
            'role_name'=>'required',


        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->user_name = $request->user_name;
            $user->password =Hash::make($request->password);
            $user->phone_number = $request->phone_number;
            $role = Role::all()->where('name','=',$request->role_name);
            if($role->isNotEmpty()){
              $user->role_id = $role->first()->id;
            }
            $query = $user->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'هناك خطأ ما']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تم إضافة مستخدم حديد بنجاح']);
            }
        }
    }

    // GET ALL Users
    public function getUsersList(Request $request){
        $users = User::all();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function($row){
                $role_name = Role::all()->find($row->role_id)->name;
                return  $role_name ;
            })
            ->addColumn('actions', function($row){
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editUserBtn" style="margin: 5px">تعديل</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteUserBtn" style="margin: 5px">حذف</button>
                                          </div>';
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="user_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['role','actions','checkbox'])
            ->make(true);
    }

    //GET User DETAILS
    public function getUserDetails(Request $request){
        $user_id = $request->user_id;
        $userDetails = User::find($user_id);
        $role_name = Role::all()->find($userDetails->role_id)->name;
        return response()->json(['details'=>$userDetails, 'role_name'=>$role_name]);
    }

    //UPDATE User DETAILS
    public function updateUserDetails(Request $request){
        $user_id = $request->id;

        $validator = \Validator::make($request->all(),[
            'user_name'=>'required|unique:users,user_name,'.$user_id,
            'name'=>'required',
            'phone_number'=>'required|unique:users,phone_number,'.$user_id,
            'role_name'=>'required',


        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

            $user = User::find($user_id);
            $user->name = $request->name;
            $user->user_name = $request->user_name;
            if ($request->password){
                $user->password =Hash::make($request->password);
            }

            $user->phone_number = $request->phone_number;
            $role = Role::all()->where('name','=',$request->role_name);
            if($role->isNotEmpty()){
                $user->role_id = $role->first()->id;
            }
            $query = $user->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'تمت عملية تعديل بيانات المستخدم']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'فشلت عملية تعديل بيانات المستخدم']);
            }
        }
    }

    // DELETE User RECORD
    public function deleteUser(Request $request){
        $user_id = $request->user_id;
        $query = User::find($user_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف المستخدم بنجاح']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'هناك خطأ ما']);
        }
    }


    public function deleteSelectedUsers(Request $request){
        $user_ids = $request->user_ids;
        User::whereIn('id', $user_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف المستخدمين بنجاح']);
    }


}
