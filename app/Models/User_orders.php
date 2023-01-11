<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class User_orders extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s',
    ];


    public function order_items()
    {
        return $this->hasMany(User_order_items::class, 'order_primary_id', 'id');
    }

    public function active_package()
    {
        return $this->hasOne(User_order_items::class, 'order_primary_id', 'id')->where('status', '1');
    }

    public function packagedata()
    {
        return $this->hasOne(Servicepackages::class, 'id', 'package_id');
    }

    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] = Carbon::parse($this->attributes['created_at'])->format("Y-m-d H:i:s");
    }
    public function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at'] = Carbon::parse($this->attributes['updated_at'])->format("Y-m-d H:i:s");
    }
}
