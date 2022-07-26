<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    protected $fillable = [ 'active', 'plan_name', 'plan_type', 'amount', 'days', 'description', 'portfolio', 'calendar', 'available', 'long_bio', 'profile_bg', 'performance', 'account_data','yearly_price','monthly_price', 'liability', 'dbs_option', 'created_at', 'updated_at'];
}
