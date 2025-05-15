<?php

namespace App\Http\Controllers;

use App\Carrier;
use Illuminate\Http\Request;
use App\Instruction;
use App\Supplier;
use App\ShippingCompany;
use App\Consignee;
use App\Consignment;
use App\ConsignmentDetail;
use App\Port;
use App\User;
use App\Email;
use Mail;
use Validator;
use Carbon\Carbon;
use App\Mail\InstructionCreated;

class InstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructions = Instruction::all();
        return view('instruction.index')->with(['instructions' => $instructions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier_list = Supplier::all();
        $consignees = Consignee::all();
        $ports = Port::all();
        $shipping_company_list = ShippingCompany::all();
        $carriers = Carrier::all();


        return view('instruction.create')->with(['supplier_list' => $supplier_list, 'shipping_company_list' => $shipping_company_list, 'carriers' => $carriers, 'consignees' => $consignees, 'ports' => $ports]);
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
            // 'consignee_id.required'         => 'Please Select Consignee',
            'loading_port_id.required' => 'Please Select Port',
            'discharge_port_id.required' => 'Please Select Port',
            'shipping_company_id.required' => 'Please Select Shipping Company',
            'supplier_id.required' => 'Please Select Supplier',
            'door_orientation.required' => 'Door Orientation Required',
            'door_orientation.in' => 'Invalid Door Orientation',
            'no_of_containers.required' => 'No of Containers is Required',
            // 'description.*.required'        => 'Description is Required',
            // 'description.*.max'             => 'Description is too Big',
            // 'item_weight.*.required'        => 'Weight is Required',
            // 'item_weight.*.numeric'         => 'Weight Must be a Numeric Value',
            // 'price.*.required'              => 'Price is Required',
            // 'price.*.numeric'               => 'Price Must be a Numeric Value'
        ];
        Validator::make($request->all(), [
            'case_datetime' => 'required|date',
            // 'weight'                => 'required|numeric',
            'pickup_datetime' => 'required|date',
            'door_orientation' => 'required|in:Towards Rear,Towards Cab',
            'instructions' => 'required',
            'no_of_containers' => 'required|numeric',
            // 'consignee_id'          => 'required|exists:consignees,id',
            'loading_port_id' => 'required|exists:ports,id',
            'discharge_port_id' => 'required|exists:ports,id',
            'shipping_company_id' => 'required|exists:shipping_companies,id',
            'supplier_id' => 'required|exists:suppliers,id',
            // 'description.*'         => 'required|max:255',
            // 'item_weight.*'         => 'required|numeric',
            // 'price.*'               => 'required|numeric'
        ], $messages)->validate();

        $instruction = new Instruction;
        $instruction->case_datetime = Carbon::parse($request->case_datetime)->format('Y-m-d H:i:s');
        // $instruction->weight               = $request->weight;
        $instruction->pickup_datetime = Carbon::parse($request->pickup_datetime)->format('Y-m-d H:i:s');
        $instruction->door_orientation = $request->door_orientation;
        $instruction->instructions = $request->instructions;
        $instruction->no_of_containers = $request->no_of_containers;
        $instruction->shipping_company_id = $request->shipping_company_id;
        $instruction->supplier_id = $request->supplier_id;
        // $instruction->consignee_id         = $request->consignee_id;
        $instruction->status = 'pending';
        $instruction->save();

        $consignment = new Consignment;
        $consignment->instruction_id = $instruction->id;
        // $consignment->consignee_id      = $request->consignee_id;
        $consignment->loading_port_id = $request->loading_port_id;
        $consignment->discharge_port_id = $request->discharge_port_id;
        $consignment->final_destination = Port::find($request->discharge_port_id)->name;
        $consignment->save();

        // $total_weight   = 0;
        // $total_price    = 0;

        // foreach($request->description as $i => $description)
        // {
        //     $item               = new ConsignmentDetail;
        //     $item->consignment_id= $consignment->id;
        //     $item->description  = $description;
        //     $item->item_weight  = (float) $request->item_weight[$i];
        //     $item->price        = (float) $request->price[$i];
        //     $item->total_price  = (float) $item->item_weight * $item->price;
        //     $item->save();

        //     $total_weight   += $item->item_weight;
        //     $total_price    += $item->total_price;
        // }

        // $instruction->weight    = $total_weight;
        // $instruction->save();

        // $consignment->weight    = $total_weight;
        // $consignment->price     = $total_price;
        // $consignment->save();

        $newEmail = new Email;
        $newEmail->instruction_id = $instruction->id;
        $newEmail->other_party_id = $instruction->shipping_company_id;
        $newEmail->subject = "New Instruction - GrayMetals";
        $newEmail->body = preg_replace('/\s+/', ' ', \View::make('email_templates.instruction.created', ['instruction' => $instruction])->render());
        $newEmail->type = 'sent';
        $newEmail->read = true;
        $newEmail->other_party_type = "shipping_company";
        $newEmail->status = "pending";
        $newEmail->save();

        Mail::to($instruction->shippingCompany->primary_email)
            ->send(new InstructionCreated($instruction, $newEmail));

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Added."]]);
        return redirect()->route('instruction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $instruction = Instruction::findOrFail($id);
        $supplier_list = Supplier::all();
        $consignee_list = Consignee::all();
        $shipping_company_list = ShippingCompany::all();
        $carriers = Carrier::all();
        return view('instruction.show')->with(['carriers' => $carriers, 'instruction' => $instruction, 'supplier_list' => $supplier_list, 'shipping_company_list' => $shipping_company_list, 'consignee_list' => $consignee_list]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instruction = Instruction::findOrFail($id);
        $supplier_list = Supplier::all();
        $consignees = Consignee::all();
        $ports = Port::all();
        $shipping_company_list = ShippingCompany::all();
        $carriers = Carrier::all();
        return view('instruction.edit')->with(['carriers' => $carriers, 'instruction' => $instruction, 'supplier_list' => $supplier_list, 'shipping_company_list' => $shipping_company_list, 'consignees' => $consignees, 'ports' => $ports]);
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
        $instruction = Instruction::findOrFail($id);

        $messages = [
            // 'consignee_id.required'         => 'Please Select Consignee',
            'loading_port_id.required' => 'Please Select Port',
            'discharge_port_id.required' => 'Please Select Port',
            'shipping_company_id.required' => 'Please Select Shipping Company',
            'supplier_id.required' => 'Please Select Supplier',
            'door_orientation.required' => 'Door Orientation Required',
            'door_orientation.in' => 'Invalid Door Orientation',
            'no_of_containers.required' => 'No of Containers is Required',
            // 'description.*.required'        => 'Description is Required',
            // 'description.*.max'             => 'Description is too Big',
            // 'item_weight.*.required'        => 'Weight is Required',
            // 'item_weight.*.numeric'         => 'Weight Must be a Numeric Value',
            // 'price.*.required'              => 'Price is Required',
            // 'price.*.numeric'               => 'Price Must be a Numeric Value'
        ];
        Validator::make($request->all(), [
            'case_datetime' => 'required|date',
            // 'weight'                  => 'required|numeric',
            'pickup_datetime' => 'required|date',
            'door_orientation' => 'required|in:Towards Rear,Towards Cab',
            'instructions' => 'required',
            'no_of_containers' => 'required|numeric',
            // 'consignee_id'            => 'required|exists:consignees,id',
            'loading_port_id' => 'required|exists:ports,id',
            'discharge_port_id' => 'required|exists:ports,id',
            'shipping_company_id' => 'required|exists:shipping_companies,id',
            'supplier_id' => 'required|exists:suppliers,id',
            // 'description.*'         => 'required|max:255',
            // 'item_weight.*'         => 'required|numeric',
            // 'price.*'               => 'required|numeric'
        ], $messages)->validate();

        $instruction->case_datetime = Carbon::parse($request->case_datetime)->format('Y-m-d H:i:s');
        // $instruction->weight               = $request->weight;
        $instruction->pickup_datetime = Carbon::parse($request->pickup_datetime)->format('Y-m-d H:i:s');
        $instruction->door_orientation = $request->door_orientation;
        $instruction->instructions = $request->instructions;
        $instruction->no_of_containers = $request->no_of_containers;
        $instruction->shipping_company_id = $request->shipping_company_id;
        $instruction->supplier_id = $request->supplier_id;
        // $instruction->consignee_id         = $request->consignee_id;
        $instruction->status = 'pending';
        $instruction->save();

        $consignment = Consignment::where('instruction_id', $instruction->id)->first();
        $consignment->instruction_id = $instruction->id;
        // $consignment->consignee_id      = $request->consignee_id;
        $consignment->loading_port_id = $request->loading_port_id;
        $consignment->discharge_port_id = $request->discharge_port_id;
        $consignment->final_destination = Port::find($request->discharge_port_id)->name;
        $consignment->save();

        // $consignment->consignmentDetails()->delete();

        // $total_weight   = 0;
        // $total_price    = 0;

        // foreach($request->description as $i => $description)
        // {
        //     $item               = new ConsignmentDetail;
        //     $item->consignment_id= $consignment->id;
        //     $item->description  = $description;
        //     $item->item_weight  = (float) $request->item_weight[$i];
        //     $item->price        = (float) $request->price[$i];
        //     $item->total_price  = (float) $item->item_weight * $item->price;
        //     $item->save();

        //     $total_weight   += $item->item_weight;
        //     $total_price    += $item->total_price;
        // }

        // $instruction->weight    = $total_weight;
        // $instruction->save();

        // $consignment->weight    = $total_weight;
        // $consignment->price     = $total_price;
        // $consignment->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Updated."]]);
        return redirect()->route('instruction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instruction = Instruction::findOrFail($id);
        $instruction->delete();
        $instruction->consignment->delete();

        session(['toaster_data' => ['type' => "success", 'message' => "Successfully Removed."]]);
        return redirect()->route('instruction.index');
    }

    /**
     * Emails of specified resource from instructions.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function emails($id)
    {
        $instruction = Instruction::findOrFail($id);
        $carriers = Carrier::all();
        return view('instruction.emails')->with(['instruction' => $instruction, 'carriers' => $carriers]);
    }

    /**
     * Consigment Details of specified resource from instructions.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function consignment($id)
    {
        $instruction = Instruction::findOrFail($id);
        if (empty($instruction->consignment))
            return abort(404);

        return view('instruction.consignment')->with(['consignment' => $instruction->consignment]);
    }

    /**
     * Mark Instruction as Completed
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function complete($instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);
        $instruction->status = "completed";
        $instruction->save();

        session(['toaster_data' => ['type' => "success", 'message' => "Instruction Mark as Completed."]]);
        return redirect(route('instruction.show', $instruction_id));
    }
}
