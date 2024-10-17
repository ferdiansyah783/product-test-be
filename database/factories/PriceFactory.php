<?php

namespace Database\Factories;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    protected $model = Price::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'unit' => $this->faker->randomElement(['bungkus', 'strip', 'pak']),
        ];
    }
}

