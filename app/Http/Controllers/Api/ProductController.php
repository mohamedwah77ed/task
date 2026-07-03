<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateStockRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Interfaces\ProductRepositoryInterface;
class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

public function __construct(ProductRepositoryInterface $productRepository)
{
    $this->productRepository = $productRepository;
}
    /**
     * Display a listing of the resource.
     */
    public function index():AnonymousResourceCollection
{
    $products = $this->productRepository->getAllProducts();

    return ProductResource::collection($products);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productRepository->createProduct($request->validated());

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */

public function show(string $id)
{
    $product = $this->productRepository->getProductById($id);

    return new ProductResource($product);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = $this->productRepository->updateProduct(
         $id,
        $request->validated()
        );

       return new ProductResource($product);
    }
    public function updateStock(UpdateStockRequest $request, string $id)
    {

    $product = $this->productRepository->updateStock(
    $id,
    $request->validated()
);

      return new ProductResource($product);
    }


    public function lowStock():AnonymousResourceCollection
{
    $products = $this->productRepository->getLowStockProducts();

    return ProductResource::collection($products);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $this->productRepository->deleteProduct($id);

       return response()->noContent();



    }
}
