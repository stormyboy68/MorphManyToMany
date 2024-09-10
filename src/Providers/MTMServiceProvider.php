<?php

namespace ASB\MorphToMany\Providers;


use ASB\MorphToMany\Console\Commands\build;
use ASB\MorphToMany\Console\Commands\Remove;
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
        $this->publishes([
            __DIR__.'/../config/mtm.php' => config_path('mtm.php'),

        ],'asb/mtm');
    }
    public function register(): void
    {
        //
    }
}
