<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'note'
    ];

    public function Booking(){
        return $this->hasMany(Booking::class);
    }
}
