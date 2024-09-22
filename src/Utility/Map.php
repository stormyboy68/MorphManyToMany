<?php

namespace ASB\MorphMTM\Utility;

class Map
{
    const FILE_CLASSMAP = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'classMap.json';

    public static function getClassMap()
    {
        if (!file_exists(self::FILE_CLASSMAP)) {
            return [];
        }
        $classMapJson = file_get_contents(self::FILE_CLASSMAP);
        return json_decode($classMapJson, true) ?? [];
    }

    public static function putClassMap(array $classes): false|int
    {
        $classMap = json_encode($classes);
        return file_put_contents(self::FILE_CLASSMAP, $classMap);
    }

    public static function getClassName(string $class)
    {
        return strtolower(substr($class, strrpos($class, '\\', -1) + 1));
    }

    public static function handler($class): void
    {
        if (!file_exists(self::FILE_CLASSMAP)) {
            static::putClassMap([static::getClassName($class) => $class]);
            return;
        }
        $classes = Map::getClassMap();
        in_array($class, $classes) ?: $classes[static::getClassName($class)] = $class;
        static::putClassMap($classes);
    }
}
