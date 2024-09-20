<?php

namespace ASB\MorphMTM\Builder\operation;

use Illuminate\Support\Collection;

class Provider
{

    public static function removeProviderToConfigFile(string $provider, ?string $path = null): bool
    {
        $path ??= app()->configPath('mtm.php');

        if (!file_exists($path)) {
            return false;
        }
        $config = collect(require $path);
        $providers = $config->get('providers');
        $providers ="    'providers' => [\r\n".
            collect($providers)
            ->reject(fn($V, $K) => $provider === $V)
            ->unique()
            ->sort()
            ->values()
            ->map(fn($p) => '        ' . $p . '::class,')
            ->implode(PHP_EOL).PHP_EOL.
            "    ],";
        $temp = self::getContinuedContent($config,'providers');
$content = '<?php'."

return [
$providers".($temp?$temp.PHP_EOL:'')."
];";
        file_put_contents($path, $content . PHP_EOL);
        return true;
    }

    public static function addProviderToConfigFile(string $provider, ?string $path = null): bool
    {
        $path ??= app()->configPath('mtm.php');

        if (!file_exists($path)) {
            return false;
        }
        $config = collect(require $path);
        $providers = $config->get('providers');
        $providers ="    'providers' => [\r\n".
            collect($providers)
            ->merge([$provider])
            ->unique()
            ->sort()
            ->values()
            ->map(fn($p) => '        ' . $p . '::class,')
            ->implode(PHP_EOL).PHP_EOL.
            "    ],";
        $temp = self::getContinuedContent($config,'providers');
        $content = '<?php'."

return [
$providers".($temp?$temp.PHP_EOL:'')."
];";
        file_put_contents($path, $content . PHP_EOL);
        return true;
    }

    /**
     * @param Collection $config
     * @param $except
     * @return string
     */
    public static function getContinuedContent(Collection $config,$except):string
    {
        return $config->except($except)->map(function ($item, $key) {
            return "    '$key' => [\r\n" .
                collect($item)
                    ->unique()
                    ->sort()
                    ->values()
                    ->map(fn($p) => '        ' . $p . '::class,')
                    ->implode(PHP_EOL) . PHP_EOL .
                "    ],";
        })->implode(PHP_EOL);
    }
}
