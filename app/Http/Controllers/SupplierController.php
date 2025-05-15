<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Country;
use App\State;
use App\City;
use Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier_detail = Supplier::all();
        return view('supplier.index')->with(['supplier_detail' => $supplier_detail]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries          = Country::all();
        return view('supplier.create')->with(['countries' => $countries]);
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
            'name'                    => 'required|unique:suppliers,name|max:255',
            'phone'                   => 'sometimes|nullable|unique:suppliers,phone',
            'primary_email'           => 'required|email|unique:suppliers,primary_email',
            'postal_code'             => 'sometimes',
            'country_id'              => 'sometimes|nullable|exists:countries,id',
            'city_id'                 => 'sometimes|nullable|exists:cities,id',
            'address'                 => 'sometimes',
        ], $messages)->validate();

        $supplier_detail                  = new Supplier;
        $supplier_detail->name            = $request->name;
        $supplier_detail->phone           = $request->phone;
        $supplier_detail->primary_email   = $request->primary_email;
        $supplier_detail->postal_code     = $request->postal_code;
        $supplier_detail->country_id      = $request->country_id;
        $supplier_detail->city_id         = $request->city_id;
        $supplier_detail->address         = $request->address;
        $supplier_detail->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('supplier.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier_detail        = Supplier::findOrFail($id);
        $countries              = Country::all();
        return view('supplier.show')->with(['supplier_detail' => $supplier_detail, 'countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier_detail        = Supplier::findOrFail($id);
        $countries              = Country::all();
        return view('supplier.edit')->with(['supplier_detail' => $supplier_detail, 'countries' => $countries]);
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
        $supplier_detail   = Supplier::findOrFail($id);

        $messages = [
            'country_id.required' => 'Please Select country',  
            'city_id.required'    => 'Please Select city'
        ];
        Validator::make($request->all(), [
            'name'          => 'required|unique:suppliers,name,'. $id .'|max:255', 
            'phone'         => 'sometimes|nullable|unique:suppliers,phone,'. $id .'',
            'primary_email' => 'required|email|unique:suppliers,primary_email,'. $id .'',
            'postal_code'   => 'sometimes',
            'country_id'    => 'sometimes|nullable|exists:countries,id',
            'city_id'       => 'sometimes|nullable|exists:cities,id',
            'address'       => 'sometimes',
        ], $messages)->validate();

        $supplier_detail->name            = $request->name;
        $supplier_detail->phone           = $request->phone;
        $supplier_detail->primary_email   = $request->primary_email;
        $supplier_detail->postal_code     = $request->postal_code;
        $supplier_detail->country_id      = $request->country_id;
        $supplier_detail->city_id         = $request->city_id;
        $supplier_detail->address         = $request->address;
        $supplier_detail->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier_detail = Supplier::findOrFail($id);

        $supplier_detail->name           = $supplier_detail->name . ' - Removed:' . time();
        $supplier_detail->primary_email  = $supplier_detail->primary_email . ' - Removed:' . time();
        $supplier_detail->save();

        $supplier_detail->delete();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('supplier.index');
    }
}
