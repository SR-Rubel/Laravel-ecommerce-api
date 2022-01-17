<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\subCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class subCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * 
     * @var string
     */
    protected $model = subCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id'=>Category::all()->random()->id,
            'name'=>$this->faker->word(),
        ];
    }
}
