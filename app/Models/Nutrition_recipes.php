<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Nutrition_recipes extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'ingredients' => 'json',
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s',
    ];
    
    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] = Carbon::parse($this->attributes['created_at'])->format("Y-m-d H:i:s");
    }
    public function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at'] = Carbon::parse($this->attributes['updated_at'])->format("Y-m-d H:i:s");
    }

    public function recipe_categorydata()
    {
        return $this->hasOne(Nutrition_recipe_categories::class, 'id', 'category_id');
    }
}
