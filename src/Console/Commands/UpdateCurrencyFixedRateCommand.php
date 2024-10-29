<?php

namespace Sambu\Ecommerce\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Sambu\Ecommerce\Models\Geo\Currency;

class UpdateCurrencyFixedRateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ecommerce:update-currency-fixed-rate {currency} {fixedRate}';

    /**
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $currency = Currency::findByCode($this->argument('currency'));
        if(!$currency) {
            $this->error('Currency not found');
        } else {
            $validator = Validator::make(
                ['fixedRate' => $this->argument('fixedRate')],
                ['fixedRate' => ['required','decimal:16,4']]
            );
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) $this->error($error);
            } else {
                $currency->update(['fixed_rate' => $this->argument('fixedRate')]);
                $this->info('The command was successful!');
            }
        }
    }
}
