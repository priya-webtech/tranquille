<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'active', 'country_name', 'country_code', 'phone_code', 'currency', 'flag', 'created_at', 'updated_at' 
    ];
}
