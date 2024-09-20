<?php

namespace ASB\MorphMTM\Providers;

use ASB\MorphMTM\Console\Commands\build;
use ASB\MorphMTM\Console\Commands\Remove;
use Illuminate\Support\ServiceProvider;


class MTMServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                build::class,
                Remove::class,
            ]);
        }
    }
    public function register(): void
    {
        if (file_exists(config_path('mtm.php')) && $providers=config('mtm.providers')) {
            foreach ($providers as $provider) {
                $this->app->register($provider);
            }
        }
    }
}
