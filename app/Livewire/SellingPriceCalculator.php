<?php

namespace App\Livewire;

use App\Http\Requests\PricingCalculationRequest;
use App\Http\Services\PricingCalculatorService;
use App\Http\Services\SalesService;
use App\Models\Products;
use App\Models\ProductSales;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;

class SellingPriceCalculator extends Component
{
    public ?Collection $products;

    public ?Collection $sales;

    public ?int $productId;

    public ?string $quantity;

    public ?string $cost;

    public ?float $sellingPrice;

    public function mount(): void
    {
        $this->products = Products::all();
        $this->sales = ProductSales::all();
    }

    /**
     * @throws ValidationException
     */
    public function updated($field): void
    {
        $this->validateOnly($field);

        if (! empty($this->productId) && ! empty($this->quantity) && ! empty($this->cost)) {
            $this->calculateSellingPrice();
        }
    }

    public function calculateSellingPrice(): void
    {
        $this->validate();

        $this->sellingPrice = app(PricingCalculatorService::class)
            ->calculateSellingPrice($this->getModel($this->productId), $this->quantity, $this->cost);
    }

    public function storeSale(): void
    {
        $this->validate();
        $salesService = app(SalesService::class);
        $newSale = $salesService->recordSale(
            $this->getModel($this->productId),
            $this->quantity,
            $this->cost,
            $this->sellingPrice
        );

        $this->sales->push($newSale);

        // Reset the properties
        $this->reset(['productId', 'quantity', 'cost', 'sellingPrice']);
    }

    protected function rules(): array
    {
        return (new PricingCalculationRequest())->rules();
    }

    public function render(): View
    {
        return view('livewire.selling-price-calculator', [
            'products' => $this->products,
            'sales' => $this->sales,
        ]);
    }

    protected function getModel($id): Products
    {
        return Products::find($id);
    }
}
