<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Clients\StockStatus;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;


/**
 * @group api
 */
class BestBuyTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function it_tracks_a_product() {

        $this->seed(RetailerWithProductSeeder::class);

        $stock = tap(Stock::first())->update([
            'sku'   =>  '6364255', // Nintendo Switch sku
            'url'   =>  'https://www.bestbuy.com/site/nintendo-switch-32gb-console-neon-red-neon-blue-joy-con/6364255.p?skuId=6364255'
        ]);

        Http::fake(function(){
            return ['onlineAvailability' => true, 'salePrice' => 30900];
        });

        try {
            (new BestBuy)->checkAvailability($stock);
        } catch (\Exception $th) {
            $this->fail('Failed to track the bestbuy api properly. ' . $th->getMessage());
        }

        $this->assertTrue(true);

    }

    /** @test */
    public function it_creates_the_proper_stock_status_response() {
        Http::fake(function() {
            return ['salePrice' => 299.99, 'onlineAvailability' => true];
        });

        $stockStatus = (new BestBuy)->checkAvailability(new Stock);

        $this->assertEquals(29999, $stockStatus->price);
        $this->assertTrue($stockStatus->available);

    }

}
