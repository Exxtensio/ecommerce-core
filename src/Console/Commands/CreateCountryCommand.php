<?php

namespace Sambu\Ecommerce\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Sambu\Ecommerce\Models\Geo\Country;

class CreateCountryCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ecommerce:create-country';

    /**
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $name = $this->ask('Country name');
        $code = $this->ask('Country code (ISO 3166-1 alpha-2)');

        $validator = Validator::make(
            ['name' => $name, 'code' => $code],
            [
                'name' => ['required','max:255','min:1','unique:countries'],
                'code' => ['required','size:2','unique:countries']
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) $this->error($error);
        } else {
            Country::create(['name' => $name, 'code' => $code]);
            $this->info('The command was successful!');
        }
    }
}
