<?php

namespace App\Http\Controllers;
use App\Models\Orphan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Importer;
use Illuminate\Http\Request;
use Exporter;
use Mpdf\Mpdf;
use PDF;

class TestExcelController extends Controller
{
    public function index(){
        return view('import.index');
    }
    public function uploadFolder(Request $request){
        if ($request->files != null) {
            $a='';
            foreach ($request->file('files') as $file){
                $filename = $file->getClientOriginalName();
                $a .=$filename.' | ';
            }
        }

    }
    function  pdf(){

        foreach (Orphan::all() as  $orphan) {
            $data['orphanNumber'] = $orphan->orphanNumber;
            $data['orphanName'] = $orphan->orphanName;
            $data['breadwinnerName'] = $orphan->breadwinnerName;
            $data['dob'] = $orphan->dob;
            $data['address'] = $orphan->address;
            $data['healthStatus'] = $orphan->healthStatus;
            $mytime = Carbon::now();
            $data['date'] = $mytime->toDateString();
            $pdf = new Mpdf();
            $viewInfo = View::make('excel.reports.pdfInfo',$data);
            $htmlInfo = $viewInfo->render();
            $viewCertificate = View::make('excel.reports.certificate',$data);
            $htmlCertificate = $viewCertificate->render();
            $viewThankYou = View::make('excel.reports.pdfThankYou',$data);
            $htmlThankYou = $viewThankYou->render();
            $viewImages = View::make('excel.reports.pdfImage',$data);
            $htmlImages = $viewImages->render();
            $pdf->WriteHTML($htmlInfo);
            $pdf->AddPage();
            $pdf->WriteHTML($htmlCertificate);
            $pdf->AddPage();
            $pdf->WriteHTML($htmlThankYou);
            $pdf->AddPage();
            $pdf->WriteHTML($htmlImages);
            $pdf->Output(public_path($orphan->orphanNumber.'.pdf'), 'F');
            return response()->download(public_path($orphan->orphanNumber.'.pdf'));
        }


    }
    function  reportOrphan($id){
        $orphan = Orphan::all()->find($id);
        if ($orphan != null) {
            $data['orphanNumber'] = $orphan->orphanNumber;
            $data['orphanName'] = $orphan->orphanName;
            $data['breadwinnerName'] = $orphan->breadwinnerName;
            $data['dob'] = $orphan->dob;
            $data['address'] = $orphan->address;
            $data['healthStatus'] = $orphan->healthStatus;
            $mytime = Carbon::now();
            $data['date'] = $mytime->toDateString();
            $pdf = new Mpdf();
            $viewInfo = View::make('excel.reports.pdfInfo',$data);
            $htmlInfo = $viewInfo->render();
            $viewCertificate = View::make('excel.reports.certificate',$data);
            $htmlCertificate = $viewCertificate->render();
            $viewThankYou = View::make('excel.reports.pdfThankYou',$data);
            $htmlThankYou = $viewThankYou->render();
            $viewImages = View::make('excel.reports.pdfImage',$data);
            $htmlImages = $viewImages->render();
            $pdf->WriteHTML($htmlInfo);
            $pdf->AddPage();
            $pdf->WriteHTML($htmlCertificate);
            $pdf->AddPage();
            $pdf->WriteHTML($htmlThankYou);
            $pdf->AddPage();
            $pdf->WriteHTML($htmlImages);
            $pdf->Output(public_path($orphan->orphanNumber.'.pdf'), 'F');
           return response()->download(public_path($orphan->orphanNumber.'.pdf'))->deleteFileAfterSend(true);
           //return response()->json(['code'=>1, 'msg'=>'user has been deleted from database']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
        }


    }

    public function test(Request $request){
        $yourFileName = 'Orphans.xlsx';
        $yourCollection = [];
        $headerColumnsRow = [
            '#',
            'رقم اليتيم',
            'اسم اليتيم',
            'اسم اليتيم بالإنجليزية',
            'اسم الام',
            'رقم هوية الأم',
            'اسم المعيل',
            'اسم المعيل بالإنجليزية',
            'صلة القرابة',
            'رقم هوية المعيل',
            'رقم الجوال',
            'رقم الحساب',
            'العنوان',
            'المرحلة الدراسية',
            'نوع الكفالة',
            'تاريخ الميلاد',
            'الحالة الصحية',
            'نوع المرض أو الإعاقة',
            'رقم هوية اليتيم',
            'التحصيل الدراسي',
            'الجنس',
            'تاريخ وفاة الأب',
            'سبب وفاة الأب',
            'تاريخ التسويق',
            'تاريخ الكفالة',

        ];
        foreach ($headerColumnsRow as $key => $value){
            $yourCollection[0][$key] = $value;
        }
        foreach (Orphan::all() as $key =>$value){
            $rowId = $key+1;
            $yourCollection[$rowId][0] = $rowId;
            $yourCollection[$rowId][1] = $value->orphanNumber;
            $yourCollection[$rowId][2] = $value->orphanName;
            $yourCollection[$rowId][3] = $value->orphanNameEn;
            $yourCollection[$rowId][4] = $value->mothersName;
            $yourCollection[$rowId][5] = $value->mothersIdentity;
            $yourCollection[$rowId][6] = $value->breadwinnerName;
            $yourCollection[$rowId][7] = $value->breadwinnerNameEn;
            $yourCollection[$rowId][8] = $value->relativeRelation;
            $yourCollection[$rowId][9] = $value->breadwinnerIdentity;
            $yourCollection[$rowId][10] = $value->phoneNumber;
            $yourCollection[$rowId][11] = $value->accountNumber;
            $yourCollection[$rowId][12] = $value->address;
            $yourCollection[$rowId][13] = $value->educationalLevel;
            $yourCollection[$rowId][14] = $value->guarantyType;
            $yourCollection[$rowId][15] = $value->dob;
            $yourCollection[$rowId][16] = $value->healthStatus;
            $yourCollection[$rowId][17] = $value->disease;
            $yourCollection[$rowId][18] = $value->orphanIdentity;
            $yourCollection[$rowId][19] = $value->educationalAttainmentLevel;
             $gender = 'ذكر';
            if($value->gender){
                $gender = 'أنثى';
            }
            $yourCollection[$rowId][20] = $gender;
            $yourCollection[$rowId][21] = $value->fathersDeathDate;
            $yourCollection[$rowId][22] = $value->causeOfDeath;
            $yourCollection[$rowId][23] = $value->marketingDate;
            $yourCollection[$rowId][24] = $value->guarantyDate;
        }

        $excel = Exporter::make('Excel');
        $excel->load(collect($yourCollection));
        return $excel->stream($yourFileName);
    }
}
