<?php

namespace App\Interfaces;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{

     public function getAllProducts():LengthAwarePaginator;
     public function getProductById(string $id): Product;
     public function createProduct(array $data): Product;
     public function updateProduct(string $id, array $data): Product;
     public function deleteProduct(string $id): bool;
     public function updateStock(string $id, array $data): Product;
     public function getLowStockProducts(): LengthAwarePaginator;
}
