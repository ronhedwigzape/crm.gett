<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBooking extends ServiceDetail
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'hotel_name',
        'location',
        'check_in_date',
        'check_out_date',
        'num_guests',
        'fee',
    ];

    public function service()
    {
        return $this->morphOne(Service::class, 'serviceDetail');
    }

}
