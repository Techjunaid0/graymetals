<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
// use Excel;
// use DB;

class ExportExcelController extends Controller
{
    public function export(Request $request) 
    {
        $this->validate($request,[
            'from' => 'required',
            'to' => 'required',
        ]);

        return Excel::download(new UsersExport($request) , 'Users.xlsx');

    }
    public function excel()
    {

    	$userExportData = User::all();
    	// dd($userExportData);
    	$userArray[] = array('Id','Name','Email');
    	foreach ($userExportData as $customerData) 
    	{
    		$userArray[] = array(
    			'Id' => $customerData->id,
    			'Name' => $customerData->name,
    			'Email' => $customerData->email
    		);
 		}

        echo "<pre>";
        var_dump((new Excel));die;
        
    	Excel::create('Customer Data', function($excel) use ($userArray){
    		$excel->setTitle('Customer Data');
    		$excel->sheet('Customer Data', function($sheet) use ($userArray){
    			$sheet->fromArray($userArray, null, 'A1', false, false);
    		});
    	})->download('xlsx');
    }
}
