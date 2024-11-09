<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristVisa extends ServiceDetail
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'visa_type',
        'country',
        'issue_date',
        'expiry_date',
        'fee'
    ];

    public function service()
    {
        return $this->morphOne(Service::class, 'serviceDetail');
    }
}
