<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Treatment extends Model
{
    use HasFactory;

    protected $table = 'treatments';

    protected $fillable = [
        'active', 'service_id', 'treatment_name', 'treatment_image', 'small_image', 'rank', 'created_at', 'updated_at', 'feature'
    ];

    public function productbrands()
    {
        return $this->hasMany('App\Models\ProductBrand', 'treatment_id', 'id')->select('id', 'treatment_id', 'brand_name', DB::raw('CONCAT("' . URL::to('/') . '/public/", brand_image) AS brand_image '));
    }

    public function serviceinfo()
    {
        return $this->belongsTo('App\Models\Services', 'service_id', 'id')->select('id', 'service_name', DB::raw('CONCAT("' . URL::to('/') . '/public/", service_image) AS service_image '));
    }
}
