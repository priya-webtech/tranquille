<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    use HasFactory;
    protected $table = 'contactuses';

    protected $fillable = [
        'name', 'message', 'email', 'phone','created_at', 'updated_at' 
    ];
}
