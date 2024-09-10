<?php

namespace ASB\MorphToMany\Console\Commands;

use ASB\MorphToMany\Builder\ResolveRelBuilder;
use ASB\MorphToMany\Builder\SingletonBuilder;
use ASB\MorphToMany\utility\File;
use function Laravel\Prompts\search;
use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\utility\CheckFile;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Str;

class Remove extends Command implements PromptsForMissingInput
{
    protected $signature = 'mtm:remove
                            {model : The Name of the Model to be Removed}';

    protected $description = 'Remove a model with its MorphByMany-MorphedByMany relations';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $models = config('mtm.models');
        $current_model = array_filter($models, function ($item, $key) use (&$models) {
            if (strtolower($this->argument('model')) === strtolower($item['model'])) {
                unset($models[$key]);
                return $item;
            }
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($current_model) || count($current_model) > 1) {
            $this->components->error('the Model Can\'t find.');
            die();
        }
        $model = ucfirst(strtolower((current($current_model)['model'])));
        self::removeProviderToBootstrapFile(sprintf(BasePathMTM::SpaceNameServiceProvider, $model, $model));
        self::removeModuleDirectory(sprintf(BasePathMTM::ModuleDirectory, $model));
        $this->removeFromConfig($models);
        $this->components->info(sprintf('%s [%s] removed successfully.', 'Model ', $model));
    }

    /**
     * @param mixed $models
     * @return void
     */
    public function removeFromConfig(mixed $models): void
    {
        $config['fileName'] = config_path('mtm.php');
        $txt = '<?php' . "\n" .
            "return [ \n" .
            "    'models' => [\n";
        foreach ($models as $val) {
            $txt .= "        [\n";
            foreach ($val as $key => $value) {
                $txt .= "            '$key' => '$value',\n";
            }
            $txt .= "        ],\n";
        }
        $txt .= "    ],
];";
        $config['txt'] = $txt;
        File::handle($config);
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'model' => ['Which Model do you want remove?', ''],
        ];
    }

    public static function removeProviderToBootstrapFile(string $provider, ?string $path = null): bool
    {
        $path ??= app()->getBootstrapProvidersPath();

        if (!file_exists($path)) {
            return false;
        }

        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($path, true);
        }

        $providers = collect(require $path)
            ->reject(fn($V, $K) => $provider === $V)
            ->unique()
            ->sort()
            ->values()
            ->map(fn($p) => '    ' . $p . '::class,')
            ->implode(PHP_EOL);

        $content = '<?php

return [
' . $providers . '
];';

        file_put_contents($path, $content . PHP_EOL);

        return true;
    }

    public static function removeModuleDirectory($dir): bool
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (is_dir($dir . DIRECTORY_SEPARATOR . $item) && count(scandir($dir . DIRECTORY_SEPARATOR . $item)) > 2) {
                if (!self::removeModuleDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                    return false;
                }
            }
            if (!self::removeModuleDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
}
