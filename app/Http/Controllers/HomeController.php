<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Consignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Instruction as Ins;
use App\Supplier;
use App\ShippingCompany;
use App\Consignee;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Charts\Instruction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $case_detail            = Ins::all();
        $supplier_list          = Supplier::all();
        $consignee_list         = Consignee::all();
        $shipping_company_list = ShippingCompany::all();
        $carriers =Carrier::all();

        //creating chart
        $current_time = Carbon::now();
        $current_month = $current_time->month;
        $instructions = Ins::selectRaw('COUNT(*) as count, case_datetime')
            ->whereRaw('MONTH(case_datetime) = ?', [$current_month])
            ->groupBy('case_datetime')
            ->get();

        if($instructions->isNotEmpty()){
            foreach ($instructions as $key => $value){
                $ins_per_day[] = ($value->count) ? $value->count : 0;
            }
        }else{
            $ins_per_day = [];
        }

        $chart = new Instruction;
        $chart->label('Instructions');
        $chart->dataset('Instruction per day','bar', $ins_per_day);

        //creating table
        $consignments = Consignment::whereRaw('MONTH(eta) = ?',[$current_month])->get();

        return view('home')->with(['carriers'=>$carriers,'case_detail' => $case_detail ,'supplier_list' => $supplier_list,'shipping_company_list'=> $shipping_company_list, 'consignee_list' =>$consignee_list, 'data' => $instructions, 'chart' => $chart, 'consignments' => $consignments]);
    }
}
