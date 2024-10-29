<?php

namespace Sambu\Ecommerce\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Sambu\Ecommerce\Models\Geo\Country;
use Sambu\Ecommerce\Models\Geo\Currency;

class MakeActiveCountryCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ecommerce:make-active-country';

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
        $country->active = true;
        if($country->currency) {
            if ($this->confirm("The country's currency is {$country->currency->name}. Do you want to change it?")) {
                $country->currency()->associate(Currency::findByName($this->choiceCurrency()));
            }
            $country->save();
        } else {
            $country->currency()
                ->associate(Currency::findByName($this->choiceCurrency()))
                ->save();
        }
        $this->info('The command was successful!');
    }

    protected function choiceCountry(): array|string
    {
        return $this->choice('Which country needs to be made active?', Country::orderBy('name')->pluck('name')->toArray());
    }

    protected function choiceCurrency(): array|string
    {
        return $this->choice('What currency do you want to set?', Currency::orderBy('name')->pluck('name')->toArray());
    }
}
