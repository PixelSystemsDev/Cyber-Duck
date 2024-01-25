<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coffeeProducts = [
            'Gold Coffee',
            'Arabic Coffee',
        ];

        $user = User::first();

        /**
         * Added as a fail-safe method in the event of
         * a user triggering seeders individually instead of
         * triggering DatabaseSeeder)
         */
        if (! $user) {
            $this->call(UserSeeder::class);
            $user = User::first();
        }

        foreach ($coffeeProducts as $product) {
            Products::create([
                'product' => $product,
                'added_by' => $user->id,
            ]);
        }
    }
}
