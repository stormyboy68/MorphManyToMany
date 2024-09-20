<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\utility\File;

class TraitBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'relationName' => $relationName,
            'fileName' => sprintf(BasePathMTM::Trait(), $model) . 'Has' . $model . '.php',
            'txt' => include BasePathMTM::TraitTemplate,
        ];
        return File::handle($data);
    }
}
