<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_type',
        'description',
        'service_detail_type',
        'service_detail_id',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function serviceDetail()
    {
        return $this->morphTo();
    }
}
