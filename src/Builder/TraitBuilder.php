<?php

namespace ASB\MorphToMany\Builder;

use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\utility\File;

class TraitBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'relationName' => $relationName,
            'fileName' => sprintf(BasePathMTM::Trait, $model) . 'Has' . $model . '.php',
            'txt' => include BasePathMTM::TraitTemplate,
        ];
        return File::handle($data);
    }
}
