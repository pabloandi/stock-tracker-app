<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_checks_stocks_for_products_at_retailers()
    {
        $product = Product::create([
            'name'  =>  'Playstation 4',
        ]);

        $retailer = Retailer::create([
            'name'  =>  'Target'
        ]);

        $this->assertFalse($product->inStock());
        // $retailer->hasStock($product);

    }
}
