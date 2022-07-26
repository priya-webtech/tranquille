<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'active', 'user_id', 'type', 'title', 'message', 'is_seen', 'created_at', 'updated_at', 'booking_id', 'status'
    ];

    public function userinfo()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->select('id','name', 'email', 'firstname', 'lastname', DB::raw('CONCAT("'.URL::to('/').'", "/public/", profile) AS profile') );
    }
}
