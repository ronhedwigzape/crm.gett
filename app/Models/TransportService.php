<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportService extends ServiceDetail
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'transport_type',
        'pickup_location',
        'dropoff_location',
        'pickup_datetime',
        'fee'
    ];

    public function service()
    {
        return $this->morphOne(Service::class, 'serviceDetail');
    }
}
