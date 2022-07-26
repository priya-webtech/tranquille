<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProduct extends Model
{
    use HasFactory;

    protected $table = 'vendor_products';

    protected $fillable = [ 'active', 'vendor_id', 'treatment_id','productbrand_id', 'created_at', 'updated_at'];

    public function productbrandinfo()
    {
        return $this->belongsTo('App\Models\ProductBrand', 'productbrand_id', 'id')->select('id', 'service_id', 'treatment_id', 'brand_name', 'brand_image');
    }
}
