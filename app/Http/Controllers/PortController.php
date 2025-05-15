<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Port;
use App\Country;
use App\State;
use App\City;
use Validator;

class PortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $port_detail = Port::all();
        return view('port.index')->with(['port_detail' => $port_detail]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries          = Country::all();
        return view('port.create')->with(['countries' => $countries]);
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
            'name.unique'         => 'Port with Same Name Already Exists',
            'country_id.required' => 'Please Select country',  
            'city_id.required'    => 'Please Select city'
          ];
        Validator::make($request->all(), [
            'name'                    => 'required|unique:ports,name|max:255',
            // 'phone'                   => 'required|unique:ports,phone',
            // 'primary_email'           => 'required|email|unique:ports,primary_email',
            // 'postal_code'             => 'required',
            'country_id'              => 'sometimes|exists_or_null:countries,id',
            'city_id'                 => 'sometimes|exists_or_null:cities,id',
            'address'                 => 'sometimes',
        ], $messages)->validate();

        $port_detail                  = new Port;
        $port_detail->name            = $request->name;
        // $port_detail->phone           = $request->phone;
        // $port_detail->primary_email   = $request->primary_email;
        // $port_detail->postal_code     = $request->postal_code;
        $port_detail->country_id      = $request->country_id;
        $port_detail->city_id         = $request->city_id;
        $port_detail->address         = $request->address;
        $port_detail->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('port.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $port_detail        = Port::findOrFail($id);
        $countries          = Country::all();
        return view('port.show')->with(['port_detail' => $port_detail, 'countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $port_detail        = Port::findOrFail($id);
        $countries          = Country::all();
        return view('port.edit')->with(['port_detail' => $port_detail, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idport_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $port_detail   = Port::findOrFail($id);

        $messages = [
            'name.unique'         => 'Port with Same Name Already Exists',
            'country_id.required' => 'Please Select country',  
            'city_id.required'    => 'Please Select city'
        ];
        Validator::make($request->all(), [
            'name'          => 'required|unique:ports,name,'. $id .'|max:255', 
            // 'phone'         => 'required',
            // 'primary_email' => 'required|email',
            // 'postal_code'   => 'required',
            'country_id'    => 'sometimes|exists_or_null:countries,id',
            'city_id'       => 'sometimes|exists_or_null:cities,id',
            'address'       => 'sometimes',
        ], $messages)->validate();

        $port_detail->name            = $request->name;
        $port_detail->phone           = $request->phone;
        $port_detail->primary_email   = $request->primary_email;
        $port_detail->postal_code     = $request->postal_code;
        $port_detail->country_id      = $request->country_id;
        $port_detail->city_id         = $request->city_id;
        $port_detail->address         = $request->address;
        $port_detail->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('port.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $port_detail = Port::findOrFail($id);

        $port_detail->name           = $port_detail->name . ' - Removed:' . time();
        $port_detail->primary_email  = $port_detail->primary_email . ' - Removed:' . time();
        $port_detail->save();

        $port_detail->delete();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('port.index');
    }
}
