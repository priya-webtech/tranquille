<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';

    protected $fillable = [
        'active', 'offer_title', 'discount', 'vendor_id', 'offer_image'
    ];

    public function vendorinfo()
    {
        return $this->belongsTo('App\Models\User', 'vendor_id', 'id')->select('id', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile'));
    }
}
