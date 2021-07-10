<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
