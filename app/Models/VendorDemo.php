<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDemo extends Model
{
    use HasFactory;
    protected $table = 'vendor_demos';
    protected $fillable = [
        'active', 'vendor_id', 'demo_image', 'created_by', 'deleted_at', 'created_at', 'updated_at'
    ];
}
