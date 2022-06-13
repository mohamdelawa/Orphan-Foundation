<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TypeImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Gate;

class TypeImageController extends Controller
{
    //Type ImageS LIST
    public function index(){
        return view('typeImage.index');
    }

    //ADD NEW Type Image
    public function store(Request $request){
        $validator = \Validator::make($request->all(),[
            'type'=>'required|unique:type_images',
        ],
            [
                'type.required'=> 'نوع الصورة مطلوب.',
                'type.unique'=>'نوع الصورة  موجود مسبقا.'
            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية اضافة نوع صورة جديدة.']);
        }else{
            $typeImage = new TypeImage();
            $typeImage->type = $request->type;
            $typeImage->user_id = auth()->user()->id;
            $query = $typeImage->save();

            if(!$query){
                return response()->json(['code'=>0, 'msg'=>'فشلت عملية اضافة نوع صورة جديدة.']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تم إضافة نوع صورة جديدة بنجاح']);
            }
        }
    }

    // GET ALL Type Images
    public function getTypeImagesList(Request $request){
        $typeImages = TypeImage::all();
        return DataTables::of($typeImages)
            ->addIndexColumn()
            ->addColumn('user_name', function($row){
                return $row->user->name;
            })
            ->addColumn('actions', function($row){
                $btn_group = '<div class="btn-group">';
                if (Gate::allows('EditTypeImage')) {
                    $btn_group .='<button class="btn btn-sm btn-primary" data-id = "'.$row['id'].'" id = "editTypeImageBtn" style = "margin: 5px" > تعديل <i class="nav-icon fas fa-edit" style = "margin: 3px" ></i ></button >';
                }
                if(Gate::allows('DeleteTypeImage')){
                    $btn_group.= '<button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteTypeImageBtn" style="margin: 5px"> حذف <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>';
                }
                $btn_group .='</div>';
                return $btn_group;
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="type_image_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['actions','checkbox','user_name'])
            ->make(true);
    }

    //GET Type Image DETAILS
    public function getTypeImageDetails(Request $request){
        $type_image_id = $request->type_image_id;
        $TypeImageDetails = TypeImage::find($type_image_id);
        return response()->json(['details'=>$TypeImageDetails]);
    }

    //UPDATE Type Image DETAILS
    public function update(Request $request){
        $type_image_id = $request->id;

        $validator = \Validator::make($request->all(),[
            'type'=>'required|unique:type_images,type,'.$type_image_id,
        ],
            [
                'type.required'=> ' نوع الصورة مطلوبة.',
                'type.unique'=>' نوع الصورة موجودة مسبقا.'
            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray() , 'msg'=>'فشلت عملية تحديث نوع الصورة .']);
        }else{

            $type_image = TypeImage::find($type_image_id);
            $type_image->type = $request->type;
            $type_image->user_id = auth()->user()->id;
            $query = $type_image->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'تم تحديث بيانات نوع الصورة بنجاح']);
            }else{
                return response()->json(['code'=>0,  'msg'=>'فشلت عملية تحديث نوع الصورة .']);
            }
        }
    }
    // DELETE Type Image RECORD
    public function deleteTypeImage(Request $request){
        $type_image_id = $request->type_image_id;
        $query = TypeImage::find($type_image_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف نوع الصورة بنجاح.']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'فشلت عملية حذف نوع الصورة.']);
        }
    }
    public function deleteSelectedTypeImages(Request $request){
        $type_image_ids = $request->type_image_ids;
        TypeImage::whereIn('id', $type_image_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف أنوع الصور بنجاح']);
    }

}
