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
           return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية اضافة ملف الأيتام ']);
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
               $errors=[];
               $rows_error =0;
               for($row=1; $row<sizeof($collection); $row++){
                   try{


                       $status = true;

                        for($i=0; $i<sizeof($collection[$row]); $i++){
                                if($collection[$row][$i] == ''){
                                    $errors[$i] =[];
                                    $errors[$i]['row'] = $row;
                                    $errors[$i]['column'] = $collection[0][$i];
                                    $errors[$i]['msg'] = 'لا تحتوي على بيانات';
                                    $status = false;
                                }
                           }
                       if($status){
                           $orphan = new Orphan();
                           if(Orphan::all()->where('orphanIdentity','=',$collection[$row][15])->count() == 1) {
                               $orphan = Orphan::all()->where('orphanIdentity', '=', $collection[$row][15])->first();
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
                           $orphan->save();
                       }else{
                           ++$rows_error;
                       }
                   }catch(\Exception $e){
                       return response()
                           ->json(['code'=>0,'errors'=>[$e->getMessage()]]);
                   }

               }
               $msg = sizeof($collection)-1-$rows_error ;
               return response()->json(['code'=>-1, 'errors'=>$errors,  'msg' => $msg]);

           }else{
               return response()->json(['code'=>0 ,'msg'=> 'الملف المرفق غير مطابق. استخدم كما في المثال !']);
           }
           File::delete($savePath.$fileName);
           return response()->json(['code'=>1,'msg'=>'تم اضافة اأيتام بنجاح !', 'orphans'=>Orphan::all()]);

       }
   }

}
