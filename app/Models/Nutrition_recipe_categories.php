<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Nutrition_recipe_categories extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    protected $casts=[
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s',
    ];

    public function nutrition_recipedata()
    {
        return $this->hasMany(Nutrition_recipes::class, 'category_id', 'id')->where('status','1')->orderBy('created_at','desc');
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
