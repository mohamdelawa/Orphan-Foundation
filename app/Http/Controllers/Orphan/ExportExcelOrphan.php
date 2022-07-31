<?php

namespace App\Http\Controllers\Orphan;

use App\Exports\OrphansExport;
use App\Http\Controllers\Controller;
use App\Models\Context;
use App\Models\Orphan;
use Exporter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelOrphan extends Controller
{
    public function exportAllOrphans(Request $request){
        $yourFileName = 'Orphans.xlsx';
        $yourCollection = [];
        $headerColumnsRow = [

        ];
        $headerLanguage = 'ar';
        if(isset($request->headerLanguage)){
            if($request->headerLanguage == 'en'){
                $headerLanguage = 'en';
            }
        }

        $columns = $request->columns;
        $rowId = 0;
        foreach (Orphan::orderBy('orphanNumber')->get() as $orphan){
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
        }

        $yourCollection = collect($yourCollection);
        return Excel::download(new OrphansExport($yourCollection,$headerColumnsRow), $yourFileName);
    }
}
