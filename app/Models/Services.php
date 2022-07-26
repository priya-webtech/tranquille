<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'active', 'service_name', 'service_image', 'small_image', 'rank', 'created_at', 'updated_at'
    ];

    public function treatments()
    {
        return $this->hasMany('App\Models\Treatment', 'service_id', 'id')->select('id','service_id', 'treatment_name', 'treatment_image', 'small_image');
    }
}
