<?php

namespace Sambu\Ecommerce\Console\Commands;

use Illuminate\Console\Command;
use Exception;

class UpdateCurrencyRateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ecommerce:update-currency-rate';

    /**
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        app('ecommerce')->updateCurrencyRate();
    }
}
