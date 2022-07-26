<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = [ 'user_id', 'vendor_id', 'booking_id', 'amount', 'transaction_id', 'transaction_at', 'description', 'response', 'status', 'created_at', 'updated_at'
    ];

    public function userinfo()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->select('id','name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile') );
    }
    public function vendorname()
    {
        return $this->belongsTo('App\Models\User', 'vendor_id', 'id')->select('id','name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile') );
    }
    public function vendorinfo()
    {
        return $this->belongsTo('App\Models\VendorDetail', 'vendor_id', 'vendor_id')->select('id','vendor_id', 'firm_name',  DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo'));
    }
    public function bookinginfo()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'id')->select('id','service_id', 'treatment_id', 'address_id', 'booking_date', 'booking_time', 'orderid');
    }
    public function statusinfo()
    {
        return $this->belongsTo('App\Models\Status', 'status', 'id')->select('id','status');
    }
}
