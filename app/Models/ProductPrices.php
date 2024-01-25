<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $product_id
 * @property int $profit_margin
 * @property int $shipping_costs
 */
class ProductPrices extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'profit_margin',
        'shipping_costs',
    ];

    public static function getPricesFromProductId(int $id): Model|Builder
    {
        return self::query()
            ->where('product_id', $id)
            ->firstOrFail();
    }
}
