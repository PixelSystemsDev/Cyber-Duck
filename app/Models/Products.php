<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $product
 * @property int $added_by
 */
class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product',
        'added_by',
    ];

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public static function getProductByName(string $product): Model|Builder
    {
        return self::query()
            ->where('product', $product)
            ->firstOrFail();
    }
}
