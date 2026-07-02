<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;
class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock_quantity',
        'low_stock_threshold',
        'status',
    ];


    public function scopeLowStock(Builder $query): Builder
{
    return $query->whereColumn(
        'stock_quantity',
        '<=',
        'low_stock_threshold'
    );
}

//Additional scopes:
    /*
    public function scopeAllProducts($query)
{
    return $query;
}
    public function scopeActive($query)
{
    return $query->where('status', 'active');
}
 public function scopeInactive($query)
{
    return $query->where('status', 'inactive');
}
 public function scopeDiscontinued($query)
{
    return $query->where('status', 'discontinued');
}
*/

}
