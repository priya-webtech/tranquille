<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ProductBrand extends Model
{
    use HasFactory;
    protected $table = 'product_brands';

    protected $fillable = [ 'active', 'service_id', 'treatment_id', 'brand_name', 'brand_image', 'created_at', 'updated_at'];

    public function serviceinfo()
    {
        return $this->belongsTo('App\Models\Services', 'service_id', 'id')->select('id', 'service_name', DB::raw('CONCAT("'.URL::to('/').'", "/public/", service_image) AS service_image'));
    }
    public function treatmentinfo()
    {
        return $this->belongsTo('App\Models\Treatment', 'treatment_id', 'id')->select('id', 'treatment_name', DB::raw('CONCAT("'.URL::to('/').'", "/public/", treatment_image) AS treatment_image'));
    }
}
