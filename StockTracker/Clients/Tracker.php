<?php

namespace StockTracker\Clients;

use App\Models\Stock;

interface Tracker {
    public function testApiAvailability();

    public function checkStockAvailability(Stock $stock);

}
