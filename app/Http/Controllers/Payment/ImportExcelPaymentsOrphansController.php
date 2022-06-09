<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\orphan\ImportExcelOrphansController;
use App\Models\Orphan;
use App\Models\Payment;
use App\Models\PaymentOrphan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Importer;

class ImportExcelPaymentsOrphansController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:500|mimes:xlsx,xls,csv',
            'paymentName' => 'required|exists:payments,name',
        ],
            [
                'file.required'=> 'الملف غير مرفوع.',
                'file.max' => 'جم الملف كبير جدا.',
                'paymentName.required' => 'اسم الصرفية مطلوبة.',
                'paymentName.exists' => 'اسم الصرفية غير موجودة.',

            ]
        );
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية إضافة صرفية أيتام. ']);
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
            if(is_array($collection[1]) && sizeof($collection[1]) == 2){
                $errors =[];
                $countAllPaymentOrphan = sizeof($collection)-1;
                $countAddedPaymentOrphan = 0;
                $countCancelPaymentOrphan = 0;
                for($row=1; $row<sizeof($collection); $row++){
                    $status = true;
                    try{
                        $validator = Validator::make($collection[$row], [
                            '0' => 'required|digits:9|exists:orphans,orphanIdentity',
                            '1' => 'required|numeric|min:1',
                        ],
                            [
                                '0.required'=>'رقم هوية  اليتيم مطلوبة.',
                                '0.digits'=>'رقم هوية اليتيم غير صحيح يجب أن يتكون من 9 أرقام.',
                                '0.exists' => 'رقم الهوية اليتيم المدخلة غير موجودة.',
                                '1.required'=> 'مبلغ الكفالة مطلوب.',
                                '1.numeric'=>'يجب أن يكون مبلغ الكفالة رقم.',
                                '1.min'=> 'يجب أن يكون مبلغ الكفالة على الأقل 1.',
                            ]
                        );
                        if(!$validator->passes()){
                            $errors[$row] = $validator->errors()->toArray();
                            ++$countCancelPaymentOrphan;
                            $status = false;
                        }
                        if($status){
                            $orphan_id = Orphan::all()->where('orphanIdentity','=',$collection[$row][0])->first()->id;
                            $payment_id = Payment::all()->where('name','=',$request->paymentName)->first()->id;
                            $payment_orphan = new PaymentOrphan();
                            $payment_orphan->payment_id =  $payment_id ;
                            $payment_orphan->warrantyValue = $collection[$row][1];
                            $payment_orphan->orphan_id = $orphan_id;
                            $payment_orphan->user_id = auth()->user()->id;
                            $query = $payment_orphan->save();
                            if($query){
                                ++$countAddedPaymentOrphan;
                            }
                        }
                    }catch(\Exception $e){
                        File::delete($savePath.$fileName);
                        return response()
                            ->json(['code'=>0,'errors'=>[$e->getMessage()]]);
                    }

                }
                $listErrors = ImportExcelOrphansController::listErrors($errors);
                $msg = 'تمت عملية اضافة صرفيات الأيتام بنجاح. العدد الكلي للأيتام : '.$countAllPaymentOrphan.'،عدد الأيتام التي تم إضافة صرفية لهم : '.$countAddedPaymentOrphan.'،عدد الأيتام التي لم تضاف لهم صرفية :'.$countCancelPaymentOrphan.'.';
                File::delete($savePath.$fileName);
                $isAllAdded =false;
                if($countAddedPaymentOrphan == $countAllPaymentOrphan){
                    $isAllAdded = true;
                }
                return response()->json(['code'=>1, 'errors'=>$listErrors,  'msg' => $msg, 'isAllAdded' =>$isAllAdded]);

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
