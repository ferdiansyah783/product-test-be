<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Price;
use App\Models\PriceDetail;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Membuat 10 produk dengan masing-masing produk memiliki 2 harga, dan tiap harga memiliki 3 detail harga
        Product::factory()
            ->count(10)
            ->has(
                Price::factory()
                    ->count(2)
                    ->has(
                        PriceDetail::factory()->count(3)
                    )
            )
            ->create();
    }
}


