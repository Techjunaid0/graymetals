<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipper;
use App\Country;
use App\State;
use App\City;
use Validator;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipper_detial = Shipper::all();
        return view('shipper.index')->with(['shipper_detial' => $shipper_detial]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries          = Country::all();
        return view('shipper.create')->with(['countries' => $countries]);
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
            'name'                    => 'required|unique:shippers,name|max:255',
            'phone'                   => 'required|unique:shippers,phone',
            'primary_email'           => 'required|email|unique:shippers,primary_email',
            'postal_code'             => 'required',
            'country_id'              => 'required|exists:countries,id',
            'city_id'                 => 'required|exists:cities,id',
            'address'                 => 'required',
        ], $messages)->validate();

        $shipper_detial                  = new Shipper;
        $shipper_detial->name            = $request->name;
        $shipper_detial->phone           = $request->phone;
        $shipper_detial->primary_email   = $request->primary_email;
        $shipper_detial->postal_code     = $request->postal_code;
        $shipper_detial->country_id      = $request->country_id;
        $shipper_detial->city_id         = $request->city_id;
        $shipper_detial->address         = $request->address;
        $shipper_detial->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('shipper.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipper_detial        = Shipper::findOrFail($id);
        $countries             = Country::all();
        return view('shipper.show')->with(['shipper_detial' => $shipper_detial, 'countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipper_detial        = Shipper::findOrFail($id);
        $countries             = Country::all();
        return view('shipper.edit')->with(['shipper_detial' => $shipper_detial, 'countries' => $countries]);
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
        $shipper_detial   = Shipper::findOrFail($id);

        $messages = [
            'country_id.required' => 'Please Select country',  
            'city_id.required'    => 'Please Select city'
        ];
        Validator::make($request->all(), [
            'name'          => 'required|unique:shippers,name,'. $id .'|max:255', 
            'phone'         => 'required|unique:shippers,phone,'. $id .'',
            'primary_email' => 'required|email|unique:shippers,primary_email,'. $id .'',
            'postal_code'   => 'required',
            'country_id'    => 'required|exists:countries,id',
            'city_id'       => 'required|exists:cities,id',
            'address'       => 'required',
        ], $messages)->validate();

        $shipper_detial->name            = $request->name;
        $shipper_detial->phone           = $request->phone;
        $shipper_detial->primary_email   = $request->primary_email;
        $shipper_detial->postal_code     = $request->postal_code;
        $shipper_detial->country_id      = $request->country_id;
        $shipper_detial->city_id         = $request->city_id;
        $shipper_detial->address         = $request->address;
        $shipper_detial->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('shipper.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipper_detial = Shipper::findOrFail($id);
        $shipper_detial->delete();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('shipper.index');
    }
}
