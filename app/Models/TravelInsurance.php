<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelInsurance extends ServiceDetail
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'insurance_provider',
        'policy_number',
        'start_date',
        'end_date',
        'coverage_amount'
    ];

    public function service()
    {
        return $this->morphOne(Service::class, 'serviceDetail');
    }
}
