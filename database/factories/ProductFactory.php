<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_code' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'), // Random product code
            'quantity' => $this->faker->numberBetween(1, 100),  // Random quantity between 1 and 100
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
