<?php

namespace ASB\MorphMTM\Builder\operation;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
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
}
