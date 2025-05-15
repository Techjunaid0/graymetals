<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
	use SoftDeletes;

	private function supplier()
	{
		return $this->belongsTo(Supplier::class, 'other_party_id');
	}

	private function shippingCompany()
	{
		return $this->belongsTo(ShippingCompany::class, 'other_party_id');
	}

	private function consignee()
	{
		return $this->belongsTo(Consignee::class, 'other_party_id');
	}

	public function otherParty()
	{
		if($this->other_party_type == 'supplier')
			return $this->supplier()->first();
		elseif($this->other_party_type == 'shipping_company')
			return $this->shippingCompany()->first();
		elseif($this->other_party_type == 'consignee')
			return $this->consignee()->first();
		else
			return;
	}

	public function emailAttachments()
	{
		return $this->hasMany(EmailAttachment::class);
	}
}
