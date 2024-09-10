<?php

return
'<?php'.
"
namespace Rack\\MTM\\$model\\Providers;

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
            return new \Rack\\MTM\\$model\\App\\Commands\\" . $model . "Command();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach (\ASB\MorphToMany\Utility\AsbClassMap::getClassMap() as \$name => \$class) {
            \\Rack\\MTM\\$model\\App\\Models\\$model::resolveRelationUsing(\$name, function (\\Rack\\MTM\\$model\\App\\Models\\$model \$model)use(\$class) {
                return \$model->morphedByMany(\$class, '".$relationName."', '".\Illuminate\Support\Str::plural($relationName)."')->without(['".strtolower($model)."']);
            });
        }
    }
}
";
