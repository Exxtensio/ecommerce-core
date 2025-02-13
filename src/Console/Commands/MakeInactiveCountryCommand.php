<?php

namespace Exxtensio\EcommerceCore\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Exxtensio\EcommerceCore\Models\Geo\Country;

class MakeInactiveCountryCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ecommerce:make-inactive-country';

    /**
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $country = Country::findByName($this->choiceCountry());
        $country->active = false;
        $country->save();
        $this->info('The command was successful!');
    }

    protected function choiceCountry(): array|string
    {
        return $this->choice('Which country needs to be made active?', Country::orderBy('name')->pluck('name')->toArray());
    }
}
