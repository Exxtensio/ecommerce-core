<?php

namespace Sambu\Ecommerce;

use Illuminate\Support\Facades\Facade;
use Sambu\Ecommerce\Services\ExchangeRateService;
use Exception;

class Ecommerce extends Facade
{
    use Traits\HasTypeCorrect, Traits\HasArtisanUser, Traits\HasTables, Traits\HasRelationColumns;

    public function __invoke($request, $next) {}

    protected static function getFacadeAccessor(): string
    {
        return 'ecommerce';
    }

    /**
     * @throws Exception
     */
    public static function updateCurrencyRate(): void
    {
        $service = new ExchangeRateService();
        $service->update();
    }
}
