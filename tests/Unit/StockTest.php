<?php

namespace Tests\Unit;

use App\Clients\Client;
use Facades\App\Clients\ClientFactory;
use App\Clients\StockStatus;
use App\Exceptions\RetailerClientException;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_an_exception_if_the_client_not_found_when_tracking() {

        //given I have a retailer with stock
        $this->seed(RetailerWithProductSeeder::class);

        // and if the retailer doesn't have a client class
        Retailer::first()->update(['name' => 'Foo Retailer']);

        // then an exception should be thrown
        $this->expectException(RetailerClientException::class);

        // if I track that stock
        Stock::first()->track();

    }

    /** @test */
    public function it_updates_local_stock_status_after_being_tracked() {
        //given I have a retailer with stock
        $this->seed(RetailerWithProductSeeder::class);

        $this->mockingClientRequest($available = true, $price = 9900);

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900, $stock->price);
    }

}
