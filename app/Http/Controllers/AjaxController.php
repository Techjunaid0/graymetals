<?php

namespace App\Http\Controllers;

use App\Carrier;
use Illuminate\Http\Request;
use App\State;
use App\City;
use App\Email;
use App\EmailAttachment;
use App\ShippingCompany;
use App\Supplier;
use App\Consignee;
use App\Consignment;
use App\ConsignmentDetail;
use App\Instruction;
use Mail;
use Validator;
use App\Mail\SimpleEmail;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AjaxController extends Controller
{
    public function getStates($country_id)
    {
        return State::where(['country_id' => $country_id])->get();
    }

    public function getCitiesByCountry($country_id)
    {
        $states = $this->getStates($country_id)->pluck('id');
        return City::whereIn('state_id', $states)->orderBy('name','asc')->get();
        // return City::where(['country_id' => $country_id])->get();
    }

    public function getCitiesByState($state_id)
    {

        return City::where(['state_id' => $state_id])->get();
    }

    public function getEmail($email_id)
    {
        return Email::with('emailAttachments')->findOrFail($email_id);
    }

    public function emailRead($email_id)
    {
        $email = Email::findOrFail($email_id);
        $email->read = true;
        $email->save();

        return response()->json(['message' => "Email mark as read."], 200);
    }

    public function newEmail(Request $request)
    {
        $messages = [
            'instruction_id.*' => 'Something Went Wrong',
            'primary_email.required' => 'Recipient Required',
            'primary_email.email' => 'Invalid Recipient',
            'subject.required' => 'Email Subject Required',
            'subject.max' => 'Email Subject is Too Long',
            'attachments.*.file' => 'Attachment Must Be a File',
            'body.required' => 'Email Message Required',
        ];
        Validator::make($request->all(), [
            'instruction_id' => 'required|exists:instructions,id',
            'primary_email' => 'required|email',
            'subject' => 'required|max:255',
            'attachments.*' => 'sometimes|file',
            'body' => 'required'
        ], $messages)->validate();

        $primary_email = $request->primary_email;

        $recipient = ShippingCompany::where('primary_email', $primary_email)->first();
        if (empty($recipient)) {
            $recipient = Supplier::where('primary_email', $primary_email)->first();
        }
        if (empty($recipient)) {
            $recipient = Consignee::where('primary_email', $primary_email)->firstOrFail();
        }

        $newEmail = new Email;
        $newEmail->instruction_id = $request->instruction_id;
        $newEmail->other_party_id = $recipient->id;
        $newEmail->subject = $request->subject;
        $newEmail->body = preg_replace('/\s+/', ' ', \View::make('email_templates.email', ['subject' => $request->subject, 'body' => $request->body])->render());
        $newEmail->type = 'sent';
        $newEmail->has_attachments = (is_array($request->attachments) && count($request->attachments)) > 0 ? true : false;
        $newEmail->read = true;
        $newEmail->other_party_type = $recipient instanceof ShippingCompany ? "shipping_company" : ($recipient instanceof Consignee ? "consignee" : "supplier");
        $newEmail->status = "pending";
        $newEmail->save();

        if (is_array($request->attachments) && count($request->attachments) > 0) {
            for ($i = 0; $i < count($request->attachments); $i++) {
                $path = $request->attachments[$i]->store('public/attachments');

                $emailAttachment = new EmailAttachment;
                $emailAttachment->email_id = $newEmail->id;
                $emailAttachment->orig_filename = $request->attachments[$i]->getClientOriginalName();
                $emailAttachment->path = basename($path);
                $emailAttachment->size = $request->attachments[$i]->getClientSize();
                $emailAttachment->save();
            }
        }

        Mail::to($recipient->primary_email)
            ->send(new SimpleEmail($newEmail));

        return response()->json(['message' => "Email Sent"], 201);
    }

    public function forwardEmail(Request $request)
    {
        $messages = [
            'instruction_id.*' => 'Something Went Wrong',
            'email_id.*' => 'Something Went Wrong',
            'primary_email.required' => 'Recipient Required',
            'primary_email.email' => 'Invalid Recipient',
        ];
        Validator::make($request->all(), [
            'instruction_id' => 'required|exists:instructions,id',
            'email_id' => 'required|exists:emails,id',
            'primary_email' => 'required|email',
        ], $messages)->validate();

        $email = Email::find($request->email_id);

        $primary_email = $request->primary_email;

        $recipient = ShippingCompany::where('primary_email', $primary_email)->first();
        if (empty($recipient)) {
            $recipient = Supplier::where('primary_email', $primary_email)->first();
        }
        if (empty($recipient)) {
            $recipient = Consignee::where('primary_email', $primary_email)->firstOrFail();
        }

        $newEmail = new Email;
        $newEmail->instruction_id = $email->instruction_id;
        $newEmail->other_party_id = $recipient->id;
        $newEmail->subject = "Fwd: " . $email->subject;
        $newEmail->body = $email->body;
        $newEmail->type = 'sent';
        $newEmail->has_attachments = $email->has_attachments;
        $newEmail->read = true;
        $newEmail->other_party_type = $recipient instanceof ShippingCompany ? "shipping_company" : ($recipient instanceof Consignee ? "consignee" : "supplier");
        $newEmail->status = "pending";
        $newEmail->save();

        if ($email->has_attachments) {
            foreach ($email->emailAttachments as $attachment) {
                $emailAttachment = new EmailAttachment;
                $emailAttachment->email_id = $newEmail->id;
                $emailAttachment->orig_filename = $attachment->orig_filename;
                $emailAttachment->path = $attachment->path;
                $emailAttachment->size = $attachment->size;
                $emailAttachment->save();
            }
        }

        Mail::to($recipient->primary_email)
            ->send(new SimpleEmail($newEmail));

        return response()->json(['message' => "Email Forwaded"], 201);
    }

    public function replyEmail(Request $request)
    {
        $messages = [
            'instruction_id.*' => 'Something Went Wrong',
            'email_id.*' => 'Something Went Wrong',
            'primary_email.required' => 'Recipient Required',
            'primary_email.email' => 'Invalid Recipient',
            // 'subject.required'          => 'Email Subject Required',
            // 'subject.max'               => 'Email Subject is Too Long',
            'attachments.*.file' => 'Attachment Must Be a File',
            'body.required' => 'Email Message Required',
        ];
        Validator::make($request->all(), [
            'instruction_id' => 'required|exists:instructions,id',
            'email_id' => 'required|exists:emails,id',
            'primary_email' => 'required|email',
            // 'subject'               => 'required|max:255',
            'attachments.*' => 'sometimes|file',
            'body' => 'required'
        ], $messages)->validate();

        $email = Email::find($request->email_id);

        $primary_email = $request->primary_email;

        $recipient = ShippingCompany::where('primary_email', $primary_email)->first();
        if (empty($recipient)) {
            $recipient = Supplier::where('primary_email', $primary_email)->first();
        }
        if (empty($recipient)) {
            $recipient = Consignee::where('primary_email', $primary_email)->firstOrFail();
        }

        $newEmail = new Email;
        $newEmail->instruction_id = $request->instruction_id;
        $newEmail->other_party_id = $recipient->id;
        $newEmail->subject = 'Re: ' . str_replace('Fwd:', '', $email->subject);
        $newEmail->body = preg_replace('/\s+/', ' ', \View::make('email_templates.email', ['subject' => $newEmail->subject, 'body' => $request->body])->render());
        $newEmail->type = 'sent';
        $newEmail->has_attachments = (is_array($request->attachments) && count($request->attachments)) > 0 ? true : false;
        $newEmail->read = true;
        $newEmail->other_party_type = $recipient instanceof ShippingCompany ? "shipping_company" : ($recipient instanceof Consignee ? "consignee" : "supplier");
        $newEmail->status = "pending";
        $newEmail->save();

        if (is_array($request->attachments) && count($request->attachments) > 0) {
            for ($i = 0; $i < count($request->attachments); $i++) {
                $path = $request->attachments[$i]->store('public/attachments');

                $emailAttachment = new EmailAttachment;
                $emailAttachment->email_id = $newEmail->id;
                $emailAttachment->orig_filename = $request->attachments[$i]->getClientOriginalName();
                $emailAttachment->path = basename($path);
                $emailAttachment->size = $request->attachments[$i]->getClientSize();
                $emailAttachment->save();
            }
        }

        Mail::to($recipient->primary_email)
            ->send(new SimpleEmail($newEmail, ['References' => $email->sender_reference, 'In-Reply-To' => $email->sender_reference]));

        return response()->json(['message' => "Reply Sent"], 201);
    }

    public function getConsignment($instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);

        return collect($instruction->consignment)->map(function ($item, $key) {
            if ($key == 'confirmation_date' || $key == 'ets' || $key == 'eta')
                return Carbon::parse($item)->format('m/d/Y');
            return $item;
        });
    }

    public function bookingConfirmation(Request $request)
    {
        $messages = [
            'instruction_id.*' => 'Something Went Wrong',
            'confirmation_date.required' => 'Confirmation Date is Required',
            'confirmation_date.date' => 'Invalid Confirmation Date Format',
            'carrier.required' => 'Carrier is Required',
            'carrier.max' => 'Carrier No is too Long',
            'reference.required' => 'Reference is Required',
            'reference.max' => 'Reference is too Long',
//            'line_reference.required' => 'Line Reference is Required',
//            'line_reference.max' => 'Line Reference is too Long',
            'vessel.required' => 'Vessel is Required',
            'vessel.max' => 'Vessel is too Long',
//            'ucr.required' => 'UCR is Required',
//            'ucr.max' => 'UCR is too Long',
            'ets.required' => 'ETS is Required',
            'ets.date' => 'Invalid ETS Format',
            'eta.required' => 'ETA is Required',
            'eta.date' => 'Invalid ETA Format',
        ];
        Validator::make($request->all(), [
            'instruction_id' => 'required|exists:instructions,id',
            'confirmation_date' => 'required|date',
            'carrier' => 'required|max:255',
            'reference' => 'required|max:255',
//            'line_reference' => 'required|max:255',
//            'vessel' => 'required|max:255',
//            'ucr' => 'required|max:255',
//            'ets' => 'required|date|max:255',
            'eta' => 'required|date|max:255',
        ], $messages)->validate();

        $instruction = Instruction::find($request->instruction_id);
        $instruction->status = $instruction->status == "pending" ? "processing" : $instruction->status;
        $instruction->save();

        $consignment = Consignment::where('instruction_id', $instruction->id)->first();
        $consignment->confirmation_date = Carbon::parse($request->confirmation_date)->format('Y-m-d');
        $consignment->carrier = $request->carrier;
        $consignment->reference = $request->reference;
        $consignment->line_reference = ($request->line_reference) ? $request->line_reference : '--';
        $consignment->vessel = $request->vessel;
        $consignment->ucr = ($request->ucr) ? $request->ucr : '--';
        $consignment->ets = ($request->ets) ? Carbon::parse($request->ets)->format('Y-m-d') : null;
        $consignment->eta = Carbon::parse($request->eta)->format('Y-m-d');
        $consignment->tracking_url = $request->tracking_url;
        $consignment->save();

        return response()->json(['message' => "Booking Info Updated."], 200);
    }

    public function trackingInfo(Request $request)
    {
        $messages = [
            'instruction_id.*' => 'Something Went Wrong',
            'courier_service.required' => 'Courier Service is Required',
            'courier_service.in' => 'Only DHL and UPS are Supported For Now',
            'courier_tracking_no.required' => 'Tracking No is Required',
            'courier_tracking_no.max' => 'Tracking No is too Long',
            'courier_status.required' => 'Status is Required',
            'courier_status.in' => 'Invalid Status',
        ];
        Validator::make($request->all(), [
            'instruction_id' => 'required|exists:instructions,id',
            'courier_service' => 'required|in:dhl,ups,fedx',
            'courier_tracking_no' => 'required|max:255',
            'courier_status' => 'required|in:booked,dispatched,delivered',
        ], $messages)->validate();

        $instruction = Instruction::find($request->instruction_id);

        $consignment = Consignment::where('instruction_id', $instruction->id)->first();
        $consignment->document_sent = TRUE;
        $consignment->courier_service = $request->courier_service;
        $consignment->courier_tracking_no = $request->courier_tracking_no;
        $consignment->courier_last_tracked = Carbon::now()->format('Y-m-d');;
        $consignment->courier_status = $request->courier_status;
        $consignment->save();

        return response()->json(['message' => "Tracking Info Updated."], 200);
    }

    public function emailInvoice(Request $request)
    {
        $messages = [
            'instruction_id.*' => 'Something Went Wrong',
            'primary_email.required' => 'Recipient Required',
            'primary_email.email' => 'Invalid Recipient',
            'subject.required' => 'Email Subject Required',
            'subject.max' => 'Email Subject is Too Long',
            'attachments.*.file' => 'Attachment Must Be a File',
            'body.required' => 'Email Message Required',
        ];
        Validator::make($request->all(), [
            'instruction_id' => 'required|exists:instructions,id',
            'primary_email' => 'required|email',
            'subject' => 'required|max:255',
            'body' => 'required'
        ], $messages)->validate();

        $primary_email = $request->primary_email;

        $recipient = ShippingCompany::where('primary_email', $primary_email)->first();
        if (empty($recipient)) {
            $recipient = Supplier::where('primary_email', $primary_email)->first();
        }
        if (empty($recipient)) {
            $recipient = Consignee::where('primary_email', $primary_email)->firstOrFail();
        }

        $newEmail = new Email;
        $newEmail->instruction_id = $request->instruction_id;
        $newEmail->other_party_id = $recipient->id;
        $newEmail->subject = $request->subject;
        $newEmail->body = preg_replace('/\s+/', ' ', \View::make('email_templates.email', ['subject' => $request->subject, 'body' => $request->body])->render());
        $newEmail->type = 'sent';
        $newEmail->has_attachments = true;
        $newEmail->read = true;
        $newEmail->other_party_type = $recipient instanceof ShippingCompany ? "shipping_company" : ($recipient instanceof Consignee ? "consignee" : "supplier");
        $newEmail->status = "pending";
        $newEmail->save();
        $newEmail->only_body = $request->body; //Little Hack

//        $path = storage_path('app/public/attachments/invoice_' . $request->instruction_id . '.pdf');
        $path = storage_path('app/public/attachments/invoice_' . $newEmail->id . '.pdf');

        $invoice_generation_done = false;

        if (is_file($path)) {
            unlink($path);
            // $attachmentExist                    = EmailAttachment::where('path', basename($path))->first();
            // if(!empty($attachmentExist))
            // {
            //     $emailAttachment                    = new EmailAttachment;
            //     $emailAttachment->email_id          = $newEmail->id;
            //     $emailAttachment->orig_filename     = $attachmentExist->orig_filename;
            //     $emailAttachment->path              = basename($path);
            //     $emailAttachment->size              = $attachmentExist->size;
            //     $emailAttachment->save();
            //     $invoice_generation_done            = true;
            // }
        }

        if (!$invoice_generation_done) {
            /*
                Generate & Save Invoice
            */
            $pdf = \PDF::loadView('pdf.invoice', ['instruction' => Instruction::findOrFail($request->instruction_id)]);
            $pdf->save($path);

            $emailAttachment = new EmailAttachment;
            $emailAttachment->email_id = $newEmail->id;
            $emailAttachment->orig_filename = basename($path);
            $emailAttachment->path = basename($path);
            $emailAttachment->size = filesize($path);
            $emailAttachment->save();
            $invoice_generation_done = true;
        }

        Mail::to($recipient->primary_email)
            ->send(new SimpleEmail($newEmail));

        return response()->json(['message' => "Invoice Sent"], 201);
    }

    public function downloadInvoice($instruction_id)
    { //return view('pdf.invoice', ['instruction' => Instruction::findOrFail($instruction_id)]);
        /*
            Generate & Save Invoice
        */
        $pdf = \PDF::loadView('pdf.invoice', ['instruction' => Instruction::findOrFail($instruction_id)]);

        return $pdf->download('invoice_' . $instruction_id . '.pdf');
    }

    public function saveItems(Request $request, $instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);
        $consignment = Consignment::where('instruction_id', $instruction->id)->firstOrFail();

        $messages = [
            `currency_id.exists` => 'Invalid Currency',
            'description.*.required' => 'Description is Required',
            'description.*.max' => 'Description is too Big',
            'container_no.*.required' => 'Container No is Required',
            'container_no.*.max' => 'Container No is too Big',
            'seal_no.*.required' => 'Seal No is Required',
            'seal_no.*.max' => 'Seal No is too Big',
            'tare_weight.*.numeric' => 'Weight Must be a Numeric Value',
            'item_weight.*.required' => 'Weight is Required',
            'item_weight.*.numeric' => 'Weight Must be a Numeric Value',
            'price.*.required' => 'Price is Required',
            'price.*.numeric' => 'Price Must be a Numeric Value'
        ];
        Validator::make($request->all(), [
            'currency_id' => 'required|exists:currencies,id',
            'container_no.*' => 'required|max:255',
            'seal_no.*' => 'required|max:255',
            'tare_weight.*' => 'sometimes|numeric',
            'description.*' => 'required|max:255',
            'item_weight.*' => 'required|numeric',
            'price.*' => 'required|numeric'
        ], $messages)->validate();

        $consignment->consignmentDetails()->delete();

        $total_weight = 0;
        $total_price = 0;

        foreach ($request->description as $i => $description) {
            $item = new ConsignmentDetail;
            $item->consignment_id = $consignment->id;
            $item->description = $description;
            $item->container_no = $request->container_no[$i];
            $item->seal_no = $request->seal_no[$i];
            $item->tare_weight = (float)$request->tare_weight[$i];
            $item->item_weight = (float)$request->item_weight[$i];
            $item->price = (float)$request->price[$i];
            $item->total_price = (float)$item->item_weight * $item->price;
            $item->save();

            $total_weight += $item->item_weight;
            $total_price += $item->total_price;
        }

        $instruction->weight = $total_weight;
        $instruction->save();

        $consignment->currency_id = $request->currency_id;
        // $consignment->container_no  = $request->container_no;
        // $consignment->seal_no       = $request->seal_no;
        $consignment->weight = $total_weight;
        $consignment->price = $total_price;
        $consignment->save();

        return response()->json(['message' => "Invoice Updated"], 200);
    }

    public function saveConsignee(Request $request, $instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);
        $consignment = Consignment::where('instruction_id', $instruction->id)->firstOrFail();

        $messages = [
            `consignee_id.exists` => 'Invalid Consignee'
        ];
        Validator::make($request->all(), [
            'consignee_id' => 'required|exists:consignees,id'
        ], $messages)->validate();

        $consignment->consignee_id = $request->consignee_id;
        $consignment->save();

        return response()->json(['message' => "Consignee Updated"], 200);
    }

    public function saveNotify(Request $request, $instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);
        $consignment = Consignment::where('instruction_id', $instruction->id)->firstOrFail();

        $messages = [
            `consignee_id.exists` => 'Invalid Consignee'
        ];
        Validator::make($request->all(), [
            'consignee_id' => 'required|exists:consignees,id'
        ], $messages)->validate();

        $consignment->notify_party_id = $request->consignee_id;
        $consignment->save();

        return response()->json(['message' => "Notify Party Updated"], 200);
    }

    public function downloadSI($instruction_id, $startDownload = true)
    {
        /*
            Generate SI Document
        */
        $instruction = Instruction::findOrFail($instruction_id);

        $spreadsheet = IOFactory::load(storage_path('si_document.xls'));
        $worksheet = $spreadsheet->getActiveSheet();

        // Client Details
        $worksheet->getCell('A11')->setValue($instruction->consignment->consignee->name ?? '-');
        $worksheet->getCell('A12')->setValue($instruction->consignment->consignee->address ?? '-');
        $worksheet->getCell('A13')->setValue($instruction->consignment->consignee->city->name ?? '-');
        $worksheet->getCell('A14')->setValue($instruction->consignment->consignee->country->name ?? '-');
        //Notify Party
        if (isset($instruction->consignment->notifyParty)) {
            $worksheet->getCell('A16')->setValue($instruction->consignment->notifyParty->name ?? '-');
            $worksheet->getCell('A17')->setValue($instruction->consignment->notifyParty->address ?? '-');
            $worksheet->getCell('A18')->setValue($instruction->consignment->notifyParty->city->name ?? '-');
            $worksheet->getCell('A19')->setValue($instruction->consignment->notifyParty->country->name ?? '-');
        }

        // Ports Details
        $worksheet->getCell('D23')->setValue($instruction->consignment->loadingPort->name ?? '-');
        $worksheet->getCell('A25')->setValue($instruction->consignment->dischargePort->name ?? '-');
        $worksheet->getCell('D25')->setValue($instruction->consignment->final_destination ?? '-');

        //Invoice Items
        if (optional($instruction->consignment->consignmentDetails)->count() > 0) {
            $row_id = 29;
            $total_weight = 0;
            foreach ($instruction->consignment->consignmentDetails as $item) {
                $worksheet->getCell('A' . $row_id)->setValue($item->container_no);
                $worksheet->getCell('B' . $row_id)->setValue($item->seal_no);
                $worksheet->getCell('C' . $row_id)->setValue($item->description);
                $worksheet->getCell('D' . $row_id++)->setValue(number_format($item->item_weight, 3, '.', ''));
                $total_weight += $item->item_weight;
            }
            $worksheet->getCell('D40')->setValue(number_format($total_weight, 3, '.', ''));
        }

        $worksheet->getCell('G29')->setValue($instruction->instruction);
        if (isset($total_weight)) {
            $worksheet->getCell('H40')->setValue($total_weight);
        }

        $worksheet->getCell('H40')->setValue('');

        if (is_file(storage_path('SI_' . $instruction->id . '.xls'))) {
            unlink(storage_path('SI_' . $instruction->id . '.xls'));
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save(storage_path('app/public/attachments/SI_' . $instruction->id . '.xls'));

        if ($startDownload)
            return response()->download(storage_path('app/public/attachments/SI_' . $instruction->id . '.xls'));

        return storage_path('app/public/attachments/SI_' . $instruction->id . '.xls');
    }

    public function emailDocuments(Request $request)
    {


        $messages = [
            'instruction_id.*' => 'Something Went Wrong',
            'primary_email.required' => 'Recipient Required',
            'primary_email.email' => 'Invalid Recipient',
            'subject.required' => 'Email Subject Required',
            'subject.max' => 'Email Subject is Too Long',
            'attachments.*.file' => 'Attachment Must Be a File',
            'body.required' => 'Email Message Required',
        ];
        Validator::make($request->all(), [
            'instruction_id' => 'required|exists:instructions,id',
            'primary_email' => 'required|email',
            'subject' => 'required|max:255',
            'body' => 'required'
        ], $messages)->validate();



        $primary_email = $request->primary_email;

        $recipient = ShippingCompany::where('primary_email', $primary_email)->first();
        if (empty($recipient)) {
            $recipient = Supplier::where('primary_email', $primary_email)->first();
        }
        if (empty($recipient)) {
            $recipient = Consignee::where('primary_email', $primary_email)->firstOrFail();
        }

        $newEmail = new Email;
        $newEmail->instruction_id = $request->instruction_id;
        $newEmail->other_party_id = $recipient->id;
        $newEmail->subject = $request->subject;
        $newEmail->body = preg_replace('/\s+/', ' ', \View::make('email_templates.email', ['subject' => $request->subject, 'body' => $request->body])->render());
        $newEmail->type = 'sent';
        $newEmail->has_attachments = true;
        $newEmail->read = true;
        $newEmail->other_party_type = $recipient instanceof ShippingCompany ? "shipping_company" : ($recipient instanceof Consignee ? "consignee" : "supplier");
        $newEmail->status = "pending";
        $newEmail->save();
        $newEmail->only_body = $request->body; //Little Hack



        if (is_array($request->attachments) && count($request->attachments) > 0) {
            for ($i = 0; $i < count($request->attachments); $i++) {
                $path = $request->attachments[$i]->store('public/attachments');
                $emailAttachment = new EmailAttachment;
                $emailAttachment->email_id = $newEmail->id;
                $emailAttachment->orig_filename = $request->attachments[$i]->getClientOriginalName();
                $emailAttachment->path = basename($path);
                $emailAttachment->size = $request->attachments[$i]->getClientSize();
                $emailAttachment->save();
            }
        }




        $path = storage_path('app/public/attachments/invoice_' . $newEmail->id . '.pdf');
//        $path = storage_path('app/public/attachments/invoice_' . $request->instruction_id . '.pdf');

        $pdf = \PDF::loadView('pdf.invoice', ['instruction' => Instruction::findOrFail($request->instruction_id)]);
        $pdf->save($path);

        $emailAttachment = new EmailAttachment;
        $emailAttachment->email_id = $newEmail->id;
        $emailAttachment->orig_filename = basename($path);
        $emailAttachment->path = basename($path);
        $emailAttachment->size = filesize($path);
        $emailAttachment->save();

        $path = $this->downloadVGMEmail($request->instruction_id, false, $newEmail->id);

        $emailAttachment = new EmailAttachment;
        $emailAttachment->email_id = $newEmail->id;
        $emailAttachment->orig_filename = basename($path);
        $emailAttachment->path = basename($path);
        $emailAttachment->size = filesize($path);
        $emailAttachment->save();

        $path = $this->downloadSIEmail($request->instruction_id, false, $newEmail->id);

        $emailAttachment = new EmailAttachment;
        $emailAttachment->email_id = $newEmail->id;
        $emailAttachment->orig_filename = basename($path);
        $emailAttachment->path = basename($path);
        $emailAttachment->size = filesize($path);
        $emailAttachment->save();

        Mail::to($recipient->primary_email)
            ->send(new SimpleEmail($newEmail));

        return response()->json(['message' => "Documents Sent"], 201);
    }

    public function downloadVGM($instruction_id, $startDownload = true)
    {
        /*
            Generate SI Document
        */
        $instruction = Instruction::findOrFail($instruction_id);

        $spreadsheet = IOFactory::load(storage_path('vgm_form.xls'));
        $worksheet = $spreadsheet->getActiveSheet();

        $row_id = 2;
        foreach ($instruction->consignment->consignmentDetails as $item) {
            $worksheet->getCell('A' . $row_id)->setValue($item->container_no);
            $worksheet->getCell('B' . $row_id)->setValue(($item->tare_weight));
            $worksheet->getCell('C' . $row_id)->setValue(($item->item_weight * 1000));
            $worksheet->getCell('D' . $row_id++)->setValue(($item->item_weight * 1000) + ($item->tare_weight));
        }

        if (is_file(storage_path('VGM_FORM_' . $instruction->id . '.xls'))) {
            unlink(storage_path('VGM_FORM_' . $instruction->id . '.xls'));
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save(storage_path('app/public/attachments/VGM_FORM_' . $instruction->id . '.xls'));

        if ($startDownload)
            return response()->download(storage_path('app/public/attachments/VGM_FORM_' . $instruction->id . '.xls'));

        return storage_path('app/public/attachments/VGM_FORM_' . $instruction->id . '.xls');
    }

    public function downloadVGMEmail($instruction_id, $startDownload = true, $emailId)
    {
        /*
            Generate SI Document
        */
        $instruction = Instruction::findOrFail($instruction_id);

        $spreadsheet = IOFactory::load(storage_path('vgm_form.xls'));
        $worksheet = $spreadsheet->getActiveSheet();

        $row_id = 2;
        foreach ($instruction->consignment->consignmentDetails as $item) {
            $worksheet->getCell('A' . $row_id)->setValue($item->container_no);
            $worksheet->getCell('B' . $row_id)->setValue(($item->tare_weight));
            $worksheet->getCell('C' . $row_id)->setValue(($item->item_weight * 1000));
            $worksheet->getCell('D' . $row_id++)->setValue(($item->item_weight * 1000) + ($item->tare_weight));
        }

        if (is_file(storage_path('VGM_FORM_' . $emailId . '.xls'))) {
            unlink(storage_path('VGM_FORM_' . $emailId . '.xls'));
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save(storage_path('app/public/attachments/VGM_FORM_' . $emailId . '.xls'));

        if ($startDownload)
            return response()->download(storage_path('app/public/attachments/VGM_FORM_' . $emailId . '.xls'));

        return storage_path('app/public/attachments/VGM_FORM_' . $emailId . '.xls');
    }

    public function downloadSIEmail($instruction_id, $startDownload = true, $emailId)
    {
        /*
            Generate SI Document
        */
        $instruction = Instruction::findOrFail($instruction_id);

        $spreadsheet = IOFactory::load(storage_path('si_document.xls'));
        $worksheet = $spreadsheet->getActiveSheet();

        // Client Details
        $worksheet->getCell('A11')->setValue($instruction->consignment->consignee->name ?? '-');
        $worksheet->getCell('A12')->setValue($instruction->consignment->consignee->address ?? '-');
        $worksheet->getCell('A13')->setValue($instruction->consignment->consignee->city->name ?? '-');
        $worksheet->getCell('A14')->setValue($instruction->consignment->consignee->country->name ?? '-');
        //Notify Party
        if (isset($instruction->consignment->notifyParty)) {
            $worksheet->getCell('A16')->setValue($instruction->consignment->notifyParty->name ?? '-');
            $worksheet->getCell('A17')->setValue($instruction->consignment->notifyParty->address ?? '-');
            $worksheet->getCell('A18')->setValue($instruction->consignment->notifyParty->city->name ?? '-');
            $worksheet->getCell('A19')->setValue($instruction->consignment->notifyParty->country->name ?? '-');
        }

        // Ports Details
        $worksheet->getCell('D23')->setValue($instruction->consignment->loadingPort->name ?? '-');
        $worksheet->getCell('A25')->setValue($instruction->consignment->dischargePort->name ?? '-');
        $worksheet->getCell('D25')->setValue($instruction->consignment->final_destination ?? '-');

        //Invoice Items
        if (optional($instruction->consignment->consignmentDetails)->count() > 0) {
            $row_id = 29;
            $total_weight = 0;
            foreach ($instruction->consignment->consignmentDetails as $item) {
                $worksheet->getCell('A' . $row_id)->setValue($item->container_no);
                $worksheet->getCell('B' . $row_id)->setValue($item->seal_no);
                $worksheet->getCell('C' . $row_id)->setValue($item->description);
                $worksheet->getCell('D' . $row_id++)->setValue(number_format($item->item_weight / 1000, 3, '.', ''));
                $total_weight += $item->item_weight;
            }
            $worksheet->getCell('D40')->setValue(number_format($total_weight / 1000, 3, '.', ''));
        }

        $worksheet->getCell('G29')->setValue($instruction->instruction);
        if (isset($total_weight)) {
            $worksheet->getCell('H40')->setValue($total_weight);
        }

        $worksheet->getCell('H40')->setValue('');

        if (is_file(storage_path('SI_' . $emailId . '.xls'))) {
            unlink(storage_path('SI_' . $emailId . '.xls'));
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save(storage_path('app/public/attachments/SI_' . $emailId . '.xls'));

        if ($startDownload)
            return response()->download(storage_path('app/public/attachments/SI_' . $emailId . '.xls'));

        return storage_path('app/public/attachments/SI_' . $emailId . '.xls');
    }


    public function getTrackingURL($carrier_id)
    {
        $carrier = Carrier::findOrFail($carrier_id);
        return response()->json(['tracking_url' => $carrier->tracking_url], 200);

    }
}
