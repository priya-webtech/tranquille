<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'active', 'reviewby', 'reviewto', 'booking_id', 'treatment_id', 'rating', 'ambiance', 'hygiene', 'medewerkers', 'review', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function userinfo()
    {
        return $this->belongsTo('App\Models\User', 'reviewby', 'id')->select('id', 'name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("' . URL::to('/') . '", "/public/", profile) AS profile'));
    }
    public function vendor()
    {
        return $this->belongsTo('App\Models\User', 'reviewto', 'id')->select('id', 'name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("' . URL::to('/') . '", "/public/", profile) AS profile'));
    }
    public function vendorinfo()
    {
        return $this->belongsTo('App\Models\VendorDetail', 'reviewto', 'vendor_id')->select('id', 'vendor_id', 'firm_name',  DB::raw('CONCAT("' . URL::to('/') . '", "/public/", logo) AS logo'));
    }
    public function bookinginfo()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'id')->select('id', 'service_id', 'treatment_id', 'address_id', 'booking_date', 'booking_time', 'orderid');
    }
    public function treatmentinfo()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'id')->select('id', 'service_id', 'treatment_id', 'address_id', 'booking_date', 'booking_time', 'orderid');
    }
}
