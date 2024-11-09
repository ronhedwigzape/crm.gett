<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'email',
        'phone', 'address', 'date_of_birth', 'gender',
        'passport_number', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flightTickets()
    {
        return $this->hasMany(FlightTicket::class);
    }

    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
