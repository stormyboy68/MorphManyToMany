<?php

namespace ASB\MorphMTM\Exceptions\Builder;

use ASB\MorphMTM\Exceptions\Enum\BasePathMTM;
use ASB\MorphMTM\Exceptions\Utility\File;

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
