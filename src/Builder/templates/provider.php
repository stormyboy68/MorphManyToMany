<?php

return
'<?php'.
"
namespace Rack\\Morph\\MTM\\$model\\Providers;

use Illuminate\Support\ServiceProvider;

class ".$model."ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        \$this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        \$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        \$this->app->singleton('MTM" . $model. "',function (){
            return new \Rack\\Morph\\MTM\\$model\\App\\Commands\\" . $model . "Command();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach (\ASB\MorphMTM\Utility\Map::getClassMap() as \$name => \$class) {
            \\Rack\\Morph\\MTM\\$model\\App\\Models\\$model::resolveRelationUsing(\$name, function (\\Rack\\Morph\\MTM\\$model\\App\\Models\\$model \$model)use(\$class) {
                return \$model->morphedByMany(\$class, '".$relationName."', '".\Illuminate\Support\Str::plural($relationName)."')->without(['".strtolower($model)."']);
            });
        }
    }
}
";
