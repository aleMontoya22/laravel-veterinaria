<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ["name", "species", "age", "weigth"];
    //RELACION 1 A 1

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}