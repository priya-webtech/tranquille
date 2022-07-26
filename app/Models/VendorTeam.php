<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTeam extends Model
{
    use HasFactory;

    protected $table = 'vendor_teams';

    protected $fillable = [ 'active', 'vendor_id', 'employee_name', 'designation', 'skills', 'profile_pic', 'created_at', 'updated_at' ];

    public function appointments()
    {
        return $this->hasMany('App\Models\Booking', 'employee_id', 'id')->select('id','employee_id', 'booking_date', 'booking_time', 'final_amount','full_amount','service_id','treatment_id','expct_end_time');
    }
}
