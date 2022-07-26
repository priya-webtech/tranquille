<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyView extends Model
{
    use HasFactory;

    protected $table = 'recently_view';

    protected $fillable = [ 'vendor_id', 'user_id', 'guest_ip', 'view_time' ];

    public $timestamps =false;

}
