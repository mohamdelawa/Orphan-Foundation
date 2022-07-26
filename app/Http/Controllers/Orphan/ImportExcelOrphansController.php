<?php

namespace App\Http\Controllers\orphan;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Importer;

class ImportExcelOrphansController extends Controller
{

   public function store(Request $request){
       $validator = Validator::make($request->all(), [
           'file' => 'required|max:5000|mimes:xlsx,xls,csv'
       ],
           [
             'file.required'=> 'الملف غير مرفوع.',
               'file.max' => 'جم الملف كبير جدا.'
           ]
       );
       if(!$validator->passes()){
           return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية إضافة أيتام ']);
       }
       else{
           $dataTime = date('Ymd_His');
           $file = $request->file('file');
           $fileName = $dataTime . '-'. $file->getClientOriginalName ();
           $savePath = public_path('/upload/');
           $file->move($savePath, $fileName);
           $excel = Importer::make('Excel');
           $excel->load($savePath.$fileName);
           $collection = $excel->getCollection();
           if(is_array($collection[1]) && sizeof($collection[1]) == 24){
                    $errors =[];
                    $countAllOrphan = sizeof($collection)-1;
                    $countAddedOrphan = 0;
                    $countCancelOrphan = 0;
                    $countUpdateOrphan = 0;
               for($row=1; $row<sizeof($collection); $row++){
                   $status = true;
                   try{
                       $validator = Validator::make($collection[$row], [
                           '1' => 'required',
                           '2' => 'required',
                           '3' => 'required',
                           '4' => 'required',
                           '5' => 'required|digits:9',
                           '6' => 'required',
                           '7' => 'required',
                           '8' => 'required',
                           '9' => 'required|digits:9',
                           '10' => 'required|digits:10',
                           '11' => 'required|digits:7',
                           '12' => 'required',
                           '13' => 'required',
                           '14' => 'required',
                           '15' => 'required|date',
                           '16' => 'required',
                           '17' => 'required',
                           '18' => 'required|digits:9',
                           '19' => 'required',
                           '20' => 'required',
                           '21' => 'required|date',
                           '22'=> '',
                           '23' => 'date',
                           '24' => 'date',
                       ],
                           [
                               '1.required'=> 'اسم اليتيم مطلوب.',
                               '2.required'=> 'اسم اليتيم مطلوب.',
                               '3.required'=>'اسم الأم مطلوب.',
                               '4.required'=>'رقم هوية  الأم مطلوبة.',
                               '4.digits'=>'رقم هوية الأم غير صحيح يجب أن يتكون من 9 أرقام.',
                               '5.required'=>'اسم المعيل مطلوب.',
                               '6.required'=>'اسم المعيل مطلوب.',
                               '7.required'=>'صلة القرابة مطلوبة.',
                               '8.required'=>'رقم هوية  المعيل مطلوبة.',
                               '8.digits'=>'رقم هوية المعيل غير صحيح يجب أن يتكون من 9 أرقم.',
                               '9.required'=>'رقم الجوال مطلوب.',
                               '9.digits'=>'رقم الجوال غير صحيح يجب أن يتكون من 10 أرقام(0594875451).',
                               '10.required'=>'رقم الحساب مطلوب.',
                               '10.digits'=>'رقم الحساب غير صحيح يجب أن يتكون من 7 أرقام(1234567).',
                               '11.required'=>'العنوان مطلوب.',
                               '12.required'=>'المرحلة الدراسية مطلوبة.',
                               '13.required'=>'نوع الكفالة مطلوبة.',
                               '14.required'=>'تاريخ ميلاد اليتيم مطلوب.',
                               '14.date'=>'تاريخ ميلاد غير صحيح.',
                               '15.required'=>'الحالة الصحية لليتيم مطلوبة.',
                               '16.required'=>'نوع المرض أو الاعاقة لليتيم مطلوبة.',
                               '17.required'=>'رقم هوية  اليتيم مطلوبة.',
                               '17.digits'=>'رقم هوية اليتيم غير صحيح يجب أن يتكون من 9 أرقم.',
                               '18.required'=>'مستوى التحصيل العلمي لليتيم مطلوب.',
                               '19.required'=>'جنس اليتيم مطلوب.',
                               '20.required'=>'تاريخ وفاة الأب  مطلوب.',
                               '21.date'=>'تاريخ وفاة الأب  غير صحيح.',
                               '22.required'=>'سبب وفاة الأب  مطلوبة.',
                               '23.date'=>'تاريخ التسويق غير صحيح.',
                               '24.date'=>'تاريخ الكفالة غير صحيح.',
                           ]
                       );
                       if(!$validator->passes()){
                           $errors[$row] = $validator->errors()->toArray();
                           ++$countCancelOrphan;
                           $status = false;
                       }
                       if($status){
                           $orphan = new Orphan();
                           if(Orphan::onlyTrashed()->where('orphanIdentity','=',$collection[$row][17])->count() == 1){
                                Orphan::onlyTrashed()->where('orphanIdentity', '=', $collection[$row][17])->first()->restore();
                           }
                           if(Orphan::all()->where('orphanIdentity','=',$collection[$row][17])->count() == 1) {
                               $orphan = Orphan::all()->where('orphanIdentity', '=', $collection[$row][17])->first();
                               ++$countUpdateOrphan;
                           }

                           $orphan->orphanNumber = $collection[$row][0];
                           $orphan->orphanName = $collection[$row][1];
                           $orphan->orphanNameEn = $collection[$row][2];
                           $orphan->mothersName = $collection[$row][3];
                           $orphan->mothersIdentity = $collection[$row][4];
                           $orphan->breadwinnerName = $collection[$row][5];
                           $orphan->breadwinnerNameEn = $collection[$row][6];
                           $orphan->relativeRelation = $collection[$row][7];
                           $orphan->breadwinnerIdentity = $collection[$row][8];
                           $orphan->phoneNumber = $collection[$row][9];
                           $orphan->accountNumber = $collection[$row][10];
                           $orphan->address = $collection[$row][11];
                           $orphan->educationalLevel = $collection[$row][12];
                           $orphan->guarantyType = $collection[$row][13];
                           $orphan->dob = $collection[$row][14];
                           $orphan->healthStatus = $collection[$row][15];
                           $orphan->disease = $collection[$row][16];
                           $orphan->orphanIdentity = $collection[$row][17];
                           $orphan->educationalAttainmentLevel = $collection[$row][18];
                           if ($collection[$row][19] == "ذكر") {
                               $orphan->gender = 0;
                           } else {
                               $orphan->gender = 1;
                           }
                           $orphan->fathersDeathDate = $collection[$row][20];
                           $orphan->causeOfDeath = $collection[$row][21];
                           $orphan->marketingDate = $collection[$row][22];
                           $orphan->guarantyDate = $collection[$row][23];
                           $orphan->user_id = auth()->user()->id;
                           $query = $orphan->save();
                           if($query){
                               ++$countAddedOrphan;
                           }
                       }
                   }catch(\Exception $e){
                       File::delete($savePath.$fileName);
                       return response()
                           ->json(['code'=>0,'msg'=>[$e->getMessage()]]);
                   }

               }
               $listErrors = ImportExcelOrphansController::listErrors($errors);
               $msg = "تمت عملية إضافة الأيتام بنجاح، عدد الأيتام الكلي :".$countAllOrphan." ، عدد الأيتام التي تم إضافتها :".$countAddedOrphan." ،عدد الأيتام التي لم يتم إضافتها :".$countCancelOrphan." ، عدد الأيتام التي تم تعديل بياناتها وهي موجودة مسبقا :".$countUpdateOrphan.".";
               $isAllAdded = false;
               if($countAddedOrphan == $countAllOrphan){
                   $isAllAdded = true;
               }
               File::delete($savePath.$fileName);
               return response()->json(['code'=>1, 'errors'=>$listErrors,  'msg' => $msg, 'isAllAdded'=>$isAllAdded]);

           }else{
               File::delete($savePath.$fileName);
               return response()->json(['code'=>0 ,'msg'=> 'الملف المرفق غير مطابق. استخدم كما في المثال !']);
           }

       }
   }
 public  function  listErrors($errors){
       $list ='';
       foreach ($errors as $key=> $errors_row){
           $list.='<li><span style="color:red">اليتيم رقم '.$key.'</span>';
           $list.='<ul style=" list-style-type:disc;">';
           foreach ($errors_row as $error_column){
               foreach ($error_column as $error) {
                   $list .= '<li><span style="color:red">'.$error. '</span></li>';
               }
           }
           $list.='</ul></li>';
       }

    return $list;

 }
}
