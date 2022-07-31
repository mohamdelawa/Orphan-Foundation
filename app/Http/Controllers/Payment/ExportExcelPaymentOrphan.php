<?php

namespace App\Http\Controllers\Payment;

use App\Exports\PaymentOrphanExport;
use App\Http\Controllers\Controller;
use App\Models\Context;
use App\Models\Orphan;
use App\Models\Payment;
use App\Models\PaymentOrphan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class ExportExcelPaymentOrphan extends Controller
{

    private function orphanSortBy($number){
        switch ($number){
            case '0' :{
                return 'orphanNumber';
            }
            break;
            case '1' :{
                return 'orphanName';
            }
                break;
            case '2' :{
                return 'orphanNameEn';
            }
                break;
            case '3' :{
                return 'breadwinnerName';
            }
                break;
            case '4' :{
                return 'breadwinnerNameEn';
            }
                break;
            case '5' :{
                return 'mothersName';
            }
                break;
            case '6' :{
                return 'dob';
            }
            default:{
                return 'orphanNumber';
            }
        }
    }

    public function exportPaymentsOrphans(Request $request){

        $columns = $request->columns;
        $validator = Validator::make($request->all(), [
            'paymentName.*' => 'required|exists:payments,name',
        ],
            [
                'paymentName.required' => 'اسم الصرفية مطلوبة.',
                'paymentName.exists' => 'اسم الصرفية غير موجودة.',
            ]
        );
        if(!$validator->passes()){
            return redirect()->back()->with('error','فشلت عملية التنزيل.');
        }else {
            $payments = Payment::all()->whereIn('name',$request->paymentName);
            if ($payments) {
                $payments_id = $payments->pluck('id')->toArray();
                $payments_orphans = PaymentOrphan::all()->whereIn('payment_id',$payments_id);
                $orphans_id = $payments_orphans->pluck('orphan_id');
                $columnOrderBy = $this->orphanSortBy($request->sortByColumn);
                $orphans = Orphan::all()->whereIn('id',$orphans_id)->sortBy($columnOrderBy);
                $yourFileName = 'PaymentOrphans.xlsx';
                $yourCollection = [];
                $headerColumnsRow = [

                ];
                $headerLanguage = 'ar';
               if(isset($request->headerLanguage)){
                   if($request->headerLanguage == 'en'){
                       $headerLanguage = 'en';
                   }
               }


                $rowId = 0;
                $cellcounter = 0 ;
                $totalAmount = 0;
                $totalAmountwarrantyValue = 0;
                foreach ($orphans as $orphan) {
                    $rowId = $rowId + 1;
                    $cellcounter = 0 ;
                    if(in_array('#', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $rowId;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['#']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('orphanNumber', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->orphanNumber;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['orphanNumber']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('orphanName', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->orphanName;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['orphanName']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('orphanNameEn', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->orphanNameEn;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['orphanNameEn']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('orphanIdentity', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->orphanIdentity;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['orphanIdentity']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('mothersName', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->mothersName;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['mothersName']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('mothersIdentity', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->mothersIdentity;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['mothersIdentity']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('breadwinnerName', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->breadwinnerName;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['breadwinnerName']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('breadwinnerNameEn', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->breadwinnerNameEn;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['breadwinnerNameEn']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('relativeRelation', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->relativeRelation;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['relativeRelation']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('breadwinnerIdentity', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->breadwinnerIdentity;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['breadwinnerIdentity']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('phoneNumber', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->accountNumber;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['phoneNumber']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('accountNumber', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->accountNumber;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['accountNumber']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('address', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->address;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['address']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('educationalLevel', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->educationalLevel;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['educationalLevel']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('guarantyType', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->guarantyType;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['guarantyType']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('dob', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->dob;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['dob']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('healthStatus', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->healthStatus;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['healthStatus']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('disease', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->disease;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['disease']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('educationalAttainmentLevel', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->educationalAttainmentLevel;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['educationalAttainmentLevel']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('gender', $columns, true)){
                        $gender = "ذكر";
                        if($orphan->gender == 0){
                            $gender = "أنثى";
                        }
                        $yourCollection[$rowId][$cellcounter] = $gender;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['gender']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('fathersDeathDate', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->fathersDeathDate;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['fathersDeathDate']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('causeOfDeath', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->causeOfDeath;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['causeOfDeath']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('marketingDate', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->marketingDate;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['marketingDate']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('guarantyDate', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $orphan->orphanIdentity;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['guarantyDate']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    $amountwarrantyValue = 00;
                    $amount = 00;
                    $payments_orphan = $orphan->payments;
                    foreach ($payments_orphan as $payment_orphan) {
                        $amountwarrantyValue = $amountwarrantyValue + $payment_orphan->warrantyValue * $payment_orphan->payment->exchangeRate;
                        $amount = $amount + intVal($payment_orphan->warrantyValue * $payment_orphan->payment->exchangeRate);
                        $currency = $payment_orphan->payment->currency;
                        $paymentDate = $payment_orphan->payment->paymentDate;
                        $exchangeRate = $payment_orphan->payment->exchangeRate;
                        $commission = $payment_orphan->payment->commission;
                        $namePayment = $payment_orphan->payment->name;

                    }
                    $totalAmountwarrantyValue += $amountwarrantyValue;
                    $totalAmount += $amount;
                    if(in_array('warrantyValue', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $amountwarrantyValue;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['warrantyValue']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('warrantyValueConvert', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $amount;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['warrantyValueConvert']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('currency', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $currency;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['currency']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('paymentDate', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $paymentDate;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['paymentDate']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('exchangeRate', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $exchangeRate;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['exchangeRate']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('commission', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $commission;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['commission']['name'][$headerLanguage];
                        ++$cellcounter;
                    }
                    if(in_array('namePayment', $columns, true)){
                        $yourCollection[$rowId][$cellcounter] = $namePayment;
                        $headerColumnsRow[$cellcounter] = Context::columnsPayments()['namePayment']['name'][$headerLanguage];
                        ++$cellcounter;
                    }

                }
                if(in_array('signature', $columns, true)){
                    $headerColumnsRow[$cellcounter] = Context::columnsPayments()['signature']['name'][$headerLanguage];
                }
                $yourCollection[$rowId + 1][0] = "";
                $yourCollection[$rowId + 1][1] = "";
                $yourCollection[$rowId + 1][2] = "";
                $yourCollection[$rowId + 1][3] = "";
                $yourCollection[$rowId + 1][4] = "";
                $yourCollection[$rowId + 1][5] = "";
                $yourCollection[$rowId + 1][6] = "";
                $yourCollection[$rowId + 1][7] = "";
                $yourCollection[$rowId + 1][8] = "الاجمالي";
                $yourCollection[$rowId + 1][9] = $totalAmount;

                $yourCollection = collect($yourCollection);
                return Excel::download(new PaymentOrphanExport($yourCollection,$headerColumnsRow), $yourFileName);
            }
            return   redirect()->back()->with('error','فشلت عملية التنزيل.');
        }
    }
}
