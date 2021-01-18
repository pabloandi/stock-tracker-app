<?php

namespace App\Clients;

class StockStatus
{
    public $available, $price;

    public function __construct($available, $price) {
        $this->available = $available;
        $this->price = $price;
    }
}
