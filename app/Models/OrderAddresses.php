<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddresses extends Model
{
    public $timestamps = false;
    protected $guarded = [];


    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
