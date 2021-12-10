<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class productFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' =>Category::all()->random()->id,
            'sub_category_id'=>SubCategory::all()->random()->id,
            'brand_id'=>Brand::all()->random()->id,
            'name' => $this->faker->word(),
            'details' =>$this->faker->paragraph(1),
            'price' =>$this->faker->numberBetween(50,100),
            'image' =>$this->faker->randomElement(['1.png','2.png','3.png','4.png','5.png']),
            'size' =>$this->faker->randomElement(['M','XL','XXL','L']),
            'color' =>$this->faker->randomElement(['red','green','blue','yellow','white','balck','offwhite']),
            'discount_price'=>$this->faker->randomElement(['10','15']),
            'stockout'=>$this->faker->randomElement([0,1,0]),
            'hot_deal'=>$this->faker->randomElement([0,1,0]),
            'buy_one_get_one'=>$this->faker->randomElement([1,0,1]),
        ];
    }
}
