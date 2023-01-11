<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class User_order_items extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        // 'start_date'  => 'datetime:M d, Y, H:i A',
        // 'end_date' => 'datetime:M d, Y, H:i A',
        // 'created_at'  => 'datetime:M d, Y, H:i A',
        // 'updated_at' => 'datetime:M d, Y, H:i A',
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s',
    ];
    

    public function package()
    {
        return $this->hasOne(Servicepackages::class, 'id', 'package_id');
    }

    public function category()
    {
        return $this->hasOne(Servicecategories::class, 'id', 'category_id');
    }

    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] = Carbon::parse($this->attributes['created_at'])->format("Y-m-d H:i:s");
    }
    public function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at'] = Carbon::parse($this->attributes['updated_at'])->format("Y-m-d H:i:s");
    }
    // public function getStartDateAttribute()
    // {
    //     return $this->attributes['start_date'] = Carbon::parse($this->attributes['start_date'])->format("d/m/y");
    // }
    // public function getEndDateAttribute()
    // {
    //     return $this->attributes['end_date'] = Carbon::parse($this->attributes['end_date'])->format("d/m/y");
    // }
}
