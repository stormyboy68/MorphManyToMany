<?php

namespace ASB\MorphMTM\Utility;

use ASB\MorphMTM\Enum\BasePathMTM;

class File
{
    public static function handle($data)
    {
        $myFile = fopen($data['fileName'], "w");
        if (!$myFile) {
            return $myFile;
        }
        fwrite($myFile, $data['txt']);
        return fclose($myFile);
    }

    public static function initializeDirectories($data): void
    {
        $paths = [
            'Rack' => BasePathMTM::Rack(),
            'Morph' => BasePathMTM::Morph(),
            'Package' => BasePathMTM::Package(),
            'ModuleDirectory' => sprintf(BasePathMTM::ModuleDirectory(), $data['model']),

            'App' => sprintf(BasePathMTM::App(), $data['model']),
            'Commands' => sprintf(BasePathMTM::Commands(), $data['model']),
            'Models' => sprintf(BasePathMTM::Model(), $data['model']),

            'Http' => sprintf(BasePathMTM::Http(), $data['model']),
            'Controller' => sprintf(BasePathMTM::Controller(), $data['model']),
            'Request' => sprintf(BasePathMTM::Request(), $data['model']),


            'database' => sprintf(BasePathMTM::Database(), $data['model']),
            'migration' => sprintf(BasePathMTM::Migration(), $data['model']),

            'facade' => sprintf(BasePathMTM::Facade(), $data['model']),
            'trait' => sprintf(BasePathMTM::Trait(), $data['model']),
            'routes' => sprintf(BasePathMTM::Route(), $data['model']),
            'provider' => sprintf(BasePathMTM::Provider(), $data['model']),

        ];
        foreach ($paths as $item) {
            if (!file_exists($item)) {
                mkdir($item);
            }
        }
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
