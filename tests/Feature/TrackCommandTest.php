<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Support\Facades\Http;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());

        Http::fake(function(){
            return [
                'available' => true,
                'price'     => 29900
            ];
        });

        $this->artisan('track')
            ->expectsOutput('All done!');

        // then
        // the stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());

    }
}
