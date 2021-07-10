<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        "name"
    ];

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
