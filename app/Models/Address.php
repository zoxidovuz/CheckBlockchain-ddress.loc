<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function tags(){
    return $this->hasMany(Tags::class, 'ID_address', 'ID_address');
}

    public function reviews(){
        return $this->hasMany(Reviews::class, 'ID_address', 'ID_address');
    }
}
