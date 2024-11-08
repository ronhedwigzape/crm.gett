<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function serviceDetail()
    {
        return $this->morphTo();
    }
}
