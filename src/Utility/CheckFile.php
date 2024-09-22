<?php

namespace ASB\MorphMTM\Utility;

use ASB\MorphMTM\Enum\BasePathMTM;

class CheckFile
{
    public static function checkFileMigrationExists($data, $pivot = false): ?string
    {
        $res = scandir(sprintf(BasePathMTM::Migration(), $data['model']));
        foreach ($res as $val) {
            if ($val == '.' || $val == '..') continue;
            if (!$pivot && isset($data['plural']) && str_contains($val, $data['plural'])) return $val;
            if ($pivot && isset($data['pluralRelation']) && str_contains($val, $data['pluralRelation'])) return $val;
        }
        return null;
    }

    public static function checkFileMigration($data, $pivot = false): bool
    {
        $res = scandir(sprintf(BasePathMTM::Migration(), $data['model']));
        foreach ($res as $val) {
            if ($val == '.' || $val == '..') continue;
            if (!$pivot && isset($data['plural']) && str_contains($val, $data['plural'])) return true;
            if ($pivot && isset($data['pluralRelation']) && str_contains($val, $data['pluralRelation'])) return true;
        }
        return false;
    }

    public static function checkFileProvider($data)
    {
        if (str_contains($data['fileName'], 'Providers')) {
            return 1;
        }
    }

    public static function checkFilesModelExists($data): bool
    {
        return file_exists(sprintf(BasePathMTM::Model(), $data['model']) . $data['model'] . '.php')
            && file_exists(sprintf(BasePathMTM::Commands(), $data['model']) . $data['model'] . "Command.php")
            && file_exists(sprintf(BasePathMTM::Controller(), $data['model']) . $data['model'] . "Controller.php")
            && file_exists(sprintf(BasePathMTM::Facade(), $data['model']) . BasePathMTM()::Prefix . $data['model'] . ".php")
            && file_exists(sprintf(BasePathMTM::Request(), $data['model']) . $data['model'] . 'Request.php')
            && file_exists(sprintf(BasePathMTM::Trait(), $data['model']) . 'Has' . $data['model'] . '.php')
            && file_exists(sprintf(BasePathMTM::Route(), $data['model']) . 'routes.php')
            && file_exists(sprintf(BasePathMTM::Provider(), $data['model']) . $data['model'] . 'ServiceProvider.php')
            && self::checkFileMigration($data)
            && self::checkFileMigration($data, true);
    }

    public static function checkModuleExists($data): bool
    {
        return file_exists(sprintf(BasePathMTM::ModuleDirectory(), $data['module']));
    }
}
