<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\utility\CheckFile;
use ASB\MorphMTM\utility\File;


class MigrationBuilder
{
    public static function handle($values)
    {
        return self::makeBasic($values);
    }

    /**
     * @param $values
     * @return bool|resource
     */
    public static function makeBasic($values)
    {
        extract($values);
        $fileName = self::fileNameGenerate($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'relationName' => $relationName,
            'fileName' => sprintf(BasePathMTM::Migration(), $model) . $fileName,
            'txt' => include BasePathMTM::MigrationBasicTemplate,
        ];
        return File::handle($data);
    }

    /**
     * @param array $values
     * @param bool $pivot
     * @param int $addTime per seconds
     * @return string
     */
    public static function fileNameGenerate(array $values, bool $pivot = false, int $addTime = 0): string
    {
        if ($pivot) {
            return CheckFile::checkFileMigrationExists($values, $pivot) ??
                date('Y_m_d_His', strtotime(now()) + $addTime) . '_create_' . $values['pluralRelation'] . '_table.php';
        }
        return CheckFile::checkFileMigrationExists($values) ??
            date('Y_m_d_His', strtotime(now()) + $addTime) . '_create_' . $values['plural'] . '_table.php';
    }
}
