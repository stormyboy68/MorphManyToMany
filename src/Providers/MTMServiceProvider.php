<?php

namespace ASB\MorphMTM\Providers;


use ASB\MorphMTM\Console\Commands\build;
use ASB\MorphMTM\Console\Commands\Remove;
use Illuminate\Support\ServiceProvider;
use Rack\MTM\Status\Providers\RiakServiceProvider;


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
        //
    }
}
