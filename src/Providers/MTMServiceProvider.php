<?php

namespace ASB\MorphMTM\Providers;

use ASB\MorphMTM\Console\Commands\build;
use ASB\MorphMTM\Console\Commands\Remove;
use ASB\MorphMTM\Utility\Map;
use ASB\MorphMTM\Utility\Json;
use Illuminate\Support\Facades\Event;
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
        $this->setMAP();
        $this->publishes([
            __DIR__.'/../config/mtm.php' => config_path('mtm.php'),
        ],'morph-mtm-config');
    }
    public function register(): void
    {
        if (file_exists(config_path('mtm.php')) && $providers=config('mtm.providers')) {
            foreach ($providers as $provider) {
                if(file_exists(base_path().$provider.'php')) {
                    $this->app->register($provider);
                }
            }
        }
    }

    protected function setMAP(): void
    {
        Event::listen('eloquent.booting: *', function ($eventName, $models) {
            $model = $models[0];
            if (array_intersect(Json::get(), class_uses_recursive($model))) {
                if (!in_array(get_class($model), Map::getClassMap())) {
                    Map::handler(get_class($model));
                }
            }
        });
    }
}
