<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingCompany;
use App\Country;
use App\State;
use App\City;
use Validator;

class ShippingCoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipping_companies = ShippingCompany::all();
        return view('shipping_co.index')->with(['shipping_companies' => $shipping_companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('shipping_co.create')->with(['countries' => $countries]);
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
            'country_id.required' => 'Please Select country',
            'city_id.required' => 'Please Select city',
        ];
        Validator::make($request->all(), [
            'name' => 'required|unique:shipping_companies,name|max:255',
            'phone' => 'sometimes|nullable|unique:shipping_companies,phone',
            'primary_email' => 'required|email|unique:shipping_companies,primary_email',
            'postal_code' => 'sometimes',
            'country_id' => 'sometimes|nullable|exists:countries,id',
            'city_id' => 'sometimes|nullable|exists:cities,id',
            'address' => 'required',
        ], $messages)->validate();

        $shipping_company = new ShippingCompany;
        $shipping_company->name = $request->name;
        $shipping_company->phone = $request->phone;
        $shipping_company->primary_email = $request->primary_email;
        $shipping_company->postal_code = $request->postal_code;
        $shipping_company->tracking_url = $request->tracking_url;
        $shipping_company->country_id = $request->country_id;
        $shipping_company->city_id = $request->city_id;
        $shipping_company->address = $request->address;
        $shipping_company->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('shipping_co.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipping_company = ShippingCompany::findOrFail($id);
        $countries = Country::all();
        return view('shipping_co.show')->with(['shipping_company' => $shipping_company, 'countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipping_company = ShippingCompany::findOrFail($id);
        $countries = Country::all();
        return view('shipping_co.edit')->with(['shipping_company' => $shipping_company, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shipping_company = ShippingCompany::findOrFail($id);

        $messages = [
            'country_id.required' => 'Please Select country',
            'city_id.required' => 'Please Select city',
        ];
        Validator::make($request->all(), [
            'name' => 'required|unique:shipping_companies,name,' . $id . '|max:255',
            'phone' => 'sometimes|nullable|unique:shipping_companies,phone,' . $id . '',
            'primary_email' => 'required|email|unique:shipping_companies,primary_email,' . $id . '',
            'postal_code' => 'sometimes',
            'country_id' => 'sometimes|nullable|exists:countries,id',
            'city_id' => 'sometimes|nullable|exists:cities,id',
            'address' => 'required',
        ], $messages)->validate();

        $shipping_company->name = $request->name;
        $shipping_company->phone = $request->phone;
        $shipping_company->primary_email = $request->primary_email;
        $shipping_company->postal_code = $request->postal_code;
        $shipping_company->tracking_url = $request->tracking_url;
        $shipping_company->country_id = $request->country_id;
        $shipping_company->city_id = $request->city_id;
        $shipping_company->address = $request->address;
        $shipping_company->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('shipping_co.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping_companies = ShippingCompany::findOrFail($id);

        $shipping_companies->name = $shipping_companies->name . ' - Removed:' . time();
        $shipping_companies->primary_email = $shipping_companies->primary_email . ' - Removed:' . time();
        $shipping_companies->save();

        $shipping_companies->delete();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('shipping_co.index');
    }
}
