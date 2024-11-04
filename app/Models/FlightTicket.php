<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'service_id', 'status_id', 'airline_id',
        'flight_number', 'departure_date', 'arrival_date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
}
