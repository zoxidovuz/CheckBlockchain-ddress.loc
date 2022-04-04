<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    public $timestamps = false;
    protected $table = 'analytics';
    protected $fillable = [
        'address_id',
        'ip',
        'country',
	    'city',
        'browser',
	    'date',
        'latitude',
        'longitude'
    ];
}
