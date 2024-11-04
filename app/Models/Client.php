<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

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
