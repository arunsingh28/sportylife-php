<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Notifications extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    

    protected $casts = [
        'data' => 'json',
        'created_at'=>'datetime:d-m-Y H:i:s',
        'updated_at'=>'datetime:d-m-Y H:i:s',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] = Carbon::parse($this->attributes['created_at'])->format("d-m-Y H:i:s");
    }
    public function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at'] = Carbon::parse($this->attributes['updated_at'])->format("d-m-Y H:i:s");
    }
}
