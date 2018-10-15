<?php

namespace Tests\Feature;

use App\User;
use App\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function userCanCreateAStock()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->json('POST', route('stocks.store'), [
                'goods_name' => 'Goods',
                'quantity' => rand(1, 10),
                'base_price' => 50,
                'selling_price' => 40,
                'status' => 1,
            ]);

        $this->assertDatabaseHas('stock', [
            'goods_name' => 'Goods',
        ]);
    }

    /** @test */
    public function userCanUpdateAStock()
    {
        $user = factory(User::class)->create();
        $stock = factory(Stock::class)->create(['goods_name' => 'Test']);

        $this->actingAs($user)
            ->json('PATCH', route('stocks.update', $stock->id), [
                'goods_name' => 'Goods Name',
                'quantity' => 1,
                'base_price' => 50,
                'selling_price' => 40,
                'status' => 1,
            ]);

        $this->assertDatabaseHas('stock', [
            'goods_name' => 'Goods Name',
        ]);
    }

    /** @test */
    public function userCanDestroyAStock()
    {
        $user = factory(User::class)->create();
        $stock = factory(Stock::class)->create(['goods_name' => 'Test']);

        $this->assertDatabaseHas('stock', [
            'goods_name' => 'Test',
        ]);

        $this->actingAs($user)
            ->json('DELETE', route('stocks.destroy', $stock->id));

        $this->assertDatabaseMissing('stock', [
            'goods_name' => 'Test',
        ]);
    }

    /** @test */
    public function guestCantCreateAStock()
    {
        $this->json('POST', route('stocks.store'), [
            'goods_name' => 'Goods',
            'quantity' => rand(1, 10),
            'base_price' => 50,
            'selling_price' => 40,
            'status' => 1,
        ]);

        $this->assertDatabaseMissing('stock', [
            'goods_name' => 'Goods',
        ]);
    }

    /** @test */
    public function guestCantUpdateAStock()
    {
        $stock = factory(Stock::class)->create(['goods_name' => 'Test']);

        $this->json('PATCH', route('stocks.update', $stock->id), [
            'goods_name' => 'Goods Name',
            'quantity' => 1,
            'base_price' => 50,
            'selling_price' => 40,
            'status' => 1,
        ]);

        $this->assertDatabaseHas('stock', [
            'goods_name' => 'Test',
        ]);
    }

    /** @test */
    public function guestCantDestroyAStock()
    {
        $stock = factory(Stock::class)->create(['goods_name' => 'Test']);

        $this->assertDatabaseHas('stock', [
            'goods_name' => 'Test',
        ]);

        $this->json('DELETE', route('stocks.destroy', $stock->id));

        $this->assertDatabaseHas('stock', [
            'goods_name' => 'Test',
        ]);
    }
}
