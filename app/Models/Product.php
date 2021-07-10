<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function brand()
    {
        $this->belongsTo(Brand::class);
    }
    public function category()
    {
        $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        $this->belongsTo(SubCategory::class);
    }
}
