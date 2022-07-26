<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'memberships';
    protected $fillable = ['user_id', 'plan_id', 'amount', 'txn_status', 'transaction_id', 'description', 'response', 'start_date', 'end_date', 'status', 'created_at', 'updated_at'];

    public function userinfo()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->select('id', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile'));
    }
    public function subscriptioninfo()
    {
        return $this->belongsTo('App\Models\Subscription', 'plan_id', 'id')->select('id', 'plan_name', 'plan_type', 'amount');
    }
}
