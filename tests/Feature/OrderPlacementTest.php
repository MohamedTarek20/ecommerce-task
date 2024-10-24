<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderPlacementTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_order_can_be_placed()
    {
        $user = User::factory()->create();

        $product = Product::create([
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 100,
        ]);

        $orderData = [
            'products' => [
                ['id' => $product->id, 'quantity' => 2],
            ],
        ];

        $response = $this->actingAs($user)->postJson('/api/orders', $orderData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', []);
        $this->assertDatabaseHas('order_products', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertEquals(98, $product->fresh()->stock);
    }
}
