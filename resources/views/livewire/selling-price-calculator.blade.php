<div class="container mx-auto p-4">
    <div class="flex flex-wrap mb-4 ml-4">
        <div class="w-full md:w-1/4 mb-4 md:mb-0">
            <label for="product_id" class="block text-sm font-medium text-gray-700">Product ID:</label>
            <select wire:model="productId" class="w-full mt-1 p-2 border rounded-md" wire:change="calculateSellingPrice">
                <option value="">Select a product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product }}</option>
                @endforeach
            </select>
            @error('productId') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="w-full md:w-1/4 mb-4 ml-4">
            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity:</label>
            <input type="text" wire:model="quantity" class="w-full mt-1 p-2 border rounded-md" wire:keydown="calculateSellingPrice">
            @error('quantity') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="w-full md:w-1/4 mb-4 ml-4">
            <label for="cost" class="block text-sm font-medium text-gray-700">Unit Cost (&pound;):</label>
            <input type="text" wire:model="cost" class="w-full mt-1 p-2 border rounded-md" wire:keydown="calculateSellingPrice">
            @error('cost') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="w-full md:w-1/4 mb-4 ml-4">
            <!-- Selling Price display -->
            @if($sellingPrice !== null)
                <p class="mt-8 text-lg font-semibold text-green-600">Selling Price: &pound;{{ number_format($sellingPrice, 2) }}</p>
            @endif
        </div>

        <div class="w-full md:w-1/4 mt-6 pb-1 ml-4">
            <x-button wire:click="storeSale">Record Sale</x-button>
        </div>
    </div>

    @if(count($sales) > 0)
        <div class="mt-5">
            <table class="w-full min-w-full bg-white border border-gray-300 rounded-md overflow-hidden table-striped">
                <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 border-r text-left">Product</th>
                    <th class="py-3 px-4 border-r text-left">Quantity</th>
                    <th class="py-3 px-4 border-r text-left">Unit Cost</th>
                    <th class="py-3 px-4 border-r text-left">Selling Price</th>
                    <th class="py-3 px-4 text-left">Sold At</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sales as $sale)
                    <tr class="hover:bg-gray-100 transition duration-300 ease-in-out text-center">
                        <td class="py-2 px-4 border-r">{{ $sale->product->product }}</td>
                        <td class="py-2 px-4 border-r">{{ number_format($sale->quantity) }}</td>
                        <td class="py-2 px-4 border-r">&pound; {{ number_format($sale->unit_cost, 2) }}</td>
                        <td class="py-2 px-4 border-r">&pound; {{ number_format($sale->selling_price, 2) }}</td>
                        <td class="py-2 px-4">{{ $sale->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
