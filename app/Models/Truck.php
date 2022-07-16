<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $fillable = ['license_plate', 'driver_id', 'model', 'color'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
