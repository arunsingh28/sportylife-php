<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    public function referbyuserdata()
    {
        return $this->hasOne(User::class, 'referral_code', 'refer_by');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s',
        'freetrial_duration'=>'datetime:Y-m-d H:i:s',
        'dob'=>'datetime:d-m-Y',
    ];
    
    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] = Carbon::parse($this->attributes['created_at'])->format("Y-m-d H:i:s");
    }
    public function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at'] = Carbon::parse($this->attributes['updated_at'])->format("Y-m-d H:i:s");
    }

    public function orders()
    {
        return $this->hasMany(User_orders::class);
    }

    public function complete_orders()
    {
        return $this->hasMany(User_orders::class)->where('payment_status', 'complete');
    }
     public function pending_orders()
    {
        return $this->hasMany(User_orders::class)->where('payment_status','!=','complete');
    }

    public function active_order()
    {
        return $this->hasOne(User_orders::class)->with('active_package')->where('payment_status', 'complete');
    }

    public function languagedata()
    {
        return $this->hasOne(Languages::class, 'id', 'language_id');
    }
    
    public function roledata()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }
}
