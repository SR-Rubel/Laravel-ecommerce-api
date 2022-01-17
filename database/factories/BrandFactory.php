<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Seller;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class brandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * 
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word(),
        ];
    }
}
