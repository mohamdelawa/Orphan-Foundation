<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Context;
use App\Models\Payment;
use App\Models\PaymentOrphan;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    //Payments LIST
    public function index(){
        $payments = Payment::orderBy('paymentDate', 'desc')->get();
        $columns = Context::columnsPayments();
        return view('payment.index',compact(['payments','columns']));
    }
    //ADD NEW payments
    public function store(Request $request){
        $validator = \Validator::make($request->all(),[
            'name'=>'required|unique:payments',
            'currency'=>'required',
            'paymentDate' => 'required|date',
            'exchangeRate'=>'required|numeric|min:1',
            'commission'=>'required|numeric|min:0',
        ],
            [
                'name.required' => 'اسم الصرفية مطلوب.',
                'name.unique' => 'اسم الصرفية موجود مسبقا.',
                'currency.required' => 'العملة مطلوبة.',
                'exchangeRate.required' => 'سعر الصرف مطلوب.',
                'exchangeRate.numeric' => 'يجب أن يكون سعر الصرف رقم.',
                'exchangeRate.min' => 'يجب أن يكون سعر الصرف على الأقل 1.',
                'commission.required' => 'العمولة مطلوبة.',
                'commission.numeric' => 'يجب أن تكون العمولة رقم.',
                'commission.min' => 'يجب أن تكون العمولة على الأقل 0.',
                'paymentDate.required' => 'تاريخ الصرفية.',
                'paymentDate.date' => 'تاريخ الصرفية غير صالح.',
            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية اضافة صرفية.']);
        }else{
            $payment = new Payment();
            $payment->name = $request->name;
            $payment->commission = $request->commission;
            $payment->exchangeRate = $request->exchangeRate;
            $payment->currency = $request->currency;
            $payment->paymentDate = $request->paymentDate;
            $payment->user_id = auth()->user()->id;
            $query = $payment->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'فشلت عملية إضافة صرفية جديدة']);
            }else{
                return response()->json(['code'=>1,'msg'=>'تم إضافة صرفية حديدة بنجاح']);
            }
        }
    }
    // GET ALL Payments
    public function getPaymentsList(Request $request){
        $payments = Payment::all();
        return DataTables::of($payments)
            ->addIndexColumn()
            ->addColumn('countOrphansPayment',function ($row){
                return PaymentOrphan::all()->where('payment_id','=',$row->id)->count();
            })
            ->addColumn('totalWarrantyValue',function ($row){
                $totalWarrantyValue = 0;
                $paymentsOrphans = PaymentOrphan::all()->where('payment_id','=',$row->id);
                foreach ($paymentsOrphans as $paymentOrphan){
                    $totalWarrantyValue += intVal($paymentOrphan->warrantyValue * $row->exchangeRate);
                }
                return $totalWarrantyValue.' شيكل';
            })
            ->addColumn('user_name', function($row){
                $user_name = User::all()->find($row->user_id)->name;
                return  $user_name ;
            })
            ->addColumn('actions', function($row){
                $btn_group = '<div class="btn-group">';
                if (Gate::allows('EditPayment')) {
                    $btn_group.= '<button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editPaymentBtn" style="margin: 5px"> <i class="nav-icon fas fa-edit" style="margin: 3px"></i></button>';
                }
                if(Gate::allows('DeletePayment')){
                    $btn_group.= '<button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deletePaymentBtn" style="margin: 5px"> <i class="nav-icon fas fa-trash-alt" style="margin: 3px"></i></button>';
                }

                $btn_group .='</div>';
                return $btn_group;
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="payment_checkbox" data-id="'.$row['id'].'"><label></label>';
            })
            ->rawColumns(['countOrphansPayment','totalWarrantyValue','user_name','actions','checkbox'])
            ->make(true);
    }
    //GET Payment DETAILS
    public function getPaymentDetails(Request $request){
        $payment_id = $request->payment_id;
        $paymentDetails = Payment::find($payment_id);
        return response()->json(['details'=>$paymentDetails]);
    }
    //UPDATE Payment DETAILS
    public function update(Request $request){
        $payment_id = $request->id;

        $validator = \Validator::make($request->all(),[
            'id'=>'required',
            'name'=>'required|unique:payments,name,'.$payment_id,
            'currency'=>'required',
            'paymentDate' => 'required|date',
            'exchangeRate'=>'required|numeric|min:1',
            'commission'=>'required|numeric|min:0',
        ],
            [
                'id.required'=>'رقم الصرفية مطلوب.',
                'name.required' => 'اسم الصرفية مطلوب.',
                'name.unique' => 'اسم الصرفية موجود مسبقا.',
                'currency.required' => 'العملة مطلوبة.',
                'exchangeRate.required' => 'سعر الصرف مطلوب.',
                'exchangeRate.numeric' => 'يجب أن يكون سعر الصرف رقم.',
                'exchangeRate.min' => 'يجب أن يكون سعر الصرف على الأقل 1.',
                'commission.required' => 'العمولة مطلوبة.',
                'commission.numeric' => 'يجب أن تكون العمولة رقم.',
                'commission.min' => 'يجب أن تكون العمولة على الأقل 0.',
                'paymentDate.required' => 'تاريخ الصرفية.',
                'paymentDate.date' => 'تاريخ الصرفية غير صالح.',

            ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray(), 'msg'=>'فشلت عملية تحديث صرفية.']);
        }else{

            $payment = Payment::find($payment_id);
            $payment->name = $request->name;
            $payment->commission = $request->commission;
            $payment->exchangeRate = $request->exchangeRate;
            $payment->currency = $request->currency;
            $payment->paymentDate = $request->paymentDate;
            $payment->user_id = auth()->user()->id;
            $query = $payment->save();
            if($query){
                return response()->json(['code'=>1, 'msg'=>'تمت عملية تعديل بيانات الصرفية.']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'فشلت عملية تعديل بيانات الصرفية.']);
            }
        }
    }
    // DELETE Payment RECORD
    public function deletePayment(Request $request){
        $payment_id = $request->payment_id;
        PaymentOrphan::where('payment_id','=',$payment_id)->delete();

        $query = Payment::find($payment_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'تم حذف الصرفية بنجاح.']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'فشلت عملية حذف صرفية.ا']);
        }
    }
    public function deleteSelectedPayments(Request $request){
        $payment_ids = $request->payment_ids;
        foreach ($payment_ids as $payment_id){
            PaymentOrphan::where('payment_id','=',$payment_id)->delete();
        }
        Payment::whereIn('id', $payment_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'تم حذف الصرفيات بنجاح']);
    }


}

