<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorService extends Model
{
    use HasFactory;

    protected $table = 'vendor_services';

    protected $fillable = [ 'active', 'service_id', 'vendor_id', 'discount', 'created_at', 'updated_at'];

    public function serviceinfo()
    {
        return $this->belongsTo('App\Models\Services', 'service_id', 'id')->select('id','service_name', 'service_image', 'small_image');
    }
}
