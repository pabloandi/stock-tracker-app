<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;

class RetailerWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create([
            'name'  =>  'Playstation 4'
        ]);

        $retailer = Retailer::create([
            'name'  =>  'Best Buy'
        ]);

        $stock = new Stock([
            'price' =>  10000,
            'url'   =>  'http://foo.com',
            'sku'   =>  '12345',
            'in_stock'  =>  false,
        ]);

        $retailer->addStock($product, $stock);
    }
}
