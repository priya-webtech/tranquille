<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'active', 'firstname', 'lastname', 'profile', 'phone', 'dob', 'type', 'otp', 'device_token', 'email_verified', 'phone_verified', 'is_notify', 'language', 'social_id', 'socialtype', 'profile_status', 'country', 'referral_code','membershipvalid'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vendorservices()
    {
        return $this->hasMany('App\Models\VendorService', 'vendor_id', 'id')->where('active', '=', 'Y')->select('id', 'vendor_id', 'service_id', 'discount');
    }
    public function vendortreatments()
    {
        return $this->hasMany('App\Models\VendorTreatment', 'vendor_id', 'id')->select('id', 'vendor_id', 'treatment_id', 'description', 'price', 'discount', 'no_of_person');
    }
    public function vendordetails()
    {
        return $this->belongsTo('App\Models\VendorDetail', 'id', 'vendor_id')->select('id', 'vendor_id', 'firm_name', 'about_us', 'service_type', 'country', 'website', 'referral_code', 'why_you', 'latitude', 'longitude', 'membershipvalid', DB::raw('CONCAT("' . URL::to('/') . '/public/", logo) AS logo '));
    }
    public function addressdetails()
    {
        return $this->belongsTo('App\Models\Address', 'id', 'user_id')->select('id', 'user_id', 'is_main', 'address_line1', 'address_line2', 'state', 'city', 'postcode', 'latitude', 'longitude', 'location_address');
    }
    public function useraddress()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'id')->where('active', '=', 'Y')->select('id', 'user_id', 'is_main', 'address_line1', 'address_line2', 'state', 'city', 'postcode', 'latitude', 'longitude', 'location_address');
    }
    public function demoimages()
    {
        return $this->hasMany('App\Models\VendorDemo', 'vendor_id', 'id')->where('active', '=', 'Y')->select('id', 'vendor_id', 'demo_image');
    }
    public function vendorBusinessHours()
    {
        return $this->belongsTo('App\Models\BusinessHours', 'id', 'vendor_id')->select('id', 'vendor_id', 'timeMonStart', 'timeMonEnd', 'dayMondayStatus', 'timeTueStart', 'timeTueEnd', 'dayTuesdayStatus', 'timeWedStart', 'timeWedEnd', 'dayWednesdayStatus', 'timeThuStart', 'timeThuEnd', 'dayThursdayStatus', 'timeFriStart', 'timeFriEnd', 'dayFridayStatus', 'timeSatStart', 'timeSatEnd', 'daySaturdayStatus', 'timeSunStart', 'timeSunEnd', 'daySundayStatus', 'timeMonFriStart', 'timeMonFriEnd', 'dayMonFriStatus');
    }
    public function vendorteams()
    {
        return $this->hasMany('App\Models\VendorTeam', 'vendor_id', 'id')->select('id', 'vendor_id', 'active', 'employee_name', 'designation', 'skills', 'profile_pic');
    }

    public function vendorproducts()
    {
        return $this->hasMany('App\Models\VendorProduct', 'vendor_id', 'id')->select('id', 'vendor_id', 'productbrand_id');
    }
}
