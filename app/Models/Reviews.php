<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    public $timestamps = false;
    protected $table = 'Reviews';
    protected $primaryKey = 'ID_Reviews';

    protected $fillable = [
        'ID_Reviews',
        'Date_Reviews',
        'Date_Reviews',
        'Addresses',
        'ID_address',
        'Blockchain',
        'IP_address',
        'Region',
        'Browser',
        'Name',
        'Tag',
        'Rating',
        'Reviews_text',
        'Public_status'
    ];

    public function tags(){
        return $this->hasMany(Tags::class, 'Addresses', 'Addresses');
    }

    public function reviews(){
        return $this->hasMany(self::class, 'ID_address', 'ID_address')->where('Public_status', 1);
    }
}
