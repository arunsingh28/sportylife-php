<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class News_feed_comments extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function newsfeeddata()
    {
        return $this->hasOne(News_feeds::class, 'id', 'news_feed_id');
    }
    
    public function userdata()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select('id','name','first_name','last_name','email','gender','image','dob');
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
