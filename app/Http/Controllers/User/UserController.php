<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Users LIST

    public function index(){
        $roles = Role::all();
        return view('user/index',compact(['roles']));
    }
    //ADD NEW User
    public function store(Request $request){
        $validator = \Validator::make($request->all(),[
            'user_name'=>'required|unique:users',
            'name'=>'required',
            'phone_number'=>'required|digits:10|unique:users',
            'password'=>'required',
            'role_name'=>'required',
        ],
            [
                'user_name.required' => 'اسم المستخدم مطلوب.',
                'user_name.unique' => 'اسم المستخدم موجود مسبقا.',
                'name.required' => 'الاسم مطلوب.',
                'phone_number.required' => 'رقم الجوال مطلوب.',
                'phone_number.unique' => 'رقم الجوال مستخدم مسبقا.',
                'phone_number.digits' => 'يجب أن يكون رقم الجوال مكون من 10 أرقام فقط (0594785414)',
                'password.required' => 'كلمة السر مطلوبة',
                'role_name.required' => 'اسم المنصب مطلوب',

            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية اضافة مستخدم.']);
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
                return response()->json(['code'=>0,'msg'=>'فشلت عملية إضافة مستخدم جديد']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تم إضافة مستخدم حديد بنجاح']);
            }
        }
    }

    // GET ALL Users
    public function getUsersList(Request $request){
        $users = User::all()->where('role_id','=',auth()->user()->role_id)->whereNotIn('id',[auth()->user()->id]);
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function($row){
                $role_name = Role::all()->find($row->role_id)->name;
                return  $role_name ;
            })
            ->addColumn('actions', function($row){
                $btn_group = '<div class="btn-group">';
                if (Gate::allows('EditUser')){
                    $btn_group .= '<button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editUserBtn" style="margin: 5px">تعديل <i class="nav-icon fas fa-edit" style="margin: 3px"></i></button>';
                }
                if (Gate::allows('DeleteUser')) {
                    $btn_group .= '<button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteUserBtn" style="margin: 5px">حذف <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>';
                }
                if (Gate::allows('AddPermissionsUser')) {
                    $btn_group .= '<button class="btn btn-sm btn-secondary" data-id="' . $row['id'] . '" id="permissionUserBtn" style="margin: 5px">الصلاحيات<i class="nav-icon fas fa-shield-alt" style="margin: 3px"></i></button>';
                }
                $btn_group .= '</div>';
                return $btn_group;
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
    public function update(Request $request){
        $user_id = $request->id;

        $validator = \Validator::make($request->all(),[
            'user_name'=>'required|unique:users,user_name,'.$user_id,
            'name'=>'required',
            'phone_number'=>'required|digits:10|unique:users,phone_number,'.$user_id,
            'role_name'=>'required',


        ],
            [
                'user_name.required' => 'اسم المستخدم مطلوب.',
                'user_name.unique' => 'اسم المستخدم موجود مسبقا.',
                'name.required' => 'الاسم مطلوب.',
                'phone_number.required' => 'رقم الجوال مطلوب.',
                'phone_number.unique' => 'رقم الجوال مستخدم مسبقا.',
                'phone_number.digits' => 'يجب أن يكون رقم الجوال مكون من 10 أرقام فقط (0594785414)',
                'password.required' => 'كلمة السر مطلوبة',
                'role_name.required' => 'اسم المنصب مطلوب',

            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية تحديث مستخدم']);
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
            return response()->json(['code'=>1, 'msg'=>'تم حذف المستخدم بنجاح.']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'فشلت عملية حذف مستخدم.']);
        }
    }
    public function deleteSelectedUsers(Request $request){
        $user_ids = $request->user_ids;
        User::whereIn('id', $user_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف المستخدمين بنجاح']);
    }


}
