<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(): LengthAwarePaginator
    {

           return Product::paginate(10);
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

    return $product->fresh();
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
