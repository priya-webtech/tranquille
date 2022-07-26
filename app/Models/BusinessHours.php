<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHours extends Model
{
    use HasFactory;

    protected $table = 'business_hours';

    protected $fillable = [
        'active', 'vendor_id', 'timeMonStart', 'timeMonEnd', 'dayMondayStatus', 'timeTueStart', 'timeTueEnd', 'dayTuesdayStatus', 'timeWedStart', 'timeWedEnd', 'dayWednesdayStatus', 'timeThuStart', 'timeThuEnd', 'dayThursdayStatus', 'timeFriStart', 'timeFriEnd', 'dayFridayStatus', 'timeSatStart', 'timeSatEnd', 'daySaturdayStatus', 'timeSunStart', 'timeSunEnd', 'daySundayStatus', 'timeMonFriStart', 'timeMonFriEnd', 'dayMonFriStatus', 'created_by', 'deleted_at', 'created_at', 'updated_at'
    ];
}
