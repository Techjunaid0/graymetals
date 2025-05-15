<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignment extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmation_date', 
        'ets',
        'eta',
        'courier_last_tracked'
    ];

    public function instruction()
    {
    	return $this->belongsTo(Instruction::class);
    }

    public function consignee()
    {
    	return $this->belongsTo(Consignee::class);
    }

    public function loadingPort()
    {
        return $this->belongsTo(Port::class, 'loading_port_id');
    }

    public function dischargePort()
    {
        return $this->belongsTo(Port::class, 'discharge_port_id');
    }

    public function consignmentDetails()
    {
        return $this->hasMany(ConsignmentDetail::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function notifyParty()
    {
        return $this->belongsTo(Consignee::class, 'notify_party_id');
    }

    public function shipper(){
        return $this->belongsTo(Shipper::class, 'shipper_id');
    }
}
