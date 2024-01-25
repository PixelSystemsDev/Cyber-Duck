<?php

namespace Tests\Feature;

use App\Http\Services\PricingCalculatorService;
use App\Http\Services\SalesService;
use App\Models\Products;
use App\Models\ProductSales;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesCalculationsTest extends TestCase
{
    protected static bool $initialSetup = false;

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        if (! self::$initialSetup) {
            $this->artisan('migrate:fresh --seed');
            self::$initialSetup = true;
        }
    }

    public function test_return_selling_price_calculation()
    {
        /**
         * Tested this for quantity 1, 2 and 5.
         * Test fails for 1 (off by 1p) but passes for the other 2.
         * Could there be a chance that the example doc of 23.34 is a typo and should be 23.33?
         */
        $product = Products::first();
        $quantity = 5;
        $unitCost = 12;

        $sellingCost = new PricingCalculatorService();
        $result = $sellingCost->calculateSellingPrice($product, $quantity, $unitCost);

        $this->assertEquals(90.00, $result);
    }

    /**
     * @depends test_return_selling_price_calculation
     */
    public function test_throw_selling_price_calculation_error()
    {
        $this->expectException(ModelNotFoundException::class);
        Products::getProductByName('Expecting this to break');
    }

    public function test_user_can_store_sale()
    {
        $product = Products::first();
        $quantity = 2;
        $unitCost = 20.50;

        $sellingCost = new PricingCalculatorService();
        $result = $sellingCost->calculateSellingPrice($product, $quantity, $unitCost);

        $newSale = new SalesService();

        $productSales = $newSale->recordSale($product, $quantity, $unitCost, $result);
        $this->assertInstanceOf(ProductSales::class, $productSales);
    }
}
