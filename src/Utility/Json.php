<?php

namespace ASB\MorphMTM\Utility;

class Json
{
    const FILE_LIST_MODlE = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'listModels.json';
    public static function get(?string $path = null): array
    {
        $path ??= self::FILE_LIST_MODlE;
        if (!file_exists($path)) {
            return [];
        }
        $Json = file_get_contents($path);
        return json_decode($Json, true) ?? [];
    }

    public static function put(array $data, ?string $path = null): bool
    {
        $path ??= self::FILE_LIST_MODlE;
        $Json = json_encode($data);
        return file_put_contents($path, $Json);
    }

    public static function add(array $data, ?string $path = null): bool
    {
        $path ??= self::FILE_LIST_MODlE;
        $temp = self::get($path);
        $temp = array_unique(array_merge($temp, $data));
        $Json = json_encode($temp);
        return file_put_contents($path, $Json);
    }

    public static function remove(array $del, ?string $path = null): bool
    {
        $path ??= self::FILE_LIST_MODlE;
        $temp = self::get($path);

        if (!array_intersect($del, $temp)) {
            return false;
        }
        array_walk($del, function ($v) use (&$temp) {
            unset($temp[array_search($v, $temp)]);
        });
        $Json = json_encode($temp);
        return file_put_contents($path, $Json);
    }
}
