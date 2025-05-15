<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    public function email()
    {
    	return $this->belongsTo(Email::class);
    }
}
