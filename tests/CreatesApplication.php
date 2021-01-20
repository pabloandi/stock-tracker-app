<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Facades\App\Clients\ClientFactory;
use App\Clients\StockStatus;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function mockingClientRequest($available = true, $price = 29900)
    {
        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available, $price));
    }
}
