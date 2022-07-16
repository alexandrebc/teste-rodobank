<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cpf', 'birth_date', 'email'];

    public function trucks()
    {
        return $this->hasMany(Truck::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
