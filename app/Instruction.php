<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instruction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'case_datetime',
        'pickup_datetime'
    ];

//    public function setcase_datetimeAttribute($value)
//    {
//        $this->attributes['case_datetime'] = Carbon::createFromFormat('d/m/Y', $value);
//    }
//
//    public function setpickup_datetimeAttribute($value)
//    {
//        $this->attributes['pickup_datetime'] = Carbon::createFromFormat('d/m/Y', $value);
//    }

    public function shippingCompany()
    {
        return $this->belongsTo(ShippingCompany::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function consignment()
    {
        return $this->hasOne(Consignment::class);
    }

    public function consignee()
    {
        return $this->belongsTo(Consignee::class, 'consignee_id', 'id');
    }
}
