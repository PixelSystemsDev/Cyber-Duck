<?php

namespace App\Http\Services;

use App\Models\Products;
use App\Models\ProductSales;

class SalesService
{
    public function recordSale(Products $product, int $quantity, float $unitCost, float $sellingPrice): ProductSales
    {
        $sale = new ProductSales();
        $sale->product_id = $product->id;
        $sale->quantity = $quantity;
        $sale->unit_cost = $unitCost;
        $sale->selling_price = $sellingPrice;
        $sale->save();

        return $sale;
    }
}
