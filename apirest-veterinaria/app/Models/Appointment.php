<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}