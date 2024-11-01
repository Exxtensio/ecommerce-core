<?php

namespace Sambu\Ecommerce\Providers\Includes;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Sambu\Ecommerce\Console;

class ConsoleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\Test::class,
                Console\Commands\InstallCommand::class,

                Console\Commands\CreateCurrencyCommand::class,
                Console\Commands\UpdateCurrencyRateCommand::class,
                Console\Commands\UpdateCurrencyFixedRateCommand::class,

                Console\Commands\CreateCountryCommand::class,

                Console\Commands\MakeActiveCountryCommand::class,
                Console\Commands\MakeInactiveCountryCommand::class,
            ]);
        }

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            if($this->app->environment('production')) {

                if(!empty(config('ecommerce.exchangerateApiKey'))) {
                    if(config('ecommerce.rateUpdateFrequency') === 'daily') {
                        $schedule->command('ecommerce:update-currency-rates')->daily();
                    } else if (config('ecommerce.rateUpdateFrequency') === 'weekly') {
                        $schedule->command('ecommerce:update-currency-rates')->weekly();
                    }
                }
            }
        });
    }

    public function register(): void {}
}
