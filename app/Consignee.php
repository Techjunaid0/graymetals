<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignee extends Model
{
    use SoftDeletes;

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }

    public function state()
    {
    	return $this->belongsTo(State::class);
    }

    public function city()
    {
    	return $this->belongsTo(City::class);
    }
    public function consignment()
    {
        return $this->hasMany(Consignment::class);
    } 
    public function loadingPort()
    {
        return $this->belongsTo(Port::class, 'loading_port_id');
    }

    public function dischargePort()
    {
        return $this->belongsTo(Port::class, 'discharge_port_id');
    }
}
