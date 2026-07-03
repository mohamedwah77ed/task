<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;


class ProductApiTest extends TestCase
{
     use RefreshDatabase;

    public function test_can_get_all_products(): void
{
    Product::factory()->count(3)->create();

    $response = $this->getJson('/api/products');

    $response->assertStatus(200)
             ->assertJsonCount(3, 'data');
}

public function test_can_create_product(): void
{
    $data = [
        'sku' => 'SKU-1001',
        'name' => 'Laptop',
        'description' => 'Test Product',
        'price' => 1500,
        'stock_quantity' => 20,
        'low_stock_threshold' => 10,
        'status' => 'active',
    ];

    $response = $this->postJson('/api/products', $data);

    $response->assertStatus(201);

    $this->assertDatabaseHas('products', [
        'sku' => 'SKU-1001',
    ]);
}
public function test_can_show_product(): void
{
    $product = Product::factory()->create();

    $response = $this->getJson("/api/products/{$product->id}");

    $response->assertStatus(200);

    $response->assertJsonFragment([
        'name' => $product->name,
    ]);
}
public function test_can_update_product(): void
{
    $product = Product::factory()->create();

    $response = $this->putJson("/api/products/{$product->id}", [
        'sku' => $product->sku,
        'name' => 'Updated Product',
        'description' => $product->description,
        'price' => 250,
        'stock_quantity' => 15,
        'low_stock_threshold' => 5,
        'status' => 'active',
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated Product',
    ]);
}
public function test_can_delete_product(): void
{
    $product = Product::factory()->create();

    $response = $this->deleteJson("/api/products/{$product->id}");

    $response->assertStatus(204);

    $this->assertSoftDeleted('products', [
        'id' => $product->id,
    ]);
}
}
