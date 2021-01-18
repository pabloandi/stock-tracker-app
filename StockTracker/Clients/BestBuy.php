<?php

namespace StockTracker\Clients;

use App\Models\Stock;

class BestBuy implements Tracker {
    public function testApiAvailability()
    {

    }

    public function checkStockAvailability(Stock $stock)
    {
        # code...
    }
}
