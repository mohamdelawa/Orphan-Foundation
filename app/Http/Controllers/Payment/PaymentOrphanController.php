<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Context;
use App\Models\Orphan;
use App\Models\Payment;
use App\Models\PaymentOrphan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use DataTables;

class PaymentOrphanController extends Controller
{
    public function index()
    {
        $payments = Payment::orderBy('paymentDate', 'desc')->get();
        $columns = Context::columnsPayments();
        return view('payment.payment-orphan.index',compact(['payments', 'columns']));
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
                $typeSearch = "breadwinnerName";
            }
                break;
            case "5" :{
                $typeSearch = "breadwinnerIdentity";
            }
                break;
            default:{
                $typeSearch = "orphanNumber";
            }
        }
        return $orphans = Orphan::all()->where($typeSearch,'=',$valueSearch);
    }
    public function searchPaymentOrphans(Request $request)
    {
        $payment_orphans = PaymentOrphan::all();

        if($request->valueSearch != "" && $request->paymentName != '' ){
            $orphans = $this->getSearchOrphans($request->typeSearch,$request->valueSearch);
            if($request->paymentName == "allPayment" && $orphans ){
                $payment_orphans = PaymentOrphan::all()->whereIn('orphan_id',$orphans->pluck('id')->toArray()) ;
            }
            else{
                $payment = Payment::all()->where('name','=',$request->paymentName) ;
                if($payment){
                    $payment_orphans = PaymentOrphan::all()->where('payment_id','=',$payment->first()->id)->whereIn('orphan_id',$orphans->pluck('id')->toArray()) ;
                }
            }
        }
        else if($request->paymentName != ''){
            if($request->paymentName == "allPayment"){
                $payment_orphans = PaymentOrphan::all();
            }else{
                $payment = Payment::all()->where('name','=',$request->paymentName) ;
                if($payment){
                    $payment_orphans = PaymentOrphan::all()->where('payment_id','=',$payment->first()->id) ;
                }
            }
        }
        return DataTables::of($payment_orphans)
            ->addIndexColumn()->addColumn('orphanNumber',function ($row){
                return Orphan::find($row->orphan_id)->orphanNumber;
            })
            ->addColumn('orphanIdentity',function ($row){
                return  Orphan::find($row->orphan_id)->orphanIdentity;
            })
            ->addColumn('orphanName',function ($row){
                return Orphan::find($row->orphan_id)->orphanName;
            })
            ->addColumn('name',function ($row){
                return Payment::find($row->payment_id)->name;
            })
            ->addColumn('exchangeRate',function ($row){
                return Payment::find($row->payment_id)->exchangeRate;
            })
            ->addColumn('commission',function ($row){
                return Payment::find($row->payment_id)->commission;
            })
            ->addColumn('warrantyValue',function ($row){
                return $row->warrantyValue.' '.Payment::find($row->payment_id)->currency;
            })
            ->addColumn('warrantyValueConverted',function ($row){
                return intVal($row->warrantyValue * Payment::find($row->payment_id)->exchangeRate).'شيكل';
            })
            ->addColumn('paymentDate',function ($row){
                return  Payment::find($row->payment_id)->paymentDate;
            })
            ->addColumn('user_name',function ($row){
                return User::find($row->user_id)->name;
            })
            ->addColumn('actions', function($row){
                $btn_group = '<div class="btn-group">';
                if (Gate::allows('EditPaymentOrphan')) {
                    $btn_group.= '<button class="btn btn-sm btn-primary"  data-id="'.$row['id'].'" id="editPaymentOrphanBtn"   style="margin: 5px">تعديل <i class="nav-icon fas fa-edit" style="margin: 3px"></i></button>';
                }
                if(Gate::allows('DeletePaymentOrphan')){
                    $btn_group.= '<button class="btn btn-sm btn-danger"  data-id="'.$row['id'].'" id="deletePaymentOrphanBtn" style="margin: 5px">حذف <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>';
                }
                $btn_group .='</div>';
                return $btn_group;
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="payment_orphan_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['orphanNumber', 'orphanIdentity', 'orphanName', 'name', 'exchangeRate', 'commission', 'warrantyValue', 'warrantyValueConverted', 'paymentDate', 'user_name','actions','checkbox'])
            ->make(true);
    }
    public function getPaymentOrphansList(Request $request){
        $payment_orphans = PaymentOrphan::all();
        return DataTables::of($payment_orphans)
            ->addIndexColumn()->addColumn('orphanNumber',function ($row){
                return Orphan::find($row->orphan_id)->orphanNumber;
            })
            ->addColumn('orphanIdentity',function ($row){
                return  Orphan::find($row->orphan_id)->orphanIdentity;
            })
            ->addColumn('orphanName',function ($row){
                return Orphan::find($row->orphan_id)->orphanName;
            })
            ->addColumn('name',function ($row){
                return Payment::find($row->payment_id)->name;
            })
            ->addColumn('exchangeRate',function ($row){
                return Payment::find($row->payment_id)->exchangeRate;
            })
            ->addColumn('commission',function ($row){
                return Payment::find($row->payment_id)->commission;
            })
            ->addColumn('warrantyValue',function ($row){
                return $row->warrantyValue.' '.Payment::find($row->payment_id)->currency;
            })
            ->addColumn('warrantyValueConverted',function ($row){
                return intVal($row->warrantyValue * Payment::find($row->payment_id)->exchangeRate).'شيكل';
            })
            ->addColumn('paymentDate',function ($row){
                return  Payment::find($row->payment_id)->paymentDate;
            })
            ->addColumn('user_name',function ($row){
                return User::find($row->user_id)->name;
            })
            ->addColumn('actions', function($row){
                $btn_group = '<div class="btn-group">';
                if (Gate::allows('EditPaymentOrphan')) {
                    $btn_group.= '<button class="btn btn-sm btn-primary"  data-id="'.$row['id'].'" id="editPaymentOrphanBtn"   style="margin: 5px">تعديل <i class="nav-icon fas fa-edit" style="margin: 3px"></i></button>';
                }
                if(Gate::allows('DeletePaymentOrphan')){
                    $btn_group.= '<button class="btn btn-sm btn-danger"  data-id="'.$row['id'].'" id="deletePaymentOrphanBtn" style="margin: 5px">حذف <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>';
                }
                $btn_group .='</div>';
                return $btn_group;
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="payment_orphan_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['orphanNumber', 'orphanIdentity', 'orphanName', 'name', 'exchangeRate', 'commission', 'warrantyValue', 'warrantyValueConverted', 'paymentDate', 'user_name','actions','checkbox'])
            ->make(true);
    }
    //GET Payment Orphan DETAILS
    public function getPaymentOrphanDetails(Request $request){
        $payment_orphan_id = $request->paymentOrphanId;
        $paymentOrphanDetails = PaymentOrphan::find($payment_orphan_id);
        $paymentName = Payment::find($paymentOrphanDetails->payment_id)->name;
        $orphanIdentity = Orphan::find($paymentOrphanDetails->orphan_id)->orphanIdentity;
        $orphanName = Orphan::find($paymentOrphanDetails->orphan_id)->orphanName;
        return response()->json(['details'=>$paymentOrphanDetails,'paymentName'=>$paymentName, 'orphanIdentity'=>$orphanIdentity,'orphanName'=>$orphanName]);
    }
    public function store(Request $request)
    {
        $rules = [
            'paymentName' => 'required|exists:payments,name',
            'warrantyValue' => 'required|numeric|min:1',
            'orphanIdentity' => 'required|digits:9|exists:orphans,orphanIdentity',
        ];
        $masseges = [
            'paymentName.required' => 'اسم الصرفية مطلوبة.',
            'paymentName.exists' => 'اسم الصرفية غير موجودة.',
            'warrantyValue.required' => 'مبلغ الكفالة مطلوبة.',
            'warrantyValue.numeric' => 'يجب أن يكون مبلغ الكفالة رقم.',
            'warrantyValue.min' => 'يجب أن يكون مبلغ الكفالة على الأقل 1.',
            'orphanIdentity.required' => 'رقم هوية  اليتيم مطلوبة.',
            'orphanIdentity.digits' => 'رقم هوية اليتيم غير صحيح يجب أن يتكون من 9 أرقام.',
            'orphanIdentity.exists' => 'رقم الهوية المدخلة غير موجودة.',
        ];
        $validator = Validator::make($request->all(), $rules, $masseges);
        if ($validator->fails()) {
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(),'msg'=>'فشلت عملية إضافة صرفية يتيم جديدة']);
        }
        else {
            $orphan_id = Orphan::all()->where('orphanIdentity','=',$request->orphanIdentity)->first()->id;
            $payment_id = Payment::all()->where('name','=',$request->paymentName)->first()->id;
            $payment_orphan = new PaymentOrphan();
            $payment_orphan->payment_id =  $payment_id ;
            $payment_orphan->warrantyValue = $request->warrantyValue;
            $payment_orphan->orphan_id = $orphan_id;
            $payment_orphan->user_id = auth()->user()->id;
            $query = $payment_orphan->save();
            if(!$query){
                return response()->json(['code'=>0,'msg'=>'فشلت عملية إضافة صرفية يتيم جديدة.']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تمت عملية إضافة صرفية يتيم بنجاح.']);
            }
        }
    }
    public function update(Request $request)
    {
        $rules = [
            'paymentOrphanId'=>'required|exists:payments,id',
            'paymentName' => 'required|exists:payments,name',
            'warrantyValue' => 'required|numeric|min:1',
        ];
        $masseges = [
            'paymentOrphanId.required' => 'رقم صرفية اليتيم مطلوب.',
            'paymentOrphanId.exists' => ' رقم صرفية اليتيم غير موجودة.',
            'paymentName.required' => 'اسم الصرفية مطلوبة.',
            'paymentName.exists' => 'اسم الصرفية غير موجودة.',
            'warrantyValue.required' => 'مبلغ الكفالة مطلوبة.',
            'warrantyValue.numeric' => 'يجب أن يكون مبلغ الكفالة رقم.',
            'warrantyValue.min' => 'يجب أن يكون مبلغ الكفالة على الأقل 1.',
        ];
        $validator = Validator::make($request->all(), $rules, $masseges);
        if ($validator->fails()) {
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(),'msg'=>'فشلت عملية تعديل صرفية يتيم .']);
        }
        else {
            $payment_id = Payment::all()->where('name','=',$request->paymentName)->first()->id;
            $payment_orphan = PaymentOrphan::find($request->paymentOrphanId);
            $payment_orphan->payment_id =  $payment_id ;
            $payment_orphan->warrantyValue = $request->warrantyValue;
            $payment_orphan->user_id = auth()->user()->id;
            $query = $payment_orphan->save();
            if(!$query){
                return response()->json(['code'=>0,'msg'=>'فشلت عملية تعديل صرفية يتيم .']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تمت عملية تعديل صرفية يتيم  بنجاح']);
            }
        }
    }
    // DELETE Payment Orphan RECORD
    public function deletePaymentOrphan(Request $request){
        $payment_orphan_id = $request->payment_orphan_id;
        $query = PaymentOrphan::find($payment_orphan_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف صرفية يتيم بنجاح.']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'فشلت عملية حذف صرفية يتيم.']);
        }
    }
    public function deleteSelectedPaymentOrphans(Request $request){
        $payment_orphan_ids = $request->payment_orphan_ids;
        PaymentOrphan::whereIn('id', $payment_orphan_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف صرفيات الأيتام بنجاح']);
    }

}
