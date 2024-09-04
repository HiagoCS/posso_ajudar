<?php

namespace Database\Factories\Storage;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class ProductsModelFactory extends Factory
{
    protected $model = \App\Models\Storage\ProductsModel::class;

    public function definition()
    {
        return [
            'sm_code' => $this->faker->unique()->lexify('SM???'),
            'bar_code' => $this->faker->unique()->numerify('###########'),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'value' => $this->faker->randomFloat(2, 1, 1000),
            'product_amount' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(['1', '0']), // Ajuste conforme necessário
        ];
    }
}
