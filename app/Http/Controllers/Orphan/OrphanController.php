<?php

namespace App\Http\Controllers\Orphan;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use App\Models\OrphanImage;
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
                $valueSearch = "marketing";
            }
            break;
            case "9":{
                $typeSearch = "status";
                $valueSearch = "guaranteed";
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
                                                <a href="'.route('show.orphan',['id'=>$row['id']]).'"><button class="btn btn-sm btn-primary"   style="margin: 5px">تعديل</button></a>
                                                <button class="btn btn-sm btn-danger"  data-id="'.$row['id'].'" id="deleteOrphanBtn" style="margin: 5px">حذف</button>
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
                                                <a href="'.route('show.orphan',['id'=>$row['id']]).'"><button class="btn btn-sm btn-primary"   style="margin: 5px">تعديل</button></a>
                                                <button class="btn btn-sm btn-danger"  data-id="'.$row['id'].'" id="deleteOrphanBtn" style="margin: 5px">حذف</button>
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
        return view('orphan.show_orphan', compact(['orphan']));
    }
    public function store(Request $request)
    {
        $rules = [
            'orphanNumber' => 'required',
            'orphanName' => 'required:string',
            'mothersName' => 'required:string',
            'mothersIdentity' => 'required:number',
            'breadwinnerName' => 'required:string',
            'relativeRelation' => 'required:string',
            'breadwinnerIdentity' => 'required:number',
            'phoneNumber' => 'required:number',
            'accountNumber' => 'required:number',
            'address' => 'required:string',
            'educationalLevel' => 'required:string',
            'guarantyType' => 'required:string',
            'dob' => 'required:date',
            'healthStatus' => 'required:string',
            'disease' => 'required:string',
            'orphanIdentity' => 'required|unique:orphans',
            'educationalAttainmentLevel' => 'required:string',
            'gender' => 'required:string',
            'fathersDeathDate' => 'required:date',
            'causeOfDeath' => 'required:string',
            'status' => 'required:string',
            'personalPicture' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'birthCertificate' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'schoolCertificate' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'otherAttachments.*' => 'mimes:jpeg,jpg,png,gif|max:10000',

        ];
        $masseges = [];
        $validator = Validator::make($request->all(), $rules, $masseges);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $orphan = new Orphan();
        $orphan->orphanNumber = $request->orphanNumber;
        $orphan->orphanName = $request->orphanName;
        $orphan->mothersName = $request->mothersName;
        $orphan->mothersIdentity = $request->mothersIdentity;
        $orphan->breadwinnerName = $request->breadwinnerName;
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
        if($request->status == "marketing"){
            $orphan->status = 0;
        }else{
            $orphan->status = 1;
        }
        if ($request->file('personalPicture') != null) {
            $file = $request->file('personalPicture');
            $filename = $file->getClientOriginalName() . time() . '.' . $file->extension();
            $request->file('personalPicture')->move('asset/imagesOrphan', $filename);
            $orphan->personalPicture = 'asset/imagesOrphan/' . $filename;
        }
        if ($request->file('birthCertificate') != null) {
            $file = $request->file('birthCertificate');
            $filename = $file->getClientOriginalName() . time() . '.' . $file->extension();
            $request->file('birthCertificate')->move('asset/imagesOrphan', $filename);
            $orphan->birthCertificate = 'asset/imagesOrphan/' . $filename;
        }
        if ($request->file('schoolCertificate') != null) {
            $file = $request->file('schoolCertificate');
            $filename = $file->getClientOriginalName() . time() . '.' . $file->extension();
            $request->file('schoolCertificate')->move('asset/imagesOrphan', $filename);
            $orphan->schoolCertificate = 'asset/imagesOrphan/' . $filename;
        }
        $orphan->user_id = auth()->user()->id;
        if ($orphan->save()) {
            if ($request->otherAttachments != null) {
                foreach ($request->file('otherAttachments') as $file){
                    $filename = $file->getClientOriginalName().time(). '.' . $file->extension();
                    $file->move('asset/imagesOrphan', $filename);
                    $orphan_image =new OrphanImage();
                    $orphan_image->url = "asset/imagesOrphan/" . $filename;

                    $orphan_image->orphan_id =  $orphan->id;
                    $orphan_image->user_id = auth()->user()->id;
                    $orphan_image->save();
                }
            }
            return redirect()->back()->with(['success' => 'تمت عملية إضافة يتيم بنجاح !']);
        } else {
            return redirect()->back()->with(['error' => 'فشلت عملية إضافة يتيم !']);
        }
    }
    public function update(Request $request)
    {
        $rules = [
            'orphanNumber' => 'required',
            'orphanName' => 'required:string',
            'mothersName' => 'required:string',
            'mothersIdentity' => 'required:number',
            'breadwinnerName' => 'required:string',
            'relativeRelation' => 'required:string',
            'breadwinnerIdentity' => 'required:number',
            'phoneNumber' => 'required:number',
            'accountNumber' => 'required:number',
            'address' => 'required:string',
            'educationalLevel' => 'required:string',
            'guarantyType' => 'required:string',
            'dob' => 'required:date',
            'healthStatus' => 'required:string',
            'disease' => 'required:string',
            'orphanIdentity' => 'required|unique:orphans,orphanIdentity,'.$request->id,
            'educationalAttainmentLevel' => 'required:string',
            'gender' => 'required:string',
            'fathersDeathDate' => 'required:date',
            'causeOfDeath' => 'required:string',
            'status' => 'required:string',
            'personalPicture' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'birthCertificate' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'schoolCertificate' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'otherAttachments.*' => 'mimes:jpeg,jpg,png,gif|max:10000',

        ];
        $masseges = [];
        $validator = Validator::make($request->all(), $rules, $masseges);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $orphan = Orphan::all()->find($request->id);
        $orphan->orphanNumber = $request->orphanNumber;
        $orphan->orphanName = $request->orphanName;
        $orphan->mothersName = $request->mothersName;
        $orphan->mothersIdentity = $request->mothersIdentity;
        $orphan->breadwinnerName = $request->breadwinnerName;
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
        if($request->status == "marketing"){
            $orphan->status = 0;
        }else{
            $orphan->status = 1;
        }
        if ($request->file('personalPicture') != null) {
            $file = $request->file('personalPicture');
            $filename = $file->getClientOriginalName() . time() . '.' . $file->extension();
            $request->file('personalPicture')->move('asset/imagesOrphan', $filename);
            $orphan->personalPicture = 'asset/imagesOrphan/' . $filename;
        }
        if ($request->file('birthCertificate') != null) {
            $file = $request->file('birthCertificate');
            $filename = $file->getClientOriginalName() . time() . '.' . $file->extension();
            $request->file('birthCertificate')->move('asset/imagesOrphan', $filename);
            $orphan->birthCertificate = 'asset/imagesOrphan/' . $filename;
        }
        if ($request->file('schoolCertificate') != null) {
            $file = $request->file('schoolCertificate');
            $filename = $file->getClientOriginalName() . time() . '.' . $file->extension();
            $request->file('schoolCertificate')->move('asset/imagesOrphan', $filename);
            $orphan->schoolCertificate = 'asset/imagesOrphan/' . $filename;
        }
        $orphan->user_id = auth()->user()->id;
        if ($orphan->save()) {
            if ($request->otherAttachments != null) {
                foreach ($request->file('otherAttachments') as $file){
                    $filename = $file->getClientOriginalName().time(). '.' . $file->extension();
                    $file->move('asset/imagesOrphan', $filename);
                    $orphan_image =new OrphanImage();
                    $orphan_image->url = "asset/imagesOrphan/" . $filename;

                    $orphan_image->orphan_id =  $orphan->id;
                    $orphan_image->user_id = auth()->user()->id;
                    $orphan_image->save();
                }
            }
            return redirect()->back()->with(['success' => 'تمت عملية تعديل بيانات اليتيم بنجاح !']);
        } else {
            return redirect()->back()->with(['error' => 'فشلت عملية تعديل بيانات اليتيم !']);
        }
    }
    // DELETE Orphan RECORD
    public function deleteOrphan(Request $request){
        $orphan_id = $request->orphan_id;
        $query = Orphan::find($orphan_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'user has been deleted from database']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
        }
    }
    public function deleteSelectedOrphans(Request $request){
        $orphan_ids = $request->orphan_ids;
        Orphan::whereIn('id', $orphan_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'Users have been deleted from database']);
    }

}
