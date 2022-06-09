<?php

namespace App\Http\Controllers\Orphan;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use App\Models\TypeImage;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class OrphanController extends Controller
{
    public function index()
    {
        return view('orphan.index');
    }
    private  function getSearchOrphans($typeSearch, $valueSearch){
        switch ($typeSearch){
            case "1" :{
                $typeSearch = "orphanName";
            }
                break;
            case "2" :{
                $typeSearch = "orphanNumber";
            }
                break;
            case "3" :{
                $typeSearch = "orphanIdentity";
            }
                break;
            case "4" :{
                $typeSearch = "mothersName";
            }
                break;
            case "5" :{
                $typeSearch = "mothersIdentity";
            }
                break;
            case "6" :{
                $typeSearch = "breadwinnerName";
            }
                break;
            case "7" :{
                $typeSearch = "breadwinnerIdentity";
            }
            break;
            case "8":{
                $typeSearch = "status";
                $valueSearch = 0;
            }
            break;
            case "9":{
                $typeSearch = "status";
                $valueSearch = 1;
            }
                break;
            default:{
                $typeSearch = "orphanNumber";
            }
        }
        return $orphans = Orphan::all()->where($typeSearch,'=',$valueSearch);
    }
    public function searchOrphans(Request $request)
    {
        $orphans = $this->getSearchOrphans($request->typeSearch,$request->valueSearch);
        return DataTables::of($orphans)
            ->addIndexColumn()
            ->addColumn('actions', function($row){
                return '<div class="btn-group">
                                                <a href="'.route('show.orphan',['id'=>$row['id']]).'"><button class="btn btn-sm btn-primary"   style="margin: 5px">تعديل <i class="nav-icon fas fa-edit" style="margin: 3px"></i></button></a>
                                                <button class="btn btn-sm btn-danger"  data-id="'.$row['id'].'" id="deleteOrphanBtn" style="margin: 5px">حذف <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>
                                          </div>';
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="orphan_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['actions','checkbox'])
            ->make(true);
    }
    public function getOrphansList(Request $request){
        $orphans = Orphan::all();
        return DataTables::of($orphans)
            ->addIndexColumn()
            ->addColumn('actions', function($row){
                return '<div class="btn-group">
                                <a href="'.route('reportOrphan',['id'=>$row['id']]).'">
                                    <button class="btn btn-primary" ><i class="nav-icon fas fa-download"></i> </button>
                                </a>
                                <a href="'.route('show.orphan',['id'=>$row['id']]).'">
                                    <button class="btn btn-sm btn-primary"   style="margin: 5px">تعديل <i class="nav-icon fas fa-edit" style="margin: 3px"></i></button>
                                </a>
                                <button class="btn btn-sm btn-danger"  data-id="'.$row['id'].'" id="deleteOrphanBtn" style="margin: 5px">حذف <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>
                        </div>';
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="orphan_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['actions','checkbox'])
            ->make(true);
    }
    public function show(Request $request)
    {
        $orphan = Orphan::all()->find($request->id);
        $types_image = TypeImage::all();
        $personalPicture = $orphan->imagesGallery->where('type_image_id','=',TypeImage::all()->where('type','=','صورة شخصية')->first()->id)->first();
        if($personalPicture){
            $personalPicture = $personalPicture->path;
        }else{
            $personalPicture = '';
        }
        return view('orphan.show_orphan', compact(['orphan','types_image','personalPicture']));
    }
    public function store(Request $request)
    {
        $rules = [
            'orphanNumber' => 'unique:orphans',
            'orphanName' => 'required',
            'orphanNameEn' => 'required',
            'mothersName' => 'required',
            'mothersIdentity' => 'required|digits:9',
            'breadwinnerName' => 'required',
            'breadwinnerNameEn' => 'required',
            'relativeRelation' => 'required',
            'breadwinnerIdentity' => 'required|digits:9',
            'phoneNumber' => 'required|digits:10',
            'accountNumber' => 'required|digits:7',
            'address' => 'required',
            'educationalLevel' => 'required',
            'guarantyType' => 'required',
            'dob' => 'required|date',
            'healthStatus' => 'required',
            'disease' => 'required',
            'orphanIdentity' => 'required|digits:9|unique:orphans',
            'educationalAttainmentLevel' => 'required',
            'gender' => 'required',
            'fathersDeathDate' => 'required|date',
            'causeOfDeath' => 'required',
            'status' => 'required',
            'marketingDate' => 'date',
            'guarantyDate' => 'date',
        ];
        $masseges = [
            'orphanNumber.unique' => 'رقم اليتيم موجود مسبقا.',
            'orphanName.required' => 'اسم اليتيم مطلوب.',
            'orphanNameEn.required' => 'اسم اليتيم مطلوب(الإنجليزية).',
            'mothersName.required' => 'اسم الأم مطلوب.',
            'mothersIdentity.required' => 'رقم هوية  الأم مطلوبة.',
            'mothersIdentity.digits' => 'رقم هوية الأم غير صحيح يجب أن يتكون من 9 أرقام.',
            'breadwinnerName.required' => 'اسم المعيل مطلوب.',
            'breadwinnerNameEn.required' => 'اسم المعيل مطلوب(الإنجليزية).',
            'relativeRelation.required' => 'صلة القرابة مطلوبة.',
            'breadwinnerIdentity.required' =>'رقم هوية  المعيل مطلوبة.',
            'breadwinnerIdentity.digits' => 'رقم هوية المعيل غير صحيح يجب أن يتكون من 9 أرقام.',
            'phoneNumber.required' =>'رقم الجوال مطلوب.',
            'phoneNumber.digits' => 'رقم الجوال غير صحيح يجب أن يتكون من 10 أرقام(0594875451).',
            'accountNumber.required' => 'رقم الحساب مطلوب.',
            'accountNumber.digits' =>'رقم الحساب غير صحيح يجب أن يتكون من 7 أرقام(1234567).',
            'address.required' => 'العنوان مطلوب.',
            'educationalLevel.required' => 'المرحلة الدراسية مطلوبة.',
            'guarantyType.required' => 'نوع الكفالة مطلوبة.',
            'dob.required' => 'تاريخ ميلاد اليتيم مطلوب.',
            'dob.date' => 'تاريخ ميلاد غير صحيح.',
            'healthStatus.required' => 'الحالة الصحية لليتيم مطلوبة.',
            'disease.required' => 'نوع المرض أو الاعاقة لليتيم مطلوبة.',
            'orphanIdentity.required' => 'رقم هوية  اليتيم مطلوبة.',
            'orphanIdentity.digits' => 'رقم هوية اليتيم غير صحيح يجب أن يتكون من 9 أرقم.',
            'orphanIdentity.unique' => 'رقم هوية اليتيم موجود مسبقا.',
            'educationalAttainmentLevel.required' => 'مستوى التحصيل العلمي لليتيم مطلوب.',
            'gender.required' => 'جنس اليتيم مطلوب.',
            'fathersDeathDate.required' => 'تاريخ وفاة الأب  مطلوب.',
            'fathersDeathDate.date' => 'تاريخ وفاة الأب  غير صحيح.',
            'causeOfDeath.required' => 'سبب وفاة الأب  مطلوبة.',
            'status.required' => 'الحالة مطلوبة.',
            'marketingDate.date'=>'تاريخ التسويق غير صحيح.',
            'guarantyDate.date'=>'تاريخ الكفالة غير صحيح.',
            ];
        $validator = Validator::make($request->all(), $rules, $masseges);
        if ($validator->fails()) {
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(),'msg'=>'فشلت عملية إضافة يتيم جديد']);
        }
        else {
            $orphan = new Orphan();
            $orphan->orphanNumber = $request->orphanNumber;
            $orphan->orphanName = $request->orphanName;
            $orphan->orphanNameEn = $request->orphanNameEn;
            $orphan->mothersName = $request->mothersName;
            $orphan->mothersIdentity = $request->mothersIdentity;
            $orphan->breadwinnerName = $request->breadwinnerName;
            $orphan->breadwinnerNameEn = $request->breadwinnerNameEn;
            $orphan->relativeRelation = $request->relativeRelation;
            $orphan->breadwinnerIdentity = $request->breadwinnerIdentity;
            $orphan->phoneNumber = $request->phoneNumber;
            $orphan->accountNumber = $request->accountNumber;
            $orphan->address = $request->address;
            $orphan->educationalLevel = $request->educationalLevel;
            $orphan->guarantyType = $request->guarantyType;
            $orphan->dob = $request->dob;
            $orphan->healthStatus = $request->healthStatus;
            $orphan->disease = $request->disease;
            $orphan->orphanIdentity = $request->orphanIdentity;
            $orphan->educationalAttainmentLevel = $request->educationalAttainmentLevel;
            if ($request->gender == "male") {
                $orphan->gender = 0;
            } else {
                $orphan->gender = 1;
            }
            $orphan->fathersDeathDate = $request->fathersDeathDate;
            $orphan->causeOfDeath = $request->causeOfDeath;
            $orphan->marketingDate = $request->marketingDate;
            $orphan->guarantyDate = $request->guarantyDate;
            if ($request->status == "marketing") {
                $orphan->status = 0;
            } else {
                $orphan->status = 1;
            }
            $orphan->user_id = auth()->user()->id;
            $query = $orphan->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'فشلت عملية إضافة يتيم جديد']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تم إضافة يتيم حديد بنجاح']);
            }
        }
    }
    public function update(Request $request)
    {
        $rules = [
            'orphanNumber' => 'unique:orphans,orphanNumber,'.$request->id,
            'orphanName' => 'required',
            'orphanNameEn' => 'required',
            'mothersName' => 'required',
            'mothersIdentity' => 'required|digits:9',
            'breadwinnerName' => 'required',
            'breadwinnerNameEn' => 'required',
            'relativeRelation' => 'required',
            'breadwinnerIdentity' => 'required|digits:9',
            'phoneNumber' => 'required|digits:10',
            'accountNumber' => 'required|digits:7',
            'address' => 'required',
            'educationalLevel' => 'required',
            'guarantyType' => 'required',
            'dob' => 'required|date',
            'healthStatus' => 'required',
            'disease' => 'required',
            'orphanIdentity' => 'required|digits:9|unique:orphans,orphanIdentity,'.$request->id,
            'educationalAttainmentLevel' => 'required',
            'gender' => 'required',
            'fathersDeathDate' => 'required|date',
            'causeOfDeath' => 'required',
            'status' => 'required',
            'marketingDate' => 'date',
            'guarantyDate' => 'date',
        ];
        $masseges = [
            'orphanNumber.unique' => 'رقم اليتيم موجود مسبقا.',
            'orphanName.required' => 'اسم اليتيم مطلوب.',
            'orphanNameEn.required' => 'اسم اليتيم مطلوب(الإنجليزية).',
            'mothersName.required' => 'اسم الأم مطلوب.',
            'mothersIdentity.required' => 'رقم هوية  الأم مطلوبة.',
            'mothersIdentity.digits' => 'رقم هوية الأم غير صحيح يجب أن يتكون من 9 أرقام.',
            'breadwinnerName.required' => 'اسم المعيل مطلوب.',
            'breadwinnerNameEn.required' => 'اسم المعيل مطلوب(الإنجليزية).',
            'relativeRelation.required' => 'صلة القرابة مطلوبة.',
            'breadwinnerIdentity.required' =>'رقم هوية  المعيل مطلوبة.',
            'breadwinnerIdentity.digits' => 'رقم هوية المعيل غير صحيح يجب أن يتكون من 9 أرقام.',
            'phoneNumber.required' =>'رقم الجوال مطلوب.',
            'phoneNumber.digits' => 'رقم الجوال غير صحيح يجب أن يتكون من 10 أرقام(0594875451).',
            'accountNumber.required' => 'رقم الحساب مطلوب.',
            'accountNumber.digits' =>'رقم الحساب غير صحيح يجب أن يتكون من 7 أرقام(1234567).',
            'address.required' => 'العنوان مطلوب.',
            'educationalLevel.required' => 'المرحلة الدراسية مطلوبة.',
            'guarantyType.required' => 'نوع الكفالة مطلوبة.',
            'dob.required' => 'تاريخ ميلاد اليتيم مطلوب.',
            'dob.date' => 'تاريخ ميلاد غير صحيح.',
            'healthStatus.required' => 'الحالة الصحية لليتيم مطلوبة.',
            'disease.required' => 'نوع المرض أو الاعاقة لليتيم مطلوبة.',
            'orphanIdentity.required' => 'رقم هوية  اليتيم مطلوبة.',
            'orphanIdentity.digits' => 'رقم هوية اليتيم غير صحيح يجب أن يتكون من 9 أرقم.',
            'orphanIdentity.unique' => 'رقم هوية اليتيم موجود مسبقا.',
            'educationalAttainmentLevel.required' => 'مستوى التحصيل العلمي لليتيم مطلوب.',
            'gender.required' => 'جنس اليتيم مطلوب.',
            'fathersDeathDate.required' => 'تاريخ وفاة الأب  مطلوب.',
            'fathersDeathDate.date' => 'تاريخ وفاة الأب  غير صحيح.',
            'causeOfDeath.required' => 'سبب وفاة الأب  مطلوبة.',
            'status.required' => 'الحالة مطلوبة.',
            'marketingDate.date'=>'تاريخ التسويق غير صحيح.',
            'guarantyDate.date'=>'تاريخ الكفالة غير صحيح.',
        ];
        $validator = Validator::make($request->all(), $rules, $masseges);
        if ($validator->fails()) {
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(),'msg'=>'فشلت عملية تعديل بيانات اليتيم ']);
        }
        else {
            $orphan = Orphan::all()->find($request->id);
            $orphan->orphanNumber = $request->orphanNumber;
            $orphan->orphanName = $request->orphanName;
            $orphan->orphanNameEn = $request->orphanNameEn;
            $orphan->mothersName = $request->mothersName;
            $orphan->mothersIdentity = $request->mothersIdentity;
            $orphan->breadwinnerName = $request->breadwinnerName;
            $orphan->breadwinnerNameEn = $request->breadwinnerNameEn;
            $orphan->relativeRelation = $request->relativeRelation;
            $orphan->breadwinnerIdentity = $request->breadwinnerIdentity;
            $orphan->phoneNumber = $request->phoneNumber;
            $orphan->accountNumber = $request->accountNumber;
            $orphan->address = $request->address;
            $orphan->educationalLevel = $request->educationalLevel;
            $orphan->guarantyType = $request->guarantyType;
            $orphan->dob = $request->dob;
            $orphan->healthStatus = $request->healthStatus;
            $orphan->disease = $request->disease;
            $orphan->orphanIdentity = $request->orphanIdentity;
            $orphan->educationalAttainmentLevel = $request->educationalAttainmentLevel;
            if ($request->gender == "male") {
                $orphan->gender = 0;
            } else {
                $orphan->gender = 1;
            }
            $orphan->fathersDeathDate = $request->fathersDeathDate;
            $orphan->causeOfDeath = $request->causeOfDeath;
            $orphan->marketingDate = $request->marketingDate;
            $orphan->guarantyDate = $request->guarantyDate;
            if ($request->status == "marketing") {
                $orphan->status = 0;
            } else {
                $orphan->status = 1;
            }

            $orphan->user_id = auth()->user()->id;
            $query = $orphan->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'فشلت عملية إضافة يتيم جديد']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تم إضافة يتيم حديد بنجاح']);
            }
        }
    }
    // DELETE Orphan RECORD
    public function deleteOrphan(Request $request){
        $orphan_id = $request->orphan_id;
        $query = Orphan::find($orphan_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف اليتيم بنجاح']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'هناك خطأ ما']);
        }
    }
    public function deleteSelectedOrphans(Request $request){
        $orphan_ids = $request->orphan_ids;
        Orphan::whereIn('id', $orphan_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف الأيتام بنجاح']);
    }

}
