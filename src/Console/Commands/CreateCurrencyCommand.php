<?php

namespace Sambu\Ecommerce\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Sambu\Ecommerce\Models\Geo\Currency;

class CreateCurrencyCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ecommerce:create-currency';

    /**
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->ask('Currency name');
        $code = $this->ask('Currency code (ISO 4217)');
        $symbol = $this->ask('Currency symbol');
        $countryTable = app('ecommerce')::getCountryTable();

        $validator = Validator::make(
            ['name' => $name, 'code' => $code, 'symbol' => $symbol],
            [
                'name' => ['required', 'max:255', 'min:1', "unique:$countryTable"],
                'code' => ['required', 'size:3', "unique:$countryTable"],
                'symbol' => ['required', 'max:7', 'min:1'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) $this->error($error);
        } else {
            Currency::create(['name' => $name, 'code' => $code, 'symbol' => $symbol]);
            $this->info('The command was successful!');
        }
    }
}
