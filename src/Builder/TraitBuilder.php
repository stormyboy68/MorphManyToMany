<?php

namespace ASB\MorphMTM\Exceptions\Builder;

use ASB\MorphMTM\Exceptions\Enum\BasePathMTM;
use ASB\MorphMTM\Exceptions\utility\File;
use ASB\MorphMTM\Exceptions\Utility\Json;

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
        Json::add(['Rack\Morph\MTM\\'.$model.'\Traits\Has'.$model]);
        return File::handle($data);
    }
}
