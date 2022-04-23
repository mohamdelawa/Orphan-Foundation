<?php

namespace App\Http\Controllers;
use App\Models\Orphan;
use File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Importer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mpdf\Mpdf;
use PDF;

class TestExcelController extends Controller
{
    public function importFile()
    {
        $orphans = Orphan::all();
        return view('excel.excelCode', compact(['orphans']));
    }
    public function importExcel(Request $request){
        $validator = Validator::make($request->all(), [
         'file' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        if($validator->passes()){
            $dataTime = date('Ymd_His');
            $file = $request->file('file');
            $fileName = $dataTime . '-'. $file->getClientOriginalName ();
            $savePath = public_path('/upload/');
            $file->move($savePath, $fileName);

            $excel = Importer::make('Excel');
            $excel->load($savePath.$fileName);
            $collection = $excel->getCollection();
            if(is_array($collection[1]) && sizeof($collection[1]) == 22){
                for($row=1; $row<sizeof($collection); $row++){
                    try{
                         $orphan = new Orphan();
                         if(Orphan::all()->where('orphanIdentity','=',$collection[$row][15])->count() == 1) {
                             $orphan = Orphan::all()->where('orphanIdentity', '=', $collection[$row][15])->first();
                         }
                         $orphan->orphanNumber = $collection[$row][0];
                         //$full_name = explode(" ",$collection[$row][1],4);
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
                         if($collection[$row][17] == "ذكر"){
                             $orphan->gender = 0;
                         }else{
                             $orphan->gender = 1;
                         }
                         $orphan->fathersDeathDate = $collection[$row][18];
                         $orphan->causeOfDeath = $collection[$row][19];
                         $orphan->marketingDate = $collection[$row][20];
                         $orphan->guarantyDate = $collection[$row][21];
                         $orphan->user_id = auth()->user()->id;
                        $orphan->save();
                        }catch(\Exception $e){
                        return redirect()->back()
                            ->with(['errors'=>[$e->getMessage()]]);
                    }

                }


            }else{
                return redirect()->back()->with(['errors'=>[0 => 'Please provide data in file according to sample file.']]);
            }

           File::delete($savePath.$fileName);
            return redirect()->back()->with(['success'=>'File uploaded successfully.', 'orphans'=>Orphan::all()]);

        }else{
            return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
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
}
