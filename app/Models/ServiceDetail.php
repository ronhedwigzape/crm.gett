<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class ServiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }


}

