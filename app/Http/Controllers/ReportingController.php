<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instruction;
use Carbon\Carbon;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $instructions = Instruction::where('status', "completed");

        if(isset($request->from_date) && Carbon::parse($request->from_date))
        {
            $instructions = $instructions->where('case_datetime', '>=', Carbon::parse($request->from_date)->format('Y-m-d'));
        }

        if(isset($request->to_date) && Carbon::parse($request->to_date))
        {
            $instructions = $instructions->where('case_datetime', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }

        $instructions = $instructions->get();
        return view("reporting.index")->with(['instructions' => $instructions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downloadReport(Request $request)
    {
        $instructions = Instruction::where('status', "completed");

        if(isset($request->from_date) && Carbon::parse($request->from_date))
        {
            $instructions = $instructions->where('case_datetime', '>=', Carbon::parse($request->from_date)->format('Y-m-d'));
        }

        if(isset($request->to_date) && Carbon::parse($request->to_date))
        {
            $instructions = $instructions->where('case_datetime', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }

        $instructions = $instructions->get();

        /*
            Generate & Save Invoice
        */
        $pdf =\PDF::loadView('pdf.report', ['instructions' => $instructions]);

        return $pdf->download('report_' . date('d-m-Y\_H\_i\_s') . '.pdf');
    }
}
