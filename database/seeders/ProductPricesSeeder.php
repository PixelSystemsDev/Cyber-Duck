<?php

namespace Database\Seeders;

use App\Models\ProductPrices;
use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profitMargins = [
            'Gold Coffee' => 0.25,
            'Arabic Coffee' => 0.15,
        ];

        $products = Products::all();

        /**
         * If there are no products call the ProductSeeder to populate.
         */
        if ($products->isEmpty()) {
            $this->call(ProductsSeeder::class);
            $products = Products::all();
        }

        foreach ($products as $product) {
            $profitMargin = $profitMargins[$product->product] ?? 0;

            ProductPrices::create([
                'product_id' => $product->id,
                'profit_margin' => $profitMargin,
                'shipping_cost' => 10,
            ]);
        }
    }
}
