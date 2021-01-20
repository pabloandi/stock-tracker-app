<?php

namespace Tests\Feature;

use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ImportantStockUpdate;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->seed(RetailerWithProductSeeder::class);
    }

    /** @test */
    public function it_tracks_product_stock()
    {

        $this->assertFalse(Product::first()->inStock());

        $this->mockingClientRequest(true, 29900);

        $this->artisan('track')
            ->expectsOutput('All done!');

        // then
        // the stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());

    }

    /** @test */
    public function it_does_not_notifies_the_user_when_the_stock_remains_available() {

        $this->mockingClientRequest(false);

        // when i track that product
        $this->artisan('track');

        // if the stock changes in a notable way after being tracked
        // then the user should be notified
        Notification::assertNothingSent();
    }

    /** @test */
    public function it_notifies_the_user_when_the_stock_is_now_available() {


        $this->mockingClientRequest();

        // when i track that product
        $this->artisan('track');

        // if the stock changes in a notable way after being tracked
        // then the user should be notified
        Notification::assertSentTo(User::first(), ImportantStockUpdate::class);
    }
}
