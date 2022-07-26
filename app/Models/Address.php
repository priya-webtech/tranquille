<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'active', 'user_id', 'is_main', 'address_line1', 'address_line2', 'state', 'city', 'postcode', 'latitude', 'longitude', 'location_address', 'created_at', 'updated_at'
    ];
}
