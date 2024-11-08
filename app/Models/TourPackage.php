<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends ServiceDetail
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'package_name', 'destination',
        'amount', 'itinerary', 'start_date', 'end_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function service()
    {
        return $this->morphOne(Service::class, 'serviceDetail');
    }
}
