<?php

namespace App\Http\Controllers;

use App\Carrier;
use Validator;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carriers = Carrier::all();
        return view('carriers.index')->with(['carriers' => $carriers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carriers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'carrier_name.required'    => 'Carrier Name is required.',
            'tracking_url.required'    => 'Tracking URL is required.'
        ];
        Validator::make($request->all(), [
            'carrier_name'            => 'required|unique:carriers,carrier_name|max:255',
            'tracking_url'            => 'required',
        ], $messages)->validate();

        $carrier                          = new Carrier();
        $carrier->carrier_name            = $request->carrier_name;
        $carrier->tracking_url            = $request->tracking_url;
        $carrier->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('carriers.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carrier        = Carrier::findOrFail($id);
        return view('carriers.show')->with(['carrier' => $carrier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Carrier $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carrier        = Carrier::findOrFail($id);
        return view('carriers.edit')->with(['carrier' => $carrier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Carrier $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carrier        = Carrier::findOrFail($id);
        $messages = [
            'carrier_name.required'    => 'Carrier Name is required.',
            'tracking_url.required'    => 'Tracking URL is required.'
        ];
        Validator::make($request->all(), [
            'carrier_name'            => 'required|unique:carriers,carrier_name,'. $id .'|max:255',
            'tracking_url'            => 'required',
        ], $messages)->validate();
        
        $carrier->carrier_name            = $request->carrier_name;
        $carrier->tracking_url            = $request->tracking_url;
        $carrier->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('carriers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Carrier $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrier         = Carrier::findOrFail($id);
        $carrier->delete();
        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('carriers.index');
    }
}
