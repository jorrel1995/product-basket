<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_basket_endpoint()
    {
        $product = Product::factory()->create([
            'sku' => 'TEST-001',
            'price' => 20.00,
            'stock' => 10,
        ]);

        $response = $this->postJson(route('basket.add'), [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'basket', 'total'])
            ->assertJsonPath('total', 60);

        $this->assertEquals(3, session('basket.TEST-001.quantity'));
    }

    public function test_delete_from_basket_endpoint()
    {
        $product = Product::factory()->create([
            'sku' => 'TEST-001',
            'stock' => 5,
            'price' => 10.00,
        ]);

        // Pre-fill session
        session(['basket' => [
            'TEST-001' => [
                'id' => $product->id,
                'sku' => 'TEST-001',
                'name' => 'Test Product', // Added missing fields to be safe
                'price' => 10.00,
                'quantity' => 1,
                'total' => 10.00, // Added missing total
            ],
        ]]);

        $response = $this->postJson(route('basket.delete'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('basket', []);

        $this->assertEmpty(session('basket'));
        $this->assertEquals(6, $product->fresh()->stock);
    }

    public function test_update_basket_endpoint()
    {
        $product = Product::factory()->create([
            'sku' => 'TEST-001',
            'stock' => 5,
            'price' => 10.00,
        ]);

        // Pre-fill session
        session(['basket' => [
            'TEST-001' => [
                'id' => $product->id,
                'sku' => 'TEST-001',
                'name' => 'Test Product', // Added missing fields to be safe
                'price' => 10.00,
                'quantity' => 1,
                'total' => 10.00, // Added missing total
            ],
        ]]);

        $response = $this->postJson(route('basket.update'), [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response->assertStatus(200);

        $this->assertEquals(3, session('basket.TEST-001.quantity'));
        $this->assertEquals(3, $product->fresh()->stock);
    }

    public function test_cannot_add_item_to_basket_if_insufficient_stock()
    {
        $product = Product::factory()->create([
             'sku' => 'TEST-001',
             'stock' => 1
        ]);

        $response = $this->postJson(route('basket.add'), [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Insufficient stock']);
    }
}
