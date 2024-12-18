<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Doctor extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'specialty', 
        'start_time',
        'end_time',   
        'phone_number', 
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
