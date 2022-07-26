<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTreatment extends Model
{   
    use HasFactory;

    protected $table = 'vendor_treatments';
    protected $fillable = [ 'vendor_id', 'treatment_id', 'description', 'price', 'discount', 'no_of_person', 'created_at', 'updated_at' ];

    public function treatmentinfo()
    {
        return $this->belongsTo('App\Models\Treatment', 'treatment_id', 'id')->select('id','treatment_name', 'treatment_image', 'small_image');
    }
}
