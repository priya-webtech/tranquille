<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'bookings';

    protected $fillable = [
        'active', 'user_id', 'vendor_id', 'employee_id', 'service_id', 'treatment_id', 'address_id', 'booking_date', 'booking_time', 'orderid', 'start_time', 'expct_end_time', 'end_time', 'expct_amount', 'full_amount', 'discount_amount', 'final_amount', 'canceled', 'canceled_reson', 'user_name', 'address', 'latitude', 'longitude', 'status_id', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'created_at', 'updated_at', 'transaction_id' , 'payment_id'
    ];

    public function userinfo()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->select('id','name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile') );
    }
    public function vendorinfo()
    {
        return $this->belongsTo('App\Models\VendorDetail', 'vendor_id', 'vendor_id')->select('id','vendor_id', 'firm_name',  DB::raw('CONCAT("'.URL::to('/').'", "/public/", logo) AS logo'));
    }
    public function serviceinfo()
    {
        return $this->belongsTo('App\Models\Services', 'service_id', 'id')->select('id','service_name', DB::raw('CONCAT("'.URL::to('/').'", "/public/", service_image) AS service_image'), DB::raw('CONCAT("'.URL::to('/').'", "/public/", small_image) AS small_image'));
    }
    public function treatmentinfo()
    {
        return $this->belongsTo('App\Models\Treatment', 'treatment_id', 'id')->select('id','treatment_name', DB::raw('CONCAT("'.URL::to('/').'", "/public/", treatment_image) AS treatment_image'), DB::raw('CONCAT("'.URL::to('/').'", "/public/", small_image) AS small_image'));
    }
    public function addressinfo()
    {
        return $this->belongsTo('App\Models\Address', 'address_id', 'id')->select('id','user_id','is_main', 'address_line1', 'address_line2', 'state', 'city', 'postcode', 'latitude', 'longitude', 'location_address');
    }
    public function employeeinfo()
    {
        return $this->belongsTo('App\Models\VendorTeam', 'employee_id', 'id')->select('id','employee_name', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile_pic) AS profile_pic'));
    }
    public function paymentinfo()
    {
        return $this->belongsTo('App\Models\Payment', 'payment_id', 'id');
    }
    public function statusinfo()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id')->select('id','status');
    }
}
