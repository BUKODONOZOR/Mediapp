<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'document', 
        'email',
        'name',
        'age',
        'phone_number', 
        'address',      
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}