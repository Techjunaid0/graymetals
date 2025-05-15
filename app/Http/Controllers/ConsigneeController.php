<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consignee;
use App\Country;
use App\State;
use App\City;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsigneeExport;
use App\Http\Controllers\Controller;

class ConsigneeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consignees = Consignee::all();
        return view('consignee.index')->with(['consignees' => $consignees]);
    }

    public function showConsignee()
    {
        $consignees = Consignee::all();
        return view('reports.consignee', compact("consignees"));
    }

    public function export(Request $request) 
    {
        $this->validate($request,[
            'consignee_id' => 'required|exists:consignees,id',
        ]);
        return Excel::download(new ConsigneeExport($request), 'consignee.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries          = Country::all();
        return view('consignee.create')->with(['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'country_id.required' => 'Please Select country',  
            'city_id.required'    => 'Please Select city'
          ];
        Validator::make($request->all(), [
            'name'                    => 'required|unique:consignees,name|max:255',
            'phone'                   => 'sometimes|nullable|unique:consignees,phone',
            'primary_email'           => 'required|email|unique:consignees,primary_email',
            'postal_code'             => 'sometimes',
            'country_id'              => 'sometimes|nullable|exists:countries,id',
            'city_id'                 => 'sometimes|nullable|exists:cities,id',
            'address'                 => 'sometimes',
        ], $messages)->validate();

        $consignee_detail                  = new Consignee;
        $consignee_detail->name            = $request->name;
        $consignee_detail->phone           = $request->phone;
        $consignee_detail->primary_email   = $request->primary_email;
        $consignee_detail->postal_code     = $request->postal_code;
        $consignee_detail->country_id      = $request->country_id;
        $consignee_detail->city_id         = $request->city_id;
        $consignee_detail->address         = $request->address;
        $consignee_detail->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('consignee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consignee   = Consignee::findOrFail($id);
        $countries   = Country::all();
        return view('consignee.show')->with(['consignee' => $consignee, 'countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consignee   = Consignee::findOrFail($id);
        $countries   = Country::all();
        return view('consignee.edit')->with(['consignee' => $consignee, 'countries' => $countries]);
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
        $consignee_detail   = Consignee::findOrFail($id);

        $messages = [
            'country_id.required' => 'Please Select country',   
            'city_id.required'    => 'Please Select city'
        ];
        Validator::make($request->all(), [
            'name'          => 'required|unique:consignees,name,'. $id .'|max:255', 
            'phone'         => 'sometimes|nullable|unique:consignees,phone,'. $id .'',
            'primary_email' => 'required|email|unique:consignees,primary_email,'. $id .'',
            'postal_code'   => 'sometimes',
            'country_id'    => 'sometimes|nullable|exists:countries,id',
            'city_id'       => 'sometimes|nullable|exists:cities,id',
            'address'       => 'sometimes',
        ], $messages)->validate();

        $consignee_detail->name            = $request->name;
        $consignee_detail->phone           = $request->phone;
        $consignee_detail->primary_email   = $request->primary_email;
        $consignee_detail->postal_code     = $request->postal_code;
        $consignee_detail->country_id      = $request->country_id;
        $consignee_detail->city_id         = $request->city_id;
        $consignee_detail->address         = $request->address;
        $consignee_detail->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('consignee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consignee_detail = Consignee::findOrFail($id);

        $consignee_detail->name           = $consignee_detail->name . ' - Removed:' . time();
        $consignee_detail->primary_email  = $consignee_detail->primary_email . ' - Removed:' . time();
        $consignee_detail->save();

        $consignee_detail->delete();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('consignee.index');
    }
}
