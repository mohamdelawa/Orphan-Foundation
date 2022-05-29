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
   public function  index(){
       return view('orphan.import.excel-add-orphans');
   }
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
           if(is_array($collection[1]) && sizeof($collection[1]) == 22){
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
                           '4' => 'required|digits:9',
                           '5' => 'required',
                           '6' => 'required',
                           '7' => 'required|digits:9',
                           '8' => 'required|digits:9',
                           '9' => 'required|digits:7',
                           '10' => 'required',
                           '11' => 'required',
                           '12' => 'required',
                           '13' => 'required|date',
                           '14' => 'required',
                           '15' => 'required',
                           '16' => 'required|digits:9',
                           '17' => 'required',
                           '18' => 'required',
                           '19' => 'required|date',
                           '20'=> '',
                           '21' => 'date',
                           '22' => 'date',
                       ],
                           [
                               '1.required'=> 'اسم اليتيم مطلوب.',
                               '2.required'=>'اسم الأم مطلوب.',
                               '3.required'=>'رقم هوية  الأم مطلوبة.',
                               '3.digits'=>'رقم هوية الأم غير صحيح يجب أن يتكون من 9 أرقام.',
                               '4.required'=>'اسم المعيل مطلوب.',
                               '5.required'=>'صلة القرابة مطلوبة.',
                               '6.required'=>'رقم هوية  المعيل مطلوبة.',
                               '6.digits'=>'رقم هوية المعيل غير صحيح يجب أن يتكون من 9 أرقم.',
                               '7.required'=>'رقم الجوال مطلوب.',
                               '7.digits'=>'رقم الجوال غير صحيح يجب أن يتكون من 9 أرقام(594875451).',
                               '8.required'=>'رقم الحساب مطلوب.',
                               '8.digits'=>'رقم الحساب غير صحيح يجب أن يتكون من 7 أرقام(1234567).',
                               '9.required'=>'العنوان مطلوب.',
                               '10.required'=>'المرحلة الدراسية مطلوبة.',
                               '11.required'=>'نوع الكفالة مطلوبة.',
                               '12.required'=>'تاريخ ميلاد اليتيم مطلوب.',
                               '12.date'=>'تاريخ ميلاد غير صحيح.',
                               '13.required'=>'الحالة الصحية لليتيم مطلوبة.',
                               '14.required'=>'نوع المرض أو الاعاقة لليتيم مطلوبة.',
                               '15.required'=>'رقم هوية  اليتيم مطلوبة.',
                               '15.digits'=>'رقم هوية اليتيم غير صحيح يجب أن يتكون من 9 أرقم.',
                               '16.required'=>'مستوى التحصيل العلمي لليتيم مطلوب.',
                               '17.required'=>'جنس اليتيم مطلوب.',
                               '18.required'=>'تاريخ وفاة الأب  مطلوب.',
                               '18.date'=>'تاريخ وفاة الأب  غير صحيح.',
                               '19.required'=>'سبب وفاة الأب  مطلوبة.',
                               '20.date'=>'تاريخ التسويق غير صحيح.',
                               '21.date'=>'تاريخ الكفالة غير صحيح.',
                           ]
                       );
                       if(!$validator->passes()){
                           $errors[$row] = $validator->errors()->toArray();
                           ++$countCancelOrphan;
                           $status = false;
                       }
                       if($status){
                           $orphan = new Orphan();
                           if(Orphan::all()->where('orphanIdentity','=',$collection[$row][15])->count() == 1) {
                               $orphan = Orphan::all()->where('orphanIdentity', '=', $collection[$row][15])->first();
                               ++$countUpdateOrphan;
                           }

                           $orphan->orphanNumber = $collection[$row][0];
                           $orphan->orphanName = $collection[$row][1];
                           $orphan->mothersName = $collection[$row][2];
                           $orphan->mothersIdentity = $collection[$row][3];
                           $orphan->breadwinnerName = $collection[$row][4];
                           $orphan->relativeRelation = $collection[$row][5];
                           $orphan->breadwinnerIdentity = $collection[$row][6];
                           $orphan->phoneNumber = $collection[$row][7];
                           $orphan->accountNumber = $collection[$row][8];
                           $orphan->address = $collection[$row][9];
                           $orphan->educationalLevel = $collection[$row][10];
                           $orphan->guarantyType = $collection[$row][11];
                           $orphan->dob = $collection[$row][12];
                           $orphan->healthStatus = $collection[$row][13];
                           $orphan->disease = $collection[$row][14];
                           $orphan->orphanIdentity = $collection[$row][15];
                           $orphan->educationalAttainmentLevel = $collection[$row][16];
                           if ($collection[$row][17] == "ذكر") {
                               $orphan->gender = 0;
                           } else {
                               $orphan->gender = 1;
                           }
                           $orphan->fathersDeathDate = $collection[$row][18];
                           $orphan->causeOfDeath = $collection[$row][19];
                           $orphan->marketingDate = $collection[$row][20];
                           $orphan->guarantyDate = $collection[$row][21];
                           $orphan->user_id = auth()->user()->id;
                           $query = $orphan->save();
                           if($query){
                               ++$countAddedOrphan;
                           }
                       }
                   }catch(\Exception $e){
                       File::delete($savePath.$fileName);
                       return response()
                           ->json(['code'=>0,'errors'=>[$e->getMessage()]]);
                   }

               }
               $listErrors = ImportExcelOrphansController::listErrors($errors);
               $msg = "تمت عملية إضافة الأيتام بنجاح، عدد الأيتام الكلي :".$countAllOrphan." ، عدد الأيتام التي تم إضافتها :".$countAddedOrphan." ،عدد الأيتام التي لم يتم إضافتها :".$countCancelOrphan." ، عدد الأيتام التي تم تعديل بياناتها وهي موجودة مسبقا :".$countUpdateOrphan.".";
               File::delete($savePath.$fileName);
               return response()->json(['code'=>1, 'errors'=>$listErrors,  'msg' => $msg]);

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
