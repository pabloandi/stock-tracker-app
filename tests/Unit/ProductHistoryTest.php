<?php

namespace Tests\Unit;

use Facades\App\Clients\ClientFactory;
use App\Clients\StockStatus;
use App\Models\Stock;
use App\Models\History;
use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_history_each_time_stock_is_tracked() {
        // given a stock at a retailer
        $this->seed(RetailerWithProductSeeder::class);

        $this->mockingClientRequest($available = true, $price = 99);

        $product = tap(Product::first(), function($product){
            $this->assertCount(0, $product->history);

            // if i track that stock
            $product->track();

            // a new history entry should be created
            $this->assertCount(1, $product->refresh()->history);

        });

        $history = $product->history->first();

        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->id, $history->product_id);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }
}
