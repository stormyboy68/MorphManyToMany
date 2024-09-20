<?php

namespace ASB\MorphMTM\Builder;

use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\Utility\File;

class RouteBuilder
{
    public static function handle($values)
    {
        extract($values);
        $data = [
            'model' => $model,
            'plural' => $plural,
            'relationName' => $relationName,
            'fileName' => sprintf(BasePathMTM::Route(), $model) . 'routes.php',
            'txt' => include BasePathMTM::RouteTemplate,
        ];
        return File::handle($data);
    }
}
