<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'service_name',
        'booking_date',
        'booking_time',
        'people_count',
        'price',
        'status',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
