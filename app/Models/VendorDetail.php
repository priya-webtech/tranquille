<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDetail extends Model
{
    use HasFactory;
    protected $table = 'vendor_details';

    protected $fillable = [
        'active', 'vendor_id', 'firm_name', 'about_us', 'service_type', 'country', 'website', 'referral_code', 'why_you', 'latitude', 'longitude', 'logo', 'deleted_at', 'created_at', 'updated_at', 'membershipvalid', 'profile_viewed'
    ];

    public function vendorrating()
    {
        return $this->hasMany('App\Models\Feedback', 'reviewto', 'vendor_id');
    }
    public function vendorservices()
    {
        return $this->hasMany('App\Models\VendorService', 'vendor_id', 'vendor_id')->where('active','=','Y')->select('id','vendor_id','service_id','discount');
    }

    public function vendortreatments()
    {
        return $this->hasMany('App\Models\VendorTreatment', 'vendor_id', 'vendor_id')->select('id','vendor_id', 'treatment_id', 'description', 'price', 'discount', 'no_of_person');
    }
    public function vendoraddress()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'vendor_id')->where('active','=','Y')->select('id','user_id','is_main', 'address_line1', 'address_line2', 'state', 'city', 'postcode', 'location_address');
    }
    public function vendorproducts()
    {
        return $this->hasMany('App\Models\VendorProduct', 'vendor_id', 'vendor_id')->select('id', 'vendor_id', 'productbrand_id');
    }
    public function vendorBusinessHours()
    {
        return $this->belongsTo('App\Models\BusinessHours', 'vendor_id', 'vendor_id')->select('id','vendor_id', 'timeMonStart', 'timeMonEnd', 'dayMondayStatus', 'timeTueStart', 'timeTueEnd', 'dayTuesdayStatus', 'timeWedStart', 'timeWedEnd', 'dayWednesdayStatus', 'timeThuStart', 'timeThuEnd', 'dayThursdayStatus', 'timeFriStart', 'timeFriEnd', 'dayFridayStatus', 'timeSatStart', 'timeSatEnd', 'daySaturdayStatus', 'timeSunStart', 'timeSunEnd', 'daySundayStatus', 'timeMonFriStart', 'timeMonFriEnd', 'dayMonFriStatus');
    }
    public function vendorDemos()
    {
        return $this->belongsTo('App\Models\VendorDemo', 'vendor_id', 'vendor_id')->select('id','vendor_id', 'demo_image');
    }
    public function recentlyView()
    {
        return $this->hasMany('App\Models\RecentlyView', 'vendor_id', 'vendor_id');
    }


}
