<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['driver_id', 'shipping_id'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
}
