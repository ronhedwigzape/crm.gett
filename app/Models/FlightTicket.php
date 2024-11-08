<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightTicket extends ServiceDetail
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'airline_id', 'flight_number',
        'departure_airport', 'arrival_airport', 'departure_date',
        'amount', 'arrival_date', 'seat_class',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function service()
    {
        return $this->morphOne(Service::class, 'serviceDetail');
    }
}
