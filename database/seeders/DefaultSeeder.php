<?php

namespace Sambu\Ecommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Sambu\Ecommerce\Models;

class DefaultSeeder extends Seeder
{
    public function run(): void
    {
        $this->initCurrencies();
        $this->initCountries();
        $this->initArtisan();
    }

    protected function initCountries(): void
    {
        $countries = File::get(__DIR__ . '/../../countries.json');

        collect(json_decode($countries, true))
            ->each(function ($country) {
                Models\Geo\Country::firstOrCreate(
                    ['code' => $country['code']],
                    [
                        'name' => $country['name'],
                        'code' => $country['code'],
                        'active' => $country['code'] === config('ecommerce.default.country'),
                    ]
                );
            });

        Models\Geo\Country::findByCode(config('ecommerce.default.country'))
            ->currency()
            ->associate(Models\Geo\Currency::findByCode(config('ecommerce.default.currency')))
            ->save();
    }

    protected function initCurrencies(): void
    {
        $currencies = File::get(__DIR__ . '/../../currencies.json');

        collect(json_decode($currencies, true))
            ->each(function ($currency) {
                Models\Geo\Currency::firstOrCreate(
                    ['code' => $currency['code']],
                    [
                        'name' => $currency['name'],
                        'code' => $currency['code'],
                        'symbol' => $currency['symbol'],
                    ]
                );
            });

        Artisan::call('ecommerce:update-currency-rate');
    }

    protected function initArtisan(): void
    {
        Models\Artisan::firstOrCreate(
            ['email' => config('ecommerce.artisan.email')],
            [
                'name' => config('ecommerce.artisan.name'),
                'email' => config('ecommerce.artisan.email'),
                'email_verified_at' => now(),
                'password' => Hash::make(config('ecommerce.artisan.password'))
            ]
        );
    }
}
