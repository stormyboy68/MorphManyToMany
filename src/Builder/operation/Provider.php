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

        $content   = file_get_contents($path);
        $providers = self::extractProviders($content);

        $providers = array_values(array_filter(
            $providers,
            fn($p) => $provider !== $p
        ));

        return self::replaceProvidersBlock($path, $content, $providers);
    }

    public static function addProviderToConfigFile(string $provider, ?string $path = null): bool
    {
        $path ??= app()->configPath('mtm.php');

        if (!file_exists($path)) {
            return false;
        }

        $content   = file_get_contents($path);
        $providers = self::extractProviders($content);

        $providers[] = $provider;
        $providers   = array_values(array_unique($providers));

        return self::replaceProvidersBlock($path, $content, $providers);
    }

    protected static function extractProviders(string $content): array
    {
        if (!preg_match("/'providers'\s*=>\s*\[(.*?)\]/s", $content, $m)) {
            return [];
        }
        preg_match_all('/([A-Za-z0-9_\\\\]+)::class/', $m[1], $matches);

        return $matches[1] ?? [];
    }

    protected static function replaceProvidersBlock(string $path, string $content, array $providers): bool
    {
        sort($providers);

        $block = "    'providers' => [" . PHP_EOL .
            collect($providers)
                ->unique()
                ->values()
                ->map(fn($p) => '        ' . $p . '::class,')
                ->implode(PHP_EOL) . PHP_EOL .
            "    ],";

        $newContent = preg_replace(
            "/    'providers'\s*=>\s*\[.*?\],/s",
            $block,
            $content,
            1
        );

        if ($newContent === $content) {
            return true;
        }
        if ($newContent === null ) {
            return false;
        }

        file_put_contents($path, $newContent);
        return true;
    }
}
