<?php

namespace App\Http\Controllers;


use App\Carrier;
use App\Contract;
use App\Supplier;
use Illuminate\Http\Request;
use Validator;
use DateTime;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::all();
        return view('contracts.index')->with(['contracts' => $contracts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier_names = Supplier::all();
        $carrier_names = Carrier::all();
        return view('contracts.create')->with(['supplier_names' => $supplier_names, 'carrier_names' => $carrier_names]);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'invoice_no' => 'required|unique:contracts,invoice_no',
        ], [
//            'invoice_no.required'           => 'Invoice no is required.',
//            'contract_no.required'          => 'Contract no is required.',
//            'contract_date.required'        => 'Contract Date is required.',
//            'supplier_name.required'        => 'Supplier Name is required.',
//            'no_of_containers.required'     => 'No of container is required.',
//            'rate.required'                 => 'Rate is required.',
//            'status.required'               => 'Status is required.',
//            'shipping_line.required'        => 'Shipping Line is required.',
//            'eta.required'                  => 'ETA is required.',
//            'weight.required'               => 'Weight is required.',
//            'invoice_value.required'        => 'Invoice Value is required.',
//            'container_no.required'         => 'Container No is required.',
//            'comments.required'             => 'Comments is required.',
//            'cu.required'                   => 'Tracking URL is required.',
//            'steal.required'                => 'Tracking URL is required.',
//            'payment_status.required'       => 'Tracking URL is required.',
        ]);


        if (!is_null($request->contract_date)) {
            $contract_date = date('Y-m-d', strtotime($request->contract_date));
        } else {
            $contract_date = null;
        }
        if (!is_null($request->eta)) {
            $eta = date('Y-m-d', strtotime($request->eta));
        } else {
            $eta = null;
        }


        $contract = new Contract();
        $contract->invoice_no = $request->invoice_no ?? null;
        $contract->contract_no = $request->contract_no ?? null;
        $contract->contract_date = $contract_date ?? null;
        $contract->supplier_name = $request->supplier_name ?? null;
        $contract->no_of_containers = $request->no_of_containers ?? null;
        $contract->rate = $request->rate ?? null;
        $contract->status = $request->status ?? null;
        $contract->shipping_line = $request->shipping_line ?? null;
        $contract->eta = $eta ?? null;
        $contract->weight = $request->weight ?? null;
        $contract->invoice_value = $request->invoice_value ?? null;
        $contract->container_no = $request->container_no ?? null;
        $contract->comments = $request->comments ?? null;
        $contract->other_info = $request->other_info ?? null;
        $contract->cu = $request->cu ?? null;
        $contract->steal = $request->steal ?? null;
        $contract->lme = $request->lme ?? null;
        $contract->payment_status = $request->payment_status ?? null;
        $contract->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('contracts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract = Contract::findOrFail($id);
        return view('contracts.show')->with(['contract' => $contract]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Contract $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier_names = Supplier::all();
        $carrier_names = Carrier::all();
        $contract = Contract::findOrFail($id);
        return view('contracts.edit')->with(['contract' => $contract, 'supplier_names' => $supplier_names, 'carrier_names' => $carrier_names]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contract $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        if (!is_null($request->contract_date)) {
            $contract_date = date('Y-m-d', strtotime($request->contract_date));
        } else {
            $contract_date = null;
        }
        if (!is_null($request->eta)) {
            $eta = date('Y-m-d', strtotime($request->eta));
        } else {
            $eta = null;
        }

        $this->validate($request, [
            'invoice_no' => 'required|unique:contracts,invoice_no,' . $id,
        ], [
//            'invoice_no.required'           => 'Invoice no is required.',
//            'contract_no.required'          => 'Contract no is required.',
//            'contract_date.required'        => 'Contract Date is required.',
//            'supplier_name.required'        => 'Supplier Name is required.',
//            'no_of_containers.required'     => 'No of container is required.',
//            'rate.required'                 => 'Rate is required.',
//            'status.required'               => 'Status is required.',
//            'shipping_line.required'        => 'Shipping Line is required.',
//            'eta.required'                  => 'ETA is required.',
//            'weight.required'               => 'Weight is required.',
//            'invoice_value.required'        => 'Invoice Value is required.',
//            'container_no.required'         => 'Container No is required.',
//            'comments.required'             => 'Comments is required.',
//            'cu.required'                   => 'Tracking URL is required.',
//            'steal.required'                => 'Tracking URL is required.',
//            'payment_status.required'       => 'Tracking URL is required.',
        ]);


        $contract->invoice_no = $request->invoice_no ?? null;
        $contract->contract_no = $request->contract_no ?? null;
        $contract->contract_date = $contract_date ?? null;
        $contract->supplier_name = $request->supplier_name ?? null;
        $contract->no_of_containers = $request->no_of_containers ?? null;
        $contract->rate = $request->rate ?? null;
        $contract->status = $request->status ?? null;
        $contract->shipping_line = $request->shipping_line ?? null;
        $contract->eta = $eta ?? null;
        $contract->weight = $request->weight ?? null;
        $contract->invoice_value = $request->invoice_value ?? null;
        $contract->container_no = $request->container_no ?? null;
        $contract->comments = $request->comments ?? null;
        $contract->other_info = $request->other_info ?? null;
        $contract->cu = $request->cu ?? null;
        $contract->steal = $request->steal ?? null;
        $contract->lme = $request->lme ?? null;
        $contract->payment_status = $request->payment_status ?? null;
        $contract->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contract $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();
        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('contracts.index');
    }
}
