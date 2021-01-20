<?php

namespace App\Clients;

class StockStatus
{
    public $available, $price;

    public function __construct(bool $available, int $price)
    {
        $this->available = $available;
        $this->price = $price;
    }
}
