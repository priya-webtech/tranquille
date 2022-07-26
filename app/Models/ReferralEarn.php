<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ReferralEarn extends Model
{
    use HasFactory;
    protected $table = 'referral_earns';
    protected $fillable = [ 'referralby', 'referralto', 'email', 'phone', 'referral_code', 'referral_date', 'amount', 'share_via', 'created_at', 'updated_at'];

    public function byinfo()
    {
        return $this->belongsTo('App\Models\User', 'referralby', 'id')->select('id','name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile') );
    }
    public function toinfo()
    {
        return $this->belongsTo('App\Models\User', 'referralto', 'id')->select('id','name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile') );
    }
}
