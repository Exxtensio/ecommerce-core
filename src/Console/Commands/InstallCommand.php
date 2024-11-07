<?php

namespace Sambu\Ecommerce\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ecommerce:install';

    /**
     * @var string
     */
    protected $description = 'Command description';

    public function handle(): void
    {
        $bar = $this->output->createProgressBar(3);
        $bar->start();

        $this->callSilently('migrate');
        $bar->advance();

        $this->callSilently('db:seed', ['--class' => \Sambu\Ecommerce\Database\Seeders\DefaultSeeder::class]);
        $bar->advance();

        $artisan = \Sambu\Ecommerce\Models\Artisan::where('name', config('ecommerce.artisan.name'))
            ->where('email', config('ecommerce.artisan.email'))
            ->first();

        PersonalAccessToken::where('name', 'artisan')->delete();

        $token = $artisan->createToken('artisan');

        $bar->advance();

        $this->newLine();
        $this->warn("\nCongratulations!");
        $this->info("Sambu eCommerce installation completed");

        $table = new Table($this->output);
        $table->setHeaders(['Key', 'Value']);
        $separator = new TableSeparator;
        $table->setRows([
            ['Name', config('ecommerce.artisan.name')],
            $separator,
            ['Email', config('ecommerce.artisan.email')],
            $separator,
            ['Password', config('ecommerce.artisan.password')],
            $separator,
            ['Bearer Token', $token->plainTextToken]
        ]);
        $table->render();
        $this->newLine();
        $this->error('Be careful!!!');
        $this->info('When reusing a command `php artisan ecommerce:install`');
        $this->info('This will create a new `Bearer Token` and delete the old one');
        $this->info('Don\'t forget to save `Bearer Token`. You\'ll only see it once');
        $this->newLine();
    }
}
