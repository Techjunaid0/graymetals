<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instruction;
use App\Email;
use App\EmailAttachment;
use Storage;

class WebhookController extends Controller
{
    public function receiveEmail(Request $request)
    {
    	if(!empty($request->recipient))
    	{
    		$reference 			= $request->References ?? $request->get('In-Reply-To');
    		$sender_reference 	= $request->get('Message-Id');
    		if(!empty($reference) && Email::where('reference', $reference)->count() > 1)
    		{
                \Log::debug('Email Already Exist');
    			return response()->json([ 'error' => 409, 'message' => 'Email Already Exist'], 409);
    		}

    		$instruction_id = (int) explode('_', explode('@', $request->recipient)[0])[1];

    		$instruction 	= Instruction::find($instruction_id);
    		if(empty($instruction))
    		{
                \Log::debug('Not instruction found for ' . $request->recipient);
    			return response()->json([ 'error' => 404, 'message' => 'Not instruction found for ' . $request->recipient], 404);
    		}

    		$newEmail 					= new Email;
    		$newEmail->instruction_id 	= $instruction->id;
    		$newEmail->subject 			= $request->Subject;
    		$newEmail->body 			= $request->get('stripped-html', $request->get('stripped-text', "Empty Body"));
    		$newEmail->type 			= 'received';
    		$newEmail->sender_reference = $sender_reference;
    		$newEmail->reference 		= $reference;
    		$newEmail->read 			= false;
    		$newEmail->status 			= 'deliverd';

    		if($instruction->supplier->primary_email == $request->sender)
    		{
    			$newEmail->other_party_id 	= $instruction->supplier->id;
    			$newEmail->other_party_type = 'supplier';
    		}
    		elseif($instruction->shippingCompany->primary_email == $request->sender)
    		{
    			$newEmail->other_party_id 	= $instruction->shippingCompany->id;
    			$newEmail->other_party_type = 'shipping_company';
    		}
    		else
    		{
                if(isset($instruction->consignment->consignee->primary_email))
                {
                    if($instruction->consignment->consignee->primary_email == $request->sender)
                    {
                        $newEmail->other_party_id   = $instruction->consignment->consignee->id;
                        $newEmail->other_party_type = 'consignee';
                    }
                    else
                    {
                        \Log::debug('Unknown Sender');
                        return response()->json([ 'error' => 422, 'message' => 'Unknown Sender'], 422);
                    }
                }
                else
                {
                    \Log::debug('Unknown Sender');
        			return response()->json([ 'error' => 422, 'message' => 'Unknown Sender'], 422);
                }
    		}

    		if($request->get('attachment-count') && $request->get('attachment-count') >= 1)
    		{
    			$newEmail->has_attachments 	= true;
    			$newEmail->save();

    			for($i = 1; $i <= $request->get('attachment-count'); $i++)
    			{
    				$file_index = 'attachment-' . $i;
    				if ($request->hasFile($file_index) && $request->file($file_index)->isValid()) 
    				{
	    				$path = $request->file($file_index)->store('public/attachments');

	    				$emailAttachment 					= new EmailAttachment;
	    				$emailAttachment->email_id  		= $newEmail->id;
	    				$emailAttachment->orig_filename  	= $request->file($file_index)->getClientOriginalName();
	    				$emailAttachment->path  			= basename($path);
	    				$emailAttachment->size  			= $request->file($file_index)->getClientSize();
	    				$emailAttachment->save();
	    			}
    			}
    		}
    		else
    		{
    			$newEmail->has_attachments 	= false;
    			$newEmail->save();
    		}
            \Log::debug('Email Saved');
    		return response()->json(['message' => "Email Saved"], 201);
    	}
        \Log::debug('Recipient required');
    	return response()->json([ 'error' => 422, 'message' => 'Recipient required' ], 422);
    }
}
