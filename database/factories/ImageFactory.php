<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class imageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * 
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::all()->random()->id,
            'image' => $this->faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        ];
    }
}
