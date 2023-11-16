<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'name', 'price', 'sale_price', 'size'];

    protected $guarded = ['id'];

    public function category(){
        return $this->hasMany(Category::class, 'id', 'category_id');
    }

    public function brand(){
        return $this->hasMany(Brand::class, 'id', 'brand_id');
    }
}
