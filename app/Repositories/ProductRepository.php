<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Events\LowStockAlert;

class ProductRepository implements ProductRepositoryInterface
{
   public function getAllProducts(): LengthAwarePaginator
{
    $page = request()->get('page', 1);

    return Cache::remember(
        "products_page_{$page}",
        now()->addMinutes(10),
        function () {
            return Product::paginate(10);
        }
    );
}

    public function getProductById(string $id): Product
    {
           return Product::findOrFail($id);

    }

    public function createProduct(array $data): Product
    {
           return Product::create($data);

    }

    public function updateProduct(string $id, array $data): Product
    {
        $product = Product::findOrFail($id);

         $product->update($data);

          return $product;
    }

    public function deleteProduct(string $id): bool
    {

    $product = Product::findOrFail($id);

    return $product->delete();
    }


    public function updateStock(string $id, array $data): Product
{
    $product = $this->getProductById($id);

    if ($data['type'] === 'increment') {
        $product->increment('stock_quantity', $data['quantity']);
    } else {
        if ($product->stock_quantity < $data['quantity']) {
            abort(422, 'Insufficient stock.');
        }

        $product->decrement('stock_quantity', $data['quantity']);
    }

    $product->refresh();

    if ($product->stock_quantity <= $product->low_stock_threshold) {
        LowStockAlert::dispatch($product);
    }

    return $product;
}


    public function getLowStockProducts(): LengthAwarePaginator
{
    return Product::whereColumn(
        'stock_quantity',
        '<=',
        'low_stock_threshold'
    )->paginate(10);
}
}
