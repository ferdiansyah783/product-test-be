<?php

namespace Database\Factories;


use App\Models\PriceDetail;
use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceDetailFactory extends Factory
{
    protected $model = PriceDetail::class;

    public function definition()
    {
        return [
            'price_id' => Price::factory(),
            'tier' => $this->faker->randomElement(['Non Member', 'Basic', 'Premium']),
            'price' => $this->faker->numberBetween(10000, 50000),
        ];
    }
}

