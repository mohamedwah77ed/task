<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateStockRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $products = Product::paginate(10);

    return ProductResource::collection($products);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
         $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */

public function show(string $id)
{
    $product = Product::findOrFail($id);

    return new ProductResource($product);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
         $product = Product::findOrFail($id);
         $product->update($request->validated());

        return new ProductResource($product);
    }
    public function updateStock(UpdateStockRequest $request, string $id)
    {

    $product = Product::findOrFail($id);

    if ($request->type === 'increment') {
        $product->increment('stock_quantity', $request->quantity);
    } else {
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock.',
            ], 422);
        }

        $product->decrement('stock_quantity', $request->quantity);
    }

    return new ProductResource($product->fresh());
    }
    public function lowStock()
{
    $products = Product::lowStock()->get();

    return ProductResource::collection($products);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->noContent();
    }
}
