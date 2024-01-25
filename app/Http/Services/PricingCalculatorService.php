<?php

namespace App\Http\Services;

use App\Models\ProductPrices;
use App\Models\Products;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class PricingCalculatorService
{
    private const CACHE_IN_MINS = 30;

    public function calculateSellingPrice(Products $product, int $quantity, float $unitCost): float|array
    {
        /**
         * Add a layer of caching here for the productID, quantity and unitCost.
         * This way we can ensure it'll return as quickly as possible based off of its unique key.
         * const added at the top in the event of needing to quickly amend the clearing time of the cache.
         */
        $productId = $product->id;
        $cacheKey = "product.$productId.$quantity.$unitCost";

        return Cache::remember($cacheKey, self::CACHE_IN_MINS, function () use ($productId, $quantity, $unitCost) {
            try {
                $productPrices = ProductPrices::getPricesFromProductId($productId);

                return $this->performCalculation($productPrices, $quantity, $unitCost);

            } catch (ModelNotFoundException $e) {
                return [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ];
            }
        });
    }

    protected function performCalculation($productPrices, $quantity, $unitCost): float
    {
        $profitMargin = $productPrices->profit_margin;

        /**
         * Conditional check in the event a user inputs 25 instead of 0.25.
         * Here we allow both and perform amendments accordingly to ensure
         * the end result remains the same.
         */
        if ($profitMargin >= 1) {
            $profitMargin /= 100;
        }

        $cost = $quantity * $unitCost;
        $sellingPrice = ($cost / (1 - $profitMargin)) + $productPrices->shipping_cost;

        return round($sellingPrice, 2);
    }
}
