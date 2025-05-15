<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class State extends Model
{
    protected $table = "states";
    protected $guarded = [];
}
