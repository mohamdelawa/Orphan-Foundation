<?php

namespace App\Http\Controllers\Orphan;

use App\Http\Controllers\Controller;
use App\Models\ImageGallery;
use App\Models\Orphan;
use App\Models\TypeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ImageGalleryController extends Controller
{
    //ADD NEW Image
    public function addImage(Request $request){
        $rules = [
            'orphan_id' => 'required|unique:orphans,id,'.$request->orphan_id,
            'type_image' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $validator = \Validator::make($request->all(),$rules);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }
        if($request->hasFile('image')){
            $path = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $path);
            $type_image = TypeImage::all()->where('type','=',$request->type_image);
            if ($type_image) {
                $image = new ImageGallery();
                $image->path = $path;
                $image->type_image_id = $type_image->first()->id;
                $image->orphan_id = $request->orphan_id;
                $image->user_id = auth()->user()->id;
                $query = $image->save();
                if ($query) {
                    return response()->json(['code' => 1,'msg' => 'تم اضافة صورة بنجاح']);
                }
            }

        }
        return response()->json(['code' => 0,'msg' => 'هناك خطأ ما']);
    }
    // GET ALL Images
    public function getImagesList(Request $request){
        $images = Orphan::all()->find($request->id)->imagesGallery;

        return DataTables::of($images)
            ->addIndexColumn()
            ->addColumn('type_image', function($row){
                return TypeImage::all()->find($row->type_image_id)->type;
            })->addColumn('image',function ($row){
                return '<img src="'.asset('/images/'.$row->path).'" width="150" height="150">';
            })
            ->addColumn('actions', function($row){
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editImageBtn" style="margin: 5px">تعديل</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteImageBtn" style="margin: 5px">حذف</button>
                                          </div>';
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="image_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['image','type_image','actions','checkbox'])
            ->make(true);
    }

    //GET Image DETAILS
    public function getImageDetails(Request $request){
        $image_id = $request->image_id;
        $image = ImageGallery::all()->find($image_id);
        if($image){
            return response()->json(['code'=>1, 'id'=> $image_id,'type_image'=>$image->typeImage->type]);
        }

        return response()->json(['code'=>0, 'msg'=>'هناك خطأ ما']);

    }

    //UPDATE Image DETAILS
    public function updateImageDetails(Request $request){
        $image_id = $request->id;
        $rules = [
            'id' => 'required',
            'type_image' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $validator = \Validator::make($request->all(),$rules);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }
        $image = ImageGallery::all()->find($image_id);
        if($image){
            $type_image = TypeImage::all()->where('type','=',$request->type_image);

                $image->type_image_id = $type_image->first()->id;
                $image->user_id = auth()->user()->id;

            if($request->hasFile('image')){
                $path = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $path);
                $image->path = $path;
                $image->user_id = auth()->user()->id;
            }
            $query = $image->save();
            if ($query) {
                return response()->json(['code' => 1,'msg' => 'تم تحديث الصورة']);
            }
        }

        return response()->json(['code' => 0,'msg' => 'هناك خطأ ما']);
    }

    // DELETE Image RECORD
    public function deleteImage(Request $request){
        $image_id = $request->image_id;
        $query = ImageGallery::find($image_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف الصورة بنجاح']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'هناك خطأ ما']);
        }
    }


    public function deleteSelectedImages(Request $request){
        $image_ids = $request->image_ids;
        ImageGallery::whereIn('id', $image_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف الصور بنجاح']);
    }


}
