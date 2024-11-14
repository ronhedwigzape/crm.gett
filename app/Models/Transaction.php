<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'client_id',
        'service_id',
        'status_id',
        'transaction_date',
        'user_id',
        'total_amount',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function serviceDetail()
    {
        return $this->morphTo();
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
