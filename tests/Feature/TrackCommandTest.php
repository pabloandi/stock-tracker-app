<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Support\Facades\Notification;

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


}
