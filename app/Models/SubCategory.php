<?php

namespace App\Models;

use App\Models\Category;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    public function category()
    {
        $this->belongsTo(Category::class);
    }
    public function products()
    {
        $this->hasMany(Product::class);
    }
}
